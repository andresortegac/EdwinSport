<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cancha_id'       => 'required',
            'fecha'           => 'required|date',
            'hora_inicio'     => 'required',
            'nombre_cliente'  => 'required',
            'telefono_cliente'=> 'nullable'
        ]);

        Reserva::create([
            'cancha_id'       => $request->cancha_id,
            'fecha'           => $request->fecha,
            'hora_inicio'     => $request->hora_inicio,
            'nombre_cliente'  => $request->nombre_cliente,
            'telefono_cliente'=> $request->telefono_cliente,
        ]);

        return back()->with('success', 'Reserva creada exitosamente.');
    }
}
