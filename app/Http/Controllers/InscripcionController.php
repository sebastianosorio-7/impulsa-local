<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Capacitacion;

class InscripcionController extends Controller
{
    /**
     * Muestra la lista de inscripciones del emprendedor autenticado.
     */
    public function index()
    {
        $inscripciones = Inscripcion::where('user_id', auth()->id())
            ->with('capacitacion')
            ->get();

        return view('inscripciones.index', compact('inscripciones'));
    }

    /**
     * Almacena o reactiva una inscripción para una capacitación.
     */
    public function store(Request $request)
    {
        $request->validate([
            'capacitacion_id' => 'required|exists:capacitaciones,id',
        ]);

        $userId = auth()->id();
        $capacitacionId = $request->capacitacion_id;

        // 1. Buscar si ya existe un registro previo (activo o cancelado)
        $inscripcionExistente = Inscripcion::where('user_id', $userId)
            ->where('capacitacion_id', $capacitacionId)
            ->first();

        if ($inscripcionExistente) {
            // Si ya está activo, avisar al usuario
            if ($inscripcionExistente->estado === 'Inscrito') {
                return redirect()->back()->with('error', 'Ya estás inscrito en esta capacitación.');
            }

            // Si estaba cancelada, la reactivamos cambiando su estado
            $inscripcionExistente->update([
                'estado' => 'Inscrito'
            ]);

            return redirect()->route('inscripciones.index')
                ->with('success', '¡Te has vuelto a inscribir exitosamente!');
        }

        // 2. Si no existía ningún registro previo, crear uno nuevo
        Inscripcion::create([
            'user_id' => $userId,
            'capacitacion_id' => $capacitacionId,
            'estado' => 'Inscrito',
        ]);

        return redirect()->route('inscripciones.index')
            ->with('success', '¡Te has inscrito exitosamente!');
    }

    /**
     * Cancela la inscripción cambiando su estado y liberando el cupo.
     */
    public function destroy(Inscripcion $inscripcion)
    {
        // Validar que la inscripción pertenezca al usuario autenticado
        if ($inscripcion->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        // Actualizar el estado a Cancelada (lo que libera el cupo automáticamente en el modelo Capacitacion)
        $inscripcion->update([
            'estado' => 'Cancelada'
        ]);

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción cancelada correctamente.');
    }
}