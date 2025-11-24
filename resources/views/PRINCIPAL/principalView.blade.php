<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-[#EFFEFB] text-gray-800 font-sans">

    {{-- NAVBAR --}}
    <nav class="flex items-center justify-between px-10 py-6 bg-white shadow-sm">
        <h1 class="text-2xl font-bold text-[#00A198]">SportFlow</h1>
        <div class="flex gap-6 text-lg">
            <a href="#" class="hover:text-[#00A198]">Inicio</a>
            <a href="#" class="hover:text-[#00A198]">Eventos</a>
            <a href="#" class="hover:text-[#00A198]">Escuelas</a>
            <a href="#" class="hover:text-[#00A198]">Contacto</a>
        </div>
        <a href="{{ route('login') }}" class="px-5 py-2 rounded-xl bg-[#00A198] text-white shadow-md hover:opacity-90">
            Ingresar
        </a>
    </nav>

    {{-- HERO --}}
    <section class="flex flex-col items-center text-center px-6 py-28">
        <h2 class="text-5xl font-extrabold text-[#003233] max-w-3xl leading-tight">
            Tu mundo deportivo en un solo lugar
        </h2>
        <p class="mt-6 text-xl text-gray-600 max-w-2xl">
            Explora eventos, rankings, escuelas deportivas y toda la actividad de tu ciudad.
        </p>
        <a href="{{ route('eventos.index') }}" class="mt-8 px-8 py-4 rounded-2xl bg-[#1DE4D1] text-[#003233] text-lg font-semibold shadow-md hover:opacity-90">
            Explorar ahora
        </a>
    </section>

    {{-- FEATURES --}}
    <section class="grid md:grid-cols-3 gap-10 px-10 pb-20">
        <div class="bg-white rounded-3xl p-8 shadow-lg border-t-4 border-[#00A198]">
            <h3 class="text-2xl font-bold mb-3 text-[#003233]">Eventos</h3>
            <p>Conoce todos los torneos y actividades deportivas disponibles.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border-t-4 border-[#1DE4D1]">
            <h3 class="text-2xl font-bold mb-3 text-[#003233]">Escuelas</h3>
            <p>Encuentra escuelas deportivas certificadas y sus programas.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border-t-4 border-[#003233]">
            <h3 class="text-2xl font-bold mb-3 text-[#003233]">Rankings</h3>
            <p>Revisa resultados oficiales y posiciones actualizadas.</p>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="text-center py-10 text-gray-600">
        © 2025 SportFlow — Todos los derechos reservados
    </footer>

</body>
</html>
