<div>
    @can('Añadir un Nuevo Recepcionista')
    <div class="flex justify mb-4">
        <x-button wire:click="toggleCreateForm">                
            +
        </x-button>
    </div>        
    @if ($mostrarFormulario)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <form wire:submit="save">
            <div class="flex justify-center items-center h-32">
                <label class="text-4xl font-extrabold text-gray-800 dark:text-gray-200">
                    Formulario para crear un nuevo/a recepcionista
                </label>
            </div>
            <div class="mb-6">
                <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> Informacion Personal: </label>
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nombre
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.nombre" />
                <x-input-error for="postCreate.nombre" />
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Apellido Paterno
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.apellidopaterno" />
                <x-input-error for="postCreate.apellidopaterno" />
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Apellido Materno
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.apellidomaterno" />
                <x-input-error for="postCreate.apellidomaterno" />
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Sexo
                </x-label>
                <select class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.sexo">
                    <option value="">Seleccione su sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                <x-input-error for="postCreate.sexo" />
            </div>    
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Carnet de Identidad
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.ci" />
                <x-input-error for="postCreate.ci" />
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Teléfono
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.telefono" />
                <x-input-error for="postCreate.telefono" />
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Dirección
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.direccion" />
                <x-input-error for="postCreate.direccion" />
            </div>
            <div class="mb-6">
                <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> Informacion de la Recepcionista: </label>
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Turno de Trabajo
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.turno_trabajo" />
                <x-input-error for="postCreate.turno_trabajo" />
            </div>            
            <div class="mb-8">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Fecha de Contratación
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    type="date" wire:model="postCreate.fecha_contratacion" />
                <x-input-error for="postCreate.fecha_contratacion" />
            </div>
            <div class="mb-6">
                <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> Login de Acceso al sistema: </label>
            </div>            
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Correo Electrónico
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.email" />
                <x-input-error for="postCreate.email" />
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Contraseña
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    type="password" wire:model="postCreate.password" />
                <x-input-error for="postCreate.password" />
            </div>
            <div class="flex justify-end">
                <x-button>
                    Crear
                </x-button>
            </div>            
        </form>
    </div>
    @endif
    @endcan  

    

    @can('Ver Lista de Recepcionistas')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Lista de Recepcionistas</h2>

        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">CI</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Nombre</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Apellido Paterno</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Apellido Materno</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Teléfono</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Dirección</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Turno de Trabajo</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Fecha de Contratación</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recepcionistas as $recepcionista)
                    <tr class="border border-gray-300 dark:border-gray-600">
                        <td class="p-2 text-center align-middle">{{ $recepcionista->persona->ci }}</td>
                        <td class="p-2 text-center align-middle">{{ $recepcionista->persona->nombre }}</td>
                        <td class="p-2 text-center align-middle">{{ $recepcionista->persona->apellidopaterno }}</td>
                        <td class="p-2 text-center align-middle">{{ $recepcionista->persona->apellidomaterno }}</td>
                        <td class="p-2 text-center align-middle">{{ $recepcionista->persona->telefono }}</td>
                        <td class="p-2 text-center align-middle">{{ $recepcionista->persona->direccion }}</td>
                        <td class="p-2 text-center align-middle">{{ $recepcionista->turno_trabajo }}</td>
                        <td class="p-2 text-center align-middle">{{ $recepcionista->fecha_contratacion }}</td>
                        <td class="p-2 text-center align-middle">
                            @can('Editar Recepcionista')
                                <x-button wire:click="edit({{ $recepcionista->id }})">Editar</x-button>
                            @endcan
                            @can('Eliminar Recepcionista')
                                <x-danger-button wire:click="destroy({{ $recepcionista->id }})">Eliminar</x-danger-button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endcan





    <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Recepcionista
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nombre
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.nombre" />
                    <x-input-error for="postEdit.nombre" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Apellido Paterno
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.apellidopaterno" />
                    <x-input-error for="postEdit.apellidopaterno" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Apellido Materno
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.apellidomaterno" />
                    <x-input-error for="postEdit.apellidomaterno" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Sexo
                    </x-label>
                    <select class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.sexo">
                        <option value="">Seleccione su sexo</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <x-input-error for="postEdit.sexo" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Carnet de Identidad
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.ci" />
                    <x-input-error for="postEdit.ci" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Teléfono
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.telefono" />
                    <x-input-error for="postEdit.telefono" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Dirección
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.direccion" />
                    <x-input-error for="postEdit.direccion" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Turno de Trabajo
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.turno_trabajo" />
                    <x-input-error for="postEdit.turno_trabajo" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Fecha de Contratación
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        type="date" wire:model="postEdit.fecha_contratacion" />
                    <x-input-error for="postEdit.fecha_contratacion" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Correo Electrónico
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.email" />
                    <x-input-error for="postEdit.email" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button wire:click="$set('open', false)">
                        Cancelar
                    </x-danger-button>
                    <x-button>
                        Actualizar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>

        {{-- Modal de Éxito en la Creación --}}
        <x-dialog-modal wire:model="mostrarModalSucessCreacion">
            <x-slot name="title">
                Creación del Recepcionista
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nuevo Recepcionista creado satisfactoriamente.
                    </x-label>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button wire:click="$set('mostrarModalSucessCreacion', false)">
                        Aceptar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>

        {{-- Modal de Éxito en la Actualización --}}
        <x-dialog-modal wire:model="mostrarModalSucessEdit">
            <x-slot name="title">
                Actualización del Recepcionista
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Datos del Recepcionista actualizados satisfactoriamente.
                    </x-label>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button wire:click="$set('mostrarModalSucessEdit', false)">
                        Aceptar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>        

        {{-- Modal de Eliminación del Recepcionista --}}
        <x-dialog-modal wire:model="mostrarModalEliminacion">
            <x-slot name="title">
                Eliminación del Recepcionista
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Recepcionista eliminado satisfactoriamente.
                    </x-label>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button wire:click="$set('mostrarModalEliminacion', false)">
                        Aceptar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>

    <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
            <p> <strong>CONTADOR DE PAGINA RECEPCIONISTA: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} CLINICA "La Guardia SRL" - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>
</div>

