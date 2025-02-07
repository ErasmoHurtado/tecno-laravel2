<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pago;
use App\Models\Ficha;

class FormularioPago extends Component
{
    public $pagos;
    public $filtroEstado = ''; // Para filtrar por estado

    public function mount()
    {
        $this->cargarPagos();
    }

    public function cargarPagos()
    {
        $query = Pago::with('ficha');

        if ($this->filtroEstado) {
            $query->where('estado', $this->filtroEstado);
        }

        $this->pagos = $query->latest()->get();
    }

    public function actualizarFiltro()
    {
        $this->cargarPagos();
    }

    public function render()
    {
        return view('livewire.formulario-pago');
    }
}

