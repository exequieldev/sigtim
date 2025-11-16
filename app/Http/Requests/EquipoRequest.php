<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'numero_serie' => 'required|string|max:100|unique:equipos_informaticos',
            'tipo_equipo' => 'required|in:Laptop,Desktop,Tablet,Servidor,Impresora,Monitor,Otro',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'procesador' => 'nullable|string|max:100',
            'ram_gb' => 'nullable|integer|min:1',
            'almacenamiento_gb' => 'nullable|integer|min:1',
            'sistema_operativo' => 'nullable|string|max:50',
            'estado' => 'required|in:Activo,Mantenimiento,Baja,En Reparación',
            'fecha_adquisicion' => 'required|date',
            'departamento' => 'required|string|max:100',
            'responsable' => 'required|string|max:100',
            'observaciones' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.unique' => 'El número de serie ya existe en el sistema.',
            'tipo_equipo.required' => 'El tipo de equipo es obligatorio.',
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
            'fecha_adquisicion.required' => 'La fecha de adquisición es obligatoria.',
            'departamento.required' => 'El departamento es obligatorio.',
            'responsable.required' => 'El responsable es obligatorio.',
        ];
    }
}