<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    // =========================
    // LISTAR + FORM CREAR (MISMA VISTA)
    // =========================
    public function index()
    {
        $participantes = Participante::orderBy('id', 'desc')->get();
        return view('REGISTER.participantes', compact('participantes'));
    }

    // =========================
    // FORM CREAR (REDIRIGE A INDEX)
    // =========================
    public function create()
    {
        return redirect()->route('participantes.index');
    }

    // =========================
    // GUARDAR NUEVO PARTICIPANTE
    // =========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'   => 'required|string|max:255',
            'evento'   => 'required|string|max:255',
            'edad'     => 'nullable|integer|min:1|max:120',
            'equipo'   => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'email'    => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
        ]);

        Participante::create($data);

       return redirect()->back()->with('success', 'El evento fue creado correctamente.');
    }

    // =========================
    // FORM EDITAR (MISMA VISTA)
    // =========================
    public function edit(Participante $participante)
    {
        $participantes = Participante::orderBy('id', 'desc')->get();
        return view('REGISTER.participantes', compact('participantes', 'participante'));
    }

    // =========================
    // ACTUALIZAR PARTICIPANTE
    // =========================
    public function update(Request $request, Participante $participante)
    {
        $data = $request->validate([
            'nombre'   => 'required|string|max:255',
            'evento'   => 'required|string|max:255',
            'edad'     => 'nullable|integer|min:1|max:120',
            'equipo'   => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'email'    => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
        ]);

        $participante->update($data);

        return redirect()->route('participantes.index')
            ->with('ok', 'Participante actualizado ✅');
    }

    // =========================
    // ELIMINAR PARTICIPANTE
    // =========================
    public function destroy(Participante $participante)
    {
        $participante->delete();

        return redirect()->route('participantes.index')
            ->with('ok', 'Participante eliminado ✅');
    }
}
