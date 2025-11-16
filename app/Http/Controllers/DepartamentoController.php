<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::orderBy('nombre')->paginate(10);
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        try {
            Departamento::create($request->all());
            return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear departamento: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Departamento $departamento)
    {
        return view('departamentos.show', compact('departamento'));
    }

    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        try {
            $departamento->update($request->all());
            return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar departamento: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Departamento $departamento)
    {
        try {
            $departamento->delete();
            return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar departamento: ' . $e->getMessage());
        }
    }
}