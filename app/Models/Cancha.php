<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'ubicacion',
        'telefono_contacto',
        'hora_apertura',
        'hora_cierre',
        'num_canchas'
    ];

   public function subcanchas()
{
    return $this->hasMany(Subcancha::class);
}

public function reservas()
{
    return $this->hasMany(Reserva::class);
}


}


