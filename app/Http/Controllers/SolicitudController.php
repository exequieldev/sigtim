<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Empleado;
use App\Models\Actividad;
use App\Models\TipoSolicitud;
use App\Models\Equipo;
use App\Models\EmpleadoEquipo;
use App\Models\Programa;
use App\Models\Componente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Add this import

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $solicitudes = Solicitud::with(['empleado', 'actividades', 'tipoSolicitud'])
            ->when($search, function($query, $search) {
                return $query->whereHas('empleado', function($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('apellido', 'like', "%{$search}%");
                })->orWhereHas('tipoSolicitud', function($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('solicitudes.index', compact('solicitudes', 'search'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        $actividades = Actividad::all();
        $tipoSolicitudes = TipoSolicitud::all();
        return view('solicitudes.create', compact('empleados', 'actividades', 'tipoSolicitudes'));
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Crear la solicitud con fecha actual y estado pendiente
                $solicitud = Solicitud::create([
                    'fecha_inicio' => now()->format('Y-m-d'),
                    'estado' => 'pendiente',
                    'empleado_id' => $request->empleado_id,
                    'tipo_solicitud_id' => $request->tipo_solicitud_id
                ]);
                
                // Sincronizar actividades si existen
                if ($request->has('actividades')) {
                    $actividadIds = array_map(function($actividad) {
                        return $actividad['actividad_id'];
                    }, $request->actividades);
                    
                    $solicitud->actividades()->sync($actividadIds);
                }

                // Si es una solicitud de adquisición, buscar equipo compatible
                $tipoSolicitud = TipoSolicitud::find($request->tipo_solicitud_id);
                if ($tipoSolicitud && stripos($tipoSolicitud->nombre, 'adquisición') !== false) {
                    $this->asignarEquipoCompatible($solicitud);
                }
            });
            
            return redirect()->route('solicitudes.index')
                ->with('success', 'Solicitud creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la solicitud: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Solicitud $solicitud)
    {
        $solicitud->load(['empleado', 'actividades', 'tipoSolicitud']);
        return view('solicitudes.show', compact('solicitud'));
    }

    public function edit(Solicitud $solicitud)
    {
        $empleados = Empleado::all();
        $actividades = Actividad::all();
        $tipoSolicitudes = TipoSolicitud::all();
        $solicitud->load('actividades');
        return view('solicitudes.edit', compact('solicitud', 'empleados', 'actividades', 'tipoSolicitudes'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        try {
            DB::transaction(function () use ($request, $solicitud) {
                // Actualizar la solicitud
                $solicitud->update([
                    'empleado_id' => $request->empleado_id,
                    'tipo_solicitud_id' => $request->tipo_solicitud_id
                ]);
                
                // Sincronizar actividades
                if ($request->has('actividades')) {
                    $actividadIds = collect($request->actividades)->pluck('actividad_id')->toArray();
                    $solicitud->actividades()->sync($actividadIds);
                } else {
                    $solicitud->actividades()->detach();
                }
            });
            
            return redirect()->route('solicitudes.index')
                ->with('success', 'Solicitud actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la solicitud: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Solicitud $solicitud)
    {
        try {
            $solicitud->delete();
            return redirect()->route('solicitudes.index')
                ->with('success', 'Solicitud eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Asigna un equipo compatible basado en los componentes requeridos por las actividades
     */
    private function asignarEquipoCompatible(Solicitud $solicitud)
    {
        // Obtener todas las actividades de la solicitud con sus programas y requisitos
        $actividades = $solicitud->actividades()->with(['programas.requisitos'])->get();
        
        if ($actividades->isEmpty()) {
            return;
        }

        // Obtener todos los componentes requeridos por los programas de las actividades
        $componentesRequeridos = collect();
        
        foreach ($actividades as $actividad) {
            foreach ($actividad->programas as $programa) {
                if ($programa->requisitos) {
                    $componentesRequeridos = $componentesRequeridos->merge($programa->requisitos);
                }
            }
        }
        
        if ($componentesRequeridos->isEmpty()) {
            return;
        }

        // Agrupar componentes requeridos por tipo
        $componentesPorTipo = $componentesRequeridos->groupBy('tipo_componente_id');
        
        // Buscar equipos dados de baja que tengan componentes compatibles
        $equiposDisponibles = Equipo::where('estado', 'Baja')
            ->with(['componentes' => function($query) use ($componentesPorTipo) {
                $query->whereIn('tipo_componente_id', $componentesPorTipo->keys());
            }])
            ->get();
        
        if ($equiposDisponibles->isEmpty()) {
            return;
        }

        // Evaluar cada equipo para encontrar el más compatible
        $mejorEquipo = null;
        $maxCompatibilidad = 0;
        
        foreach ($equiposDisponibles as $equipo) {
            $puntajeCompatibilidad = $this->calcularCompatibilidad($equipo, $componentesPorTipo);
            
            if ($puntajeCompatibilidad > $maxCompatibilidad) {
                $maxCompatibilidad = $puntajeCompatibilidad;
                $mejorEquipo = $equipo;
            }
        }
        
        // Si se encontró un equipo compatible, asignarlo al empleado
        if ($mejorEquipo && $maxCompatibilidad > 0) {
            $this->asignarEquipoAEmpleado($mejorEquipo, $solicitud->empleado_id, $solicitud->id);
            
            // Actualizar el estado del equipo
            $mejorEquipo->update(['estado' => 'Activo']);
            
            // Registrar en la solicitud el equipo asignado (si tienes este campo)
            if (Schema::hasColumn('solicitudes', 'equipo_asignado_id')) {
                $solicitud->update(['equipo_asignado_id' => $mejorEquipo->id]);
            }
        }
    }

    /**
     * Calcula el puntaje de compatibilidad entre un equipo y los componentes requeridos
     */
    private function calcularCompatibilidad(Equipo $equipo, $componentesPorTipo)
    {
        $puntaje = 0;
        
        foreach ($componentesPorTipo as $tipoComponenteId => $requisitos) {
            $componentesDelTipo = $equipo->componentes->where('tipo_componente_id', $tipoComponenteId);
            
            if ($componentesDelTipo->count() > 0) {
                // Puntaje base por tener el tipo de componente
                $puntaje += 10;
                
                // Evaluar especificaciones para cada componente del tipo
                foreach ($componentesDelTipo as $componente) {
                    foreach ($requisitos as $requisito) {
                        if ($this->cumpleRequisitos($componente, $requisito)) {
                            $puntaje += 5;
                        }
                    }
                }
            }
        }
        
        return $puntaje;
    }

    /**
     * Verifica si un componente cumple con los requisitos del programa
     */
    private function cumpleRequisitos(Componente $componente, $requisito)
    {
        // Verificar compatibilidad básica
        // Puedes mejorar esta lógica según tus necesidades específicas
        
        $compatibilidad = false;
        
        // Verificar fabricante
        if ($componente->fabricante_id == $requisito->fabricante_id) {
            $compatibilidad = true;
        }
        
        // Verificar modelo (búsqueda parcial)
        if ($requisito->modelo_minimo && stripos($componente->modelo, $requisito->modelo_minimo) !== false) {
            $compatibilidad = true;
        }
        
        // Verificar especificaciones (búsqueda básica)
        if ($requisito->especificaciones_minimas && 
            $componente->especificaciones && 
            stripos($componente->especificaciones, $requisito->especificaciones_minimas) !== false) {
            $compatibilidad = true;
        }
        
        return $compatibilidad;
    }

    /**
     * Asigna el equipo al empleado usando el modelo EmpleadoEquipo
     */
    private function asignarEquipoAEmpleado(Equipo $equipo, $empleadoId, $solicitudId)
    {
        // Usar el modelo EmpleadoEquipo para crear la asignación
        EmpleadoEquipo::create([
            'empleado_id' => $empleadoId,
            'equipo_id' => $equipo->id,
            'fecha_asignacion' => now(),
            'observaciones' => "Asignado automáticamente por solicitud de adquisición #{$solicitudId}"
        ]);
    }

    /**
     * Método adicional para forzar la búsqueda de equipo compatible (puedes usar en una ruta)
     */
    public function buscarEquipoCompatible(Solicitud $solicitud)
    {
        try {
            $this->asignarEquipoCompatible($solicitud);
            return redirect()->back()
                ->with('success', 'Búsqueda de equipo compatible completada.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error en la búsqueda: ' . $e->getMessage());
        }
    }
}