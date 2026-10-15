<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    // Listado global de inscripciones para el administrador
    public function index()
    {
        $inscripciones = Inscripcion::with(['user', 'capacitacion'])
            ->latest()
            ->get();

        return view('admin.inscripciones.index', compact('inscripciones'));
    }
}
