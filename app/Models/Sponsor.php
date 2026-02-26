<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $table = 'sponsors'; // opcional

    protected $fillable = [
        'name',     // nombre real en BD
        'nombre',   // alias legacy (formularios actuales)
        'image',    // nombre real en BD
        'logo',     // alias legacy (formularios actuales)
        'url',      // enlace opcional
    ];

    // Compatibilidad: permite leer $sponsor->nombre aunque la columna sea `name`.
    public function getNombreAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    // Compatibilidad: permite asignar `nombre` y persistirlo en `name`.
    public function setNombreAttribute(?string $value): void
    {
        $this->attributes['name'] = $value;
    }

    // Compatibilidad: permite leer $sponsor->logo aunque la columna sea `image`.
    public function getLogoAttribute(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    // Compatibilidad: permite asignar `logo` y persistirlo en `image`.
    public function setLogoAttribute(?string $value): void
    {
        $this->attributes['image'] = $value;
    }
}
