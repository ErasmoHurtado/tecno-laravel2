<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicoEspecialidad extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_medico',
        'id_especialidad',
        'titulo_especialidad',
        'origen_especialidad',
        'ano_especialidad',
    ];   

    // Relaciones
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'id_medico');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }

    public function turnosAtencion()
    {
        return $this->hasMany(TurnoAtencion::class);
    }

    
}
