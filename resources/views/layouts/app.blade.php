<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Edwin Sport')</title>

  {{-- Bootstrap 5 --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Estilos base del sitio --}}
  <link rel="stylesheet" href="{{ asset('CSS/principal.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/views/layouts/app.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">

  {{-- Librerias visuales compartidas --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  {{-- Estilos propios de cada vista --}}
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

  {{-- ðŸ‘‡ NUEVO: scripts extra por vista (si algÃºn dÃ­a los necesitas) --}}
  @stack('scripts')
</body>
</html>
