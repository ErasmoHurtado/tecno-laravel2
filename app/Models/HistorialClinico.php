<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    use HasFactory;
    
    protected $table = 'historial_clinicos';

    protected $fillable = [
        'diagnostico_principal',
        'alergias',
        'antecedentes_familiares',
        'antecedentes_personales',
        'tratamientos_cronicos',
        'estado',
        'paciente_id'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'historial_clinico_id');
    }

}
