<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Sala;
use App\Models\Paginacion;

class FormularioSala extends Component
{
    public $salas;

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacion = false;    
    public $mostrarModalSucessEdit = false;    
    public $mostrarModalEliminacion = false;    

    public $postCreate = [        
        'codigo' => '',
        'tipo' => ''        
    ];

    public $posts;

    public $postEditId = '';

    public $open = false;

    public $postEdit = [        
        'codigo' => '',
        'tipo' => ''
    ];

    public function rules(){
        return [
            'postCreate.codigo' => 'required|max:10',
            'postCreate.tipo' => 'required|max:50'
        ];
    }

    public function messages(){
        return [
            'postCreate.codigo.required' => 'El Campo Código es requerido',
            'postCreate.codigo.max' => 'El Campo Código no puede tener más de 10 caracteres',
            'postCreate.tipo.required' => 'El Campo Tipo es requerido',
            'postCreate.tipo.max' => 'El Campo Tipo no puede tener más de 50 caracteres',

            'postEdit.codigo.required' => 'El Campo Código es requerido',
            'postEdit.codigo.max' => 'El Campo Código no puede tener más de 10 caracteres',
            'postEdit.tipo.required' => 'El Campo Tipo es requerido',
            'postEdit.tipo.max' => 'El Campo Tipo no puede tener más de 50 caracteres'
        ];
    }

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public function save(){

        $this->validate();
        
        $sala = Sala::create([
            'codigo' => $this->postCreate['codigo'],
            'tipo' => $this->postCreate['tipo']            
        ]);

        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);
        $this->salas = Sala::all();
        $this->mostrarModalSucessCreacion = true;        
    }

    public function edit($postId){
        $this->resetValidation();
        $this->mostrarFormulario = false;        
        $this->open = true;

        $this->postEditId = $postId;

        $sala = Sala::find($postId);

        $this->postEdit['codigo'] = $sala->codigo;
        $this->postEdit['tipo'] = $sala->tipo;        
    }

    public function update(){ 
        $this->validate([
            'postEdit.codigo' => 'required|max:10',
            'postEdit.tipo' => 'required|max:50'
        ]);
        

        $sala = Sala::find($this->postEditId);

        $sala->update([
            'codigo' => $this->postEdit['codigo'],
            'tipo' => $this->postEdit['tipo']            
        ]);

        $this->mostrarFormulario = false;
        $this->reset(['postEditId', 'postEdit', 'open']);
        $this->salas = Sala::all();
        $this->mostrarModalSucessEdit = true;        
    }

    public function destroy($postId){
        $this->mostrarFormulario = false;            
        $sala = Sala::find($postId);

        $sala->delete();

        $this->salas = Sala::all();
        $this->mostrarModalEliminacion = true;        
    }

    public $contador = 0;
    public $paginacion;
    
    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'sala')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount(){
        $this->salas = Sala::all();
        $this->incrementarPaginacion();
    }

    public function render()
    {
        return view('livewire.formulario-sala');
    }
}

