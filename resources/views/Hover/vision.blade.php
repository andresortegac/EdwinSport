@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Vision</h1>
    <p style="font-size: 18px;">
        Transformar la manera en que el mundo se equipa para el deporte. Ser reconocidos globalmente como el referente de la innovación, la sostenibilidad y la excelencia en el retail deportivo, liderando la industria a través de la tecnología, la diversidad de productos y el compromiso inquebrantable con la comunidad atlética.
Ser el líder regional en la prestación de servicios deportivos de alto impacto, reconocido por nuestra excelencia operativa en la gestión de eventos y por ser el motor principal en la formación de futuros atletas y la promoción de una cultura deportiva sostenible y accesible para todos.
Ser la plataforma líder y referente mundial en la organización de competiciones deportivas, reconocida por la innovación en la gestión de eventos, la integridad de nuestros torneos y la capacidad de transformar cada competición en un hito memorable para atletas, aficionados y patrocinadores.
Ser la academia deportiva líder a nivel nacional (o regional), reconocida por ser la incubadora de talento más exitosa, produciendo consistentemente atletas de élite y, más importante aún, jóvenes que demuestran liderazgo, ética y excelencia en todas las facetas de sus vidas.
    </p>

    <a href="{{ route('about') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
