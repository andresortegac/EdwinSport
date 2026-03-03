<?php

namespace App\Http\Controllers;

use App\Models\Competicion;
use App\Models\Event;
use App\Models\Sponsor;
use App\Models\TablaPosicion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function media(string $path)
    {
        $path = ltrim($path, '/');

        // Evita path traversal y rutas inválidas.
        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }

    public function index(Request $request)
    {
        // Ahora filtramos por category (porque sport NO existe en tu tabla)
        $category = $request->query('category');

        $query = Event::query();

        if (!empty($category)) {
            $query->where('category', $category);
        }

        $events = $query->orderBy('start_at', 'asc')->paginate(12);

        $sponsors = Sponsor::orderBy('created_at', 'desc')->take(4)->get();

        return view('principal.evento', compact('events', 'category', 'sponsors'));
    }

    public function show(Event $event)
    {
        $competicion = Competicion::where('evento', $event->id)
            ->with(['grupos.equipos'])
            ->first();

        $grupos = $competicion
            ? $competicion->grupos->sortBy('nombre_grupo')->values()
            : collect();

        $fixturesByGroup = [];
        $standingsByGroup = [];
        $baseStart = $event->start_at ? $event->start_at->copy() : Carbon::now();
        $tablaPosicionesPorGrupo = $competicion
            ? TablaPosicion::where('competicion_id', $competicion->id)
                ->with('equipo')
                ->orderBy('grupo_id')
                ->orderByDesc('puntos')
                ->orderByDesc('dg')
                ->orderByDesc('gf')
                ->orderBy('equipo_id')
                ->get()
                ->groupBy('grupo_id')
            : collect();

        foreach ($grupos as $groupIndex => $grupo) {
            $teamNames = $grupo->equipos
                ->sortBy('id')
                ->pluck('nombre_equipo')
                ->filter()
                ->values()
                ->all();

            $fixturesByGroup[$grupo->id] = $this->buildRoundRobinFixtures(
                $teamNames,
                $baseStart,
                $groupIndex,
                (string) $event->location
            );

            $tablaGrupoReal = collect($tablaPosicionesPorGrupo->get($grupo->id, collect()))
                ->values();

            if ($tablaGrupoReal->isNotEmpty()) {
                $standingsByGroup[$grupo->id] = $tablaGrupoReal
                    ->map(function ($fila, $index) {
                        return [
                            'pos' => $index + 1,
                            'team' => optional($fila->equipo)->nombre_equipo ?? 'Equipo',
                            'pj' => (int) $fila->pj,
                            'pg' => (int) $fila->pg,
                            'pe' => (int) $fila->pe,
                            'pp' => (int) $fila->pp,
                            'gf' => (int) $fila->gf,
                            'gc' => (int) $fila->gc,
                            'dg' => (int) $fila->dg,
                            'pts' => (int) $fila->puntos,
                        ];
                    })
                    ->all();

                continue;
            }

            // Fallback inicial antes de tener resultados guardados.
            $standingsByGroup[$grupo->id] = collect($teamNames)
                ->values()
                ->map(function ($teamName, $index) {
                    return [
                        'pos' => $index + 1,
                        'team' => $teamName,
                        'pj' => 0,
                        'pg' => 0,
                        'pe' => 0,
                        'pp' => 0,
                        'gf' => 0,
                        'gc' => 0,
                        'dg' => 0,
                        'pts' => 0,
                    ];
                })
                ->all();
        }

        $groupDuels = $this->buildGroupDuels($grupos->all());
        $knockoutMatches = $this->buildKnockoutMatches($grupos->all());

        $scoringRules = [
            ['result' => 'Victoria', 'points' => 3],
            ['result' => 'Empate', 'points' => 1],
            ['result' => 'Derrota', 'points' => 0],
        ];

        $tieBreakers = [
            'Diferencia de gol (DG)',
            'Mayor cantidad de goles a favor (GF)',
            'Resultado entre los equipos empatados',
            'Sorteo, como ultima instancia',
        ];

        $arbitrationRules = [
            'Cada partido debe iniciar con arbitro principal y asistente(s) designados.',
            'Tiempo de espera maximo sugerido: 10 minutos despues de la hora programada.',
            'Toda sancion disciplinaria se aplica segun reglamento oficial del torneo.',
            'Acumulacion de tarjetas y expulsiones se registra para fases siguientes.',
            'Solo capitanes pueden dirigirse al arbitro para aclaraciones formales.',
            'Decisiones arbitrales en cancha son inapelables durante el juego.',
        ];

        return view('events.show', [
            'event' => $event,
            'competicion' => $competicion,
            'grupos' => $grupos,
            'fixturesByGroup' => $fixturesByGroup,
            'standingsByGroup' => $standingsByGroup,
            'groupDuels' => $groupDuels,
            'knockoutMatches' => $knockoutMatches,
            'scoringRules' => $scoringRules,
            'tieBreakers' => $tieBreakers,
            'arbitrationRules' => $arbitrationRules,
        ]);
    }

    public function fixtureDetail(Event $event, $grupo, $jornada, $partido)
    {
        foreach ([$grupo, $jornada, $partido] as $value) {
            if (!ctype_digit((string) $value)) {
                abort(404);
            }
        }

        $grupoId = (int) $grupo;
        $jornadaNum = (int) $jornada;
        $partidoIndex = (int) $partido;

        $competicion = Competicion::where('evento', $event->id)
            ->with(['grupos.equipos'])
            ->firstOrFail();

        $grupos = $competicion->grupos->sortBy('nombre_grupo')->values();
        $grupoModel = $grupos->firstWhere('id', $grupoId);

        if (!$grupoModel) {
            abort(404);
        }

        $groupIndex = $grupos->search(fn ($item) => (int) $item->id === (int) $grupoModel->id);
        $baseStart = $event->start_at ? $event->start_at->copy() : Carbon::now();

        $teamNames = $grupoModel->equipos
            ->sortBy('id')
            ->pluck('nombre_equipo')
            ->filter()
            ->values()
            ->all();

        $fixture = $this->buildRoundRobinFixtures(
            $teamNames,
            $baseStart,
            (int) $groupIndex,
            (string) $event->location
        );

        $roundData = collect($fixture)->firstWhere('round', $jornadaNum);

        if (!$roundData || !isset($roundData['matches'][$partidoIndex])) {
            abort(404);
        }

        $match = $roundData['matches'][$partidoIndex];

        return view('events.fixture-detail', [
            'event' => $event,
            'grupo' => $grupoModel,
            'jornada' => $jornadaNum,
            'match' => $match,
            'partidoNumero' => $partidoIndex + 1,
            'totalPartidosJornada' => count($roundData['matches']),
        ]);
    }

    public function listado()
    {
        // Mejor paginado (si quieres dejar all(), puedes, pero esto es más sano)
        $eventos = Event::orderBy('start_at', 'desc')->paginate(20);

        return view('events.listado-eventos', compact('eventos'));
    }

    public function create()
    {
        return view('events.crear-evento');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255', // puede venir vacío
            'category'    => 'required|string',
            'start_at'    => 'required|date',
            'end_at'      => 'nullable|date|after_or_equal:start_at',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:activo,inactivo,cerrado',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        // ✅ Slug limpio + único (desde slug o title)
        $baseSlug = Str::slug($request->slug ?: $request->title);
        $slug = $baseSlug;
        $i = 2;

        while (Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        // ✅ Subir imagen si existe
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('eventos', 'public');
        }

        // ✅ Guardar en BD
        $evento = new Event();
        $evento->title       = $request->title;
        $evento->slug        = $slug;
        $evento->description = $request->description;
        $evento->category    = $request->category;
        $evento->location    = $request->location;
        $evento->start_at    = $request->start_at;
        $evento->end_at      = $request->end_at;
        $evento->image       = $imagePath;
        $evento->status      = $request->status;
        $evento->save();

        return redirect()->back()->with('success', 'El evento fue creado correctamente.');
    }

    public function destroy(Request $request, Event $event)
    {
        // ✅ Borrar imagen del storage si existe
        if (!empty($event->image) && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        if ($request->filled('redirect_to')) {
            return redirect()->to($request->input('redirect_to'))
                ->with('success', 'Evento eliminado correctamente.');
        }

        return redirect()->back()->with('success', 'Evento eliminado correctamente.');
    }

    public function eliminarEvento(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->delete(); // Eliminar evento

        // Volver a la misma vista con un mensaje flash
        return back()->with('success', 'Evento eliminado correctamente.');
    }

    private function buildRoundRobinFixtures(
        array $teamNames,
        Carbon $baseStart,
        int $groupIndex,
        string $location
    ): array {
        if (count($teamNames) < 2) {
            return [];
        }

        $teams = array_values($teamNames);

        if (count($teams) % 2 !== 0) {
            $teams[] = 'Descansa';
        }

        $totalTeams = count($teams);
        $rounds = $totalTeams - 1;
        $matchesPerRound = intdiv($totalTeams, 2);
        $current = $teams;
        $fixture = [];

        for ($round = 0; $round < $rounds; $round++) {
            $matches = [];

            for ($i = 0; $i < $matchesPerRound; $i++) {
                $home = $current[$i];
                $away = $current[$totalTeams - 1 - $i];

                if ($home === 'Descansa' || $away === 'Descansa') {
                    continue;
                }

                if ($round % 2 === 1) {
                    [$home, $away] = [$away, $home];
                }

                $kickoff = $baseStart
                    ->copy()
                    ->addDays(($groupIndex * ($rounds + 1)) + $round)
                    ->setTime(9 + ($i * 2), 0);

                $matches[] = [
                    'home' => $home,
                    'away' => $away,
                    'kickoff' => $kickoff,
                    'location' => $location !== '' ? $location : 'Sede por confirmar',
                ];
            }

            $fixture[] = [
                'round' => $round + 1,
                'matches' => $matches,
            ];

            $fixed = $current[0];
            $rotating = array_slice($current, 1);
            $last = array_pop($rotating);
            array_unshift($rotating, $last);
            $current = array_merge([$fixed], $rotating);
        }

        return $fixture;
    }

    private function buildGroupDuels(array $groups): array
    {
        $duels = [];
        $total = count($groups);

        for ($i = 0; $i < $total; $i += 2) {
            if (!isset($groups[$i + 1])) {
                break;
            }

            $groupA = $groups[$i];
            $groupB = $groups[$i + 1];

            $duels[] = [
                'label' => 'Llave ' . (($i / 2) + 1),
                'group_a' => $groupA->nombre_grupo,
                'group_b' => $groupB->nombre_grupo,
                'pairings' => [
                    '1o ' . $groupA->nombre_grupo . ' vs 2o ' . $groupB->nombre_grupo,
                    '1o ' . $groupB->nombre_grupo . ' vs 2o ' . $groupA->nombre_grupo,
                ],
            ];
        }

        return $duels;
    }

    private function buildKnockoutMatches(array $groups): array
    {
        $matches = [];
        $total = count($groups);

        for ($i = 0; $i < $total; $i += 2) {
            if (!isset($groups[$i + 1])) {
                break;
            }

            $groupA = $groups[$i]->nombre_grupo;
            $groupB = $groups[$i + 1]->nombre_grupo;

            $matches[] = [
                'stage' => 'Cuadro final',
                'home' => '1o ' . $groupA,
                'away' => '2o ' . $groupB,
            ];

            $matches[] = [
                'stage' => 'Cuadro final',
                'home' => '1o ' . $groupB,
                'away' => '2o ' . $groupA,
            ];
        }

        return $matches;
    }
}
