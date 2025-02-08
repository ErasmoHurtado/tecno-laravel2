<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Consulta;
use App\Models\Ficha;
use App\Models\HistorialClinico;
use App\Models\Paginacion;
use App\Models\Tratamiento;
use App\Models\Receta;

class FormularioConsulta extends Component
{
    public $consultas;
    public $fichas;
    public $historialesClinicos;
    
    public $mostrarFormulario = false;
    public $mostrarModalReceta = false;
    public $mostrarModalEditarReceta = false;
    public $mostrarModalEliminarReceta = false;
    public $mostrarModalSucessCreacion = false;

    public $recetaAEliminar = null;

    public $ficha_id;

    public $mostrarHistorialClinico = false;
    public $historialClinico;
    public $historialConsultas = [];
    public $consultaSeleccionada;
    public $tratamiento;
    public $recetas = [];
    public $mostrarDetalleConsulta = false;



    
    public $postCreate = [
        'motivo' => '',
        'sintomas' => '',
        'diagnostico' => '',
        'estado' => 'En espera',
        'ficha_id' => '',
        'historial_clinico_id' => '',
        'tratamiento' => [
            'nombre' => '',
            'detalle' => '',
            'duracion' => '',
            'tipo' => ''
        ],
        'recetas' => [] // Aquí se almacenarán temporalmente las recetas antes de guardar
    ];

    public $nuevaReceta = [
        'remedio' => '',
        'descripcion' => '',
        'indicaciones' => ''
    ];

    public $editarRecetaData = [
        'index' => null,
        'remedio' => '',
        'descripcion' => '',
        'indicaciones' => '',
    ];    
    

    public function rules()
    {
        return [
            'postCreate.motivo' => 'required',
            'postCreate.sintomas' => 'required',
            'postCreate.diagnostico' => 'required',
            //'postCreate.ficha_id' => 'required|exists:fichas,id',
            //'postCreate.historial_clinico_id' => 'required|exists:historial_clinicos,id',
            'postCreate.tratamiento.nombre' => 'required',
            'postCreate.tratamiento.detalle' => 'required',
            'postCreate.tratamiento.duracion' => 'required',
            'postCreate.tratamiento.tipo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'postCreate.motivo.required' => 'El motivo es obligatorio.',
            'postCreate.sintomas.required' => 'Los síntomas son obligatorios.',
            'postCreate.diagnostico.required' => 'El diagnóstico es obligatorio.',
            //'postCreate.ficha_id.required' => 'Debe seleccionar una ficha.',
            //'postCreate.historial_clinico_id.required' => 'Debe seleccionar un historial clínico.',
            'postCreate.tratamiento.nombre.required' => 'El nombre del tratamiento es obligatorio.',
            'postCreate.tratamiento.detalle.required' => 'El detalle del tratamiento es obligatorio.',
            'postCreate.tratamiento.duracion.required' => 'La duración del tratamiento es obligatoria.',
            'postCreate.tratamiento.tipo.required' => 'El tipo de tratamiento es obligatorio.',
        ];
    }

    public function toggleCreateForm()
    {
        $this->resetValidation();
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }    

    public function agregarReceta()
    {
        $this->validate([
            'nuevaReceta.remedio' => 'required|string',
            'nuevaReceta.descripcion' => 'required|string',
            'nuevaReceta.indicaciones' => 'required|string',
        ]);

        $this->postCreate['recetas'][] = [
            'remedio' => $this->nuevaReceta['remedio'],
            'descripcion' => $this->nuevaReceta['descripcion'],
            'indicaciones' => $this->nuevaReceta['indicaciones'],
        ];

        // Limpia los campos después de agregar la receta
        $this->reset('nuevaReceta');
        $this->mostrarModalReceta = false;
    }

    public function editarReceta($index)
    {
        if (!isset($this->postCreate['recetas'][$index])) {
            return;
        }

        // Cargar la receta seleccionada en `editarRecetaData`
        $this->editarRecetaData = [
            'index' => $index,
            'remedio' => $this->postCreate['recetas'][$index]['remedio'],
            'descripcion' => $this->postCreate['recetas'][$index]['descripcion'],
            'indicaciones' => $this->postCreate['recetas'][$index]['indicaciones'],
        ];

        // Abrir el modal de edición
        $this->mostrarModalEditarReceta = true;
    }

    public function guardarEdicionReceta()
    {
        $this->validate([
            'editarRecetaData.remedio' => 'required|string',
            'editarRecetaData.descripcion' => 'required|string',
            'editarRecetaData.indicaciones' => 'required|string',
        ]);

        $index = $this->editarRecetaData['index'];

        if (!isset($this->postCreate['recetas'][$index])) {
            return;
        }

        // Actualizar los valores en la lista de recetas
        $this->postCreate['recetas'][$index] = [
            'remedio' => $this->editarRecetaData['remedio'],
            'descripcion' => $this->editarRecetaData['descripcion'],
            'indicaciones' => $this->editarRecetaData['indicaciones'],
        ];

        // Limpiar y cerrar el modal
        $this->reset('editarRecetaData');
        $this->mostrarModalEditarReceta = false;
    }

    public function confirmarEliminarReceta($index)
    {
        if (!isset($this->postCreate['recetas'][$index])) {
            return;
        }

        // Guardar el índice de la receta a eliminar
        $this->recetaAEliminar = $index;

        // Mostrar el modal de confirmación
        $this->mostrarModalEliminarReceta = true;
    }

    public function eliminarRecetaConfirmada()
    {
        if ($this->recetaAEliminar === null || !isset($this->postCreate['recetas'][$this->recetaAEliminar])) {
            return;
        }

        // Eliminar la receta del array
        unset($this->postCreate['recetas'][$this->recetaAEliminar]);

        // Reindexar el array para evitar errores en los índices
        $this->postCreate['recetas'] = array_values($this->postCreate['recetas']);

        // Limpiar y cerrar el modal
        $this->reset('recetaAEliminar');
        $this->mostrarModalEliminarReceta = false;
    }

    public function eliminarReceta($index)
    {
        unset($this->postCreate['recetas'][$index]);
        $this->postCreate['recetas'] = array_values($this->postCreate['recetas']); // Reindexar
    }

    public function atenderFicha($ficha_id)
    {
        // Guardamos el ficha_id para su uso en la consulta        
        $this->ficha_id = $ficha_id;

        // Buscamos el historial clínico del paciente asociado a la ficha
        $ficha = Ficha::find($ficha_id);        
        if ($ficha && $ficha->paciente && $ficha->paciente->historialClinico) {
            $this->postCreate['historial_clinico_id'] = $ficha->paciente->historialClinico->id;
            
            //dd($this->postCreate['historial_clinico_id']);
        } else {
            $this->postCreate['historial_clinico_id'] = null; // Si no hay historial, dejar en null
            //dd($this->postCreate['historial_clinico_id']);
        }

        // Mostramos el formulario de consulta
        $this->mostrarFormulario = true;
    }


    public function save()
    {
        //dd($this->postCreate);
        $this->validate();

        // Crear la consulta con ficha_id e historial_clinico_id
        $consulta = Consulta::create([
            'motivo' => $this->postCreate['motivo'],
            'sintomas' => $this->postCreate['sintomas'],
            'diagnostico' => $this->postCreate['diagnostico'],
            'estado' => 'En espera',
            'ficha_id' => $this->ficha_id,
            'historial_clinico_id' => $this->postCreate['historial_clinico_id'],
        ]);

        // Crear el tratamiento asociado a la consulta
        Tratamiento::create([
            'nombre' => $this->postCreate['tratamiento']['nombre'],
            'detalle' => $this->postCreate['tratamiento']['detalle'],
            'duracion' => $this->postCreate['tratamiento']['duracion'],
            'tipo' => $this->postCreate['tratamiento']['tipo'],
            'consulta_id' => $consulta->id,
        ]);

        // Crear todas las recetas asociadas a la consulta
        foreach ($this->postCreate['recetas'] as $receta) {
            Receta::create([
                'remedio' => $receta['remedio'],
                'descripcion' => $receta['descripcion'],
                'indicaciones' => $receta['indicaciones'],
                'consulta_id' => $consulta->id,
            ]);
        }

        // 🔥 Actualizar el estado de la ficha a "Atendida"
        $ficha = Ficha::find($this->ficha_id);
        if ($ficha) {
            $ficha->update(['estado' => 'Atendida']);
        }

        // Resetear formulario y cerrar modal
        $this->reset(['postCreate', 'ficha_id', 'mostrarFormulario']);
        //$this->consultas = Consulta::all();
        $this->fichas = Ficha::all();
        $this->mostrarModalSucessCreacion = true;
    }

    public function verHistorialClinico($ficha_id)
    {
        // Buscar la ficha para obtener el paciente
        $ficha = Ficha::find($ficha_id);

        if (!$ficha || !$ficha->paciente) {
            $this->historialClinico = null;
            $this->historialConsultas = []; // Se cambió de $consultas a $historialConsultas
            return;
        }

        // Obtener el historial clínico del paciente
        $this->historialClinico = $ficha->paciente->historialClinico;

        if (!$this->historialClinico) {
            $this->historialConsultas = [];
        } else {
            // Obtener todas las consultas relacionadas al historial clínico
            $this->historialConsultas = Consulta::where('historial_clinico_id', $this->historialClinico->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Activar la vista del historial clínico
        $this->mostrarHistorialClinico = true;
    }

    public function ocultarHistorialClinico()
    {
        $this->mostrarHistorialClinico = false;
    }

    public function verDetalleConsulta($consultaId)
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

        // Mostrar la sección de detalles
        $this->mostrarDetalleConsulta = true;
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
        $this->consultas = Consulta::with(['ficha', 'historialClinico', 'tratamiento', 'recetas'])->get();
        $this->fichas = Ficha::all();
        $this->historialesClinicos = HistorialClinico::all();
        $this->incrementarPaginacion();
    }

    public function render()
    {
        return view('livewire.formulario-consulta');
    }
}
