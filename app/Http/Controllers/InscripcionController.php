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
        $capacitacion = Capacitacion::findOrFail($request->capacitacion_id);

        // 1. Buscar si ya existe un registro previo (activo, finalizado o cancelado)
        $inscripcionExistente = Inscripcion::where('user_id', $userId)
            ->where('capacitacion_id', $capacitacion->id)
            ->first();

        // Solo se puede volver a inscribir quien canceló; los demás ya están inscritos
        if ($inscripcionExistente && strtolower($inscripcionExistente->estado) !== 'cancelada') {
            return redirect()->back()->with('error', 'Ya estás inscrito en esta capacitación.');
        }

        // 2. Control de cupo (también al reactivar una inscripción cancelada)
        if ($capacitacion->cuposDisponibles() <= 0) {
            return redirect()->back()->with('error', 'Lo sentimos, esta capacitación ya no tiene cupos disponibles.');
        }

        // 3. Reactivar la cancelada o crear una nueva
        if ($inscripcionExistente) {
            $inscripcionExistente->update([
                'estado'   => 'Inscrito',
                'progreso' => 0,
            ]);

            return redirect()->route('inscripciones.index')
                ->with('success', '¡Te has vuelto a inscribir exitosamente!');
        }

        Inscripcion::create([
            'user_id'         => $userId,
            'capacitacion_id' => $capacitacion->id,
            'estado'          => 'Inscrito',
            'progreso'        => 0,
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
