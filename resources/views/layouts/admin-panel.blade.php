<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>@yield('title', 'Edwin Sport | Panel')</title>

  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('CSS/sb-admin-2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('CSS/views/panel/usuario-panel.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
  @stack('styles')
</head>
<body id="page-top">
@php
  $isDashboard = request()->routeIs('usuario.panel');
  $isReservasExternas = request()->routeIs('reservas_externas.index') || request()->routeIs('reservas_externas.create') || request()->routeIs('reservas_externas.edit');
  $isHistorialReservas = request()->routeIs('reservas_externas.history');
  $isReservasSection = $isReservasExternas || $isHistorialReservas;
@endphp

<div id="wrapper">
  <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('usuario.panel') }}">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-medal"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Edwin Sport</div>
    </a>

    <hr class="sidebar-divider my-0">

    <div class="sidebar-heading mt-3">Administracion</div>

    <li class="nav-item {{ $isDashboard ? 'active' : '' }}">
      <a class="nav-link collapsed {{ $isDashboard ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapsePanel" aria-expanded="{{ $isDashboard ? 'true' : 'false' }}" data-toggle-tooltip="tooltip" data-placement="right" title="Panel principal">
        <i class="fas fa-fw fa-trophy"></i>
        <span>Panel principal</span>
      </a>
      <div id="collapsePanel" class="collapse {{ $isDashboard ? 'show' : '' }}">
        <div class="py-2 collapse-inner rounded">
          <a class="collapse-item {{ $isDashboard ? 'active' : '' }}" href="{{ route('usuario.panel') }}">Inicio del panel</a>
          <a id="btn-crear-evento" class="collapse-item" href="{{ $isDashboard ? '#' : route('usuario.panel') }}">Crear evento</a>
          <a id="btn-listado-eventos" class="collapse-item" href="{{ $isDashboard ? '#' : route('usuario.panel') }}">Listado de eventos</a>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParticipantes" aria-expanded="false" data-toggle-tooltip="tooltip" data-placement="right" title="Participantes">
        <i class="fas fa-fw fa-users"></i>
        <span>Participantes</span>
      </a>
      <div id="collapseParticipantes" class="collapse">
        <div class="py-2 collapse-inner rounded">
          <a id="btn-registrar-participante" class="collapse-item" href="{{ $isDashboard ? '#' : route('usuario.panel') }}">
            Registrar participantes
          </a>
        </div>
      </div>
    </li>

    <li class="nav-item {{ $isReservasSection ? 'active' : '' }}">
      <a class="nav-link collapsed {{ $isReservasSection ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseReservasExternas" aria-expanded="{{ $isReservasSection ? 'true' : 'false' }}" data-toggle-tooltip="tooltip" data-placement="right" title="Reservas externas">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span>Reservas externas</span>
      </a>
      <div id="collapseReservasExternas" class="collapse {{ $isReservasSection ? 'show' : '' }}">
        <div class="py-2 collapse-inner rounded">
          <a class="collapse-item {{ $isReservasExternas ? 'active' : '' }}" href="{{ route('reservas_externas.index') }}">
            Proximas reservas
          </a>
          <a class="collapse-item {{ $isHistorialReservas ? 'active' : '' }}" href="{{ route('reservas_externas.history') }}">
            Historial
          </a>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#" data-toggle-tooltip="tooltip" data-placement="right" title="Inscripciones">
        <i class="fas fa-fw fa-ticket-alt"></i>
        <span>Inscripciones</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#" data-toggle-tooltip="tooltip" data-placement="right" title="Reportes">
        <i class="fas fa-fw fa-chart-line"></i>
        <span>Reportes</span>
      </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>

  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
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
                    <span class="font-weight-bold">{{ $n['texto'] ?? 'Notificacion nueva' }}</span>
                  </div>
                </a>
              @empty
                <div class="dropdown-item text-center small text-gray-500 py-3">No tienes notificaciones</div>
              @endforelse
            </div>
          </li>

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
                    <div class="small text-gray-500">{{ $m['nombre'] ?? 'Usuario' }} · {{ $m['fecha'] ?? '' }}</div>
                  </div>
                </a>
              @empty
                <div class="dropdown-item text-center small text-gray-500 py-3">No tienes mensajes</div>
              @endforelse
            </div>
          </li>

          <div class="topbar-divider d-none d-sm-block"></div>

          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-2" href="#" id="userDropdown" role="button" data-toggle="dropdown">
              <span class="d-none d-lg-inline fw-semibold">{{ auth()->user()->name ?? auth()->user()->email ?? 'Usuario' }}</span>
              <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}" style="width:34px;height:34px;object-fit:cover;">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
              <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Perfil</a>
              <a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Configuracion</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Cerrar sesion
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <div class="container-fluid">
        @yield('admin_content')
      </div>
    </div>

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

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿Deseas cerrar sesion?</h5>
        <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">Selecciona "Cerrar sesion" para finalizar tu sesion actual.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-primary">Cerrar sesion</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script>
  (function () {
    var storageKey = 'edwinsport-admin-sidebar-toggled';
    var collapseSelector = '.sidebar .collapse';

    function applySidebarState() {
      if (window.innerWidth < 768) {
        return;
      }

      var shouldBeToggled = localStorage.getItem(storageKey) === 'true';
      var body = document.body;
      var sidebar = document.querySelector('.sidebar');

      if (!sidebar) {
        return;
      }

      if (shouldBeToggled) {
        body.classList.add('sidebar-toggled');
        sidebar.classList.add('toggled');
      } else {
        body.classList.remove('sidebar-toggled');
        sidebar.classList.remove('toggled');
      }
    }

    function isDesktopCollapsed() {
      var sidebar = document.querySelector('.sidebar');
      return window.innerWidth >= 768 && sidebar && sidebar.classList.contains('toggled');
    }

    function hideFloatingSubmenus() {
      document.querySelectorAll(collapseSelector).forEach(function (collapse) {
        collapse.classList.remove('show');
      });
    }

    function syncSidebarTooltips() {
      var collapsed = isDesktopCollapsed();

      $('[data-toggle-tooltip="tooltip"]').each(function () {
        var $element = $(this);

        if (collapsed) {
          if (!$element.data('bs.tooltip')) {
            $element.tooltip({
              trigger: 'hover',
              container: 'body'
            });
          }
          return;
        }

        $element.tooltip('hide');
        if ($element.data('bs.tooltip')) {
          $element.tooltip('dispose');
        }
      });
    }

    document.addEventListener('DOMContentLoaded', function () {
      applySidebarState();

      if (isDesktopCollapsed()) {
        hideFloatingSubmenus();
      }
      syncSidebarTooltips();

      var toggleButton = document.getElementById('sidebarToggle');
      if (toggleButton) {
        toggleButton.addEventListener('click', function () {
          window.setTimeout(function () {
            var sidebar = document.querySelector('.sidebar');
            var isToggled = sidebar && sidebar.classList.contains('toggled');
            localStorage.setItem(storageKey, isToggled ? 'true' : 'false');
            if (isToggled) {
              hideFloatingSubmenus();
            }
            syncSidebarTooltips();
          }, 0);
        });
      }

      document.querySelectorAll('.sidebar .nav-link[data-toggle="collapse"]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
          if (!isDesktopCollapsed()) {
            return;
          }

          var targetSelector = trigger.getAttribute('data-target');
          window.setTimeout(function () {
            document.querySelectorAll(collapseSelector).forEach(function (collapse) {
              if (collapse.matches(targetSelector)) {
                return;
              }
              collapse.classList.remove('show');
            });
          }, 0);
        });
      });

      document.querySelectorAll('.sidebar .collapse-item').forEach(function (item) {
        item.addEventListener('click', function () {
          if (isDesktopCollapsed()) {
            hideFloatingSubmenus();
          }
        });
      });

      document.addEventListener('click', function (event) {
        if (!isDesktopCollapsed()) {
          return;
        }

        var clickedInsideSidebar = event.target.closest('.sidebar');
        if (!clickedInsideSidebar) {
          hideFloatingSubmenus();
        }
      });

      window.addEventListener('resize', function () {
        if (window.innerWidth < 768) {
          localStorage.removeItem(storageKey);
          document.body.classList.remove('sidebar-toggled');
          var sidebar = document.querySelector('.sidebar');
          if (sidebar) {
            sidebar.classList.remove('toggled');
          }
          syncSidebarTooltips();
          return;
        }

        applySidebarState();
        if (isDesktopCollapsed()) {
          hideFloatingSubmenus();
        }
        syncSidebarTooltips();
      });
    });
  })();
</script>
@stack('scripts')
</body>
</html>
