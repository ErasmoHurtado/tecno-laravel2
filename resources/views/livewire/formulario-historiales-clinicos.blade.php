<div>
    <!-- 🔹 BÚSQUEDA Y LISTA DE HISTORIALES CLÍNICOS -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Lista de Historiales Clínicos</h2>
            <x-input placeholder="Buscar por nombre..." class="w-1/3" wire:model.debounce.500ms="search" />
        </div>

        @if(count($historiales) > 0)
            <ul>
                @foreach ($historiales as $historial)
                    <li class="flex justify-between items-center p-2 border-b border-gray-200">
                        <span>
                            <strong>Paciente:</strong> {{ $historial->paciente->persona->nombre }}<br>
                            <strong>Diagnóstico Principal:</strong> {{ $historial->diagnostico_principal }}
                        </span>
                        <x-button wire:click="verConsultas({{ $historial->id }})">Ver Historial</x-button>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">No se encontraron historiales clínicos.</p>
        @endif
    </div>

    <!-- 🔹 CONSULTAS DEL HISTORIAL SELECCIONADO -->
    @if($mostrarConsultas)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Consultas del Historial</h2>
                <x-button wire:click="$set('mostrarConsultas', false)">Cerrar</x-button>
            </div>

            @if(count($consultas) > 0)
                <table class="w-full border mt-2">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2 text-left">Motivo</th>
                            <th class="p-2 text-left">Síntomas</th>
                            <th class="p-2 text-left">Diagnóstico</th>
                            <th class="p-2 text-left">Fecha</th>
                            <th class="p-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consultas as $consulta)
                            <tr class="border-b">
                                <td class="p-2">{{ $consulta->motivo }}</td>
                                <td class="p-2">{{ $consulta->sintomas }}</td>
                                <td class="p-2">{{ $consulta->diagnostico }}</td>
                                <td class="p-2">{{ $consulta->created_at->format('d/m/Y') }}</td>
                                <td class="p-2">
                                    <x-button wire:click="verDetalleConsulta({{ $consulta->id }})">
                                        Ver Detalle
                                    </x-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-600">No hay consultas registradas en este historial.</p>
            @endif
        </div>
    @endif

    <!-- 🔹 DETALLES DE LA CONSULTA SELECCIONADA -->
    @if($mostrarDetalleConsulta)
        <div class="bg-gray-200 dark:bg-gray-700 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Detalles de la Consulta</h2>
                <x-button wire:click="ocultarDetalleConsulta">Cerrar</x-button>
            </div>

            @if($consultaSeleccionada)
                <div class="mb-4">
                    <strong>Motivo:</strong> {{ $consultaSeleccionada->motivo }}<br>
                    <strong>Síntomas:</strong> {{ $consultaSeleccionada->sintomas }}<br>
                    <strong>Diagnóstico:</strong> {{ $consultaSeleccionada->diagnostico }}<br>
                    <strong>Estado:</strong> {{ $consultaSeleccionada->estado }}<br>
                    <strong>Fecha:</strong> {{ $consultaSeleccionada->created_at->format('d/m/Y') }}
                </div>

                <!-- Mostrar Tratamiento -->
                @if($tratamiento)
                    <div class="mb-4 bg-white p-4 rounded">
                        <h3 class="font-semibold">Tratamiento</h3>
                        <p><strong>Nombre:</strong> {{ $tratamiento->nombre }}</p>
                        <p><strong>Detalle:</strong> {{ $tratamiento->detalle }}</p>
                        <p><strong>Duración:</strong> {{ $tratamiento->duracion }}</p>
                        <p><strong>Tipo:</strong> {{ $tratamiento->tipo }}</p>
                    </div>
                @endif

                <!-- Mostrar Recetas -->
                @if(count($recetas) > 0)
                    <div class="mt-4">
                        <h3 class="font-semibold">Recetas</h3>
                        <table class="w-full border mt-2">
                            <thead>
                                <tr class="border-b">
                                    <th class="p-2 text-left">Remedio</th>
                                    <th class="p-2 text-left">Descripción</th>
                                    <th class="p-2 text-left">Indicaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recetas as $receta)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $receta->remedio }}</td>
                                        <td class="p-2">{{ $receta->descripcion }}</td>
                                        <td class="p-2">{{ $receta->indicaciones }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>
    @endif
</div>
