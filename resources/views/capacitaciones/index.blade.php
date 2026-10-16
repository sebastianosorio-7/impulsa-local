<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Capacitaciones Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Mensajes de alerta -->
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($capacitaciones ?? [] as $capacitacion)
                            <div class="border p-4 rounded-lg shadow-sm">
                                <h4 class="font-bold text-lg">{{ $capacitacion->nombre }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $capacitacion->descripcion ?? 'Sin descripción' }}</p>
                                <p class="text-sm mt-2"><strong>Cupo máximo:</strong> {{ $capacitacion->cupo }}</p>
                                
                               <!-- Formulario de Inscripción -->
<form action="{{ route('inscripciones.store') }}" method="POST" style="margin-top: 15px;">
    @csrf
    <input type="hidden" name="capacitacion_id" value="{{ $capacitacion->id }}">
    
    <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 15px; border: none; border-radius: 5px; width: 100%; font-weight: bold; cursor: pointer;">
        Inscribirme
    </button>
</form>
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
    </div>
</x-app-layout>
