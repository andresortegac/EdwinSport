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

    $matchTotalsByGroup = [];
    $totalCalendarMatches = 0;

    foreach ($grupos as $grupo) {
        $groupTotal = 0;

        foreach (($fixturesByGroup[$grupo->id] ?? []) as $round) {
            $groupTotal += count($round['matches'] ?? []);
        }

        $matchTotalsByGroup[$grupo->id] = $groupTotal;
        $totalCalendarMatches += $groupTotal;
    }
@endphp

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Manrope:wght@500;600;700;800&display=swap');

:root {
    --tc-bg-a: #edf6ff;
    --tc-bg-b: #f4fff6;
    --tc-surface: #ffffff;
    --tc-border: #d5e7f6;
    --tc-ink: #12334d;
    --tc-muted: #587289;
    --tc-primary: #0b6db2;
    --tc-primary-2: #084e80;
    --tc-accent: #0f9b72;
    --tc-warn: #c98d28;
    --tc-shadow: 0 22px 46px rgba(11, 40, 66, 0.13);
}

.tourney-page {
    min-height: 72vh;
    padding: 24px 0 56px;
    background: linear-gradient(140deg, var(--tc-bg-a), var(--tc-bg-b));
}

.tourney-shell {
    position: relative;
}

.hero-card,
.panel,
.side-card {
    border-radius: 24px;
    border: 1px solid var(--tc-border);
    background: var(--tc-surface);
    box-shadow: var(--tc-shadow);
}

.hero-card {
    overflow: hidden;
    margin-bottom: 16px;
}

.hero-media {
    width: 100%;
    height: 240px;
    object-fit: cover;
    border-bottom: 1px solid var(--tc-border);
    background: linear-gradient(145deg, #deeeff, #eaf9f0);
}

.hero-media-fallback {
    display: grid;
    place-items: center;
    color: #7e98ac;
    font: 700 1rem/1 "Manrope", sans-serif;
}

.hero-body {
    padding: 20px;
}

.hero-topline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    color: #15619a;
    font: 800 0.75rem/1 "Manrope", sans-serif;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.hero-title {
    margin: 0;
    color: var(--tc-ink);
    font: 800 clamp(1.4rem, 3.2vw, 2.2rem)/1.15 "Sora", sans-serif;
    letter-spacing: -0.02em;
}

.hero-subtitle {
    margin: 10px 0 0;
    color: var(--tc-muted);
    font: 600 0.95rem/1.58 "Manrope", sans-serif;
}

.hero-meta {
    margin-top: 14px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.meta-pill {
    border-radius: 999px;
    border: 1px solid #cfe1ef;
    background: #f5fbff;
    color: #255676;
    font: 700 0.78rem/1 "Manrope", sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 10px;
}

.status-on {
    border-color: #b8e6d6;
    background: #ecfaf4;
    color: #0f7d58;
}

.status-off {
    border-color: #f0d8ae;
    background: #fff5e8;
    color: #996317;
}

.hero-actions {
    margin-top: 14px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.btn-hero {
    border-radius: 11px;
    border: 1px solid transparent;
    text-decoration: none;
    font: 700 0.86rem/1 "Manrope", sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 13px;
}

.btn-hero.primary {
    background: linear-gradient(135deg, var(--tc-primary), var(--tc-primary-2));
    color: #ffffff;
}

.btn-hero.ghost {
    border-color: #cadeef;
    background: #ffffff;
    color: #205173;
}

.tourney-layout {
    display: grid;
    grid-template-columns: 1.35fr 0.85fr;
    gap: 16px;
}

.main-stack,
.side-stack {
    display: grid;
    gap: 14px;
}

.panel {
    padding: 18px;
}

.panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
}

.panel-head h2 {
    margin: 0;
    color: var(--tc-ink);
    font: 800 1.05rem/1.2 "Sora", sans-serif;
}

.panel-tag {
    border-radius: 999px;
    border: 1px solid #cde1ef;
    background: #f5fbff;
    color: #2e678e;
    font: 700 0.73rem/1 "Manrope", sans-serif;
    text-transform: uppercase;
    letter-spacing: .07em;
    padding: 6px 9px;
}

.empty-box {
    border-radius: 12px;
    border: 1px dashed #c4d8e8;
    background: #f8fcff;
    color: #567084;
    font: 600 0.88rem/1.5 "Manrope", sans-serif;
    padding: 12px;
    margin: 0;
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 10px;
}

.group-card {
    border-radius: 14px;
    border: 1px solid #dbe9f4;
    background: #ffffff;
    padding: 12px;
}

.group-card h3 {
    margin: 0 0 8px;
    color: #184969;
    font: 800 0.95rem/1.2 "Sora", sans-serif;
}

.group-list {
    margin: 0;
    padding: 0;
    list-style: none;
    display: grid;
    gap: 6px;
}

.group-list li {
    border-radius: 9px;
    border: 1px solid #e3edf5;
    background: #fafdff;
    color: #37576e;
    font: 600 0.83rem/1.35 "Manrope", sans-serif;
    padding: 7px 8px;
}

.duels-grid {
    margin-top: 10px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 10px;
}

.duel-card {
    border-radius: 14px;
    border: 1px solid #dbe9f4;
    background: linear-gradient(145deg, #ffffff, #f8fcff);
    padding: 12px;
}

.duel-card h4 {
    margin: 0 0 8px;
    color: #164766;
    font: 800 0.9rem/1.2 "Sora", sans-serif;
}

.duel-pairs {
    margin: 0;
    padding-left: 18px;
}

.duel-pairs li {
    color: #3e5f75;
    font: 600 0.82rem/1.4 "Manrope", sans-serif;
}

.table-wrap {
    overflow-x: auto;
}

.t-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid #d8e8f5;
    border-radius: 14px;
    overflow: hidden;
}

.t-table th,
.t-table td {
    padding: 8px 9px;
    border-bottom: 1px solid #e2edf6;
    color: #36566f;
    font: 600 0.82rem/1.35 "Manrope", sans-serif;
    white-space: nowrap;
}

.t-table th {
    background: #f1f8ff;
    color: #1d4b6d;
    font-weight: 800;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.t-table tbody tr:last-child td {
    border-bottom: 0;
}

.t-table tbody tr:hover td {
    background: #f8fcff;
}

.btn-detail {
    border: 1px solid #bfd9ec;
    border-radius: 9px;
    background: #f4fbff;
    color: #1b5d84;
    font: 700 0.76rem/1 "Manrope", sans-serif;
    padding: 6px 8px;
}

.btn-detail:hover {
    background: #eaf6ff;
    color: #164e6f;
}

.calendar-board {
    display: grid;
    gap: 12px;
}

.schedule-group-card {
    border-radius: 16px;
    border: 1px solid #d9e9f5;
    background: linear-gradient(150deg, #ffffff, #f6fbff);
    padding: 12px;
}

.schedule-group-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dfedf8;
}

.schedule-group-overline {
    margin: 0 0 4px;
    color: #5d7f9a;
    font: 700 0.68rem/1 "Manrope", sans-serif;
    letter-spacing: .11em;
    text-transform: uppercase;
}

.schedule-group-head h3 {
    margin: 0;
    color: #1a4968;
    font: 800 0.98rem/1.2 "Sora", sans-serif;
}

.schedule-group-total {
    border-radius: 999px;
    border: 1px solid #cfe2f0;
    background: #eff7ff;
    color: #235e84;
    font: 800 0.72rem/1 "Manrope", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
    padding: 7px 9px;
    white-space: nowrap;
}

.schedule-round-stack {
    display: grid;
    gap: 10px;
}

.schedule-round {
    border-radius: 13px;
    border: 1px solid #dae9f5;
    background: #ffffff;
    overflow: hidden;
}

.schedule-round-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    background: #f1f8ff;
    border-bottom: 1px solid #dfedf7;
    padding: 8px 10px;
}

.schedule-round-title {
    color: #1a4f72;
    font: 800 0.78rem/1 "Sora", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.schedule-round-count {
    color: #44708d;
    font: 700 0.72rem/1 "Manrope", sans-serif;
}

.schedule-match-list {
    display: grid;
    gap: 8px;
    padding: 10px;
}

.schedule-match {
    display: grid;
    grid-template-columns: minmax(116px, 142px) minmax(220px, 1fr) minmax(140px, 186px) auto;
    align-items: center;
    gap: 10px;
    border-radius: 11px;
    border: 1px solid #deebf6;
    background: #ffffff;
    padding: 10px;
    text-decoration: none;
    transition: transform .14s ease, box-shadow .14s ease, border-color .14s ease, background-color .14s ease;
}

.schedule-match:hover {
    transform: translateY(-1px);
    border-color: #b7d4ea;
    background: #f8fcff;
    box-shadow: 0 8px 20px rgba(11, 70, 112, 0.1);
}

.schedule-meta {
    display: grid;
    gap: 4px;
}

.schedule-date {
    color: #365f7c;
    font: 700 0.76rem/1 "Manrope", sans-serif;
}

.schedule-time {
    color: #0f629c;
    font: 800 0.92rem/1 "Sora", sans-serif;
}

.schedule-time small {
    color: #4c7692;
    font: 700 0.68rem/1 "Manrope", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.schedule-vs {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
}

.schedule-team {
    color: #244f6f;
    font: 700 0.8rem/1.3 "Manrope", sans-serif;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.schedule-vs-chip {
    border-radius: 999px;
    border: 1px solid #c6ddef;
    background: #f1f8ff;
    color: #1d5c84;
    font: 800 0.68rem/1 "Sora", sans-serif;
    letter-spacing: .09em;
    text-transform: uppercase;
    padding: 5px 8px;
    flex-shrink: 0;
}

.schedule-location {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #436b86;
    font: 700 0.74rem/1.2 "Manrope", sans-serif;
    min-width: 0;
}

.schedule-location i {
    color: #2d6b95;
    flex-shrink: 0;
}

.schedule-location span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.schedule-go {
    border-radius: 9px;
    border: 1px solid #bdd8ec;
    background: #f1f8ff;
    color: #1d5f87;
    font: 700 0.72rem/1 "Manrope", sans-serif;
    padding: 7px 8px;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.standings-grid {
    display: grid;
    gap: 10px;
}

.standings-card {
    border-radius: 14px;
    border: 1px solid #dce9f4;
    background: #ffffff;
    padding: 10px;
}

.standings-card h3 {
    margin: 0 0 8px;
    color: #1b4f71;
    font: 800 0.9rem/1.2 "Sora", sans-serif;
}

.knockout-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 10px;
}

.knockout-match {
    border-radius: 14px;
    border: 1px solid #dce9f4;
    background: linear-gradient(150deg, #ffffff, #f6fbff);
    padding: 12px;
}

.knockout-match .stage {
    display: inline-block;
    border-radius: 999px;
    border: 1px solid #cde1f0;
    background: #f2f8fd;
    color: #2b678d;
    font: 700 0.7rem/1 "Manrope", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
    padding: 5px 8px;
    margin-bottom: 8px;
}

.knockout-match .line {
    color: #244f6f;
    font: 700 0.84rem/1.3 "Manrope", sans-serif;
}

.knockout-match .line + .line {
    margin-top: 6px;
}

.vs-chip {
    margin: 6px 0;
    color: #0f9b72;
    font: 800 0.72rem/1 "Sora", sans-serif;
}

.side-card {
    padding: 16px;
}

.side-head {
    margin: 0 0 10px;
    color: var(--tc-ink);
    font: 800 1rem/1.2 "Sora", sans-serif;
}

.rule-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid #d9e7f3;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 10px;
}

.rule-table th,
.rule-table td {
    padding: 8px 9px;
    border-bottom: 1px solid #e3edf5;
    color: #3f5f76;
    font: 700 0.8rem/1.3 "Manrope", sans-serif;
}

.rule-table th {
    background: #f2f8fd;
    color: #1d4d6e;
    text-transform: uppercase;
    font-size: 0.72rem;
}

.rule-table tr:last-child td {
    border-bottom: 0;
}

.rule-list {
    margin: 0;
    padding-left: 18px;
}

.rule-list li {
    color: #3f5f76;
    font: 600 0.84rem/1.45 "Manrope", sans-serif;
}

.summary-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
    margin-bottom: 10px;
}

.summary-card {
    border-radius: 12px;
    border: 1px solid #dce9f4;
    background: #fbfeff;
    padding: 9px 10px;
}

.summary-card span {
    display: block;
    color: #688299;
    font: 700 0.68rem/1 "Manrope", sans-serif;
    text-transform: uppercase;
    letter-spacing: .07em;
    margin-bottom: 4px;
}

.summary-card strong {
    color: #1b4d6e;
    font: 800 1rem/1.1 "Sora", sans-serif;
}

@media (max-width: 1100px) {
    .tourney-layout {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 920px) {
    .schedule-match {
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .schedule-vs {
        justify-content: flex-start;
    }

    .schedule-go {
        justify-self: flex-start;
    }
}

@media (max-width: 576px) {
    .tourney-page {
        padding-top: 16px;
    }

    .hero-card,
    .panel,
    .side-card {
        border-radius: 18px;
    }

    .hero-body,
    .panel,
    .side-card {
        padding: 14px;
    }

    .summary-stats {
        grid-template-columns: 1fr;
    }

    .schedule-group-head {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
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
                        <div class="calendar-board">
                            @foreach($grupos as $grupo)
                                @php
                                    $groupRounds = $fixturesByGroup[$grupo->id] ?? [];
                                    $groupMatches = $matchTotalsByGroup[$grupo->id] ?? 0;
                                @endphp
                                @continue($groupMatches === 0)

                                <article class="schedule-group-card">
                                    <header class="schedule-group-head">
                                        <div>
                                            <p class="schedule-group-overline">Calendario oficial</p>
                                            <h3>{{ $grupo->nombre_grupo }}</h3>
                                        </div>
                                        <span class="schedule-group-total">{{ $groupMatches }} partidos</span>
                                    </header>

                                    <div class="schedule-round-stack">
                                        @foreach($groupRounds as $round)
                                            @php
                                                $roundMatches = $round['matches'] ?? [];
                                            @endphp
                                            @continue(empty($roundMatches))

                                            <section class="schedule-round">
                                                <header class="schedule-round-head">
                                                    <span class="schedule-round-title">Jornada {{ $round['round'] }}</span>
                                                    <span class="schedule-round-count">{{ count($roundMatches) }} partidos</span>
                                                </header>

                                                <div class="schedule-match-list">
                                                    @foreach($roundMatches as $matchIndex => $match)
                                                        <a
                                                            class="schedule-match"
                                                            href="{{ route('events.fixture.detail', [$event->id, $grupo->id, $round['round'], $matchIndex]) }}"
                                                        >
                                                            <div class="schedule-meta">
                                                                <span class="schedule-date">{{ $match['kickoff']->format('d/m/Y') }}</span>
                                                                <span class="schedule-time">{{ $match['kickoff']->format('H:i') }} <small>hrs</small></span>
                                                            </div>

                                                            <div class="schedule-vs">
                                                                <span class="schedule-team" title="{{ $match['home'] }}">{{ $match['home'] }}</span>
                                                                <span class="schedule-vs-chip">VS</span>
                                                                <span class="schedule-team" title="{{ $match['away'] }}">{{ $match['away'] }}</span>
                                                            </div>

                                                            <div class="schedule-location" title="{{ $match['location'] }}">
                                                                <i class="bi bi-geo-alt"></i>
                                                                <span>{{ $match['location'] }}</span>
                                                            </div>

                                                            <span class="schedule-go">
                                                                Detalle
                                                                <i class="bi bi-arrow-up-right"></i>
                                                            </span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </section>
                                        @endforeach
                                    </div>
                                </article>
                            @endforeach
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
<script>
(() => {
    const REFRESH_MS = 30000;
    let timerId = null;

    const schedule = () => {
        clearTimeout(timerId);
        timerId = setTimeout(() => {
            if (document.visibilityState === 'visible') {
                window.location.reload();
                return;
            }
            schedule();
        }, REFRESH_MS);
    };

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            schedule();
        }
    });

    schedule();
})();
</script>
@endpush
