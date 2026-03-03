<?php

namespace App\Http\Controllers;

use App\Models\Competicion;
use App\Models\Equipo;
use App\Models\Event;
use App\Models\Grupo;
use App\Models\Partido;
use App\Models\PartidoEliminacion;
use App\Models\TablaPosicion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompeticionesController extends Controller
{
    public function show($eventoId)
    {
        $evento = Event::findOrFail($eventoId);
        $competicion = Competicion::where('evento', $evento->id)->first();

        if ($competicion) {
            $this->procesarGeneracionGrupos($competicion, $evento);
            $competicion->refresh();
        }

        $equipos = Equipo::where('evento', trim($evento->title))->get();

        $grupos = $competicion
            ? $competicion->grupos()->with('equipos')->orderBy('nombre_grupo')->get()
            : collect();

        $partidosPorGrupo = [];
        $tablaPosicionesPorGrupo = collect();
        $eliminacionPorRonda = collect();

        if ($competicion && $grupos->isNotEmpty()) {
            $this->asegurarTablaPosiciones($competicion, $grupos);
            $partidosPorGrupo = $this->construirPartidosPorGrupo($competicion, $grupos);

            $tablaPosicionesPorGrupo = TablaPosicion::where('competicion_id', $competicion->id)
                ->with('equipo')
                ->orderBy('grupo_id')
                ->orderByDesc('puntos')
                ->orderByDesc('dg')
                ->orderByDesc('gf')
                ->orderBy('equipo_id')
                ->get()
                ->groupBy('grupo_id');

            $eliminacionPorRonda = $this->sincronizarCuadroEliminatorio(
                $competicion,
                $grupos,
                $tablaPosicionesPorGrupo
            );
        }

        return view('COMPETICION.show', [
            'evento' => $evento,
            'competicion' => $competicion,
            'equipos' => $equipos,
            'grupos' => $grupos,
            'partidosPorGrupo' => $partidosPorGrupo,
            'tablaPosicionesPorGrupo' => $tablaPosicionesPorGrupo,
            'eliminacionPorRonda' => $eliminacionPorRonda,
        ]);
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

        if (Competicion::where('evento', $evento->id)->exists()) {
            return back()->with('error', 'Este evento ya tiene una competicion');
        }

        $competicion = Competicion::create([
            'evento' => $evento->id,
            'estado' => 'creada',
        ]);

        $resultado = $this->procesarGeneracionGrupos($competicion, $evento);

        if ($resultado === 'generated') {
            return back()->with('success', 'Competicion creada y grupos generados automaticamente');
        }

        return back()->with('success', 'Competicion creada correctamente');
    }

    /**
     * Generar grupos automaticamente
     */
    public function generarGrupos($competicionId)
    {
        $competicion = Competicion::findOrFail($competicionId);
        $evento = Event::findOrFail($competicion->evento);

        $resultado = $this->procesarGeneracionGrupos($competicion, $evento);

        if ($resultado === 'already_generated') {
            return back()->with('error', 'Los grupos ya fueron generados');
        }

        if ($resultado === 'insufficient_teams') {
            return back()->with('error', 'Se requieren al menos 4 equipos');
        }

        return redirect()
            ->route('competicion', $evento->id)
            ->with('success', 'Grupos creados correctamente');
    }

    /**
     * Registrar o actualizar resultado de partido y mover tabla de posiciones.
     */
    public function registrarResultado(Request $request, $competicionId)
    {
        $competicion = Competicion::findOrFail($competicionId);
        $evento = Event::findOrFail($competicion->evento);

        $data = $request->validate([
            'grupo_id' => 'required|integer|exists:grupos,id',
            'equipo_local_id' => 'required|integer|exists:equipos,id|different:equipo_visitante_id',
            'equipo_visitante_id' => 'required|integer|exists:equipos,id',
            'goles_local' => 'required|integer|min:0|max:99',
            'goles_visitante' => 'required|integer|min:0|max:99',
        ]);

        $grupo = Grupo::with('equipos:id')
            ->where('id', $data['grupo_id'])
            ->where('competicion_id', $competicion->id)
            ->firstOrFail();

        $localId = (int) $data['equipo_local_id'];
        $visitanteId = (int) $data['equipo_visitante_id'];
        $golesLocal = (int) $data['goles_local'];
        $golesVisitante = (int) $data['goles_visitante'];

        // Canoniza el par para evitar partidos duplicados por orden invertido.
        if ($localId > $visitanteId) {
            [$localId, $visitanteId] = [$visitanteId, $localId];
            [$golesLocal, $golesVisitante] = [$golesVisitante, $golesLocal];
        }

        $localValido = $grupo->equipos->contains('id', $localId);
        $visitanteValido = $grupo->equipos->contains('id', $visitanteId);

        if (!$localValido || !$visitanteValido) {
            return back()->with('error', 'Los equipos no pertenecen al grupo seleccionado.');
        }

        DB::transaction(function () use ($competicion, $grupo, $localId, $visitanteId, $golesLocal, $golesVisitante) {
            $localTabla = TablaPosicion::firstOrCreate(
                [
                    'competicion_id' => $competicion->id,
                    'grupo_id' => $grupo->id,
                    'equipo_id' => $localId,
                ],
                [
                    'pj' => 0,
                    'pg' => 0,
                    'pe' => 0,
                    'pp' => 0,
                    'gf' => 0,
                    'gc' => 0,
                    'dg' => 0,
                    'puntos' => 0,
                ]
            );

            $visitanteTabla = TablaPosicion::firstOrCreate(
                [
                    'competicion_id' => $competicion->id,
                    'grupo_id' => $grupo->id,
                    'equipo_id' => $visitanteId,
                ],
                [
                    'pj' => 0,
                    'pg' => 0,
                    'pe' => 0,
                    'pp' => 0,
                    'gf' => 0,
                    'gc' => 0,
                    'dg' => 0,
                    'puntos' => 0,
                ]
            );

            $partido = Partido::where('competicion_id', $competicion->id)
                ->where('grupo_id', $grupo->id)
                ->where('equipo_local_id', $localId)
                ->where('equipo_visitante_id', $visitanteId)
                ->first();

            if ($partido && $partido->goles_local !== null && $partido->goles_visitante !== null) {
                $this->revertirTablaConResultado(
                    $localTabla,
                    (int) $partido->goles_local,
                    (int) $partido->goles_visitante
                );

                $this->revertirTablaConResultado(
                    $visitanteTabla,
                    (int) $partido->goles_visitante,
                    (int) $partido->goles_local
                );
            }

            if (!$partido) {
                $partido = new Partido([
                    'competicion_id' => $competicion->id,
                    'grupo_id' => $grupo->id,
                    'equipo_local_id' => $localId,
                    'equipo_visitante_id' => $visitanteId,
                ]);
            }

            $partido->goles_local = $golesLocal;
            $partido->goles_visitante = $golesVisitante;
            $partido->jugado_en = now();
            $partido->save();

            $this->actualizarTablaConResultado(
                $localTabla,
                $golesLocal,
                $golesVisitante
            );

            $this->actualizarTablaConResultado(
                $visitanteTabla,
                $golesVisitante,
                $golesLocal
            );
        });

        return redirect()
            ->route('competicion', $evento->id)
            ->with('success', 'Resultado guardado y tabla de posiciones actualizada.');
    }

    /**
     * Registrar resultado de partido de eliminacion y propagar clasificados.
     */
    public function registrarResultadoEliminacion(Request $request, $competicionId, $partidoId)
    {
        $competicion = Competicion::findOrFail($competicionId);
        $evento = Event::findOrFail($competicion->evento);

        $data = $request->validate([
            'goles_local' => 'required|integer|min:0|max:99',
            'goles_visitante' => 'required|integer|min:0|max:99',
        ]);

        $partido = PartidoEliminacion::where('competicion_id', $competicion->id)
            ->where('id', $partidoId)
            ->firstOrFail();

        if (!$partido->equipo_local_id || !$partido->equipo_visitante_id) {
            return back()->with('error', 'Este enfrentamiento aun no tiene ambos equipos definidos.');
        }

        if ((int) $data['goles_local'] === (int) $data['goles_visitante']) {
            return back()->with('error', 'En eliminacion directa no se permite empate.');
        }

        DB::transaction(function () use ($partido, $data, $competicion) {
            $partido->goles_local = (int) $data['goles_local'];
            $partido->goles_visitante = (int) $data['goles_visitante'];
            $partido->ganador_id = $partido->goles_local > $partido->goles_visitante
                ? $partido->equipo_local_id
                : $partido->equipo_visitante_id;
            $partido->jugado_en = now();
            $partido->save();

            $grupos = $competicion->grupos()->with('equipos')->orderBy('nombre_grupo')->get();

            $tablaPosicionesPorGrupo = TablaPosicion::where('competicion_id', $competicion->id)
                ->orderBy('grupo_id')
                ->orderByDesc('puntos')
                ->orderByDesc('dg')
                ->orderByDesc('gf')
                ->orderBy('equipo_id')
                ->get()
                ->groupBy('grupo_id');

            $this->sincronizarCuadroEliminatorio($competicion, $grupos, $tablaPosicionesPorGrupo);
        });

        return redirect()
            ->route('competicion', $evento->id)
            ->with('success', 'Resultado de eliminacion guardado y cuadro actualizado.');
    }

    private function procesarGeneracionGrupos(Competicion $competicion, Event $evento): string
    {
        if ($competicion->grupos()->exists()) {
            if ($competicion->estado !== 'grupos_generados') {
                $competicion->update(['estado' => 'grupos_generados']);
            }

            return 'already_generated';
        }

        $equipos = Equipo::where('evento', trim($evento->title))
            ->inRandomOrder()
            ->get();

        if ($equipos->count() < 4) {
            return 'insufficient_teams';
        }

        DB::transaction(function () use ($competicion, $equipos) {
            $letra = 'A';

            foreach ($equipos->chunk(4) as $chunk) {
                $grupo = $competicion->grupos()->create([
                    'nombre_grupo' => 'Grupo ' . $letra++,
                ]);

                $grupo->equipos()->attach($chunk->pluck('id'));
            }

            $competicion->update(['estado' => 'grupos_generados']);
        });

        return 'generated';
    }

    private function asegurarTablaPosiciones(Competicion $competicion, $grupos): void
    {
        foreach ($grupos as $grupo) {
            foreach ($grupo->equipos as $equipo) {
                TablaPosicion::firstOrCreate(
                    [
                        'competicion_id' => $competicion->id,
                        'grupo_id' => $grupo->id,
                        'equipo_id' => $equipo->id,
                    ],
                    [
                        'pj' => 0,
                        'pg' => 0,
                        'pe' => 0,
                        'pp' => 0,
                        'gf' => 0,
                        'gc' => 0,
                        'dg' => 0,
                        'puntos' => 0,
                    ]
                );
            }
        }
    }

    private function construirPartidosPorGrupo(Competicion $competicion, $grupos): array
    {
        $partidosExistentes = Partido::where('competicion_id', $competicion->id)->get();
        $partidosPorGrupo = [];

        foreach ($grupos as $grupo) {
            $equipos = $grupo->equipos->sortBy('id')->values();
            $mapaPartidos = [];

            foreach ($partidosExistentes->where('grupo_id', $grupo->id) as $partido) {
                $key = $partido->equipo_local_id . '-' . $partido->equipo_visitante_id;
                $mapaPartidos[$key] = $partido;
            }

            $agenda = [];

            for ($i = 0; $i < $equipos->count(); $i++) {
                for ($j = $i + 1; $j < $equipos->count(); $j++) {
                    $local = $equipos[$i];
                    $visitante = $equipos[$j];
                    $key = $local->id . '-' . $visitante->id;

                    $agenda[] = [
                        'local' => $local,
                        'visitante' => $visitante,
                        'partido' => $mapaPartidos[$key] ?? null,
                    ];
                }
            }

            $partidosPorGrupo[$grupo->id] = $agenda;
        }

        return $partidosPorGrupo;
    }

    private function sincronizarCuadroEliminatorio(
        Competicion $competicion,
        $grupos,
        $tablaPosicionesPorGrupo
    ) {
        $clasificados = $this->construirClasificadosDesdeTabla($grupos, $tablaPosicionesPorGrupo);
        $cantidadClasificados = count($clasificados);

        if ($cantidadClasificados < 2) {
            PartidoEliminacion::where('competicion_id', $competicion->id)->delete();

            return collect();
        }

        $bracketSize = 1;
        while ($bracketSize < $cantidadClasificados) {
            $bracketSize *= 2;
        }
        $bracketSize = max(2, $bracketSize);

        $seeded = array_pad($clasificados, $bracketSize, null);

        $totalRondas = 0;
        $tmp = $bracketSize;
        while ($tmp > 1) {
            $totalRondas++;
            $tmp = intdiv($tmp, 2);
        }

        DB::transaction(function () use ($competicion, $seeded, $bracketSize, $totalRondas) {
            $mapaRondas = [];

            for ($ronda = 1; $ronda <= $totalRondas; $ronda++) {
                $partidosRonda = intdiv($bracketSize, 2 ** $ronda);
                $slotsActivos = [];

                for ($slot = 1; $slot <= $partidosRonda; $slot++) {
                    if ($ronda === 1) {
                        $equipoLocal = $seeded[($slot - 1) * 2] ?? null;
                        $equipoVisitante = $seeded[(($slot - 1) * 2) + 1] ?? null;
                    } else {
                        $prevA = $mapaRondas[$ronda - 1][($slot * 2) - 1] ?? null;
                        $prevB = $mapaRondas[$ronda - 1][$slot * 2] ?? null;
                        $equipoLocal = $prevA?->ganador_id;
                        $equipoVisitante = $prevB?->ganador_id;
                    }

                    $partido = PartidoEliminacion::firstOrNew([
                        'competicion_id' => $competicion->id,
                        'ronda' => $ronda,
                        'slot' => $slot,
                    ]);

                    $cambioEquipos = (int) ($partido->equipo_local_id ?? 0) !== (int) ($equipoLocal ?? 0)
                        || (int) ($partido->equipo_visitante_id ?? 0) !== (int) ($equipoVisitante ?? 0);

                    $partido->equipo_local_id = $equipoLocal;
                    $partido->equipo_visitante_id = $equipoVisitante;

                    if ($cambioEquipos) {
                        $partido->goles_local = null;
                        $partido->goles_visitante = null;
                        $partido->ganador_id = null;
                        $partido->jugado_en = null;
                    }

                    if ($equipoLocal && !$equipoVisitante) {
                        $partido->ganador_id = $equipoLocal;
                        $partido->jugado_en = $partido->jugado_en ?? now();
                    } elseif (!$equipoLocal && $equipoVisitante) {
                        $partido->ganador_id = $equipoVisitante;
                        $partido->jugado_en = $partido->jugado_en ?? now();
                    } elseif (!$equipoLocal && !$equipoVisitante) {
                        $partido->goles_local = null;
                        $partido->goles_visitante = null;
                        $partido->ganador_id = null;
                        $partido->jugado_en = null;
                    } elseif (
                        $partido->ganador_id
                        && !in_array((int) $partido->ganador_id, [(int) $equipoLocal, (int) $equipoVisitante], true)
                    ) {
                        $partido->goles_local = null;
                        $partido->goles_visitante = null;
                        $partido->ganador_id = null;
                        $partido->jugado_en = null;
                    }

                    $partido->save();

                    $mapaRondas[$ronda][$slot] = $partido;
                    $slotsActivos[] = $slot;
                }

                PartidoEliminacion::where('competicion_id', $competicion->id)
                    ->where('ronda', $ronda)
                    ->whereNotIn('slot', $slotsActivos)
                    ->delete();
            }

            PartidoEliminacion::where('competicion_id', $competicion->id)
                ->where('ronda', '>', $totalRondas)
                ->delete();
        });

        return PartidoEliminacion::where('competicion_id', $competicion->id)
            ->with(['local', 'visitante', 'ganador'])
            ->orderBy('ronda')
            ->orderBy('slot')
            ->get()
            ->groupBy('ronda');
    }

    private function construirClasificadosDesdeTabla($grupos, $tablaPosicionesPorGrupo): array
    {
        $clasificados = [];

        foreach ($grupos as $grupo) {
            $tablaGrupo = collect($tablaPosicionesPorGrupo->get($grupo->id, collect()))
                ->sort(function ($a, $b) {
                    if ($a->puntos !== $b->puntos) {
                        return $b->puntos <=> $a->puntos;
                    }

                    if ($a->dg !== $b->dg) {
                        return $b->dg <=> $a->dg;
                    }

                    if ($a->gf !== $b->gf) {
                        return $b->gf <=> $a->gf;
                    }

                    return $a->equipo_id <=> $b->equipo_id;
                })
                ->take(2);

            foreach ($tablaGrupo as $fila) {
                if (!empty($fila->equipo_id)) {
                    $clasificados[] = (int) $fila->equipo_id;
                }
            }
        }

        return array_values(array_unique($clasificados));
    }

    private function actualizarTablaConResultado(TablaPosicion $fila, int $golesFavor, int $golesContra): void
    {
        $fila->pj += 1;
        $fila->gf += $golesFavor;
        $fila->gc += $golesContra;

        if ($golesFavor > $golesContra) {
            $fila->pg += 1;
            $fila->puntos += 3;
        } elseif ($golesFavor === $golesContra) {
            $fila->pe += 1;
            $fila->puntos += 1;
        } else {
            $fila->pp += 1;
        }

        $fila->dg = $fila->gf - $fila->gc;
        $fila->save();
    }

    private function revertirTablaConResultado(TablaPosicion $fila, int $golesFavor, int $golesContra): void
    {
        $fila->pj = max(0, $fila->pj - 1);
        $fila->gf = max(0, $fila->gf - $golesFavor);
        $fila->gc = max(0, $fila->gc - $golesContra);

        if ($golesFavor > $golesContra) {
            $fila->pg = max(0, $fila->pg - 1);
            $fila->puntos = max(0, $fila->puntos - 3);
        } elseif ($golesFavor === $golesContra) {
            $fila->pe = max(0, $fila->pe - 1);
            $fila->puntos = max(0, $fila->puntos - 1);
        } else {
            $fila->pp = max(0, $fila->pp - 1);
        }

        $fila->dg = $fila->gf - $fila->gc;
        $fila->save();
    }
}
