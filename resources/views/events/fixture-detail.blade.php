@extends('layouts.app')

@section('title', 'Detalle del Partido | ' . $event->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/views/events/fixture-detail.css') }}">
@endpush

@section('content')
@php
    $homeBadge = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $match['home']), 0, 3)) ?: 'AAA';
    $awayBadge = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $match['away']), 0, 3)) ?: 'BBB';
    $tecnicoLocalPath = $fixtureTecnico->local_image_path ?? $fixtureTecnico->image_path ?? null;
    $tecnicoVisitantePath = $fixtureTecnico->visitante_image_path ?? null;
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
        </section>

        <section class="fixture-card fixture-card-actions">
            <div class="actions">
                <div class="actions-col">
                    <a href="{{ route('events.show', $event->id) }}" class="btn-back">
                        <i class="bi bi-arrow-left-circle"></i>
                        Volver al centro de competicion
                    </a>
                </div>

                <div class="live-panel" data-live-panel data-live-url="{{ old('live_url', $liveStream->live_url ?? '') }}">
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
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/views/events/fixture-detail.js') }}"></script>
@endpush

