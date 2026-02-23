<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\UserReserva;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CanchaController extends Controller
{
    // LISTAR TODAS LAS CANCHAS (Página del convenio)
    public function index()
    {
        $canchas = Cancha::all();
        return view('canchas.index', compact('canchas'));
    }

    // MOSTRAR UNA CANCHA + AGENDA + RESERVAS + SUBCANCHAS
    public function show(Cancha $cancha)
    {
        // Obtener subcanchas de la cancha
        $subcanchas = $cancha->subcanchas;  // ← relación belongsTo

        // Semana actual (domingo a sabado)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek   = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        // Generar días de la semana
        $dias = [];
        for ($d = 0; $d < 7; $d++) {
            $dias[] = $startOfWeek->copy()->addDays($d);
        }

        // Generar horas entre apertura y cierre
        $horaInicio = Carbon::parse($cancha->hora_apertura);
        $horaFin    = Carbon::parse($cancha->hora_cierre);

        $hours = [];
        for ($h = $horaInicio->copy(); $h->lt($horaFin); $h->addHour()) {
            $hours[] = $h->format('H:i');
        }

        // Agenda semanal solo desde user_reservas
        $reservas = UserReserva::where('cancha_id', $cancha->id)
            ->whereBetween('fecha', [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ])
            ->get()
            ->map(function ($r) {
                return (object) [
                    'fecha' => $r->fecha,
                    'hora_inicio' => $r->hora,
                    'nombre_cliente' => $r->nombre_cliente,
                    'telefono_cliente' => $r->telefono_cliente,
                    'subcancha_label' => $r->numero_subcancha ? 'Cancha '.$r->numero_subcancha : 'Sin subcancha',
                ];
            });

        // Si hay reservas fuera del horario base, ampliamos la grilla para mostrarlas.
        if ($reservas->isNotEmpty()) {
            $horaMinReserva = $reservas->min(fn($r) => Carbon::parse($r->hora_inicio)->format('H:i'));
            $horaMaxReserva = $reservas->max(fn($r) => Carbon::parse($r->hora_inicio)->format('H:i'));

            if ($horaMinReserva && Carbon::parse($horaMinReserva)->lt($horaInicio)) {
                $horaInicio = Carbon::parse($horaMinReserva)->startOfHour();
            }

            if ($horaMaxReserva) {
                $maxReserva = Carbon::parse($horaMaxReserva)->startOfHour()->addHour();
                if ($maxReserva->gt($horaFin)) {
                    $horaFin = $maxReserva;
                }
            }
        }

        // Recalcular horas con posible rango ampliado
        $hours = [];
        for ($h = $horaInicio->copy(); $h->lt($horaFin); $h->addHour()) {
            $hours[] = $h->format('H:i');
        }

        return view('canchas.show', compact(
            'cancha',
            'subcanchas',
            'reservas',
            'dias',
            'hours'
        ));
    }

    
    public function destroy(Cancha $cancha)
    {
        // Eliminar reservas asociadas
        $cancha->reservas()->delete();

        // Eliminar la cancha
        $cancha->delete();

        return redirect()->route('canchas.index')
            ->with('success', 'La cancha se eliminó correctamente');
    }
}
