<div >    
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <form wire:submit="save">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nombre
                </x-label>
                <x-input 
                class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" 
                wire:model="postCreate.title"/>                
                <x-input-error for="postCreate.title"/>
            </div>            
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Contenido
                </x-label>
                <x-textarea class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" 
                wire:model="postCreate.content"></x-textarea>
                <x-input-error for="postCreate.content"/>
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Categoria
                </x-label>
                <x-select class="w-full" 
                wire:model="postCreate.category_id">

                    <option value="" disabled>Seleccione una Categoria</option>

                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="postCreate.category_id"/>
            </div>
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Etiquetas
                </x-label>
                <ul>
                    @foreach ($tags as $tag)
                        <li>
                            <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                <x-checkbox 
                                wire:model="postCreate.tags" 
                                value="{{$tag->id}}"/>
                                {{$tag->name}}
                            </label>
                        </li>                        
                    @endforeach
                </ul>
                <x-input-error for="postCreate.tags"/>                
            </div>
            <div class="flex justify-end">
                <x-button >
                    Crear
                </x-button>
            </div>
        </form>   
    </div>    

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <ul class="list-disc list-inside space-y-2">
            @foreach ($posts as $post)
                <li class="font-semibold text-sm dark:text-gray-200 leading-tight mb-3 flex justify-between" 
                wire:key="post--{{$post->id}}">
                    {{$post->title}}
                    <div>
                        <x-button wire:click="edit({{$post->id}})">Editar</x-button>
                        <x-danger-button wire:click="destroy({{$post->id}})">Eliminar</x-danger-button>
                    </div>
                </li>  
            @endforeach
        </ul>        
    </div>
    
    {{-- Formulario de Edicion --}}
    {{--
    @if($open)    
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0">
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <form wire:submit="update">
                        <div class="mb-4">
                            <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                Nombre
                            </x-label>
                            <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" wire:model="postEdit.title" required/>                
                        </div>            
                        <div class="mb-4">
                            <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                Contenido
                            </x-label>
                            <x-textarea class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" wire:model="postEdit.content" required></x-textarea>
                        </div>
                        <div class="mb-4">
                            <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                Categoria
                            </x-label>
                            <x-select class="w-full" wire:model="postEdit.category_id">
            
                                <option value="" disabled>Seleccione una Categoria</option>
            
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="mb-4">
                            <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                Etiquetas
                            </x-label>
                            <ul>
                                @foreach ($tags as $tag)
                                    <li>
                                        <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                            <x-checkbox wire:model="postEdit.tags" value="{{$tag->id}}"/>
                                            {{$tag->name}}
                                        </label>
                                    </li>                        
                                @endforeach
                            </ul>                
                        </div>                        
                        <div class="flex justify-end">
                            <x-danger-button class="mr-2" wire:click="$set('open', false)">
                                Cancelar
                            </x-danger-button>
                            <x-button >
                                Actualizar
                            </x-button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>   
        </div>
    @endif
    --}}
    <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Post
            </x-slot>
            <x-slot name="content">                
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Nombre
                        </x-label>
                        <x-input class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" 
                        wire:model="postEdit.title"/>                                        
                        <x-input-error for="postEdit.title"/>                
                    </div>            
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Contenido
                        </x-label>
                        <x-textarea class="w-full font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                         wire:model="postEdit.content">
                        </x-textarea>
                        <x-input-error for="postEdit.content"/>                
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Categoria
                        </x-label>
                        <x-select class="w-full" 
                        wire:model="postEdit.category_id">
        
                            <option value="" disabled>Seleccione una Categoria</option>
        
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="postEdit.category_id"/>                
                    </div>
                    <div class="mb-4">
                        <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                            Etiquetas
                        </x-label>
                        <ul>
                            @foreach ($tags as $tag)
                                <li>
                                    <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                        <x-checkbox wire:model="postEdit.tags" value="{{$tag->id}}"/>
                                        {{$tag->name}}
                                    </label>
                                </li>                        
                            @endforeach
                        </ul>                
                        <x-input-error for="postEdit.tags"/>                
                    </div> 
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button class="mr-2" wire:click="$set('open', false)">
                        Cancelar
                    </x-danger-button>
                    <x-button >
                        Actualizar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>  
</div>


