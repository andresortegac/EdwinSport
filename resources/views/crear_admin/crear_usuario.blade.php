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

  <style>
    :root{
      --brand-900:#0b1020;
      --brand-800:#111936;
      --brand-700:#172554;
      --accent-500:#22d3ee;   /* cyan */
      --accent-600:#0ea5e9;   /* sky */
      --accent-700:#2563eb;   /* blue */
      --success-500:#22c55e;
      --danger-500:#ef4444;
      --muted-400:#94a3b8;
      --text:#e2e8f0;
    }

    body{
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:
        radial-gradient(1200px 600px at 10% -10%, rgba(34,211,238,.18), transparent 60%),
        radial-gradient(900px 500px at 110% 0%, rgba(37,99,235,.18), transparent 55%),
        linear-gradient(180deg, #0a0f1d 0%, #0f172a 40%, #0b1020 100%);
      color: var(--text);
      min-height: 100vh;
    }

    .hero{
      background:
        linear-gradient(135deg, rgba(34,211,238,.12), rgba(37,99,235,.12)),
        linear-gradient(180deg, var(--brand-900), var(--brand-800));
      border: 1px solid rgba(148,163,184,.15);
      border-radius: 1.25rem;
      padding: 1.5rem 1.75rem;
      box-shadow: 0 10px 30px rgba(0,0,0,.35);
    }
    .hero-title{
      font-family: Oswald, Inter, sans-serif;
      letter-spacing: .5px;
      font-weight: 600;
      font-size: clamp(1.6rem, 2.4vw, 2.2rem);
      margin: 0;
    }
    .hero-sub{
      color: var(--muted-400);
      margin-top: .35rem;
      font-size: .98rem;
    }
    .pill{
      display:inline-flex;
      align-items:center;
      gap:.5rem;
      background: rgba(34,211,238,.08);
      border: 1px solid rgba(34,211,238,.35);
      color:#dff9ff;
      padding:.35rem .7rem;
      border-radius: 999px;
      font-size:.85rem;
      font-weight:600;
      letter-spacing:.2px;
    }

    .pro-card{
      background: linear-gradient(180deg, rgba(17,25,54,.9), rgba(11,16,32,.95));
      border: 1px solid rgba(148,163,184,.12);
      border-radius: 1.25rem;
      box-shadow: 0 10px 30px rgba(0,0,0,.35);
      backdrop-filter: blur(6px);
    }
    .pro-card h4{
      font-family: Oswald, Inter, sans-serif;
      font-weight: 600;
      letter-spacing: .4px;
      color: #f8fafc;
    }

    .form-label{ color:#cbd5e1; font-weight:600; }
    .form-control{
      background: rgba(2,6,23,.6);
      border: 1px solid rgba(148,163,184,.25);
      color:#e2e8f0;
      border-radius: .9rem;
      padding:.8rem .9rem;
    }
    .form-control:focus{
      border-color: var(--accent-500);
      box-shadow: 0 0 0 .2rem rgba(34,211,238,.15);
      background: rgba(2,6,23,.9);
      color:#fff;
    }
    .helper{
      color: var(--muted-400);
      font-size:.85rem;
      margin-top:.35rem;
    }

    .btn-brand{
      background: linear-gradient(135deg, var(--accent-600), var(--accent-700));
      border: none;
      color:white;
      font-weight:700;
      letter-spacing:.3px;
      border-radius: .95rem;
      padding:.8rem 1rem;
      box-shadow: 0 8px 18px rgba(14,165,233,.35);
      transition: transform .08s ease, filter .12s ease;
    }
    .btn-brand:hover{ filter: brightness(1.05); transform: translateY(-1px); }
    .btn-ghost{
      background: transparent;
      border:1px solid rgba(148,163,184,.35);
      color:#e2e8f0;
      border-radius:.95rem;
      padding:.75rem 1rem;
      font-weight:600;
    }
    .btn-ghost:hover{ border-color:#e2e8f0; color:#fff; }

    .table-pro{
      --bs-table-bg: rgba(2,6,23,.78);
      --bs-table-color: var(--text);
      --bs-table-hover-bg: rgba(34,211,238,.10);
      --bs-table-border-color: rgba(148,163,184,.18);
      color: var(--text) !important;
      border-color: rgba(148,163,184,.12);
      margin:0;
    }
    .table-pro thead th{
      color:#e2e8f0 !important;
      font-weight:800;
      text-transform: uppercase;
      font-size:.8rem;
      letter-spacing:.6px;
      background: rgba(15,23,42,.95) !important;
      border-bottom:1px solid rgba(148,163,184,.2) !important;
    }
    .table-pro > :not(caption) > * > *{
      background-color: rgba(2,6,23,.78) !important;
      color: var(--text) !important;
      border-color: rgba(148,163,184,.18) !important;
      font-weight:600 !important;
    }
    .table-pro tbody tr:hover > *{
      background-color: rgba(34,211,238,.12) !important;
      color:#fff !important;
    }

    .badge-role{
      background: rgba(34,197,94,.12);
      border:1px solid rgba(34,197,94,.35);
      color:#bbf7d0;
      font-weight:700;
      letter-spacing:.3px;
    }

    .alert{
      border-radius: .9rem;
      border:1px solid transparent;
      background: rgba(2,6,23,.6);
      color:#e2e8f0;
    }
    .alert-success{ border-color: rgba(34,197,94,.5); }
    .alert-danger{ border-color: rgba(239,68,68,.5); }
    .alert-warning{ border-color: rgba(250,204,21,.5); }

    .section-title{
      display:flex; align-items:center; justify-content:space-between;
      gap:1rem; margin-bottom:1rem;
    }

    @media (max-width: 991px){
      .sticky-lg-top { position: static !important; top:auto !important; }
    }
  </style>
</head>

<body>
  <div class="container py-4 py-lg-5">

    <!-- HERO -->
    <div class="hero mb-4">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
          <div class="pill mb-2">🏟️ Panel de Control · Eventos Deportivos</div>
          <h1 class="hero-title">Gestión de Usuarios Administradores</h1>
          <p class="hero-sub">
            Crea, organiza y controla el acceso de tu equipo administrativo con seguridad y estilo.
          </p>
        </div>
        <div class="text-md-end">
          <a href="{{ route('register') }}" class="btn btn-ghost">
            ⬅ Volver al panel principal
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

          <form method="POST" action="{{ route('crear_usuario.store') }}" class="mt-3">
            @csrf

            <div class="mb-3">
              <label class="form-label">Nombre completo</label>
              <input type="text" name="name" class="form-control" placeholder="Ej: Camila Pérez" required>
              <div class="helper">Este nombre será visible en el panel.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Correo electrónico</label>
              <input type="email" name="email" class="form-control" placeholder="admin@tuevento.com" required>
              <div class="helper">Usa un email corporativo si es posible.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Contraseña</label>
              <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" minlength="6" required>
              <div class="helper">Recomendado: letras + números + símbolo.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirmar contraseña</label>
              <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la contraseña" minlength="6" required>
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
                             style="width:40px;height:40px;background:rgba(37,99,235,.18);border:1px solid rgba(37,99,235,.45);font-weight:800;">
                          {{ strtoupper(substr($a->name,0,1)) }}
                        </div>
                        <div>
                          <div class="fw-semibold text-light">{{ $a->name }}</div>
                          <div class="small text-muted">Administrador</div>
                        </div>
                      </div>
                    </td>

                    <td>{{ $a->email }}</td>

                    <td>
                      <span class="text-muted">
                        {{ $a->created_at->format('d M Y') }}
                      </span>
                    </td>

                    <!-- ✅ ACCIONES LIMPIAS (SIN MODAL AQUÍ) -->
                    <td class="text-end">
                      <div class="d-flex justify-content-end align-items-center gap-2 flex-wrap">

                        <!-- Botón abrir modal -->
                        <button
                          type="button"
                          class="btn btn-sm btn-outline-light"
                          style="border-radius:.7rem;border-color:rgba(34,197,94,.6);color:#bbf7d0;"
                          data-bs-toggle="modal"
                          data-bs-target="#modalPassword{{ $a->id }}"
                        >
                          🔑 Cambiar
                        </button>

                        <!-- Eliminar -->
                        <form action="{{ route('crear_usuario.destroy', $a->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button
                            class="btn btn-sm btn-outline-light"
                            style="border-radius:.7rem;border-color:rgba(239,68,68,.6);color:#fecaca;"
                            onclick="return confirm('¿Eliminar este usuario?')"
                          >
                            🗑️ Eliminar
                          </button>
                        </form>

                      </div>
                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-5">
              <div class="display-6 mb-2">👤</div>
              <p class="text-muted mb-0">No hay administradores aún.</p>
              <p class="text-muted small">Crea el primero desde el formulario.</p>
            </div>
          @endif

        </div>
      </div>

    </div>
  </div>

  <!-- ✅ MODALES FUERA DE LA TABLA (ARREGLO DEFINITIVO) -->
  @foreach($admins as $a)
    <div class="modal fade" id="modalPassword{{ $a->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pro-card p-3">
          <div class="modal-header border-0">
            <h5 class="modal-title text-light">Cambiar contraseña</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>

          <form action="{{ route('crear_usuario.updatePassword', $a->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="modal-body">
              <label class="form-label">Nueva contraseña para {{ $a->name }}</label>
              <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Nueva contraseña"
                minlength="6"
                required
                autofocus
              >
              <div class="helper">Mínimo 6 caracteres.</div>
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
</body>
</html>
