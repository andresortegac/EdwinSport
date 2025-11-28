<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamsImportService;

class TeamsController extends Controller
{
    public function importForm()
    {
        return view('equipos.import');
    }

    public function import(Request $request, TeamsImportService $importer)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $teams = $importer->import($file->getRealPath());

        // Cantidad por grupo
        $groupSize = (int) $request->input('group_size', 4);

        // Generar grupos
        $groups = $this->generateGroups($teams, $groupSize);

        // Renombrar grupos: Grupo A, Grupo B...
        $groups = $this->renameGroups($groups);

        // Contador de equipos
        $n = count($teams);

        return view('equipos.show', [
            'teams'  => $teams,
            'groups' => $groups,

            // Variables que la vista NECESITA
            'style' => 'champions',
            'mode'  => 'normal',
            'n'     => $n
        ]);
    }


    /** =============================
     * GENERADOR DE GRUPOS
     * =============================
     */
    private function generateGroups(array $teams, int $groupSize)
    {
        shuffle($teams);
        $total = count($teams);

        // Si el grupo pedido es mayor a los equipos, lo ajustamos.
        if ($groupSize > $total) {
            $groupSize = max(3, floor($total / 2));
        }

        // Dividir en grupos
        $groups = array_chunk($teams, $groupSize);

        // Si el último grupo queda MUY pequeño, redistribuir
        if (count(end($groups)) < ($groupSize / 2)) {

            $last = array_pop($groups);
            $i = 0;

            foreach ($last as $team) {
                $groups[$i % count($groups)][] = $team;
                $i++;
            }
        }

        return $groups;
    }


    /** =============================
     * RENOMBRAR GRUPOS (A, B, C...)
     * =============================
     */
    private function renameGroups(array $groups)
    {
        $letters = range('A', 'Z');
        $result = [];

        foreach ($groups as $i => $group) {
            $result["Grupo " . $letters[$i]] = $group;
        }

        return $result;
    }
}
