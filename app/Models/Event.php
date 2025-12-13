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
}
