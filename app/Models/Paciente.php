<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_sangre', 'fecha_registro', 'person_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'person_id');
    }

    public function historialClinico()
    {
        return $this->hasOne(HistorialClinico::class, 'paciente_id');
    }


    public function fichas()
    {
        return $this->hasMany(Ficha::class);
    }
}
