<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generar Reportes y Estadísticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Filtros -->
                <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
                    <div class="flex gap-4">
                        <select class="border-gray-300 rounded-md shadow-sm">
                            <option>Filtrar por Sector</option>
                        </select>
                        <select class="border-gray-300 rounded-md shadow-sm">
                            <option>Rango de Fechas</option>
                        </select>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Exportar Reporte (PDF/Excel)
                    </button>
                </div>

                <!-- Tabla de Emprendedores Activos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombres</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sectores</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estados</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($emprendedoresActivos as $emp)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $emp->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $emp->actividad_economica ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>