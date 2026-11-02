<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateEmprendedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        // El acceso ya está protegido por el middleware rol:administrador
        return true;
    }

    public function rules(): array
    {
        $emprendedor = $this->route('emprendedor');

        return [
            'name'                   => ['required', 'string', 'max:255'],
            'documento'              => ['required', 'string', 'max:20', Rule::unique('users', 'documento')->ignore($emprendedor)],
            'email'                  => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($emprendedor)],
            'telefono'               => ['required', 'string', 'max:20'],
            'actividad_economica'    => ['required', 'string', 'max:255'],
            'ubicacion'              => ['required', 'string', 'max:255'],
            'password'               => ['nullable', 'confirmed', Password::min(8)],
            'requisitos_verificados' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'                => 'nombre completo',
            'documento'           => 'documento',
            'email'               => 'correo electrónico',
            'telefono'            => 'teléfono',
            'actividad_economica' => 'actividad económica',
            'ubicacion'           => 'ubicación',
            'password'            => 'contraseña',
        ];
    }

    public function messages(): array
    {
        return [
            'required'  => 'El campo :attribute es obligatorio.',
            'unique'    => 'Ese :attribute ya está registrado.',
            'email'     => 'Escribe un correo electrónico válido.',
            'max'       => 'El campo :attribute es demasiado largo.',
            'confirmed' => 'Las contraseñas no coinciden.',
            'min'       => 'La contraseña debe tener al menos :min caracteres.',
        ];
    }
}
