<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActividadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'programas' => 'sometimes|array',
            'programas.*.programa_id' => 'required|exists:programas,id',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la actividad es obligatorio.',
            'programas.*.programa_id.required' => 'El programa es obligatorio.',
            'programas.*.programa_id.exists' => 'El programa seleccionado no es válido.',
        ];
    }
}