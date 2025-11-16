<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\TipoServicio;
use App\Models\TipoComponente;
use App\Models\TipoEquipo;
use App\Http\Requests\ProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $proveedores = Proveedor::with('tipoServicio')
            ->when($search, function($query, $search) {
                return $query->where('razon_social', 'like', "%{$search}%")
                           ->orWhere('cuit', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return view('proveedores.index', compact('proveedores', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposServicio = TipoServicio::orderBy('nombre')->get();
        $tiposComponente = TipoComponente::orderBy('nombre')->get();
        $tiposEquipo = TipoEquipo::orderBy('nombre')->get();
        

        return view('proveedores.create', compact('tiposServicio', 'tiposComponente', 'tiposEquipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(ProveedorRequest $request)
    {
        // try {
            DB::transaction(function () use ($request) {
                // Crear el proveedor
                $proveedor = Proveedor::create($request->validated());
                
                // Sincronizar tipos de componente
                if ($request->has('tipos_componente')) {
                    $tipoComponenteIds = collect($request->tipos_componente)
                        ->pluck('tipo_componente_id')
                        ->filter()
                        ->unique()
                        ->toArray();
                    
                    $proveedor->tiposComponente()->sync($tipoComponenteIds);
                }

                // Sincronizar tipos de equipo
                if ($request->has('tipos_equipo')) {
                    $tipoEquipoIds = collect($request->tipos_equipo)
                        ->pluck('tipo_equipo_id')
                        ->filter()
                        ->unique()
                        ->toArray();
                    
                    $proveedor->tiposEquipo()->sync($tipoEquipoIds);
                }
            });

            return redirect()->route('proveedores.index')
                ->with('success', 'Proveedor creado exitosamente.');
        // } catch (\Exception $e) {
        //     return redirect()->back()
        //         ->with('error', 'Error al crear el proveedor: ' . $e->getMessage())
        //         ->withInput();
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedore)
    {
        $proveedor = $proveedore->load([
            'tipoServicio',
            'tiposComponente',
            'tiposEquipo'
        ]);
        
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedore)
{
    $proveedore->load(['tipoServicio', 'tiposComponente', 'tiposEquipo']);
    $tiposServicio = TipoServicio::orderBy('nombre')->get();
    $tiposComponente = TipoComponente::orderBy('nombre')->get();
    $tiposEquipo = TipoEquipo::orderBy('nombre')->get();

    return view('proveedores.edit', compact('proveedore', 'tiposServicio', 'tiposComponente', 'tiposEquipo'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedorRequest $request, Proveedor $proveedore)
{
    try {
        DB::transaction(function () use ($request, $proveedore) {
            // Actualizar el proveedor
            $proveedore->update($request->validated());
            // Sincronizar tipos de componente - procesar la estructura multidimensional
            if ($request->has('tipos_componente')) {
                $tipoComponenteIds = collect($request->tipos_componente)
                    ->pluck('tipo_componente_id')
                    ->filter() // Eliminar valores null o vacíos
                    ->unique()
                    ->toArray();
                
                $proveedore->tiposComponente()->sync($tipoComponenteIds);
            } else {
                $proveedore->tiposComponente()->detach();
            }

            // Sincronizar tipos de equipo - procesar la estructura multidimensional
            if ($request->has('tipos_equipo')) {
                $tipoEquipoIds = collect($request->tipos_equipo)
                    ->pluck('tipo_equipo_id')
                    ->filter() // Eliminar valores null o vacíos
                    ->unique()
                    ->toArray();
                
                $proveedore->tiposEquipo()->sync($tipoEquipoIds);
            } else {
                $proveedore->tiposEquipo()->detach();
            }
        });

        return redirect()->route('proveedores.show', $proveedore)->with('success', 'Proveedor actualizado exitosamente.');
        
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al actualizar el proveedor: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        try {
            $proveedor->delete();
            
            return redirect()->route('proveedores.index')
                ->with('success', 'Proveedor eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }
}