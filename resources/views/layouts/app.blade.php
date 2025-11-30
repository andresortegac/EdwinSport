<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Edwin Sport')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
  <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('/CSS/principal.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('CSS/panel.css') }}">  
    <link rel="stylesheet" href="{{ asset('CSS/canchas.css') }}"> 
    <link rel="stylesheet" href="{{ asset('CSS/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/password.css') }}">
   <link rel="stylesheet" href="{{ asset('CSS/agenda.css') }}">
   <link rel="stylesheet" href="{{ asset('CSS/import.css') }}">
   <link rel="stylesheet" href="{{ asset('CSS/bracket.css') }}">

  
    

</head>
<body>
  @include('partials.navbar')
  <main class="py-4">
    @yield('content')
  </main>
  <footer class="text-center py-4">© 2026 Edwin Sport</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('demo/tournament-navidad.js') }}"></script>
</body>
</html>
