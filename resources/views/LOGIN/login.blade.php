<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <title>Ingreso | Eventos Deportivos</title>

    <link rel="stylesheet" href="{{ asset('CSS/views/auth/login.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>

<body>

  <div class="login-card">

    <div class="text-center mb-4 position-relative" style="z-index:2;">
      <div class="brand-badge">EDWIN SPORT · PRO</div>
      <div class="brand-title">Ingresar al Sistema</div>
      <div class="brand-sub">
        Acceso exclusivo para gestion de eventos deportivos
      </div>
    </div>

    {{-- ERRORES --}}
    @if($errors->any())
      <div class="alert py-2"
           style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.6);color:#fecaca;border-radius:.9rem;">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- FORM LOGIN REAL --}}
    <form method="POST" action="{{ route('login.post') }}" class="mt-3 position-relative" style="z-index:2;">
      @csrf

      <div class="mb-3">
        <label class="form-label">Correo</label>
        <div class="input-wrap">
          <span class="input-icon">@</span>
          <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Ej: developer@eventos.com"
            required
            autocomplete="off"
            value="{{ old('email') }}"
          />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Contrasena / Codigo</label>
        <div class="input-wrap">
          <span class="input-icon">*</span>
          <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Ingresa tu contrasena"
            required
          />
        </div>
      </div>

      <button type="submit" class="btn btn-brand w-100 mt-2">
        Entrar
      </button>

      <!-- VOLVER DEBAJO DE ENTRAR -->
    <a href="{{ url('/') }}" class="btn-soft w-100 mt-3">
  Volver
</a>


    </form>

    <div class="small-note">
      Sistema de eventos deportivos
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


