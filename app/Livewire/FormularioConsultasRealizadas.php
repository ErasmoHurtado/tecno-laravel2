<?php

namespace App\Livewire;

use App\Models\Consulta;
use App\Models\Receta;
use App\Models\Tratamiento;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormularioConsultasRealizadas extends Component
{

    public $consultas;
    public $search = '';

    // Variables para ver detalles de la consulta
    public $consultaSeleccionada;
    public $tratamiento;
    public $recetas = [];
    public $mostrarModalDetalle = false;

    public function mount()
    {
        $this->filtrarConsultas();
    }

    public function filtrarConsultas()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        if (!$user || !$user->persona || !$user->persona->paciente) {
            $this->consultas = [];
            return;
        }

        // Obtener el paciente y su historial clínico
        $paciente = $user->persona->paciente;

        if (!$paciente->historialClinico) {
            $this->consultas = [];
            return;
        }

        // Obtener consultas asociadas al historial clínico
        $this->consultas = Consulta::where('historial_clinico_id', $paciente->historialClinico->id)
            ->where(function ($query) {
                $query->where('motivo', 'like', "%{$this->search}%")
                      ->orWhere('sintomas', 'like', "%{$this->search}%")
                      ->orWhere('diagnostico', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updatedSearch()
    {
        $this->filtrarConsultas();
    }

    public function verDetalle($consultaId)
    {
        // Obtener la consulta seleccionada
        $this->consultaSeleccionada = Consulta::find($consultaId);

        if (!$this->consultaSeleccionada) {
            return;
        }

        // Obtener tratamiento relacionado
        $this->tratamiento = Tratamiento::where('consulta_id', $consultaId)->first();

        // Obtener todas las recetas relacionadas a la consulta
        $this->recetas = Receta::where('consulta_id', $consultaId)->get();

        // Mostrar el modal
        $this->mostrarModalDetalle = true;
    }


    public function render()
    {
        return view('livewire.formulario-consultas-realizadas');
    }
}
