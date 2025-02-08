<div>
    @can('Añadir una Nueva Ficha')
    <div class="flex justify mb-4">
        <x-button wire:click="toggleCreateForm"> + </x-button>
    </div>
    @if ($mostrarFormulario)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
            <form wire:submit="save">
                <div class="mb-6">
                    <label class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> Formulario de Nueva Ficha</label>
                </div>                
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Recepcionista
                    </x-label>
                    <x-select class="w-full" wire:model="postCreate.recepcionista_id">
                        <option value="" disabled>Seleccione una Recepcionista</option>
                        @foreach ($recepcionistas as $recepcionista)
                            <option value="{{ $recepcionista->id }}">{{ $recepcionista->persona->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.recepcionista_id" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Paciente
                    </x-label>
                    <x-select class="w-full" wire:model="postCreate.paciente_id">
                        <option value="" disabled>Seleccione un Paciente</option>
                        @foreach ($pacientes as $paciente)
                            <option value="{{ $paciente->id }}">{{ $paciente->persona->nombre }} {{ $paciente->persona->apellidopaterno }} {{ $paciente->persona->apellidomaterno }}  </option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.paciente_id" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Turno de Atención
                    </x-label>
                    <x-select class="w-full" wire:model="postCreate.turno_atencion_id">
                        <option value="" disabled>Seleccione un Turno de Atencion</option>
                        @foreach ($turnosAtencion as $turnoAtencion)
                            <option value="{{ $turnoAtencion->id }}">{{ $turnoAtencion->horario }} -- {{ $turnoAtencion->hora_inicio }} -- {{ $turnoAtencion->hora_fin }} -- {{ $turnoAtencion->medicoEspecialidad->medico->persona->nombre }} {{ $turnoAtencion->medicoEspecialidad->medico->persona->apellidopaterno }} -- {{ $turnoAtencion->medicoEspecialidad->medico->persona->apellidomaterno }} -- {{ $turnoAtencion->medicoEspecialidad->especialidad->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.turno_atencion_id" />
                </div>
                <div class="flex justify-end mt-4">
                    <x-button>Crear</x-button>
                </div>
            </form>
        </div>
    @endif
    @endcan
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @if($mostrarFormularioPago)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Pago de Ficha</h2>
                    <x-button wire:click="cerrarFormularioPago">Cerrar</x-button>
                </div>
    
                @if($fichaSeleccionada)
                    <div class="mb-4">
                        <strong>Ficha ID:</strong> {{ $fichaSeleccionada->id }}<br>
                        <strong>Estado:</strong> {{ $fichaSeleccionada->estado }}<br>
                        <strong>Recepcionista:</strong> {{ $fichaSeleccionada->recepcionista->nombre }}<br>
                        <strong>Paciente:</strong> {{ $fichaSeleccionada->paciente->nombre }}<br>
                        <strong>Turno de Atención:</strong> {{ $fichaSeleccionada->turnoAtencion->horario }}<br>
                        <strong>Monto a Pagar:</strong> ${{ number_format($monto, 2) }}
                    </div>
    
                    <!-- Selección de Método de Pago (Radio Buttons) -->
                <div class="mb-4">
                    <label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Método de Pago
                    </label>
                    <div class="flex flex-col space-y-2">
                        <label class="flex items-center">
                            <input type="radio" wire:model.lazy="metodoPago" value="QR" class="mr-2">
                            QR
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model.lazy="metodoPago" value="Efectivo" class="mr-2">
                            Efectivo
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model.lazy="metodoPago" value="Tarjeta de Crédito" class="mr-2">
                            Tarjeta de Crédito
                        </label>
                    </div>
                    <x-input-error for="metodoPago" />
                </div>

                <!-- Botón "Siguiente" para todos los métodos de pago -->
                <div class="flex justify-end mt-4">
                    <x-button wire:click="pagarFichaSeleccionada">Siguiente</x-button>
                </div>

                @endif
            </div>
        @endif
    </div>
      
    {{-- @can('Ver Lista de Fichas')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <ul>
            @foreach ($fichas as $ficha)
                <li class="flex justify-between items-center p-2 border-b border-gray-200">
                    <span>
                        Estado: {{ $ficha->estado }},
                        Recepcionista: {{ $ficha->recepcionista->nombre }},
                        Paciente: {{ $ficha->paciente->nombre }},
                        Turno de Atención: {{ $ficha->turnoAtencion->horario }}
                    </span>
                    <div>
                        @can('Editar una Ficha')
                            <x-button wire:click="edit({{ $ficha->id }})">Editar</x-button>
                        @endcan
                        @can('Eliminar una Ficha')
                            <x-danger-button wire:click="destroy({{ $ficha->id }})">Eliminar</x-danger-button>
                        @endcan
                        @if($ficha->estado === 'Pendiente de Pago')
                        @can('Pagar una Ficha')
                            <x-button wire:click="pagarFicha({{ $ficha->id }})">Pagar Ficha</x-button>
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
                                @can('Editar una Ficha')
                                    <x-button wire:click="edit({{ $ficha->id }})">Editar</x-button>
                                @endcan
                                @can('Eliminar una Ficha')
                                    <x-danger-button wire:click="destroy({{ $ficha->id }})">Eliminar</x-danger-button>
                                @endcan
                                @if($ficha->estado === 'Pendiente de Pago')
                                    @can('Pagar una Ficha')
                                        <x-button wire:click="pagarFicha({{ $ficha->id }})">Pagar Ficha</x-button>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcan


    <x-dialog-modal wire:model="mostrarModalPagoExitoso">
        <x-slot name="title">
            Pago Exitoso
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    El pago de la ficha se realizó correctamente. Ahora está en estado "Pagado en espera de atención".
                </x-label>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button wire:click="$set('mostrarModalPagoExitoso', false)">
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="mostrarModalConfirmarPago">
        <x-slot name="title">
            Confirmación de Pago
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    ¿Desea confirmar este pago?
                </x-label>
                <p><strong>Monto:</strong> ${{ number_format($monto, 2) }}</p>
                <p><strong>Método de Pago:</strong> {{ $metodoPago }}</p>
                <p><strong>Estado Actual:</strong> Pendiente de pago</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button wire:click="confirmarPago">Confirmar Pago</x-button>
                <x-danger-button wire:click="$set('mostrarModalConfirmarPago', false)">Cancelar</x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>
    
    <x-dialog-modal wire:model="mostrarModalQR">
        <x-slot name="title">
            Escanea el Código QR
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col items-center">
                <img src="{{ $qrCode }}" alt="Código QR de Pago" class="w-48 h-48">
                <p class="mt-4 text-gray-600">Escanea este código con tu aplicación de pago.</p>
                <p class="text-blue-500 flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"></svg>
                    Esperando el pago, por favor espere...
                </p>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end">
                <x-button wire:click="$set('mostrarModalQR', false)">Cancelar</x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
    
    
    

    <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Ficha
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Estado
                    </x-label>
                    <x-input class="w-full" wire:model="postEdit.estado" />
                    <x-input-error for="postEdit.estado" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Recepcionista
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.recepcionista_id">
                        @foreach ($recepcionistas as $recepcionista)
                            <option value="{{ $recepcionista->id }}">{{ $recepcionista->persona->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.recepcionista_id" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Paciente
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.paciente_id">
                        @foreach ($pacientes as $paciente)
                            <option value="{{ $paciente->id }}">{{ $paciente->persona->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.paciente_id" />
                </div>
                <div class="mb-4">
                    <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                        Turno de Atención
                    </x-label>
                    <x-select class="w-full" wire:model="postEdit.turno_atencion_id">
                        @foreach ($turnosAtencion as $turnoAtencion)
                            <option value="{{ $turnoAtencion->id }}">{{ $turnoAtencion->horario }} -- {{ $turnoAtencion->medicoEspecialidad->medico->persona->nombre }} -- {{ $turnoAtencion->medicoEspecialidad->especialidad->nombre }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postEdit.turno_atencion_id" />
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

        {{-- Modal de Creación de Ficha --}}
    <x-dialog-modal wire:model="mostrarModalSucessCreacion">
        <x-slot name="title">
            Creación de Ficha
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Nueva ficha creada satisfactoriamente.
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

    {{-- Modal de Actualización de Ficha --}}
    <x-dialog-modal wire:model="mostrarModalSucessEdit">
        <x-slot name="title">
            Actualización de Ficha
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Ficha actualizada satisfactoriamente.
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

    {{-- Modal de Eliminación de Ficha --}}
    <x-dialog-modal wire:model="mostrarModalEliminacion">
        <x-slot name="title">
            Eliminación de Ficha
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    Ficha eliminada satisfactoriamente.
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
            <p><strong>CONTADOR DE PÁGINA FICHAS: {{ $contador }}</strong></p>
            <p>&copy; {{ date('Y') }} CLÍNICA "La Guardia SRL" - Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-gray-400 hover:text-white">Política de Privacidad</a> |
                <a href="#" class="text-gray-400 hover:text-white">Términos de Servicio</a>
            </p>
        </div>
    </footer>
</div>

{{-- <script>
    Livewire.on('iniciarVerificacionQR', () => {
        setInterval(() => {
            Livewire.emit('verificarPagoQR');
        }, 10000); // Cada 10 segundos
    }); 
</script>--}}


