<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Reserva;
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

        // Semana actual
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

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

        // Obtener reservas de esta semana con SUBCANCHA
        $reservas = Reserva::with('subcancha')
            ->where('cancha_id', $cancha->id)
            ->whereBetween('fecha', [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ])
            ->get();

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
