<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProgresoRequest;
use App\Models\Inscripcion;

class ProgresoController extends Controller
{
    // Lista las inscripciones con un formulario para actualizar el avance
    public function index()
    {
        $inscripciones = Inscripcion::with(['user', 'capacitacion'])
            ->latest()
            ->get();

        return view('admin.progreso.index', compact('inscripciones'));
    }

    // Guarda el estado y el avance de una inscripción
    public function update(UpdateProgresoRequest $request, Inscripcion $inscripcion)
    {
        $datos = $request->validated();

        // Si el avance llega al 100 %, la inscripción queda finalizada
        if ((int) $datos['progreso'] === 100) {
            $datos['estado'] = 'Finalizado';
        }

        $inscripcion->update($datos);

        return redirect()
            ->route('admin.progreso.index')
            ->with('status', 'Progreso actualizado correctamente.');
    }
}
