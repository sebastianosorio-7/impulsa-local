<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmprendedorRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmprendedorController extends Controller
{
    public function index()
    {
        $emprendedores = User::where('rol', 'emprendedor')
            ->latest()
            ->paginate(10);

        return view('admin.emprendedores.index', compact('emprendedores'));
    }

    public function create()
    {
        return view('admin.emprendedores.create');
    }

    public function store(StoreEmprendedorRequest $request)
    {
        $datos = $request->validated();

        User::create([
            'name'                   => $datos['name'],
            'documento'              => $datos['documento'],
            'email'                  => $datos['email'],
            'telefono'               => $datos['telefono'],
            'actividad_economica'    => $datos['actividad_economica'],
            'ubicacion'              => $datos['ubicacion'],
            'password'               => Hash::make($datos['password']),
            'rol'                    => 'emprendedor',   // fijo: nunca viene del formulario
            'estado'                 => 'activo',
            'requisitos_verificados' => $request->boolean('requisitos_verificados'),
        ]);

        return redirect()
            ->route('admin.emprendedores.index')
            ->with('status', 'Emprendedor registrado correctamente.');
    }
}