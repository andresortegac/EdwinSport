<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos'; // ← importante si la tabla NO se llama "groups"

    protected $fillable = ['nombre'];

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'grupo_equipo');
    }


    
}
