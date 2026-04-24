<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'discipline_payload',
        'location',
        'start_at',
        'end_at',
        'image',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'discipline_payload' => 'array',
    ];

    /**
     * Equipos inscritos en el evento
     * campo FK: equipos.evento
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'evento');
    }

    /**
     * Competicion del evento (una sola)
     * campo FK: competiciones.evento
     */
    public function competicion()
    {
        return $this->hasOne(Competicion::class, 'evento');
    }
}
