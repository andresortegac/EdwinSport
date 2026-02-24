<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valores | Edwin Sport</title>
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
                <span class="detail-pill">VALORES</span>
                <h1>Principios que guian cada decision en Edwin Sport.</h1>
                <p>Nuestro equipo trabaja con una cultura orientada a calidad, integridad y resultados sostenibles para la comunidad deportiva.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <article class="value-card h-100">
                        <i class="bi bi-award"></i>
                        <h3>Excelencia</h3>
                        <p>Buscamos altos estandares en producto, servicio y experiencia de usuario.</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="value-card h-100">
                        <i class="bi bi-lightbulb"></i>
                        <h3>Innovacion</h3>
                        <p>Adoptamos tecnologia y mejoras continuas para resolver problemas reales.</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="value-card h-100">
                        <i class="bi bi-shield-check"></i>
                        <h3>Integridad</h3>
                        <p>Actuamos con transparencia, juego limpio y respeto por las reglas.</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="value-card h-100">
                        <i class="bi bi-people"></i>
                        <h3>Comunidad</h3>
                        <p>Impulsamos inclusion, participacion y bienestar en todos los niveles.</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="value-card h-100">
                        <i class="bi bi-graph-up-arrow"></i>
                        <h3>Impacto</h3>
                        <p>Medimos resultados para generar crecimiento deportivo sostenible.</p>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4">
                    <article class="value-card h-100">
                        <i class="bi bi-heart-pulse"></i>
                        <h3>Bienestar</h3>
                        <p>Priorizamos seguridad, salud y desarrollo integral de los participantes.</p>
                    </article>
                </div>
            </div>

            <div class="cta-mini mt-4">
                <a href="{{ route('about') }}" class="btn btn-outline-brand">Volver a Acerca de</a>
                <a href="{{ route('contactenos') }}" class="btn btn-brand">Contactar equipo</a>
            </div>
        </div>
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


