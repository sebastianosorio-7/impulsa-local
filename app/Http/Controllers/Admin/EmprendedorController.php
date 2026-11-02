<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmprendedorRequest;
use App\Http\Requests\Admin\UpdateEmprendedorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmprendedorController extends Controller
{
    public function index(Request $request)
    {
        $buscar = trim((string) $request->query('buscar'));

        $emprendedores = User::where('rol', 'emprendedor')
            ->when($buscar !== '', function ($consulta) use ($buscar) {
                $consulta->where(function ($q) use ($buscar) {
                    $q->where('name', 'like', "%{$buscar}%")
                        ->orWhere('documento', 'like', "%{$buscar}%")
                        ->orWhere('actividad_economica', 'like', "%{$buscar}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.emprendedores.index', compact('emprendedores', 'buscar'));
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

    public function edit(User $emprendedor)
    {
        $this->soloEmprendedor($emprendedor);

        return view('admin.emprendedores.edit', compact('emprendedor'));
    }

    public function update(UpdateEmprendedorRequest $request, User $emprendedor)
    {
        $this->soloEmprendedor($emprendedor);

        $datos = $request->validated();

        $emprendedor->update([
            'name'                   => $datos['name'],
            'documento'              => $datos['documento'],
            'email'                  => $datos['email'],
            'telefono'               => $datos['telefono'],
            'actividad_economica'    => $datos['actividad_economica'],
            'ubicacion'              => $datos['ubicacion'],
            'requisitos_verificados' => $request->boolean('requisitos_verificados'),
        ]);

        // La contraseña solo cambia si se escribió una nueva
        if (! empty($datos['password'])) {
            $emprendedor->update(['password' => Hash::make($datos['password'])]);
        }

        return redirect()
            ->route('admin.emprendedores.index')
            ->with('status', 'Emprendedor actualizado correctamente.');
    }

    public function cambiarEstado(User $emprendedor)
    {
        $this->soloEmprendedor($emprendedor);

        $estaActivo = strtolower((string) $emprendedor->estado) === 'activo';
        $emprendedor->update(['estado' => $estaActivo ? 'inactivo' : 'activo']);

        return redirect()
            ->route('admin.emprendedores.index')
            ->with('status', $estaActivo ? 'Emprendedor desactivado.' : 'Emprendedor activado.');
    }

    public function destroy(User $emprendedor)
    {
        $this->soloEmprendedor($emprendedor);

        // Sus inscripciones se borran en cascada (clave foránea)
        $emprendedor->delete();

        return redirect()
            ->route('admin.emprendedores.index')
            ->with('status', 'Emprendedor eliminado correctamente.');
    }

    // Estas acciones solo aplican a usuarios con rol emprendedor
    private function soloEmprendedor(User $usuario): void
    {
        abort_unless($usuario->rol === 'emprendedor', 404);
    }
}
