<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vision | Edwin Sport</title>
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
                <span class="detail-pill">VISION</span>
                <h1>Ser la plataforma referente en transformacion digital del deporte regional.</h1>
                <p>Aspiramos a liderar la gestion deportiva con tecnologia confiable, innovacion constante y una experiencia sobresaliente para organizaciones y deportistas.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <article class="detail-card h-100">
                        <h3>Hacia donde vamos</h3>
                        <p>Queremos que cada organizacion deportiva tenga acceso a herramientas profesionales para operar con mayor agilidad, transparencia y capacidad de crecimiento.</p>
                        <p>Nuestra vision integra impacto social y excelencia operativa: mas personas activas, mas oportunidades para talentos emergentes y una cultura deportiva sostenible en el tiempo.</p>
                    </article>
                </div>
                <div class="col-lg-5">
                    <article class="detail-card h-100">
                        <h3>Metas estrategicas</h3>
                        <ul class="detail-list mb-0">
                            <li><i class="bi bi-check2-circle"></i> Expandir cobertura en ligas y escuelas aliadas.</li>
                            <li><i class="bi bi-check2-circle"></i> Integrar analitica para mejorar rendimiento.</li>
                            <li><i class="bi bi-check2-circle"></i> Consolidar estandares de calidad en cada torneo.</li>
                            <li><i class="bi bi-check2-circle"></i> Fortalecer ecosistema deportivo local y regional.</li>
                        </ul>
                    </article>
                </div>
            </div>

            <div class="cta-mini mt-4">
                <a href="{{ route('about') }}" class="btn btn-outline-brand">Volver a Acerca de</a>
                <a href="{{ route('about.valores') }}" class="btn btn-brand">Ver Valores</a>
            </div>
        </div>
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


