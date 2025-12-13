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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- Estilos adicionales --}}
    <style>
        .ad-box {
            background: #f5f7fb;
            border: 1px dashed #cbd3e3;
            border-radius: 10px;
            padding: 16px;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 0.9rem;
            color: #555;
        }

        /* Estilos para los sponsors del sidebar */
        .sponsors-sidebar-title {
            font-weight: 600;
            letter-spacing: .03em;
        }

        .sponsor-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff, #eef4ff);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .sponsor-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
        }

        .sponsor-logo-wrapper {
            background: radial-gradient(circle at top, #0d6efd18, #f8fafc);
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sponsor-logo {
            max-height: 90px;
            width: 100%;
            object-fit: contain;
        }

        .sponsor-name {
            font-size: .95rem;
            font-weight: 600;
            margin-bottom: .2rem;
        }

        .sponsor-badge {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 px-4">
        <div class="container-fluid">
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="90" height="60" class="me-2">
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
                        <a class="nav-link" href="{{ route('about') }}">Acerca de</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('events.index') }}">Eventos</a>
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

    {{-- SLIDER --}}
    <div id="principalSlider" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sponsors as $index => $sponsor)
                <button type="button"
                        data-bs-target="#principalSlider"
                        data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">

            @forelse($sponsors as $index => $sponsor)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img
                        src="{{ asset('storage/'.$sponsor->logo) }}"
                        class="d-block w-100"
                        alt="{{ $sponsor->nombre }}"
                        style="height: 420px; object-fit: contain; background: #000;">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="fw-bold">{{ $sponsor->nombre }}</h5>
                        @if($sponsor->url)
                            <p>
                                <a href="{{ $sponsor->url }}" target="_blank" class="btn btn-sm btn-light">
                                    Visitar sitio
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            @empty
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
            @endforelse

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#principalSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#principalSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- LISTA DE EVENTOS + SIDEBAR DE PATROCINADORES --}}
    <div class="container my-5">
        <div class="row">
            {{-- COLUMNA PRINCIPAL: EVENTOS --}}
            <div class="col-lg-9">
                <h1 class="mb-4">
                    Eventos
                    @if(!empty($category))
                        - {{ ucfirst($category) }}
                    @endif
                </h1>

                <div class="mb-4">
                    <!-- filtros rápidos -->
                    <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm">Todos</a>
                    <a href="{{ route('events.index', ['category' => 'hombres']) }}" class="btn btn-outline-secondary btn-sm">Hombres</a>
                    <a href="{{ route('events.index', ['category' => 'mujeres']) }}" class="btn btn-outline-secondary btn-sm">Mujeres</a>
                </div>

                <div class="row g-4">
                    @forelse($events as $event)
                        <div class="col-md-6 col-lg-4">
                            @include('partials.event-card', ['event' => $event])
                        </div>
                    @empty
                        <p>No hay eventos.</p>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $events->withQueryString()->links() }}
                </div>
            </div>

            {{-- COLUMNA DERECHA: PUBLICIDAD / PATROCINIOS --}}
            <div class="col-lg-3">

                {{-- BLOQUE DE PATROCINADORES DINÁMICOS --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="mb-0 sponsors-sidebar-title">Patrocinadores</h4>
                        <a href="{{ route('sponsors.create') }}" class="btn btn-primary btn-sm" title="Agregar patrocinador">
                            +
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success py-1 px-2 mb-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($sponsors as $sponsor)
                        <div class="sponsor-card mb-3">
                            @if($sponsor->logo)
                                <div class="sponsor-logo-wrapper">
                                    <img
                                        src="{{ asset('storage/'.$sponsor->logo) }}"
                                        class="sponsor-logo"
                                        alt="{{ $sponsor->nombre }}">
                                </div>
                            @else
                                <div class="sponsor-logo-wrapper">
                                    <span class="text-muted">Sin imagen</span>
                                </div>
                            @endif

                            <div class="card-body py-2 px-3">
                                <span class="badge bg-light text-secondary sponsor-badge mb-1">
                                    Sponsor oficial
                                </span>
                                <div class="sponsor-name text-truncate">
                                    {{ $sponsor->nombre }}
                                </div>

                                @if($sponsor->url)
                                    <a href="{{ $sponsor->url }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary w-100 mt-2">
                                        Ver sitio
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No hay patrocinadores registrados.</p>
                    @endforelse

                    {{-- enlace para ver todos los patrocinadores --}}
                    <div class="text-end mt-2">
                        <a href="{{ route('sponsors.index') }}" class="btn btn-link btn-sm">
                            Ver todos los patrocinadores
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('CSS/password-modal.css') }}">
</body>
</html>
