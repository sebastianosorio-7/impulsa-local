<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capacitacion;
use App\Http\Requests\Admin\StoreCapacitacionRequest;
use Illuminate\Http\Request; // IMPORTANTE PARA EL INDICE

class CapacitacionController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $estado = $request->input('estado');

        // Aplicamos el buscador dinámico concurrente y el filtro de estado exigido
        $capacitaciones = Capacitacion::query()
            ->when($buscar, function ($consulta, $buscar) {
                return $consulta->where(function($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                      ->orWhere('area', 'like', "%{$buscar}%");
                });
            })
            ->when($estado, function ($consulta, $estado) {
                return $consulta->where('estado', $estado);
            })
            ->get(); // Mantén get() o cambia a paginate(10) si la vista usa enlaces de paginación

        return view('admin.capacitaciones.index', compact('capacitaciones'));
    }

    public function create()
    {
        return view('admin.capacitaciones.create');
    }

    public function store(StoreCapacitacionRequest $request)
    {
        // Se usan únicamente los datos validados para cumplir las reglas del grupo
        Capacitacion::create($request->validated());

        return redirect()->route('admin.capacitaciones.index')
            ->with('status', 'Capacitación creada con éxito.');
    }

    public function edit(Capacitacion $capacitacion)
    {
        return view('admin.capacitaciones.edit', compact('capacitacion'));
    }

    public function update(StoreCapacitacionRequest $request, Capacitacion $capacitacion)
    {
        $capacitacion->update($request->validated());

        return redirect()->route('admin.capacitaciones.index')
            ->with('status', 'Capacitación actualizada con éxito.');
    }

    public function destroy(Capacitacion $capacitacion)
    {
        $capacitacion->delete();

        return redirect()->route('admin.capacitaciones.index')
            ->with('status', 'Capacitación personalizada eliminada.');
    }
}
