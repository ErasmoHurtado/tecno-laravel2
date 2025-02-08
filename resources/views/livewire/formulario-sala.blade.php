<div>
    @can('Añadir una Nueva Sala')
    <div class="flex justify mb-4">
        <x-button wire:click="toggleCreateForm">                
            +
        </x-button>
    </div>
    @if ($mostrarFormulario)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <form wire:submit="save">            
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Código
                </x-label>
                <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.codigo" />
                <x-input-error for="postCreate.codigo" />
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Tipo
                </x-label>
                <x-textarea class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                    wire:model="postCreate.tipo"></x-textarea>
                <x-input-error for="postCreate.tipo" />
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
    

    @can('Ver Lista de Salas')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Lista de Salas</h2>

        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Código</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Tipo</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salas as $sala)
                    <tr class="border border-gray-300 dark:border-gray-600">
                        <td class="p-2 text-center align-middle">{{ $sala->codigo }}</td>
                        <td class="p-2 text-center align-middle">{{ $sala->tipo }}</td>
                        <td class="p-2 text-center align-middle">
                            @can('Editar una Sala')
                                <x-button wire:click="edit({{ $sala->id }})">Editar</x-button>
                            @endcan
                            @can('Eliminar una Sala')
                                <x-danger-button wire:click="destroy({{ $sala->id }})">Eliminar</x-danger-button>
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
                Actualizar Sala
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Código
                    </x-label>
                    <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.codigo" />
                    <x-input-error for="postEdit.codigo" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Tipo
                    </x-label>
                    <x-textarea class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                        wire:model="postEdit.tipo"></x-textarea>
                    <x-input-error for="postEdit.tipo" />
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

        {{-- Modal de Creación de Sala --}}
        <x-dialog-modal wire:model="mostrarModalSucessCreacion">
            <x-slot name="title">
                Creación de Sala
            </x-slot>
            <x-slot name="content">                
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Nueva Sala creada satisfactoriamente
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

        {{-- Modal de Edición de Sala --}}
        <x-dialog-modal wire:model="mostrarModalSucessEdit">
            <x-slot name="title">
                Actualización de datos de la Sala
            </x-slot>
            <x-slot name="content">                
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Datos de la Sala actualizados satisfactoriamente
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

        {{-- Modal de Eliminación de Sala --}}
        <x-dialog-modal wire:model="mostrarModalEliminacion">
            <x-slot name="title">
                Eliminación de la Sala
            </x-slot>
            <x-slot name="content">                
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Sala eliminada satisfactoriamente
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
            <p> <strong>CONTADOR DE PÁGINA SALAS: {{$contador}} </strong></p>
            <p>&copy; {{ date('Y') }} CLINICA "La Guardia SRL" - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>
</div>

