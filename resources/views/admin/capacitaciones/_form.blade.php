@php
    $c = $capacitacion ?? null;
@endphp

<div class="space-y-4">
    <div>
        <x-input-label for="nombre" value="Nombre de la capacitación" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $c?->nombre)" required autofocus />
        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="area" value="Área" />
        <x-text-input id="area" name="area" type="text" class="mt-1 block w-full" :value="old('area', $c?->area)" required />
        <x-input-error :messages="$errors->get('area')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="descripcion" value="Descripción" />
        <textarea id="descripcion" name="descripcion" rows="3" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $c?->descripcion) }}</textarea>
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="requisitos" value="Requisitos (opcional)" />
        <textarea id="requisitos" name="requisitos" rows="2"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('requisitos', $c?->requisitos) }}</textarea>
        <x-input-error :messages="$errors->get('requisitos')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="fecha" value="Fecha" />
            <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full" :value="old('fecha', $c?->fecha)" required />
            <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="hora" value="Hora" />
            <x-text-input id="hora" name="hora" type="time" class="mt-1 block w-full" :value="old('hora', $c ? substr($c->hora, 0, 5) : null)" required />
            <x-input-error :messages="$errors->get('hora')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="cupo" value="Cupo" />
            <x-text-input id="cupo" name="cupo" type="number" min="1" class="mt-1 block w-full" :value="old('cupo', $c?->cupo)" required />
            <x-input-error :messages="$errors->get('cupo')" class="mt-2" />
        </div>
    </div>
</div>
