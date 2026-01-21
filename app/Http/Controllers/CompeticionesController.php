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

        // ?? USAMOS EL MISMO VALOR QUE GUARDAS EN equipos.evento
        $equipos = Equipo::where('evento', $evento->title)->get();

        $competicion = Competicion::where('evento', $eventoId)->first();

        return view('COMPETICION.show', compact(
            'evento',
            'competicion',
            'equipos'
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($evento)
    {
        if (Competicion::where('evento', $evento)->exists()) {
            return back()->with('error', 'Este evento ya tiene una competición');
        }

        Competicion::create([
            'evento' => $evento,
            'estado' => 'creada'
        ]);

        return back()->with('success', 'Competición creada correctamente');
    }

    public function generarGrupos($competicionId)
    {
        $competicion = Competicion::findOrFail($competicionId);

        // evitar regenerar
        if (Grupo::where('competicion_id', $competicion->id)->exists()) {
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
            $grupo = Grupo::create([
                'competicion_id' => $competicion->id,
                'nombre_grupo' => 'Grupo ' . $letra++
            ]);

            $grupo->equipos()->attach($chunk->pluck('id'));
        }

        $competicion->update(['estado' => 'grupos_generados']);

        return back()->with('success', 'Grupos creados correctamente');
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competicion $competicion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competicion $competicion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competicion $competicion)
    {
        //
    }
}
