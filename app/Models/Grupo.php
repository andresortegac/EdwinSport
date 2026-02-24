<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $fillable = [
        'competicion_id',
        'nombre_grupo'
    ];

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'grupo_equipo');
    }

    public function competicion()
    {
        return $this->belongsTo(Competicion::class);
    }
}
