<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgresoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // El acceso ya está protegido por el middleware rol:administrador
        return true;
    }

    public function rules(): array
    {
        return [
            'estado'   => ['required', Rule::in(['Inscrito', 'En curso', 'Finalizado'])],
            'progreso' => ['required', 'integer', 'between:0,100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'estado'   => 'estado',
            'progreso' => 'progreso',
        ];
    }

    public function messages(): array
    {
        return [
            'required'         => 'El campo :attribute es obligatorio.',
            'estado.in'        => 'Elige un estado válido.',
            'integer'          => 'El progreso debe ser un número entero.',
            'progreso.between' => 'El progreso debe estar entre 0 y 100.',
        ];
    }
}