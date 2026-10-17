<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generar Reportes y Estadísticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Resumen -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Emprendedores{{ $sector ? ' (filtrados)' : '' }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $emprendedores->count() }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Emprendedores activos</p>
                    <p class="text-3xl font-bold text-green-700">{{ $totalActivos }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Inscripciones totales</p>
                    <p class="text-3xl font-bold text-indigo-700">{{ $totalInscripciones }}</p>
                </div>
            </div>

            <!-- Sectores y cursos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Sectores más comunes</h3>
                    @php $maxSector = max(1, (int) ($sectores->max('total') ?? 1)); @endphp
                    @forelse($sectores as $s)
                        <div class="mb-3">
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>{{ $s->actividad_economica ?: 'Sin especificar' }}</span>
                                <span class="font-semibold">{{ $s->total }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded h-2">
                                <div class="bg-indigo-500 h-2 rounded"
                                    style="width: {{ ($s->total / $maxSector) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aún no hay emprendedores registrados.</p>
                    @endforelse
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Cursos más solicitados</h3>
                    @php $maxCurso = max(1, (int) ($cursosSolicitados->max('total') ?? 1)); @endphp
                    @forelse($cursosSolicitados as $c)
                        <div class="mb-3">
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>{{ $c->nombre }}</span>
                                <span class="font-semibold">{{ $c->total }} inscritos</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded h-2">
                                <div class="bg-green-500 h-2 rounded"
                                    style="width: {{ ($c->total / $maxCurso) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aún no hay inscripciones.</p>
                    @endforelse
                </div>
            </div>

            <!-- Listado de emprendedores con filtro por sector -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('admin.reportes.index') }}"
                    class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
                    <select name="sector" class="border-gray-300 rounded-md shadow-sm">
                        <option value="">Todos los sectores</option>
                        @foreach ($sectores->whereNotNull('actividad_economica') as $s)
                            <option value="{{ $s->actividad_economica }}" @selected($sector === $s->actividad_economica)>
                                {{ $s->actividad_economica }}
                            </option>
                        @endforeach
                    </select>
                    <x-primary-button>Filtrar</x-primary-button>
                    @if ($sector)
                        <a href="{{ route('admin.reportes.index') }}" class="text-sm text-gray-600 underline">Quitar
                            filtro</a>
                    @endif
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombres</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sector</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($emprendedores as $emp)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $emp->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $emp->actividad_economica ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if (strtolower((string) $emp->estado) === 'activo')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-700">{{ $emp->estado ?: 'Sin estado' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay emprendedores
                                        para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
