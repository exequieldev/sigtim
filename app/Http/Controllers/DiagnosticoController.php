<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Solicitud;
use App\Models\Equipo;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosticoController extends Controller
{
    public function index()
    {
        $query = Diagnostico::latest();
        
        // Aplicar filtros condicionalmente
        if (request('search')) {
            $query->where(function($q) {
                $q->where('edificio', 'like', '%' . request('search') . '%')
                ->orWhere('oficina', 'like', '%' . request('search') . '%')
                ->orWhere('empleado_solicitud', 'like', '%' . request('search') . '%')
                ->orWhere('tecnico_responsable', 'like', '%' . request('search') . '%')
                ->orWhere('tipo_equipo', 'like', '%' . request('search') . '%');
            });
        }
        
        if (request('estado')) {
            $query->where('estado', request('estado'));
        }
        
        if (request('tipo_equipo')) {
            $query->where('tipo_equipo', request('tipo_equipo'));
        }
        
        if (request('nivel_gravedad')) {
            $query->where('nivel_gravedad', request('nivel_gravedad'));
        }
        
        $diagnosticos = $query->paginate(10);

        $estadisticas = [
            'total' => Diagnostico::count(),
            'pendientes' => Diagnostico::where('estado', 'pendiente')->count(),
            'en_proceso' => Diagnostico::where('estado', 'en_proceso')->count(),
            'completados' => Diagnostico::where('estado', 'completado')->count(),
        ];

        return view('diagnosticos.index', compact('diagnosticos', 'estadisticas'));
    }

    public function create(Request $request)
    {
        // Obtener la solicitud específica con su equipo
        $solicitud = null;
        $equipoSeleccionado = null;
        $componentesReales = collect();
        
        if ($request->has('solicitud_id')) {
            $solicitud = Solicitud::with([
                'empleado', 
                'solicitudEquipos.equipo.tipoEquipo',
                'solicitudEquipos.equipo.componentes.tipoComponente', // Componentes con relación belongsToMany
                'solicitudEquipos.equipo.componentes.fabricante'
            ])->find($request->solicitud_id);
            
            if ($solicitud && $solicitud->solicitudEquipos->isNotEmpty()) {
                $equipoSeleccionado = $solicitud->solicitudEquipos->first()->equipo;
                
                // Obtener componentes reales del equipo (solo los activos en la relación pivot)
                if ($equipoSeleccionado && $equipoSeleccionado->componentes) {
                    $componentesReales = $equipoSeleccionado->componentes()
                        ->wherePivot('activo', true)
                        ->get()
                        ->map(function($componente) {
                            $peso = $this->asignarPesoPorTipo($componente->tipoComponente->nombre ?? 'General');
                            $importanciaText = $peso >= 20 ? 'Alta' : ($peso >= 10 ? 'Media' : 'Baja');
                            $importanciaClass = $peso >= 20 ? 'danger' : ($peso >= 10 ? 'warning' : 'success');
                            
                            return [
                                'id' => $componente->id,
                                'nombre' => $componente->nombre ?? 'Componente sin nombre',
                                'tipo' => $componente->tipoComponente->nombre ?? 'General',
                                'modelo' => $componente->modelo,
                                'numero_serie' => $componente->numero_serie,
                                'especificaciones' => $componente->especificaciones,
                                'fabricante' => $componente->fabricante->nombre ?? 'N/A',
                                'estado' => 'Activo',
                                'peso' => $peso,
                                'importancia_text' => $importanciaText,
                                'importancia_class' => $importanciaClass
                            ];
                        });
                }
            }
        }

        // Si no hay solicitud, redirigir con error
        if (!$solicitud) {
            return redirect()->route('solicitudes.index')
                ->with('error', 'No se encontró la solicitud especificada.');
        }

        // Si no hay equipo en la solicitud, redirigir con error
        if (!$equipoSeleccionado) {
            return redirect()->route('solicitudes.index')
                ->with('error', 'La solicitud no tiene un equipo asignado para diagnosticar.');
        }

        // Datos predeterminados basados en la solicitud y equipo
        $datosPredeterminados = [
            'solicitud_id' => $solicitud->id,
            'equipo_id' => $equipoSeleccionado->id,
            'edificio' => 'Torre Central',
            'piso' => '4',
            'oficina' => 'Sistemas - 402',
            'empleado_solicitud' => $solicitud->empleado ? $solicitud->empleado->nombre . ' ' . $solicitud->empleado->apellido : 'N/A',
            'tecnico_responsable' => auth()->user()->name ?? 'Técnico Responsable',
            'tipo_equipo' => $this->mapearTipoEquipo($equipoSeleccionado->tipoEquipo->nombre ?? 'otros'),
            'marca_equipo' => $equipoSeleccionado->marca ?? '',
            'modelo_equipo' => $equipoSeleccionado->modelo ?? '',
            'numero_serie' => $equipoSeleccionado->numero_serie ?? '',
        ];

        return view('diagnosticos.create', compact('datosPredeterminados', 'solicitud', 'equipoSeleccionado', 'componentesReales'));
    }

    // Método para mapear tipos de equipo
    private function mapearTipoEquipo($tipoEquipoNombre)
    {
        $mapeo = [
            'Laptop' => 'laptop',
            'Desktop' => 'desktop', 
            'Computadora de Escritorio' => 'desktop',
            'Impresora' => 'impresora',
            'Monitor' => 'monitor',
            'Router' => 'router',
            'Servidor' => 'servidor',
            'Tablet' => 'tablet',
        ];
        
        return $mapeo[$tipoEquipoNombre] ?? 'otros';
    }

    // Método para asignar peso según el tipo de componente
    private function asignarPesoPorTipo($tipoComponente)
    {
        $pesos = [
            'Procesador' => 25,
            'CPU' => 25,
            'Memoria RAM' => 20,
            'RAM' => 20,
            'Disco Duro' => 20,
            'HDD' => 20,
            'SSD' => 20,
            'Placa Madre' => 25,
            'Motherboard' => 25,
            'Tarjeta de Video' => 20,
            'GPU' => 20,
            'Fuente de Poder' => 15,
            'Power Supply' => 15,
            'Pantalla' => 20,
            'Monitor' => 20,
            'Teclado' => 10,
            'Keyboard' => 10,
            'Mouse' => 5,
            'Batería' => 15,
            'Battery' => 15,
            'Cargador' => 10,
            'Charger' => 10,
            'Ventilador' => 10,
            'Fan' => 10,
            'Disipador' => 10,
            'Cooler' => 10,
            'Unidad Óptica' => 5,
            'Optical Drive' => 5,
            'Tarjeta de Red' => 10,
            'Network Card' => 10,
            'Tarjeta de Sonido' => 5,
            'Sound Card' => 5,
        ];
        
        return $pesos[$tipoComponente] ?? 10; // Peso por defecto 10
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'solicitud_id' => 'required|exists:solicitudes,id',
            'equipo_id' => 'required|exists:equipos,id',
            'edificio' => 'required|string|max:100',
            'piso' => 'required|string|max:50',
            'oficina' => 'required|string|max:100',
            'empleado_solicitud' => 'required|string|max:200',
            'tipo_equipo' => 'required|in:laptop,desktop,impresora,monitor,router,servidor,tablet,otros',
            'marca_equipo' => 'nullable|string|max:100',
            'modelo_equipo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'porcentaje_funcionalidad' => 'required|numeric|min:0|max:100',
            'nivel_gravedad' => 'required|in:baja,media,alta,critica',
            'mensaje_diagnostico' => 'required|string',
            'analisis_componentes' => 'required|string',
            'recomendaciones' => 'required|string',
            'componentes_estado' => 'required|array',
            'componentes_defectuosos' => 'required|array',
            'recursos_necesarios' => 'required|array',
            'tecnico_responsable' => 'required|string|max:200',
            'fecha_diagnostico' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $diagnostico = Diagnostico::create($validated);

            // Actualizar el estado de la solicitud a "en_proceso"
            $solicitud = Solicitud::find($request->solicitud_id);
            if ($solicitud) {
                $solicitud->update(['estado' => 'en_proceso']);
            }

            DB::commit();

            return redirect()->route('diagnosticos.show', $diagnostico)
                ->with('success', 'Diagnóstico creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear el diagnóstico: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Diagnostico $diagnostico)
    {
        return view('diagnosticos.show', compact('diagnostico'));
    }

    public function edit(Diagnostico $diagnostico)
    {
        return view('diagnosticos.edit', compact('diagnostico'));
    }

    public function update(Request $request, Diagnostico $diagnostico)
    {
        $validated = $request->validate([
            'edificio' => 'required|string|max:100',
            'piso' => 'required|string|max:50',
            'oficina' => 'required|string|max:100',
            'empleado_solicitud' => 'required|string|max:200',
            'tipo_equipo' => 'required|in:laptop,desktop,impresora,monitor,router,servidor,tablet,otros',
            'marca_equipo' => 'nullable|string|max:100',
            'modelo_equipo' => 'nullable|string|max:100',
            'porcentaje_funcionalidad' => 'required|numeric|min:0|max:100',
            'nivel_gravedad' => 'required|in:baja,media,alta,critica',
            'mensaje_diagnostico' => 'required|string',
            'analisis_componentes' => 'required|string',
            'recomendaciones' => 'required|string',
            'componentes_estado' => 'required|array',
            'componentes_defectuosos' => 'required|array',
            'recursos_necesarios' => 'required|array',
            'tecnico_responsable' => 'required|string|max:200',
            'fecha_diagnostico' => 'required|date',
            'estado' => 'required|in:pendiente,en_proceso,completado,cancelado',
        ]);

        try {
            DB::beginTransaction();

            $diagnostico->update($validated);

            DB::commit();

            return redirect()->route('diagnosticos.show', $diagnostico)
                ->with('success', 'Diagnóstico actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el diagnóstico: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Diagnostico $diagnostico)
    {
        try {
            $diagnostico->delete();

            return redirect()->route('diagnosticos.index')
                ->with('success', 'Diagnóstico eliminado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el diagnóstico: ' . $e->getMessage());
        }
    }

    // Método para obtener equipos de una solicitud
    public function getEquipoSolicitud($solicitudId)
    {
        try {
            $solicitud = Solicitud::with(['solicitudEquipos.equipo.tipoEquipo'])
                ->find($solicitudId);

            if (!$solicitud) {
                return response()->json(['error' => 'Solicitud no encontrada'], 404);
            }

            $equipo = null;
            if ($solicitud->solicitudEquipos->isNotEmpty()) {
                $equipoData = $solicitud->solicitudEquipos->first()->equipo;
                $equipo = [
                    'id' => $equipoData->id,
                    'numero_serie' => $equipoData->numero_serie,
                    'modelo' => $equipoData->modelo,
                    'marca' => $equipoData->marca,
                    'descripcion' => $equipoData->descripcion,
                    'tipo_equipo' => $equipoData->tipoEquipo->nombre ?? 'N/A',
                    'tipo_equipo_id' => $equipoData->tipo_equipo_id
                ];
            }

            return response()->json([
                'equipo' => $equipo,
                'empleado' => $solicitud->empleado ? [
                    'nombre' => $solicitud->empleado->nombre,
                    'apellido' => $solicitud->empleado->apellido
                ] : null
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar equipo: ' . $e->getMessage()], 500);
        }
    }

    // Método para calcular diagnóstico automático (API)
    public function calcularDiagnostico(Request $request)
    {
        $request->validate([
            'tipo_equipo' => 'required|string',
            'componentes' => 'required|array'
        ]);

        $resultado = $this->calcularDiagnosticoAutomatico(
            $request->tipo_equipo,
            $request->componentes
        );

        return response()->json($resultado);
    }

    private function calcularDiagnosticoAutomatico($tipoEquipo, $componentes)
    {
        $puntuacionTotal = 0;
        $puntuacionMaxima = 0;
        $componentesDefectuosos = [];

        foreach ($componentes as $componente) {
            $peso = $componente['peso'] ?? 0;
            $puntuacionMaxima += $peso;

            switch ($componente['estado']) {
                case 'good':
                    $puntuacionTotal += $peso;
                    break;
                case 'faulty':
                    $componentesDefectuosos[] = $componente['nombre'];
                    break;
                case 'unknown':
                    $puntuacionTotal += $peso * 0.5;
                    break;
            }
        }

        $porcentajeFuncional = $puntuacionMaxima > 0 ? ($puntuacionTotal / $puntuacionMaxima) * 100 : 0;

        if ($porcentajeFuncional >= 80) {
            $nivelGravedad = 'baja';
            $mensaje = 'Equipo en buen estado';
        } elseif ($porcentajeFuncional >= 50) {
            $nivelGravedad = 'media';
            $mensaje = 'Equipo con problemas menores';
        } elseif ($porcentajeFuncional >= 20) {
            $nivelGravedad = 'alta';
            $mensaje = 'Equipo requiere reparación';
        } else {
            $nivelGravedad = 'critica';
            $mensaje = 'Equipo en estado crítico';
        }

        return [
            'porcentaje_funcionalidad' => round($porcentajeFuncional, 2),
            'nivel_gravedad' => $nivelGravedad,
            'mensaje_diagnostico' => $mensaje,
            'componentes_defectuosos' => $componentesDefectuosos
        ];
    }
}