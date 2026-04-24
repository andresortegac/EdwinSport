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
    isolation: isolate;
    margin-top: 12px;
    border-radius: 20px;
    border: 1px solid rgba(173, 207, 239, 0.34);
    background: transparent;
    padding: 18px;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 16px;
    align-items: center;
    min-height: 420px;
}

.teams-box::before {
    display: none;
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

.tecnico-side {
    position: absolute;
    bottom: 0;
    z-index: 4;
    width: clamp(540px, 23vw, 330px);
    pointer-events: none;
}

.tecnico-side.left {
    left: -4px;
}

.tecnico-side.right {
    right: -4px;
}

.tecnico-side img {
    display: block;
    width: 100%;
    max-height: 360px;
    object-fit: contain;
    object-position: bottom;
    opacity: .96;
    filter: drop-shadow(0 14px 22px rgba(0, 0, 0, 0.62)) saturate(1.04) contrast(1.03);
    -webkit-mask-image: radial-gradient(ellipse 86% 95% at 50% 72%, #000 56%, rgba(0, 0, 0, .94) 70%, rgba(0, 0, 0, .48) 84%, transparent 100%);
    mask-image: radial-gradient(ellipse 86% 95% at 50% 72%, #000 56%, rgba(0, 0, 0, .94) 70%, rgba(0, 0, 0, .48) 84%, transparent 100%);
}

.tecnico-side::after {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.tecnico-side.left::after {
    background:
        linear-gradient(to right, rgba(7, 17, 31, .24), transparent 42%),
        linear-gradient(to top, rgba(7, 17, 31, .56), rgba(7, 17, 31, .12) 35%, transparent 75%);
}

.tecnico-side.right::after {
    background:
        linear-gradient(to left, rgba(7, 17, 31, .24), transparent 42%),
        linear-gradient(to top, rgba(7, 17, 31, .56), rgba(7, 17, 31, .12) 35%, transparent 75%);
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
    display: grid;
    grid-template-columns: minmax(240px, 360px) minmax(0, 1fr);
    gap: 12px;
    align-items: start;
}

.actions-col {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.live-panel {
    border: 1px solid #d0e2f1;
    border-radius: 12px;
    padding: 10px;
    background: linear-gradient(180deg, #fbfdff, #f2f8ff);
}

.live-title {
    margin: 0 0 6px;
    color: #1b4f72;
    font: 800 0.86rem/1 "Exo 2", sans-serif;
    letter-spacing: .05em;
    text-transform: uppercase;
}

.live-platforms {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 8px;
}

.live-chip {
    border-radius: 999px;
    border: 1px solid #bdd8ee;
    background: #ffffff;
    color: #2a5c7f;
    font: 700 0.7rem/1 "Exo 2", sans-serif;
    letter-spacing: .03em;
    text-transform: uppercase;
    padding: 5px 9px;
}

.live-form {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 8px;
}

.live-input {
    width: 100%;
    border-radius: 9px;
    border: 1px solid #bfd7eb;
    padding: 10px 11px;
    font: 600 0.86rem/1.2 "Exo 2", sans-serif;
    color: #0f3654;
    background: #ffffff;
    outline: none;
}

.live-input:focus {
    border-color: #2f80ff;
    box-shadow: 0 0 0 2px rgba(47, 128, 255, 0.2);
}

.btn-live {
    justify-content: center;
    white-space: nowrap;
}

.live-help {
    margin: 8px 0 0;
    color: #4a6f8f;
    font: 600 0.76rem/1.45 "Exo 2", sans-serif;
}

.live-open-link {
    margin-top: 8px;
    display: none;
    width: fit-content;
}

.live-embed {
    margin-top: 10px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #bed8ed;
    box-shadow: 0 10px 24px rgba(9, 54, 92, 0.14);
    display: none;
    aspect-ratio: 16 / 9;
    background: #04111e;
}

.live-embed.is-active {
    display: block;
}

.live-embed iframe {
    width: 100%;
    height: 100%;
    border: 0;
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

.report-board {
    margin-top: 14px;
    display: grid;
    gap: 12px;
}

.result-strip {
    border-radius: 14px;
    border: 1px solid rgba(191, 223, 255, 0.32);
    background: linear-gradient(145deg, rgba(14, 35, 62, 0.84), rgba(7, 20, 36, 0.94));
    padding: 12px;
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
    gap: 10px;
    align-items: center;
}

.result-strip.is-empty {
    background: linear-gradient(145deg, rgba(11, 28, 49, 0.78), rgba(6, 18, 32, 0.9));
}

.result-team {
    color: #edf6ff;
    font: 700 0.95rem/1.2 "Exo 2", sans-serif;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.result-team.right {
    text-align: right;
}

.result-core {
    text-align: center;
    display: grid;
    gap: 4px;
}

.result-core strong {
    color: #ffd36b;
    font: 400 clamp(2.4rem, 6vw, 3.2rem)/1 "Bebas Neue", sans-serif;
    letter-spacing: .04em;
}

.result-core span {
    color: #b9d7f5;
    font: 700 0.72rem/1 "Exo 2", sans-serif;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.team-insights {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
}

.team-insight-card {
    border-radius: 14px;
    border: 1px solid rgba(185, 218, 247, 0.32);
    background: rgba(9, 25, 44, 0.66);
    padding: 12px;
    display: grid;
    gap: 10px;
}

.team-insight-head {
    border-bottom: 1px solid rgba(181, 216, 247, 0.26);
    padding-bottom: 8px;
}

.team-insight-head h3 {
    margin: 0;
    color: #f5fbff;
    font: 700 1rem/1.2 "Exo 2", sans-serif;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.team-insight-head p {
    margin: 6px 0 0;
    color: #9dc5e8;
    font: 700 0.7rem/1 "Exo 2", sans-serif;
    letter-spacing: .09em;
    text-transform: uppercase;
}

.insight-block h4 {
    margin: 0 0 7px;
    color: #ffd988;
    font: 700 0.75rem/1 "Exo 2", sans-serif;
    letter-spacing: .09em;
    text-transform: uppercase;
}

.lineup-list {
    margin: 0;
    padding-left: 18px;
    display: grid;
    gap: 4px;
}

.lineup-list li {
    color: #e9f4ff;
    font: 600 0.84rem/1.35 "Exo 2", sans-serif;
}

.cards-summary {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
    margin-bottom: 8px;
}

.card-badge {
    border-radius: 10px;
    border: 1px solid rgba(190, 218, 243, 0.3);
    padding: 7px 8px;
    text-align: center;
}

.card-badge span {
    display: block;
    color: #b7d1e7;
    font: 700 0.66rem/1 "Exo 2", sans-serif;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.card-badge strong {
    display: block;
    margin-top: 5px;
    color: #ffffff;
    font: 800 1rem/1 "Exo 2", sans-serif;
}

.card-badge.yellow {
    background: rgba(180, 140, 12, 0.25);
    border-color: rgba(252, 206, 73, 0.45);
}

.card-badge.red {
    background: rgba(166, 33, 33, 0.24);
    border-color: rgba(244, 108, 108, 0.45);
}

.card-badge.blue {
    background: rgba(23, 84, 162, 0.28);
    border-color: rgba(113, 173, 246, 0.5);
}

.cards-players {
    display: grid;
    gap: 4px;
}

.cards-players p {
    margin: 0;
    color: #dcebfa;
    font: 600 0.78rem/1.4 "Exo 2", sans-serif;
}

.cards-players p strong {
    color: #ffffff;
}

.insight-facts {
    margin: 0;
    padding: 0;
    list-style: none;
    display: grid;
    gap: 6px;
}

.insight-facts li {
    border-radius: 10px;
    border: 1px solid rgba(186, 218, 245, 0.28);
    background: rgba(8, 22, 39, 0.6);
    padding: 8px;
}

.insight-facts span {
    display: block;
    color: #9ec3e4;
    font: 700 0.66rem/1 "Exo 2", sans-serif;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.insight-facts strong {
    display: block;
    margin-top: 4px;
    color: #ffffff;
    font: 700 0.9rem/1.2 "Exo 2", sans-serif;
}

.insight-facts small {
    display: block;
    margin-top: 4px;
    color: #b4d3ef;
    font: 700 0.74rem/1 "Exo 2", sans-serif;
}

.empty-mini {
    margin: 0;
    color: #a5c4e0;
    font: 600 0.78rem/1.35 "Exo 2", sans-serif;
}

.match-highlights {
    border-radius: 12px;
    border: 1px solid rgba(190, 220, 246, 0.3);
    background: rgba(8, 24, 42, 0.62);
    padding: 10px;
}

.match-highlights h4 {
    margin: 0 0 6px;
    color: #ffd988;
    font: 700 0.74rem/1 "Exo 2", sans-serif;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.match-highlights p {
    margin: 0;
    color: #e8f4ff;
    font: 600 0.85rem/1.45 "Exo 2", sans-serif;
    white-space: pre-line;
}

.editor-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
}

.editor-title {
    margin: 0;
    color: #1f4f70;
    font: 800 1rem/1 "Exo 2", sans-serif;
    letter-spacing: .02em;
}

.editor-tag {
    border-radius: 999px;
    border: 1px solid #c8def0;
    background: #eef7ff;
    color: #2a6389;
    font: 700 0.7rem/1 "Exo 2", sans-serif;
    letter-spacing: .06em;
    text-transform: uppercase;
    padding: 6px 10px;
}

.report-form {
    display: grid;
    gap: 12px;
}

.report-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
}

.report-col {
    border: 1px solid #d5e7f4;
    border-radius: 12px;
    background: #f9fcff;
    padding: 10px;
    display: grid;
    gap: 8px;
}

.report-col h4 {
    margin: 0;
    color: #1f5275;
    font: 800 0.88rem/1 "Exo 2", sans-serif;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.input-row {
    display: grid;
    gap: 6px;
}

.input-row label {
    color: #356283;
    font: 700 0.73rem/1 "Exo 2", sans-serif;
    letter-spacing: .04em;
    text-transform: uppercase;
}

.input-row input,
.input-row textarea {
    width: 100%;
    border: 1px solid #bfd7e8;
    border-radius: 9px;
    padding: 9px 10px;
    color: #123a57;
    font: 600 0.84rem/1.3 "Exo 2", sans-serif;
    background: #ffffff;
    outline: none;
}

.input-row textarea {
    min-height: 90px;
    resize: vertical;
}

.input-row input:focus,
.input-row textarea:focus {
    border-color: #2f80ff;
    box-shadow: 0 0 0 2px rgba(47, 128, 255, 0.15);
}

.score-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 8px;
}

.roster-help {
    margin: 0;
    color: #587d99;
    font: 600 0.74rem/1.45 "Exo 2", sans-serif;
}

.report-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
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

    .tecnico-side {
        width: clamp(120px, 38vw, 220px);
    }

    .actions {
        grid-template-columns: 1fr;
    }

    .live-form {
        grid-template-columns: 1fr;
    }

    .result-strip {
        grid-template-columns: 1fr;
    }

    .result-team.right {
        text-align: left;
    }

    .team-insights {
        grid-template-columns: 1fr;
    }

    .cards-summary {
        grid-template-columns: 1fr;
    }

    .report-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
@php
    $homeBadge = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $match['home']), 0, 3)) ?: 'AAA';
    $awayBadge = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $match['away']), 0, 3)) ?: 'BBB';
    $tecnicoLocalPath = $fixtureTecnico->local_image_path ?? $fixtureTecnico->image_path ?? null;
    $tecnicoVisitantePath = $fixtureTecnico->visitante_image_path ?? null;

    $buildRoster = static function ($roster) {
        return collect($roster)->map(function ($player) {
            $shirt = trim((string) ($player->numero_camisa ?? ''));
            $prefix = $shirt !== '' ? '#' . $shirt . ' ' : '';
            return $prefix . (string) $player->nombre;
        })->values()->all();
    };

    $localRosterList = $buildRoster($homeRoster ?? collect());
    $visitanteRosterList = $buildRoster($awayRoster ?? collect());

    $localLineupRaw = $fixtureReport?->local_lineup ?? [];
    $visitanteLineupRaw = $fixtureReport?->visitante_lineup ?? [];
    $localLineupDisplay = !empty($localLineupRaw) ? $localLineupRaw : $localRosterList;
    $visitanteLineupDisplay = !empty($visitanteLineupRaw) ? $visitanteLineupRaw : $visitanteRosterList;
    $localLineupLabel = !empty($localLineupRaw) ? 'Alineacion confirmada' : 'Plantel disponible';
    $visitanteLineupLabel = !empty($visitanteLineupRaw) ? 'Alineacion confirmada' : 'Plantel disponible';

    $localYellow = $fixtureReport?->local_yellow_cards ?? [];
    $localRed = $fixtureReport?->local_red_cards ?? [];
    $localBlue = $fixtureReport?->local_blue_cards ?? [];
    $visitanteYellow = $fixtureReport?->visitante_yellow_cards ?? [];
    $visitanteRed = $fixtureReport?->visitante_red_cards ?? [];
    $visitanteBlue = $fixtureReport?->visitante_blue_cards ?? [];

    $scoreLocal = $fixtureReport?->score_local ?? ($matchScore['local'] ?? null);
    $scoreVisitante = $fixtureReport?->score_visitante ?? ($matchScore['visitante'] ?? null);
    $hasScore = $scoreLocal !== null && $scoreVisitante !== null;

    $localRosterText = implode(', ', $localRosterList);
    $visitanteRosterText = implode(', ', $visitanteRosterList);

    $formLocalLineup = old('local_lineup', implode("\n", $localLineupRaw));
    $formVisitanteLineup = old('visitante_lineup', implode("\n", $visitanteLineupRaw));
    $formLocalYellow = old('local_yellow_cards', implode("\n", $localYellow));
    $formLocalRed = old('local_red_cards', implode("\n", $localRed));
    $formLocalBlue = old('local_blue_cards', implode("\n", $localBlue));
    $formVisitanteYellow = old('visitante_yellow_cards', implode("\n", $visitanteYellow));
    $formVisitanteRed = old('visitante_red_cards', implode("\n", $visitanteRed));
    $formVisitanteBlue = old('visitante_blue_cards', implode("\n", $visitanteBlue));
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
                @if(!empty($tecnicoLocalPath))
                    <div class="tecnico-side left">
                        <img
                            src="{{ route('events.media', ['path' => $tecnicoLocalPath]) }}"
                            alt="Imagen local {{ $match['home'] }}"
                        >
                    </div>
                @endif

                @if(!empty($tecnicoVisitantePath))
                    <div class="tecnico-side right">
                        <img
                            src="{{ route('events.media', ['path' => $tecnicoVisitantePath]) }}"
                            alt="Imagen visitante {{ $match['away'] }}"
                        >
                    </div>
                @endif

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

            <div class="report-board">
                <article class="result-strip {{ $hasScore ? '' : 'is-empty' }}">
                    <div class="result-team">{{ $match['home'] }}</div>
                    <div class="result-core">
                        @if($hasScore)
                            <strong>{{ $scoreLocal }} - {{ $scoreVisitante }}</strong>
                            <span>Marcador oficial</span>
                        @else
                            <strong>VS</strong>
                            <span>Partido programado</span>
                        @endif
                    </div>
                    <div class="result-team right">{{ $match['away'] }}</div>
                </article>

                <div class="team-insights">
                    <article class="team-insight-card">
                        <header class="team-insight-head">
                            <h3>{{ $match['home'] }}</h3>
                            <p>{{ $localLineupLabel }}</p>
                        </header>

                        <section class="insight-block">
                            <h4>Jugadores que van a jugar</h4>
                            @if(!empty($localLineupDisplay))
                                <ul class="lineup-list">
                                    @foreach($localLineupDisplay as $player)
                                        <li>{{ $player }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="empty-mini">Sin alineacion registrada para este encuentro.</p>
                            @endif
                        </section>

                        <section class="insight-block">
                            <h4>Tarjetas</h4>
                            <div class="cards-summary">
                                <article class="card-badge yellow">
                                    <span>Amarillas</span>
                                    <strong>{{ count($localYellow) }}</strong>
                                </article>
                                <article class="card-badge red">
                                    <span>Rojas</span>
                                    <strong>{{ count($localRed) }}</strong>
                                </article>
                                <article class="card-badge blue">
                                    <span>Azules</span>
                                    <strong>{{ count($localBlue) }}</strong>
                                </article>
                            </div>
                            <div class="cards-players">
                                @if(!empty($localYellow))
                                    <p><strong>A:</strong> {{ implode(', ', $localYellow) }}</p>
                                @endif
                                @if(!empty($localRed))
                                    <p><strong>R:</strong> {{ implode(', ', $localRed) }}</p>
                                @endif
                                @if(!empty($localBlue))
                                    <p><strong>Z:</strong> {{ implode(', ', $localBlue) }}</p>
                                @endif
                                @if(empty($localYellow) && empty($localRed) && empty($localBlue))
                                    <p class="empty-mini">Sin tarjetas registradas.</p>
                                @endif
                            </div>
                        </section>

                        <section class="insight-block">
                            <h4>Destacados</h4>
                            <ul class="insight-facts">
                                <li>
                                    <span>Jugador con mas goles</span>
                                    <strong>{{ $fixtureReport?->local_top_scorer ?? 'Sin dato' }}</strong>
                                    <small>Goles: {{ $fixtureReport?->local_top_scorer_goals ?? '-' }}</small>
                                </li>
                                <li>
                                    <span>Arquero con menor valla vencida</span>
                                    <strong>{{ $fixtureReport?->local_best_goalkeeper ?? 'Sin dato' }}</strong>
                                    <small>Goles recibidos: {{ $fixtureReport?->local_goalkeeper_goals_conceded ?? '-' }}</small>
                                </li>
                            </ul>
                        </section>
                    </article>

                    <article class="team-insight-card">
                        <header class="team-insight-head">
                            <h3>{{ $match['away'] }}</h3>
                            <p>{{ $visitanteLineupLabel }}</p>
                        </header>

                        <section class="insight-block">
                            <h4>Jugadores que van a jugar</h4>
                            @if(!empty($visitanteLineupDisplay))
                                <ul class="lineup-list">
                                    @foreach($visitanteLineupDisplay as $player)
                                        <li>{{ $player }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="empty-mini">Sin alineacion registrada para este encuentro.</p>
                            @endif
                        </section>

                        <section class="insight-block">
                            <h4>Tarjetas</h4>
                            <div class="cards-summary">
                                <article class="card-badge yellow">
                                    <span>Amarillas</span>
                                    <strong>{{ count($visitanteYellow) }}</strong>
                                </article>
                                <article class="card-badge red">
                                    <span>Rojas</span>
                                    <strong>{{ count($visitanteRed) }}</strong>
                                </article>
                                <article class="card-badge blue">
                                    <span>Azules</span>
                                    <strong>{{ count($visitanteBlue) }}</strong>
                                </article>
                            </div>
                            <div class="cards-players">
                                @if(!empty($visitanteYellow))
                                    <p><strong>A:</strong> {{ implode(', ', $visitanteYellow) }}</p>
                                @endif
                                @if(!empty($visitanteRed))
                                    <p><strong>R:</strong> {{ implode(', ', $visitanteRed) }}</p>
                                @endif
                                @if(!empty($visitanteBlue))
                                    <p><strong>Z:</strong> {{ implode(', ', $visitanteBlue) }}</p>
                                @endif
                                @if(empty($visitanteYellow) && empty($visitanteRed) && empty($visitanteBlue))
                                    <p class="empty-mini">Sin tarjetas registradas.</p>
                                @endif
                            </div>
                        </section>

                        <section class="insight-block">
                            <h4>Destacados</h4>
                            <ul class="insight-facts">
                                <li>
                                    <span>Jugador con mas goles</span>
                                    <strong>{{ $fixtureReport?->visitante_top_scorer ?? 'Sin dato' }}</strong>
                                    <small>Goles: {{ $fixtureReport?->visitante_top_scorer_goals ?? '-' }}</small>
                                </li>
                                <li>
                                    <span>Arquero con menor valla vencida</span>
                                    <strong>{{ $fixtureReport?->visitante_best_goalkeeper ?? 'Sin dato' }}</strong>
                                    <small>Goles recibidos: {{ $fixtureReport?->visitante_goalkeeper_goals_conceded ?? '-' }}</small>
                                </li>
                            </ul>
                        </section>
                    </article>
                </div>

                @if(!empty($fixtureReport?->highlights))
                    <article class="match-highlights">
                        <h4>Resumen del encuentro</h4>
                        <p>{{ $fixtureReport?->highlights }}</p>
                    </article>
                @endif
            </div>
        </section>

        <section class="fixture-card fixture-card-actions">
            <div class="actions">
                <div class="actions-col">
                    <a href="{{ route('events.show', $event->id) }}" class="btn-back">
                        <i class="bi bi-arrow-left-circle"></i>
                        Volver al centro de competicion
                    </a>
                </div>

                <div class="live-panel">
                    <p class="live-title">
                        <i class="bi bi-broadcast-pin"></i>
                        Transmision en vivo (YouTube, Facebook, Instagram, TikTok)
                    </p>

                    @if(session('live_success'))
                        <div class="alert alert-success py-2 px-3 mb-2">
                            {{ session('live_success') }}
                        </div>
                    @endif

                    @if($errors->liveStream->any())
                        <div class="alert alert-danger py-2 px-3 mb-2">
                            <ul class="mb-0">
                                @foreach($errors->liveStream->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="live-platforms" aria-hidden="true">
                        <span class="live-chip">YouTube</span>
                        <span class="live-chip">Facebook</span>
                        <span class="live-chip">Instagram</span>
                        <span class="live-chip">TikTok</span>
                    </div>

                    @if(auth()->check() && auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('events.fixture.stream.store') }}" class="live-form">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                            <input type="hidden" name="jornada" value="{{ $jornada }}">
                            <input type="hidden" name="partido_numero" value="{{ $partidoIndex }}">

                            <input
                                id="yt-live-url"
                                name="live_url"
                                class="live-input"
                                type="url"
                                value="{{ old('live_url', $liveStream->live_url ?? '') }}"
                                placeholder="Pega un enlace de YouTube, Facebook, Instagram o TikTok"
                                required>

                            <button type="submit" class="btn-back primary btn-live">
                                Guardar en vivo
                            </button>
                        </form>
                    @endif

                    <p id="yt-live-message" class="live-help">
                        @if(auth()->check() && auth()->user()->isAdmin())
                            Guarda un enlace oficial para que todos vean esta transmision.
                        @else
                            El enlace oficial lo carga un administrador del evento.
                        @endif
                    </p>

                    <div id="yt-live-embed" class="live-embed" aria-live="polite">
                        <iframe
                            id="yt-live-frame"
                            title="Transmision en vivo"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>

                    <a id="yt-live-open-link"
                       class="btn-back live-open-link"
                       href="#"
                       target="_blank"
                       rel="noopener noreferrer">
                        <i class="bi bi-box-arrow-up-right"></i>
                        Abrir en nueva pestana
                    </a>
                </div>
            </div>
        </section>

        <section class="fixture-card fixture-card-actions">
            <div class="editor-head">
                <h2 class="editor-title">Panel de informacion del encuentro</h2>
                <span class="editor-tag">Por partido</span>
            </div>

            @if(session('fixture_report_success'))
                <div class="alert alert-success py-2 px-3 mb-2">
                    {{ session('fixture_report_success') }}
                </div>
            @endif

            @if($errors->fixtureReport->any())
                <div class="alert alert-danger py-2 px-3 mb-2">
                    <ul class="mb-0">
                        @foreach($errors->fixtureReport->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(auth()->check() && auth()->user()->isAdmin())
                <form method="POST" action="{{ route('events.fixture.report.store') }}" class="report-form">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                    <input type="hidden" name="jornada" value="{{ $jornada }}">
                    <input type="hidden" name="partido_numero" value="{{ $partidoIndex }}">

                    <div class="score-grid">
                        <div class="input-row">
                            <label for="score_local">Marcador local</label>
                            <input
                                id="score_local"
                                name="score_local"
                                type="number"
                                min="0"
                                max="99"
                                value="{{ old('score_local', $fixtureReport?->score_local ?? ($matchScore['local'] ?? '')) }}"
                                placeholder="Ej: 2"
                            >
                        </div>
                        <div class="input-row">
                            <label for="score_visitante">Marcador visitante</label>
                            <input
                                id="score_visitante"
                                name="score_visitante"
                                type="number"
                                min="0"
                                max="99"
                                value="{{ old('score_visitante', $fixtureReport?->score_visitante ?? ($matchScore['visitante'] ?? '')) }}"
                                placeholder="Ej: 1"
                            >
                        </div>
                    </div>

                    <div class="report-grid">
                        <article class="report-col">
                            <h4>{{ $match['home'] }} (Local)</h4>

                            <div class="input-row">
                                <label for="local_lineup">Jugadores que van a jugar</label>
                                <textarea
                                    id="local_lineup"
                                    name="local_lineup"
                                    placeholder="Un jugador por linea"
                                >{{ $formLocalLineup }}</textarea>
                                @if($localRosterText !== '')
                                    <p class="roster-help">Plantel registrado: {{ $localRosterText }}</p>
                                @endif
                            </div>

                            <div class="input-row">
                                <label for="local_yellow_cards">Tarjetas amarillas</label>
                                <textarea
                                    id="local_yellow_cards"
                                    name="local_yellow_cards"
                                    placeholder="Jugadores con amarilla (uno por linea)"
                                >{{ $formLocalYellow }}</textarea>
                            </div>

                            <div class="input-row">
                                <label for="local_red_cards">Tarjetas rojas</label>
                                <textarea
                                    id="local_red_cards"
                                    name="local_red_cards"
                                    placeholder="Jugadores con roja (uno por linea)"
                                >{{ $formLocalRed }}</textarea>
                            </div>

                            <div class="input-row">
                                <label for="local_blue_cards">Tarjetas azules</label>
                                <textarea
                                    id="local_blue_cards"
                                    name="local_blue_cards"
                                    placeholder="Jugadores con azul (uno por linea)"
                                >{{ $formLocalBlue }}</textarea>
                            </div>

                            <div class="input-row">
                                <label for="local_top_scorer">Jugador con mas goles</label>
                                <input
                                    id="local_top_scorer"
                                    name="local_top_scorer"
                                    type="text"
                                    value="{{ old('local_top_scorer', $fixtureReport?->local_top_scorer ?? '') }}"
                                    placeholder="Nombre del goleador"
                                >
                            </div>

                            <div class="input-row">
                                <label for="local_top_scorer_goals">Goles del goleador</label>
                                <input
                                    id="local_top_scorer_goals"
                                    name="local_top_scorer_goals"
                                    type="number"
                                    min="0"
                                    max="99"
                                    value="{{ old('local_top_scorer_goals', $fixtureReport?->local_top_scorer_goals ?? '') }}"
                                    placeholder="Ej: 3"
                                >
                            </div>

                            <div class="input-row">
                                <label for="local_best_goalkeeper">Arquero con menor valla vencida</label>
                                <input
                                    id="local_best_goalkeeper"
                                    name="local_best_goalkeeper"
                                    type="text"
                                    value="{{ old('local_best_goalkeeper', $fixtureReport?->local_best_goalkeeper ?? '') }}"
                                    placeholder="Nombre del arquero"
                                >
                            </div>

                            <div class="input-row">
                                <label for="local_goalkeeper_goals_conceded">Goles recibidos del arquero</label>
                                <input
                                    id="local_goalkeeper_goals_conceded"
                                    name="local_goalkeeper_goals_conceded"
                                    type="number"
                                    min="0"
                                    max="99"
                                    value="{{ old('local_goalkeeper_goals_conceded', $fixtureReport?->local_goalkeeper_goals_conceded ?? '') }}"
                                    placeholder="Ej: 1"
                                >
                            </div>
                        </article>

                        <article class="report-col">
                            <h4>{{ $match['away'] }} (Visitante)</h4>

                            <div class="input-row">
                                <label for="visitante_lineup">Jugadores que van a jugar</label>
                                <textarea
                                    id="visitante_lineup"
                                    name="visitante_lineup"
                                    placeholder="Un jugador por linea"
                                >{{ $formVisitanteLineup }}</textarea>
                                @if($visitanteRosterText !== '')
                                    <p class="roster-help">Plantel registrado: {{ $visitanteRosterText }}</p>
                                @endif
                            </div>

                            <div class="input-row">
                                <label for="visitante_yellow_cards">Tarjetas amarillas</label>
                                <textarea
                                    id="visitante_yellow_cards"
                                    name="visitante_yellow_cards"
                                    placeholder="Jugadores con amarilla (uno por linea)"
                                >{{ $formVisitanteYellow }}</textarea>
                            </div>

                            <div class="input-row">
                                <label for="visitante_red_cards">Tarjetas rojas</label>
                                <textarea
                                    id="visitante_red_cards"
                                    name="visitante_red_cards"
                                    placeholder="Jugadores con roja (uno por linea)"
                                >{{ $formVisitanteRed }}</textarea>
                            </div>

                            <div class="input-row">
                                <label for="visitante_blue_cards">Tarjetas azules</label>
                                <textarea
                                    id="visitante_blue_cards"
                                    name="visitante_blue_cards"
                                    placeholder="Jugadores con azul (uno por linea)"
                                >{{ $formVisitanteBlue }}</textarea>
                            </div>

                            <div class="input-row">
                                <label for="visitante_top_scorer">Jugador con mas goles</label>
                                <input
                                    id="visitante_top_scorer"
                                    name="visitante_top_scorer"
                                    type="text"
                                    value="{{ old('visitante_top_scorer', $fixtureReport?->visitante_top_scorer ?? '') }}"
                                    placeholder="Nombre del goleador"
                                >
                            </div>

                            <div class="input-row">
                                <label for="visitante_top_scorer_goals">Goles del goleador</label>
                                <input
                                    id="visitante_top_scorer_goals"
                                    name="visitante_top_scorer_goals"
                                    type="number"
                                    min="0"
                                    max="99"
                                    value="{{ old('visitante_top_scorer_goals', $fixtureReport?->visitante_top_scorer_goals ?? '') }}"
                                    placeholder="Ej: 2"
                                >
                            </div>

                            <div class="input-row">
                                <label for="visitante_best_goalkeeper">Arquero con menor valla vencida</label>
                                <input
                                    id="visitante_best_goalkeeper"
                                    name="visitante_best_goalkeeper"
                                    type="text"
                                    value="{{ old('visitante_best_goalkeeper', $fixtureReport?->visitante_best_goalkeeper ?? '') }}"
                                    placeholder="Nombre del arquero"
                                >
                            </div>

                            <div class="input-row">
                                <label for="visitante_goalkeeper_goals_conceded">Goles recibidos del arquero</label>
                                <input
                                    id="visitante_goalkeeper_goals_conceded"
                                    name="visitante_goalkeeper_goals_conceded"
                                    type="number"
                                    min="0"
                                    max="99"
                                    value="{{ old('visitante_goalkeeper_goals_conceded', $fixtureReport?->visitante_goalkeeper_goals_conceded ?? '') }}"
                                    placeholder="Ej: 0"
                                >
                            </div>
                        </article>
                    </div>

                    <div class="input-row">
                        <label for="highlights">Resumen del encuentro</label>
                        <textarea
                            id="highlights"
                            name="highlights"
                            placeholder="Resumen libre del partido"
                        >{{ old('highlights', $fixtureReport?->highlights ?? '') }}</textarea>
                    </div>

                    <div class="report-actions">
                        <button type="submit" class="btn-back primary">
                            <i class="bi bi-save"></i>
                            Guardar informacion del partido
                        </button>
                    </div>
                </form>
            @else
                <p class="live-help mb-0">
                    Solo un administrador puede editar la informacion avanzada del encuentro.
                </p>
            @endif
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('yt-live-url');
    const message = document.getElementById('yt-live-message');
    const embed = document.getElementById('yt-live-embed');
    const frame = document.getElementById('yt-live-frame');
    const openLink = document.getElementById('yt-live-open-link');

    if (!message || !embed || !frame || !openLink) return;

    function safeParseUrl(rawValue) {
        try {
            return new URL(rawValue);
        } catch (error) {
            return null;
        }
    }

    function sanitizeId(value) {
        return (value || '').split('?')[0].split('&')[0].replace(/[^\w-]/g, '');
    }

    function resolveYouTube(rawValue, parsed) {
        const plainId = sanitizeId((rawValue || '').trim());
        if (/^[a-zA-Z0-9_-]{11}$/.test(plainId)) {
            return {
                platform: 'YouTube',
                embedUrl: 'https://www.youtube.com/embed/' + plainId + '?autoplay=1&rel=0&modestbranding=1',
                sourceUrl: 'https://www.youtube.com/watch?v=' + plainId
            };
        }

        if (!parsed) return null;

        const host = parsed.hostname.replace(/^www\./, '');
        if (!(host === 'youtu.be' || host.includes('youtube.com'))) {
            return null;
        }

        let videoId = '';
        if (host === 'youtu.be') {
            videoId = sanitizeId(parsed.pathname.split('/').filter(Boolean)[0] || '');
        } else {
            videoId = sanitizeId(parsed.searchParams.get('v') || '');
            if (!videoId) {
                const pathParts = parsed.pathname.split('/').filter(Boolean);
                const knownKeys = ['embed', 'live', 'shorts'];
                for (const key of knownKeys) {
                    const keyIndex = pathParts.indexOf(key);
                    if (keyIndex >= 0 && pathParts[keyIndex + 1]) {
                        videoId = sanitizeId(pathParts[keyIndex + 1]);
                        break;
                    }
                }
            }
        }

        if (!videoId) return null;

        return {
            platform: 'YouTube',
            embedUrl: 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&modestbranding=1',
            sourceUrl: parsed.toString()
        };
    }

    function resolveFacebook(parsed) {
        if (!parsed) return null;
        const host = parsed.hostname.replace(/^www\./, '');
        if (!(host.includes('facebook.com') || host === 'fb.watch')) {
            return null;
        }

        const sourceUrl = parsed.toString();
        return {
            platform: 'Facebook',
            embedUrl: 'https://www.facebook.com/plugins/video.php?href=' + encodeURIComponent(sourceUrl) + '&show_text=false',
            sourceUrl: sourceUrl
        };
    }

    function resolveInstagram(parsed) {
        if (!parsed) return null;
        const host = parsed.hostname.replace(/^www\./, '');
        if (!host.includes('instagram.com')) {
            return null;
        }

        const parts = parsed.pathname.split('/').filter(Boolean);
        if (parts.length < 2) return null;
        const type = parts[0];
        const shortcode = sanitizeId(parts[1]);

        if (!shortcode || !['p', 'reel', 'tv'].includes(type)) {
            return null;
        }

        const sourceUrl = 'https://www.instagram.com/' + type + '/' + shortcode + '/';
        return {
            platform: 'Instagram',
            embedUrl: sourceUrl + 'embed/',
            sourceUrl: sourceUrl
        };
    }

    function resolveTikTok(parsed) {
        if (!parsed) return null;
        const host = parsed.hostname.replace(/^www\./, '');
        if (!host.includes('tiktok.com')) {
            return null;
        }

        const parts = parsed.pathname.split('/').filter(Boolean);
        let videoId = '';

        const videoIndex = parts.indexOf('video');
        if (videoIndex >= 0 && parts[videoIndex + 1]) {
            videoId = sanitizeId(parts[videoIndex + 1]);
        } else if (parts[0] === 'v' && parts[1]) {
            videoId = sanitizeId(parts[1]);
        }

        if (!videoId) return null;

        return {
            platform: 'TikTok',
            embedUrl: 'https://www.tiktok.com/embed/v2/' + videoId,
            sourceUrl: parsed.toString()
        };
    }

    function resolveEmbed(rawValue) {
        const value = (rawValue || '').trim();
        if (!value) return null;

        const parsed = safeParseUrl(value);

        return (
            resolveYouTube(value, parsed) ||
            resolveFacebook(parsed) ||
            resolveInstagram(parsed) ||
            resolveTikTok(parsed)
        );
    }

    function hideLive() {
        frame.src = '';
        embed.classList.remove('is-active');
        openLink.style.display = 'none';
        openLink.removeAttribute('href');
    }

    function renderLive(urlValue) {
        const embedData = resolveEmbed(urlValue);

        if (!embedData) {
            hideLive();
            message.textContent = 'No pude leer ese enlace. Usa un link valido de YouTube, Facebook, Instagram o TikTok.';
            return;
        }

        frame.src = embedData.embedUrl;
        embed.classList.add('is-active');
        message.textContent = 'Transmision cargada desde ' + embedData.platform + '.';
        openLink.href = embedData.sourceUrl;
        openLink.style.display = 'inline-flex';
    }

    const persistedUrl = @json(old('live_url', $liveStream->live_url ?? ''));
    if (input && !input.value && persistedUrl) {
        input.value = persistedUrl;
    }

    if (persistedUrl) {
        renderLive(persistedUrl);
    } else {
        hideLive();
        message.textContent = 'Aun no hay transmision en vivo disponible para este partido.';
    }
});
</script>
@endpush
