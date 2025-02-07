<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ficha;
use App\Models\Recepcionista;
use App\Models\Paciente;
use App\Models\TurnoAtencion;
use App\Models\Paginacion;
use App\Models\Pago;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FormularioFicha extends Component
{
    public $fichas;
    public $recepcionistas;
    public $pacientes;
    public $turnosAtencion;
    public $contador = 0;
    public $paginacion;

    public $mostrarFormulario = false;
    public $mostrarModalSucessCreacion = false;
    public $mostrarModalSucessEdit = false;
    public $mostrarModalEliminacion = false;

    public $mostrarFormularioPago = false;
    public $fichaSeleccionada;
    public $monto;
    public $metodoPago = 'Efectivo'; // Ahora el valor por defecto es "Efectivo"
    public $mostrarModalPagoExitoso = false; // Variable para mostrar el modal de pago exitoso

    public $mostrarModalConfirmarPago = false; // Nuevo modal para confirmar el pago
    public $pagoSeleccionado; // Para manejar el pago registrado

    public $mostrarModalQR = false; // Para mostrar el modal de QR
    public $qrCode = ''; // Para almacenar la imagen QR generada
    public $transaccionId = ''; // ID de transacción generado




    public $postCreate = [        
        'recepcionista_id' => '',
        'paciente_id' => '',
        'turno_atencion_id' => ''
    ];

    public $postEditId = '';
    public $open = false;

    public $postEdit = [
        'estado' => '',
        'recepcionista_id' => '',
        'paciente_id' => '',
        'turno_atencion_id' => ''
    ];

    public function rules()
    {
        return [            
            'postCreate.recepcionista_id' => 'required|exists:recepcionistas,id',
            'postCreate.paciente_id' => 'required|exists:pacientes,id',
            'postCreate.turno_atencion_id' => 'required|exists:turno_atencions,id',
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

        Ficha::create($this->postCreate);

        $this->reset(['postCreate', 'mostrarFormulario']);
        $this->mostrarModalSucessCreacion = true;
        $this->fichas = Ficha::with(['recepcionista', 'paciente', 'turnoAtencion'])->get();
    }

    public function pagarFicha($ficha_id)
    {
        // Obtener la ficha seleccionada
        $this->fichaSeleccionada = Ficha::find($ficha_id);

        if (!$this->fichaSeleccionada) {
            return;
        }

        // Obtener el precio desde TurnoAtencion
        $this->monto = $this->fichaSeleccionada->turnoAtencion->precio;

        // Mostrar el formulario de pago
        $this->mostrarFormularioPago = true;
    }

    public function cerrarFormularioPago()
    {
        $this->mostrarFormularioPago = false;
        $this->fichaSeleccionada = null;
        $this->monto = null;
        $this->metodoPago = null;
    }

    public function pagarFichaSeleccionada()
    {
        if (!$this->fichaSeleccionada) {
            return;
        }

        // Crear el pago solo cuando el usuario haga clic en "Pagar"
        $pago = Pago::create([
            'ficha_id' => $this->fichaSeleccionada->id,
            'metodo' => $this->metodoPago,
            'monto' => $this->monto,
            'estado' => 'Pendiente de pago',
        ]);

        // Guardar el pago registrado en la variable para usarlo después
        $this->pagoSeleccionado = $pago;

        // Si el método de pago es QR, generamos el QR
        if ($this->metodoPago === 'QR') {
            $this->generarQr();
        } else {
            // Si es efectivo o tarjeta, mostramos el modal de confirmación
            $this->mostrarModalConfirmarPago = true;
        }
    }

    public function confirmarPago()
    {
        if (!$this->pagoSeleccionado) {
            return;
        }

        // Actualizar el estado del pago a "Pagado"
        $this->pagoSeleccionado->update(['estado' => 'Pagado']);

        // Actualizar el estado de la ficha a "Pagado en espera de atención"
        $this->fichaSeleccionada->update([
            'estado' => 'Pagado en espera de atencion'
        ]);

        // Cerrar el formulario de pago y el modal de confirmación
        $this->mostrarFormularioPago = false; // 🔹 Cierra el formulario de pago
        $this->mostrarModalConfirmarPago = false; // 🔹 Cierra el modal de confirmación
    }

    public function generarQr()
    {
        try {
            $lcComerceID = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda = 2;
            $lnTelefono = 78504677;
            $lcNombreUsuario = 'Alexander grupo 15';
            $lnCiNit = 7452532;
            $lcNroPago = "test-" . rand(100000, 999999);
            $lnMontoClienteEmpresa = 0.01;
            $lcCorreo = 'alexander@gmail.com';
            $lcUrlCallBack = "http://localhost:8000/";
            $lcUrlReturn = "http://localhost:8000/";

            $loClient = new Client();
            $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";

            $laHeader = ['Accept' => 'application/json'];
            $laBody = [
                "tcCommerceID" => $lcComerceID,
                "tnMoneda" => $lnMoneda,
                "tnTelefono" => $lnTelefono,
                'tcNombreUsuario' => $lcNombreUsuario,
                'tnCiNit' => $lnCiNit,
                'tcNroPago' => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo" => $lcCorreo,
                'tcUrlCallBack' => $lcUrlCallBack,
                "tcUrlReturn" => $lcUrlReturn,
                'taPedidoDetalle' => ''
            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);
            $laResult = json_decode($loResponse->getBody()->getContents());

             // 🔍 Verificar qué respuesta está devolviendo la API
            //Log::info('Respuesta de la API:', (array) $laResult);

            // Obtener el código de transacción
            $this->transaccionId = explode(";", $laResult->values)[0];

            // Obtener la imagen QR en base64
            $qrImage = explode(";", $laResult->values)[1];
            $this->qrCode = "data:image/png;base64," . json_decode($qrImage)->qrImage;

            // 🔍 Verificar si $qrCode está obteniendo un valor
            //Log::info('QR Generado:', ['qrCode' => $this->qrCode]);

            // Abrir el modal con el QR
            $this->mostrarModalQR = true;

            // Iniciar la verificación del estado de pago
            //$this->emit('iniciarVerificacionQR');

        } catch (\Throwable $th) {
            $this->qrCode = null;
        }
    }

    // public function verificarEstadoPago()
    // {
    //     if (!$this->pagoSeleccionado) {
    //         return;
    //     }

    //     // Consultar la base de datos para ver si el estado del pago cambió
    //     $pagoActualizado = Pago::find($this->pagoSeleccionado->id);

    //     if ($pagoActualizado && $pagoActualizado->estado === 'Pagado') {
    //         // Actualizar la ficha a "Pagado en espera de atención"
    //         $this->fichaSeleccionada->update([
    //             'estado' => 'Pagado en espera de atencion'
    //         ]);

    //         // Cerrar el modal de QR y abrir el modal de éxito
    //         $this->mostrarModalQR = false;
    //         $this->mostrarModalPagoExitoso = true;
    //     } else {
    //         // Si el pago sigue pendiente, volver a llamar a la función en 10 segundos
    //         $this->emit('verificarPagoQR');
    //     }
    // }

    public function edit($id)
    {
        $this->resetValidation();
        $this->mostrarFormulario = false;
        $this->open = true;

        $this->postEditId = $id;
        $ficha = Ficha::findOrFail($id);
        $this->postEdit = $ficha->toArray();
    }

    public function update()
    {
        $this->validate();
        
        $ficha = Ficha::findOrFail($this->postEditId);
        $ficha->update($this->postEdit);

        $this->reset(['postEditId', 'postEdit', 'mostrarFormulario', 'open']);
        $this->mostrarModalSucessEdit = true;
        $this->fichas = Ficha::with(['recepcionista', 'paciente', 'turnoAtencion'])->get();
    }

    public function destroy($id)
    {
        Ficha::findOrFail($id)->delete();
        $this->fichas = Ficha::with(['recepcionista', 'paciente', 'turnoAtencion'])->get();
        $this->mostrarModalEliminacion = true;
    }

    public function incrementarPaginacion()
    {
        $this->paginacion = Paginacion::where('pagina', 'ficha')->first();
        $this->paginacion->increment('contador');
        $this->paginacion->save();
        $this->contador = $this->paginacion->contador;
    }

    public function mount()
    {
        $this->recepcionistas = Recepcionista::all();
        $this->pacientes = Paciente::all();
        $this->turnosAtencion = TurnoAtencion::all();
        $this->fichas = Ficha::with(['recepcionista', 'paciente', 'turnoAtencion'])->get();
        $this->incrementarPaginacion();
    }

    public function render()
    {
        return view('livewire.formulario-ficha');
    }
}
