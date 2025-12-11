<?php

namespace App\Imports;

use App\Models\Participante;
use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ParticipantesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $equipo = Equipo::where('nombre_equipo', $row['equipo'] ?? '')->first();

        return new Participante([
            'equipo_id' => $equipo?->id,
            'nombre' => $row['nombre'] ?? null,
            'numero_camisa' => $row['numero_camisa'] ?? null,
            'evento' => $row['evento'] ?? null,
            'edad' => $row['edad'] ?? null,
            'division' => $row['division'] ?? null,
            'email' => $row['email'] ?? null,
            'telefono' => $row['telefono'] ?? null,
        ]);
    }
}

