<?php

namespace App\Exports;

use App\Models\Participante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipantesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Participante::with('equipo')->get()->map(function($p){
            return [
                'equipo' => optional($p->equipo)->nombre_equipo,
                'nombre' => $p->nombre,
                'numero_camisa' => $p->numero_camisa,
                'evento' => $p->evento,
                'edad' => $p->edad,
                'division' => $p->division,
                'email' => $p->email,
                'telefono' => $p->telefono,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Equipo',
            'Nombre',
            'Numero Camisa',
            'Evento',
            'Edad',
            'Division',
            'Email',
            'Telefono',
        ];
    }
}
