<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Edwin Sport | Panel</title>

  <!-- Fonts -->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- SB Admin base -->
  <link href="{{ asset('CSS/sb-admin-2.min.css') }}" rel="stylesheet">

  <!-- ✅ OPCIÓN C APLICADA -->
  <style>
    :root{
      /* Paleta opción C */
      --bg: #F6F1E7;          /* arena claro */
      --card: #FFFFFF;
      --sidebar: #10131A;     /* negro suave/carbón */
      --primary: #D4A017;     /* dorado */
      --secondary: #1E3A8A;   /* azul oscuro */
      --text: #0B1020;
      --muted: #7A8594;

      --line: rgba(11,16,32,.12);
      --white-line: rgba(255,255,255,.08);
    }

    body{
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
      color: var(--text);
      background:
        radial-gradient(1200px 600px at 5% -10%, rgba(212,160,23,.18), transparent 60%),
        radial-gradient(900px 600px at 110% 0%, rgba(30,58,138,.10), transparent 55%),
        linear-gradient(180deg, var(--bg), #F2EBDD);
      min-height:100vh;
    }

    /* ================= SIDEBAR PREMIUM OSCURO ================= */
    .sidebar{
      background: linear-gradient(180deg, #0d1016, var(--sidebar)) !important;
      border-right: 1px solid var(--white-line);
      box-shadow: 10px 0 25px rgba(0,0,0,.35);
      padding-top: .6rem;
    }

    .sidebar .sidebar-brand{
      padding: 1rem 1rem;
      background:
        linear-gradient(135deg, rgba(212,160,23,.15), rgba(30,58,138,.12));
      border-bottom:1px solid var(--white-line);
    }

    .sidebar .sidebar-brand-text{
      font-family: Oswald, Inter, sans-serif;
      font-weight:600;
      letter-spacing:1px;
      font-size:1.12rem;
      text-transform: uppercase;
      color:#fff !important;
    }

    .sidebar-heading{
      color: rgba(255,255,255,.6) !important;
      letter-spacing: 1px;
      font-weight:800;
      text-transform:uppercase;
      font-size:.72rem;
      margin: 1rem .9rem .3rem .9rem;
    }

    .sidebar .nav-item{
      margin: .12rem .6rem;
    }

    .sidebar .nav-item .nav-link{
      position:relative;
      display:flex;
      align-items:center;
      gap:.6rem;
      border-radius: .9rem;
      padding: .8rem .9rem;
      color: #e5e7eb !important;
      font-weight:700;
      transition: all .12s ease;
    }

    /* activo dorado */
    .sidebar .nav-item.active .nav-link{
      background: rgba(212,160,23,.13) !important;
      color:#fff !important;
      box-shadow: inset 0 0 0 1px rgba(212,160,23,.35);
    }
    .sidebar .nav-item.active .nav-link::before{
      content:"";
      position:absolute;
      left:-8px;
      top:10%;
      bottom:10%;
      width:4px;
      border-radius:999px;
      background: var(--primary);
      box-shadow: 0 0 10px rgba(212,160,23,.8);
    }

    .sidebar .nav-item .nav-link:hover{
      background: rgba(255,255,255,.06) !important;
      color:#fff !important;
      transform: translateX(3px);
    }

    .sidebar .nav-item .nav-link i{
      color:#f8fafc !important;
      font-size:1rem;
      opacity:.9;
    }

    /* dropdown interno claro */
    .collapse-inner{
      border-radius: 1rem !important;
      background: rgba(255,255,255,.98) !important;
      border:1px solid var(--line) !important;
      box-shadow: 0 8px 18px rgba(11,16,32,.15);
      padding:.35rem;
    }
    .collapse-item{
      border-radius: .7rem !important;
      font-weight:700 !important;
      color:var(--text) !important;
      padding: .55rem .8rem !important;
    }
    .collapse-item:hover{
      background: rgba(212,160,23,.12) !important;
      color:var(--text) !important;
    }

    /* ================= TOPBAR CLARA PREMIUM ================= */
    .topbar{
      background: rgba(255,255,255,.95) !important;
      border:1px solid var(--line);
      border-radius: 1rem;
      margin: 1rem 1rem 1.2rem 1rem !important;
      box-shadow: 0 10px 25px rgba(11,16,32,.10);
    }

    .topbar .navbar-search .form-control{
      background: #fff !important;
      color:var(--text) !important;
      border:1px solid var(--line) !important;
      border-radius: 999px !important;
      padding-left: 1.1rem;
    }
    .topbar .navbar-search .form-control::placeholder{
      color:var(--muted) !important;
    }
    .topbar .navbar-search .btn{
      border-radius: 999px !important;
      font-weight:800;
      background: linear-gradient(135deg, var(--secondary), #0f245f) !important;
      border:none !important;
      color: #fff !important;
      box-shadow: 0 8px 18px rgba(30,58,138,.30);
    }

    /* usuario derecha */
    .topbar .dropdown-toggle span{
      color:var(--text) !important;
      font-weight:800;
    }

    /* ================= CONTENIDO ================= */
    #content-wrapper{ background: transparent !important; }
    .container-fluid{
      padding: 0 1.4rem 1.6rem 1.4rem;
    }
    h1,h2,h3,h4,h5{
      font-family: Oswald, Inter, sans-serif;
      letter-spacing:.4px;
      font-weight:600;
      color:var(--text);
    }

    /* ================= CARDS BLANCAS CON ACCENTO TROFEO ================= */
    .card{
      background: var(--card) !important;
      border:1px solid var(--line) !important;
      border-radius: 1.1rem !important;
      box-shadow: 0 12px 26px rgba(11,16,32,.08) !important;
      color:var(--text);
      position:relative;
      overflow:hidden;
    }
    .card-header{
      background: transparent !important;
      border-bottom:1px solid var(--line) !important;
      font-weight:900;
      color:var(--text) !important;
    }

    /* acentos arriba por color */
    .accent-gold{ border-top:4px solid var(--primary) !important; }
    .accent-blue{ border-top:4px solid var(--secondary) !important; }

    /* Footer claro */
    footer.sticky-footer{
      background: rgba(255,255,255,.95) !important;
      color:var(--muted) !important;
      border-top:1px solid var(--line);
      backdrop-filter: blur(6px);
    }

    .scroll-to-top{
      background: linear-gradient(135deg, var(--primary), #b8890f) !important;
      color:#fff !important;
      box-shadow: 0 10px 22px rgba(212,160,23,.35);
    }
  </style>

</head>

<body id="page-top">
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-medal"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Edwin Sport</div>
    </a>

    <hr class="sidebar-divider my-0">

    <div class="sidebar-heading mt-3">Administración</div>

    <!-- Eventos -->
    <li class="nav-item active">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEventos">
        <i class="fas fa-fw fa-trophy"></i>
        <span>Eventos</span>
      </a>
      <div id="collapseEventos" class="collapse show">
        <div class="py-2 collapse-inner rounded">
          <h6 class="collapse-header">Gestión de eventos</h6>
          <a class="collapse-item" href="#">Crear evento</a>
          <a class="collapse-item" href="#">Listado de eventos</a>
          <a class="collapse-item" href="#">Resultados</a>
        </div>
      </div>
    </li>

    <!-- Participantes -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParticipantes">
        <i class="fas fa-fw fa-users"></i>
        <span>Participantes</span>
      </a>
      <div id="collapseParticipantes" class="collapse">
        <div class="py-2 collapse-inner rounded">
          <h6 class="collapse-header">Equipos y atletas</h6>
          <a class="collapse-item" href="#">Registrar participante</a>
          <a class="collapse-item" href="#">Lista de participantes</a>
          <a class="collapse-item" href="#">Categorías</a>
        </div>
      </div>
    </li>

    <!-- Calendario -->
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span>Calendario</span>
      </a>
    </li>

    <!-- Inscripciones -->
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-ticket-alt"></i>
        <span>Inscripciones</span>
      </a>
    </li>

    <!-- Reportes -->
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-chart-line"></i>
        <span>Reportes</span>
      </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End Sidebar -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light topbar static-top shadow">

        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>

        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control small" placeholder="Buscar eventos, participantes...">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-2" href="#"
               id="userDropdown" role="button" data-toggle="dropdown">
              <span class="d-none d-lg-inline fw-semibold">
                {{ auth()->user()->name ?? auth()->user()->email ?? 'Usuario' }}
              </span>
              <img class="img-profile rounded-circle"
                   src="{{ asset('img/undraw_profile.svg') }}"
                   style="width:34px;height:34px;object-fit:cover;">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
              <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Perfil</a>
              <a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Configuración</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Cerrar sesión
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Content -->
      <div class="container-fluid">
        <h1 class="h3 mb-4">Panel del Usuario</h1>
        <p class="text-muted">Bienvenido: {{ auth()->user()->email ?? '' }}</p>

        <!-- Cards ejemplo con acentos -->
        <div class="row">

          <div class="col-lg-4">
            <div class="card accent-gold mb-4">
              <div class="card-header">🏆 Eventos activos</div>
              <div class="card-body">
                Tienes 12 eventos en curso esta semana.
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card accent-blue mb-4">
              <div class="card-header">🎟️ Inscripciones</div>
              <div class="card-body">
                1,284 inscripciones registradas en total.
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card accent-gold mb-4">
              <div class="card-header">📅 Próximos torneos</div>
              <div class="card-body">
                5 torneos programados próximamente.
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>

    <!-- Footer -->
    <footer class="sticky-footer">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; Edwin Sport {{ date('Y') }}</span>
        </div>
      </div>
    </footer>

  </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿Deseas cerrar sesión?</h5>
        <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">Selecciona "Cerrar sesión" para finalizar tu sesión actual.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-primary">Cerrar sesión</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>
