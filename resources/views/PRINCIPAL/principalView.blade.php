<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edwin Sport | Plataforma Deportiva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>
<body>
    @include('partials.navbar')

    <header class="hero-section">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="container position-relative">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <p class="eyebrow mb-3">GESTION DEPORTIVA PROFESIONAL</p>
                    <h1 class="hero-title mb-4">Organiza torneos, reservas y rendimiento en una sola plataforma.</h1>
                    <p class="hero-subtitle mb-4">Centraliza la operacion deportiva de tu comunidad con una experiencia moderna, clara y escalable.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('events.index') }}" class="btn btn-brand btn-lg">Ver eventos</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-brand btn-lg">Conocer mas</a>
                    </div>
                    <div class="stats-grid mt-5">
                        <div class="stat-card">
                            <h3>+120</h3>
                            <p>Eventos gestionados</p>
                        </div>
                        <div class="stat-card">
                            <h3>+45</h3>
                            <p>Escuelas afiliadas</p>
                        </div>
                        <div class="stat-card">
                            <h3>98%</h3>
                            <p>Satisfaccion de usuarios</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel">
                        <h4 class="mb-3">Panel ejecutivo</h4>
                        <ul class="feature-list mb-0">
                            <li><i class="bi bi-check2-circle"></i> Reservas y canchas en tiempo real</li>
                            <li><i class="bi bi-check2-circle"></i> Control de participantes por torneo</li>
                            <li><i class="bi bi-check2-circle"></i> Reportes y rankings centralizados</li>
                            <li><i class="bi bi-check2-circle"></i> Soporte para competiciones y grupos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="sports-carousel-section pb-5">
        <div class="container">
            <div class="carousel-frame">
                <div id="sportsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
                    <div class="carousel-indicators modern-indicators">
                        <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
                        <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="5" aria-label="Slide 6"></button>
                    </div>

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('img/slider/slider0.png') }}" class="d-block w-100" alt="Futbol profesional">
                            <div class="carousel-caption modern-caption">
                                <p class="caption-tag">TORNEOS</p>
                                <h3>Competencia de alto nivel</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/slider/slider1.png') }}" class="d-block w-100" alt="Entrenamiento deportivo">
                            <div class="carousel-caption modern-caption">
                                <p class="caption-tag">FORMACION</p>
                                <h3>Escuelas y rendimiento</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/slider/slider2.png') }}" class="d-block w-100" alt="Deporte en comunidad">
                            <div class="carousel-caption modern-caption">
                                <p class="caption-tag">COMUNIDAD</p>
                                <h3>Deporte para todos</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/cancha.jpg') }}" class="d-block w-100" alt="Cancha deportiva">
                            <div class="carousel-caption modern-caption">
                                <p class="caption-tag">INFRAESTRUCTURA</p>
                                <h3>Canchas listas para jugar</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/estadio-de-futbol-lleno-de-gente.jpg') }}" class="d-block w-100" alt="Estadio lleno">
                            <div class="carousel-caption modern-caption">
                                <p class="caption-tag">EXPERIENCIA</p>
                                <h3>Ambiente de estadio real</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/cancha vertical.jpg') }}" class="d-block w-100" alt="Cancha vertical">
                            <div class="carousel-caption modern-caption">
                                <p class="caption-tag">RESERVAS</p>
                                <h3>Espacios disponibles todo el ano</h3>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev modern-control" type="button" data-bs-target="#sportsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next modern-control" type="button" data-bs-target="#sportsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section py-5">
        <div class="container">
            <div class="section-head text-center mb-5">
                <p class="eyebrow">NUESTRAS CAPACIDADES</p>
                <h2>Soluciones para una operacion deportiva eficiente</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <article class="service-card h-100">
                        <div class="icon-wrap"><i class="bi bi-trophy"></i></div>
                        <h3>Gestion de Eventos</h3>
                        <p>Publica, administra y da seguimiento a torneos con informacion siempre actualizada.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="service-card h-100">
                        <div class="icon-wrap"><i class="bi bi-calendar2-check"></i></div>
                        <h3>Reservas Inteligentes</h3>
                        <p>Organiza horarios, canchas y disponibilidad para optimizar recursos deportivos.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="service-card h-100">
                        <div class="icon-wrap"><i class="bi bi-bar-chart"></i></div>
                        <h3>Rendimiento y Reportes</h3>
                        <p>Consulta tablas, grupos y resultados con una vista profesional para decisiones rapidas.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="benefits-section py-5">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-6">
                    <div class="benefits-card h-100">
                        <p class="eyebrow mb-2">BENEFICIOS CLAVE</p>
                        <h3>Control total en cada ciclo deportivo</h3>
                        <ul class="benefits-list mb-0">
                            <li><i class="bi bi-shield-check"></i> Operacion centralizada para ligas, escuelas y clubes.</li>
                            <li><i class="bi bi-clock-history"></i> Menos tiempos de coordinacion y menos errores manuales.</li>
                            <li><i class="bi bi-people"></i> Mejor experiencia para administradores y deportistas.</li>
                            <li><i class="bi bi-graph-up-arrow"></i> Datos para tomar decisiones de crecimiento.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="benefits-card h-100">
                        <p class="eyebrow mb-2">COMO FUNCIONA</p>
                        <h3>Implementacion en tres pasos</h3>
                        <div class="steps-grid">
                            <div class="step-item">
                                <span>1</span>
                                <p>Configura tus canchas, categorias y calendarios en minutos.</p>
                            </div>
                            <div class="step-item">
                                <span>2</span>
                                <p>Publica eventos y abre inscripciones de forma organizada.</p>
                            </div>
                            <div class="step-item">
                                <span>3</span>
                                <p>Monitorea resultados, grupos y reportes desde tu panel.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials-section py-5">
        <div class="container">
            <div class="section-head text-center mb-4">
                <p class="eyebrow">CONFIANZA DEL SECTOR</p>
                <h2>Lo que dicen nuestros usuarios</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <article class="quote-card h-100">
                        <p>"Mejoramos la planificacion semanal y ahora tenemos trazabilidad completa de reservas."</p>
                        <h4>Coordinador de Liga</h4>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="quote-card h-100">
                        <p>"La gestion de torneos y participantes es mucho mas rapida que con hojas manuales."</p>
                        <h4>Director de Escuela</h4>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="quote-card h-100">
                        <p>"Tenemos una imagen mas profesional frente a patrocinadores y comunidad deportiva."</p>
                        <h4>Administrador de Club</h4>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section py-5">
        <div class="container">
            <div class="cta-box">
                <div>
                    <p class="eyebrow mb-2">TRANSFORMA TU GESTION DEPORTIVA</p>
                    <h3 class="mb-0">Impulsa tu comunidad con una plataforma moderna y confiable.</h3>
                </div>
                <a href="{{ route('contactenos') }}" class="btn btn-brand btn-lg">Solicitar informacion</a>
            </div>
        </div>
    </section>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


