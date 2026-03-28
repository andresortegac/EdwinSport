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
        'numero_subcancha',
        'estado_solicitud',
        'external_reference',
        'external_sync_status',
        'external_sync_message',
        'external_sent_at',
    ];

    protected $casts = [
        'external_sent_at' => 'datetime',
    ];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }
}
