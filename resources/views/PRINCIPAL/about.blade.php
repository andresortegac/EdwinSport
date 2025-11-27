<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edwin Sport</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('/CSS/principal.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    {{-- NAVBAR (TAL COMO LA PÁGINA PRINCIPAL) --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 px-4">
        <div class="container-fluid">
            
            <div class="logo">
                 <img src="{{ asset('img/logo.png') }}" alt="Logo" width="90" height="60" class="me-2" >
            </div>

            <a class="navbar-brand brand fs-3" href="/">Edwin Sport</a>

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
                        <a class="nav-link" href="{{ route('canchas.index') }}">Convenio</a>
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

    {{-- SECCIÓN PRINCIPAL --}}
    <section class="container py-5">
        <h1 class="text-center fw-bold hero-title mb-4">Acerca de Nosotros</h1>

        <p class="text-center w-75 mx-auto mb-5">
            Somos un equipo apasionado por el deporte y la tecnología. Nuestro objetivo es 
            centralizar toda la información deportiva de tu ciudad: eventos, torneos, escuelas 
            deportivas, rankings y noticias.
        </p>

        <div class="row mt-5 g-4">

           <div class="col-md-4">
                <a href="{{ route('about.mision') }}" class="text-decoration-none text-dark">
                    <div class="p-4 shadow-sm bg-white rounded-3 text-center card-hover">
                        <h3 class="hero-title">Misión</h3>
                        <p class="mt-2">
                            Brindar una plataforma moderna y accesible que conecte deportistas, instituciones y público en general, promoviendo el crecimiento del deporte.
                        </p>
                    </div>
                </a>
            </div>


            <div class="col-md-4">
                <a href="{{ route('about.vision') }}" class="text-decoration-none text-dark">
                    <div class="p-4 shadow-sm bg-white rounded-3 text-center card-hover">
                        <h3 class="hero-title">vision</h3>
                        <p class="mt-2">
                            Convertirnos en el sistema líder de gestión deportiva regional, ofreciendo herramientas digitales de alto impacto.
                        </p>
                    </div>
                </a>
            </div>


            <div class="col-md-4">
                <a href="{{ route('about.valores') }}" class="text-decoration-none text-dark">
                    <div class="p-4 shadow-sm bg-white rounded-3 text-center card-hover">
                        <h3 class="hero-title">valores</h3>
                        <p class="mt-2">
                           Integridad, pasión deportiva, transparencia, innovación y compromiso con la comunidad.
                        </p>
                    </div>
                </a>
            </div>


        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="text-center py-4 text-secondary">
        © 2025 SportFlow — Todos los derechos reservados
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
