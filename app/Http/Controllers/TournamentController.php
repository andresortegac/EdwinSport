<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TeamsImport;
use App\Models\Group;   // ← NUEVO MODELO para guardar grupos
use App\Models\Team;
use Barryvdh\DomPDF\Facade\Pdf;

class TournamentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORMULARIO PRINCIPAL
    |--------------------------------------------------------------------------
    */
    public function showForm()
    {
        return view('tournament.form');
    }


    /*
    |--------------------------------------------------------------------------
    | GENERAR GRUPOS AUTOMÁTICAMENTE
    |--------------------------------------------------------------------------
    */
    public function generateGroups()
    {
        $teams = Team::pluck('name')->toArray();
        $n = count($teams);

        if ($n == 0) {
            return back()->with('error', 'No hay equipos registrados.');
        }

        // Obtener configuración óptima
        [$groupCount, $groupSize] = $this->findEqualGrouping($n);

        // Crear grupos
        $groups = $this->allocateGroups($teams, $groupCount, $groupSize);

        // Guardarlos en base de datos
        Group::truncate();   // ← limpiamos grupos anteriores

        foreach ($groups as $name => $teams) {
            Group::create([
                'name'  => $name,
                'teams' => json_encode($teams)
            ]);
        }

        return back()->with('ok', 'Grupos generados y guardados correctamente.');
    }



    /*
    |--------------------------------------------------------------------------
    | MOSTRAR GRUPOS GUARDADOS
    |--------------------------------------------------------------------------
    */
    public function showGroups()
    {
        $groups = Group::all();

        return view('tournament.groups', compact('groups'));
    }



    /*
    |--------------------------------------------------------------------------
    | EXPORTAR PDF
    |--------------------------------------------------------------------------
    */
    public function exportPdf(Request $request)
    {
        $groups = json_decode($request->input('groups', '[]'), true);

        // Contar equipos totales
        $n = 0;
        foreach ($groups as $g) {
            $n += count($g);
        }

        $style = $request->input('style', 'champions');
        $mode  = $request->input('mode', 'normal');

        $pdf = PDF::loadView('tournament.pdf', compact('groups', 'n', 'style', 'mode'));

        return $pdf->download("plantilla_torneo_{$n}_equipos.pdf");
    }



    /*
    |--------------------------------------------------------------------------
    | MÉTODOS INTERNOS (LÓGICA DEL TORNEO)
    |--------------------------------------------------------------------------
    */

    private function findEqualGrouping(int $n): array
    {
        $preferredSizes = [4, 3, 5, 6, 2, 8];

        foreach ($preferredSizes as $size) {
            if ($n % $size === 0) {
                return [$n / $size, $size];
            }
        }

        return [8, ceil($n / 8)];
    }


    private function allocateGroups(array $teams, int $groupCount, int $groupSize): array
    {
        $groups = [];
        $letters = range('A', 'Z');

        for ($i = 0; $i < $groupCount; $i++) {
            $groups["Grupo " . $letters[$i]] =
                array_slice($teams, $i * $groupSize, $groupSize);
        }

        return $groups;
    }


    private function buildBracketFromQualified(array $q): array
    {
        if (count($q) !== 8) {
            return [];
        }

        $L = range('A', 'H');
        $map = [];

        for ($i = 0; $i < 8; $i++) {
            $map[$L[$i]] = $q[$i];
        }

        return [
            [$map['A']['first'], $map['B']['second']],
            [$map['C']['first'], $map['D']['second']],
            [$map['E']['first'], $map['F']['second']],
            [$map['G']['first'], $map['H']['second']],
            [$map['B']['first'], $map['A']['second']],
            [$map['D']['first'], $map['C']['second']],
            [$map['F']['first'], $map['E']['second']],
            [$map['H']['first'], $map['G']['second']],
        ];
    }

    public function bracket()
{
    // 1. Leer los grupos guardados
    $grupos = \App\Models\Grupo::all();

    // 2. Preparar estructura de clasificados
    $clasificados = [];

    foreach ($grupos as $g) {
        $equipos = $g->equipos()->orderBy('puntos', 'desc')->take(2)->get();

        // Si no hay al menos 2 equipos, no se puede armar el bracket
        if (count($equipos) < 2) continue;

        $clasificados[] = [
            'first'  => $equipos[0]->nombre,
            'second' => $equipos[1]->nombre,
        ];
    }

    // 3. Usar la función interna que ya tienes
    $cuartos = $this->buildBracketFromQualified($clasificados);

    // 4. Enviar a la vista
    return view('tournament.bracket', compact('cuartos'));
}

}
