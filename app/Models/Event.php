<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    protected $fillable = [
        'title','sport','description','start_at','location','category','capacity','price','image','status'
    ];
    protected $dates = ['start_at'];
    
}
