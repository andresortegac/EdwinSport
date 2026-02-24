<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidos</title>

    <!-- CSS independiente -->
    <link rel="stylesheet" href="{{ asset('css/partidos.css') }}">
  <link rel="stylesheet" href="{{ asset('CSS/unified-font.css') }}">
</head>
<body>

    <div class="top-bar">
        <a href="{{ route('principal') }}" class="btn-back">â†</a>
    </div>

    <!-- Imagen superior -->
    <div class="header-image">
        <img src="{{ asset('img/slider/slider0.png') }}" alt="">
    </div>

    <!-- Menu -->
    <div class="menu">
        <a href="{{ route('competicion') }}"
           class="{{ request()->routeIs('competicion') ? 'active' : '' }}">
            CompeticiÃ³n
        </a>

        <a href="{{ route('partidos') }}"
           class="{{ request()->routeIs('partidos') ? 'active' : '' }}">
            Partidos
        </a>
    </div>

    <!-- Contenido de la seccion -->
    <div class="content">
        <h1>Pantalla de Partidos</h1>

        <p>AquÃ­ puedes mostrar la lista de partidos, calendario o prÃ³ximos encuentros.</p>
    </div>

</body>
</html>

