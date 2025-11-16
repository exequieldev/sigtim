<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Oficina;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('oficina')->orderBy('nombre')->paginate(10);
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $oficinas = Oficina::all();
        return view('empleados.create', compact('oficinas'));
    }

    public function store(Request $request)
    {
        try {
            Empleado::create($request->all());
            return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear empleado: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        $oficinas = Oficina::all();
        return view('empleados.edit', compact('empleado', 'oficinas'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        try {
            $empleado->update($request->all());
            return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar empleado: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Empleado $empleado)
    {
        try {
            $empleado->delete();
            return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar empleado: ' . $e->getMessage());
        }
    }
}