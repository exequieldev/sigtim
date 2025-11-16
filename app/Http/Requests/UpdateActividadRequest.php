<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActividadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('actividades')->ignore($this->route('actividade')),
            ],
            'descripcion' => 'nullable|string',
            
            // Validación para programas
            'programas' => 'required|array|min:1',
            'programas.*.programa_id' => 'required|exists:programas,id',
            
            // Validación para tipos de equipo
            'tipos_equipo' => 'nullable|array',
            'tipos_equipo.*.tipo_equipo_id' => 'nullable|exists:tipos_equipo,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la actividad es obligatorio.',
            'nombre.unique' => 'El nombre de la actividad ya está registrado.',
            'programas.required' => 'Debe agregar al menos un programa.',
            'programas.min' => 'Debe agregar al menos un programa.',
            'programas.*.programa_id.required' => 'El programa es obligatorio.',
            'programas.*.programa_id.exists' => 'El programa seleccionado no es válido.',
            'tipos_equipo.*.tipo_equipo_id.exists' => 'El tipo de equipo seleccionado no es válido.',
        ];
    }
}