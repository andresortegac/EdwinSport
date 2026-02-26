<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos | Edwin Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/events-page.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>
<body class="events-page">
    @include('partials.navbar')

    @php
        $categoryLabels = [
            'futbol' => 'Futbol',
            'futbol_salon' => 'Futbol de salon',
            'baloncesto' => 'Baloncesto',
            'ciclismo' => 'Ciclismo',
            'natacion' => 'Natacion',
            'patinaje' => 'Patinaje',
        ];

        $currentLabel = !empty($category) && isset($categoryLabels[$category])
            ? $categoryLabels[$category]
            : 'Todos los deportes';
    @endphp

    <header class="events-hero py-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <p class="eyebrow mb-3">AGENDA DEPORTIVA</p>
                    <h1>Encuentra y participa en los mejores eventos deportivos.</h1>
                    <p class="hero-copy">Consulta torneos activos, fechas clave, ubicaciones y categorias para planificar tu participacion con tiempo y organizar mejor tu temporada.</p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('events.index') }}" class="btn btn-brand btn-lg">Ver agenda completa</a>
                        <a href="{{ route('contactenos') }}" class="btn btn-outline-brand btn-lg">Solicitar informacion</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-metrics">
                        <h4 class="mb-3">Resumen actual</h4>
                        <div class="metrics-grid">
                            <div>
                                <span>{{ $events->total() }}</span>
                                <p>Eventos disponibles</p>
                            </div>
                            <div>
                                <span>{{ $events->count() }}</span>
                                <p>En esta pagina</p>
                            </div>
                            <div>
                                <span>{{ $currentLabel }}</span>
                                <p>Categoria activa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="container pb-4">
        <div class="filters-box">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="filter-label">Filtrar por categoria:</span>
                <a href="{{ route('events.index') }}" class="filter-chip {{ empty($category) ? 'active' : '' }}">Todos</a>
                @foreach($categoryLabels as $slug => $label)
                    <a href="{{ route('events.index', ['category' => $slug]) }}" class="filter-chip {{ $category === $slug ? 'active' : '' }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container pb-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="events-grid-wrap">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h2 class="section-title mb-0">Listado de eventos</h2>
                        <p class="section-sub mb-0">Mostrando {{ $events->count() }} de {{ $events->total() }}</p>
                    </div>

                    <div class="row g-4">
                        @forelse($events as $event)
                            <div class="col-md-6">
                                @include('partials.event-card', ['event' => $event])
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-box">
                                    <h4>No hay eventos para esta categoria.</h4>
                                    <p>Prueba con otro filtro o vuelve luego para conocer nuevas convocatorias.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4 pagination-wrap">
                        {{ $events->withQueryString()->links() }}
                    </div>
                </div>
            </div>

            <aside class="col-lg-4">
                <div class="side-card mb-4">
                    <h3>Como participar</h3>
                    <ol class="steps-list mb-0">
                        <li>Explora eventos por categoria y fecha.</li>
                        <li>Revisa requisitos, cupos y ubicacion.</li>
                        <li>Confirma tu asistencia o inscripcion.</li>
                    </ol>
                </div>

                <div class="side-card mb-4">
                    <h3>Tipos de eventos</h3>
                    <ul class="info-list mb-0">
                        <li><i class="bi bi-trophy"></i> Torneos competitivos</li>
                        <li><i class="bi bi-people"></i> Festivales comunitarios</li>
                        <li><i class="bi bi-calendar2-week"></i> Ligas por temporada</li>
                        <li><i class="bi bi-award"></i> Escuelas y formacion</li>
                    </ul>
                </div>

                <div class="side-card mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="mb-0">Patrocinadores</h3>
                        <a href="{{ route('sponsors.index') }}" class="mini-link">Ver todos</a>
                    </div>

                    @forelse($sponsors as $sponsor)
                        <article class="sponsor-item">
                            @if($sponsor->logo)
                                <img
                                    src="{{ route('sponsors.media', ['path' => ltrim($sponsor->logo, '/')]) }}"
                                    alt="{{ $sponsor->nombre }}"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.parentElement.insertAdjacentHTML('afterbegin','<div class=&quot;sponsor-placeholder&quot;>Sin logo</div>');"
                                >
                            @else
                                <div class="sponsor-placeholder">Sin logo</div>
                            @endif
                            <div>
                                <h4>{{ $sponsor->nombre }}</h4>
                                @if($sponsor->url)
                                    <a href="{{ $sponsor->url }}" target="_blank" class="mini-link">Visitar sitio</a>
                                @else
                                    <span class="text-muted small">Sitio no disponible</span>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p class="text-muted mb-0">No hay patrocinadores registrados.</p>
                    @endforelse
                </div>

                <div class="side-card highlight">
                    <h3>Organizas un evento?</h3>
                    <p>Publica tu proxima competencia y conecta con mas participantes en tu ciudad.</p>
                    <a href="{{ route('contactenos') }}" class="btn btn-brand w-100">Contactar ahora</a>
                </div>
            </aside>
        </div>
    </section>

    <section class="container pb-5">
        <div class="extra-content">
            <div class="row g-4">
                <div class="col-md-4">
                    <article class="extra-card h-100">
                        <i class="bi bi-clock-history"></i>
                        <h3>Agenda siempre actualizada</h3>
                        <p>Consulta cambios de fecha, horarios y estado de cada evento en tiempo real.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="extra-card h-100">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Ubicaciones verificadas</h3>
                        <p>Encuentra facilmente canchas y escenarios deportivos con informacion clara.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="extra-card h-100">
                        <i class="bi bi-bar-chart"></i>
                        <h3>Mejor experiencia deportiva</h3>
                        <p>Accede a eventos mejor organizados para competir, entrenar y crecer.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


