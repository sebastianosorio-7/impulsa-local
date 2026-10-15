<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'administrador') {
            $resumen = [
                'emprendedores'  => User::where('rol', 'emprendedor')->count(),
                'capacitaciones' => Capacitacion::count(),
                'inscripciones'  => Inscripcion::count(),
                'finalizadas'    => Inscripcion::where('estado', 'Finalizado')->count(),
            ];
        } else {
            $resumen = [
                'inscripciones' => $user->inscripciones()->count(),
                'finalizadas'   => $user->inscripciones()->where('estado', 'Finalizado')->count(),
                'disponibles'   => Capacitacion::where('fecha', '>=', now()->toDateString())->count(),
            ];
        }

        return view('dashboard', compact('user', 'resumen'));
    }
}