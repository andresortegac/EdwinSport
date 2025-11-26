<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visión - Edwin Sport</title>

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

        <h1 class="fw-bold mb-4">Visión</h1>

       <div class="custom-card p-4">
            <p class="fs-5 mb-0">
                Transformar la manera en que el mundo se equipa para el deporte. Ser reconocidos globalmente como el referente de la innovación, la sostenibilidad y la excelencia en el retail deportivo, liderando la industria a través de la tecnología, la diversidad de productos y el compromiso inquebrantable con la comunidad atlética.
                Ser el líder regional en la prestación de servicios deportivos de alto impacto, reconocido por nuestra excelencia operativa en la gestión de eventos y por ser el motor principal en la formación de futuros atletas y la promoción de una cultura deportiva sostenible y accesible para todos.
                Ser la plataforma líder y referente mundial en la organización de competiciones deportivas, reconocida por la innovación en la gestión de eventos, la integridad de nuestros torneos y la capacidad de transformar cada competición en un hito memorable para atletas, aficionados y patrocinadores.
                Ser la academia deportiva líder a nivel nacional (o regional), reconocida por ser la incubadora de talento más exitosa, produciendo consistentemente atletas de élite y, más importante aún, jóvenes que demuestran liderazgo, ética y excelencia en todas las facetas de sus vidas.</p>
        </div>

        <a href="{{ route('about') }}" class="btn btn-secondary mt-4">← Volver</a>
    </div>

</body>
</html>
