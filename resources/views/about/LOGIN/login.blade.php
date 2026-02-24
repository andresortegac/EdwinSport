<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

  <title>Ingreso | Eventos Deportivos</title>

  <style>
    body {
      min-height: 100vh;
      background: radial-gradient(circle at top, #0ea5e9 0%, #0f172a 60%);
      font-family: system-ui, sans-serif;
    }
    .login-wrapper { min-height: 100vh; display: flex; }
    .login-left { flex: 1; display: grid; place-items: center; padding: 30px; }
    .login-card {
      width: 100%; max-width: 420px; background: #fff; border-radius: 18px;
      padding: 30px 28px; box-shadow: 0 20px 60px rgba(0,0,0,.35);
      animation: fadeIn .4s ease;
    }
    .brand-title { font-weight: 800; font-size: 1.8rem; color: #0f172a; }
    .brand-sub { color: #64748b; margin-top: 6px; font-size: .95rem; }
    .form-control {
      border-radius: 12px; padding: 12px 14px; border: 1.5px solid #cbd5e1;
      font-size: 1rem; transition: .2s;
    }
    .form-control:focus {
      border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.15);
    }
    .btn-primary {
      background: #22c55e; border: none; border-radius: 12px; font-weight: 700;
      padding: 12px; font-size: 1rem; transition: .2s;
      display:block; width:100%; text-align:center;
    }
    .btn-primary:hover { background: #16a34a; transform: translateY(-1px); text-decoration:none; }
    .small-note { font-size: .8rem; color: #94a3b8; text-align: center; margin-top: 12px; }

    .login-right {
      flex: 1;
      background: url("https://images.unsplash.com/photo-1547347298-4074fc3086f0?q=80&w=1600&auto=format&fit=crop") center/cover no-repeat;
      position: relative; display: none;
    }
    .login-right::after {
      content: ""; position: absolute; inset: 0; background: rgba(15, 23, 42, 0.65);
    }
    .right-content {
      position: relative; z-index: 2; color: #fff; height: 100%;
      display: grid; place-items: center; padding: 40px; text-align: center;
    }
    .right-content h1 { font-size: 2.2rem; font-weight: 800; }
    .right-content p { color: rgba(255,255,255,.85); font-size: 1.05rem; margin-top: 10px; }

    @media(min-width: 992px){ .login-right{ display:block; } }

    @keyframes fadeIn {
      from { opacity:0; transform: translateY(6px) scale(.98); }
      to { opacity:1; transform: translateY(0) scale(1); }
    }
  </style>
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

        {{-- BOTÃ“N QUE VA A REGISTER.register --}}
        <a href="{{ route('REGISTER.register') }}" class="btn btn-primary btn-block">
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

