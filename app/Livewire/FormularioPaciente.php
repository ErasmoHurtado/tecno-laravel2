<?php

namespace App\Livewire;

use App\Models\HistorialClinico;
use App\Models\Paciente;
use App\Models\Paginacion;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class FormularioPaciente extends Component
{
    public $pacientes;
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
        'fecha_registro' => '',
        'tipo_sangre' => '',
        'email' => '',
        'password' => '',
        'diagnostico_principal' => '',
        'alergias' => '',
        'antecedentes_familiares' => '',
        'antecedentes_personales' => '',
        'tratamientos_cronicos' => '',
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
        'fecha_registro' => '',
        'tipo_sangre' => '',
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
            'postCreate.fecha_registro' => 'required|date',
            'postCreate.tipo_sangre' => 'required|max:5',
            'postCreate.email' => 'required|email',
            'postCreate.password' => 'required|min:8',
            'postCreate.diagnostico_principal' => 'required',
            'postCreate.alergias' => 'nullable',
            'postCreate.antecedentes_familiares' => 'nullable',
            'postCreate.antecedentes_personales' => 'nullable',
            'postCreate.tratamientos_cronicos' => 'nullable',
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
            'postCreate.fecha_registro.required' => 'El Campo Fecha de Registro es requerido',
            'postCreate.fecha_registro.date' => 'El Campo Fecha de Registro debe ser una fecha válida',
            'postCreate.tipo_sangre.required' => 'El Campo Tipo de Sangre es requerido',
            'postCreate.tipo_sangre.max' => 'El Campo Tipo de Sangre no debe exceder 5 caracteres',
            'postCreate.email.required' => 'El Campo Email es requerido',
            'postCreate.password.required' => 'El Campo Password es requerido',
            'postCreate.diagnostico_principal.required' => 'El Campo Diagnóstico Principal es requerido',
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
        $this->paginacion = Paginacion::where('pagina', 'paciente')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount()
    {
        $this->pacientes = Paciente::all();
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

        $pacienteCreated = Paciente::create([
            'fecha_registro' => $this->postCreate['fecha_registro'],
            'tipo_sangre' => $this->postCreate['tipo_sangre'],
            'person_id' => $personaCreated->id,
        ]);

        $userCreated = User::create([
            'email' => $this->postCreate['email'],
            'password' => Hash::make($this->postCreate['password']),
            'person_id' => $personaCreated->id,
        ]);

        $userCreated->assignRole('Paciente');

        // Creación del historial clínico
        HistorialClinico::create([
            'diagnostico_principal' => $this->postCreate['diagnostico_principal'],
            'alergias' => $this->postCreate['alergias'],
            'antecedentes_familiares' => $this->postCreate['antecedentes_familiares'],
            'antecedentes_personales' => $this->postCreate['antecedentes_personales'],
            'tratamientos_cronicos' => $this->postCreate['tratamientos_cronicos'],
            'paciente_id' => $pacienteCreated->id,
        ]);

        $this->mostrarFormulario = false;
        $this->reset(['postCreate']);
        $this->pacientes = Paciente::all();

        $this->mostrarModalSucessCreacion = true;
    }

    public function edit($postId)
    {
        $this->resetValidation();

        $this->mostrarFormulario = false;
        $this->open = true;

        $this->postEditId = $postId;

        $pacienteUpdate = Paciente::find($postId);
        $personId = $pacienteUpdate->person_id;

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
        $this->postEdit['fecha_registro'] = $pacienteUpdate->fecha_registro;
        $this->postEdit['tipo_sangre'] = $pacienteUpdate->tipo_sangre;
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
            'postEdit.fecha_registro' => 'required|date',
            'postEdit.tipo_sangre' => 'required|max:5',
            'postEdit.email' => 'required|email',
        ]);

        $pacienteUpdate = Paciente::find($this->postEditId);
        $personId = $pacienteUpdate->person_id;

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

        $pacienteUpdate->update([
            'fecha_registro' => $this->postEdit['fecha_registro'],
            'tipo_sangre' => $this->postEdit['tipo_sangre'],
        ]);

        $this->mostrarFormulario = false;

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->pacientes = Paciente::all();
        $this->mostrarModalSucessEdit = true;
    }

    public function destroy($postId)
    {
        $pacienteDelete = Paciente::find($postId);

        if (!$pacienteDelete) {
            return;
        }

        $personId = $pacienteDelete->person_id;
        $userDelete = User::where('person_id', $personId)->first();
        $personDelete = Persona::find($personId);

        if ($userDelete) {
            $userDelete->removeRole('Paciente');
            $pacienteDelete->delete();
            $userDelete->delete();
            $personDelete->delete();

            $this->mostrarFormulario = false;
        }

        $this->pacientes = Paciente::all();
        $this->mostrarModalEliminacion = true;
    }

    public function render()
    {
        return view('livewire.formulario-paciente');
    }
}

