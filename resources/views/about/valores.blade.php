<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valores - Edwin Sport</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/CSS/principal.css') }}">

    <style>
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5 fade-in">

        <h1 class="fw-bold mb-4">Valores</h1>

        <div class="custom-card p-4">
            <p class="fs-5 mb-0">
                3.1 Excelencia en el Producto: Compromiso con la calidad, la durabilidad y la funcionalidad, asegurando que cada artículo cumpla con los más altos estándares de rendimiento.
 3.2 Pasión por el Deporte: Vivir y respirar la cultura deportiva, entendiendo profundamente las necesidades de nuestros clientes y las exigencias de cada disciplina.
 3.3 Innovación Constante: Buscar e integrar proactivamente nuevas tecnologías y materiales para ofrecer soluciones de vanguardia en equipos y vestimenta deportiva.
 3.4 Integridad y Transparencia: Actuar con honestidad en todas las interacciones, desde la calidad de los productos hasta la comunicación con los clientes y socios.
 3.5 Foco en el Cliente: Poner al cliente en el centro de todas las operaciones, proporcionando un servicio especializado, asesoramiento experto y una experiencia de compra fluida.
3.6 Inclusión y Accesibilidad: Garantizar que el deporte sea una actividad disponible para personas de todas las edades, habilidades y condiciones socioeconómicas.
 3.7 Profesionalismo y Calidad: Aplicar los más altos estándares de gestión en la organización de cada evento, programa de entrenamiento y administración de instalaciones.
 3.8 Desarrollo Integral: Enfocarse no solo en el rendimiento físico, sino también en el desarrollo de valores como el trabajo en equipo, la disciplina y el respeto en nuestros participantes.
 3.9 Seguridad y Bienestar: Priorizar la integridad física y emocional de los atletas y participantes en todas nuestras actividades y entornos deportivos.
 3.10 Pasión por el Deporte: Transmitir entusiasmo y compromiso con la actividad física, siendo agentes de cambio positivo en la comunidad.
3.11 Integridad Competitiva: Actuar con imparcialidad, transparencia y estricto apego a las reglas, asegurando que la competencia sea justa y equitativa para todos los participantes.
 3.12 Excelencia Operacional: Buscar la perfección en cada detalle de la planificación y ejecución del evento, desde la logística hasta la experiencia del espectador.
 3.13 Innovación en Eventos: Adoptar tecnologías y estrategias creativas para mejorar la experiencia de atletas y aficionados, optimizando la gestión y la difusión de los torneos.
 3.14 Seguridad y Bienestar: Priorizar la protección de los atletas, el personal y los asistentes, creando un ambiente seguro en todas las sedes del evento.
 3.15 Compromiso Comunitario: Utilizar los torneos como vehículos para inspirar la participación deportiva y dejar un legado positivo en las comunidades anfitrionas.
3.16 Disciplina: Fomentar el rigor y la constancia necesarios para el éxito tanto en el deporte como en la vida.
 3.17 Excelencia Técnica: Compromiso con la enseñanza de las mejores prácticas y métodos de entrenamiento actualizados.
 3.18 Respeto: Promover el respeto hacia los entrenadores, compañeros, rivales y las reglas del juego.
 3.19 Integridad: Inculcar la honestidad y la ética en la competición y en el comportamiento diario.
 3.20 Desarrollo Integral: Valorar el rendimiento académico, el bienestar mental y la responsabilidad social al mismo nivel que el logro deportivo.
            </p>
        </div>

        <a href="{{ route('about') }}" class="btn btn-secondary mt-4">← Volver</a>
    </div>

</body>
</html>
