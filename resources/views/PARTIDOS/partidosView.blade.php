<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidos</title>

    <!-- CSS independiente -->
    <link rel="stylesheet" href="{{ asset('css/partidos.css') }}">
</head>
<body>

    <div class="top-bar">
        <a href="{{ route('principal') }}" class="btn-back">←</a>
    </div>

    <!-- Imagen superior -->
    <div class="header-image">
        <img src="{{ asset('img/slider/slider0.png') }}" alt="">
    </div>

    <!-- Menu -->
    <div class="menu">
        <a href="{{ route('competicion') }}"
           class="{{ request()->routeIs('competicion') ? 'active' : '' }}">
            Competición
        </a>

        <a href="{{ route('partidos') }}"
           class="{{ request()->routeIs('partidos') ? 'active' : '' }}">
            Partidos
        </a>
    </div>

    <!-- Contenido de la seccion -->
    <div class="content">
        <h1>Pantalla de Partidos</h1>

        <p>Aquí puedes mostrar la lista de partidos, calendario o próximos encuentros.</p>
    </div>

</body>
</html>
