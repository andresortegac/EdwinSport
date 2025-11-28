<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'group_id',
        'home_score',
        'away_score',
        'starts_at',
        'status'
    ];

    // Equipo local
    public function home()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    // Equipo visitante
    public function away()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    // Grupo al que pertenece el partido
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
