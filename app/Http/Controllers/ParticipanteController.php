<?php

namespace App\Http\Controllers;

use App\Exports\ParticipantesExport;
use App\Exports\PlanillaEquipoExport;
use App\Imports\ParticipantesImport;
use App\Models\Equipo;
use App\Models\Event;
use App\Models\Participante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParticipanteController extends Controller
{
    /**
     * Carga los datos comunes de la vista de participantes.
     */
    private function getDatosFormulario(Participante $participante = null): array
    {
        $equipos = Equipo::orderBy('nombre_equipo')->get();

        $participantes = Participante::with('equipo')
            ->orderBy('id', 'desc')
            ->get();

        $eventos = Event::orderBy('start_at', 'desc')->get();

        return compact('participantes', 'equipos', 'eventos', 'participante');
    }

    public function index()
    {
        return view('register.participantes', $this->getDatosFormulario());
    }

    public function create()
    {
        return view('register.participantes', $this->getDatosFormulario());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'nombre' => 'required|string|max:255',
            'numero_camisa' => 'nullable|string|max:10',
            'edad' => 'nullable|integer|min:1|max:120',
            'division' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
        ]);

        $equipo = Equipo::findOrFail($data['equipo_id']);
        $data['evento'] = $equipo->evento;

        Participante::create($data);

        return back()->with('ok', 'Jugador guardado correctamente.');
    }

    public function edit(Participante $participante)
    {
        return view('register.participantes', $this->getDatosFormulario($participante));
    }

    public function update(Request $request, Participante $participante)
    {
        $data = $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'nombre' => 'required|string|max:255',
            'numero_camisa' => 'nullable|string|max:10',
            'edad' => 'nullable|integer|min:1|max:120',
            'division' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
        ]);

        $equipo = Equipo::findOrFail($data['equipo_id']);
        $data['evento'] = $equipo->evento;

        $participante->update($data);

        return back()->with('ok', 'Jugador actualizado.');
    }

    public function destroy(Participante $participante)
    {
        $participante->delete();

        return back()->with('ok', 'Jugador eliminado.');
    }

    public function exportExcel()
    {
        return Excel::download(new ParticipantesExport(), 'participantes.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new ParticipantesImport();

        try {
            Excel::import($import, $request->file('file'));
        } catch (\Throwable $e) {
            $esErrorZip = str_contains($e->getMessage(), 'ZipArchive') || !extension_loaded('zip');

            if ($esErrorZip) {
                return back()->with(
                    'ok',
                    'No se pudo importar .xlsx/.xls porque falta la extension ZIP en PHP (ZipArchive). Habilita php_zip en php.ini o usa CSV temporalmente.'
                );
            }

            throw $e;
        }

        $mensaje = "Importacion finalizada: {$import->getImportados()} importados";
        if ($import->getOmitidos() > 0) {
            $mensaje .= ", {$import->getOmitidos()} omitidos";
        }
        $mensaje .= '.';

        $observaciones = $import->getObservaciones();
        if (!empty($observaciones)) {
            $mensaje .= ' Observaciones: ' . implode(' ', array_slice($observaciones, 0, 3));
            if (count($observaciones) > 3) {
                $mensaje .= ' ...';
            }
        }

        return back()->with('ok', $mensaje);
    }

    public function exportPlanillaExcel(Request $request)
    {
        $equipoId = $request->input('equipo_id');
        $equipo = Equipo::with('participantes')->findOrFail($equipoId);

        return Excel::download(
            new PlanillaEquipoExport($equipo),
            'planilla_' . $equipo->nombre_equipo . '.xlsx'
        );
    }

    public function exportPlanillaPdf(Request $request)
    {
        $equipoId = $request->input('equipo_id');
        $equipo = Equipo::with('participantes')->findOrFail($equipoId);

        $pdf = Pdf::loadView('events.planilla_equipo', [
            'equipo' => $equipo,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('planilla_' . $equipo->nombre_equipo . '.pdf');
    }
}
