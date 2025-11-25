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
use App\Models\SolicitudEquipo;
use App\Models\SolicitudActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $solicitudes = Solicitud::with([
            'empleado', 
            'solicitudActividades', 
            'tipoSolicitud', 
            'solicitudEquipos.equipo'
        ])
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
        // try {
            DB::transaction(function () use ($request) {
                // Validar equipo SOLO para reparación
                $tipoSolicitud = TipoSolicitud::find($request->tipo_solicitud_id);
                $esReparacion = $tipoSolicitud && stripos($tipoSolicitud->nombre, 'reparación') !== false;
                
                // Solo validar equipo para reparación
                if ($esReparacion && !$request->equipo_id) {
                    throw new \Exception('Para solicitudes de reparación debe seleccionar un equipo.');
                }

                // Crear la solicitud con fecha actual y estado pendiente
                $solicitud = Solicitud::create([
                    'fecha_inicio' => now()->format('Y-m-d'),
                    'estado' => 'pendiente',
                    'empleado_id' => $request->empleado_id,
                    'tipo_solicitud_id' => $request->tipo_solicitud_id
                ]);

                // Si es una solicitud de reparación, crear registro en SolicitudEquipo
                if ($esReparacion && $request->equipo_id) {
                    SolicitudEquipo::create([
                        'solicitud_id' => $solicitud->id,
                        'equipo_id' => $request->equipo_id,
                        'descripcion_uso' => $request->descripcion_uso ?? 'Reparación solicitada',
                        'fecha_asignacion' => now(),
                        'estado_asignacion' => 'pendiente',
                        'observaciones' => $request->observaciones ?? 'Solicitud de reparación creada automáticamente'
                    ]);
                }

                // Sincronizar actividades si existen (para ambos tipos de solicitud)
                if ($request->has('actividades')) {
                    foreach ($request->actividades as $actividadData) {
                        SolicitudActividad::create([
                            'solicitud_id' => $solicitud->id,
                            'actividad_id' => $actividadData['actividad_id'],
                            'fecha_asignacion' => now(),
                            'estado_asignacion' => 'pendiente',
                            'observaciones' => $actividadData['observaciones'] ?? null
                        ]);
                    }
                }

                // Si es una solicitud de adquisición, buscar equipo compatible
                if ($tipoSolicitud && stripos($tipoSolicitud->nombre, 'adquisición') !== false) {
                    $this->asignarEquipoCompatible($solicitud);
                }
            });
            
            return redirect()->route('solicitudes.index')
                ->with('success', 'Solicitud creada exitosamente.');
        // } catch (\Exception $e) {
        //     return redirect()->back()
        //         ->with('error', 'Error al crear la solicitud: ' . $e->getMessage())
        //         ->withInput();
        // }
    }

    public function show(Solicitud $solicitud)
    {
        $solicitud->load([
            'empleado', 
            'solicitudActividades.actividad', 
            'tipoSolicitud', 
            'solicitudEquipos.equipo'
        ]);
        return view('solicitudes.show', compact('solicitud'));
    }

    public function edit(Solicitud $solicitud)
    {
        $empleados = Empleado::all();
        $actividades = Actividad::all();
        $tipoSolicitudes = TipoSolicitud::all();
        $solicitud->load(['solicitudActividades', 'solicitudEquipos']);
        
        // Obtener equipos del empleado SOLO si es reparación
        $equiposEmpleado = collect();
        if ($solicitud->esReparacion() && $solicitud->empleado_id) {
            $equiposEmpleado = $solicitud->empleado->equipos()
                ->where('estado', 'Activo')
                ->get();
        }
        
        return view('solicitudes.edit', compact('solicitud', 'empleados', 'actividades', 'tipoSolicitudes', 'equiposEmpleado'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        try {
            DB::transaction(function () use ($request, $solicitud) {
                // Validar equipo SOLO para reparación
                $tipoSolicitud = TipoSolicitud::find($request->tipo_solicitud_id);
                $esReparacion = $tipoSolicitud && stripos($tipoSolicitud->nombre, 'reparación') !== false;
                
                // Solo validar equipo para reparación
                if ($esReparacion && !$request->equipo_id) {
                    throw new \Exception('Para solicitudes de reparación debe seleccionar un equipo.');
                }

                // Actualizar la solicitud
                $solicitud->update([
                    'empleado_id' => $request->empleado_id,
                    'tipo_solicitud_id' => $request->tipo_solicitud_id
                ]);

                // Manejar SolicitudEquipo SOLO para reparaciones
                if ($esReparacion && $request->equipo_id) {
                    $solicitudEquipo = $solicitud->solicitudEquipos()->first();
                    
                    if ($solicitudEquipo) {
                        // Actualizar existente
                        $solicitudEquipo->update([
                            'equipo_id' => $request->equipo_id,
                            'descripcion_uso' => $request->descripcion_uso ?? $solicitudEquipo->descripcion_uso,
                            'observaciones' => $request->observaciones ?? $solicitudEquipo->observaciones
                        ]);
                    } else {
                        // Crear nuevo
                        SolicitudEquipo::create([
                            'solicitud_id' => $solicitud->id,
                            'equipo_id' => $request->equipo_id,
                            'descripcion_uso' => $request->descripcion_uso ?? 'Reparación solicitada',
                            'fecha_asignacion' => now(),
                            'estado_asignacion' => 'pendiente',
                            'observaciones' => $request->observaciones ?? 'Solicitud de reparación actualizada'
                        ]);
                    }
                } else {
                    // Si ya no es reparación, eliminar SolicitudEquipo
                    $solicitud->solicitudEquipos()->delete();
                }

                // Manejar SolicitudActividad (para ambos tipos de solicitud)
                $solicitud->solicitudActividades()->delete();
                if ($request->has('actividades')) {
                    foreach ($request->actividades as $actividadData) {
                        SolicitudActividad::create([
                            'solicitud_id' => $solicitud->id,
                            'actividad_id' => $actividadData['actividad_id'],
                            'fecha_asignacion' => now(),
                            'estado_asignacion' => 'pendiente',
                            'observaciones' => $actividadData['observaciones'] ?? null
                        ]);
                    }
                }

                // Si cambió a adquisición, buscar equipo compatible
                if ($tipoSolicitud && stripos($tipoSolicitud->nombre, 'adquisición') !== false) {
                    $this->asignarEquipoCompatible($solicitud);
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
            DB::transaction(function () use ($solicitud) {
                // Eliminar relaciones
                $solicitud->solicitudActividades()->delete();
                $solicitud->solicitudEquipos()->delete();
                $solicitud->delete();
            });
            
            return redirect()->route('solicitudes.index')
                ->with('success', 'Solicitud eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Obtener equipos activos de un empleado (SOLO para reparación)
     */
    public function getEquiposActivos($empleadoId)
    {
        try {
            \Log::info("Buscando equipos para empleado: {$empleadoId}");
            
            $empleado = Empleado::find($empleadoId);
            
            if (!$empleado) {
                return response()->json([], 404);
            }
            
            // Cargar equipos con la relación tipoEquipo
            $equipos = $empleado->equipos()
                ->with('tipoEquipo')
                ->where('equipos.estado', 'Activo')
                ->select(
                    'equipos.id', 
                    'equipos.numero_serie', 
                    'equipos.modelo', 
                    'equipos.descripcion',
                    'equipos.tipo_equipo_id'
                )
                ->get()
                ->map(function ($equipo) {
                    return [
                        'id' => $equipo->id,
                        'numero_serie' => $equipo->numero_serie,
                        'modelo' => $equipo->modelo,
                        'descripcion' => $equipo->descripcion,
                        'tipo_equipo' => $equipo->tipoEquipo->nombre ?? 'N/A'
                    ];
                });
            
            \Log::info("Equipos encontrados: " . $equipos->count());
            
            return response()->json($equipos);
        } catch (\Exception $e) {
            \Log::error('Error al cargar equipos del empleado: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Asigna un equipo compatible basado en los componentes requeridos por las actividades
     */
    private function asignarEquipoCompatible(Solicitud $solicitud)
    {
        // Obtener todas las actividades de la solicitud con sus programas y requisitos
        $actividades = $solicitud->solicitudActividades()->with(['actividad.programas.requisitos'])->get();
        
        if ($actividades->isEmpty()) {
            return;
        }

        // Obtener todos los componentes requeridos por los programas de las actividades
        $componentesRequeridos = collect();
        
        foreach ($actividades as $solicitudActividad) {
            foreach ($solicitudActividad->actividad->programas as $programa) {
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
            $mejorEquipo->update(['estado', 'Activo']);
            
            // // Registrar en SolicitudEquipo
            // SolicitudEquipo::create([
            //     'solicitud_id' => $solicitud->id,
            //     'equipo_id' => $mejorEquipo->id,
            //     'descripcion_uso' => 'Equipo asignado automáticamente por solicitud de adquisición',
            //     'fecha_asignacion' => now(),
            //     'estado_asignacion' => 'completado',
            //     'observaciones' => 'Equipo compatible encontrado automáticamente'
            // ]);
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
        // Verificar si ya existe una asignación activa
        $asignacionExistente = EmpleadoEquipo::where('empleado_id', $empleadoId)
            ->where('equipo_id', $equipo->id)
            ->first();
            
        if ($asignacionExistente) {
            // Actualizar asignación existente
            $asignacionExistente->update([
                'fecha_asignacion' => now(),
                'observaciones' => "Reasignado por solicitud de adquisición #{$solicitudId}"
            ]);
        } else {
            // Crear nueva asignación
            EmpleadoEquipo::create([
                'empleado_id' => $empleadoId,
                'equipo_id' => $equipo->id,
                'fecha_asignacion' => now(),
                'observaciones' => "Asignado automáticamente por solicitud de adquisición #{$solicitudId}"
            ]);
        }
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

    /**
     * Cambiar estado de una solicitud
     */
    public function cambiarEstado(Request $request, Solicitud $solicitud)
    {
        try {
            $request->validate([
                'estado' => 'required|in:pendiente,en_proceso,completada,cancelada'
            ]);
            
            $solicitud->update([
                'estado' => $request->estado,
                'fecha_fin' => $request->estado === 'completada' ? now()->format('Y-m-d') : null
            ]);
            
            return redirect()->back()
                ->with('success', 'Estado de la solicitud actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }
}