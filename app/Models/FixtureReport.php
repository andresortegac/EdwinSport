<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureReport extends Model
{
    protected $table = 'fixture_reports';

    protected $fillable = [
        'event_id',
        'grupo_id',
        'jornada',
        'partido_numero',
        'score_local',
        'score_visitante',
        'local_lineup',
        'visitante_lineup',
        'local_yellow_cards',
        'local_red_cards',
        'local_blue_cards',
        'visitante_yellow_cards',
        'visitante_red_cards',
        'visitante_blue_cards',
        'local_top_scorer',
        'local_top_scorer_goals',
        'visitante_top_scorer',
        'visitante_top_scorer_goals',
        'local_best_goalkeeper',
        'local_goalkeeper_goals_conceded',
        'visitante_best_goalkeeper',
        'visitante_goalkeeper_goals_conceded',
        'highlights',
        'updated_by',
    ];

    protected $casts = [
        'local_lineup' => 'array',
        'visitante_lineup' => 'array',
        'local_yellow_cards' => 'array',
        'local_red_cards' => 'array',
        'local_blue_cards' => 'array',
        'visitante_yellow_cards' => 'array',
        'visitante_red_cards' => 'array',
        'visitante_blue_cards' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

