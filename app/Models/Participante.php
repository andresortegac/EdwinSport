<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    // ✅ nombre real de la tabla en tu BD
    protected $table = 'participantes';

    // ✅ si tu tabla NO tiene created_at / updated_at
    public $timestamps = false;

    // ✅ campos permitidos para create() y update()
    protected $fillable = [
        'nombre',
        'evento',
        'edad',
        'equipo',
        'division',
        'email',
        'telefono',
    ];
}
