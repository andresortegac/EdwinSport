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

