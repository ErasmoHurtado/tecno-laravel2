<div>
    @can('Añadir un Nuevo Turno de Atencion')
    <div class="flex justify mb-4">
        <x-button wire:click="toggleCreateForm"> + </x-button>
    </div>
    @if ($mostrarFormulario)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
            <form wire:submit="save">
                <div class="mb-6">
                    <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> Formulario de Nuevo Turno de Atención</label>
                </div>                
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Horario
                    </x-label>
                    <x-input class="w-full" wire:model="postCreate.horario" />
                    <x-input-error for="postCreate.horario" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Hora de Inicio
                    </x-label>
                    <x-input type="time" class="w-full" wire:model="postCreate.hora_inicio" />
                    <x-input-error for="postCreate.hora_inicio" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Hora de Fin
                    </x-label>
                    <x-input type="time" class="w-full" wire:model="postCreate.hora_fin" />
                    <x-input-error for="postCreate.hora_fin" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Días de Servicio
                    </x-label>
                    <div class="grid grid-cols-7 gap-2">
                        @foreach(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $dia)
                            <label>
                                <x-checkbox wire:model="postCreate.dias_servicio" value="{{ $dia }}" />
                                {{ ucfirst($dia) }}
                            </label>
                        @endforeach
                    </div>
                    <x-input-error for="postCreate.dias_servicio" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Cantidad de Fichas
                    </x-label>
                    <x-input type="number" class="w-full" wire:model="postCreate.cantidad_fichas" />
                    <x-input-error for="postCreate.cantidad_fichas" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Precio
                    </x-label>
                    <x-input type="number" step="0.01" class="w-full" wire:model="postCreate.precio" />
                    <x-input-error for="postCreate.precio" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Médico Especialidad
                    </x-label>
                    <x-select class="w-full" wire:model="postCreate.medico_especialidad_id">
                        <option value="" disabled>Seleccione una Especialidad Médica</option>
                        @foreach ($medicoEspecialidades as $medicoEspecialidad)
                            <option value="{{ $medicoEspecialidad->id }}">{{ $medicoEspecialidad->medico->persona->nombre }} {{ $medicoEspecialidad->medico->persona->apellidopaterno }} {{ $medicoEspecialidad->medico->persona->apellidomaterno }} -- {{ $medicoEspecialidad->especialidad->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.medico_especialidad_id" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Sala
                    </x-label>
                    <x-select class="w-full" wire:model="postCreate.sala_id">
                        <option value="" disabled>Seleccione una Sala</option>
                        @foreach ($salas as $sala)
                            <option value="{{ $sala->id }}">Sala:  {{ $sala->codigo }} -- Tipo: {{ $sala->tipo }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.sala_id" />
                </div>
                <div class="flex justify-end mt-4">
                    <x-button>Crear</x-button>
                </div>
            </form>
        </div>
    @endif
    @endcan

    {{-- @can('Ver Lista de Turnos de Atencion')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <ul>
            @foreach ($turnosAtencion as $turnoAtencion)
                <li class="flex justify-between items-center p-2 border-b border-gray-200">
                    <span>
                        Horario: {{ $turnoAtencion->horario }},
                        Hora Inicio: {{ $turnoAtencion->hora_inicio }},
                        Hora Fin: {{ $turnoAtencion->hora_fin }},
                        Días: {{ implode(', ', $turnoAtencion->dias_servicio) }},
                        Fichas: {{ $turnoAtencion->cantidad_fichas }},
                        Precio: ${{ $turnoAtencion->precio }},
                        Médico Especialidad: {{ $turnoAtencion->medicoEspecialidad->titulo_especialidad }},
                        Sala: {{ $turnoAtencion->sala->codigo }}
                    </span>
                    <div>
                        @can('Editar un Turno de Atencion')
                            <x-button wire:click="edit({{ $turnoAtencion->id }})">Editar</x-button>
                        @endcan
                        @can('Eliminar un Turno de Atencion')
                            <x-danger-button wire:click="destroy({{ $turnoAtencion->id }})">Eliminar</x-danger-button>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @endcan --}}

    @can('Ver Lista de Turnos de Atención')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Lista de Turnos de Atención</h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Médico</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Especialidad</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Horario</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Hora Inicio</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Hora Fin</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Días de Servicio</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Cantidad de Fichas</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Precio</th>
                        <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($turnosAtencion as $turnoAtencion)
                        <tr class="border border-gray-300 dark:border-gray-600">
                            <td class="p-2 text-center align-middle">
                                {{ $turnoAtencion->medicoEspecialidad->medico->persona->nombre }}
                                {{ $turnoAtencion->medicoEspecialidad->medico->persona->apellidoPaterno }}
                                {{ $turnoAtencion->medicoEspecialidad->medico->persona->apellidoMaterno }}
                            </td>
                            <td class="p-2 text-center align-middle">{{ $turnoAtencion->medicoEspecialidad->especialidad->nombre }}</td>
                            <td class="p-2 text-center align-middle">{{ $turnoAtencion->horario }}</td>
                            <td class="p-2 text-center align-middle">{{ $turnoAtencion->hora_inicio }}</td>
                            <td class="p-2 text-center align-middle">{{ $turnoAtencion->hora_fin }}</td>
                            <td class="p-2 text-center align-middle">{{ implode(', ', $turnoAtencion->dias_servicio) }}</td>
                            <td class="p-2 text-center align-middle">{{ $turnoAtencion->cantidad_fichas }}</td>
                            <td class="p-2 text-center align-middle">{{ $turnoAtencion->precio }}</td>
                            <td class="p-2 text-center align-middle">
                                @can('Editar un Turno de Atención')
                                    <x-button wire:click="edit({{ $turnoAtencion->id }})">Editar</x-button>
                                @endcan
                                @can('Eliminar un Turno de Atención')
                                    <x-danger-button wire:click="destroy({{ $turnoAtencion->id }})">Eliminar</x-danger-button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcan



    <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Turno de Atención
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Horario
                    </x-label>
                    <x-input class="w-full" wire:model="postEdit.horario" />
                    <x-input-error for="postEdit.horario" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Hora de Inicio
                    </x-label>
                    <x-input type="time" class="w-full" wire:model="postEdit.hora_inicio" />
                    <x-input-error for="postEdit.hora_inicio" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Hora de Fin
                    </x-label>
                    <x-input type="time" class="w-full" wire:model="postEdit.hora_fin" />
                    <x-input-error for="postEdit.hora_fin" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Días de Servicio
                    </x-label>
                    <div class="grid grid-cols-7 gap-2">
                        @foreach(['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'] as $dia)
                            <label>
                                <x-checkbox wire:model="postEdit.dias_servicio" value="{{ $dia }}" />
                                {{ ucfirst($dia) }}
                            </label>
                        @endforeach
                    </div>
                    <x-input-error for="postEdit.dias_servicio" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Cantidad de Fichas
                    </x-label>
                    <x-input type="number" class="w-full" wire:model="postEdit.cantidad_fichas" />
                    <x-input-error for="postEdit.cantidad_fichas" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Precio
                    </x-label>
                    <x-input type="number" step="0.01" class="w-full" wire:model="postEdit.precio" />
                    <x-input-error for="postEdit.precio" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Médico Especialidad
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.medico_especialidad_id">
                        @foreach ($medicoEspecialidades as $medicoEspecialidad)
                            <option value="{{ $medicoEspecialidad->id }}">{{ $medicoEspecialidad->titulo_especialidad }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.medico_especialidad_id" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Sala
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.sala_id">
                        @foreach ($salas as $sala)
                            <option value="{{ $sala->id }}">Sala {{ $sala->codigo }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.sala_id" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button class="mr-2" wire:click="$set('open', false)">
                        Cancelar
                    </x-danger-button>
                    <x-button>
                        Actualizar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
        {{-- Modal de Creación de Turno de Atención --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacion">
        <x-slot name="title">
            Creación de Turno de Atención
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nuevo Turno de Atención creado satisfactoriamente.
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessCreacion', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Actualización de Turno de Atención --}}
    <x-dialog-modal wire:model="mostrarModalSucessEdit">
        <x-slot name="title">
            Actualización de Turno de Atención
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Turno de Atención actualizado satisfactoriamente.
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalSucessEdit', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Eliminación de Turno de Atención --}}
    <x-dialog-modal wire:model="mostrarModalEliminacion">
        <x-slot name="title">
            Eliminación de Turno de Atención
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Turno de Atención eliminado satisfactoriamente.
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button class="mr-2" wire:click="$set('mostrarModalEliminacion', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
    </form>

    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p><strong>CONTADOR DE PÁGINA TURNOS DE ATENCIÓN: {{ $contador }}</strong></p>
            <p>&copy; {{ date('Y') }} CLÍNICA "La Guardia SRL" - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>
</div>

