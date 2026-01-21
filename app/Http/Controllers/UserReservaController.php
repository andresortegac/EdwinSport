<?php

namespace App\Http\Controllers;

use App\Models\UserReserva;
use App\Models\Cancha;
use Illuminate\Http\Request;

class UserReservaController extends Controller
{
    public function create(Cancha $cancha)
    {
        return view('canchas.serv', compact('cancha'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'nombre_cliente' => 'required|string',
            'telefono_cliente' => 'nullable|string',
            'fecha' => 'required|date',
            'hora' => 'required',
            'numero_subcancha' => 'required|integer|min:1|max:4',
        ]);

        UserReserva::create($data);

        return redirect()
            ->route('canchas.index')
            ->with('success', 'Reserva registrada exitosamente.');
    }
}
