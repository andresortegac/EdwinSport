<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

  <title>Ingreso | Eventos Deportivos</title>

    <link rel="stylesheet" href="{{ asset('CSS/views/about/login.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>

<body>
  <div class="login-wrapper">

    <!-- LEFT -->
    <div class="login-left">
      <div class="login-card">

        <div class="text-center mb-4">
          <div class="brand-title">Ingresar al Sistema</div>
          <div class="brand-sub">Acceso exclusivo para gestiÃ³n de eventos deportivos</div>
        </div>

        {{-- ERRORES --}}
        @if($errors->any())
          <div class="alert alert-danger py-2">
            {{ $errors->first() }}
          </div>
        @endif

        {{-- CAMPOS SOLO VISUALES --}}
        <div class="form-group">
          <label class="font-weight-bold">Usuario</label>
          <input
            type="text"
            name="username"
            class="form-control"
            placeholder="Ej: organizador"
            required
            autocomplete="off"
            value="{{ old('username') }}"
          />
        </div>

        <div class="form-group">
          <label class="font-weight-bold">ContraseÃ±a / CÃ³digo</label>
          <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Ingresa tu contraseÃ±a"
            required
          />
        </div>

        {{-- BOTON QUE VA A register --}}
        <a href="{{ route('register') }}" class="btn btn-primary btn-block">
  Entrar
</a>


        <div class="small-note">
          Sistema de eventos deportivos âš½ðŸ€ðŸ
        </div>
      </div>
    </div>

    <!-- RIGHT -->
    <div class="login-right">
      <div class="right-content">
        <div>
          <h1>Crea y organiza tus partidos</h1>
          <p>
            Publica eventos de fÃºtbol, voleibol, basket o desafÃ­os.<br>
            Administra cupos, fechas y lugares fÃ¡cilmente.
          </p>
        </div>
      </div>
    </div>

  </div>
</body>
</html>

