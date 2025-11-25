<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use App\Models\Fabricante;
use App\Models\TipoComponente;
use App\Models\ProgramaRequisito;
use App\Models\Unidad; // Agregado
use App\Http\Requests\ProgramaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $programas = Programa::with(['fabricante', 'requisitos'])
            ->buscar($search)
            ->orderBy('nombre')
            ->paginate(10);

        return view('programas.index', compact('programas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fabricantes = Fabricante::orderBy('nombre')->get();
        $tiposComponente = TipoComponente::orderBy('nombre')->get();
        $unidades = Unidad::orderBy('nombre')->get(); // Cambiado: obtener de tabla unidades
        
        return view('programas.create', compact('fabricantes', 'tiposComponente', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProgramaRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Crear el programa
                $programa = Programa::create($request->validated());
                
                // Crear los requisitos si existen
                if ($request->has('requisitos')) {
                    foreach ($request->requisitos as $requisito) {
                        // Validar que los campos requeridos no estén vacíos
                        if (!empty($requisito['tipo_componente_id']) && !empty($requisito['requisito_minimo'])) {
                            ProgramaRequisito::create([
                                'programa_id' => $programa->id,
                                'tipo_componente_id' => $requisito['tipo_componente_id'],
                                'requisito_minimo' => $requisito['requisito_minimo'],
                                'requisito_recomendado' => $requisito['requisito_recomendado'] ?? null,
                                'unidad_medida_id' => $requisito['unidad_medida_id'] ?? null, // Cambiado a unidad_medida_id
                            ]);
                        }
                    }
                }
            });
            
            return redirect()->route('programas.index')
                ->with('success', 'Programa creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el programa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Programa $programa)
    {
        $fabricantes = Fabricante::orderBy('nombre')->get();
        $tiposComponente = TipoComponente::orderBy('nombre')->get();
        $unidades = Unidad::orderBy('nombre')->get(); // Cambiado: obtener de tabla unidades
        $programa->load('requisitos');
        
        return view('programas.edit', compact('programa', 'fabricantes', 'tiposComponente', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProgramaRequest $request, Programa $programa)
    {
        try {
            DB::transaction(function () use ($request, $programa) {
                // Actualizar el programa
                $programa->update($request->validated());
                
                // Eliminar requisitos existentes
                $programa->requisitos()->delete();
                
                // Crear los nuevos requisitos si existen y no están vacíos
                if ($request->has('requisitos') && !empty($request->requisitos)) {
                    foreach ($request->requisitos as $requisito) {
                        // Validar que los campos requeridos no estén vacíos
                        if (!empty($requisito['tipo_componente_id']) && !empty($requisito['requisito_minimo'])) {
                            ProgramaRequisito::create([
                                'programa_id' => $programa->id,
                                'tipo_componente_id' => $requisito['tipo_componente_id'],
                                'requisito_minimo' => $requisito['requisito_minimo'],
                                'requisito_recomendado' => $requisito['requisito_recomendado'] ?? null,
                                'unidad_medida_id' => $requisito['unidad_medida_id'] ?? null, // Cambiado a unidad_medida_id
                            ]);
                        }
                    }
                }
            });
            
            return redirect()->route('programas.index')
                ->with('success', 'Programa actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el programa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Programa $programa)
    {
        $programa->load(['fabricante', 'requisitos.tipoComponente', 'requisitos.unidad']); // Agregado unidad
        return view('programas.show', compact('programa'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Programa $programa)
    {
        try {
            $programa->delete();
            return redirect()->route('programas.index')
                ->with('success', 'Programa eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el programa: ' . $e->getMessage());
        }
    }
}