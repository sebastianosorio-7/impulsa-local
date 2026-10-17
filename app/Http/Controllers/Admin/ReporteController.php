<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Emprendedores activos
        $emprendedoresActivos = User::where('role', 'emprendedor')->get();

        // Sectores más comunes
        $sectores = User::where('role', 'emprendedor')
            ->selectRaw('actividad_economica, count(*) as total')
            ->groupBy('actividad_economica')
            ->get();

        // Cursos más solicitados
        $cursosSolicitados = Inscripcion::with('capacitacion')
            ->selectRaw('capacitacion_id, count(*) as total')
            ->groupBy('capacitacion_id')
            ->get();

        return view('admin.reportes.index', compact('emprendedoresActivos', 'sectores', 'cursosSolicitados'));
    }
}