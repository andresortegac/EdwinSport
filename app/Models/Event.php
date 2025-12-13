<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'location',
        'start_at',
        'end_at',
        'image',
        'status',
    ];

    // Castear las fechas a datetime (Carbon)
    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
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
     * Competición del evento (UNA sola)
     * campo FK: competiciones.evento
     */
    public function competicion()
    {
        return $this->hasOne(Competicion::class, 'evento');
    }
}
