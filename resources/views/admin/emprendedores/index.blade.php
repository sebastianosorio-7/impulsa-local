<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Emprendedores</h2>
            <a href="{{ route('admin.emprendedores.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase rounded-md hover:bg-gray-700">
                Registrar emprendedor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.emprendedores.index') }}"
                class="mb-4 flex flex-wrap items-center gap-2">
                <input type="text" name="buscar" value="{{ $buscar }}"
                    placeholder="Buscar por nombre, documento o actividad"
                    class="w-full sm:w-80 border-gray-300 rounded-md shadow-sm text-sm">
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase rounded-md hover:bg-gray-700">
                    Buscar
                </button>
                @if ($buscar !== '')
                    <a href="{{ route('admin.emprendedores.index') }}"
                        class="text-sm text-gray-600 underline">Limpiar</a>
                @endif
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actividad</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ubicación</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requisitos</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($emprendedores as $e)
                            @php $activo = strtolower((string) $e->estado) === 'activo'; @endphp
                            <tr>
                                <td class="px-4 py-3">{{ $e->name }}<br><span
                                        class="text-xs text-gray-500">{{ $e->email }}</span></td>
                                <td class="px-4 py-3">{{ $e->documento }}</td>
                                <td class="px-4 py-3">{{ $e->actividad_economica }}</td>
                                <td class="px-4 py-3">{{ $e->ubicacion }}</td>
                                <td class="px-4 py-3">
                                    @if ($e->requisitos_verificados)
                                        <span class="text-green-700">Verificados</span>
                                    @else
                                        <span class="text-amber-600">Pendientes</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($activo)
                                        <span class="text-green-700">Activo</span>
                                    @else
                                        <span class="text-red-600">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="{{ route('admin.emprendedores.edit', $e) }}"
                                            class="text-indigo-600 underline">Editar</a>

                                        <form method="POST" action="{{ route('admin.emprendedores.estado', $e) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-gray-700 underline">
                                                {{ $activo ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.emprendedores.destroy', $e) }}"
                                            onsubmit="return confirm('¿Eliminar a este emprendedor? También se borrarán sus inscripciones.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 underline">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    @if ($buscar !== '')
                                        No se encontraron emprendedores con esa búsqueda.
                                    @else
                                        Aún no hay emprendedores registrados.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $emprendedores->links() }}</div>
        </div>
    </div>
</x-app-layout>
