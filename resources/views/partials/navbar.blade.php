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
                        <a class="nav-link" href="{{ route('canchas.show') }}">Convenio</a>
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