<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\TipoComponente;
use App\Models\Fabricante;
use Illuminate\Http\Request;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $componentes = Componente::with(['tipoComponente', 'fabricante'])
            ->latest()
            ->get();

        return view('componentes.index', compact('componentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        $tiposComponente = \App\Models\TipoComponente::orderBy('nombre')->get();
        $fabricantes = \App\Models\Fabricante::orderBy('nombre')->get();
        
        return view('componentes.create', compact('tiposComponente', 'fabricantes'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo_componente_id' => 'required|exists:tipos_componente,id',
            'fabricante_id' => 'required|exists:fabricantes,id',
            'modelo' => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'numero_serie' => 'nullable|string|max:255|unique:componentes,numero_serie',
            'fecha_adquisicion' => 'required|date',
            'fecha_instalacion' => 'nullable|date|after_or_equal:fecha_adquisicion',
        ]);

        Componente::create($request->all());

        return redirect()->route('componentes.index')
            ->with('success', 'Componente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Componente $componente)
    {
        $componente->load(['tipoComponente', 'fabricante']);
        
        return view('componentes.show', compact('componente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Componente $componente)
    {
        $tiposComponente = TipoComponente::all();
        $fabricantes = Fabricante::all();

        return view('componentes.edit', compact('componente', 'tiposComponente', 'fabricantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Componente $componente)
    {
        $request->validate([
            'tipo_componente_id' => 'required|exists:tipos_componente,id',
            'fabricante_id' => 'required|exists:fabricantes,id',
            'modelo' => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'numero_serie' => 'nullable|string|max:255|unique:componentes,numero_serie,' . $componente->id,
            'fecha_adquisicion' => 'required|date',
            'fecha_instalacion' => 'nullable|date|after_or_equal:fecha_adquisicion',
        ]);

        $componente->update($request->all());

        return redirect()->route('componentes.index')
            ->with('success', 'Componente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Componente $componente)
    {
        $componente->delete();

        return redirect()->route('componentes.index')
            ->with('success', 'Componente eliminado exitosamente.');
    }
}