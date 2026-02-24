<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Edwin Sport | Panel Developer</title>

  <!-- Fonts -->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- SB Admin base -->
  <link href="{{ asset('CSS/sb-admin-2.min.css') }}" rel="stylesheet">

  <style>
  /* ==========================================================
   la vista del crear-eventodeveloper
   ========================================================== */
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
        radial-gradient(1200px 600px at 5% -10%, rgba(18, 5, 73, 0.3), transparent 60%),
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
      background: linear-gradient(135deg, rgba(13, 8, 78, 0.25), rgba(30,64,175,.25));
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
      background: rgba(13, 4, 70, 0.15) !important;
      color:#fff !important;
      box-shadow: inset 0 0 0 1px rgba(7, 3, 71, 0.45);
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
      box-shadow: 0 0 10px rgba(35, 10, 128, 0.9);
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
      background: rgba(14, 8, 97, 0.18) !important;
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
      background: linear-gradient(135deg, var(--primary), #10054bff) !important;
      color:#fff !important;
      box-shadow: 0 10px 22px rgba(36, 14, 160, 0.35);
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

    /* =========================================================
       âœ… SOLO LO QUE PEDISTE (SOLO ESTILO):
       1) Centrar el formulario desde donde termina la sidebar
       2) Textbox blancos
       3) Labels blancas
       ========================================================= */

    /* 1) CENTRAR EL FORMULARIO EN EL ÃREA DE CONTENIDO (sin contar la sidebar)
       - No toca JS ni botones.
       - Centra el "include" aunque no tenga clase .formulario-evento.
       - Usa margin auto + max-width (no rompe el display block/none del JS). */
    #contenedor-formulario > *{
      width: 100%;
      max-width: 900px;     /* mismo ancho que tu diseÃ±o */
      margin-left: auto;    /* centra horizontal */
      margin-right: auto;   /* centra horizontal */
    }

    /* Por si dentro del include viene una .card como contenedor principal */
    #contenedor-formulario .card{
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
    }

    /* 2) TEXTBOX BLANCOS (solo en el formulario) */
    #contenedor-formulario input,
    #contenedor-formulario select,
    #contenedor-formulario textarea{
      background: #ffffff !important; /* fondo blanco */
      color: #0f172a !important;      /* texto oscuro */
      border: 1px solid rgba(148,163,184,.9) !important;
    }

    /* Placeholder gris para que se lea en blanco */
    #contenedor-formulario input::placeholder,
    #contenedor-formulario textarea::placeholder{
      color: #64748b !important;
    }

    /* 3) LABELS BLANCAS (solo en el formulario) */
    #contenedor-formulario label{
      color: #ffffff !important;
    }
  </style>

  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>

<body id="page-top">
  <div id="wrapper">

    <!-- âœ… Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-medal"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Edwin Sport</div>
      </a>

      <hr class="sidebar-divider my-0">

      <!-- Crear evento -->
      <li class="nav-item active">
        <button id="btn-crear-evento" type="button" class="nav-link btn btn-link text-left w-100">
          <i class="fas fa-fw fa-plus-circle"></i>
          <span>Crear evento</span>
        </button>
      </li>

      <!-- Listado -->
      <li class="nav-item">
        <button id="btn-listado-eventos" type="button" class="nav-link btn btn-link text-left w-100">
          <i class="fas fa-fw fa-list"></i>
          <span>Listado de eventos</span>
        </button>
      </li>

      <!-- ðŸ§© Patrocinadores -->
      <li class="nav-item">
        <a href="{{ route('sponsors.index') }}" class="nav-link text-left w-100">
          <i class="fas fa-image"></i>
          <span>Patrocinadores</span>
        </a>
      </li>

      <!-- Volver -->
      <li class="nav-item">
        <a href="{{ url('/register') }}" class="nav-link text-left w-100">
          <i class="fas fa-fw fa-arrow-left"></i>
          <span>Volver</span>
        </a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End Sidebar -->

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
            <!-- ðŸ”” Notificaciones -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">{{ $notificacionesCount ?? 0 }}</span>
              </a>

              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
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

                <a class="dropdown-item text-center small text-gray-500" href="#">Ver todas</a>
              </div>
            </li>

            <!-- ðŸ’¬ Mensajes -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-danger badge-counter">{{ $mensajesCount ?? 0 }}</span>
              </a>

              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">Mensajes</h6>

                @forelse($mensajes ?? [] as $m)
                  <a class="dropdown-item d-flex align-items-center" href="{{ $m['url'] ?? '#' }}">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="{{ $m['avatar'] ?? asset('img/undraw_profile.svg') }}" style="width:40px;height:40px;object-fit:cover;">
                      <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                      <div class="text-truncate">{{ $m['texto'] ?? 'Mensaje nuevo' }}</div>
                      <div class="small text-gray-500">{{ $m['nombre'] ?? 'Usuario' }} Â· {{ $m['fecha'] ?? '' }}</div>
                    </div>
                  </a>
                @empty
                  <div class="dropdown-item text-center small text-gray-500 py-3">
                    No tienes mensajes
                  </div>
                @endforelse

                <a class="dropdown-item text-center small text-gray-500" href="#">Ver todos</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- ðŸ‘¤ Usuario -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-2" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span class="d-none d-lg-inline fw-semibold">
                  {{ auth()->user()->name ?? auth()->user()->email ?? 'Usuario' }}
                </span>
                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
              </a>

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Perfil
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> ConfiguraciÃ³n
                </a>
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
          <h1 class="h3 mb-4">Panel del Usuario</h1>
          <p class="text-muted">Bienvenido: {{ auth()->user()->email ?? '' }}</p>

          <div class="row">
            <!-- FORMULARIO -->
            <div id="contenedor-formulario" class="col-12">
              @include('events.crear-evento')
            </div>

            <!-- LISTADO -->
            <div id="contenedor-listado" class="col-12">
              @include('events.listado-eventos', ['eventos' => $eventos])
            </div>
          </div>

          <!-- âœ… ELIMINADO: bloque "NUEVO PATROCINADOR" (ya no se renderiza aquÃ­) -->
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

  <!-- âœ… JS personalizado (sin jQuery extra) -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const form = document.getElementById("contenedor-formulario");
      const list = document.getElementById("contenedor-listado");

      function activar(idBtn) {
        document.querySelectorAll(".sidebar .nav-item")
          .forEach(li => li.classList.remove("active"));
        const btn = document.getElementById(idBtn);
        if (btn) btn.closest(".nav-item").classList.add("active");
      }

      function mostrarFormulario() {
        if (form) form.style.display = "block";
        if (list) list.style.display = "none";
        activar("btn-crear-evento");
      }

      function mostrarListado() {
        if (form) form.style.display = "none";
        if (list) list.style.display = "block";
        activar("btn-listado-eventos");
      }

      // Mostrar formulario al entrar
      mostrarFormulario();

      document.addEventListener("click", function (e) {
        const crear = e.target.closest("#btn-crear-evento");
        const listado = e.target.closest("#btn-listado-eventos");

        if (crear) {
          e.preventDefault();
          mostrarFormulario();
        }
        if (listado) {
          e.preventDefault();
          mostrarListado();
        }
      });

      // Sidebar toggle simple (persistencia bÃ¡sica usando localStorage)
      const sidebar = document.getElementById('accordionSidebar');
      const toggleBtn = document.getElementById('sidebarToggle');

      if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
          sidebar.classList.toggle('toggled');
          try {
            localStorage.setItem('sidebarToggled', sidebar.classList.contains('toggled'));
          } catch (e) {}
        });

        try {
          if (localStorage.getItem('sidebarToggled') === 'true') sidebar.classList.add('toggled');
        } catch (e) {}
      }
    });
  </script>
</body>

</html>

