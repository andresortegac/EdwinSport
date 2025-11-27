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

    // MOSTRAR UNA CANCHA + AGENDA + RESERVAS
    public function show(Cancha $cancha)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $reservas = Reserva::where('cancha_id', $cancha->id)
            ->whereBetween('fecha', [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ])
            ->get();

        return view('canchas.show', compact('cancha', 'reservas', 'startOfWeek'));
    }
}
