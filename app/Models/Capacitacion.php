<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    protected $table = 'capacitaciones';

    protected $fillable = ['nombre', 'area', 'descripcion', 'requisitos', 'fecha', 'hora', 'cupo'];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
}
