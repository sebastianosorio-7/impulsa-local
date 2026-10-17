<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCapacitacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'cupo' => 'required|integer|min:1',
            'fecha' => 'required|date|after_or_equal:today',
            // Campos obligatorios requeridos por la tabla:
            'area' => 'required|string|max:255',
            'requisitos' => 'required|string',
            'hora' => 'required',
        ];
    }
}
