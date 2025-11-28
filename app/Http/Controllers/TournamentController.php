<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TeamsImport;
use App\Models\Game;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;

class TournamentController extends Controller
{
    public function exportPdf(Request $request)
    {
        $groups = json_decode($request->input('groups', '[]'), true);

        // Contar equipos
        $n = 0;
        foreach ($groups as $g) {
            $n += count($g);
        }

        $style = $request->input('style', 'champions');
        $mode  = $request->input('mode', 'normal');

        // PDF correcto
        $pdf = PDF::loadView('tournament.pdf', compact('groups', 'n', 'style', 'mode'));

        return $pdf->download("plantilla_torneo_{$n}_equipos.pdf");
    }

    

    public function showForm()
    {
        return view('tournament.form');
    }
    
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
}
