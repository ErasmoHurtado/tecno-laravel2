<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    
    protected $table = 'pagos';

    protected $fillable = [
        'metodo',
        'monto',
        'ficha_id',
        'estado'
    ];

    public function ficha()
    {
        return $this->belongsTo(Ficha::class);
    }
}
