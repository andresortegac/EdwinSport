<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PlanillaEquipoExport implements FromView, WithTitle
{
    protected $equipo;

    public function __construct($equipo)
    {
        $this->equipo = $equipo;
    }

    public function view(): View
    {
        return view('events.planilla_equipo', [
            'equipo' => $this->equipo,
        ]);
    }

    // 🔴 AQUÍ está el título de la hoja
    public function title(): string
    {
        // Título fijo, corto y seguro
        return 'Planilla';
    }
}
