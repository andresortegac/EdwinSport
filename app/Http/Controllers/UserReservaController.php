<?php

namespace App\Http\Controllers;

use App\Models\UserReserva;
use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\Subcancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserReservaController extends Controller
{
    public function create(Cancha $cancha)
    {
        return view('canchas.serv', compact('cancha'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
        ]);

        $cancha = Cancha::findOrFail($request->input('cancha_id'));

        $data = $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'nombre_cliente' => 'required|string',
            'telefono_cliente' => 'nullable|string',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'numero_subcancha' => 'required|integer|min:1|max:'.$cancha->num_canchas,
        ]);

        $horaReserva = substr($data['hora'], 0, 5);
        $horaApertura = substr((string) $cancha->hora_apertura, 0, 5);
        $horaCierre = substr((string) $cancha->hora_cierre, 0, 5);

        // Reserva valida solo dentro del horario operativo de la cancha.
        if ($horaReserva < $horaApertura || $horaReserva >= $horaCierre) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora' => "La hora debe estar entre {$horaApertura} y {$horaCierre}.",
                ]);
        }

        $subcancha = Subcancha::where('cancha_id', $data['cancha_id'])
            ->where('nombre', 'Cancha '.$data['numero_subcancha'])
            ->first();

        $ocupada = Reserva::where('cancha_id', $data['cancha_id'])
            ->where('fecha', $data['fecha'])
            ->where('hora_inicio', $data['hora'])
            ->exists();

        if ($ocupada) {
            return back()
                ->withInput()
                ->withErrors(['hora' => 'Esa fecha y hora ya esta ocupada.']);
        }

        try {
            DB::transaction(function () use ($data, $subcancha) {
                // Se mantiene el historial propio de reservas de usuario
                UserReserva::create($data);

                // Se registra en la tabla que consume Agenda semanal
                Reserva::create([
                    'cancha_id' => $data['cancha_id'],
                    'subcancha_id' => $subcancha?->id,
                    'fecha' => $data['fecha'],
                    'hora_inicio' => $data['hora'],
                    'nombre_cliente' => $data['nombre_cliente'],
                    'telefono_cliente' => $data['telefono_cliente'] ?? null,
                ]);
            });
        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo registrar la reserva. Intenta nuevamente.');
        }

        return redirect()
            ->route('user_reservas.create', $data['cancha_id'])
            ->with('success', 'Reserva registrada exitosamente.');
    }
}
