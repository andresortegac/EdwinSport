<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
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
}
