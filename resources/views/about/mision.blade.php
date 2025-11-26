<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misión - Edwin Sport</title>

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

        <h1 class="fw-bold mb-4">Misión</h1>

        
        <div class="custom-card p-4">
            <p class="fs-5 mb-0">
                Ser el principal proveedor de productos deportivos de alta calidad y rendimiento, inspirando y equipando a atletas y entusiastas de todos los niveles para que alcancen su máximo potencial. Nos dedicamos a ofrecer una experiencia de compra excepcional, innovadora y especializada, garantizando que cada cliente encuentre el equipo perfecto para su disciplina, desde la vestimenta hasta los accesorios técnicos. 
Enriquecer la vida de las personas y las comunidades a través del deporte, ofreciendo servicios integrales de la más alta calidad. es organizar y gestionar eventos deportivos, escuelas y programas de entrenamiento que fomenten la participación, promuevan estilos de vida saludables y desarrollen el talento atlético en un entorno seguro, inclusivo y profesional.
Crear y ejecutar experiencias de competición deportivas inolvidables que inspiren la excelencia, fomenten el fair play (juego limpio) y unan a las comunidades. Nos dedicamos a la organización impecable de torneos y eventos, garantizando la equidad, la seguridad y la máxima calidad de producción, desde ligas locales hasta competiciones de alto nivel.
Formar atletas de alto rendimiento y ciudadanos ejemplares, utilizando el deporte como una herramienta fundamental para el desarrollo integral. Nuestra misión es impartir una instrucción técnica de vanguardia, promover valores como la disciplina, el respeto y la perseverancia, y crear un ambiente de aprendizaje positivo que maximice el potencial deportivo y personal de cada estudiante-atleta.
            </p>
        </div>


        <a href="{{ route('about') }}" class="btn btn-secondary mt-4">← Volver</a>
    </div>

</body>
</html>
