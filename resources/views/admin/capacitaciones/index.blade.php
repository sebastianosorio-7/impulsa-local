
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestionar Capacitaciones (Administrador)') }}
            </h2>
            <a href="{{ route('admin.capacitaciones.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Nueva capacitación
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('status') }}
                </div>
            @endif

            <!-- BUSCADOR Y FILTRO DE ESTADO -->
            <form method="GET"
                action="{{ route('admin.capacitaciones.index') }}"
                class="mb-6 flex flex-col md:flex-row gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">

                <!-- Buscador por texto -->
                <div class="flex-1 flex gap-2">
                    <input type="text"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Buscar capacitación por nombre o área..."
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    
                    <!-- Botón Buscar -->
                    <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-md font-bold text-sm border border-indigo-700 shadow-md cursor-pointer"
                        style="background-color: #4F46E5 !important; color: #FFFFFF !important; border: 1px solid #3730A3; padding: 10px 24px; border-radius: 6px; font-size: 14px; font-weight: bold; min-width: 90px; cursor: pointer; display: inline-block;">
                        Buscar
                    </button>
                </div>

                <!-- FILTRO AUTOMÁTICO  -->
                <div class="w-full md:w-48">

                    <select name="estado"
                        onchange="this.form.submit()"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-gray-700">

                        <option value="" {{ request('estado') == '' ? 'selected' : '' }}>
                            Todos los estados
                        </option>

                        <option value="abierta" {{ request('estado') == 'abierta' ? 'selected' : '' }}>
                            Abierta
                        </option>

                        <option value="cerrada" {{ request('estado') == 'cerrada' ? 'selected' : '' }}>
                            Cerrada
                        </option>

                    </select>
                </div>

    
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition-colors">
                        Filtrar
                    </button>

                    <a href="{{ route('admin.capacitaciones.index') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md text-sm font-semibold text-center flex items-center transition-colors">
                        Limpiar
                    </a>
                </div>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Área</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha / Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cupos Totales</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($capacitaciones as $curso)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $curso->nombre }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $curso->area }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $curso->fecha }} a las {{ substr($curso->hora, 0, 5) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $curso->cupo }}
                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $curso->estado == 'abierta' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($curso->estado ?? 'abierta') }}
                                        </span>
                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.capacitaciones.edit', $curso->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.capacitaciones.destroy', $curso->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('¿Seguro que deseas eliminar este curso?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No se encontraron capacitaciones con los criterios de búsqueda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
