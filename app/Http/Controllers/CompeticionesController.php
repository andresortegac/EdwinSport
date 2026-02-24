<?php

namespace App\Http\Controllers;

use App\Models\Competicion;
use App\Models\Event;
use App\Models\Equipo;
use App\Models\Grupo;
use Illuminate\Http\Request;

class CompeticionesController extends Controller
{
    public function show($eventoId)
    {
        $evento = Event::findOrFail($eventoId);

        // ?? STRING EXACTO
        $nombreEvento = trim($evento->title);

        $equipos = Equipo::where('evento', $nombreEvento)->get();

        $competicion = Competicion::where('evento', $nombreEvento)->first();

        $grupos = $competicion
            ? $competicion->grupos()->with('equipos')->get()
            : collect();

        return view('COMPETICION.show', compact(
            'evento',
            'competicion',
            'equipos',
            'grupos'
        ));
    }



    public function competicion()
    {
        return view('COMPETICION.competicionView');
    }

    public function partidos()
    {
        return view('PARTIDOS.partidosView'); 
    }

    /**
     * Crear competicion
     */
    public function store($eventoId)
    {
        $evento = Event::findOrFail($eventoId);

        if (Competicion::where('evento', $evento->title)->exists()) {
            return back()->with('error', 'Este evento ya tiene una competici�n');
        }

        Competicion::create([
            'evento' => $evento->title, // ? "Prueba"
            'estado' => 'creada'
        ]);

        return back()->with('success', 'Competicion creada correctamente');
    }



    /**
     * Generar grupos automaticamente
     */
    public function generarGrupos($competicionId)
    {
        $competicion = Competicion::findOrFail($competicionId);

        if ($competicion->grupos()->exists()) {
            return back()->with('error', 'Los grupos ya fueron generados');
        }

        $equipos = Equipo::where('evento', $competicion->evento)
            ->inRandomOrder()
            ->get();

        if ($equipos->count() < 4) {
            return back()->with('error', 'Se requieren al menos 4 equipos');
        }

        $grupos = $equipos->chunk(4);
        $letra = 'A';

        foreach ($grupos as $chunk) {
            $grupo = $competicion->grupos()->create([
                'nombre_grupo' => 'Grupo ' . $letra++
            ]);

            $grupo->equipos()->attach($chunk->pluck('id'));
        }

        $competicion->update(['estado' => 'grupos_generados']);

        $evento = Event::where('title', $competicion->evento)->firstOrFail();

        return redirect()
            ->route('competicion.show', $evento->id)
            ->with('success', 'Grupos creados correctamente');
    }

}
