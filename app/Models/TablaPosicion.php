<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablaPosicion extends Model
{
    protected $table = 'tabla_posiciones';

    protected $fillable = [
        'competicion_id',
        'grupo_id',
        'equipo_id',
        'pj',
        'pg',
        'pe',
        'pp',
        'gf',
        'gc',
        'dg',
        'puntos',
    ];

    public function competicion()
    {
        return $this->belongsTo(Competicion::class, 'competicion_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }
}
