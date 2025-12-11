<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Participante;
use App\Models\Event;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::orderBy('id', 'desc')->get();

        $participantes = Participante::with('equipo')
            ->orderBy('id', 'desc')
            ->get();

        $eventos = Event::orderBy('start_at', 'desc')->get();

        return view('REGISTER.participantes', compact('equipos', 'participantes', 'eventos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'evento'            => 'required|string|max:255',
            'nombre_equipo'     => 'required|string|max:255',
            'nit'               => 'required|string|max:255',
            'direccion'         => 'required|string|max:255',
            'telefono_equipo'   => 'required|string|max:30',
            'email_equipo'      => 'required|email|max:255',
            'valor_inscripcion' => 'required|numeric|min:0',
            'nombre_dt'         => 'required|string|max:255',
        ]);

        Equipo::create($data);

        return back()->with('success', 'Equipo guardado correctamente ✅');
    }

    public function edit(Equipo $equipo)
    {
        $equipos = Equipo::orderBy('id', 'desc')->get();

        $participantes = Participante::with('equipo')
            ->orderBy('id', 'desc')
            ->get();

        $eventos = Event::orderBy('start_at', 'desc')->get();

        return view('REGISTER.participantes', compact('equipos', 'participantes', 'equipo', 'eventos'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $data = $request->validate([
            'evento'            => 'required|string|max:255',
            'nombre_equipo'     => 'required|string|max:255',
            'nit'               => 'required|string|max:255',
            'direccion'         => 'required|string|max:255',
            'telefono_equipo'   => 'required|string|max:30',
            'email_equipo'      => 'required|email|max:255',
            'valor_inscripcion' => 'required|numeric|min:0',
            'nombre_dt'         => 'required|string|max:255',
        ]);

        $equipo->update($data);

        return back()->with('success', 'Equipo actualizado ✅');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        return back()->with('success', 'Equipo eliminado ✅');
    }
}
