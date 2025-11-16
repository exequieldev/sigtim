<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\Departamento;
use Illuminate\Http\Request;

class OficinaController extends Controller
{
    public function index()
    {
        $oficinas = Oficina::with('departamento')->orderBy('nombre')->paginate(3);
        return view('oficinas.index', compact('oficinas'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        return view('oficinas.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        try {
            Oficina::create($request->all());
            return redirect()->route('oficinas.index')->with('success', 'Oficina creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear oficina: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Oficina $oficina)
    {
        return view('oficinas.show', compact('oficina'));
    }

    public function edit(Oficina $oficina)
    {
        $departamentos = Departamento::all();
        return view('oficinas.edit', compact('oficina', 'departamentos'));
    }

    public function update(Request $request, Oficina $oficina)
    {
        try {
            $oficina->update($request->all());
            return redirect()->route('oficinas.index')->with('success', 'Oficina actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar oficina: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Oficina $oficina)
    {
        try {
            $oficina->delete();
            return redirect()->route('oficinas.index')->with('success', 'Oficina eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar oficina: ' . $e->getMessage());
        }
    }
}