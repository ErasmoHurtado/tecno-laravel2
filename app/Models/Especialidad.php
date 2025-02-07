<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];

    // Relación muchos a muchos con Medico a través de ServicioMedico
    public function medicos()
    {
        return $this->hasMany(MedicoEspecialidad::class, 'id_especialidad')
                    ->with('medico');
    }
}
