<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    // Nombre real de la tabla en tu BD
    protected $table = 'participantes';

    // Si tu tabla NO tiene created_at / updated_at
    public $timestamps = false;

    // Clave primaria (solo cambia esto si tu PK no es "id")
    // protected $primaryKey = 'id'; 

    // Campos permitidos para create() y update()
    protected $fillable = [
    'equipo_id',
    'nombre',
    'numero_camisa',
    'evento',
    'edad',
    'division',
    'email',
    'telefono'
];


    /**
     * Relación: un Participante pertenece a un Equipo
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
        // 👆 Si tu columna FK en participantes se llama "equipo" en vez de "equipo_id",
        // entonces cambia la línea a:
        // return $this->belongsTo(Equipo::class, 'equipo');
    }
}
