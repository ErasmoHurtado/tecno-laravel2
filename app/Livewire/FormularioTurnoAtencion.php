<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TurnoAtencion;
use App\Models\MedicoEspecialidad;
use App\Models\Sala;
use App\Models\Paginacion;

class FormularioTurnoAtencion extends Component
{
    public $turnosAtencion;
    public $medicoEspecialidades;
    public $salas;
    public $contador = 0;
    public $paginacion;

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacion = false;
    public $mostrarModalSucessEdit = false;
    public $mostrarModalEliminacion = false;

    public $postCreate = [
        'horario' => '',
        'hora_inicio' => '',
        'hora_fin' => '',
        'dias_servicio' => [],
        'cantidad_fichas' => '',
        'precio' => '',
        'medico_especialidad_id' => '',
        'sala_id' => ''
    ];

    public $postEditId = '';
    public $open = false;

    public $postEdit = [
        'horario' => '',
        'hora_inicio' => '',
        'hora_fin' => '',
        'dias_servicio' => [],
        'cantidad_fichas' => '',
        'precio' => '',
        'medico_especialidad_id' => '',
        'sala_id' => ''
    ];

    public function rules()
    {
        return [
            'postCreate.horario' => 'required|string|max:255',
            'postCreate.hora_inicio' => 'required|date_format:H:i',
            'postCreate.hora_fin' => 'required|date_format:H:i|after:postCreate.hora_inicio',
            'postCreate.dias_servicio' => 'required|array|min:1',
            'postCreate.cantidad_fichas' => 'required|integer|min:1',
            'postCreate.precio' => 'required|numeric|min:0',
            'postCreate.medico_especialidad_id' => 'required|exists:medico_especialidads,id',
            'postCreate.sala_id' => 'required|exists:salas,id',
        ];
    }

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public function save()
    {
        $this->validate();

        TurnoAtencion::create($this->postCreate);

        $this->reset(['postCreate', 'mostrarFormulario']);
        $this->mostrarModalSucessCreacion = true;
        $this->turnosAtencion = TurnoAtencion::with(['medicoEspecialidad', 'sala'])->get();
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->mostrarFormulario = false;
        $this->open = true;

        $this->postEditId = $id;
        $turnoAtencion = TurnoAtencion::findOrFail($id);
        $this->postEdit = $turnoAtencion->toArray();        
    }

    public function update()
    {
        
        $this->validate();
        
        $turnoAtencion = TurnoAtencion::findOrFail($this->postEditId);
        $turnoAtencion->update($this->postEdit);

        $this->reset(['postEditId', 'postEdit', 'mostrarFormulario', 'open']);
        $this->mostrarModalSucessEdit = true;
        $this->turnosAtencion = TurnoAtencion::with(['medicoEspecialidad', 'sala'])->get();
    }

    public function destroy($id)
    {
        TurnoAtencion::findOrFail($id)->delete();
        $this->turnosAtencion = TurnoAtencion::with(['medicoEspecialidad', 'sala'])->get();
        $this->mostrarModalEliminacion = true;
    }

    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'turnoatencion')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount()
    {
        $this->medicoEspecialidades = MedicoEspecialidad::all();
        $this->salas = Sala::all();
        $this->turnosAtencion = TurnoAtencion::with(['medicoEspecialidad', 'sala'])->get();
        $this->incrementarPaginacion();
    }

    public function render()
    {
        return view('livewire.formulario-turno-atencion');
    }
}
