<nav id="menu-principal-top" class="navbar navbar-expand-lg nav-glass py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('principal') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Edwin Sport" width="52" height="52">
            <span class="brand-text">Edwin Sport</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('principal') || request()->routeIs('panel_principal') ? 'active' : '' }}"
                        href="{{ route('principal') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about*') ? 'active' : '' }}"
                        href="{{ route('about') }}">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('events.*') || request()->routeIs('crear-evento.*') || request()->routeIs('competicion*') ? 'active' : '' }}"
                        href="{{ route('events.index') }}">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('canchas.*') || request()->routeIs('user_reservas.*') || request()->routeIs('reservas.*') ? 'active' : '' }}"
                        href="{{ route('canchas.index') }}">Convenios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contactenos*') || request()->routeIs('contactos.*') ? 'active' : '' }}"
                        href="{{ route('contactenos') }}">Contactanos</a>
                </li>
            </ul>

            <a href="{{ url('login') }}" class="btn btn-brand">Ingresar</a>
        </div>
    </div>
</nav>
