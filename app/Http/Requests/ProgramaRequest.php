<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramaRequest extends FormRequest
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
            'version' => 'nullable|string|max:100',
            'fabricante_id' => 'nullable|exists:fabricantes,id', // Cambiado a fabricante_id
            'sistema_operativo' => 'nullable|string|max:100',
        ];
    }
}