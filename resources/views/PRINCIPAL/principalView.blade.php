<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportFlow</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tu CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('/principal.css') }}">
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
                        <a class="nav-link" href="#">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contactanos</a>
                    </li>
                </ul>

                {{-- Botón de login --}}
               <a href="{{ route('login') }}" class="btn btn-success">Ingresar</a>
            </div>
        </div>
    </nav>

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

</body>
</html>
