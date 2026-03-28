<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administradores | Panel Deportivo</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font (sport/premium) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('CSS/views/crear_admin/crear_usuario.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>

<body>
  <div class="container py-4 py-lg-5">

    <!-- HERO -->
    <div class="hero mb-4">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
          <div class="pill mb-2">Panel de Control · Eventos Deportivos</div>
          <h1 class="hero-title">Gestion de Usuarios Administradores</h1>
          <p class="hero-sub">
            Crea, organiza y controla el acceso de tu equipo administrativo con seguridad y estilo.
          </p>
        </div>
        <div class="text-md-end">
          <a href="{{ route('register') }}" class="btn btn-ghost">
            Volver al panel principal
          </a>
        </div>
      </div>
    </div>

    <div class="row g-4">

      <!-- FORMULARIO CREAR -->
      <div class="col-lg-5">
        <div class="pro-card p-4 sticky-lg-top" style="top:1.5rem;">
          <div class="section-title">
            <h4 class="mb-0">Crear Administrador</h4>
            <span class="badge badge-role rounded-pill px-3 py-2">ADMIN</span>
          </div>

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          @if($errors->any())
            <div class="alert alert-warning">
              <ul class="mb-0">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('guardar_usuario') }}" class="mt-3">
            @csrf

            <div class="mb-3">
              <label class="form-label">Nombre completo</label>
              <input type="text" name="name" class="form-control" placeholder="Ej: Camila Perez" required>
              <div class="helper">Este nombre sera visible en el panel.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Correo electronico</label>
              <input type="email" name="email" class="form-control" placeholder="admin@tuevento.com" required>
              <div class="helper">Usa un email corporativo si es posible.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Contrasena</label>
              <input type="password" name="password" class="form-control" placeholder="Minimo 6 caracteres" minlength="6" required>
              <div class="helper">Recomendado: letras + numeros + simbolo.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirmar contrasena</label>
              <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la contrasena" minlength="6" required>
            </div>

            <button class="btn btn-brand w-100 mt-2">
              Crear usuario administrador
            </button>
          </form>
        </div>
      </div>

      <!-- LISTA + ELIMINAR -->
      <div class="col-lg-7">
        <div class="pro-card p-4">
          <div class="section-title">
            <h4 class="mb-0">Usuarios Administradores</h4>
            <div class="text-muted small">
              Total: <strong class="text-light">{{ count($admins) }}</strong>
            </div>
          </div>

          @if(count($admins) > 0)
            <div class="table-responsive">
              <table class="table table-pro table-hover align-middle">
                <thead>
                  <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Registro</th>
                    <th class="text-end">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($admins as $a)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             class="avatar-chip">
                          {{ strtoupper(substr($a->name,0,1)) }}
                        </div>
                        <div>
                          <div class="fw-semibold text-light">{{ $a->name }}</div>
                          <div class="small">
                            @if($a->role === 'superadmin')
                              <span class="role-chip role-superadmin">Superadmin</span>
                            @elseif($a->role === 'developer')
                              <span class="role-chip role-developer">Developer</span>
                            @else
                              <span class="role-chip role-admin">Admin</span>
                            @endif
                          </div>
                        </div>
                      </div>
                    </td>

                    <td>{{ $a->email }}</td>

                    <td>
                      <span class="text-muted">
                        {{ $a->created_at->format('d M Y') }}
                      </span>
                    </td>

                    <!-- ACCIONES LIMPIAS (SIN MODAL AQUI) -->
                    <td class="text-end">
                      <div class="d-flex justify-content-end align-items-center gap-2 flex-wrap">

                        <!-- Boton abrir modal -->
                        <button
                          type="button"
                          class="btn btn-sm btn-outline-light btn-action-safe"
                          data-bs-toggle="modal"
                          data-bs-target="#modalPassword{{ $a->id }}"
                        >
                          Cambiar
                        </button>

                        <!-- Eliminar -->
                        @if(in_array($a->role, ['superadmin', 'developer']))
                          <button class="btn btn-sm btn-outline-light btn-action-danger" disabled title="Cuenta protegida">
                            Protegido
                          </button>
                        @else
                          <form action="{{ route('crear_usuario.destroy', $a->id) }}" method="POST" style="display:inline;" data-delete-admin-form>
                            @csrf
                            @method('DELETE')
                            <button
                              class="btn btn-sm btn-outline-light btn-action-danger"
                            >
                              Eliminar
                            </button>
                          </form>
                        @endif

                      </div>
                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-5">
              <div class="display-6 mb-2">Usuarios</div>
              <p class="text-muted mb-0">No hay administradores aun.</p>
              <p class="text-muted small">Crea el primero desde el formulario.</p>
            </div>
          @endif

        </div>
      </div>

    </div>
  </div>

  <!-- MODALES FUERA DE LA TABLA (ARREGLO DEFINITIVO) -->
  @foreach($admins as $a)
    <div class="modal fade" id="modalPassword{{ $a->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pro-card p-3">
          <div class="modal-header border-0">
            <h5 class="modal-title text-light">Cambiar contrasena</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>

          <form action="{{ route('crear_usuario.updatePassword', $a->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="modal-body">
              <label class="form-label">Nueva contrasena para {{ $a->name }}</label>
              <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Nueva contrasena"
                minlength="6"
                required
                autofocus
              >
              <div class="helper">Minimo 6 caracteres.</div>
            </div>

            <div class="modal-footer border-0">
              <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-brand">Guardar</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  @endforeach


  <!-- Bootstrap JS (NECESARIO PARA EL MODAL) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/views/crear_admin/crear_usuario.js') }}"></script>
</body>
</html>


