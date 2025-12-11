<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';

    protected $fillable = [
    'evento',           // ✅
    'nombre_equipo',
    'nit',
    'direccion',
    'telefono_equipo',
    'email_equipo',
    'valor_inscripcion',
    'nombre_dt',
];


    public function participantes()
    {
        return $this->hasMany(Participante::class);
    }
}
