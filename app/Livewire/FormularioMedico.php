<?php

namespace App\Livewire;

use App\Models\Medico;
use App\Models\Paginacion;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class FormularioMedico extends Component
{
    public $medicos;
    public $mostrarFormulario = false;

    public $mostrarModalSucessCreacion = false;
    public $mostrarModalSucessEdit = false;
    public $mostrarModalEliminacion = false;

    public $postCreate = [
        'user_id' => '',
        'nombre' => '',
        'apellidopaterno' => '',
        'apellidomaterno' => '',
        'sexo' => '',
        'ci' => '',
        'telefono' => '',
        'direccion' => '',
        'numero_licencia' => '',        
        'titulo_universidad' => '',
        'origen_titulo' => '',
        'ano_titulacion' => '',
        'email' => '',
        'password' => '',
    ];

    public $posts;

    public $postEditId = '';

    public $open = false;

    public $postEdit = [
        'user_id' => '',
        'nombre' => '',
        'apellidopaterno' => '',
        'apellidomaterno' => '',
        'sexo' => '',
        'ci' => '',
        'telefono' => '',
        'direccion' => '',
        'titulo_universidad' => '',
        'origen_titulo' => '',
        'ano_titulacion' => '',
        'email' => '',
    ];

    public function rules()
    {
        return [
            'postCreate.ci' => 'required',
            'postCreate.nombre' => 'required',
            'postCreate.apellidopaterno' => 'required',
            'postCreate.apellidomaterno' => 'required',
            'postCreate.sexo' => 'required',
            'postCreate.telefono' => 'required',
            'postCreate.direccion' => 'required',
            'postCreate.numero_licencia' => 'required',
            'postCreate.titulo_universidad' => 'required',
            'postCreate.origen_titulo' => 'required',
            'postCreate.ano_titulacion' => 'required|integer',
            'postCreate.email' => 'required|email',
            'postCreate.password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'postCreate.ci.required' => 'El Campo CI es requerido',
            'postCreate.nombre.required' => 'El Campo Nombre es requerido',
            'postCreate.apellidopaterno.required' => 'El Campo Apellido Paterno es requerido',
            'postCreate.apellidomaterno.required' => 'El Campo Apellido Materno es requerido',
            'postCreate.sexo.required' => 'El Campo Sexo es requerido',
            'postCreate.telefono.required' => 'El Campo Teléfono es requerido',
            'postCreate.direccion.required' => 'El Campo Dirección es requerido',
            'postCreate.numero_licencia.required' => 'El Campo Número de Licencia es requerido',
            'postCreate.titulo_universidad.required' => 'El Campo Titulo de Universidad es requerido',
            'postCreate.ano_titulacion.required' => 'El Campo Año de Titulacion es requerido',
            'postCreate.email.required' => 'El Campo Email es requerido',
            'postCreate.password.required' => 'El Campo Password es requerido',
        ];
    }

    public function validationAttributes()
    {
        return [
            'postCreate.email' => 'email',
            'postCreate.password' => 'password',
        ];
    }

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public $contador = 0;
    public $paginacion;

    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'medico')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount()
    {
        $this->medicos = Medico::all();
        $this->incrementarPaginacion();
    }

    public function save()
    {
        $this->validate();

        $personaCreated = Persona::create([
            'ci' => $this->postCreate['ci'],
            'nombre' => $this->postCreate['nombre'],
            'apellidopaterno' => $this->postCreate['apellidopaterno'],
            'apellidomaterno' => $this->postCreate['apellidomaterno'],
            'sexo' => $this->postCreate['sexo'],
            'telefono' => $this->postCreate['telefono'],
            'direccion' => $this->postCreate['direccion'],
        ]);

        $medicoCreated = Medico::create([
            'numero_licencia' => $this->postCreate['numero_licencia'],
            'titulo_universidad' => $this->postCreate['titulo_universidad'],
            'origen_titulo' => $this->postCreate['origen_titulo'],
            'ano_titulacion' => $this->postCreate['ano_titulacion'],
            'person_id' => $personaCreated->id,
        ]);

        $userCreated = User::create([
            'email' => $this->postCreate['email'],
            'password' => Hash::make($this->postCreate['password']),
            'person_id' => $personaCreated->id,
        ]);

        $userCreated->assignRole('Medico');

        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);
        $this->medicos = Medico::all();

        $this->mostrarModalSucessCreacion = true;
    }

    public function edit($postId)
    {
        $this->resetValidation();

        $this->mostrarFormulario = false;
        $this->open = true;

        $this->postEditId = $postId;
        

        $medicoUpdate = Medico::find($postId);        
        $personId = $medicoUpdate->person_id;

        $userUpdate = User::where('person_id', $personId)->first();
        $personUpdate = Persona::find($personId);        

        $this->postEdit['nombre'] = $personUpdate->nombre;
        $this->postEdit['apellidopaterno'] = $personUpdate->apellidopaterno;
        $this->postEdit['apellidomaterno'] = $personUpdate->apellidomaterno;
        $this->postEdit['sexo'] = $personUpdate->sexo;
        $this->postEdit['ci'] = $personUpdate->ci;
        $this->postEdit['telefono'] = $personUpdate->telefono;
        $this->postEdit['direccion'] = $personUpdate->direccion;
        $this->postEdit['email'] = $userUpdate->email;
        $this->postEdit['numero_licencia'] = $medicoUpdate->numero_licencia;
        $this->postEdit['titulo_universidad'] = $medicoUpdate->titulo_universidad;
        $this->postEdit['origen_titulo'] = $medicoUpdate->origen_titulo;
        $this->postEdit['ano_titulacion'] = $medicoUpdate->ano_titulacion;
    }

    public function update()
    {
        $this->validate([
            'postEdit.ci' => 'required',
            'postEdit.nombre' => 'required',
            'postEdit.apellidopaterno' => 'required',
            'postEdit.apellidomaterno' => 'required',
            'postEdit.sexo' => 'required',
            'postEdit.telefono' => 'required',
            'postEdit.direccion' => 'required',
            'postEdit.numero_licencia' => 'required',
            'postEdit.titulo_universidad' => 'required',
            'postEdit.origen_titulo' => 'required',
            'postEdit.ano_titulacion' => 'required|integer',
            'postEdit.email' => 'required|email',
        ]);

        $medicoUpdate = Medico::find($this->postEditId);
        $personId = $medicoUpdate->person_id;

        $userUpdate = User::where('person_id', $personId)->first();
        $personUpdate = Persona::find($personId);

        $personUpdate->update([
            'ci' => $this->postEdit['ci'],
            'nombre' => $this->postEdit['nombre'],
            'apellidopaterno' => $this->postEdit['apellidopaterno'],
            'apellidomaterno' => $this->postEdit['apellidomaterno'],
            'sexo' => $this->postEdit['sexo'],
            'telefono' => $this->postEdit['telefono'],
            'direccion' => $this->postEdit['direccion'],
        ]);

        $userUpdate->update([
            'email' => $this->postEdit['email'],
        ]);

        $medicoUpdate->update([
            'numero_licencia' => $this->postEdit['numero_licencia'],
            'titulo_universidad' => $this->postEdit['titulo_universidad'],
            'origen_titulo' => $this->postEdit['origen_titulo'],
            'ano_titulacion' => $this->postEdit['ano_titulacion'],
        ]);

        $this->mostrarFormulario = false;

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->medicos = Medico::all();
        $this->mostrarModalSucessEdit = true;
    }

    public function destroy($postId)
    {
        $medicoDelete = Medico::find($postId);

        if (!$medicoDelete) {
            return;
        }

        $personId = $medicoDelete->person_id;
        $userDelete = User::where('person_id', $personId)->first();
        $personDelete = Persona::find($personId);

        if ($userDelete) {
            $userDelete->removeRole('Medico');
            $medicoDelete->delete();
            $userDelete->delete();
            $personDelete->delete();

            $this->mostrarFormulario = false;
        }

        $this->medicos = Medico::all();
        $this->mostrarModalEliminacion = true;
    }

    public function render()
    {
        return view('livewire.formulario-medico');
    }
}

