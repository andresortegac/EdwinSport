<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $table = 'sponsors'; // opcional

    protected $fillable = [
        'nombre',   // nombre del sponsor
        'logo',     // ruta de la imagen
        'url',      // enlace opcional
    ];
}
