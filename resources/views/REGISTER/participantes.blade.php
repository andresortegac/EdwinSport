<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Equipos y Participantes</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{ --bg:#070b16; --bg-2:#0b1020; --bg-3:#0f172a; --line:rgba(148,163,184,.14);
      --text:#e2e8f0; --muted:#94a3b8; --c2:#0ea5e9; --c3:#2563eb; }
    body{
      font-family: Inter, system-ui, sans-serif; color:var(--text);
      background: linear-gradient(180deg, var(--bg), var(--bg-2) 45%, var(--bg-3) 100%);
      min-height:100vh;
    }
    .pro-card{
      background: linear-gradient(180deg, rgba(15,23,42,.9), rgba(11,18,38,.95));
      border:1px solid var(--line); border-radius:1.3rem; box-shadow:0 12px 30px rgba(0,0,0,.45);
      padding:1.5rem;
    }
    .muted{ color:var(--muted); }

    .btn-brand{
      background: linear-gradient(135deg, var(--c2), var(--c3));
      border:none;color:white;font-weight:800;letter-spacing:.3px;
      border-radius: .95rem; padding:.6rem 1rem;
      box-shadow: 0 10px 24px rgba(14,165,233,.35);
    }
    .btn-soft{
      border-radius:.95rem;font-weight:700;padding:.55rem 1rem;
      border:1px solid rgba(148,163,184,.35); color:var(--text); background:transparent;
      text-decoration:none;
    }
    .btn-sep{
      background: linear-gradient(135deg,#2563eb,#0ea5e9);
      border:none;color:white;font-weight:900;letter-spacing:.4px;
      border-radius: 1.1rem; padding:.8rem 1.2rem;
      width: 100%;
      box-shadow: 0 12px 28px rgba(37,99,235,.45);
      text-transform: uppercase;
    }

    .form-label{ font-weight:600; }
    .form-control, .form-select{
      background:#0b1020; border:1px solid var(--line); color:var(--text);
    }
    .form-control:focus, .form-select:focus{
      background:#0b1020; color:var(--text); border-color:rgba(14,165,233,.6);
      box-shadow:0 0 0 .2rem rgba(14,165,233,.15);
    }

    .divider{
      height:1px; background:var(--line); margin:1.2rem 0;
    }

    .table-dark{
      --bs-table-bg: transparent;
      --bs-table-striped-bg: rgba(255,255,255,.03);
      --bs-table-hover-bg: rgba(255,255,255,.05);
      color: var(--text);
      border-color: var(--line);
    }
    .table thead th{
      color:#cbd5e1; font-weight:700; border-bottom:1px solid var(--line);
    }
    .table td, .table th{
      border-top:1px solid var(--line);
    }
  </style>
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>
<body>

@php
    // Si no viene definida desde el include, por defecto es false
    $hideBackButton = $hideBackButton ?? false;
@endphp

<div class="container py-5">
  <div class="pro-card">

    {{-- âœ… MENSAJES DE Ã‰XITO (equipos y participantes) --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('mensaje'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- âœ… NUEVO: mensajes que vienen como "ok" (store/update/destroy/import) --}}
    @if(session('ok'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('ok') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif


    {{-- =========================
         1) FORMULARIO EQUIPO
       ========================= --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h1 class="mb-1" style="font-family: Oswald;">ðŸ·ï¸ Crear / Editar Equipo</h1>
        <p class="muted mb-0">Registra el equipo primero, luego agrega jugadores.</p>
      </div>

      {{-- âœ… ESTE botÃ³n vuelve al register
           Se oculta SOLO cuando $hideBackButton == true (desde usuario.panel) --}}
      @if (! $hideBackButton)
        <a href="{{ route('register') }}" class="btn btn-soft">â† Volver</a>
      @endif
    </div>

    @php $isEditEquipo = isset($equipo); @endphp

    <form method="POST"
          action="{{ $isEditEquipo ? route('equipos.update', $equipo->id) : route('equipos.store') }}"
          class="row g-3">
      @csrf
      @if($isEditEquipo)
        @method('PUT')
      @endif

      {{-- âœ… EVENTO ahora es SELECT --}}
      <div class="col-md-6">
        <label class="form-label">Evento *</label>
        <select name="evento" class="form-select" required>
          <option value="">-- Selecciona evento --</option>
          @foreach($eventos as $ev)
            <option value="{{ $ev->title }}"
              {{ old('evento', $isEditEquipo ? $equipo->evento : '') == $ev->title ? 'selected' : '' }}>
              {{ $ev->title }}
            </option>
          @endforeach
        </select>
        @error('evento') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Nombre Equipo *</label>
        <input type="text" name="nombre_equipo" class="form-control" required
               value="{{ old('nombre_equipo', $isEditEquipo ? $equipo->nombre_equipo : '') }}">
        @error('nombre_equipo') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">NIT *</label>
        <input type="text" name="nit" class="form-control" required
               value="{{ old('nit', $isEditEquipo ? $equipo->nit : '') }}">
        @error('nit') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">DirecciÃ³n *</label>
        <input type="text" name="direccion" class="form-control" required
               value="{{ old('direccion', $isEditEquipo ? $equipo->direccion : '') }}">
        @error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">TelÃ©fono (Equipo) *</label>
        <input type="text" name="telefono_equipo" class="form-control" required
               value="{{ old('telefono_equipo', $isEditEquipo ? $equipo->telefono_equipo : '') }}">
        @error('telefono_equipo') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">E-mail (Equipo) *</label>
        <input type="email" name="email_equipo" class="form-control" required
               value="{{ old('email_equipo', $isEditEquipo ? $equipo->email_equipo : '') }}">
        @error('email_equipo') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">Valor de inscripciÃ³n *</label>
        <input type="number" name="valor_inscripcion" class="form-control" required
               value="{{ old('valor_inscripcion', $isEditEquipo ? $equipo->valor_inscripcion : '') }}">
        @error('valor_inscripcion') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-3">
        <label class="form-label">Nombre DT *</label>
        <input type="text" name="nombre_dt" class="form-control" required
               value="{{ old('nombre_dt', $isEditEquipo ? $equipo->nombre_dt : '') }}">
        @error('nombre_dt') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      {{-- âœ… BOTÃ“N AZUL SEPARADOR --}}
      <div class="col-12 mt-2">
        <button type="submit" class="btn-sep">
          ðŸ’¾ Guardar Equipo
        </button>
      </div>
    </form>

    <div class="divider"></div>

    {{-- =========================
         2) FORMULARIO JUGADORES
       ========================= --}}
    <div class="mb-3">
      <h2 style="font-family: Oswald;" class="mb-1">ðŸ‘¤ Agregar Jugadores / Participantes</h2>
      <p class="muted mb-0">Selecciona un equipo ya creado y registra jugadores.</p>
    </div>

    @php $isEditPart = isset($participante); @endphp

    <form method="POST"
          action="{{ $isEditPart ? route('participantes.update', $participante->id) : route('participantes.store') }}"
          class="row g-3">
      @csrf
      @if($isEditPart)
        @method('PUT')
      @endif

      <div class="col-md-6">
        <label class="form-label">Equipo *</label>
        <select name="equipo_id" class="form-select" required>
          <option value="">-- Selecciona equipo --</option>
          @foreach($equipos as $e)
            <option value="{{ $e->id }}"
              {{ old('equipo_id', $isEditPart ? $participante->equipo_id : '') == $e->id ? 'selected':'' }}>
              {{ $e->nombre_equipo }}
            </option>
          @endforeach
        </select>
        @error('equipo_id') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Nombre Jugador *</label>
        <input type="text" name="nombre" class="form-control" required
               value="{{ old('nombre', $isEditPart ? $participante->nombre : '') }}">
        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      {{-- âœ… NUMERO CAMISA --}}
      <div class="col-md-2">
        <label class="form-label">NÂ° Camisa</label>
        <input type="text" name="numero_camisa" class="form-control"
               value="{{ old('numero_camisa', $isEditPart ? $participante->numero_camisa : '') }}">
        @error('numero_camisa') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      {{-- âŒ EVENTO ELIMINADO DE PARTICIPANTES --}}

      <div class="col-md-2">
        <label class="form-label">Edad</label>
        <input type="number" name="edad" class="form-control"
               value="{{ old('edad', $isEditPart ? $participante->edad : '') }}">
        @error('edad') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">DivisiÃ³n</label>
        <input type="text" name="division" class="form-control"
               value="{{ old('division', $isEditPart ? $participante->division : '') }}">
        @error('division') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $isEditPart ? $participante->email : '') }}">
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">TelÃ©fono</label>
        <input type="text" name="telefono" class="form-control"
               value="{{ old('telefono', $isEditPart ? $participante->telefono : '') }}">
        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 d-flex gap-2 mt-2">
        <button type="submit" class="btn btn-brand">
          {{ $isEditPart ? 'Actualizar Jugador' : 'Guardar Jugador' }}
        </button>

        {{-- cancelar a esta pantalla --}}
        <a href="{{ route('participantes.index') }}" class="btn btn-soft">Cancelar</a>
      </div>
    </form>

    <div class="divider"></div>

    {{-- =========================
         3) TABLA EQUIPOS + EDITAR + ELIMINAR âœ…
       ========================= --}}
    <h3 style="font-family: Oswald;" class="mb-3">ðŸ† Equipos Registrados</h3>

    @if(isset($equipos) && $equipos->count())
      <div class="table-responsive mb-4">
        <table class="table table-dark table-hover align-middle">
          <thead>
            <tr>
              <th>Evento</th>
              <th>Nombre Equipo</th>
              <th>NIT</th>
              <th>DirecciÃ³n</th>
              <th>TelÃ©fono</th>
              <th>E-mail</th>
              <th>Valor InscripciÃ³n</th>
              <th>Nombre DT</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($equipos as $e)
              <tr>
                <td>{{ $e->evento ?? '-' }}</td>
                <td>{{ $e->nombre_equipo }}</td>
                <td>{{ $e->nit }}</td>
                <td>{{ $e->direccion }}</td>
                <td>{{ $e->telefono_equipo }}</td>
                <td>{{ $e->email_equipo }}</td>
                <td>{{ $e->valor_inscripcion }}</td>
                <td>{{ $e->nombre_dt }}</td>

                <td class="text-end d-flex gap-2 justify-content-end">
                  <a href="{{ route('equipos.edit', $e->id) }}"
                     class="btn btn-sm btn-warning">
                    Editar equipo
                  </a>

                  <form action="{{ route('equipos.destroy', $e->id) }}"
                        method="POST"
                        onsubmit="return confirm('Â¿Eliminar equipo?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="muted">AÃºn no hay equipos registrados.</p>
    @endif


    {{-- =========================
         4) TABLA JUGADORES + IMPORT/EXPORT âœ…
       ========================= --}}
    <h3 style="font-family: Oswald;" class="mb-3">ðŸ“‹ Jugadores / Participantes</h3>

    {{-- âœ… EXPORTAR PLANILLA POR EQUIPO (EXCEL o PDF) --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
      <form method="GET" class="d-flex flex-wrap gap-2">
        <select name="equipo_id" class="form-select form-select-sm w-auto" required>
          <option value="">-- Selecciona equipo --</option>
          @foreach($equipos as $eq)
            <option value="{{ $eq->id }}">{{ $eq->nombre_equipo }}</option>
          @endforeach
        </select>

        <button formaction="{{ route('participantes.planilla.excel') }}" class="btn btn-brand">
          ðŸ“¤ Exportar Excel
        </button>

        <button formaction="{{ route('participantes.planilla.pdf') }}" class="btn btn-soft">
          ðŸ“„ Exportar PDF
        </button>
      </form>

      {{-- importaciÃ³n sigue igual --}}
      <form action="{{ route('participantes.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
        @csrf
        <input type="file" name="file" class="form-control form-control-sm" required>
        <button class="btn btn-soft" type="submit">
          ðŸ“¥ Importar Excel
        </button>
      </form>
    </div>

    @if(isset($participantes) && $participantes->count())
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
          <thead>
            <tr>
              <th>Jugador</th>
              <th>NÂ° Camisa</th>
              <th>Equipo</th>
              <th>Edad</th>
              <th>DivisiÃ³n</th>
              <th>Email</th>
              <th>TelÃ©fono</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($participantes as $p)
              <tr>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->numero_camisa ?? '-' }}</td>
                <td>{{ optional($p->equipo)->nombre_equipo ?? '-' }}</td>
                <td>{{ $p->edad ?? '-' }}</td>
                <td>{{ $p->division ?? '-' }}</td>
                <td>{{ $p->email ?? '-' }}</td>
                <td>{{ $p->telefono ?? '-' }}</td>

                <td class="text-end d-flex gap-2 justify-content-end">
                  <a href="{{ route('participantes.edit', $p->id) }}"
                     class="btn btn-sm btn-warning">
                    Editar
                  </a>

                  <form action="{{ route('participantes.destroy', $p->id) }}"
                        method="POST"
                        onsubmit="return confirm('Â¿Eliminar jugador?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="muted">AÃºn no hay jugadores registrados.</p>
    @endif

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

