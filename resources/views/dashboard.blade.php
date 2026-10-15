<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel principal
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">Hola, {{ $user->name }}</h3>
                <p class="text-gray-600 mt-1">
                    @if ($user->rol === 'administrador')
                        Desde aquí puedes administrar el programa Impulsa Local.
                    @else
                        Bienvenido al programa Impulsa Local de la Alcaldía de Ciudad Nueva.
                    @endif
                </p>
            </div>

            @if ($user->rol === 'administrador')
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-sm text-gray-500">Emprendedores</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $resumen['emprendedores'] }}</p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-sm text-gray-500">Capacitaciones</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $resumen['capacitaciones'] }}</p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-sm text-gray-500">Inscripciones</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $resumen['inscripciones'] }}</p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-sm text-gray-500">Cursos finalizados</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $resumen['finalizadas'] }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Accesos rápidos</h4>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.emprendedores.create') }}"
                           class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">Registrar emprendedor</a>
                        <a href="{{ route('admin.capacitaciones.index') }}"
                           class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">Gestionar capacitaciones</a>
                        <a href="{{ route('admin.progreso.index') }}"
                           class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">Actualizar progreso</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-sm text-gray-500">Mis inscripciones</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $resumen['inscripciones'] }}</p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-sm text-gray-500">Cursos finalizados</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $resumen['finalizadas'] }}</p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-5">
                        <p class="text-sm text-gray-500">Capacitaciones disponibles</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $resumen['disponibles'] }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Accesos rápidos</h4>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('capacitaciones.index') }}"
                           class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">Ver capacitaciones</a>
                        <a href="{{ route('inscripciones.index') }}"
                           class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">Mis inscripciones</a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>