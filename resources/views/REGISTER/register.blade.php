<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Eventos Deportivos</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- FontAwesome (para lupa, campana y sobre) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#070b16;
      --bg-2:#0b1020;
      --bg-3:#0f172a;
      --line:rgba(148,163,184,.14);

      --c1:#22d3ee; /* cyan */
      --c2:#0ea5e9; /* sky */
      --c3:#2563eb; /* blue */
      --c4:#a855f7; /* purple */
      --c5:#f59e0b; /* amber */
      --ok:#22c55e;
      --danger:#ef4444;

      --text:#e2e8f0;
      --muted:#94a3b8;
    }

    body{
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: var(--text);
      background:
        radial-gradient(1000px 700px at 10% -10%, rgba(34,211,238,.18), transparent 60%),
        radial-gradient(900px 600px at 100% 0%, rgba(168,85,247,.18), transparent 55%),
        linear-gradient(180deg, var(--bg), var(--bg-2) 45%, var(--bg-3) 100%);
      min-height: 100vh;
    }

    /* NAVBAR */
    .nav-pro{
      background: rgba(7,11,22,.7);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--line);
    }
    .brand{
      font-family: Oswald, Inter, sans-serif;
      font-weight:600;
      letter-spacing:.8px;
    }
    .brand-badge{
      background: linear-gradient(135deg, rgba(34,211,238,.15), rgba(37,99,235,.15));
      border:1px solid rgba(34,211,238,.45);
      padding:.35rem .7rem;
      border-radius:999px;
      font-size:.8rem;
      font-weight:800;
      color:#e6fbff;
    }

    /* HERO */
    .hero{
      background:
        linear-gradient(135deg, rgba(34,211,238,.14), rgba(37,99,235,.14)),
        linear-gradient(180deg, #0b1020, #0b1430);
      border:1px solid var(--line);
      border-radius: 1.6rem;
      box-shadow: 0 18px 60px rgba(0,0,0,.5);
      position:relative;
      overflow:hidden;
    }
    .hero::after{
      content:"";
      position:absolute;
      right:-180px; top:-260px;
      width:620px; height:620px;
      border-radius:999px;
      background: radial-gradient(circle, rgba(34,211,238,.35), transparent 60%);
      filter: blur(50px);
      opacity:.9;
    }
    .hero-title{
      font-family: Oswald, Inter, sans-serif;
      font-size: clamp(1.9rem, 2.7vw, 2.7rem);
      font-weight:600;
      letter-spacing:.8px;
      color:#fff;
      margin:0;
    }
    .hero-sub{ color:var(--muted); max-width: 65ch; }

    /* CARD BASE */
    .pro-card{
      background: linear-gradient(180deg, rgba(15,23,42,.9), rgba(11,18,38,.95));
      border:1px solid var(--line);
      border-radius: 1.3rem;
      box-shadow: 0 12px 30px rgba(0,0,0,.45);
      backdrop-filter: blur(7px);
    }

    /* STATS */
    .stat{
      position:relative;
      overflow:hidden;
      background: rgba(2,6,23,.55);
      border:1px solid var(--line);
      border-radius: 1.1rem;
    }
    .stat .label{
      font-size:.8rem; letter-spacing:.9px; text-transform:uppercase;
      color:var(--muted); font-weight:800;
    }
    .stat .value{
      font-family: Oswald, Inter, sans-serif;
      font-size:2.1rem; font-weight:600; letter-spacing:.7px;
    }
    .stat .glow{
      position:absolute; width:260px; height:260px; border-radius:999px;
      right:-40%; bottom:-70%;
      filter: blur(35px); opacity:.8;
    }

    /* ACTION CARDS */
    .action{
      position:relative;
      height:100%;
      background: rgba(2,6,23,.6);
      border:1px solid var(--line);
      border-radius: 1.2rem;
      transition: transform .14s ease, border-color .14s ease, box-shadow .14s ease, background .14s ease;
      overflow:hidden;
      cursor:pointer;
    }
    .action::after{
      content:"";
      position:absolute; inset:-40% -20% auto auto;
      width:280px; height:280px; border-radius:999px;
      filter: blur(40px);
      opacity:0; transition:opacity .18s ease;
    }
    .action:hover{
      transform: translateY(-6px);
      border-color: rgba(34,211,238,.6);
      box-shadow:
        0 18px 45px rgba(0,0,0,.55),
        0 0 0 1px rgba(34,211,238,.15),
        0 0 30px rgba(34,211,238,.25);
      background: rgba(34,211,238,.05);
    }
    .action:hover::after{ opacity:1; }

    .icon-box{
      width:60px; height:60px; border-radius:16px;
      display:grid; place-items:center; font-size:1.7rem;
      border:1px solid transparent;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,.04);
    }
    .action h5{
      font-family: Oswald, Inter, sans-serif;
      font-weight:600; letter-spacing:.4px; margin-bottom:.25rem;
    }
    .action p{ color:var(--muted); font-size:.93rem; min-height: 44px; }

    /* Variantes */
    .action.blue .icon-box{
      background: rgba(37,99,235,.18);
      border-color: rgba(37,99,235,.55);
    }
    .action.blue::after{ background: radial-gradient(circle, rgba(37,99,235,.45), transparent 60%); }

    .action.cyan .icon-box{
      background: rgba(34,211,238,.16);
      border-color: rgba(34,211,238,.6);
    }
    .action.cyan::after{ background: radial-gradient(circle, rgba(34,211,238,.55), transparent 60%); }

    .action.green .icon-box{
      background: rgba(34,197,94,.14);
      border-color: rgba(34,197,94,.55);
    }
    .action.green::after{ background: radial-gradient(circle, rgba(34,197,94,.5), transparent 60%); }
    .action.green:hover{
      border-color: rgba(34,197,94,.65);
      box-shadow: 0 18px 45px rgba(0,0,0,.55), 0 0 30px rgba(34,197,94,.25);
    }

    .action.purple .icon-box{
      background: rgba(168,85,247,.14);
      border-color: rgba(168,85,247,.55);
    }
    .action.purple::after{ background: radial-gradient(circle, rgba(168,85,247,.6), transparent 60%); }
    .action.purple:hover{
      border-color: rgba(168,85,247,.7);
      box-shadow: 0 18px 45px rgba(0,0,0,.55), 0 0 30px rgba(168,85,247,.25);
    }

    /* Buttons */
    .btn-brand{
      background: linear-gradient(135deg, var(--c2), var(--c3));
      border:none;color:white;font-weight:800;letter-spacing:.3px;
      border-radius: .95rem; padding:.75rem 1rem;
      box-shadow: 0 10px 24px rgba(14,165,233,.35);
    }
    .btn-brand:hover{ filter: brightness(1.06); }
    .btn-soft{
      border-radius:.95rem;font-weight:700;padding:.7rem 1rem;
      border:1px solid rgba(148,163,184,.35);
      color:var(--text);
      background: transparent;
    }
    .btn-soft:hover{ background:rgba(255,255,255,.05); border-color:#fff; }

    /* ================= TABLA ARREGLADA ================= */
    .table-pro{
      --bs-table-bg: rgba(2,6,23,.75);
      --bs-table-color: var(--text);
      --bs-table-hover-bg: rgba(34,211,238,.10);
      --bs-table-border-color: rgba(148,163,184,.18);
      color: var(--text) !important;
      margin:0;
    }
    .table-pro thead th{
      background: rgba(15,23,42,.98) !important;
      color:#e2e8f0 !important;
      font-weight:800;text-transform:uppercase;font-size:.78rem;letter-spacing:.7px;
      border-bottom:1px solid rgba(148,163,184,.22) !important;
    }
    .table-pro > :not(caption) > * > *{
      background-color: rgba(2,6,23,.75) !important;
      color: var(--text) !important;
      border-color: rgba(148,163,184,.18) !important;
      font-weight:600 !important;
    }
    .table-pro tbody tr:hover > *{
      background-color: rgba(34,211,238,.12) !important;
      color:#fff !important;
    }

    .badge-open{ background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.35); color:#bbf7d0; font-weight:800; }
    .badge-soon{ background:rgba(245,158,11,.12); border:1px solid rgba(245,158,11,.35); color:#fde68a; font-weight:800; }
    .badge-prep{ background:rgba(148,163,184,.12); border:1px solid rgba(148,163,184,.35); color:#e2e8f0; font-weight:800; }

    input::placeholder{ color: #cbd5e1 !important; opacity:.9; }

    .avatar{
      width:96px;height:96px;border-radius:999px;
      border:2px solid rgba(34,211,238,.6);
      box-shadow: 0 15px 40px rgba(0,0,0,.55);
    }

    .divider{ border-color: rgba(148,163,184,.2); }
    .muted{ color:var(--muted); }

    /* ================== SOLO LO QUE PEDISTE ================== */

    /* Buscador topbar */
    .search-pro{
      display:flex;
      align-items:center;
      gap:.5rem;
      width: 100%;
      max-width: 520px;
    }
    .search-pro .form-control{
      background: rgba(255,255,255,.06) !important;
      color: var(--text) !important;
      border:1px solid var(--line) !important;
      border-radius: 999px !important;
      padding: .55rem 1.1rem;
      height: 44px;
    }
    .search-pro .form-control::placeholder{
      color: var(--muted) !important;
    }
    .search-pro .btn-search{
      height: 44px;
      width: 44px;
      border-radius: 999px !important;
      font-weight:800;
      background: linear-gradient(135deg, var(--c2), #1e40af) !important;
      border:none !important;
      color: #fff !important;
      display:grid;
      place-items:center;
      box-shadow: 0 8px 18px rgba(59,130,246,.35);
    }

    /* Iconos para notificaciones/mensajes */
    .top-icon-btn{
      position:relative;
      width:40px;height:40px;border-radius:999px;
      display:grid;place-items:center;
      color:#e5e7eb !important;
      background: rgba(255,255,255,.04);
      border:1px solid var(--line);
      transition:.12s ease;
      text-decoration:none;
    }
    .top-icon-btn:hover{
      background: rgba(255,255,255,.08);
      color:#fff !important;
      transform: translateY(-1px);
    }
    .top-icon-btn .badge-counter{
      position:absolute; top:-6px; right:-6px;
      font-size:.68rem; font-weight:900;
      padding:.25rem .38rem;
      border-radius:999px;
      background:#ef4444;
      color:#fff;
      border:2px solid #0b1020;
      line-height:1;
      min-width: 18px;
      text-align:center;
    }

    /* Dropdown oscuro pro */
    .dropdown-pro{
      background: rgba(8,17,38,.98) !important;
      border:1px solid var(--line) !important;
      color: var(--text) !important;
      border-radius: 1rem;
      min-width: 320px;
      overflow:hidden;
      box-shadow: 0 18px 40px rgba(0,0,0,.6);
    }
    .dropdown-pro .dropdown-header{
      background: rgba(255,255,255,.04);
      color:#fff;font-weight:900;letter-spacing:.5px;
      border-bottom:1px solid var(--line);
      padding:.75rem 1rem;
    }
    .dropdown-pro .dropdown-item{
      color: var(--text) !important;
      white-space: normal;
      padding:.75rem 1rem;
      border-bottom:1px solid var(--line);
    }
    .dropdown-pro .dropdown-item:hover{
      background: rgba(34,211,238,.08);
    }
    .dropdown-pro .small-muted{ color: var(--muted); font-size:.8rem; }

    .icon-circle{
      width:38px;height:38px;border-radius:999px;
      display:grid;place-items:center;
      background: rgba(14,165,233,.18);
      border:1px solid rgba(14,165,233,.45);
      color:#fff;
      flex-shrink:0;
    }

    /* Ventana flotante de perfil */
    .floating-user-panel{
      position: sticky;
      top: 6rem;
      max-height: calc(100vh - 7rem);
      overflow-y: auto;
      z-index: 10;
    }
    .floating-user-panel::-webkit-scrollbar{
      width: 8px;
    }
    .floating-user-panel::-webkit-scrollbar-thumb{
      background: rgba(148,163,184,.35);
      border-radius: 999px;
    }
    @media (max-width: 991.98px){
      .floating-user-panel{
        position: static;
        top: auto;
        max-height: none;
        overflow: visible;
      }
    }
  </style>
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg nav-pro sticky-top">
    <div class="container py-2">
      <a class="navbar-brand text-white d-flex align-items-center gap-3" href="{{ route('principal') }}">
        <div class="brand d-flex align-items-center gap-2">
          <span class="brand-badge"><i class="fas fa-trophy me-1"></i>SPORT EVENTS</span>
          <span class="d-none d-md-inline">PRO</span>
        </div>
      </a>

      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMain">

        <!-- BUSCADOR -->
        <form class="search-pro me-lg-auto my-2 my-lg-0" role="search">
          <input type="text" class="form-control" placeholder="Buscar eventos, participantes...">
          <button class="btn-search" type="button" aria-label="Buscar">
            <i class="fas fa-search"></i>
          </button>
        </form>

        <ul class="navbar-nav ms-auto gap-lg-2 align-items-lg-center">
          <!-- NOTIFICACIONES -->
          <li class="nav-item dropdown ms-lg-2">
            <a class="top-icon-btn dropdown-toggle"
               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-bell"></i>
              <span class="badge-counter">{{ $notificacionesCount ?? 0 }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end dropdown-pro">
              <div class="dropdown-header">Notificaciones</div>

              @forelse($notificaciones ?? [] as $n)
                <a class="dropdown-item d-flex align-items-start gap-2" href="{{ $n['url'] ?? '#' }}">
                  <div class="icon-circle">
                    <i class="{{ $n['icon'] ?? 'fas fa-info' }}"></i>
                  </div>
                  <div>
                    <div class="small-muted">{{ $n['fecha'] ?? '' }}</div>
                    <div class="fw-bold">{{ $n['texto'] ?? 'Notificacion nueva' }}</div>
                  </div>
                </a>
              @empty
                <div class="dropdown-item text-center small-muted py-3">
                  No tienes notificaciones
                </div>
              @endforelse

              <a class="dropdown-item text-center small-muted" href="#">
                Ver todas
              </a>
            </div>
          </li>

          <!-- MENSAJES -->
          <li class="nav-item dropdown ms-lg-2">
            <a class="top-icon-btn dropdown-toggle"
               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-envelope"></i>
              <span class="badge-counter">{{ $mensajesCount ?? 0 }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end dropdown-pro">
              <div class="dropdown-header">Mensajes</div>

              @forelse($mensajes ?? [] as $m)
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ $m['url'] ?? '#' }}">
                  <img class="rounded-circle"
                       src="{{ $m['avatar'] ?? asset('img/undraw_profile.svg') }}"
                       style="width:42px;height:42px;object-fit:cover;">
                  <div class="flex-grow-1">
                    <div class="fw-bold text-truncate">{{ $m['texto'] ?? 'Mensaje nuevo' }}</div>
                    <div class="small-muted">
                      {{ $m['nombre'] ?? 'Usuario' }} &middot; {{ $m['fecha'] ?? '' }}
                    </div>
                  </div>
                </a>
              @empty
                <div class="dropdown-item text-center small-muted py-3">
                  No tienes mensajes
                </div>
              @endforelse

              <a class="dropdown-item text-center small-muted" href="#">
                Ver todos
              </a>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-4 py-lg-5">

    <!-- Hero -->
    <section class="hero p-4 p-md-5 mb-4">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
          <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-2"
               style="background:rgba(34,211,238,.08);border:1px solid rgba(34,211,238,.35);font-weight:800;">
            <i class="fas fa-landmark me-1"></i>Panel del Organizador
          </div>
          <h1 class="hero-title">Registro de Eventos Deportivos</h1>
          <p class="hero-sub mt-2">
            Gestiona torneos, inscripciones y administracion con estilo profesional.
          </p>
        </div>

        <div class="text-md-end">
          <div class="muted small">Estado</div>
          <div class="fw-bold text-light">Operativo</div>
          <div class="muted small mt-2">Hoy</div>
          <div class="small text-light">
            {{ now()->timezone('America/Bogota')->locale('es')->translatedFormat('d M Y, H:i') }}
          </div>
        </div>
      </div>
    </section>

    <!-- Stats -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="stat pro-card p-3 p-md-4">
          <div class="glow" style="background:radial-gradient(circle, rgba(37,99,235,.45), transparent 60%);"></div>
          <div class="label mb-1">Eventos activos</div>
          <div class="value">12</div>
          <div class="fw-bold text-success small">+3 esta semana</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat pro-card p-3 p-md-4">
          <div class="glow" style="background:radial-gradient(circle, rgba(34,197,94,.45), transparent 60%);"></div>
          <div class="label mb-1">Inscripciones</div>
          <div class="value">1,284</div>
          <div class="fw-bold small" style="color:#bbf7d0;">+11% vs mes anterior</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat pro-card p-3 p-md-4">
          <div class="glow" style="background:radial-gradient(circle, rgba(168,85,247,.5), transparent 60%);"></div>
          <div class="label mb-1">Proximos torneos</div>
          <div class="value">5</div>
          <div class="fw-bold small" style="color:#e9d5ff;">2 confirmados</div>
        </div>
      </div>
    </div>

    <div class="row g-4">

      <!-- Main -->
      <div class="col-lg-8">
        <div class="pro-card p-4 p-md-5">

          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h3 class="mb-1" style="font-family:Oswald;"><i class="fas fa-hand-sparkles me-1"></i>Bienvenido</h3>
              <p class="muted mb-0">Acciones rapidas para operar tu sistema.</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="row g-3 mt-3">

            <div class="col-md-4">
              <div class="action cyan p-3">
                <div class="icon-box mb-3"><i class="fas fa-landmark"></i></div>
                <h5>Crear evento</h5>
                <p>Registra competencias con calendario, sede y categorias.</p>

                <!-- CAMBIO AQUI: ahora si te lleva a tu vista nueva -->
                <a href="{{ route('events.crear-evento-developer') }}" class="btn btn-brand w-100">
                  Nuevo evento
                </a>
              </div>
            </div>

            <div class="col-md-4">
              <div class="action blue p-3">
                <div class="icon-box mb-3"><i class="fas fa-calendar-alt"></i></div>
                <h5>Calendario</h5>
                <p>Visualiza agenda y estado de inscripciones por fecha.</p>
                <a href="{{ route('events.index') }}" class="btn btn-soft w-100">Ver eventos</a>
              </div>
            </div>

            <div class="col-md-4">
              <div class="action green p-3">
                <div class="icon-box mb-3"><i class="fas fa-users"></i></div>
                <h5>Participantes</h5>
                <p>Administra equipos, atletas, edades y divisiones.</p>

                <a href="{{ route('participantes.index') }}" class="btn btn-soft w-100"
                   style="border-color:rgba(34,197,94,.6);color:#bbf7d0;">
                  Gestionar
                </a>
              </div>
            </div>

            <div class="col-md-4">
              <div class="action purple p-3">
                <div class="icon-box mb-3"><i class="fas fa-user-shield"></i></div>
                <h5>Usuarios admin</h5>
                <p>Crea personal autorizado para operar el sistema contigo.</p>
                <a href="{{ route('crear_usuario') }}" class="btn btn-soft w-100"
                   style="border-color:rgba(168,85,247,.65);color:#e9d5ff;">
                  Nuevo usuario
                </a>
              </div>
            </div>
            <div class="col-md-4">
              <div class="action cyan p-3">
                <div class="icon-box mb-3">🏟️</div>
                <h5>Agregar canchas</h5>
                <p>Crea nuevas canchas y define cuantas internas maneja cada sede.</p>
                <button type="button" class="btn btn-brand w-100"
                        data-bs-toggle="collapse" data-bs-target="#formNuevaCancha"
                        aria-expanded="false" aria-controls="formNuevaCancha">
                  Nueva cancha
                </button>
              </div>
            </div>
          </div>


          <div class="collapse mt-4 {{ $errors->any() || session('success') ? 'show' : '' }}" id="formNuevaCancha">
            <div class="pro-card p-4">
              <h4 class="mb-3" style="font-family:Oswald;">Nueva cancha</h4>

              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form action="{{ route('canchas.store') }}" method="POST" class="row g-3">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ route('register') }}">

                <div class="col-md-6">
                  <label class="form-label">Nombre de la cancha</label>
                  <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Numero de canchas internas</label>
                  <select name="num_canchas" class="form-select" required>
                    @for ($i = 1; $i <= 4; $i++)
                      <option value="{{ $i }}" {{ old('num_canchas',1)==$i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </div>

                <div class="col-12">
                  <label class="form-label">Descripcion</label>
                  <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion') }}</textarea>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Ubicacion</label>
                  <input type="text" name="ubicacion" class="form-control" value="{{ old('ubicacion') }}" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Telefono de contacto</label>
                  <input type="text" name="telefono_contacto" class="form-control" value="{{ old('telefono_contacto') }}" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Hora apertura</label>
                  <input type="time" name="hora_apertura" class="form-control" value="{{ old('hora_apertura') }}" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Hora cierre</label>
                  <input type="time" name="hora_cierre" class="form-control" value="{{ old('hora_cierre') }}" required>
                </div>

                <div class="col-12">
                  <button class="btn btn-brand">Guardar cancha</button>
                </div>
              </form>
            </div>
          </div>
          <!-- Table -->
          <hr class="my-5 divider">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0" style="font-family:Oswald;">Proximos eventos</h4>
            <div class="d-flex gap-2">
              <input class="form-control form-control-sm bg-transparent text-light"
                     style="border-color:rgba(148,163,184,.35);border-radius:.8rem;"
                     placeholder="Buscar evento..." />
              <a href="{{ route('events.index') }}" class="btn btn-soft btn-sm">Ver todos</a>
            </div>
          </div>

          <div class="table-responsive pro-card p-0">
            <table class="table table-pro table-hover align-middle">
              <thead>
                <tr>
                  <th>Evento</th>
                  <th>Fecha</th>
                  <th>Lugar</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="fw-semibold">Torneo Regional de Futbol</td>
                  <td>12 Dic 2025</td>
                  <td>Estadio Central</td>
                  <td><span class="badge badge-open rounded-pill px-3 py-2">Inscripciones abiertas</span></td>
                </tr>
                <tr>
                  <td class="fw-semibold">Carrera 10K Ciudad</td>
                  <td>20 Ene 2026</td>
                  <td>Parque Principal</td>
                  <td><span class="badge badge-soon rounded-pill px-3 py-2">Proximo</span></td>
                </tr>
                <tr>
                  <td class="fw-semibold">Liga de Baloncesto</td>
                  <td>05 Feb 2026</td>
                  <td>Coliseo Norte</td>
                  <td><span class="badge badge-prep rounded-pill px-3 py-2">En preparacion</span></td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <!-- Side user -->
      <div class="col-lg-4 align-self-start">
        <div class="pro-card p-4 text-center floating-user-panel">

          <img
            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Usuario Deportivo') }}&background=0D6EFD&color=fff"
            class="avatar mb-3"
            alt="avatar"
          />

          <h5 class="mb-0">{{ auth()->user()->name ?? 'Usuario Deportivo' }}</h5>
          <small class="muted">{{ auth()->user()->email ?? 'usuario@email.com' }}</small>

          <hr class="my-4 divider">

          <div class="d-grid gap-2">
            <a href="#" class="btn btn-soft"><i class="fas fa-cog me-1"></i>Configuracion</a>
            <a href="#" class="btn btn-soft"><i class="fas fa-chart-line me-1"></i>Reportes</a>
          </div>

          <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn w-100"
              style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.6);color:#fecaca;border-radius:.95rem;font-weight:800;padding:.75rem 1rem;">
              Cerrar sesion
            </button>
          </form>

          <p class="small muted mt-3 mb-0">
            Sistema de administracion de eventos deportivos v1.0
          </p>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


