<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competicion extends Model
{
    protected $table = 'competiciones';

    protected $fillable = [
        'evento',
        'estado'
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'competicion_id');
    }

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento');
    }
}
