<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
     protected $table = 'capacitaciones';
    protected $fillable = [
        'nombre',
        'area',
        'cupos',
        'estado'
    ];

    public function cuposDisponibles()
    {
        $inscritos = $this->hasMany(Inscripcion::class, 'capacitacion_id')
            ->where('estado', '!=', 'cancelada')
            ->count();

        return $this->cupo - $inscritos;
    }
}
