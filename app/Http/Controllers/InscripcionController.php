<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    // Mostrar las inscripciones del emprendedor logueado
    public function index()
    {
        $inscripciones = Inscripcion::with('capacitacion')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('inscripciones.index', compact('inscripciones'));
    }

    // Procesar la inscripción con control de cupo
    public function store(Request $request)
    {
        $request->validate([
            'capacitacion_id' => 'required|exists:capacitaciones,id',
        ]);

        $capacitacion = Capacitacion::findOrFail($request->capacitacion_id);
        $userId = Auth::id();

        // 1. Validar que el emprendedor no esté ya inscrito
        $yaInscrito = Inscripcion::where('user_id', $userId)
            ->where('capacitacion_id', $capacitacion->id)
            ->exists();

        if ($yaInscrito) {
            return back()->with('error', 'Ya te encuentras inscrito en esta capacitación.');
        }

        // 2. Control de cupo
        $inscritosActuales = Inscripcion::where('capacitacion_id', $capacitacion->id)->count();

        if ($inscritosActuales >= $capacitacion->cupo) {
            return back()->with('error', 'Lo sentimos, esta capacitación ya no tiene cupos disponibles.');
        }

        // 3. Crear la inscripción
        Inscripcion::create([
            'user_id' => $userId,
            'capacitacion_id' => $capacitacion->id,
            'estado' => 'Inscrito',
            'progreso' => 0,
        ]);

        return redirect()->route('inscripciones.index')
            ->with('success', '¡Te has inscrito exitosamente a la capacitación!');
    }
}