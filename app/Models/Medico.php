<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_licencia','titulo_universidad', 'origen_titulo' ,'ano_titulacion', 'person_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'person_id');
    }

    // Relación muchos a muchos con Especialidad a través de ServicioMedico
    public function especialidades()
    {
        return $this->hasMany(MedicoEspecialidad::class, 'id_medico')
                    ->with('especialidad');
    }
}
