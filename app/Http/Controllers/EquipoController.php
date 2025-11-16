<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TipoEquipo;
use App\Models\Fabricante;
use App\Models\Componente;
use App\Models\EquipoComponente;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tipo = $request->input('tipo');
        $estado = $request->input('estado');

        $equipos = Equipo::buscar($search)
            ->tipo($tipo)
            ->estado($estado)
            ->orderBy('created_at', 'desc')
            ->get();
       
        return view('equipos.index', compact('equipos', 'search', 'tipo', 'estado'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposEquipo = TipoEquipo::all();
        $fabricantes = Fabricante::all();
        $componentes = Componente::all();
        
        return view('equipos.create', compact('tiposEquipo', 'fabricantes', 'componentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $equipoData = $request->validate([
        'numero_serie' => 'required',
        'tipo_equipo_id' => 'required',
        'fabricante_id' => 'required',
        'modelo' => 'required',
        'descripcion' => 'nullable|string',
        'componentes' => 'sometimes|array',
        'componentes.*.componente_id' => 'required',
    ]);

    // Agregar la fecha actual automáticamente
    $equipoData['fecha_adquisicion'] = now()->toDateString();
    $equipoData['estado'] = 'Activo'; // También puedes establecer un estado por defecto

    // Crear el equipo
    $equipo = Equipo::create($equipoData);

    // Asignar componentes seleccionados usando la tabla pivote
    if ($request->has('componentes')) {
        foreach ($request->componentes as $componenteData) {
            if (!empty($componenteData['componente_id'])) {
                // Usar la tabla pivote equipo_componente
                EquipoComponente::create([
                    'equipo_id' => $equipo->id,
                    'componente_id' => $componenteData['componente_id'],
                    'activo' => true
                ]);
            }
        }
    }

    return redirect()->route('equipos.index')
        ->with('success', 'Equipo informático creado exitosamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        $equipo->load(['tipoEquipo', 'fabricante', 'componentes.tipoComponente', 'componentes.fabricante']);
        return view('equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $equipo = Equipo::with(['componentes'])->findOrFail($id);
        $tiposEquipo = TipoEquipo::all();
        $fabricantes = Fabricante::all();
        $componentes = Componente::with(['tipoComponente', 'fabricante'])->get();

        return view('equipos.edit', compact('equipo', 'tiposEquipo', 'fabricantes', 'componentes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);

        $equipoData = $request->validate([
            'numero_serie' => 'required|string|max:255|unique:equipos,numero_serie,' . $equipo->id,
            'tipo_equipo_id' => 'required|exists:tipos_equipo,id',
            'fabricante_id' => 'required|exists:fabricantes,id',
            'modelo' => 'required|string|max:255',
            'fecha_adquisicion' => 'required|date',
            'fecha_instalacion' => 'nullable|date|after_or_equal:fecha_adquisicion',
            'estado' => 'required|string|in:Activo,Mantenimiento,Baja,En Reparación',
            'descripcion' => 'nullable|string',
            'componentes' => 'sometimes|array',
            'componentes.*.componente_id' => 'required|exists:componentes,id',
        ]);

        // Actualizar el equipo
        $equipo->update($equipoData);

        // Sincronizar componentes
        if ($request->has('componentes')) {
            $componentesIds = collect($request->componentes)
                ->pluck('componente_id')
                ->filter()
                ->unique()
                ->toArray();

            // Usar sync para actualizar la relación muchos-a-muchos
            $equipo->componentes()->sync($componentesIds);
        } else {
            // Si no hay componentes, eliminar todas las relaciones
            $equipo->componentes()->detach();
        }

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo informático actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        try {
            // Desasignar componentes (no eliminarlos)
            $equipo->componentes()->update(['equipo_id' => null]);
            
            // Eliminar el equipo
            $equipo->delete();
            
            return redirect()->route('equipos.index')
                ->with('success', 'Equipo informático eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el equipo: ' . $e->getMessage());
        }
    }
}