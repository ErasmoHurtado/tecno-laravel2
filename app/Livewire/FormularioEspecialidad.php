<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Especialidad;
use App\Models\Paginacion;

class FormularioEspecialidad extends Component
{
    public $especialidads;

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacion = false;    
    public $mostrarModalSucessEdit = false;    
    public $mostrarModalEliminacion = false;    

    public $postCreate = [        
        'nombre' => '',
        'descripcion' => ''        
    ];

    public $posts;

    public $postEditId = '';

    public $open = false;

    public $postEdit = [        
        'nombre' => '',
        'descripcion' => ''
    ];

    public function rules(){
        return [
            'postCreate.nombre' => 'required',
            'postCreate.descripcion' => 'required'
        ];
    }

    public function messages(){
        return [
            'postCreate.nombre.required' => 'El Campo Nombre es requerido',
            'postCreate.descripcion.required' => 'El Campo Descripcion es requerido',

            'postEdit.nombre.required' => 'El Campo Nombre es requerido',
            'postEdit.descripcion.required' => 'El Campo Descripcion es requerido'
        ];
    }

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public function save(){

        $this->validate();
        
        $especialidad = Especialidad::create([
            'nombre' => $this->postCreate['nombre'],
            'descripcion' => $this->postCreate['descripcion']            
        ]);

        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);
        $this->especialidads = Especialidad::all();
        $this->mostrarModalSucessCreacion = true;        
    }

    public function edit($postId){
        $this->resetValidation();
        $this->mostrarFormulario = false;        
        $this->open = true;

        $this->postEditId = $postId;

        $especialidad = Especialidad::find($postId);

        $this->postEdit['nombre'] = $especialidad->nombre;
        $this->postEdit['descripcion'] = $especialidad->descripcion;        
    }

    public function update(){ 
        $this->validate([
            'postEdit.nombre' => 'required',
            'postEdit.descripcion' => 'required'
        ]);
        

        $especialidad = Especialidad::find($this->postEditId);

        $especialidad->update([
            'nombre' => $this->postEdit['nombre'],
            'descripcion' => $this->postEdit['descripcion']            
        ]);

        $this->mostrarFormulario = false;
        $this->reset(['postEditId', 'postEdit', 'open']);
        $this->especialidads = Especialidad::all();
        $this->mostrarModalSucessEdit = true;        
    }

    public function destroy($postId){
        $this->mostrarFormulario = false;            
        $especialidad = Especialidad::find($postId);

        $especialidad->delete();

        $this->especialidads = Especialidad::all();
        $this->mostrarModalEliminacion = true;        
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'especialidad')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount(){
        $this->especialidads = Especialidad::all();
        $this->incrementarPaginacion();
    }

    public function render()
    {
        return view('livewire.formulario-especialidad');
    }
}

