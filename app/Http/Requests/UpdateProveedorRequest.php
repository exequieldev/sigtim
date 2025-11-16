<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtener el ID del proveedor actual de la ruta
        // $proveedorId = $this->route('proveedores')->id;

        return [
            'razon_social' => 'required|string|max:255',
            'cuit' => [
                'required',
                'string',
                'max:13',
                Rule::unique('proveedores')->ignore($this->route('proveedore')),
            ],
            'tipo_servicio_id' => 'required|exists:tipo_servicios,id',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            
            // Validación para tipos de componente
            'tipos_componente' => 'nullable|array',
            'tipos_componente.*.tipo_componente_id' => 'nullable|exists:tipos_componente,id',
            
            // Validación para tipos de equipo
            'tipos_equipo' => 'nullable|array',
            'tipos_equipo.*.tipo_equipo_id' => 'nullable|exists:tipos_equipo,id',
        ];
    }

    public function messages(): array
    {
        return [
            'razon_social.required' => 'La razón social es obligatoria.',
            'cuit.required' => 'El CUIT es obligatorio.',
            'cuit.unique' => 'El CUIT ya está registrado en otro proveedor.',
            'tipo_servicio_id.required' => 'El tipo de servicio es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'estado.required' => 'El estado es obligatorio.',
            'tipos_componente.*.tipo_componente_id.exists' => 'El tipo de componente seleccionado no es válido.',
            'tipos_equipo.*.tipo_equipo_id.exists' => 'El tipo de equipo seleccionado no es válido.',
        ];
    }
}