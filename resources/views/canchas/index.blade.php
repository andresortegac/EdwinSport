@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">
<link rel="stylesheet" href="{{ asset('CSS/canchas-index.css') }}">
@endpush

@section('content')
@php
    $totalComplejos = $canchas->count();
    $totalEspacios = $canchas->sum(fn($c) => (int)($c->num_canchas ?? 1));
    $ubicaciones = $canchas->pluck('ubicacion')->filter()->unique()->count();
    $gallery = [
        'img/cancha.jpg',
        'img/cancha vertical.jpg',
        'img/slider/slider0.png',
        'img/slider/slider1.png',
        'img/slider/slider2.png',
    ];
@endphp

<div class="canchas-page py-4 py-lg-5">
    <div class="container">
        <section class="canchas-hero mb-4 mb-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <p class="eyebrow mb-2">CONVENIOS Y RESERVAS</p>
                    <h1>Encuentra canchas disponibles para entrenar, competir y organizar tu agenda deportiva.</h1>
                    <p class="hero-copy">Explora espacios aliados con informacion clara de horario, ubicacion y capacidad. Reserva en minutos y manten un mejor control de tus actividades.</p>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="#listado-canchas" class="btn btn-brand btn-lg">Ver canchas</a>
                        <a href="{{ route('contactenos') }}" class="btn btn-outline-brand btn-lg">Solicitar convenio</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-stats">
                        <h4 class="mb-3">Resumen actual</h4>
                        <div class="stats-grid">
                            <div class="stat-line">
                                <span>{{ $totalComplejos }}</span>
                                <p>Complejos registrados</p>
                            </div>
                            <div class="stat-line">
                                <span>{{ $totalEspacios }}</span>
                                <p>Espacios deportivos</p>
                            </div>
                            <div class="stat-line">
                                <span>{{ $ubicaciones }}</span>
                                <p>Ubicaciones activas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="benefits-wrap mb-4 mb-lg-5">
            <div class="row g-3">
                <div class="col-md-4">
                    <article class="benefit-card h-100">
                        <i class="bi bi-clock-history"></i>
                        <h3>Horarios organizados</h3>
                        <p>Consulta disponibilidad por franja horaria para planificar mejor cada jornada.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="benefit-card h-100">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Ubicacion clara</h3>
                        <p>Visualiza donde se encuentra cada cancha y selecciona la opcion mas conveniente.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="benefit-card h-100">
                        <i class="bi bi-people"></i>
                        <h3>Gestion para equipos</h3>
                        <p>Ideal para escuelas, ligas y grupos que requieren reservas recurrentes y control.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="listado-canchas" class="mb-4 mb-lg-5">
            <div class="section-head d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <p class="eyebrow mb-1">LISTADO DISPONIBLE</p>
                    <h2 class="mb-0">Canchas asociadas</h2>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($canchas as $cancha)
                    @php
                        $img = $gallery[$loop->index % count($gallery)];
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <article class="cancha-card h-100">
                            <img src="{{ asset($img) }}" class="cancha-cover" alt="Imagen de cancha {{ $cancha->nombre }}">

                            <div class="cancha-body d-flex flex-column">
                                <h3>{{ $cancha->nombre }}</h3>

                                <ul class="cancha-meta list-unstyled mb-3">
                                    <li><i class="bi bi-geo"></i> {{ $cancha->ubicacion ?: 'Ubicacion por definir' }}</li>
                                    <li><i class="bi bi-clock"></i> {{ $cancha->hora_apertura }} - {{ $cancha->hora_cierre }}</li>
                                    <li><i class="bi bi-grid"></i> {{ $cancha->num_canchas ?? 1 }} espacios</li>
                                </ul>

                                <div class="mt-auto d-flex flex-wrap gap-2">
                                    <a href="{{ route('canchas.show', $cancha->id) }}" class="btn btn-outline-brand btn-sm">Ver agenda</a>
                                    <a href="{{ route('user_reservas.create', $cancha->id) }}" class="btn btn-brand btn-sm">Reservar</a>
                                </div>

                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-box">
                            <h4>No hay canchas registradas.</h4>
                            <p>Agrega una nueva cancha para comenzar a gestionar reservas y disponibilidad.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="info-band">
            <div class="row g-4 align-items-center">
                <div class="col-lg-8">
                    <p class="eyebrow mb-2">GESTION EFICIENTE</p>
                    <h3>Mejora el uso de tus escenarios deportivos con reservas mejor organizadas.</h3>
                    <p class="mb-0">Centraliza horarios, evita cruces y ofrece una experiencia profesional para deportistas y administradores.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('contactenos') }}" class="btn btn-brand btn-lg">Hablar con soporte</a>
                </div>
            </div>
        </section>
    </div>

</div>
@endsection
