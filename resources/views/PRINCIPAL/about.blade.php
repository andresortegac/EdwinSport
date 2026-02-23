<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edwin Sport | Acerca de</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/about.css') }}">
</head>
<body class="about-page">
    @include('partials.navbar')

    <header class="about-hero py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <p class="eyebrow mb-3">SOBRE EDWIN SPORT</p>
                    <h1>Impulsamos una nueva forma de gestionar deporte en tu ciudad.</h1>
                    <p class="lead-text">Somos una plataforma que conecta clubes, ligas, escuelas y deportistas para organizar eventos, reservas y competiciones con procesos claros y tecnologia confiable.</p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('events.index') }}" class="btn btn-brand btn-lg">Explorar eventos</a>
                        <a href="{{ route('contactenos') }}" class="btn btn-outline-brand btn-lg">Hablar con el equipo</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about-hero-panel">
                        <h4 class="mb-3">Impacto actual</h4>
                        <ul class="impact-list mb-0">
                            <li><strong>120+</strong> eventos organizados anualmente.</li>
                            <li><strong>45+</strong> escuelas y clubes aliados.</li>
                            <li><strong>3x</strong> mas agilidad en procesos deportivos.</li>
                            <li><strong>98%</strong> satisfaccion de usuarios.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="{{ route('about.mision') }}" class="text-decoration-none">
                        <article class="about-card h-100">
                            <span class="pill">MISION</span>
                            <h3>Conectar y profesionalizar</h3>
                            <p>Facilitamos una gestion moderna que une deportistas, instituciones y comunidad en una sola experiencia digital.</p>
                            <span class="about-link">Ver detalle <i class="bi bi-arrow-right"></i></span>
                        </article>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('about.vision') }}" class="text-decoration-none">
                        <article class="about-card h-100">
                            <span class="pill">VISION</span>
                            <h3>Liderar la transformacion</h3>
                            <p>Buscamos ser la referencia regional en tecnologia deportiva con soluciones escalables y medibles.</p>
                            <span class="about-link">Ver detalle <i class="bi bi-arrow-right"></i></span>
                        </article>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('about.valores') }}" class="text-decoration-none">
                        <article class="about-card h-100">
                            <span class="pill">VALORES</span>
                            <h3>Confianza e innovacion</h3>
                            <p>Trabajamos con integridad, transparencia y enfoque en resultados para el crecimiento de cada organizacion.</p>
                            <span class="about-link">Ver detalle <i class="bi bi-arrow-right"></i></span>
                        </article>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="about-services py-5">
        <div class="container">
            <div class="section-head text-center mb-4">
                <p class="eyebrow">QUE HACEMOS</p>
                <h2>Soluciones para cada actor del ecosistema deportivo</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-box h-100">
                        <i class="bi bi-calendar2-event"></i>
                        <h3>Eventos y torneos</h3>
                        <p>Publicacion, seguimiento y administracion centralizada de toda tu agenda competitiva.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box h-100">
                        <i class="bi bi-grid-3x3-gap"></i>
                        <h3>Reservas y canchas</h3>
                        <p>Control de disponibilidad, horarios y flujo de usuarios con menos trabajo manual.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box h-100">
                        <i class="bi bi-clipboard-data"></i>
                        <h3>Datos y reportes</h3>
                        <p>Rankings, resultados y metricas para tomar decisiones con informacion confiable.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="roadmap-box">
                <div class="section-head mb-4">
                    <p class="eyebrow">METODO DE TRABAJO</p>
                    <h2>Como acompanamos a tu organizacion</h2>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="step-card h-100">
                            <span>01</span>
                            <h4>Diagnostico</h4>
                            <p>Analizamos operacion actual, necesidades y puntos de mejora prioritarios.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card h-100">
                            <span>02</span>
                            <h4>Implementacion</h4>
                            <p>Configuramos modulos, usuarios y flujos para arrancar sin fricciones.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card h-100">
                            <span>03</span>
                            <h4>Escalamiento</h4>
                            <p>Medimos resultados y mejoramos procesos para sostener crecimiento.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-cta py-5">
        <div class="container">
            <div class="cta-box">
                <div>
                    <p class="eyebrow mb-2">LISTOS PARA CRECER CONTIGO</p>
                    <h3 class="mb-0">Lleva tu operacion deportiva a un nivel mas profesional.</h3>
                </div>
                <a href="{{ route('contactenos') }}" class="btn btn-brand btn-lg">Solicitar asesoria</a>
            </div>
        </div>
    </section>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

