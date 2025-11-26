<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportFlow</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tu CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('/CSS/principal.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 px-4">
        <div class="container-fluid">
            <div class="logo">
                 <img src="{{ asset('img/logo.png') }}" alt="Logo" width="90" height="60" class="me-2" >
            </div>
            <a class="navbar-brand brand fs-3" href="#">Edwin Sport</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-3 fs-5">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('about') }}">Acerca de</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('events.index') }}">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contactenos') }}">Contactanos</a>
                    </li>
                </ul>

                {{-- Botón de login --}}
                <a href="{{ url('login') }}" class="btn btn-login">
                    Ingresar
                </a>
            </div>
        </div>
    </nav>

    {{-- SLIDER --}}
<div id="principalSlider" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#principalSlider" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#principalSlider" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#principalSlider" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="{{ asset('img/slider/slider0.png') }}" class="d-block w-100" alt="Slide 1" style="height: 420px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h5 class="fw-bold">Vive la pasión del deporte</h5>
                <p>Conoce los mejores torneos de tu ciudad</p>
            </div>
        </div>

        <div class="carousel-item">
            <img src="{{ asset('img/slider/slider1.png') }}" class="d-block w-100" alt="Slide 2" style="height: 420px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h5 class="fw-bold">Escuelas deportivas certificadas</h5>
                <p>Entrena con los mejores</p>
            </div>
        </div>

        <div class="carousel-item">
            <img src="{{ asset('img/slider/slider2.png') }}" class="d-block w-100" alt="Slide 3" style="height: 420px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h5 class="fw-bold">Resultados y rankings actualizados</h5>
                <p>Todo en un solo lugar</p>
            </div>
        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#principalSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#principalSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>


    {{-- HERO SECTION --}}
    <section class="container text-center hero-section">
        <h1 class="display-4 fw-bold hero-title">
            Tu mundo deportivo en un solo lugar
        </h1>

        <p class="mt-3 fs-5 text-secondary w-75 mx-auto">
            Explora eventos, rankings, escuelas deportivas y toda la actividad de tu ciudad.
        </p>
        <a href="{{ route('about') }}" class="mt-8 px-8 py-4 rounded-2xl bg-[#1DE4D1] text-[#003233] text-lg font-semibold shadow-md hover:opacity-90">
            Explorar ahora
        </a>
    </section>

    {{-- FEATURES --}}
    <section class="container py-5">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="p-4 bg-white shadow feature-card feature-1">
                    <h3 class="fw-bold hero-title">Eventos</h3>
                    <p>Conoce todos los torneos y actividades deportivas disponibles.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white shadow feature-card feature-2">
                    <h3 class="fw-bold hero-title">Escuelas</h3>
                    <p>Encuentra escuelas deportivas certificadas y sus programas.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white shadow feature-card feature-3">
                    <h3 class="fw-bold hero-title">Rankings</h3>
                    <p>Revisa resultados oficiales y posiciones actualizadas.</p>
                </div>
            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="text-center py-10 text-gray-600">
        © 2025 SportFlow — Todos los derechos reservados
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- MODAL DE CONTRASEÑA -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">

                <div class="modal-header">
                    <h5 class="modal-title">Ingrese su contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('login') }}" method="GET"> 
                    <div class="modal-body">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                        <button type="submit" class="btn btn-primary">
                            Entrar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>
