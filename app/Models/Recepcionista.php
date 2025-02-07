<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcionista extends Model
{
    use HasFactory;
    protected $fillable = [
        'turno_trabajo','fecha_contratacion','person_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'person_id');
    }

    public function fichas()
    {
        return $this->hasMany(Ficha::class);
    }

}
