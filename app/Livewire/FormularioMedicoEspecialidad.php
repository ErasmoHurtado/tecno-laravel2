<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Medico;
use App\Models\Especialidad;
use App\Models\MedicoEspecialidad;
use App\Models\Paginacion;

class FormularioMedicoEspecialidad extends Component
{
    public $medicos;
    public $especialidades;
    public $medicoEspecialidades;
    public $contador = 0;
    public $paginacion;

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacion = false;
    public $mostrarModalSucessEdit = false;
    public $mostrarModalEliminacion = false;

    public $postCreate = [
        'id_medico' => '',
        'id_especialidad' => '',
        'titulo_especialidad' => '',
        'origen_especialidad' => '',
        'ano_especialidad' => '',
    ];

    public $postEditId = '';
    public $open = false;

    public $postEdit = [
        'id_medico' => '',
        'id_especialidad' => '',
        'titulo_especialidad' => '',
        'origen_especialidad' => '',
        'ano_especialidad' => '',
    ];

    public function rules()
    {
        return [
            'postCreate.id_medico' => 'required|exists:medicos,id',
            'postCreate.id_especialidad' => 'required|exists:especialidads,id',
            'postCreate.titulo_especialidad' => 'required|string|max:255',
            'postCreate.origen_especialidad' => 'required|string|max:255',
            'postCreate.ano_especialidad' => 'required|integer|min:1900|max:' . date('Y'),
        ];
    }

    public function messages()
    {
        return [                        
            'postCreate.id_medico.required' => 'Debe seleccionar un médico.',
            'postCreate.id_especialidad.required' => 'Debe seleccionar una especialidad.',            
            'postCreate.titulo_especialidad.required' => 'Se debe anotar el nombre del titulo.',
            'postCreate.origen_especialidad.required' => 'Se debe anotar el origen/pais del titulo.',
            'postCreate.ano_especialidad' => 'Se debe anotar el ano de la especialidad.',            
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

        MedicoEspecialidad::create($this->postCreate);

        $this->reset(['postCreate', 'mostrarFormulario']);
        $this->mostrarModalSucessCreacion = true;
        $this->medicoEspecialidades = MedicoEspecialidad::with(['medico', 'especialidad'])->get();
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->mostrarFormulario = false;
        $this->open = true;

        $this->postEditId = $id;
        $medicoEspecialidad = MedicoEspecialidad::findOrFail($id);
        $this->postEdit = $medicoEspecialidad->toArray();
    }

    public function update()
    {
        $this->validate([
            'postEdit.id_medico' => 'required|exists:medicos,id',
            'postEdit.id_especialidad' => 'required|exists:especialidads,id',
            'postEdit.titulo_especialidad' => 'required|string|max:255',
            'postEdit.origen_especialidad' => 'required|string|max:255',
            'postEdit.ano_especialidad' => 'required|integer|min:1900|max:' . date('Y'),
        ]);
        
        $medicoEspecialidad = MedicoEspecialidad::findOrFail($this->postEditId);
        $medicoEspecialidad->update($this->postEdit);

        $this->reset(['postEditId', 'postEdit', 'mostrarFormulario', 'open']);
        $this->mostrarModalSucessEdit = true;
        $this->medicoEspecialidades = MedicoEspecialidad::with(['medico', 'especialidad'])->get();
    }

    public function destroy($id)
    {
        MedicoEspecialidad::findOrFail($id)->delete();
        $this->medicoEspecialidades = MedicoEspecialidad::with(['medico', 'especialidad'])->get();
        $this->mostrarModalEliminacion = true;
    }

    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'medicoespecialidad')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount()
    {
        $this->medicos = Medico::all();
        $this->especialidades = Especialidad::all();
        $this->medicoEspecialidades = MedicoEspecialidad::with(['medico', 'especialidad'])->get();
        $this->incrementarPaginacion();
    }

    public function render()
    {
        return view('livewire.formulario-medico-especialidad');
    }
}
