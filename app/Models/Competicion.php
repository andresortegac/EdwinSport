<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competicion extends Model
{
        // ?? ESTO ES LO QUE FALTABA
    protected $table = 'competiciones';

    protected $fillable = [
        'evento',
        'estado',
    ];
    
    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento');
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }

}
