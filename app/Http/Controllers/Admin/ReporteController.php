<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Filtro opcional por sector (viene de la URL: ?sector=...)
        $sector = $request->query('sector');

        // CU09: emprendedores (se puede filtrar por sector)
        $emprendedores = User::where('rol', 'emprendedor')
            ->when($sector, fn($q) => $q->where('actividad_economica', $sector))
            ->orderBy('name')
            ->get();

        $totalActivos = $emprendedores
            ->filter(fn($e) => strtolower((string) $e->estado) === 'activo')
            ->count();

        // CU10: sectores más comunes
        $sectores = User::where('rol', 'emprendedor')
            ->selectRaw('actividad_economica, count(*) as total')
            ->groupBy('actividad_economica')
            ->orderByDesc('total')
            ->get();

        // CU10: cursos más solicitados (top 5)
        $cursosSolicitados = DB::table('inscripciones')
            ->join('capacitaciones', 'capacitaciones.id', '=', 'inscripciones.capacitacion_id')
            ->select('capacitaciones.nombre', DB::raw('count(*) as total'))
            ->groupBy('capacitaciones.id', 'capacitaciones.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $totalInscripciones = Inscripcion::count();

        return view('admin.reportes.index', compact(
            'emprendedores',
            'totalActivos',
            'sectores',
            'cursosSolicitados',
            'totalInscripciones',
            'sector'
        ));
    }
public function export(Request $request)
    {
        $sector = $request->query('sector');
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        $emprendedores = User::where('rol', 'emprendedor')
            ->when($sector, fn($q) => $q->where('actividad_economica', $sector))
            ->when($desde, fn($q) => $q->whereDate('created_at', '>=', $desde))
            ->when($hasta, fn($q) => $q->whereDate('created_at', '<=', $hasta))
            ->orderBy('name')
            ->get();

        $fileName = 'reporte_emprendedores_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($emprendedores) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['Nombre', 'Correo', 'Actividad Económica', 'Estado', 'Fecha de Registro']);

            foreach ($emprendedores as $emp) {
                fputcsv($file, [
                    $emp->name,
                    $emp->email,
                    $emp->actividad_economica,
                    $emp->estado ?? 'N/A',
                    $emp->created_at ? $emp->created_at->format('Y-m-d') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}