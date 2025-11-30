<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ isset($participante) ? 'Editar Participante' : 'Crear Participante' }}</title>

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
    }
    .form-label{ font-weight:600; }
    .form-control{
      background:#0b1020; border:1px solid var(--line); color:var(--text);
    }
    .form-control:focus{
      background:#0b1020; color:var(--text); border-color:rgba(14,165,233,.6);
      box-shadow:0 0 0 .2rem rgba(14,165,233,.15);
    }

    /* tabla */
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
</head>
<body>

<div class="container py-5">
  <div class="pro-card">

    @php
      $isEdit = isset($participante);
    @endphp

    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h1 class="mb-1" style="font-family: Oswald;">
          {{ $isEdit ? '✏️ Editar Participante' : '➕ Nuevo Participante' }}
        </h1>
        <p class="muted mb-0">
          {{ $isEdit ? 'Actualiza los datos.' : 'Registra un nuevo participante.' }}
        </p>
      </div>

      <!-- ✅ VOLVER A LA VISTA ANTERIOR -->
      <a href="{{ url()->previous() }}" class="btn btn-soft">← Volver</a>
    </div>

    <form method="POST"
          action="{{ $isEdit ? route('participantes.update', $participante->id) : route('participantes.store') }}"
          class="row g-3">
      @csrf
      @if($isEdit)
        @method('PUT')
      @endif

      <div class="col-md-6">
        <label class="form-label">Nombre *</label>
        <input type="text" name="nombre" class="form-control" required
               value="{{ old('nombre', $isEdit ? $participante->nombre : '') }}">
        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Evento *</label>
        <input type="text" name="evento" class="form-control" required
               value="{{ old('evento', $isEdit ? $participante->evento : '') }}">
        @error('evento') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-2">
        <label class="form-label">Edad</label>
        <input type="number" name="edad" class="form-control"
               value="{{ old('edad', $isEdit ? $participante->edad : '') }}">
        @error('edad') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-5">
        <label class="form-label">Equipo</label>
        <input type="text" name="equipo" class="form-control"
               value="{{ old('equipo', $isEdit ? $participante->equipo : '') }}">
        @error('equipo') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-5">
        <label class="form-label">División</label>
        <input type="text" name="division" class="form-control"
               value="{{ old('division', $isEdit ? $participante->division : '') }}">
        @error('division') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $isEdit ? $participante->email : '') }}">
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control"
               value="{{ old('telefono', $isEdit ? $participante->telefono : '') }}">
        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 d-flex gap-2 mt-2">
        <button class="btn btn-brand">
          {{ $isEdit ? 'Actualizar' : 'Guardar' }}
        </button>

        <!-- ✅ CANCELAR TAMBIÉN VUELVE ATRÁS -->
        <a href="{{ url()->previous() }}" class="btn btn-soft">Cancelar</a>
      </div>

    </form>

    <hr class="my-4">

    @if(session('ok'))
      <div class="alert alert-success">
        {{ session('ok') }}
      </div>
    @endif

    <h3 style="font-family: Oswald;" class="mb-3">📋 Participantes Registrados</h3>

    @if(isset($participantes) && $participantes->count())
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Evento</th>
              <th>Edad</th>
              <th>Equipo</th>
              <th>División</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($participantes as $p)
              <tr>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->evento }}</td>
                <td>{{ $p->edad ?? '-' }}</td>
                <td>{{ $p->equipo ?? '-' }}</td>
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
                        onsubmit="return confirm('¿Eliminar participante?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                  </form>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="muted">Aún no hay participantes registrados.</p>
    @endif

  </div>
</div>

</body>
</html>
