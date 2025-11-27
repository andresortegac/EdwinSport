<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactenos extends Model
{
    protected $table = 'contactenos';

    protected $fillable = [
        'tipo',
        'nombre_completo',
        'documento',
        'telefono_natural',
        'correo_electronico',
        'razon_social',
        'evento_nombre',
        'categoria',
        'descripcion',
        'fecha_inicial',
        'fecha_final',
    ];
}
