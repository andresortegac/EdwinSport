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

  <style>
    :root{
      --bg:#070b16;
      --bg2:#0b1020;
      --bg3:#0f172a;
      --line:rgba(148,163,184,.18);

      --c1:#22d3ee; /* cyan */
      --c2:#0ea5e9; /* sky */
      --c3:#2563eb; /* blue */
      --danger:#ef4444;

      --text:#e2e8f0;
      --muted:#94a3b8;
    }

    body{
      min-height:100vh;
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: var(--text);
      display:grid;
      place-items:center;
      position:relative;
      overflow:hidden;

      /* IMAGEN DE FONDO FULLSCREEN */
      background:
        url("https://images.unsplash.com/photo-1547347298-4074fc3086f0?q=80&w=1600&auto=format&fit=crop")
        center/cover no-repeat fixed;
    }

    /* OVERLAY OSCURO + DEGRADADO */
    body::before{
      content:"";
      position:absolute; inset:0;
      background:
        radial-gradient(1200px 700px at 10% -10%, rgba(34,211,238,.22), transparent 60%),
        radial-gradient(1000px 650px at 105% 0%, rgba(37,99,235,.22), transparent 55%),
        linear-gradient(180deg, rgba(2,6,23,.55), rgba(2,6,23,.9));
      z-index:0;
    }

    /* CARD LOGIN CENTRADA */
    .login-card{
      width:100%;
      max-width: 460px;
      background: linear-gradient(180deg, rgba(15,23,42,.92), rgba(11,18,38,.96));
      border:1px solid var(--line);
      border-radius: 1.6rem;
      box-shadow: 0 20px 70px rgba(0,0,0,.7);
      padding: 2.2rem 2.2rem;
      backdrop-filter: blur(10px);
      animation: fadeUp .45s ease;
      position:relative;
      z-index:1;
      overflow:hidden;
    }
    .login-card::after{
      content:"";
      position:absolute;
      right:-120px; top:-160px;
      width:360px; height:360px; border-radius:999px;
      background: radial-gradient(circle, rgba(34,211,238,.35), transparent 60%);
      filter: blur(45px);
      opacity:.8;
      pointer-events:none;
    }

    /* âœ… BADGE MÃS GRANDE */
    .brand-badge{
      display:inline-flex; 
      align-items:center; 
      gap:.65rem;

      padding:.55rem 1.15rem;          /* mÃ¡s alto y ancho */
      border-radius:999px;

      font-weight:900; 
      letter-spacing:.6px; 
      font-size:1.05rem;               /* antes .8rem */

      color:#e6fbff;
      background:linear-gradient(135deg, rgba(34,211,238,.14), rgba(37,99,235,.14));
      border:1.5px solid rgba(34,211,238,.75);  /* mÃ¡s grueso */

      box-shadow:
        0 0 6px rgba(34,211,238,.8),
        0 0 14px rgba(14,165,233,.55);
    }

    .brand-title{
      font-family: Oswald, Inter, sans-serif;
      font-weight:600;
      letter-spacing:.8px;
      font-size: clamp(1.7rem, 2.2vw, 2.1rem);
      color:#fff;
      margin-top:.8rem;
    }
    .brand-sub{
      color: var(--muted);
      font-size:.98rem;
      margin-top:.25rem;
      line-height:1.4;
    }

    /* INPUTS con icono */
    .form-label{
      font-weight:700; color:#cbd5e1; font-size:.9rem;
      letter-spacing:.3px;
    }
    .input-wrap{ position:relative; }
    .input-icon{
      position:absolute; left:14px; top:50%; transform:translateY(-50%);
      font-size:1rem; opacity:.85; color:#cbd5e1;
      pointer-events:none;
    }
    .form-control{
      background: rgba(2,6,23,.8);
      border:1px solid rgba(148,163,184,.28);
      color: var(--text);
      border-radius: 1rem;
      padding: .9rem .95rem .9rem 2.5rem;
      font-size: 1rem;
      transition: .18s ease;
    }
    .form-control::placeholder{ color:#94a3b8; }
    .form-control:focus{
      color:#fff;
      background: rgba(2,6,23,.95);
      border-color: rgba(34,211,238,.85);
      box-shadow: 0 0 0 .25rem rgba(34,211,238,.12);
    }

    .btn-brand{
      background: linear-gradient(135deg, var(--c2), var(--c3));
      border:none; color:white;
      font-weight:800; letter-spacing:.3px;
      border-radius: 1rem;
      padding:.9rem 1rem;
      box-shadow: 0 12px 26px rgba(14,165,233,.4);
      transition: transform .1s ease, filter .12s ease;
    }
    .btn-brand:hover{ filter: brightness(1.08); transform: translateY(-1px); }

    /* âœ… BOTÃ“N VOLVER NEÃ“N CIAN/AZUL */
    .btn-soft{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:.35rem;

      border-radius: 1rem;
      font-weight:800;
      padding:.75rem 1rem;

      color:#e6fbff;
      text-decoration:none;

      background: rgba(14,165,233,.08); /* sky suave */
      border:1px solid rgba(34,211,238,.9); /* cyan */

      box-shadow:
        0 0 6px rgba(34,211,238,.95),
        0 0 14px rgba(14,165,233,.75),
        0 0 30px rgba(37,99,235,.55);

      transition: .15s ease;
    }

    .btn-soft:hover{
      transform: translateY(-1px) scale(1.02);
      background: rgba(14,165,233,.18);

      box-shadow:
        0 0 8px rgba(34,211,238,1),
        0 0 18px rgba(14,165,233,.95),
        0 0 38px rgba(37,99,235,.8);
    }

    .small-note{
      font-size:.82rem; color: var(--muted);
      text-align:center; margin-top: 1.1rem;
    }

    /* responsive extra */
    @media (max-width: 480px){
      .login-card{ padding: 1.6rem 1.5rem; border-radius: 1.25rem; }
    }

    @keyframes fadeUp{
      from{ opacity:0; transform: translateY(10px) scale(.98); }
      to{ opacity:1; transform: translateY(0) scale(1); }
    }
  </style>
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>

<body>

  <div class="login-card">

    <div class="text-center mb-4 position-relative" style="z-index:2;">
      <div class="brand-badge">ðŸ† EDWIN SPORT Â· PRO</div>
      <div class="brand-title">Ingresar al Sistema</div>
      <div class="brand-sub">
        Acceso exclusivo para gestiÃ³n de eventos deportivos
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
          <span class="input-icon">ðŸ“§</span>
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
        <label class="form-label">ContraseÃ±a / CÃ³digo</label>
        <div class="input-wrap">
          <span class="input-icon">ðŸ”’</span>
          <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Ingresa tu contraseÃ±a"
            required
          />
        </div>
      </div>

      <button type="submit" class="btn btn-brand w-100 mt-2">
        Entrar
      </button>

      <!-- âœ… VOLVER DEBAJO DE ENTRAR -->
    <a href="{{ url('/') }}" class="btn-soft w-100 mt-3">
  â† Volver
</a>


    </form>

    <div class="small-note">
      Sistema de eventos deportivos âš½ðŸ€ðŸ
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

