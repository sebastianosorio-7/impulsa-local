<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use Illuminate\Http\Request; // Importante para capturar la búsqueda

class CapacitacionController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        // Mantiene el filtro de fecha original e integra tus requisitos: 
        // 1. Que el estado sea estrictamente 'abierta'
        // 2. Buscador funcional por nombre o área
        $capacitaciones = Capacitacion::where('fecha', '>=', now()->toDateString())
            ->where('estado', 'abierta')
            ->when($buscar, function ($consulta, $buscar) {
                return $consulta->where(function($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                      ->orWhere('area', 'like', "%{$buscar}%");
                });
            })
            ->get();

        return view('capacitaciones.index', compact('capacitaciones'));
    }
}
