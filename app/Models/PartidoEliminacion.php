<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartidoEliminacion extends Model
{
    protected $table = 'partidos_eliminacion';

    protected $fillable = [
        'competicion_id',
        'ronda',
        'slot',
        'equipo_local_id',
        'equipo_visitante_id',
        'goles_local',
        'goles_visitante',
        'ganador_id',
        'jugado_en',
    ];

    protected $casts = [
        'jugado_en' => 'datetime',
    ];

    public function competicion()
    {
        return $this->belongsTo(Competicion::class, 'competicion_id');
    }

    public function local()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    public function visitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    public function ganador()
    {
        return $this->belongsTo(Equipo::class, 'ganador_id');
    }
}
