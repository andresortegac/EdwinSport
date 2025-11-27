<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'nombre_cliente' => 'required|string|max:255',
            'telefono_cliente' => 'nullable|string|max:50',
        ]);

        // verificar rango válido
        $cancha = Cancha::find($data['cancha_id']);
        $hora = Carbon::createFromFormat('H:i', $data['hora_inicio']);

        if ($hora->lt(Carbon::parse($cancha->hora_apertura)) ||
            $hora->gte(Carbon::parse($cancha->hora_cierre))) {
            return back()->withErrors(['hora_inicio' => 'Hora fuera del horario permitido']);
        }

        try {
            Reserva::create($data);
            return back()->with('success', 'Reserva creada correctamente');
        } catch (\Exception $e) {
            return back()->withErrors(['hora_inicio' => 'Ya existe una reserva para esta hora.']);
        }
    }
}
