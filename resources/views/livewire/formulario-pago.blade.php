<div>
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Lista de Pagos</h2>

    <!-- Filtro por estado -->
    <div class="mb-4">
        <label class="font-semibold text-sm text-gray-800 dark:text-gray-200">Filtrar por Estado:</label>
        <select wire:model="filtroEstado" wire:change="actualizarFiltro" class="w-full border-gray-300 rounded-lg shadow-sm">
            <option value="">Todos</option>
            <option value="Pendiente de pago">Pendiente de pago</option>
            <option value="Pagado">Pagado</option>
        </select>
    </div>

    <!-- Tabla de pagos -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th class="p-2 border border-gray-300 dark:border-gray-600">ID</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600">Monto</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600">Método</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600">Estado</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600">Ficha Asociada</th>
                    <th class="p-2 border border-gray-300 dark:border-gray-600">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pagos as $pago)
                    <tr class="border border-gray-300 dark:border-gray-600">
                        <td class="p-2 text-center">{{ $pago->id }}</td>
                        <td class="p-2 text-center">${{ number_format($pago->monto, 2) }}</td>
                        <td class="p-2 text-center">{{ $pago->metodo }}</td>
                        <td class="p-2 text-center">
                            <span class="px-2 py-1 text-sm font-semibold rounded-lg {{ $pago->estado === 'Pagado' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                {{ $pago->estado }}
                            </span>
                        </td>
                        <td class="p-2 text-center">
                            @if($pago->ficha)
                                Ficha #{{ $pago->ficha->id }}
                            @else
                                No asignado
                            @endif
                        </td>
                        <td class="p-2 text-center">{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">No hay pagos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
