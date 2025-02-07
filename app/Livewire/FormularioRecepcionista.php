<?php

namespace App\Livewire;

use App\Models\Recepcionista;
use App\Models\Paginacion;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class FormularioRecepcionista extends Component
{
    public $recepcionistas;
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
        'turno_trabajo' => '',
        'fecha_contratacion' => '',
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
        'turno_trabajo' => '',
        'fecha_contratacion' => '',
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
            'postCreate.turno_trabajo' => 'required|max:50',
            'postCreate.fecha_contratacion' => 'required|date',
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
            'postCreate.turno_trabajo.required' => 'El Campo Turno de Trabajo es requerido',
            'postCreate.turno_trabajo.max' => 'El Campo Turno de Trabajo no debe exceder 50 caracteres',
            'postCreate.fecha_contratacion.required' => 'El Campo Fecha de Contratación es requerido',
            'postCreate.fecha_contratacion.date' => 'El Campo Fecha de Contratación debe ser una fecha válida',
            'postCreate.email.required' => 'El Campo Email es requerido',
            'postCreate.password.required' => 'El Campo Password es requerido',
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
        $this->paginacion = Paginacion::where('pagina', 'recepcionista')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount()
    {
        $this->recepcionistas = Recepcionista::all();
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

        $recepcionistaCreated = Recepcionista::create([
            'turno_trabajo' => $this->postCreate['turno_trabajo'],
            'fecha_contratacion' => $this->postCreate['fecha_contratacion'],
            'person_id' => $personaCreated->id,
        ]);

        $userCreated = User::create([
            'email' => $this->postCreate['email'],
            'password' => Hash::make($this->postCreate['password']),
            'person_id' => $personaCreated->id,
        ]);

        $userCreated->assignRole('Recepcionista');

        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);
        $this->recepcionistas = Recepcionista::all();

        $this->mostrarModalSucessCreacion = true;
    }

    public function edit($postId)
    {
        $this->resetValidation();

        $this->mostrarFormulario = false;
        $this->open = true;

        $this->postEditId = $postId;

        $recepcionistaUpdate = Recepcionista::find($postId);
        $personId = $recepcionistaUpdate->person_id;

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
        $this->postEdit['turno_trabajo'] = $recepcionistaUpdate->turno_trabajo;
        $this->postEdit['fecha_contratacion'] = $recepcionistaUpdate->fecha_contratacion;
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
            'postEdit.turno_trabajo' => 'required|max:50',
            'postEdit.fecha_contratacion' => 'required|date',
            'postEdit.email' => 'required|email',
        ]);

        $recepcionistaUpdate = Recepcionista::find($this->postEditId);
        $personId = $recepcionistaUpdate->person_id;

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

        $recepcionistaUpdate->update([
            'turno_trabajo' => $this->postEdit['turno_trabajo'],
            'fecha_contratacion' => $this->postEdit['fecha_contratacion'],
        ]);

        $this->mostrarFormulario = false;

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->recepcionistas = Recepcionista::all();
        $this->mostrarModalSucessEdit = true;
    }

    public function destroy($postId)
    {
        $recepcionistaDelete = Recepcionista::find($postId);

        if (!$recepcionistaDelete) {
            return;
        }

        $personId = $recepcionistaDelete->person_id;
        $userDelete = User::where('person_id', $personId)->first();
        $personDelete = Persona::find($personId);

        if ($userDelete) {
            $userDelete->removeRole('Recepcionista');
            $recepcionistaDelete->delete();
            $userDelete->delete();
            $personDelete->delete();

            $this->mostrarFormulario = false;
        }

        $this->recepcionistas = Recepcionista::all();
        $this->mostrarModalEliminacion = true;
    }

    public function render()
    {
        return view('livewire.formulario-recepcionista');
    }
}

