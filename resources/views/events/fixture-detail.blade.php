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
}
</style>
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
