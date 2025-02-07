<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HistorialClinico;
use App\Models\Consulta;
use App\Models\Tratamiento;
use App\Models\Receta;
use App\Models\Paciente;

class FormularioHistorialesClinicos extends Component
{
    public $search = ''; // Campo de búsqueda
    public $historiales = [];
    public $historialSeleccionado;
    public $consultas = [];
    public $consultaSeleccionada;
    public $tratamiento;
    public $recetas = [];
    public $mostrarConsultas = false;
    public $mostrarDetalleConsulta = false;

    public function mount()
    {
        $this->filtrarHistoriales();
    }

    public function filtrarHistoriales()
    {
        // Obtener historiales filtrados por el nombre del paciente
        $this->historiales = HistorialClinico::whereHas('paciente', function ($query) {
            $query->whereHas('persona', function ($q) {
                $q->where('nombre', 'like', "%{$this->search}%");
            });
        })->get();
    }

    public function updatedSearch()
    {
        $this->filtrarHistoriales();
    }

    public function verConsultas($historialId)
    {
        $this->historialSeleccionado = HistorialClinico::find($historialId);

        if (!$this->historialSeleccionado) {
            return;
        }

        $this->consultas = Consulta::where('historial_clinico_id', $historialId)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->mostrarConsultas = true;
        $this->mostrarDetalleConsulta = false;
    }

    public function verDetalleConsulta($consultaId)
    {
        $this->consultaSeleccionada = Consulta::find($consultaId);

        if (!$this->consultaSeleccionada) {
            return;
        }

        $this->tratamiento = Tratamiento::where('consulta_id', $consultaId)->first();
        $this->recetas = Receta::where('consulta_id', $consultaId)->get();
        $this->mostrarDetalleConsulta = true;
    }

    public function ocultarDetalleConsulta()
    {
        $this->mostrarDetalleConsulta = false;
    }

    public function render()
    {
        return view('livewire.formulario-historiales-clinicos');
    }
}

