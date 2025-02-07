<div>
    @can('Añadir una Nueva Asignacion de Especialidad Medica')
    <div class="flex justify mb-4">
        <x-button wire:click="toggleCreateForm"> + </x-button>
    </div>
    @if ($mostrarFormulario)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
            <form wire:submit="save">
                <div class="mb-6">
                    <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> Formulario de Nueva Especialidad Médica</label>
                </div>                
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Médico
                    </x-label>
                    <x-select class="w-full" wire:model="postCreate.id_medico">
                        <option value="" disabled>Seleccione un Médico</option>
                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}">{{ $medico->persona->nombre }} {{ $medico->persona->apellido }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.id_medico" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Especialidad
                    </x-label>
                    <x-select class="w-full" wire:model="postCreate.id_especialidad">
                        <option value="" disabled>Seleccione una Especialidad</option>
                        @foreach ($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.id_especialidad" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Título Especialidad
                    </x-label>
                    <x-input class="w-full" wire:model="postCreate.titulo_especialidad" />
                    <x-input-error for="postCreate.titulo_especialidad" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Origen Especialidad
                    </x-label>
                    <x-input class="w-full" wire:model="postCreate.origen_especialidad" />
                    <x-input-error for="postCreate.origen_especialidad" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Año Especialidad
                    </x-label>
                    <x-input type="number" class="w-full" wire:model="postCreate.ano_especialidad" />
                    <x-input-error for="postCreate.ano_especialidad" />
                </div>
                <div class="flex justify-end mt-4">
                    <x-button>Crear</x-button>
                </div>
            </form>
        </div>
    @endif
    @endcan

    @can('Ver Lista de Asignaciones de Especialidades Medicas')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <ul>
            @foreach ($medicoEspecialidades as $medicoEspecialidad)
                <li class="flex justify-between items-center p-2 border-b border-gray-200">
                    <span>
                        Médico: {{ $medicoEspecialidad->medico->persona->nombre }} {{ $medicoEspecialidad->medico->persona->apellido }}, 
                        Especialidad: {{ $medicoEspecialidad->especialidad->nombre }}
                    </span>
                    <div>
                        @can('Editar una asignacion de Especialidad Medica')
                            <x-button wire:click="edit({{ $medicoEspecialidad->id }})">Editar</x-button>
                        @endcan
                        @can('Eliminar una asignacion de Especialidad Medica')
                            <x-danger-button wire:click="destroy({{ $medicoEspecialidad->id }})">Eliminar</x-danger-button>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @endcan

    <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Especialidad Médica
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Médico
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.id_medico">
                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}">{{ $medico->persona->nombre }} {{ $medico->persona->apellido }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.id_medico" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Especialidad
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.id_especialidad">
                        @foreach ($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.id_especialidad" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Título Especialidad
                    </x-label>
                    <x-input class="w-full" wire:model="postEdit.titulo_especialidad" />
                    <x-input-error for="postEdit.titulo_especialidad" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Origen Especialidad
                    </x-label>
                    <x-input class="w-full" wire:model="postEdit.origen_especialidad" />
                    <x-input-error for="postEdit.origen_especialidad" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Año Especialidad
                    </x-label>
                    <x-input type="number" class="w-full" wire:model="postEdit.ano_especialidad" />
                    <x-input-error for="postEdit.ano_especialidad" />
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
        {{-- Modal de Creación de Especialidad Médica --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacion">
        <x-slot name="title">
            Creación de Especialidad Médica
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nueva Especialidad Médica creada satisfactoriamente.
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

    {{-- Modal de Actualización de Especialidad Médica --}}
    <x-dialog-modal wire:model="mostrarModalSucessEdit">
        <x-slot name="title">
            Actualización de Especialidad Médica
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Especialidad Médica actualizada satisfactoriamente.
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

    {{-- Modal de Eliminación de Especialidad Médica --}}
    <x-dialog-modal wire:model="mostrarModalEliminacion">
        <x-slot name="title">
            Eliminación de Especialidad Médica
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Especialidad Médica eliminada satisfactoriamente.
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
            <p><strong>CONTADOR DE PÁGINA ESPECIALIDADES MÉDICAS: {{ $contador }}</strong></p>
            <p>&copy; {{ date('Y') }} CLÍNICA "La Guardia SRL" - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>
</div>

