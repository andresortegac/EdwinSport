<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'position'];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
