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
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Public+Sans:wght@400;500;600;700&display=swap');

:root {
    --comp-bg-1: #f3fbf8;
    --comp-bg-2: #edf2ff;
    --comp-surface: #ffffff;
    --comp-border: #d7e8e1;
    --comp-ink: #102f2b;
    --comp-muted: #5d7670;
    --comp-brand: #0f9d7a;
    --comp-brand-deep: #0b735a;
    --comp-accent: #f1bd58;
    --comp-danger: #dc4e4e;
    --comp-shadow: 0 24px 55px rgba(8, 42, 44, 0.12);
}

.comp-page {
    position: relative;
    min-height: 72vh;
    padding: 24px 0 56px;
    background: linear-gradient(130deg, var(--comp-bg-1), var(--comp-bg-2));
    overflow: hidden;
}

.comp-page::before,
.comp-page::after {
    content: "";
    position: absolute;
    border-radius: 999px;
    z-index: 0;
    opacity: 0.28;
}

.comp-page::before {
    width: 380px;
    height: 380px;
    background: radial-gradient(circle, #a6f0de 0%, rgba(166, 240, 222, 0) 70%);
    top: -120px;
    right: -90px;
}

.comp-page::after {
    width: 320px;
    height: 320px;
    background: radial-gradient(circle, #c6cffd 0%, rgba(198, 207, 253, 0) 72%);
    bottom: -120px;
    left: -80px;
}

.comp-shell {
    position: relative;
    z-index: 1;
}

.comp-topbar {
    display: flex;
    align-items: center;
    margin-bottom: 14px;
}

.btn-back-modern {
    border: 1px solid #cfe5de;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.92);
    color: #1a4d43;
    font: 700 0.86rem/1 "Public Sans", sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    text-decoration: none;
    transition: transform .2s ease, background .2s ease, border-color .2s ease;
}

.btn-back-modern:hover {
    transform: translateY(-1px);
    background: #f3fbf8;
    border-color: #b8dcd0;
    color: #15443b;
}

.comp-hero,
.comp-panel,
.comp-alert,
.group-card {
    border-radius: 22px;
    border: 1px solid var(--comp-border);
    background: var(--comp-surface);
    box-shadow: var(--comp-shadow);
}

.comp-hero {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 20px;
    padding: 30px;
    margin-bottom: 20px;
}

.comp-overline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 10px;
    font: 700 0.75rem/1 "Public Sans", sans-serif;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--comp-brand-deep);
}

.comp-hero h1 {
    margin: 0;
    font-family: "Sora", sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.35rem);
    font-weight: 800;
    color: var(--comp-ink);
    letter-spacing: -0.015em;
}

.comp-hero p {
    margin: 12px 0 0;
    color: var(--comp-muted);
    font: 500 0.98rem/1.65 "Public Sans", sans-serif;
    max-width: 62ch;
}

.comp-metrics {
    display: grid;
    gap: 12px;
}

.metric-card {
    border-radius: 16px;
    border: 1px solid #d8ebe3;
    background: linear-gradient(145deg, #ffffff, #f5fbf8);
    padding: 14px 16px;
}

.metric-card span {
    display: block;
    color: var(--comp-muted);
    font: 600 0.8rem/1 "Public Sans", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 8px;
}

.metric-card strong {
    color: var(--comp-ink);
    font: 800 1.25rem/1.2 "Sora", sans-serif;
}

.comp-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    padding: 12px 14px;
    color: #0f2f2b;
    font: 600 0.94rem/1.45 "Public Sans", sans-serif;
}

.comp-alert i {
    font-size: 1.08rem;
}

.comp-alert-success {
    border-color: #c7e7dc;
    background: #ecfaf4;
}

.comp-alert-error {
    border-color: #f3cdcd;
    background: #fff3f3;
}

.comp-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 18px;
}

.comp-panel {
    padding: 22px;
    margin-bottom: 18px;
}

.panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
}

.panel-head h2 {
    margin: 0;
    color: var(--comp-ink);
    font: 800 1.15rem/1.2 "Sora", sans-serif;
    letter-spacing: -0.01em;
}

.panel-chip {
    border-radius: 999px;
    border: 1px solid #cfe5de;
    background: #f3fbf8;
    color: var(--comp-brand-deep);
    font: 700 0.78rem/1 "Public Sans", sans-serif;
    padding: 6px 10px;
}

.team-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid;
    gap: 10px;
}

.team-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #e2ece8;
    border-radius: 14px;
    background: #fdfefe;
    padding: 10px 12px;
    animation: fadeSlide 0.45s ease both;
    animation-delay: calc(var(--i) * 55ms);
}

.team-index {
    width: 30px;
    height: 30px;
    border-radius: 10px;
    background: #dff4ec;
    color: var(--comp-brand-deep);
    display: grid;
    place-items: center;
    font: 700 0.8rem/1 "Sora", sans-serif;
}

.team-name {
    color: #173a34;
    font: 600 0.94rem/1.3 "Public Sans", sans-serif;
}

.state-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 14px;
}

.state-row span:first-child {
    color: var(--comp-muted);
    font: 600 0.88rem/1 "Public Sans", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.status-pill {
    border-radius: 999px;
    padding: 7px 11px;
    font: 700 0.78rem/1 "Public Sans", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
    border: 1px solid transparent;
}

.status-neutral {
    color: #4f6070;
    background: #edf2f8;
    border-color: #d5deea;
}

.status-pending {
    color: #8b6108;
    background: #fff6df;
    border-color: #f1d896;
}

.status-ok {
    color: #0f684f;
    background: #e7f8f1;
    border-color: #bfebda;
}

.panel-note {
    margin: 0 0 16px;
    color: var(--comp-muted);
    font: 500 0.94rem/1.6 "Public Sans", sans-serif;
}

.btn-primary-modern {
    border: 0;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--comp-brand), var(--comp-brand-deep));
    color: #ffffff;
    font: 700 0.9rem/1 "Public Sans", sans-serif;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
    box-shadow: 0 10px 22px rgba(11, 115, 90, 0.25);
}

.btn-primary-modern:hover {
    transform: translateY(-1px);
    filter: brightness(1.04);
}

.btn-primary-modern:active {
    transform: translateY(0);
}

.state-done {
    border-radius: 12px;
    border: 1px solid #cee9df;
    background: #f1fbf7;
    padding: 12px;
    color: #265c4f;
    font: 600 0.88rem/1.45 "Public Sans", sans-serif;
}

.empty-panel {
    border-radius: 14px;
    border: 1px dashed #cde3db;
    background: #f8fcfb;
    color: #4f6b64;
    padding: 14px;
    margin: 0;
    font: 600 0.9rem/1.45 "Public Sans", sans-serif;
}

.groups-header {
    display: flex;
    align-items: end;
    justify-content: space-between;
    gap: 10px;
    margin: 8px 0 12px;
}

.groups-header h2 {
    margin: 0;
    font: 800 1.25rem/1.2 "Sora", sans-serif;
    color: var(--comp-ink);
}

.groups-header p {
    margin: 0;
    color: var(--comp-muted);
    font: 600 0.88rem/1.2 "Public Sans", sans-serif;
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 14px;
}

.group-card {
    padding: 16px;
}

.group-card header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
}

.group-card h3 {
    margin: 0;
    color: var(--comp-ink);
    font: 800 1.03rem/1.2 "Sora", sans-serif;
}

.group-card header span {
    border-radius: 999px;
    border: 1px solid #d8ebe3;
    background: #f5fbf8;
    color: var(--comp-brand-deep);
    font: 700 0.74rem/1 "Public Sans", sans-serif;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 6px 8px;
}

.group-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid;
    gap: 8px;
}

.group-list li {
    border: 1px solid #e4ece9;
    border-radius: 10px;
    background: #ffffff;
    color: #2d4a44;
    font: 600 0.88rem/1.3 "Public Sans", sans-serif;
    padding: 8px 10px;
}

.results-wrap {
    margin-top: 18px;
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 14px;
}

.results-card {
    border-radius: 18px;
    border: 1px solid #d8ebe3;
    background: #ffffff;
    box-shadow: var(--comp-shadow);
    padding: 15px;
}

.results-card h3 {
    margin: 0 0 10px;
    color: var(--comp-ink);
    font: 800 1rem/1.2 "Sora", sans-serif;
}

.results-table-wrap {
    overflow-x: auto;
}

.results-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid #dceae5;
    border-radius: 12px;
    overflow: hidden;
}

.results-table th,
.results-table td {
    border-bottom: 1px solid #e6efeb;
    padding: 8px 8px;
    color: #23423c;
    font: 600 0.78rem/1.3 "Public Sans", sans-serif;
    white-space: nowrap;
    vertical-align: middle;
}

.results-table th {
    color: #1d3f38;
    background: #f1faf6;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .04em;
    font-size: 0.7rem;
}

.results-table tbody tr:last-child td {
    border-bottom: 0;
}

.results-table tbody tr:hover td {
    background: #f8fcfa;
}

.score-form {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.score-input {
    width: 48px;
    border: 1px solid #c8ddd5;
    border-radius: 8px;
    padding: 4px 5px;
    color: #173530;
    font: 700 0.78rem/1 "Public Sans", sans-serif;
    background: #ffffff;
}

.score-sep {
    color: #355d54;
    font: 800 0.78rem/1 "Sora", sans-serif;
}

.btn-score {
    border: 0;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--comp-brand), var(--comp-brand-deep));
    color: #ffffff;
    font: 700 0.74rem/1 "Public Sans", sans-serif;
    padding: 7px 9px;
}

.result-chip {
    border-radius: 999px;
    border: 1px solid #cfe5de;
    background: #effaf6;
    color: #0b735a;
    font: 700 0.68rem/1 "Public Sans", sans-serif;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 5px 7px;
}

.standings-title {
    margin: 12px 0 8px;
    color: #254a43;
    font: 700 0.82rem/1.2 "Public Sans", sans-serif;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.playoff-wrap {
    margin-top: 20px;
}

.playoff-panel {
    border-radius: 22px;
    border: 1px solid var(--comp-border);
    background: var(--comp-surface);
    box-shadow: var(--comp-shadow);
    padding: 20px;
}

.playoff-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 14px;
}

.playoff-head h2 {
    margin: 0;
    color: var(--comp-ink);
    font: 800 1.2rem/1.2 "Sora", sans-serif;
}

.playoff-head span {
    border-radius: 999px;
    border: 1px solid #cfe5de;
    background: #f3fbf8;
    color: var(--comp-brand-deep);
    font: 700 0.78rem/1 "Public Sans", sans-serif;
    padding: 7px 10px;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.playoff-board {
    border-radius: 20px;
    border: 1px solid rgba(177, 199, 242, 0.42);
    background:
        radial-gradient(circle at 20% 18%, rgba(66, 133, 244, 0.28), transparent 38%),
        radial-gradient(circle at 84% 80%, rgba(42, 214, 159, 0.2), transparent 34%),
        linear-gradient(145deg, #0f3d90, #0a2f72);
    padding: 18px;
    overflow-x: auto;
}

.playoff-grid {
    min-width: 980px;
    display: grid;
    grid-template-columns: 1fr 180px 1fr;
    gap: 12px;
    align-items: stretch;
}

.playoff-side {
    display: grid;
    grid-template-columns: repeat(var(--rounds), minmax(150px, 1fr));
    gap: 10px;
}

.playoff-round {
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    gap: 10px;
}

.playoff-round h5 {
    margin: 0 0 8px;
    color: #d9e8ff;
    font: 800 0.78rem/1 "Public Sans", sans-serif;
    letter-spacing: .1em;
    text-transform: uppercase;
    text-align: center;
}

.playoff-match {
    position: relative;
    border-radius: 14px;
    border: 1px solid rgba(195, 215, 255, 0.45);
    background: rgba(5, 18, 47, 0.38);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.05);
    padding: 10px;
}

.playoff-left .playoff-round:not(:last-child) .playoff-match::after {
    content: "";
    position: absolute;
    right: -11px;
    top: 50%;
    width: 11px;
    border-top: 2px solid rgba(230, 238, 255, 0.72);
}

.playoff-right .playoff-round:not(:first-child) .playoff-match::before {
    content: "";
    position: absolute;
    left: -11px;
    top: 50%;
    width: 11px;
    border-top: 2px solid rgba(230, 238, 255, 0.72);
}

.playoff-team {
    display: flex;
    align-items: center;
    gap: 8px;
}

.playoff-team + .playoff-team {
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid rgba(223, 236, 255, 0.3);
}

.playoff-token {
    width: 30px;
    height: 30px;
    border-radius: 999px;
    border: 2px solid #8f5fff;
    background: linear-gradient(145deg, #2e7cd7, #1d3f93);
    color: #ffffff;
    display: grid;
    place-items: center;
    font: 800 0.68rem/1 "Sora", sans-serif;
    flex: 0 0 30px;
}

.playoff-name {
    color: #e8f0ff;
    font: 700 0.79rem/1.2 "Public Sans", sans-serif;
    letter-spacing: .01em;
}

.playoff-team.is-placeholder .playoff-token {
    border-color: #7f95ca;
    background: linear-gradient(145deg, #465a85, #2d3e63);
}

.playoff-team.is-placeholder .playoff-name {
    color: #b8c9e6;
}

.playoff-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.playoff-cup {
    width: 106px;
    height: 106px;
    border-radius: 999px;
    border: 1px solid rgba(236, 219, 160, 0.6);
    background: radial-gradient(circle at 35% 25%, #ffeab6, #e5b64a 60%, #c08a2d);
    display: grid;
    place-items: center;
    box-shadow:
        0 0 0 8px rgba(255, 255, 255, 0.09),
        0 18px 28px rgba(0, 12, 36, 0.35);
}

.playoff-cup i {
    color: #684400;
    font-size: 2.4rem;
}

.playoff-center span {
    color: #e7f0ff;
    font: 800 0.84rem/1 "Public Sans", sans-serif;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.playoff-empty {
    margin: 0;
    border-radius: 14px;
    border: 1px dashed #bfd5ce;
    background: #f8fcfb;
    color: #4e6762;
    font: 600 0.9rem/1.5 "Public Sans", sans-serif;
    padding: 12px 14px;
}

.elim-board {
    border-radius: 18px;
    border: 1px solid rgba(177, 199, 242, 0.42);
    background:
        radial-gradient(circle at 20% 18%, rgba(66, 133, 244, 0.22), transparent 38%),
        radial-gradient(circle at 84% 80%, rgba(42, 214, 159, 0.14), transparent 34%),
        linear-gradient(145deg, #0f3d90, #0a2f72);
    padding: 16px;
    overflow-x: auto;
}

.elim-rounds {
    min-width: 940px;
    display: grid;
    grid-template-columns: repeat(var(--rounds), minmax(220px, 1fr));
    gap: 14px;
}

.elim-round {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.elim-round h5 {
    margin: 0;
    color: #d9e8ff;
    font: 800 0.78rem/1 "Public Sans", sans-serif;
    letter-spacing: .11em;
    text-transform: uppercase;
    text-align: center;
}

.elim-match {
    position: relative;
    border-radius: 14px;
    border: 1px solid rgba(205, 223, 255, 0.45);
    background: rgba(5, 18, 47, 0.38);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.05);
    padding: 10px;
}

.elim-round:not(:last-child) .elim-match::after {
    content: "";
    position: absolute;
    right: -14px;
    top: 50%;
    width: 14px;
    border-top: 2px solid rgba(224, 235, 255, 0.72);
}

.elim-match.is-played::after {
    border-top-color: #4fe4b5;
}

.elim-match-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.elim-match-head span {
    color: #b8cae8;
    font: 700 0.66rem/1 "Public Sans", sans-serif;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.elim-match-head strong {
    color: #ebf3ff;
    font: 800 0.8rem/1 "Sora", sans-serif;
}

.elim-team {
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
    border-radius: 10px;
    border: 1px solid rgba(219, 232, 255, 0.25);
    background: rgba(255, 255, 255, 0.04);
    padding: 7px 8px;
}

.elim-team + .elim-team {
    margin-top: 7px;
}

.elim-team.is-empty {
    opacity: 0.65;
}

.elim-team.is-winner {
    border-color: rgba(93, 238, 183, 0.72);
    background: rgba(79, 228, 181, 0.12);
}

.elim-team.is-winner::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -1px;
    height: 3px;
    width: 0;
    border-radius: 0 0 10px 10px;
    background: linear-gradient(90deg, #28d29d, #6bf0c7);
    animation: winnerLine 1s ease forwards;
}

.elim-token {
    width: 28px;
    height: 28px;
    border-radius: 999px;
    border: 2px solid #8f5fff;
    background: linear-gradient(145deg, #2e7cd7, #1d3f93);
    color: #ffffff;
    display: grid;
    place-items: center;
    font: 800 0.64rem/1 "Sora", sans-serif;
    flex: 0 0 28px;
}

.elim-name {
    color: #e8f0ff;
    font: 700 0.77rem/1.2 "Public Sans", sans-serif;
    letter-spacing: .01em;
}

.elim-form {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    flex-wrap: wrap;
}

.elim-input {
    width: 44px;
    border: 1px solid rgba(216, 230, 255, 0.48);
    border-radius: 7px;
    background: rgba(255, 255, 255, 0.1);
    color: #f2f7ff;
    padding: 4px 5px;
    font: 700 0.75rem/1 "Public Sans", sans-serif;
}

.elim-input::placeholder {
    color: #d5e4fd;
}

.elim-sep {
    color: #e7f0ff;
    font: 800 0.78rem/1 "Sora", sans-serif;
}

.elim-save {
    border: 0;
    border-radius: 8px;
    background: linear-gradient(135deg, #17ba88, #0e8562);
    color: #ffffff;
    font: 700 0.73rem/1 "Public Sans", sans-serif;
    padding: 7px 8px;
}

.elim-auto {
    margin: 8px 0 0;
    color: #b6f4db;
    font: 600 0.72rem/1.3 "Public Sans", sans-serif;
}

@keyframes winnerLine {
    from { width: 0; }
    to { width: 100%; }
}

.fade-up {
    --d: 0ms;
    animation: fadeUp .55s ease both;
    animation-delay: var(--d);
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateX(10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@media (max-width: 992px) {
    .comp-hero,
    .comp-grid {
        grid-template-columns: 1fr;
    }

    .comp-hero {
        padding: 24px;
    }

    .playoff-grid {
        min-width: 860px;
        grid-template-columns: 1fr 150px 1fr;
    }

    .elim-rounds {
        min-width: 820px;
    }
}

@media (max-width: 576px) {
    .comp-page {
        padding-top: 16px;
    }

    .comp-hero,
    .comp-panel,
    .group-card {
        border-radius: 18px;
    }

    .comp-hero h1 {
        font-size: 1.45rem;
    }

    .score-form {
        flex-wrap: wrap;
    }

    .playoff-panel {
        padding: 14px;
    }

    .playoff-board {
        padding: 12px;
    }

    .playoff-grid {
        min-width: 740px;
        grid-template-columns: 1fr 120px 1fr;
    }

    .elim-board {
        padding: 10px;
    }

    .elim-rounds {
        min-width: 680px;
        gap: 10px;
    }

    .playoff-cup {
        width: 78px;
        height: 78px;
    }

    .playoff-cup i {
        font-size: 1.75rem;
    }
}
</style>
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
