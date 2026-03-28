@extends('layouts.app')

@section('title', 'Centro de Competicion | ' . $event->title)

@php
    $imageUrl = null;

    if (!empty($event->image)) {
        $imageUrl = \Illuminate\Support\Str::startsWith($event->image, ['http://', 'https://'])
            ? $event->image
            : route('events.media', ['path' => ltrim($event->image, '/')]);
    }

    $statusClass = in_array(strtolower((string) $event->status), ['activo'], true)
        ? 'status-on'
        : 'status-off';

    $totalTeams = $grupos->sum(function ($grupo) {
        return $grupo->equipos->count();
    });

    $totalCalendarMatches = 0;

    foreach ($fixturesByGroup as $rounds) {
        foreach ($rounds as $round) {
            $totalCalendarMatches += count($round['matches'] ?? []);
        }
    }
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/views/events/show.css') }}">
@endpush

@section('content')
<div class="tourney-page">
    <div class="container tourney-shell">
        <header class="hero-card">
            @if($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $event->title }}" class="hero-media">
            @else
                <div class="hero-media hero-media-fallback">Sin imagen del evento</div>
            @endif

            <div class="hero-body">
                <p class="hero-topline">
                    <i class="bi bi-clipboard-data"></i>
                    Centro tecnico del torneo
                </p>
                <h1 class="hero-title">{{ $event->title }}</h1>
                <p class="hero-subtitle">
                    Vista integral de competicion: grupos, cruces, calendario, sistema de puntos FIFA,
                    tabla de posiciones, cuadro final y reglas de arbitraje.
                </p>

                <div class="hero-meta">
                    <span class="meta-pill"><i class="bi bi-calendar-event"></i> {{ $event->start_at ? $event->start_at->format('d/m/Y H:i') : 'Fecha por definir' }}</span>
                    <span class="meta-pill"><i class="bi bi-geo-alt"></i> {{ $event->location ?: 'Sede por definir' }}</span>
                    <span class="meta-pill"><i class="bi bi-diagram-3"></i> {{ $grupos->count() }} grupos</span>
                    <span class="meta-pill {{ $statusClass }}"><i class="bi bi-shield-check"></i> {{ strtoupper((string) $event->status) }}</span>
                </div>

                <div class="hero-actions">
                    <a href="{{ route('events.index') }}" class="btn-hero ghost">
                        <i class="bi bi-arrow-left-circle"></i>
                        Volver a eventos
                    </a>
                </div>
            </div>
        </header>

        <div class="tourney-layout">
            <div class="main-stack">
                <section class="panel">
                    <div class="panel-head">
                        <h2>1. Grupos y grupos que se enfrentan</h2>
                        <span class="panel-tag">Cruces</span>
                    </div>

                    @if($grupos->isEmpty())
                        <p class="empty-box">
                            Aun no hay grupos generados para este evento. Crea la competicion y genera grupos para activar este modulo.
                        </p>
                    @else
                        <div class="groups-grid">
                            @foreach($grupos as $grupo)
                                <article class="group-card">
                                    <h3>{{ $grupo->nombre_grupo }}</h3>
                                    <ul class="group-list">
                                        @forelse($grupo->equipos as $equipo)
                                            <li>{{ $equipo->nombre_equipo }}</li>
                                        @empty
                                            <li>Sin equipos registrados</li>
                                        @endforelse
                                    </ul>
                                </article>
                            @endforeach
                        </div>

                        @if(empty($groupDuels))
                            <p class="empty-box" style="margin-top: 10px;">Se necesitan al menos 2 grupos para mostrar cruces de fase final.</p>
                        @else
                            <div class="duels-grid">
                                @foreach($groupDuels as $duel)
                                    <article class="duel-card">
                                        <h4>{{ $duel['label'] }}: {{ $duel['group_a'] }} vs {{ $duel['group_b'] }}</h4>
                                        <ul class="duel-pairs">
                                            @foreach($duel['pairings'] as $pair)
                                                <li>{{ $pair }}</li>
                                            @endforeach
                                        </ul>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </section>

                <section class="panel">
                    <div class="panel-head">
                        <h2>2. Calendario oficial de partidos (fecha y lugar)</h2>
                        <span class="panel-tag">{{ $totalCalendarMatches }} partidos</span>
                    </div>

                    @if($totalCalendarMatches === 0)
                        <p class="empty-box">No hay calendario disponible. Se genera al tener grupos con 2 o mas equipos.</p>
                    @else
                        <div class="table-wrap">
                            <table class="t-table">
                                <thead>
                                    <tr>
                                        <th>Grupo</th>
                                        <th>Jornada</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Partido</th>
                                        <th>Lugar</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grupos as $grupo)
                                        @foreach(($fixturesByGroup[$grupo->id] ?? []) as $round)
                                            @foreach(($round['matches'] ?? []) as $match)
                                                @php
                                                    $matchIndex = $loop->index;
                                                @endphp
                                                <tr>
                                                    <td>{{ $grupo->nombre_grupo }}</td>
                                                    <td>Fecha {{ $round['round'] }}</td>
                                                    <td>{{ $match['kickoff']->format('d/m/Y') }}</td>
                                                    <td>{{ $match['kickoff']->format('H:i') }}</td>
                                                    <td>{{ $match['home'] }} vs {{ $match['away'] }}</td>
                                                    <td>{{ $match['location'] }}</td>
                                                    <td>
                                                        <a
                                                            class="btn-detail d-inline-flex align-items-center gap-1 text-decoration-none"
                                                            href="{{ route('events.fixture.detail', [$event->id, $grupo->id, $round['round'], $matchIndex]) }}"
                                                        >
                                                            Ver detalle
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>

                <section class="panel">
                    <div class="panel-head">
                        <h2>3. Tabla de posiciones por grupo</h2>
                        <span class="panel-tag">FIFA base</span>
                    </div>

                    @if($grupos->isEmpty())
                        <p class="empty-box">No hay datos para posiciones porque todavia no existen grupos.</p>
                    @else
                        <div class="standings-grid">
                            @foreach($grupos as $grupo)
                                @php
                                    $rows = $standingsByGroup[$grupo->id] ?? [];
                                @endphp
                                <article class="standings-card">
                                    <h3>{{ $grupo->nombre_grupo }}</h3>
                                    <div class="table-wrap">
                                        <table class="t-table">
                                            <thead>
                                                <tr>
                                                    <th>Pos</th>
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
                                                @forelse($rows as $row)
                                                    <tr>
                                                        <td>{{ $row['pos'] }}</td>
                                                        <td>{{ $row['team'] }}</td>
                                                        <td>{{ $row['pj'] }}</td>
                                                        <td>{{ $row['pg'] }}</td>
                                                        <td>{{ $row['pe'] }}</td>
                                                        <td>{{ $row['pp'] }}</td>
                                                        <td>{{ $row['gf'] }}</td>
                                                        <td>{{ $row['gc'] }}</td>
                                                        <td>{{ $row['dg'] }}</td>
                                                        <td>{{ $row['pts'] }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="10">Sin equipos para posicionar.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="panel">
                    <div class="panel-head">
                        <h2>4. Cuadro final</h2>
                        <span class="panel-tag">Playoff</span>
                    </div>

                    @if(empty($knockoutMatches))
                        <p class="empty-box">Se requieren al menos 2 grupos para generar el cuadro de fase final.</p>
                    @else
                        <div class="knockout-grid">
                            @foreach($knockoutMatches as $index => $match)
                                <article class="knockout-match">
                                    <span class="stage">{{ $match['stage'] }}</span>
                                    <div class="line">{{ $match['home'] }}</div>
                                    <div class="vs-chip">VS</div>
                                    <div class="line">{{ $match['away'] }}</div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>

            <aside class="side-stack">
                <section class="side-card">
                    <h2 class="side-head">Sistema de puntuacion FIFA</h2>
                    <table class="rule-table">
                        <thead>
                            <tr>
                                <th>Resultado</th>
                                <th>Puntos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scoringRules as $rule)
                                <tr>
                                    <td>{{ $rule['result'] }}</td>
                                    <td>{{ $rule['points'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h2 class="side-head" style="margin-top: 2px;">Criterios de desempate</h2>
                    <ul class="rule-list">
                        @foreach($tieBreakers as $criterion)
                            <li>{{ $criterion }}</li>
                        @endforeach
                    </ul>
                </section>

                <section class="side-card">
                    <h2 class="side-head">Resumen operativo</h2>
                    <div class="summary-stats">
                        <article class="summary-card">
                            <span>Grupos</span>
                            <strong>{{ $grupos->count() }}</strong>
                        </article>
                        <article class="summary-card">
                            <span>Equipos</span>
                            <strong>{{ $totalTeams }}</strong>
                        </article>
                        <article class="summary-card">
                            <span>Partidos</span>
                            <strong>{{ $totalCalendarMatches }}</strong>
                        </article>
                    </div>
                    <p class="empty-box" style="margin: 0;">
                        Este modulo es solo de consulta. Todo el contenido se muestra en formato informativo para organizacion y comunicacion oficial.
                    </p>
                </section>

                <section class="side-card">
                    <h2 class="side-head">Reglas de arbitraje</h2>
                    <ul class="rule-list">
                        @foreach($arbitrationRules as $rule)
                            <li>{{ $rule }}</li>
                        @endforeach
                    </ul>
                </section>
            </aside>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/views/events/show.js') }}"></script>
@endpush

