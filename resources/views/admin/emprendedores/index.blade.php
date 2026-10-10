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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actividad</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ubicación</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requisitos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($emprendedores as $e)
                            <tr>
                                <td class="px-4 py-3">{{ $e->name }}<br><span class="text-xs text-gray-500">{{ $e->email }}</span></td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    Aún no hay emprendedores registrados.
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