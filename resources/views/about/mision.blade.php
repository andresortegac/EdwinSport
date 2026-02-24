<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mision | Edwin Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/about.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/about-detail.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>
<body class="about-page">
    @include('partials.navbar')

    <main class="detail-wrap py-5">
        <div class="container">
            <div class="detail-header mb-4">
                <span class="detail-pill">MISION</span>
                <h1>Desarrollar una gestion deportiva moderna, cercana y sostenible.</h1>
                <p>En Edwin Sport trabajamos para que clubes, ligas y escuelas organicen su operacion con procesos digitales claros, impulsando participacion, rendimiento y comunidad.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <article class="detail-card h-100">
                        <h3>Lo que nos mueve</h3>
                        <p>Facilitar cada etapa de la actividad deportiva desde la planificacion de torneos hasta la administracion de canchas y participantes, garantizando experiencias ordenadas y de calidad para todos los actores.</p>
                        <p>Promovemos una cultura basada en juego limpio, inclusion, formacion y crecimiento de talento, apoyando a organizaciones que buscan elevar su impacto en la comunidad.</p>
                    </article>
                </div>
                <div class="col-lg-5">
                    <article class="detail-card h-100">
                        <h3>Objetivos de la mision</h3>
                        <ul class="detail-list mb-0">
                            <li><i class="bi bi-check2-circle"></i> Centralizar informacion de eventos y competiciones.</li>
                            <li><i class="bi bi-check2-circle"></i> Reducir carga operativa con procesos simples.</li>
                            <li><i class="bi bi-check2-circle"></i> Fortalecer la experiencia de deportistas y equipos.</li>
                            <li><i class="bi bi-check2-circle"></i> Impulsar decisiones basadas en datos reales.</li>
                        </ul>
                    </article>
                </div>
            </div>

            <div class="cta-mini mt-4">
                <a href="{{ route('about') }}" class="btn btn-outline-brand">Volver a Acerca de</a>
                <a href="{{ route('about.vision') }}" class="btn btn-brand">Ver Vision</a>
            </div>
        </div>
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


