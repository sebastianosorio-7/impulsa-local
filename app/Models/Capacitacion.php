<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    protected $table = 'capacitaciones';

    protected $fillable = ['nombre', 'area', 'descripcion', 'requisitos', 'fecha', 'hora', 'cupo', 'estado'];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    // Cupos libres: cuenta toda inscripción que no esté cancelada
    public function cuposDisponibles()
    {
        $ocupados = $this->inscripciones()->where('estado', '!=', 'Cancelada')->count();

        return max(0, $this->cupo - $ocupados);
    }
}