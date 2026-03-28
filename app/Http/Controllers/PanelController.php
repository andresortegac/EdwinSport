<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Event;
use App\Models\UserReserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanelController extends Controller
{
    public function index()
    {
        $eventos = Event::all();
        $equipos = Equipo::all();
        $now = Carbon::now();

        $reservas = UserReserva::with('cancha')
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        $proximasReservas = $reservas
            ->filter(fn (UserReserva $reserva) => Carbon::parse("{$reserva->fecha} {$reserva->hora}") >= $now)
            ->groupBy('cancha_id')
            ->map(function ($items) {
                $items = $items->values();

                return [
                    'cancha' => $items->first()?->cancha,
                    'reservas' => $items,
                    'total' => $items->count(),
                ];
            })
            ->values();

        $historialReservas = $reservas
            ->filter(fn (UserReserva $reserva) => Carbon::parse("{$reserva->fecha} {$reserva->hora}") < $now)
            ->groupBy('cancha_id')
            ->map(function ($items) {
                $items = $items->values();

                return [
                    'cancha' => $items->first()?->cancha,
                    'reservas' => $items,
                    'total' => $items->count(),
                ];
            })
            ->values();

        return view('usuario.panel', compact(
            'eventos',
            'equipos',
            'proximasReservas',
            'historialReservas',
        ));
    }

    public function destroy($id)
    {
        $evento = Event::findOrFail($id);

        if ($evento->image && Storage::exists('public/' . $evento->image)) {
            Storage::delete('public/' . $evento->image);
        }

        $evento->delete();

        return redirect()->route('usuario.panel')
            ->with('success', 'Evento eliminado correctamente.');
    }

    public function edit($id)
    {
        $evento = Event::findOrFail($id);

        return view('events.editar-evento', compact('evento'));
    }

    public function update(Request $request, $id)
    {
        $evento = Event::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string',
            'location'    => 'required|string',
            'start_at'    => 'required|date',
            'end_at'      => 'nullable|date',
            'status'      => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->category = $request->category;
        $evento->location = $request->location;
        $evento->start_at = $request->start_at;
        $evento->end_at = $request->end_at;
        $evento->status = $request->status;

        if ($request->hasFile('image')) {
            if ($evento->image && Storage::exists('public/' . $evento->image)) {
                Storage::delete('public/' . $evento->image);
            }

            $evento->image = $request->file('image')->store('eventos', 'public');
        }

        $evento->save();

        return redirect()->route('usuario.panel')
            ->with('success', 'Evento actualizado correctamente.');
    }
}
