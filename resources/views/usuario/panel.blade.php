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

  <style>
    :root{
      --bg: #020617;          /* fondo oscuro general del contenido */
      --card: #020924;
      --sidebar: #020617;
      --primary: #D4A017;
      --secondary: #1E3A8A;
      --text: #E5E7EB;        /* texto claro para fondo oscuro */
      --muted: #CBD5F5;

      --line: rgba(148,163,184,.35);
      --white-line: rgba(255,255,255,.08);
    }

    body{
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
      color: var(--text);
      background:
        radial-gradient(1200px 600px at 5% -10%, rgba(212,160,23,.30), transparent 60%),
        radial-gradient(900px 600px at 110% 0%, rgba(30,64,175,.40), transparent 55%),
        linear-gradient(180deg, #020617, #020617);
      min-height:100vh;
    }

    /* textos â€œmutedâ€ mÃ¡s claros para que se vean sobre el fondo oscuro */
    .text-muted{
      color: var(--muted) !important;
    }

    /* ================= SIDEBAR ================= */
    .sidebar{
      background: linear-gradient(180deg, #020617, #020617) !important;
      border-right: 1px solid var(--white-line);
      box-shadow: 10px 0 25px rgba(0,0,0,.60);
      padding-top: .6rem;
    }

    .sidebar .sidebar-brand{
      padding: 1rem 1rem;
      background: linear-gradient(135deg, rgba(212,160,23,.25), rgba(30,64,175,.25));
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
      color: rgba(148,163,184,.85) !important;
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

    .sidebar .nav-item.active .nav-link{
      background: rgba(212,160,23,.15) !important;
      color:#fff !important;
      box-shadow: inset 0 0 0 1px rgba(212,160,23,.45);
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
      box-shadow: 0 0 10px rgba(212,160,23,.9);
    }

    .sidebar .nav-item .nav-link:hover{
      background: rgba(148,163,184,.28) !important;
      color:#fff !important;
      transform: translateX(3px);
    }

    .sidebar .nav-item .nav-link i{
      color:#f8fafc !important;
      font-size:1rem;
      opacity:.9;
    }

    .collapse-inner{
      border-radius: 1rem !important;
      background: rgba(15,23,42,1) !important;
      border:1px solid var(--white-line) !important;
      box-shadow: 0 8px 18px rgba(15,23,42,.9);
      padding:.35rem;
    }
    .collapse-item{
      border-radius: .7rem !important;
      font-weight:700 !important;
      color:#e5e7eb !important;
      padding: .55rem .8rem !important;
    }
    .collapse-item:hover{
      background: rgba(212,160,23,.18) !important;
      color:#f9fafb !important;
    }

    /* ================= TOPBAR ================= */
    .topbar{
      background: rgba(15,23,42,.98) !important;
      border:1px solid var(--white-line);
      border-radius: 1rem;
      margin: 1rem 1rem 1.2rem 1rem !important;
      box-shadow: 0 18px 40px rgba(0,0,0,.65);
    }

    .topbar .navbar-search .form-control{
      background: #0b1220 !important;
      color:#e5e7eb !important;
      border:1px solid rgba(148,163,184,.6) !important;
      border-radius: 999px !important;
      padding-left: 1.1rem;
    }
    .topbar .navbar-search .form-control::placeholder{
      color:#94a3b8 !important;
    }
    .topbar .navbar-search .btn{
      border-radius: 999px !important;
      font-weight:800;
      background: linear-gradient(135deg, var(--secondary), #0f245f) !important;
      border:none !important;
      color: #fff !important;
      box-shadow: 0 8px 18px rgba(30,64,175,.60);
    }

    .topbar .dropdown-toggle span{
      color:#e5e7eb !important;
      font-weight:800;
    }

    .topbar .nav-link i{
      color: #e5e7eb !important;
      font-size: 1.05rem;
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
      color:#f9fafb;
    }

    /* ================= CARDS OSCURAS ================= */
    .card{
      background: #020924 !important;
      border:1px solid rgba(15,23,42,.9) !important;
      border-radius: 1.1rem !important;
      box-shadow: 0 16px 40px rgba(0,0,0,.80) !important;
      color:#e5e7eb !important;
      position:relative;
      overflow:hidden;
    }
    .card-header{
      background: linear-gradient(90deg, rgba(15,23,42,1), rgba(15,23,42,.6)) !important;
      border-bottom:1px solid rgba(15,23,42,.9) !important;
      font-weight:900;
      color:#f9fafb !important;
    }

    /* Evita texto blanco â€œapagadoâ€ dentro de cards */
    #content .card .text-white{
      color: #f9fafb !important;
    }

    .accent-gold{ border-top:4px solid var(--primary) !important; }
    .accent-blue{ border-top:4px solid var(--secondary) !important; }

    footer.sticky-footer{
      background: #020617 !important;
      color:#9ca3af !important;
      border-top:1px solid rgba(15,23,42,.9);
    }

    .scroll-to-top{
      background: linear-gradient(135deg, var(--primary), #b8890f) !important;
      color:#fff !important;
      box-shadow: 0 10px 22px rgba(212,160,23,.35);
    }

    /* ================= FORMULARIO CREAR EVENTO ================= */

    #contenedor-formulario {
      display: flex;
      justify-content: center;
      width: 100%;
      padding: 30px 0;
    }

    .formulario-evento {
      width: 100%;
      max-width: 900px;
      background: #020b1c;
      padding: 35px;
      border-radius: 1.4rem;
      border: 1px solid rgba(15,23,42,.9);
      box-shadow: 0 16px 40px rgba(0,0,0,.85);
    }

    .formulario-evento form .card{
      padding: 35px !important;
      background:#020b1c !important;
      border:none !important;
      box-shadow:none !important;
    }

    .formulario-evento input,
    .formulario-evento select,
    .formulario-evento textarea {
      width: 100% !important;
      box-sizing: border-box !important;
      border-radius: 0.8rem !important;
      border: 1px solid rgba(148,163,184,.6) !important;
      padding: 12px 14px !important;
      background:#020617 !important;
      color:#e5e7eb !important;
    }

    .formulario-evento .form-group,
    .formulario-evento .field,
    .formulario-evento .full,
    .formulario-evento div {
      margin-bottom: 18px;
    }

    .formulario-evento h1 {
      text-align: center !important;
      width: 100%;
    }

    .formulario-evento h2,
    .formulario-evento h3 {
      font-family: Oswald, sans-serif;
      margin-bottom: 20px;
      color: #f9fafb;
    }

    .formulario-evento button[type="submit"] {
      border: 0 !important;
      background: linear-gradient(90deg,#2563eb,#22c55e) !important;
      color: #f9fafb !important;
      font-weight: 800;
      border-radius: 999px !important;
      padding: 12px 26px;
      transition: 0.2s ease;
      box-shadow: 0 14px 30px rgba(37,99,235,.55);
    }

    .formulario-evento button[type="submit"]:hover {
      transform: translateY(-2px);
      box-shadow: 0 18px 40px rgba(37,99,235,.75);
    }

    #menu-principal-top {
      display: none !important;
    }

    /* =========================================================
       *****  ARREGLO DURO PARA QUE LAS TABLAS SE VEAN  *****
       Cualquier tabla .table quedarÃ¡ con fondo claro
       y texto oscuro, sin opacidades.
       Esto afecta tu tabla de â€œEquipos Registradosâ€.
       ========================================================= */

    .table{
      background-color:#ffffff !important;
      color:#020617 !important;
      border-radius: 1rem !important;
      overflow: hidden;
    }

    .table th,
    .table td{
      color:#020617 !important;
      opacity:1 !important;
      background-color:#ffffff !important;
      border-top:1px solid rgba(148,163,184,.45) !important;
      vertical-align: middle !important;
    }

    .table thead th{
      background:#E5E7EB !important;
      color:#020617 !important;
      font-weight:700 !important;
      border-bottom:1px solid rgba(148,163,184,.8) !important;
    }

    .table-striped tbody tr:nth-of-type(odd){
      background-color:#ffffff !important;
    }
    .table-striped tbody tr:nth-of-type(even){
      background-color:#F9FAFB !important;
    }

    .table-hover tbody tr:hover{
      background-color:#E0ECFF !important;
    }

    .table .btn{
      border-radius:.8rem !important;
      font-weight:600 !important;
    }

  </style>

  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
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

    <div class="sidebar-heading mt-3">AdministraciÃ³n</div>

    <!-- Eventos -->
    <li class="nav-item active">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEventos">
        <i class="fas fa-fw fa-trophy"></i>
        <span>Eventos</span>
      </a>
      <div id="collapseEventos" class="collapse show">
        <div class="py-2 collapse-inner rounded">
          <h6 class="collapse-header">Gestion de eventos</h6>
          <a id="btn-crear-evento" class="collapse-item" href="#">Crear evento</a>
          <a id="btn-listado-eventos" class="collapse-item" href="#">Listado de eventos</a>
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

          <a class="collapse-item" href="#" id="btn-registrar-participante">
            Registrar participantes
          </a>

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

        <!-- Notificaciones, mensajes y usuario -->
        <ul class="navbar-nav ml-auto">

          <!-- Notificaciones -->
          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-bell fa-fw"></i>
              <span class="badge badge-danger badge-counter">
                {{ $notificacionesCount ?? 0 }}
              </span>
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
              <h6 class="dropdown-header">Notificaciones</h6>

              @forelse($notificaciones ?? [] as $n)
                <a class="dropdown-item d-flex align-items-center" href="{{ $n['url'] ?? '#' }}">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="{{ $n['icon'] ?? 'fas fa-info text-white' }}"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">{{ $n['fecha'] ?? '' }}</div>
                    <span class="font-weight-bold">{{ $n['texto'] ?? 'NotificaciÃ³n nueva' }}</span>
                  </div>
                </a>
              @empty
                <div class="dropdown-item text-center small text-gray-500 py-3">
                  No tienes notificaciones
                </div>
              @endforelse

              <a class="dropdown-item text-center small text-gray-500" href="#">
                Ver todas
              </a>
            </div>
          </li>

          <!-- Mensajes -->
          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-envelope fa-fw"></i>
              <span class="badge badge-danger badge-counter">
                {{ $mensajesCount ?? 0 }}
              </span>
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="messagesDropdown">
              <h6 class="dropdown-header">Mensajes</h6>

              @forelse($mensajes ?? [] as $m)
                <a class="dropdown-item d-flex align-items-center" href="{{ $m['url'] ?? '#' }}">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle"
                         src="{{ $m['avatar'] ?? asset('img/undraw_profile.svg') }}"
                         style="width:40px;height:40px;object-fit:cover;">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">{{ $m['texto'] ?? 'Mensaje nuevo' }}</div>
                    <div class="small text-gray-500">
                      {{ $m['nombre'] ?? 'Usuario' }} Â· {{ $m['fecha'] ?? '' }}
                    </div>
                  </div>
                </a>
              @empty
                <div class="dropdown-item text-center small text-gray-500 py-3">
                  No tienes mensajes
                </div>
              @endforelse

              <a class="dropdown-item text-center small text-gray-500" href="#">
                Ver todos
              </a>
            </div>
          </li>

          <div class="topbar-divider d-none d-sm-block"></div>

          <!-- Usuario -->
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
              <a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> ConfiguraciÃ³n</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Cerrar sesiÃ³n
              </a>
            </div>
          </li>

        </ul>
      </nav>

      <!-- Content -->
      <div class="container-fluid">
        <h1 class="h3 mb-1">Panel del Usuario</h1>
        <p class="mb-4 text-muted">Bienvenido: {{ auth()->user()->email ?? '' }}</p>

        <div class="row">

          <!-- FORMULARIO EVENTO -->
          <div id="contenedor-formulario" class="col-12" style="display:none;">
            @include('events.crear-evento')
          </div>

          <!-- LISTADO EVENTOS -->
          <div id="contenedor-listado" class="col-12" style="display:none;">
            @include('events.listado-eventos')
          </div>

          <!-- PARTICIPANTES -->
          <div id="contenedor-participantes" class="col-12" style="display:none;">
            @include('REGISTER.participantes', ['hideBackButton' => true])
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
        <h5 class="modal-title">Â¿Deseas cerrar sesiÃ³n?</h5>
        <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">Ã—</span></button>
      </div>
      <div class="modal-body">Selecciona "Cerrar sesiÃ³n" para finalizar tu sesiÃ³n actual.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-primary">Cerrar sesiÃ³n</button>
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

<!-- JS PARA CAMBIAR ENTRE VISTAS -->
<script>
document.getElementById('btn-crear-evento').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('contenedor-formulario').style.display = "block";
    document.getElementById('contenedor-listado').style.display = "none";
    document.getElementById('contenedor-participantes').style.display = "none";
});

document.getElementById('btn-listado-eventos').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('contenedor-formulario').style.display = "none";
    document.getElementById('contenedor-listado').style.display = "block";
    document.getElementById('contenedor-participantes').style.display = "none";
});

document.getElementById('btn-registrar-participante').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('contenedor-formulario').style.display = "none";
    document.getElementById('contenedor-listado').style.display = "none";
    document.getElementById('contenedor-participantes').style.display = "block";
});
</script>

</body>
</html>

