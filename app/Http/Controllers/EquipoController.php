<?php

namespace App\Http\Controllers;

use App\Models\Competicion;
use App\Models\Equipo;
use App\Models\Event;
use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'evento' => 'required|string|max:255',
            'nombre_equipo' => 'required|string|max:255',
            'nit' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono_equipo' => 'required|string|max:30',
            'email_equipo' => 'required|email|max:255',
            'valor_inscripcion' => 'required|numeric|min:0',
            'nombre_dt' => 'required|string|max:255',
        ]);

        Equipo::create($data);
        $this->generarGruposAutomaticamenteParaEvento($data['evento']);

        return back()->with('success', 'Equipo guardado correctamente');
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
            'evento' => 'required|string|max:255',
            'nombre_equipo' => 'required|string|max:255',
            'nit' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono_equipo' => 'required|string|max:30',
            'email_equipo' => 'required|email|max:255',
            'valor_inscripcion' => 'required|numeric|min:0',
            'nombre_dt' => 'required|string|max:255',
        ]);

        $equipo->update($data);
        $this->generarGruposAutomaticamenteParaEvento($data['evento']);

        return back()->with('success', 'Equipo actualizado');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        return back()->with('success', 'Equipo eliminado');
    }

    private function generarGruposAutomaticamenteParaEvento(string $nombreEvento): void
    {
        $evento = Event::where('title', trim($nombreEvento))->first();

        if (!$evento) {
            return;
        }

        $competicion = Competicion::where('evento', $evento->id)->first();

        if (!$competicion) {
            return;
        }

        if ($competicion->grupos()->exists()) {
            if ($competicion->estado !== 'grupos_generados') {
                $competicion->update(['estado' => 'grupos_generados']);
            }

            return;
        }

        $equipos = Equipo::where('evento', trim($evento->title))
            ->inRandomOrder()
            ->get();

        if ($equipos->count() < 4) {
            return;
        }

        DB::transaction(function () use ($competicion, $equipos) {
            $letra = 'A';

            foreach ($equipos->chunk(4) as $chunk) {
                $grupo = $competicion->grupos()->create([
                    'nombre_grupo' => 'Grupo ' . $letra++,
                ]);

                $grupo->equipos()->attach($chunk->pluck('id'));
            }

            $competicion->update(['estado' => 'grupos_generados']);
        });
    }
}
