<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Capacitaciones Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Mensajes de alerta (Mariana) -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <!-- TU NUEVO BUSCADOR PARA EL EMPRENDEDOR -->
            <form method="GET" action="{{ route('capacitaciones.index') }}" class="mb-6 flex gap-2">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar capacitación por nombre o área..." 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md text-sm font-semibold transition-colors">
                    Buscar
                </button>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600 mb-6">Consulta los cursos disponibles para fortalecer tu emprendimiento.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($capacitaciones ?? [] as $curso)
                        <div class="border border-gray-200 rounded-lg p-5 shadow-sm bg-gray-50 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $curso->nombre }}</h3>
                                <p class="text-sm text-gray-600 mb-4">{{ $curso->descripcion ?? 'Sin descripción' }}</p>
                            </div>
                            <div class="border-t border-gray-200 pt-3 text-xs text-gray-500 space-y-1">
                                <p>📅 <strong>Fecha:</strong> {{ $curso->fecha }}</p>
                                <p>👥 <strong>Cupos restantes:</strong>
                                    <span class="text-sm font-semibold text-indigo-600">
                                        {{ $curso->cuposDisponibles() }}
                                    </span>
                                </p>

                                <!-- VALIDACIÓN DE CUPO LLENO EXIGIDA EN TU REPARTO -->
                                @if($curso->cuposDisponibles() <= 0)
                                    <button class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded shadow-sm opacity-60 cursor-not-allowed text-center text-sm" style="margin-top: 15px;" disabled>
                                        Cupo lleno
                                    </button>
                                @else
                                    <!-- Formulario de Inscripción (Mariana) -->
                                    <form action="{{ route('inscripciones.store') }}" method="POST" style="margin-top: 15px;">
                                        @csrf
                                        <input type="hidden" name="capacitacion_id" value="{{ $curso->id }}">

                                        <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 15px; border: none; border-radius: 5px; width: 100%; font-weight: bold; cursor: pointer;">
                                            Inscribirme
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            No se encontraron capacitaciones disponibles en este momento.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
