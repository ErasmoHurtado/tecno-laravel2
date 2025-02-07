<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnoAtencion extends Model
{
    use HasFactory;
    
    protected $table = 'turno_atencions';
    
    protected $fillable = [
        'horario',
        'hora_inicio',
        'hora_fin',
        'dias_servicio',
        'cantidad_fichas',
        'precio',
        'medico_especialidad_id',
        'sala_id'
    ];
    
    protected $casts = [
        'dias_servicio' => 'array',
    ];

    public function medicoEspecialidad()
    {
        return $this->belongsTo(MedicoEspecialidad::class);
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function fichas()
    {
        return $this->hasMany(Ficha::class);
    }

}
