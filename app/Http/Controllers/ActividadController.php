<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Programa;
use App\Models\TipoEquipo;
use App\Http\Requests\ActividadRequest;
use App\Http\Requests\UpdateActividadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $actividades = Actividad::buscar($search)
            ->orderBy('nombre')
            ->paginate(10);

        return view('actividades.index', compact('actividades', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programas = Programa::with('fabricante')->orderBy('nombre')->get();
        $tiposEquipo = TipoEquipo::orderBy('nombre')->get();
        
        return view('actividades.create', compact('programas', 'tiposEquipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActividadRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Crear la actividad
                $actividad = Actividad::create($request->validated());
                
                // Sincronizar programas si existen
                if ($request->has('programas')) {
                    $programaIds = collect($request->programas)->pluck('programa_id')->toArray();
                    $actividad->programas()->sync($programaIds);
                }
                
                // Sincronizar tipos de equipo si existen
                if ($request->has('tipos_equipo')) {
                    $tipoEquipoIds = collect($request->tipos_equipo)->pluck('tipo_equipo_id')->toArray();
                    $actividad->tiposEquipo()->sync($tipoEquipoIds);
                }
            });
            
            return redirect()->route('actividades.index')
                ->with('success', 'Actividad creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la actividad: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Actividad $actividade)
    {
        $actividade->load(['programas', 'tiposEquipo']);
        return view('actividades.show', compact('actividade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actividad $actividade)
    {
        $programas = Programa::with('fabricante')->orderBy('nombre')->get();
        $tiposEquipo = TipoEquipo::orderBy('nombre')->get();
        $actividade->load(['programas', 'tiposEquipo']);
        
        return view('actividades.edit', compact('actividade', 'programas', 'tiposEquipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActividadRequest $request, Actividad $actividade)
    {
        try {
            DB::transaction(function () use ($request, $actividade) {
                // Actualizar la actividad
                $actividade->update($request->validated());
                
                // Sincronizar programas
                if ($request->has('programas')) {
                    $programaIds = collect($request->programas)->pluck('programa_id')->toArray();
                    $actividade->programas()->sync($programaIds);
                } else {
                    $actividade->programas()->detach();
                }
                
                // Sincronizar tipos de equipo
                if ($request->has('tipos_equipo')) {
                    $tipoEquipoIds = collect($request->tipos_equipo)->pluck('tipo_equipo_id')->toArray();
                    $actividade->tiposEquipo()->sync($tipoEquipoIds);
                } else {
                    $actividade->tiposEquipo()->detach();
                }
            });
            
            return redirect()->route('actividades.index')
                ->with('success', 'Actividad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la actividad: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actividad $actividad)
    {
        try {
            $actividad->delete();
            return redirect()->route('actividades.index')
                ->with('success', 'Actividad eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la actividad: ' . $e->getMessage());
        }
    }
}