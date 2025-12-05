<?php
namespace App\Http\Controllers;

use App\Models\UserReserva;
use Illuminate\Http\Request;

class UserReservaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'nombre_cliente' => 'required|string',
            'telefono_cliente' => 'nullable|string',
            'fecha' => 'required|date',
            'hora' => 'required',
            'numero_subcancha' => 'required|integer|min=1|max:4',
        ]);

        UserReserva::create($data);

        return back()->with('success', 'Reserva registrada exitosamente.');
    }
}
