<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureStream extends Model
{
    protected $table = 'fixture_streams';

    protected $fillable = [
        'event_id',
        'grupo_id',
        'jornada',
        'partido_numero',
        'live_url',
        'platform',
        'updated_by',
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
