<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReserva extends Model
{
    protected $fillable = [
        'cancha_id',
        'nombre_cliente',
        'telefono_cliente',
        'fecha',
        'hora',
        'numero_subcancha'
    ];
}
