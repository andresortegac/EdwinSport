<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Edwin Sport')</title>

  {{-- Bootstrap 5 --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Tu CSS principal --}}
  <link rel="stylesheet" href="{{ asset('CSS/principal.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">

  {{-- Iconos y otros estilos --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('CSS/panel.css') }}">  
  <link rel="stylesheet" href="{{ asset('CSS/canchas.css') }}"> 
  <link rel="stylesheet" href="{{ asset('CSS/tournament.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/password.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/agenda.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/import.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/bracket.css') }}">

  {{-- Estilo para las cajas de publicidad --}}
  <style>
    .ad-box {
        background: #ffffff;
        border: 1px solid #cbd3e3;
        border-radius: 10px;
        padding: 16px;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 0.9rem;
        color: #555;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
  </style>

  {{-- 👇 NUEVO: estilos extra por vista --}}
  @stack('styles')
</head>
<body>
  @include('partials.navbar')

  <main class="py-4">
    @yield('content')
  </main>

  @include('components.footer')

  {{-- (Opcional) JS de Bootstrap si no lo cargas en otro lado --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  {{-- 👇 NUEVO: scripts extra por vista (si algún día los necesitas) --}}
  @stack('scripts')
</body>
</html>
