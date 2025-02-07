<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    
    protected $table = 'consultas';

    protected $fillable = [
        'motivo',
        'sintomas',
        'diagnostico',
        'estado',
        'ficha_id',
        'historial_clinico_id'
    ];

    public function ficha()
    {
        return $this->belongsTo(Ficha::class);
    }

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'historial_clinico_id');
    }

    public function tratamiento()
    {
        return $this->hasOne(Tratamiento::class);
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
}
