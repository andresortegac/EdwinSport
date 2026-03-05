<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureTecnico extends Model
{
    protected $table = 'fixture_tecnicos';

    protected $fillable = [
        'event_id',
        'grupo_id',
        'jornada',
        'partido_numero',
        'image_path',
        'local_image_path',
        'visitante_image_path',
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
