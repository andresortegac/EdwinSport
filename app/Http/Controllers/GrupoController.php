<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Team;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function store(Request $request)
    {
        $groups = json_decode($request->groups, true);

        foreach ($groups as $groupName => $teams) {

            // Crear grupo
            $grupo = Grupo::create([
                'nombre' => $groupName
            ]);

            // Asignar los equipos al grupo
            foreach ($teams as $teamName) {
                Team::where('name', $teamName)->update([
                    'grupo_id' => $grupo->id
                ]);
            }
        }

        return redirect()->route('torneo.ver')->with('ok', 'Sorteo guardado correctamente.');
    }

   public function index()
    {
        $grupos = Grupo::with('equipos')->get();
        return view('tournament.saved', compact('grupos'));
    }
}
