<?php

use App\Livewire\FormularioPago;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/rol', function () {
        return view('view-formulario-rol');
    })->name('formulario.roles');       
    
    
    Route::get('/personal', function () {
        return view('view-formulario-personal');
    })->name('formulario.personal');
    

    // Route::get('/pago', function () {
    //     return view('view-formulario-pago');
    // })->name('formulario.pagos');
    
    Route::get('/especialidad', function () {
        return view('view-formulario-especialidad');
    })->name('formulario.especialidades');

    Route::get('/sala', function () {
        return view('view-formulario-sala');
    })->name('formulario.salas');

    Route::get('/medico', function () {
        return view('view-formulario-medico');
    })->name('formulario.medicos');

    Route::get('/paciente', function () {
        return view('view-formulario-paciente');
    })->name('formulario.pacientes');

    Route::get('/recepcionista', function () {
        return view('view-formulario-recepcionista');
    })->name('formulario.recepcionistas');

    Route::get('/medico-especialidad', function () {
        return view('view-formulario-medico-especialidad');
    })->name('formulario.medico.especialidad');

    Route::get('/turno-atencion', function () {
        return view('view-formulario-turno-atencion');
    })->name('formulario.turno.atencion');

    Route::get('/ficha', function () {
        return view('view-formulario-ficha');
    })->name('formulario.fichas');

    Route::get('/consulta-medica', function () {
        return view('view-formulario-consulta');
    })->name('formulario.consulta.medica');

    Route::get('/consultas-realizadas', function () {
        return view('view-formulario-consultas-realizadas');
    })->name('formulario.consultas.realizadas');

    Route::get('/historias-clinicas', function () {
        return view('view-formulario-historiales-clinicos');
    })->name('formulario.historias.clinicas');
    
    Route::get('/pago', function () {
        return view('view-formulario-pago');
    })->name('formulario.pagos');
    
    //Armar pagoFacil
    /*

    

    

    use App\Http\Controllers\ConsumirServicioController;
    
    Route::post('/consumirServicio', [ConsumirServicioController::class, 'RecolectarDatos']);
    Route::post('/consultar', [ConsumirServicioController::class, 'ConsultarEstado']);
    */
    
});

//Callback
//Route::post('/registrarPago', [App\Livewire\FormularioPago::class, 'urlCallback']);

