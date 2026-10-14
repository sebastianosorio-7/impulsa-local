<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capacitacion;
use App\Http\Requests\Admin\StoreCapacitacionRequest;

class CapacitacionController extends Controller
{
    public function index()
    {
        $capacitaciones = Capacitacion::all();
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
