<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcancha extends Model
{
    use HasFactory;

    protected $fillable = [
        'cancha_id',
        'nombre',
        'activo',
    ];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
