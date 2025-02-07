<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Historial de Consultas</h2>        
    </div>

    @if(count($consultas) > 0)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <ul>
                @foreach ($consultas as $consulta)
                    <li class="flex justify-between items-center p-2 border-b border-gray-200">
                        <span>
                            <strong>Motivo:</strong> {{ $consulta->motivo }}<br>
                            <strong>Síntomas:</strong> {{ $consulta->sintomas }}<br>
                            <strong>Diagnóstico:</strong> {{ $consulta->diagnostico }}<br>
                            <strong>Fecha:</strong> {{ $consulta->created_at->format('d/m/Y') }}
                        </span>
                        <x-button wire:click="verDetalle({{ $consulta->id }})">Ver Detalles</x-button>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <p class="text-gray-600">No se encontraron consultas en su historial clínico.</p>
    @endif
    <x-dialog-modal wire:model="mostrarModalDetalle">
        <x-slot name="title">
            Detalles de la Consulta
        </x-slot>
    
        <x-slot name="content">
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
                    <div class="mb-4 bg-gray-200 dark:bg-gray-700 p-4 rounded">
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
        </x-slot>
    
        <x-slot name="footer">
            <x-button wire:click="$set('mostrarModalDetalle', false)">Cerrar</x-button>
        </x-slot>
    </x-dialog-modal>
    
</div>


