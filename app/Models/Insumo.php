<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'marca', 'origen', 'categoria_insumo_id'];

    public function categoriainsumo(){
        return $this->belongsTo(CategoriaInsumo::class);
    }


    public function insumo(){
        return $this->hasMany(Insumo::class);
    }
}
