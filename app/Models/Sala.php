<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;
    protected $fillable = ['codigo', 'tipo'];

    /**
     * Relación con el modelo Turno.
     * Una sala puede tener muchos turnos.
     */
    public function turnosAtencion()
    {
        return $this->hasMany(TurnoAtencion::class);
    }
}
