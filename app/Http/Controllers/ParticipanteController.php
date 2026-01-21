<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use App\Models\Equipo;
use App\Models\Event;
use Illuminate\Http\Request;

// ✅ Excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParticipantesExport;
use App\Imports\ParticipantesImport;

// ✅ NUEVO: export planilla por equipo
use App\Exports\PlanillaEquipoExport;

// ✅ NUEVO: PDF
use Barryvdh\DomPDF\Facade\Pdf;

class ParticipanteController extends Controller
{
    /**
     * Carga los datos comunes que necesita la vista REGISTER.participantes
     */
    private function getDatosFormulario(Participante $participante = null): array
    {
        $equipos = Equipo::orderBy('nombre_equipo')->get();

        $participantes = Participante::with('equipo')
            ->orderBy('id', 'desc')
            ->get();

        $eventos = Event::orderBy('start_at', 'desc')->get();

        // compact crea array con las variables
        return compact('participantes', 'equipos', 'eventos', 'participante');
    }

    /**
     * Lista de participantes + formulario (vista principal)
     */
    public function index()
    {
        return view('REGISTER.participantes', $this->getDatosFormulario());
    }

    /**
     * Mostrar formulario de registro (la usaremos para /registrar-participantes)
     * En tu caso, muestra lo mismo que index.
     */
    public function create()
    {
        return view('REGISTER.participantes', $this->getDatosFormulario());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'equipo_id'      => 'required|exists:equipos,id',
            'nombre'         => 'required|string|max:255',
            'numero_camisa'  => 'nullable|string|max:10',
            'edad'           => 'nullable|integer|min:1|max:120',
            'division'       => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'telefono'       => 'nullable|string|max:30',
        ]);

        // ✅ evento automático desde el equipo
        $equipo = Equipo::findOrFail($data['equipo_id']);
        $data['evento'] = $equipo->evento;

        Participante::create($data);

        return back()->with('ok', 'Jugador guardado correctamente ✅');
    }

    public function edit(Participante $participante)
    {
        // misma vista pero con $participante para editar
        return view('REGISTER.participantes', $this->getDatosFormulario($participante));
    }

    public function update(Request $request, Participante $participante)
    {
        $data = $request->validate([
            'equipo_id'      => 'required|exists:equipos,id',
            'nombre'         => 'required|string|max:255',
            'numero_camisa'  => 'nullable|string|max:10',
            'edad'           => 'nullable|integer|min:1|max:120',
            'division'       => 'nullable|string|max:100',
            'email'          => 'nullable|email|max:255',
            'telefono'       => 'nullable|string|max:30',
        ]);

        $equipo = Equipo::findOrFail($data['equipo_id']);
        $data['evento'] = $equipo->evento;

        $participante->update($data);

        return back()->with('ok', 'Jugador actualizado ✅');
    }

    public function destroy(Participante $participante)
    {
        $participante->delete();

        return back()->with('ok', 'Jugador eliminado ✅');
    }

    // =========================
    // EXPORT GENERAL DE TODOS LOS PARTICIPANTES (EXCEL)
    // =========================
    public function exportExcel()
    {
        return Excel::download(new ParticipantesExport, 'participantes.xlsx');
    }

    // =========================
    // IMPORTAR PARTICIPANTES DESDE EXCEL
    // =========================
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new ParticipantesImport, $request->file('file'));

        return back()->with('ok', 'Participantes importados correctamente ✅');
    }

    // =========================
    // ✅ NUEVO: EXPORTAR PLANILLA POR EQUIPO (EXCEL)
    // =========================
    public function exportPlanillaExcel(Request $request)
    {
        $equipoId = $request->input('equipo_id');
        $equipo   = Equipo::with('participantes')->findOrFail($equipoId);

        return Excel::download(
            new PlanillaEquipoExport($equipo),
            'planilla_' . $equipo->nombre_equipo . '.xlsx'
        );
    }

    // =========================
    // ✅ NUEVO: EXPORTAR PLANILLA POR EQUIPO (PDF)
    // =========================
    public function exportPlanillaPdf(Request $request)
    {
        $equipoId = $request->input('equipo_id');

        $equipo = Equipo::with('participantes')->findOrFail($equipoId);

        $pdf = Pdf::loadView('events.planilla_equipo', [
            'equipo' => $equipo,
        ]);

        return $pdf->download('planilla_' . $equipo->nombre_equipo . '.pdf');
    }
}
