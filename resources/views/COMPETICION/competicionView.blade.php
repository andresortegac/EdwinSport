<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competición</title>

    <!-- CSS independiente -->
    <link rel="stylesheet" href="{{ asset('css/competicion.css') }}">
</head>
<body>

    <div class="top-bar">
        <a href="{{ route('usuario.panel') }}" class="btn-back">←</a>
    </div>

    <!-- Imagen superior -->
    <div class="header-image">
        <img src="{{ asset('img/slider/slider0.png') }}" alt="Imagen superior">
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

    <!-- Contenido debajo -->
    <div class="content">
        <h1>Pantalla de Competicion</h1>
    </div>

</body>
</html>
