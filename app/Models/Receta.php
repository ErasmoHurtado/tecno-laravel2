<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $table = 'recetas';

    protected $fillable = [
        'remedio',
        'descripcion',
        'indicaciones',
        'consulta_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
