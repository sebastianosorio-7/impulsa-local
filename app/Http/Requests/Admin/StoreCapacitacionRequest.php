<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCapacitacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // El acceso ya está protegido por el middleware rol:administrador
        return true;
    }

    public function rules(): array
    {
        // Al crear, la fecha no puede estar en el pasado.
        // Al editar se permite conservar la fecha original del curso.
        $reglaFecha = $this->isMethod('post')
            ? ['required', 'date', 'after_or_equal:today']
            : ['required', 'date'];

        return [
            // No se permiten dos cursos con el mismo nombre en la misma área (CU05, flujo A1).
            // Al editar se ignora el propio curso para que pueda guardarse sin cambios.
            'nombre'      => [
                'required', 'string', 'max:255',
                Rule::unique('capacitaciones', 'nombre')
                    ->where(fn ($q) => $q->where('area', $this->input('area')))
                    ->ignore($this->route('capacitacion')),
            ],
            'area'        => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'requisitos'  => ['nullable', 'string'],
            'fecha'       => $reglaFecha,
            'hora'        => ['required', 'date_format:H:i'],
            'cupo'        => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'      => 'nombre',
            'area'        => 'área',
            'descripcion' => 'descripción',
            'requisitos'  => 'requisitos',
            'fecha'       => 'fecha',
            'hora'        => 'hora',
            'cupo'        => 'cupo',
        ];
    }

    public function messages(): array
    {
        return [
            'required'             => 'El campo :attribute es obligatorio.',
            'max'                  => 'El campo :attribute es demasiado largo.',
            'integer'              => 'El campo :attribute debe ser un número entero.',
            'nombre.unique'        => 'Ya existe una capacitación con ese nombre en esa área.',
            'cupo.min'             => 'El cupo debe ser de al menos 1 persona.',
            'date'                 => 'Escribe una fecha válida.',
            'fecha.after_or_equal' => 'La fecha no puede estar en el pasado.',
            'hora.date_format'     => 'Escribe una hora válida (por ejemplo 16:00).',
        ];
    }
}