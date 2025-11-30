<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'cancha_id',
        'usuario_id',
        'fecha',
        'hora_inicio',
        'nombre_cliente',
        'telefono_cliente'
    ];

    public function cancha() {
        return $this->belongsTo(Cancha::class);
    }
        public function subcancha()
    {
        return $this->belongsTo(Subcancha::class);
    }

    

}
