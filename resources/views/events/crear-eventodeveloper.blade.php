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

    <link rel="stylesheet" href="{{ asset('CSS/views/events/create-developer.css') }}">

  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>
@php
  $initialPanel = 'crear-evento';
  if ($errors->fixtureReport->any() || session('fixture_report_success') || session('fixture_report_url')) {
      $initialPanel = 'info-encuentro';
  }
  if ($errors->storeItem->any() || session('store_success')) {
      $initialPanel = 'modulo-tiendas';
  }
@endphp

<body id="page-top" data-initial-panel="{{ $initialPanel }}">
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

      <li class="nav-item">
        <button id="btn-info-encuentro" type="button" class="nav-link btn btn-link text-left w-100">
          <i class="fas fa-fw fa-futbol"></i>
          <span>Info de encuentros</span>
        </button>
      </li>

      <li class="nav-item">
        <button id="btn-modulo-tiendas" type="button" class="nav-link btn btn-link text-left w-100">
          <i class="fas fa-fw fa-store"></i>
          <span>Modulo tiendas</span>
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
                      <span class="font-weight-bold">{{ $n['texto'] ?? 'Notificaci&oacute;n nueva' }}</span>
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
                      <img class="rounded-circle" src="{{ $m['avatar'] ?? asset('img2/undraw_profile.svg') }}" style="width:40px;height:40px;object-fit:cover;">
                      <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                      <div class="text-truncate">{{ $m['texto'] ?? 'Mensaje nuevo' }}</div>
                      <div class="small text-gray-500">{{ $m['nombre'] ?? 'Usuario' }} &middot; {{ $m['fecha'] ?? '' }}</div>
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
                <img class="img-profile rounded-circle" src="{{ asset('img2/undraw_profile.svg') }}">
              </a>

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Perfil
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Configuraci&oacute;n
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Cerrar sesi&oacute;n
                </a>
              </div>
            </li>
          </ul>
        </nav>

        <!-- Content -->
        <div class="container-fluid">
          <section class="panel-hero">
            <h1 class="hero-title">Panel del Usuario</h1>
            <p class="hero-subtitle">Bienvenido: {{ auth()->user()->email ?? '' }}</p>
          </section>

          <div class="row">
            <!-- FORMULARIO -->
            <div id="contenedor-formulario" class="col-12">
              @include('events.crear-evento')
            </div>

            <!-- LISTADO -->
            <div id="contenedor-listado" class="col-12" style="display:none;">
              @include('events.partials.listado-eventos-content', ['eventos' => $eventos])
            </div>

            <!-- MODULO INFO ENCUENTRO -->
            <div id="contenedor-info-encuentro" class="col-12" style="display:none;">
              @include('events.partials.fixture-info-module')
            </div>

            <!-- MODULO TIENDAS -->
            <div id="contenedor-modulo-tiendas" class="col-12" style="display:none;">
              @include('events.partials.store-module', [
                'storeItems' => $storeItems ?? collect(),
                'externalStoreItems' => $externalStoreItems ?? collect(),
              ])
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
          <h5 class="modal-title">&iquest;Deseas cerrar sesi&oacute;n?</h5>
          <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">Selecciona "Cerrar sesi&oacute;n" para finalizar tu sesi&oacute;n actual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Cerrar sesi&oacute;n</button>
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

  <script src="{{ asset('js/views/events/create-developer.js') }}"></script>
</body>

</html>
