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
    :root{
      /* Paleta tipo PRO (azul noche) */
      --bg: #050914;
      --bg-2: #070E1F;
      --card: rgba(8, 17, 38, .92);
      --sidebar: #050915;
      --primary: #22D3EE;       /* cian */
      --secondary: #3B82F6;     /* azul */
      --text: #E6ECFF;
      --muted: #9AA6C7;

      --line: rgba(255,255,255,.08);
      --white-line: rgba(255,255,255,.08);
    }

    body{
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
      color: var(--text);
      background:
        radial-gradient(1200px 700px at 10% -20%, rgba(34,211,238,.18), transparent 55%),
        radial-gradient(1000px 700px at 110% 0%, rgba(59,130,246,.18), transparent 60%),
        linear-gradient(180deg, var(--bg), var(--bg-2));
      min-height:100vh;
    }

    /* ================= SIDEBAR PRO ================= */
    .sidebar{
      background: linear-gradient(180deg, #040812, #060B18 45%, #050915) !important;
      border-right: 1px solid var(--white-line);
      box-shadow: 12px 0 30px rgba(0,0,0,.6);
      padding-top: .6rem;
    }

    .sidebar .sidebar-brand{
      padding: 1rem 1rem;
      background:
        linear-gradient(135deg, rgba(34,211,238,.12), rgba(59,130,246,.12));
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

    .sidebar .nav-item{
      margin: .12rem .6rem;
    }

    /* ✅ botones del sidebar como nav-link */
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
      width: 100%;
      text-align: left;
      background: transparent;
      border: none;
      outline: none;
      cursor: pointer;
    }

    .sidebar .nav-item.active .nav-link{
      background: rgba(34,211,238,.12) !important;
      color:#fff !important;
      box-shadow: inset 0 0 0 1px rgba(34,211,238,.35);
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
      box-shadow: 0 0 12px rgba(34,211,238,.9);
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

    /* ================= TOPBAR PRO ================= */
    .topbar{
      background: rgba(8, 17, 38, .95) !important;
      border:1px solid var(--line);
      border-radius: 1rem;
      margin: 1rem 1rem 1.2rem 1rem !important;
      box-shadow: 0 10px 25px rgba(0,0,0,.45);
      backdrop-filter: blur(6px);
    }

    .topbar .navbar-search .form-control{
      background: rgba(255,255,255,.06) !important;
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
      background: linear-gradient(135deg, var(--secondary), #1e40af) !important;
      border:none !important;
      color: #fff !important;
      box-shadow: 0 8px 18px rgba(59,130,246,.35);
    }

    /* ================= CONTENIDO ================= */
    #content-wrapper{ background: transparent !important; }
    .container-fluid{ padding: 0 1.4rem 1.6rem 1.4rem; }

    h1,h2,h3,h4,h5{
      font-family: Oswald, Inter, sans-serif;
      letter-spacing:.4px;
      font-weight:600;
      color:var(--text);
    }

    /* ================= CARDS PRO ================= */
    .card{
      background: var(--card) !important;
      border:1px solid var(--line) !important;
      border-radius: 1.2rem !important;
      box-shadow: 0 14px 30px rgba(0,0,0,.45) !important;
      color:var(--text);
      position:relative;
      overflow:hidden;
      backdrop-filter: blur(6px);
    }
    .card-header{
      background: transparent !important;
      border-bottom:1px solid var(--line) !important;
      font-weight:900;
      color:var(--text) !important;
    }

    footer.sticky-footer{
      background: rgba(8, 17, 38, .95) !important;
      color:var(--muted) !important;
      border-top:1px solid var(--line);
      backdrop-filter: blur(6px);
    }

    .scroll-to-top{
      background: linear-gradient(135deg, var(--primary), #0891b2) !important;
      color:#fff !important;
      box-shadow: 0 10px 22px rgba(34,211,238,.35);
    }

    /* ================= CONTENEDORES (OCULTOS AL INICIO) ================= */
    #contenedor-formulario,
    #contenedor-listado { display:none; }

    #menu-principal-top { display:none !important; }
/* ================== FORMULARIO BONITO (PRO) ================== */
.formulario-evento{
  width: 100%;
  max-width: 880px;
  margin: 0 auto;
  background: rgba(8,17,38,.95);
  padding: 32px;
  border-radius: 1.4rem;
  border: 1px solid var(--line);
  box-shadow: 0 18px 40px rgba(0,0,0,.55);
}

.formulario-evento .hero-title{
  text-align:center;
  font-size: 2rem;
  letter-spacing: 1px;
  font-weight: 800;
  color: #fff;
  margin-bottom: 10px;
}

.formulario-evento .section-title{
  font-size: 1.3rem;
  font-weight: 800;
  color: var(--primary);
  margin-bottom: 18px;
}

/* grid responsive */
.formulario-evento .form-grid{
  display:grid;
  grid-template-columns: repeat(2, minmax(0,1fr));
  gap:18px;
}

@media (max-width: 768px){
  .formulario-evento .form-grid{
    grid-template-columns: 1fr;
  }
}

.formulario-evento .field{
  display:flex;
  flex-direction:column;
  gap:6px;
}

.formulario-evento .field.full{
  grid-column: 1 / -1;
}

.formulario-evento label{
  font-weight: 700;
  color: #E6ECFF;
  font-size: .95rem;
}

/* inputs pro */
.formulario-evento input,
.formulario-evento select,
.formulario-evento textarea{
  width:100%;
  background: rgba(255,255,255,.06);
  border: 1px solid var(--line);
  color: #fff;
  padding: 12px 14px;
  border-radius: .9rem;
  outline: none;
  transition: .15s ease;
}

.formulario-evento input::placeholder,
.formulario-evento textarea::placeholder{
  color: var(--muted);
}

.formulario-evento input:focus,
.formulario-evento select:focus,
.formulario-evento textarea:focus{
  border-color: rgba(34,211,238,.7);
  box-shadow: 0 0 0 3px rgba(34,211,238,.15);
}

/* botón guardar */
.formulario-evento .btn{
  margin-top: 18px;
  width: 100%;
  padding: 12px 18px;
  font-weight: 900;
  border-radius: 1rem;
  border: none;
  color:#001018;
  background: linear-gradient(135deg, var(--primary), #38bdf8);
  box-shadow: 0 10px 24px rgba(34,211,238,.35);
  transition:.15s ease;
}

.formulario-evento .btn:hover{
  transform: translateY(-2px);
  filter: brightness(1.05);
}



    /* ================= ARREGLO LISTADO (TEXTO BLANCO) ================= */
    #contenedor-listado,
    #contenedor-listado *{
      color: #E6ECFF !important;
    }

    #contenedor-listado .text-dark,
    #contenedor-listado .text-muted,
    #contenedor-listado .small,
    #contenedor-listado .text-gray-500,
    #contenedor-listado .text-secondary{
      color: #E6ECFF !important;
      opacity: .9;
    }

    #contenedor-listado h1,
    #contenedor-listado h2,
    #contenedor-listado h3,
    #contenedor-listado h4,
    #contenedor-listado h5{
      color:#FFFFFF !important;
    }
  </style>

</head>

<body id="page-top">
<div id="wrapper">

  <!-- ✅ Sidebar con SOLO 3 BOTONES (button real) -->
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

    <!-- Volver -->
    <li class="nav-item">
      <button id="btn-volver" type="button" class="nav-link btn btn-link text-left w-100">
        <i class="fas fa-fw fa-arrow-left"></i>
        <span>Volver</span>
      </button>
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

          <!-- 🔔 Notificaciones -->
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
                    <span class="font-weight-bold">{{ $n['texto'] ?? 'Notificación nueva' }}</span>
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

          <!-- 💬 Mensajes -->
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
                      {{ $m['nombre'] ?? 'Usuario' }} · {{ $m['fecha'] ?? '' }}
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

          <!-- 👤 Usuario -->
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

<!-- ✅ JS a prueba de SB-Admin (sin jQuery) -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contenedor-formulario");
  const list = document.getElementById("contenedor-listado");

  function activar(idBtn){
    document.querySelectorAll(".sidebar .nav-item")
      .forEach(li => li.classList.remove("active"));
    const btn = document.getElementById(idBtn);
    if(btn) btn.closest(".nav-item").classList.add("active");
  }

  function mostrarFormulario(){
    if(form) form.style.display = "block";
    if(list) list.style.display = "none";
    activar("btn-crear-evento");
  }

  function mostrarListado(){
    if(form) form.style.display = "none";
    if(list) list.style.display = "block";
    activar("btn-listado-eventos");
  }

  // Mostrar formulario al entrar
  mostrarFormulario();

  document.addEventListener("click", function(e){
    const crear   = e.target.closest("#btn-crear-evento");
    const listado = e.target.closest("#btn-listado-eventos");
    const volver  = e.target.closest("#btn-volver");

    if(crear){
      e.preventDefault();
      mostrarFormulario();
    }
    if(listado){
      e.preventDefault();
      mostrarListado();
    }
    if(volver){
      e.preventDefault();
      history.back();
    }
  });
  
});
</script>

</body>
</html>
