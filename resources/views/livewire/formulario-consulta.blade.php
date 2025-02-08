<div>   
    @if ($mostrarFormulario)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
            <form wire:submit.prevent="save">
                <div class="mb-6">
                    <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> 
                        Formulario de Nueva Consulta
                    </label>
                </div>
                
                <!-- Motivo -->
                <div class="mb-4">
                    <x-label>Motivo</x-label>
                    <x-input class="w-full" wire:model="postCreate.motivo" />
                    <x-input-error for="postCreate.motivo" />
                </div>

                <!-- Síntomas -->
                <div class="mb-4">
                    <x-label>Síntomas</x-label>
                    <x-input class="w-full" wire:model="postCreate.sintomas" />
                    <x-input-error for="postCreate.sintomas" />
                </div>

                <!-- Diagnóstico -->
                <div class="mb-4">
                    <x-label>Diagnóstico</x-label>
                    <x-input class="w-full" wire:model="postCreate.diagnostico" />
                    <x-input-error for="postCreate.diagnostico" />
                </div>

                <!-- Tratamiento -->
                <div class="mb-4">
                    <x-label>Tratamiento</x-label>
                    <x-input placeholder="Nombre del tratamiento" class="w-full" wire:model="postCreate.tratamiento.nombre" />
                    <x-input placeholder="Detalle" class="w-full mt-2" wire:model="postCreate.tratamiento.detalle" />
                    <x-input placeholder="Duración" class="w-full mt-2" wire:model="postCreate.tratamiento.duracion" />
                    <x-input placeholder="Tipo" class="w-full mt-2" wire:model="postCreate.tratamiento.tipo" />
                </div>

                <!-- Recetas -->
                <div class="mb-4">
                    <x-label>Recetas</x-label>
                    <x-button wire:click.prevent="$set('mostrarModalReceta', true)">Añadir Receta</x-button>
                    
                    <!-- Tabla de recetas agregadas -->
                    <table class="w-full mt-4 border">
                        <thead>
                            <tr class="border-b">
                                <th class="p-2 text-left">Remedio</th>
                                <th class="p-2 text-left">Descripción</th>
                                <th class="p-2 text-left">Indicaciones</th>
                                <th class="p-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($postCreate['recetas'] as $index => $receta)
                                <tr class="border-b">
                                    <td class="p-2">{{ $receta['remedio'] }}</td>
                                    <td class="p-2">{{ $receta['descripcion'] }}</td>
                                    <td class="p-2">{{ $receta['indicaciones'] }}</td>
                                    <td class="p-2 text-center">
                                        <x-button wire:click="editarReceta({{ $index }})">Editar</x-button>
                                        <x-danger-button wire:click="confirmarEliminarReceta({{ $index }})">Eliminar</x-danger-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-4">
                    <x-button>Guardar Consulta</x-button>
                </div>
            </form>
        </div>
    @endif
    
    @if($mostrarHistorialClinico)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Historial Clínico del Paciente</h2>                
                <x-button wire:click="ocultarHistorialClinico">Cerrar</x-button>
            </div>

            @if($historialClinico)
                <div class="mb-4">
                    <strong>Diagnóstico Principal:</strong> {{ $historialClinico->diagnostico_principal }}<br>
                    <strong>Alergias:</strong> {{ $historialClinico->alergias }}<br>
                    <strong>Antecedentes Familiares:</strong> {{ $historialClinico->antecedentes_familiares }}<br>
                    <strong>Antecedentes Personales:</strong> {{ $historialClinico->antecedentes_personales }}<br>
                    <strong>Tratamientos Crónicos:</strong> {{ $historialClinico->tratamientos_cronicos }}<br>
                    <strong>Estado:</strong> {{ $historialClinico->estado }}
                </div>

                <!-- Mostrar Consultas Relacionadas -->
                @if(count($historialConsultas) > 0)
                    <div class="mt-4">
                        <h3 class="font-semibold">Consultas</h3>
                        <table class="w-full border mt-2">
                            <thead>
                                <tr class="border-b">
                                    <th class="p-2 text-left">Motivo</th>
                                    <th class="p-2 text-left">Síntomas</th>
                                    <th class="p-2 text-left">Diagnóstico</th>
                                    <th class="p-2 text-left">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historialConsultas as $consulta)
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
                    </div>
                @endif
            @else
                <p class="text-gray-600">No se encontró historial clínico para este paciente.</p>
            @endif
        </div>
    @endif


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


    <!-- MODALES PARA MANEJO DE RECETAS -->

    <!-- Modal para añadir receta -->
    <x-dialog-modal wire:model="mostrarModalReceta">
        <x-slot name="title">Añadir Receta</x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label>Remedio</x-label>
                <x-input class="w-full" wire:model="nuevaReceta.remedio" />
                <x-input-error for="nuevaReceta.remedio" />
            </div>
            <div class="mb-4">
                <x-label>Descripción</x-label>
                <x-textarea class="w-full" wire:model="nuevaReceta.descripcion"></x-textarea>
                <x-input-error for="nuevaReceta.descripcion" />
            </div>
            <div class="mb-4">
                <x-label>Indicaciones</x-label>
                <x-textarea class="w-full" wire:model="nuevaReceta.indicaciones"></x-textarea>
                <x-input-error for="nuevaReceta.indicaciones" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="$set('mostrarModalReceta', false)">Cancelar</x-danger-button>
            <x-button wire:click="agregarReceta">Guardar</x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal para editar receta -->
    <x-dialog-modal wire:model="mostrarModalEditarReceta">
        <x-slot name="title">Editar Receta</x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label>Remedio</x-label>
                <x-input class="w-full" wire:model="editarRecetaData.remedio" />
                <x-input-error for="editarRecetaData.remedio" />
            </div>
            <div class="mb-4">
                <x-label>Descripción</x-label>
                <x-textarea class="w-full" wire:model="editarRecetaData.descripcion"></x-textarea>
                <x-input-error for="editarRecetaData.descripcion" />
            </div>
            <div class="mb-4">
                <x-label>Indicaciones</x-label>
                <x-textarea class="w-full" wire:model="editarRecetaData.indicaciones"></x-textarea>
                <x-input-error for="editarRecetaData.indicaciones" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="$set('mostrarModalEditarReceta', false)">Cancelar</x-danger-button>
            <x-button wire:click="guardarEdicionReceta">Actualizar</x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal para eliminar receta -->
    <x-dialog-modal wire:model="mostrarModalEliminarReceta">
        <x-slot name="title">Eliminar Receta</x-slot>
        <x-slot name="content">
            <p>¿Está seguro de que desea eliminar esta receta?</p>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="$set('mostrarModalEliminarReceta', false)">Cancelar</x-danger-button>
            <x-button wire:click="eliminarRecetaConfirmada">Eliminar</x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- @can('Ver Lista de Fichas')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <ul>
            @foreach ($fichas as $ficha)
                <li class="flex justify-between items-center p-2 border-b border-gray-200">
                    <span>
                        Estado: {{ $ficha->estado }},
                        Recepcionista: {{ $ficha->recepcionista->nombre }},
                        Paciente: {{ $ficha->paciente->persona->nombre }},
                        Turno de Atención: {{ $ficha->turnoAtencion->horario }}
                    </span>
                    <div>
                        @can('Editar una Ficha')
                            <x-button wire:click="edit({{ $ficha->id }})">Editar</x-button>
                        @endcan
                        @can('Eliminar una Ficha')
                            <x-danger-button wire:click="destroy({{ $ficha->id }})">Eliminar</x-danger-button>
                        @endcan
                        @if($ficha->estado === 'Pagado en espera de atencion')
                            @can('Puede atender una ficha medica')
                                <x-button wire:click="atenderFicha({{ $ficha->id }})">Atender Ficha</x-button>
                            @endcan                        
                        @can('Puede ver el historial clinico de un paciente')
                            <x-button wire:click="verHistorialClinico({{ $ficha->paciente->id }})">Ver Historial Clínico del Paciente</x-button>
                        @endcan
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @endcan --}}

    @can('Ver Lista de Fichas')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Lista de Fichas</h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Estado</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Recepcionista</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Paciente</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Horario</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Hora Inicio</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Hora Fin</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Días de Servicio</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Cantidad de Fichas</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Precio</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Médico</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Especialidad</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fichas as $ficha)
                        <tr class="border border-gray-300 dark:border-gray-600">
                            <td class="p-2 text-center align-middle">{{ $ficha->estado }}</td>
                            <td class="p-2 text-center align-middle">
                                {{ $ficha->recepcionista->persona->nombre }}
                                {{ $ficha->recepcionista->persona->apellidoPaterno }}
                                {{ $ficha->recepcionista->persona->apellidoMaterno }}
                            </td>
                            <td class="p-2 text-center align-middle">
                                {{ $ficha->paciente->persona->nombre }}
                                {{ $ficha->paciente->persona->apellidoPaterno }}
                                {{ $ficha->paciente->persona->apellidoMaterno }}
                            </td>
                            <td class="p-2 text-center align-middle">{{ $ficha->turnoAtencion->horario }}</td>
                            <td class="p-2 text-center align-middle">{{ $ficha->turnoAtencion->hora_inicio }}</td>
                            <td class="p-2 text-center align-middle">{{ $ficha->turnoAtencion->hora_fin }}</td>
                            <td class="p-2 text-center align-middle">{{ implode(', ', $ficha->turnoAtencion->dias_servicio) }}</td>
                            <td class="p-2 text-center align-middle">{{ $ficha->turnoAtencion->cantidad_fichas }}</td>
                            <td class="p-2 text-center align-middle">{{ $ficha->turnoAtencion->precio }}</td>
                            <td class="p-2 text-center align-middle">
                                {{ $ficha->turnoAtencion->medicoEspecialidad->medico->persona->nombre }}
                                {{ $ficha->turnoAtencion->medicoEspecialidad->medico->persona->apellidoPaterno }}
                                {{ $ficha->turnoAtencion->medicoEspecialidad->medico->persona->apellidoMaterno }}
                            </td>
                            <td class="p-2 text-center align-middle">{{ $ficha->turnoAtencion->medicoEspecialidad->especialidad->nombre }}</td>
                            <td class="p-2 text-center align-middle">
                                @if($ficha->estado === 'Pagado en espera de atencion')
                                    @can('Puede atender una ficha medica')
                                        <x-button wire:click="atenderFicha({{ $ficha->id }})">Atender Ficha</x-button>
                                    @endcan                        
                                    @can('Puede ver el historial clinico de un paciente')
                                        <x-button wire:click="verHistorialClinico({{ $ficha->paciente->id }})">Ver Historial Clínico del Paciente</x-button>
                                    @endcan
                                @else
                                    <p>Ninguna</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcan

    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p><strong>CONTADOR DE PÁGINA CONSULTAS: {{ $contador }}</strong></p>
            <p>&copy; {{ date('Y') }} CLÍNICA "La Guardia SRL" - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>
</div>
