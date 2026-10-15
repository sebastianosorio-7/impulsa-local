<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Seguimiento del progreso</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc ms-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Emprendedor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capacitación
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Avance</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actualizar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($inscripciones as $inscripcion)
                            <tr>
                                <td class="px-4 py-3">{{ $inscripcion->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $inscripcion->capacitacion->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $inscripcion->estado }}</td>
                                <td class="px-4 py-3">{{ $inscripcion->progreso }}%</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.progreso.update', $inscripcion) }}"
                                        class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')

                                        <select name="estado"
                                            class="border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            @foreach (['Inscrito', 'En curso', 'Finalizado'] as $opcion)
                                                <option value="{{ $opcion }}" @selected(strtolower($inscripcion->estado) === strtolower($opcion))>
                                                    {{ $opcion }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="number" name="progreso" min="0" max="100"
                                            value="{{ $inscripcion->progreso }}"
                                            class="w-20 border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">

                                        <button type="submit"
                                            class="px-3 py-2 bg-gray-800 text-white text-xs font-semibold uppercase rounded-md hover:bg-gray-700">
                                            Guardar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    Aún no hay inscripciones para dar seguimiento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
