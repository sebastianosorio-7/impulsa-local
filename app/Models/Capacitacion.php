<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    use HasFactory;

    // Especificar el nombre correcto de la tabla en español
    protected $table = 'capacitaciones';

    protected $fillable = ['nombre', 'area', 'descripcion', 'cupo', 'requisitos'];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function cuposDisponibles()
    {
        // Cuenta únicamente las inscripciones activas (estado 'Inscrito')
        $inscritos = $this->inscripciones()->where('estado', 'Inscrito')->count();
        return max(0, $this->cupo - $inscritos);
    }
}