<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory;
    
    protected $table = 'fichas';

    protected $fillable = [
        'estado',
        'recepcionista_id',
        'paciente_id',
        'turno_atencion_id'
    ];

    public function recepcionista()
    {
        return $this->belongsTo(Recepcionista::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function turnoAtencion()
    {
        return $this->belongsTo(TurnoAtencion::class);
    }

    public function pago()
    {
        return $this->hasOne(Pago::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

}
