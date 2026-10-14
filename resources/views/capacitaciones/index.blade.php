<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Capacitaciones Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600 mb-6">Consulta los cursos disponibles para fortalecer tu emprendimiento.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($capacitaciones as $curso)
                        <div class="border border-gray-200 rounded-lg p-5 shadow-sm bg-gray-50 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $curso->nombre }}</h3>
                                <p class="text-sm text-gray-600 mb-4">{{ $curso->descripcion }}</p>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-3 text-xs text-gray-500 space-y-1">
                                <p>📅 <strong>Fecha:</strong> {{ $curso->fecha }}</p>
                                <p>👥 <strong>Cupos restantes:</strong> <span class="text-sm font-semibold text-indigo-600">{{ $curso->cupo }}</span></p>
                            </div>
                            <!-- Mariana incrustará aquí su formulario de inscripción del CU07 -->
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            No hay capacitaciones programadas por el momento.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
