@extends('layouts.app')

@section('title', 'Competicion | ' . $evento->title)

@php
    $estado = $competicion->estado ?? 'sin_competicion';

    $estadoLabel = [
        'sin_competicion' => 'Sin competicion',
        'creada' => 'Creada',
        'grupos_generados' => 'Grupos listos',
    ][$estado] ?? ucfirst(str_replace('_', ' ', $estado));

    $estadoTone = [
        'sin_competicion' => 'neutral',
        'creada' => 'pending',
        'grupos_generados' => 'ok',
    ][$estado] ?? 'neutral';

    $partidosPorGrupo = $partidosPorGrupo ?? [];
    $tablaPosicionesPorGrupo = $tablaPosicionesPorGrupo ?? collect();
    $eliminacionPorRonda = $eliminacionPorRonda ?? collect();
    $totalPartidosEliminacion = $eliminacionPorRonda->flatten(1)->count();

    $badgeEquipo = function (?string $nombre): string {
        if (!$nombre) {
            return '--';
        }

        $clean = preg_replace('/[^A-Za-z0-9]/', '', $nombre);
        $badge = strtoupper(substr($clean, 0, 2));

        return $badge !== '' ? $badge : '--';
    };

    $labelRonda = function (int $ronda, \Illuminate\Support\Collection $coleccion) use ($eliminacionPorRonda) {
        $cantidad = $coleccion->count();
        $totalRondas = $eliminacionPorRonda->count();

        if ($cantidad === 1) {
            return 'Final';
        }

        if ($cantidad === 2) {
            return 'Semifinal';
        }

        if ($cantidad === 4) {
            return 'Cuartos';
        }

        if ($cantidad === 8) {
            return 'Octavos';
        }

        if ($ronda === $totalRondas) {
            return 'Final';
        }

        return 'Ronda ' . $ronda;
    };
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/views/competicion/show.css') }}">
@endpush

@section('content')
<div class="comp-page">
    <div class="container comp-shell">
        <div class="comp-topbar fade-up">
            <a href="{{ route('events.crear-evento-developer') }}" class="btn-back-modern">
                <i class="bi bi-arrow-left-circle"></i>
                Volver a crear evento developer
            </a>
        </div>

        <section class="comp-hero fade-up">
            <div>
                <p class="comp-overline">
                    <i class="bi bi-trophy-fill"></i>
                    Zona de competicion
                </p>
                <h1>{{ $evento->title }}</h1>
                <p>
                    Administra la competicion del evento, controla su estado y organiza
                    la distribucion de equipos en grupos desde una sola pantalla.
                </p>
            </div>

            <div class="comp-metrics">
                <article class="metric-card">
                    <span>Equipos inscritos</span>
                    <strong>{{ $equipos->count() }}</strong>
                </article>
                <article class="metric-card">
                    <span>Grupos activos</span>
                    <strong>{{ $grupos->count() }}</strong>
                </article>
                <article class="metric-card">
                    <span>Estado</span>
                    <strong>
                        <span class="status-pill status-{{ $estadoTone }}">{{ $estadoLabel }}</span>
                    </strong>
                </article>
            </div>
        </section>

        @if(session('success'))
            <div class="comp-alert comp-alert-success fade-up" style="--d: 100ms;">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="comp-alert comp-alert-error fade-up" style="--d: 120ms;">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="comp-alert comp-alert-error fade-up" style="--d: 130ms;">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @if(!$competicion)
            <section class="comp-panel fade-up" style="--d: 140ms;">
                <div class="panel-head">
                    <h2>Preparar competicion</h2>
                    <span class="panel-chip">Paso inicial</span>
                </div>
                <p class="panel-note">
                    El evento aun no tiene una competicion creada. Inicia el flujo para
                    habilitar la generacion de grupos y el armado de cruces.
                </p>
                <form method="POST" action="{{ route('competicion.crear', $evento->id) }}">
                    @csrf
                    <button type="submit" class="btn-primary-modern">
                        <i class="bi bi-lightning-charge-fill"></i>
                        Crear competicion
                    </button>
                </form>
            </section>
        @else
            <section class="comp-grid">
                <article class="comp-panel fade-up" style="--d: 140ms;">
                    <div class="panel-head">
                        <h2>Equipos inscritos</h2>
                        <span class="panel-chip">{{ $equipos->count() }} equipos</span>
                    </div>

                    @if($equipos->isEmpty())
                        <p class="empty-panel">Aun no hay equipos asociados a este evento.</p>
                    @else
                        <ul class="team-list">
                            @foreach($equipos as $equipo)
                                <li style="--i: {{ $loop->index }};">
                                    <span class="team-index">{{ $loop->iteration }}</span>
                                    <span class="team-name">{{ $equipo->nombre_equipo }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </article>

                <aside class="comp-panel fade-up" style="--d: 190ms;">
                    <div class="panel-head">
                        <h2>Control de estado</h2>
                        <i class="bi bi-gear-fill" style="color: var(--comp-brand-deep);"></i>
                    </div>

                    <div class="state-row">
                        <span>Estado actual</span>
                        <span class="status-pill status-{{ $estadoTone }}">{{ $estadoLabel }}</span>
                    </div>

                    <p class="panel-note">
                        Si ya tienes suficientes equipos, genera los grupos de forma automatica.
                    </p>

                    @if($competicion->estado === 'creada')
                        <form method="POST" action="{{ route('competicion.grupos', $competicion->id) }}">
                            @csrf
                            <button type="submit" class="btn-primary-modern">
                                <i class="bi bi-diagram-3-fill"></i>
                                Generar divisiones automaticamente
                            </button>
                        </form>
                    @else
                        <div class="state-done">
                            Los grupos ya fueron generados para esta competicion.
                        </div>
                    @endif
                </aside>
            </section>
        @endif

        @if($grupos->count())
            <section>
                <div class="groups-header fade-up" style="--d: 230ms;">
                    <h2>Grupos generados</h2>
                    <p>{{ $grupos->count() }} grupos activos</p>
                </div>

                <div class="groups-grid">
                    @foreach($grupos as $grupo)
                        <article class="group-card fade-up" style="--d: {{ 240 + ($loop->index * 60) }}ms;">
                            <header>
                                <h3>{{ $grupo->nombre_grupo }}</h3>
                                <span>{{ $grupo->equipos->count() }} equipos</span>
                            </header>

                            <ul class="group-list">
                                @foreach($grupo->equipos as $equipo)
                                    <li>{{ $equipo->nombre_equipo }}</li>
                                @endforeach
                            </ul>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if($competicion && $grupos->count())
            <section class="results-wrap">
                <div class="groups-header fade-up" style="--d: 260ms;">
                    <h2>Registro de resultados y tabla</h2>
                    <p>Logica automatica de puntos FIFA</p>
                </div>

                <div class="results-grid">
                    @foreach($grupos as $grupo)
                        @php
                            $agenda = $partidosPorGrupo[$grupo->id] ?? [];
                            $tabla = $tablaPosicionesPorGrupo->get($grupo->id, collect());
                        @endphp

                        <article class="results-card fade-up" style="--d: {{ 270 + ($loop->index * 55) }}ms;">
                            <h3>{{ $grupo->nombre_grupo }}</h3>

                            @if(empty($agenda))
                                <p class="empty-panel">No hay cruces disponibles en este grupo.</p>
                            @else
                                <div class="results-table-wrap">
                                    <table class="results-table">
                                        <thead>
                                            <tr>
                                                <th>Partido</th>
                                                <th>Resultado</th>
                                                <th>Guardar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($agenda as $fixture)
                                                @php
                                                    $local = $fixture['local'];
                                                    $visitante = $fixture['visitante'];
                                                    $partido = $fixture['partido'];
                                                    $golesLocal = old('equipo_local_id') == $local->id && old('equipo_visitante_id') == $visitante->id
                                                        ? old('goles_local')
                                                        : ($partido->goles_local ?? null);
                                                    $golesVisitante = old('equipo_local_id') == $local->id && old('equipo_visitante_id') == $visitante->id
                                                        ? old('goles_visitante')
                                                        : ($partido->goles_visitante ?? null);
                                                @endphp
                                                <tr>
                                                    <td>{{ $local->nombre_equipo }} vs {{ $visitante->nombre_equipo }}</td>
                                                    <td>
                                                        @if($partido && $partido->goles_local !== null && $partido->goles_visitante !== null)
                                                            <span class="result-chip">{{ $partido->goles_local }} - {{ $partido->goles_visitante }}</span>
                                                        @else
                                                            <span class="result-chip">Pendiente</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="{{ route('competicion.resultado', $competicion->id) }}" class="score-form">
                                                            @csrf
                                                            <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                                            <input type="hidden" name="equipo_local_id" value="{{ $local->id }}">
                                                            <input type="hidden" name="equipo_visitante_id" value="{{ $visitante->id }}">
                                                            <input type="number" class="score-input" name="goles_local" min="0" max="99" value="{{ $golesLocal }}" required>
                                                            <span class="score-sep">-</span>
                                                            <input type="number" class="score-input" name="goles_visitante" min="0" max="99" value="{{ $golesVisitante }}" required>
                                                            <button type="submit" class="btn-score">Guardar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <p class="standings-title">Tabla de posiciones</p>
                            <div class="results-table-wrap">
                                <table class="results-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Equipo</th>
                                            <th>PJ</th>
                                            <th>PG</th>
                                            <th>PE</th>
                                            <th>PP</th>
                                            <th>GF</th>
                                            <th>GC</th>
                                            <th>DG</th>
                                            <th>PTS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tabla as $fila)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $fila->equipo->nombre_equipo ?? 'Equipo' }}</td>
                                                <td>{{ $fila->pj }}</td>
                                                <td>{{ $fila->pg }}</td>
                                                <td>{{ $fila->pe }}</td>
                                                <td>{{ $fila->pp }}</td>
                                                <td>{{ $fila->gf }}</td>
                                                <td>{{ $fila->gc }}</td>
                                                <td>{{ $fila->dg }}</td>
                                                <td>{{ $fila->puntos }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10">Sin datos de posicion.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="playoff-wrap">
            <article class="playoff-panel fade-up" style="--d: 280ms;">
                <div class="playoff-head">
                    <h2>Cuadro eliminatorio</h2>
                    <span>{{ $totalPartidosEliminacion }} partidos</span>
                </div>

                @if($eliminacionPorRonda->isEmpty())
                    <p class="playoff-empty">
                        El cuadro final aparece automaticamente cuando la tabla de posiciones define clasificados.
                    </p>
                @else
                    <div class="elim-board">
                        <div class="elim-rounds" style="--rounds: {{ $eliminacionPorRonda->count() }};">
                            @foreach($eliminacionPorRonda as $ronda => $partidosRonda)
                                <div class="elim-round">
                                    <h5>{{ $labelRonda((int) $ronda, $partidosRonda) }}</h5>

                                    @foreach($partidosRonda as $partidoElim)
                                        @php
                                            $local = $partidoElim->local;
                                            $visitante = $partidoElim->visitante;
                                            $ganadorId = $partidoElim->ganador_id;
                                            $jugado = $partidoElim->goles_local !== null && $partidoElim->goles_visitante !== null;
                                        @endphp

                                        <article class="elim-match {{ $jugado ? 'is-played' : '' }}">
                                            <div class="elim-match-head">
                                                <span>Llave {{ $partidoElim->slot }}</span>
                                                @if($jugado)
                                                    <strong>{{ $partidoElim->goles_local }} - {{ $partidoElim->goles_visitante }}</strong>
                                                @endif
                                            </div>

                                            <div class="elim-team {{ !$local ? 'is-empty' : '' }} {{ $ganadorId === optional($local)->id ? 'is-winner' : '' }}">
                                                <span class="elim-token">{{ $badgeEquipo($local?->nombre_equipo) }}</span>
                                                <span class="elim-name">{{ $local?->nombre_equipo ?? 'Por definir' }}</span>
                                            </div>

                                            <div class="elim-team {{ !$visitante ? 'is-empty' : '' }} {{ $ganadorId === optional($visitante)->id ? 'is-winner' : '' }}">
                                                <span class="elim-token">{{ $badgeEquipo($visitante?->nombre_equipo) }}</span>
                                                <span class="elim-name">{{ $visitante?->nombre_equipo ?? 'Por definir' }}</span>
                                            </div>

                                            @if($local && $visitante)
                                                <form method="POST" action="{{ route('competicion.eliminacion.resultado', [$competicion->id, $partidoElim->id]) }}" class="elim-form">
                                                    @csrf
                                                    <input
                                                        type="number"
                                                        class="elim-input"
                                                        name="goles_local"
                                                        min="0"
                                                        max="99"
                                                        value="{{ $partidoElim->goles_local }}"
                                                        required
                                                    >
                                                    <span class="elim-sep">-</span>
                                                    <input
                                                        type="number"
                                                        class="elim-input"
                                                        name="goles_visitante"
                                                        min="0"
                                                        max="99"
                                                        value="{{ $partidoElim->goles_visitante }}"
                                                        required
                                                    >
                                                    <button type="submit" class="elim-save">Guardar</button>
                                                </form>
                                            @elseif($ganadorId && $partidoElim->ganador)
                                                <p class="elim-auto">
                                                    Clasifica directo: {{ $partidoElim->ganador->nombre_equipo }}
                                                </p>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>
        </section>
    </div>
</div>
@endsection

