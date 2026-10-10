<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar emprendedor</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.emprendedores.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nombre completo" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="documento" value="Documento de identidad" />
                        <x-text-input id="documento" name="documento" type="text" class="mt-1 block w-full" :value="old('documento')" required />
                        <x-input-error :messages="$errors->get('documento')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Correo electrónico" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="telefono" value="Teléfono" />
                        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono')" required />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="actividad_economica" value="Actividad económica" />
                        <x-text-input id="actividad_economica" name="actividad_economica" type="text" class="mt-1 block w-full" :value="old('actividad_economica')" required />
                        <x-input-error :messages="$errors->get('actividad_economica')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="ubicacion" value="Ubicación" />
                        <x-text-input id="ubicacion" name="ubicacion" type="text" class="mt-1 block w-full" :value="old('ubicacion')" required />
                        <x-input-error :messages="$errors->get('ubicacion')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Contraseña inicial" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Confirmar contraseña" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                    </div>

                    <div class="flex items-center">
                        <input id="requisitos_verificados" name="requisitos_verificados" type="checkbox" value="1"
                               class="rounded border-gray-300" @checked(old('requisitos_verificados'))>
                        <label for="requisitos_verificados" class="ms-2 text-sm text-gray-700">
                            Los requisitos del programa fueron verificados
                        </label>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Registrar</x-primary-button>
                        <a href="{{ route('admin.emprendedores.index') }}" class="text-sm text-gray-600 underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>