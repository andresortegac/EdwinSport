<?php

namespace App\Http\Controllers;

use App\Models\Competicion;
use App\Models\Event;
use App\Models\FixtureReport;
use App\Models\FixtureStream;
use App\Models\FixtureTecnico;
use App\Models\Partido;
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

        // Evita path traversal y rutas invÃ¡lidas.
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

    public function calendar(Request $request)
    {
        $fecha = (string) $request->query('fecha', '');
        $estado = (string) $request->query('estado', '');
        $allowedStatuses = ['activo', 'cerrado', 'inactivo'];
        $selectedDate = null;

        if ($fecha !== '') {
            try {
                $selectedDate = Carbon::createFromFormat('Y-m-d', $fecha, 'America/Bogota')->startOfDay();
            } catch (\Throwable $e) {
                $selectedDate = null;
                $fecha = '';
            }
        }

        if (!in_array($estado, $allowedStatuses, true)) {
            $estado = '';
        }

        $query = Event::query();

        if ($selectedDate) {
            $query->whereDate('start_at', $selectedDate->toDateString());
        }

        if ($estado !== '') {
            $query->where('status', $estado);
        }

        $events = $query
            ->orderBy('start_at', 'asc')
            ->paginate(18)
            ->withQueryString();

        $today = now('America/Bogota')->startOfDay();

        return view('events.calendar', [
            'events' => $events,
            'fecha' => $fecha,
            'estado' => $estado,
            'today' => $today,
        ]);
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

        $fixtureContext = $this->resolveFixtureContext($event, $grupoId, $jornadaNum, $partidoIndex);
        if (!$fixtureContext) {
            abort(404);
        }

        $partidoNumero = $partidoIndex + 1;
        $liveStream = FixtureStream::query()
            ->where('event_id', $event->id)
            ->where('grupo_id', $grupoId)
            ->where('jornada', $jornadaNum)
            ->where('partido_numero', $partidoIndex)
            ->first();

        $fixtureTecnico = FixtureTecnico::query()
            ->where('event_id', $event->id)
            ->where('grupo_id', $grupoId)
            ->where('jornada', $jornadaNum)
            ->where('partido_numero', $partidoIndex)
            ->first();

        $fixtureReport = FixtureReport::query()
            ->where('event_id', $event->id)
            ->where('grupo_id', $grupoId)
            ->where('jornada', $jornadaNum)
            ->where('partido_numero', $partidoIndex)
            ->first();

        $homeRoster = $fixtureContext['homeTeam']
            ? $fixtureContext['homeTeam']->participantes()->orderBy('numero_camisa')->orderBy('nombre')->get()
            : collect();

        $awayRoster = $fixtureContext['awayTeam']
            ? $fixtureContext['awayTeam']->participantes()->orderBy('numero_camisa')->orderBy('nombre')->get()
            : collect();

        return view('events.fixture-detail', [
            'event' => $event,
            'grupo' => $fixtureContext['grupo'],
            'jornada' => $jornadaNum,
            'match' => $fixtureContext['match'],
            'homeTeam' => $fixtureContext['homeTeam'],
            'awayTeam' => $fixtureContext['awayTeam'],
            'matchScore' => $fixtureContext['score'],
            'partidoNumero' => $partidoNumero,
            'partidoIndex' => $partidoIndex,
            'totalPartidosJornada' => $fixtureContext['totalPartidosJornada'],
            'liveStream' => $liveStream,
            'fixtureTecnico' => $fixtureTecnico,
            'fixtureReport' => $fixtureReport,
            'homeRoster' => $homeRoster,
            'awayRoster' => $awayRoster,
        ]);
    }

    public function storeFixtureStream(Request $request)
    {
        $data = $request->validateWithBag('liveStream', [
            'event_id' => 'required|integer|exists:events,id',
            'grupo_id' => 'required|integer|exists:grupos,id',
            'jornada' => 'required|integer|min:1',
            'partido_numero' => 'required|integer|min:0',
            'live_url' => 'required|url|max:2048',
        ]);

        $event = Event::findOrFail((int) $data['event_id']);
        $grupoId = (int) $data['grupo_id'];
        $jornada = (int) $data['jornada'];
        $partidoIndex = (int) $data['partido_numero'];

        $fixtureContext = $this->resolveFixtureContext($event, $grupoId, $jornada, $partidoIndex);
        if (!$fixtureContext) {
            return back()
                ->withErrors([
                    'partido_numero' => 'No encontramos ese partido para el evento/grupo/jornada indicados.',
                ], 'liveStream')
                ->withInput();
        }

        $platform = $this->detectLivePlatform((string) $data['live_url']);
        if (!$platform) {
            return back()
                ->withErrors([
                    'live_url' => 'Solo se aceptan enlaces de YouTube, Facebook, Instagram o TikTok.',
                ], 'liveStream')
                ->withInput();
        }

        FixtureStream::updateOrCreate(
            [
                'event_id' => $event->id,
                'grupo_id' => $grupoId,
                'jornada' => $jornada,
                'partido_numero' => $partidoIndex,
            ],
            [
                'live_url' => (string) $data['live_url'],
                'platform' => $platform,
                'updated_by' => auth()->id(),
            ]
        );

        return redirect()
            ->back()
            ->with('live_success', 'Transmision en vivo guardada correctamente.')
            ->with('live_fixture_url', route('events.fixture.detail', [$event->id, $grupoId, $jornada, $partidoIndex]));
    }

    public function storeFixtureTecnico(Request $request)
    {
        $data = $request->validateWithBag('tecnicoImage', [
            'event_id' => 'required|integer|exists:events,id',
            'grupo_id' => 'required|integer|exists:grupos,id',
            'jornada' => 'required|integer|min:1',
            'partido_numero' => 'required|integer|min:0',
            'tecnico_image_local' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tecnico_image_visitante' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $event = Event::findOrFail((int) $data['event_id']);
        $grupoId = (int) $data['grupo_id'];
        $jornada = (int) $data['jornada'];
        $partidoIndex = (int) $data['partido_numero'];

        $fixtureContext = $this->resolveFixtureContext($event, $grupoId, $jornada, $partidoIndex);
        if (!$fixtureContext) {
            return back()
                ->withErrors([
                    'partido_numero' => 'No encontramos ese partido para el evento/grupo/jornada indicados.',
                ], 'tecnicoImage')
                ->withInput();
        }

        $existing = FixtureTecnico::query()
            ->where('event_id', $event->id)
            ->where('grupo_id', $grupoId)
            ->where('jornada', $jornada)
            ->where('partido_numero', $partidoIndex)
            ->first();

        $localImagePath = $request->file('tecnico_image_local')->store('eventos/tecnicos', 'public');
        $visitanteImagePath = $request->file('tecnico_image_visitante')->store('eventos/tecnicos', 'public');

        if ($existing) {
            $oldPaths = array_filter(array_unique([
                $existing->image_path,
                $existing->local_image_path,
                $existing->visitante_image_path,
            ]));

            foreach ($oldPaths as $oldPath) {
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        }

        FixtureTecnico::updateOrCreate(
            [
                'event_id' => $event->id,
                'grupo_id' => $grupoId,
                'jornada' => $jornada,
                'partido_numero' => $partidoIndex,
            ],
            [
                // Mantenemos image_path por compatibilidad con registros anteriores.
                'image_path' => $localImagePath,
                'local_image_path' => $localImagePath,
                'visitante_image_path' => $visitanteImagePath,
                'updated_by' => auth()->id(),
            ]
        );

        return redirect()
            ->back()
            ->with('tecnico_success', 'Imagenes de ambos equipos guardadas correctamente.')
            ->with('tecnico_fixture_url', route('events.fixture.detail', [$event->id, $grupoId, $jornada, $partidoIndex]));
    }

    public function storeFixtureReport(Request $request)
    {
        $data = $request->validateWithBag('fixtureReport', [
            'event_id' => 'required|integer|exists:events,id',
            'grupo_id' => 'required|integer|exists:grupos,id',
            'jornada' => 'required|integer|min:1',
            'partido_numero' => 'required|integer|min:0',
            'score_local' => 'nullable|integer|min:0|max:99',
            'score_visitante' => 'nullable|integer|min:0|max:99',
            'local_lineup' => 'nullable|string|max:6000',
            'visitante_lineup' => 'nullable|string|max:6000',
            'local_yellow_cards' => 'nullable|string|max:4000',
            'local_red_cards' => 'nullable|string|max:4000',
            'local_blue_cards' => 'nullable|string|max:4000',
            'visitante_yellow_cards' => 'nullable|string|max:4000',
            'visitante_red_cards' => 'nullable|string|max:4000',
            'visitante_blue_cards' => 'nullable|string|max:4000',
            'local_top_scorer' => 'nullable|string|max:120',
            'local_top_scorer_goals' => 'nullable|integer|min:0|max:99',
            'visitante_top_scorer' => 'nullable|string|max:120',
            'visitante_top_scorer_goals' => 'nullable|integer|min:0|max:99',
            'local_best_goalkeeper' => 'nullable|string|max:120',
            'local_goalkeeper_goals_conceded' => 'nullable|integer|min:0|max:99',
            'visitante_best_goalkeeper' => 'nullable|string|max:120',
            'visitante_goalkeeper_goals_conceded' => 'nullable|integer|min:0|max:99',
            'highlights' => 'nullable|string|max:4000',
        ]);

        $scoreLocal = $data['score_local'] ?? null;
        $scoreVisitante = $data['score_visitante'] ?? null;
        if (($scoreLocal === null) xor ($scoreVisitante === null)) {
            return back()
                ->withErrors([
                    'score_local' => 'Para guardar marcador debes completar ambos campos (local y visitante).',
                ], 'fixtureReport')
                ->withInput();
        }

        $event = Event::findOrFail((int) $data['event_id']);
        $grupoId = (int) $data['grupo_id'];
        $jornada = (int) $data['jornada'];
        $partidoIndex = (int) $data['partido_numero'];

        $fixtureContext = $this->resolveFixtureContext($event, $grupoId, $jornada, $partidoIndex);
        if (!$fixtureContext) {
            return back()
                ->withErrors([
                    'partido_numero' => 'No encontramos ese partido para el evento/grupo/jornada indicados.',
                ], 'fixtureReport')
                ->withInput();
        }

        $normalizeText = static function ($value): ?string {
            $text = trim((string) ($value ?? ''));
            return $text !== '' ? $text : null;
        };

        FixtureReport::updateOrCreate(
            [
                'event_id' => $event->id,
                'grupo_id' => $grupoId,
                'jornada' => $jornada,
                'partido_numero' => $partidoIndex,
            ],
            [
                'score_local' => $scoreLocal !== null ? (int) $scoreLocal : null,
                'score_visitante' => $scoreVisitante !== null ? (int) $scoreVisitante : null,
                'local_lineup' => $this->parseFixtureList($data['local_lineup'] ?? null),
                'visitante_lineup' => $this->parseFixtureList($data['visitante_lineup'] ?? null),
                'local_yellow_cards' => $this->parseFixtureList($data['local_yellow_cards'] ?? null),
                'local_red_cards' => $this->parseFixtureList($data['local_red_cards'] ?? null),
                'local_blue_cards' => $this->parseFixtureList($data['local_blue_cards'] ?? null),
                'visitante_yellow_cards' => $this->parseFixtureList($data['visitante_yellow_cards'] ?? null),
                'visitante_red_cards' => $this->parseFixtureList($data['visitante_red_cards'] ?? null),
                'visitante_blue_cards' => $this->parseFixtureList($data['visitante_blue_cards'] ?? null),
                'local_top_scorer' => $normalizeText($data['local_top_scorer'] ?? null),
                'local_top_scorer_goals' => isset($data['local_top_scorer_goals']) ? (int) $data['local_top_scorer_goals'] : null,
                'visitante_top_scorer' => $normalizeText($data['visitante_top_scorer'] ?? null),
                'visitante_top_scorer_goals' => isset($data['visitante_top_scorer_goals']) ? (int) $data['visitante_top_scorer_goals'] : null,
                'local_best_goalkeeper' => $normalizeText($data['local_best_goalkeeper'] ?? null),
                'local_goalkeeper_goals_conceded' => isset($data['local_goalkeeper_goals_conceded']) ? (int) $data['local_goalkeeper_goals_conceded'] : null,
                'visitante_best_goalkeeper' => $normalizeText($data['visitante_best_goalkeeper'] ?? null),
                'visitante_goalkeeper_goals_conceded' => isset($data['visitante_goalkeeper_goals_conceded']) ? (int) $data['visitante_goalkeeper_goals_conceded'] : null,
                'highlights' => $normalizeText($data['highlights'] ?? null),
                'updated_by' => auth()->id(),
            ]
        );

        return redirect()
            ->back()
            ->with('fixture_report_success', 'Informacion del encuentro guardada correctamente.')
            ->with('fixture_report_url', route('events.fixture.detail', [$event->id, $grupoId, $jornada, $partidoIndex]));
    }

    public function listado()
    {
        // Mejor paginado (si quieres dejar all(), puedes, pero esto es mÃ¡s sano)
        $eventos = Event::orderBy('start_at', 'desc')->paginate(20);

        return view('events.listado-eventos', compact('eventos'));
    }

    public function create()
    {
        return view('events.crear-evento');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category' => 'required|string|max:80',
            'category_custom' => 'nullable|required_if:category,otro|string|max:80',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:activo,inactivo,cerrado',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $categoryValue = Str::slug((string) $data['category'], '_');
        if ($categoryValue === 'otro') {
            $categoryValue = Str::slug((string) ($data['category_custom'] ?? ''), '_');
        }
        if ($categoryValue === '') {
            $categoryValue = 'general';
        }

        $disciplineGroup = $this->resolveDisciplineGroup($categoryValue);
        $disciplinePayload = $this->validateDisciplinePayload($request, $disciplineGroup);

        $baseSlug = Str::slug(($data['slug'] ?? null) ?: $data['title']);
        $slug = $baseSlug;
        $i = 2;

        while (Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('eventos', 'public');
        }

        $evento = new Event();
        $evento->title = $data['title'];
        $evento->slug = $slug;
        $evento->description = $data['description'] ?? null;
        $evento->category = $categoryValue;
        $evento->discipline_payload = $disciplinePayload;
        $evento->location = $data['location'];
        $evento->start_at = $data['start_at'];
        $evento->end_at = $data['end_at'] ?? null;
        $evento->image = $imagePath;
        $evento->status = $data['status'];
        $evento->save();

        return redirect()->back()->with('success', 'El evento fue creado correctamente.');
    }

    public function destroy(Request $request, Event $event)
    {
        // âœ… Borrar imagen del storage si existe
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

    private function resolveDisciplineGroup(string $category): string
    {
        return match ($category) {
            'futbol', 'futbol_salon', 'baloncesto', 'voleibol' => 'team',
            'atletismo' => 'atletismo',
            'ciclismo' => 'ciclismo',
            'natacion' => 'natacion',
            'crossfit' => 'crossfit',
            default => 'generic',
        };
    }

    private function validateDisciplinePayload(Request $request, string $group): array
    {
        if ($group === 'team') {
            $data = $request->validate([
                'team_format' => 'required|in:liga,copa,eliminacion,grupos_y_eliminacion,amistoso',
                'team_count' => 'required|integer|min:2|max:128',
                'team_players_per_team' => 'required|integer|min:3|max:30',
                'team_match_duration_min' => 'required|integer|min:10|max:180',
            ]);

            return [
                'discipline_group' => 'team',
                'team_format' => $data['team_format'],
                'team_count' => (int) $data['team_count'],
                'team_players_per_team' => (int) $data['team_players_per_team'],
                'team_match_duration_min' => (int) $data['team_match_duration_min'],
            ];
        }

        if ($group === 'atletismo') {
            $data = $request->validate([
                'athletics_modality' => 'required|in:pista,campo,ruta,trail,maraton',
                'athletics_distance_m' => 'required|integer|min:50|max:100000',
                'athletics_heat_count' => 'required|integer|min:1|max:50',
                'athletics_participant_cap' => 'required|integer|min:2|max:5000',
            ]);

            return [
                'discipline_group' => 'atletismo',
                'athletics_modality' => $data['athletics_modality'],
                'athletics_distance_m' => (int) $data['athletics_distance_m'],
                'athletics_heat_count' => (int) $data['athletics_heat_count'],
                'athletics_participant_cap' => (int) $data['athletics_participant_cap'],
            ];
        }

        if ($group === 'ciclismo') {
            $data = $request->validate([
                'cycling_modality' => 'required|in:ruta,mtb,pista,bmx,crono',
                'cycling_distance_km' => 'required|numeric|min:1|max:500',
                'cycling_elevation_m' => 'nullable|integer|min:0|max:10000',
                'cycling_stage_count' => 'required|integer|min:1|max:30',
            ]);

            return [
                'discipline_group' => 'ciclismo',
                'cycling_modality' => $data['cycling_modality'],
                'cycling_distance_km' => (float) $data['cycling_distance_km'],
                'cycling_elevation_m' => isset($data['cycling_elevation_m']) ? (int) $data['cycling_elevation_m'] : null,
                'cycling_stage_count' => (int) $data['cycling_stage_count'],
            ];
        }

        if ($group === 'natacion') {
            $data = $request->validate([
                'swim_environment' => 'required|in:piscina,aguas_abiertas',
                'swim_style' => 'required|in:libre,pecho,espalda,mariposa,mixto',
                'swim_distance_m' => 'required|integer|min:25|max:10000',
                'swim_lane_count' => 'required|integer|min:1|max:20',
            ]);

            return [
                'discipline_group' => 'natacion',
                'swim_environment' => $data['swim_environment'],
                'swim_style' => $data['swim_style'],
                'swim_distance_m' => (int) $data['swim_distance_m'],
                'swim_lane_count' => (int) $data['swim_lane_count'],
            ];
        }

        if ($group === 'crossfit') {
            $data = $request->validate([
                'crossfit_level' => 'required|in:iniciacion,intermedio,rx,elite,master',
                'crossfit_wod_count' => 'required|integer|min:1|max:20',
                'crossfit_heat_duration_min' => 'required|integer|min:5|max:120',
                'crossfit_athlete_cap' => 'required|integer|min:2|max:500',
            ]);

            return [
                'discipline_group' => 'crossfit',
                'crossfit_level' => $data['crossfit_level'],
                'crossfit_wod_count' => (int) $data['crossfit_wod_count'],
                'crossfit_heat_duration_min' => (int) $data['crossfit_heat_duration_min'],
                'crossfit_athlete_cap' => (int) $data['crossfit_athlete_cap'],
            ];
        }

        $data = $request->validate([
            'generic_competition_type' => 'required|string|max:120',
            'generic_participant_cap' => 'required|integer|min:1|max:10000',
            'generic_notes' => 'nullable|string|max:1500',
        ]);

        return [
            'discipline_group' => 'generic',
            'generic_competition_type' => trim((string) ($data['generic_competition_type'] ?? '')) ?: null,
            'generic_participant_cap' => isset($data['generic_participant_cap']) ? (int) $data['generic_participant_cap'] : null,
            'generic_notes' => trim((string) ($data['generic_notes'] ?? '')) ?: null,
        ];
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

    private function parseFixtureList(?string $raw): ?array
    {
        if ($raw === null) {
            return null;
        }

        $items = collect(preg_split('/[\r\n,;]+/', $raw) ?: [])
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->unique()
            ->take(40)
            ->values()
            ->all();

        return count($items) > 0 ? $items : null;
    }

    private function resolveFixtureContext(Event $event, int $grupoId, int $jornadaNum, int $partidoIndex): ?array
    {
        $competicion = Competicion::where('evento', $event->id)
            ->with(['grupos.equipos'])
            ->first();

        if (!$competicion) {
            return null;
        }

        $grupos = $competicion->grupos->sortBy('nombre_grupo')->values();
        $grupoModel = $grupos->firstWhere('id', $grupoId);

        if (!$grupoModel) {
            return null;
        }

        $groupIndex = $grupos->search(fn ($item) => (int) $item->id === (int) $grupoModel->id);
        $baseStart = $event->start_at ? $event->start_at->copy() : Carbon::now();

        $teamsSorted = $grupoModel->equipos
            ->sortBy('id')
            ->values();

        $teamNames = $teamsSorted
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
            return null;
        }

        $match = $roundData['matches'][$partidoIndex];
        $homeTeam = $teamsSorted->first(function ($team) use ($match) {
            return (string) $team->nombre_equipo === (string) $match['home'];
        });
        $awayTeam = $teamsSorted->first(function ($team) use ($match) {
            return (string) $team->nombre_equipo === (string) $match['away'];
        });

        $score = null;
        if ($homeTeam && $awayTeam) {
            $partido = Partido::query()
                ->where('competicion_id', $competicion->id)
                ->where('grupo_id', $grupoModel->id)
                ->where(function ($query) use ($homeTeam, $awayTeam) {
                    $query
                        ->where(function ($q) use ($homeTeam, $awayTeam) {
                            $q->where('equipo_local_id', $homeTeam->id)
                                ->where('equipo_visitante_id', $awayTeam->id);
                        })
                        ->orWhere(function ($q) use ($homeTeam, $awayTeam) {
                            $q->where('equipo_local_id', $awayTeam->id)
                                ->where('equipo_visitante_id', $homeTeam->id);
                        });
                })
                ->first();

            if ($partido && $partido->goles_local !== null && $partido->goles_visitante !== null) {
                if ((int) $partido->equipo_local_id === (int) $homeTeam->id) {
                    $score = [
                        'local' => (int) $partido->goles_local,
                        'visitante' => (int) $partido->goles_visitante,
                    ];
                } else {
                    $score = [
                        'local' => (int) $partido->goles_visitante,
                        'visitante' => (int) $partido->goles_local,
                    ];
                }
            }
        }

        return [
            'grupo' => $grupoModel,
            'match' => $match,
            'homeTeam' => $homeTeam,
            'awayTeam' => $awayTeam,
            'score' => $score,
            'totalPartidosJornada' => count($roundData['matches']),
        ];
    }

    private function detectLivePlatform(string $url): ?string
    {
        $host = strtolower((string) parse_url(trim($url), PHP_URL_HOST));
        $host = preg_replace('/^www\./', '', $host);

        if ($host === 'youtu.be' || str_contains($host, 'youtube.com')) {
            return 'YouTube';
        }

        if ($host === 'fb.watch' || str_contains($host, 'facebook.com')) {
            return 'Facebook';
        }

        if (str_contains($host, 'instagram.com')) {
            return 'Instagram';
        }

        if (str_contains($host, 'tiktok.com')) {
            return 'TikTok';
        }

        return null;
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

