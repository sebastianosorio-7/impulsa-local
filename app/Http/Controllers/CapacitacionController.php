<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;

class CapacitacionController extends Controller
{
    public function index()
    {
        // Trae únicamente los cursos que venzan hoy o en el futuro
        $capacitaciones = Capacitacion::where('fecha', '>=', now()->toDateString())->get();
        return view('capacitaciones.index', compact('capacitaciones'));
    }
}
