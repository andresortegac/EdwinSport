@extends('layouts.app')

@section('title', 'Detalle del Partido | ' . $event->title)

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo+2:wght@500;600;700;800&display=swap');

:root {
    --fd-bg-a: #071225;
    --fd-bg-b: #0f2642;
    --fd-surface: rgba(7, 17, 31, 0.74);
    --fd-border: rgba(141, 187, 230, 0.35);
    --fd-ink: #f6ce6f;
    --fd-muted: #d6e7ff;
    --fd-primary: #0c6fb5;
    --fd-primary-2: #0a4f80;
    --fd-shadow: 0 24px 58px rgba(0, 0, 0, 0.48);
}

.fixture-page {
    min-height: 72vh;
    padding: 24px 0 56px;
    background: radial-gradient(circle at 50% -5%, #1a3f72, transparent 44%), linear-gradient(145deg, var(--fd-bg-a), var(--fd-bg-b));
}

.fixture-shell {
    display: grid;
    gap: 14px;
}

.fixture-card {
    border-radius: 22px;
    border: 1px solid var(--fd-border);
    background: var(--fd-surface);
    box-shadow: var(--fd-shadow);
    backdrop-filter: blur(3px);
    padding: 18px;
}

.fixture-card-actions {
    background: rgba(255, 255, 255, 0.97);
    border-color: #d9e8f4;
    box-shadow: 0 18px 34px rgba(5, 38, 69, 0.14);
    backdrop-filter: none;
}

.fixture-topline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 9px;
    color: #83cbff;
    font: 700 0.76rem/1 "Exo 2", sans-serif;
    text-transform: uppercase;
    letter-spacing: .13em;
}

.fixture-title {
    margin: 0;
    color: var(--fd-ink);
    font: 400 clamp(2rem, 4vw, 2.9rem)/1 "Bebas Neue", sans-serif;
    letter-spacing: .03em;
}

.fixture-sub {
    margin: 8px 0 0;
    color: var(--fd-muted);
    font: 600 0.95rem/1.55 "Exo 2", sans-serif;
}

.teams-box {
    position: relative;
    overflow: hidden;
    margin-top: 12px;
    border-radius: 20px;
    border: 1px solid rgba(173, 207, 239, 0.34);
    background:
        linear-gradient(120deg, rgba(0, 0, 0, 0.62), rgba(3, 13, 28, 0.65)),
        url('{{ asset('img/vs.jpeg') }}');
    background-size: cover;
    background-position: center;
    padding: 18px;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 16px;
    align-items: center;
    min-height: 420px;
}

.teams-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 20% 55%, rgba(255, 80, 43, 0.62), transparent 44%),
        radial-gradient(circle at 82% 55%, rgba(44, 124, 255, 0.6), transparent 46%),
        linear-gradient(90deg, rgba(255, 47, 0, 0.18), transparent 36%, transparent 64%, rgba(0, 122, 255, 0.2));
    pointer-events: none;
}

.teams-box::after {
    content: "";
    position: absolute;
    left: 50%;
    top: 6%;
    transform: translateX(-50%);
    width: 7px;
    height: 88%;
    border-radius: 999px;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0), rgba(255, 194, 56, 0.98), rgba(255, 255, 255, 0));
    box-shadow: 0 0 34px rgba(255, 190, 67, 0.65);
    pointer-events: none;
}

.team-panel {
    position: relative;
    z-index: 1;
    border: 1px solid rgba(232, 241, 255, 0.35);
    background: rgba(8, 21, 38, 0.56);
    backdrop-filter: blur(3px);
    padding: 16px 14px 28px;
    min-height: 298px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    clip-path: polygon(8% 0, 92% 0, 100% 18%, 100% 84%, 50% 100%, 0 84%, 0 18%);
}

.team-panel.left {
    box-shadow: inset 0 0 0 1px rgba(255, 93, 64, 0.24), 0 0 42px rgba(255, 85, 45, 0.42);
}

.team-panel.right {
    box-shadow: inset 0 0 0 1px rgba(76, 151, 255, 0.26), 0 0 42px rgba(45, 126, 255, 0.42);
}

.team-badge {
    width: 132px;
    height: 132px;
    margin: 0 auto 14px;
    border-radius: 999px;
    display: grid;
    place-items: center;
    color: #ffffff;
    border: 4px solid rgba(255, 255, 255, 0.78);
    font: 800 2rem/1 "Exo 2", sans-serif;
    letter-spacing: .04em;
}

.team-panel.left .team-badge {
    background: radial-gradient(circle at 35% 25%, #ffbfad, #eb3d1f 62%, #b3150a);
    box-shadow: 0 0 0 8px rgba(255, 99, 64, 0.3), 0 10px 30px rgba(236, 68, 37, 0.52);
}

.team-panel.right .team-badge {
    background: radial-gradient(circle at 35% 25%, #b7dcff, #2f80ff 62%, #114eb7);
    box-shadow: 0 0 0 8px rgba(105, 170, 255, 0.28), 0 10px 30px rgba(51, 127, 255, 0.52);
}

.team-name {
    color: #ffffff;
    font: 800 clamp(1.1rem, 2.7vw, 1.58rem)/1.16 "Exo 2", sans-serif;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: .03em;
    text-shadow: 0 2px 14px rgba(0, 0, 0, 0.56);
}

.team-subline {
    position: relative;
    z-index: 1;
    margin-top: 6px;
    color: #d7e8fb;
    font: 700 0.72rem/1 "Exo 2", sans-serif;
    text-transform: uppercase;
    letter-spacing: .11em;
    text-align: center;
}

.versus-core {
    position: relative;
    z-index: 1;
    display: grid;
    place-items: center;
    gap: 10px;
}

.versus-league {
    border-radius: 999px;
    border: 1px solid rgba(255, 224, 146, 0.65);
    background: linear-gradient(145deg, rgba(20, 16, 6, 0.94), rgba(59, 46, 19, 0.9));
    color: #ffd36b;
    font: 400 1.1rem/1 "Bebas Neue", sans-serif;
    letter-spacing: .12em;
    text-transform: uppercase;
    padding: 8px 18px;
    box-shadow: 0 0 20px rgba(255, 198, 74, 0.35);
}

.versus-vs {
    color: #ffe191;
    text-shadow: 0 0 22px rgba(255, 197, 72, 0.7), 0 10px 20px rgba(0, 0, 0, 0.5);
    font: 400 clamp(4.2rem, 13vw, 8.2rem)/.82 "Bebas Neue", sans-serif;
    letter-spacing: .03em;
}

.versus-fire {
    width: 100%;
    max-width: 160px;
    height: 10px;
    border-radius: 999px;
    background: linear-gradient(90deg, rgba(255, 86, 30, 0.06), #ffd35c, rgba(44, 124, 255, 0.16));
    box-shadow: 0 0 28px rgba(255, 201, 84, 0.56);
}

.meta-grid {
    margin-top: 14px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 10px;
}

.meta-item {
    border-radius: 12px;
    border: 1px solid rgba(191, 223, 255, 0.32);
    background: rgba(11, 27, 49, 0.74);
    padding: 10px;
}

.meta-item span {
    display: block;
    color: #9cc2e9;
    font: 700 0.72rem/1 "Exo 2", sans-serif;
    text-transform: uppercase;
    letter-spacing: .09em;
    margin-bottom: 5px;
}

.meta-item strong {
    color: #eef6ff;
    font: 700 0.9rem/1.35 "Exo 2", sans-serif;
}

.actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border-radius: 10px;
    border: 1px solid #cadff0;
    background: #ffffff;
    color: #255778;
    text-decoration: none;
    font: 700 0.86rem/1 "Exo 2", sans-serif;
    padding: 10px 12px;
}

.btn-back.primary {
    border-color: transparent;
    background: linear-gradient(135deg, var(--fd-primary), var(--fd-primary-2));
    color: #ffffff;
}

@media (max-width: 576px) {
    .fixture-page {
        padding-top: 16px;
    }

    .fixture-card {
        border-radius: 16px;
        padding: 14px;
    }

    .teams-box {
        grid-template-columns: 1fr;
        text-align: center;
        min-height: 560px;
        padding: 16px;
    }

    .teams-box::after {
        display: none;
    }

    .versus-core {
        order: -1;
        padding: 6px 0;
    }

    .team-panel {
        clip-path: none;
        border-radius: 16px;
        min-height: 220px;
    }

    .team-badge {
        width: 104px;
        height: 104px;
        font-size: 1.45rem;
    }
}
</style>
@endpush

@section('content')
@php
    $homeBadge = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $match['home']), 0, 3)) ?: 'AAA';
    $awayBadge = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $match['away']), 0, 3)) ?: 'BBB';
@endphp
<div class="fixture-page">
    <div class="container fixture-shell">
        <section class="fixture-card">
            <p class="fixture-topline">
                <i class="bi bi-calendar2-week"></i>
                Detalle del partido
            </p>

            <h1 class="fixture-title">{{ $event->title }}</h1>
            <p class="fixture-sub">
                {{ $grupo->nombre_grupo }} · Jornada {{ $jornada }} · Partido {{ $partidoNumero }} de {{ $totalPartidosJornada }}
            </p>

            <div class="teams-box">
                <article class="team-panel left">
                    <div class="team-badge">{{ $homeBadge }}</div>
                    <div class="team-name">{{ $match['home'] }}</div>
                    <div class="team-subline">Equipo local</div>
                </article>

                <div class="versus-core" aria-hidden="true">
                    <div class="versus-league">UFFA</div>
                    <div class="versus-vs">VS</div>
                    <div class="versus-fire"></div>
                </div>

                <article class="team-panel right">
                    <div class="team-badge">{{ $awayBadge }}</div>
                    <div class="team-name">{{ $match['away'] }}</div>
                    <div class="team-subline">Equipo visitante</div>
                </article>
            </div>

            <div class="meta-grid">
                <article class="meta-item">
                    <span>Fecha</span>
                    <strong>{{ $match['kickoff']->format('d/m/Y') }}</strong>
                </article>
                <article class="meta-item">
                    <span>Hora</span>
                    <strong>{{ $match['kickoff']->format('H:i') }}</strong>
                </article>
                <article class="meta-item">
                    <span>Lugar</span>
                    <strong>{{ $match['location'] }}</strong>
                </article>
                <article class="meta-item">
                    <span>Estado</span>
                    <strong>Programado</strong>
                </article>
            </div>
        </section>

        <section class="fixture-card fixture-card-actions">
            <div class="actions">
                <a href="{{ route('events.show', $event->id) }}" class="btn-back">
                    <i class="bi bi-arrow-left-circle"></i>
                    Volver al centro de competicion
                </a>
                <a href="{{ route('competicion', $event->id) }}" class="btn-back primary">
                    <i class="bi bi-trophy"></i>
                    Ir a competicion
                </a>
            </div>
        </section>
    </div>
</div>
@endsection
