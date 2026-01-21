{{-- resources/views/events/sponsors.blade.php --}}
@extends('layouts.app')

@section('title', 'Patrocinadores')

@push('styles')
<style>
    /* Oculta la navbar pública SOLO en esta vista */
    nav.navbar {
        display: none !important;
    }

    body {
        padding-top: 0 !important;
        background: #020617;
    }

    main.py-4 {
        padding-top: 0 !important;
    }

    /* ===========================
       ESTILOS ESPECÍFICOS SPONSORS
    ============================ */
    .sponsors-page {
        min-height: 100vh;
        padding: 2.5rem 0 3rem;
        background: radial-gradient(circle at top, #0f172a 0, #020617 40%, #000 100%);
        color: #e5e7eb;
    }

    .sponsors-page .page-container {
        max-width: 1200px;
    }

    /* Cabecera */
    .sponsors-header {
        border-radius: 1.5rem;
        padding: 1.75rem 2rem;
        background: radial-gradient(circle at top left, #2563eb, #020617 55%);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(148, 163, 184, 0.4);
    }

    .sponsors-header-title {
        font-size: 2.1rem;
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    .sponsors-header p {
        color: #d1d5db;
        margin-bottom: 0;
    }

    .sponsors-badge {
        background: rgba(248, 250, 252, 0.9);
        color: #0f172a;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
    }

    .sponsors-updated-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #9ca3af;
    }

    .sponsors-updated-date {
        font-size: 0.9rem;
        font-weight: 600;
        color: #f9fafb;
    }

    /* Botón volver */
    .back-to-event-btn {
        border-radius: 999px;
        font-size: 0.85rem;
        padding: 0.4rem 0.9rem;
        border-color: rgba(148, 163, 184, 0.8);
        color: #e5e7eb;
    }

    .back-to-event-btn i {
        font-size: 0.95rem;
    }

    .back-to-event-btn:hover {
        border-color: #3b82f6;
        background: rgba(37, 99, 235, 0.15);
        color: #f9fafb;
    }

    /* Card contenedor principal */
    .sponsors-main-card {
        border-radius: 1.5rem;
        background: radial-gradient(circle at top left, #020617, #020617 55%, #030712 100%);
        border: 1px solid rgba(30, 64, 175, 0.35);
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.95);
    }

    /* Formulario */
    .sponsor-form-card {
        border-radius: 1.25rem;
        background: radial-gradient(circle at top left, #020617, #020617 55%, #020617 100%);
        border: 1px solid rgba(55, 65, 81, 0.8);
    }

    .sponsor-form-card h5 {
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #e5e7eb;
        margin-bottom: 1.25rem;
    }

    .sponsors-page .form-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #9ca3af;
        margin-bottom: 0.3rem;
    }

    .sponsors-page .form-control {
        background-color: #020617;
        border-radius: 0.75rem;
        border: 1px solid #374151;
        color: #f9fafb;
        font-size: 0.9rem;
        padding: 0.55rem 0.85rem;
    }

    .sponsors-page .form-control::placeholder {
        color: #6b7280;
    }

    .sponsors-page .form-control:focus {
        background-color: #020617;
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.65);
        color: #f9fafb;
    }

    .sponsors-page small.text-muted {
        font-size: 0.75rem;
        color: #9ca3af !important;
    }

    .sponsor-submit-btn {
        border-radius: 999px;
        padding: 0.6rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        background: linear-gradient(90deg, #2563eb, #3b82f6);
        border: none;
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.65);
    }

    .sponsor-submit-btn:hover {
        background: linear-gradient(90deg, #1d4ed8, #2563eb);
        transform: translateY(-1px);
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.8);
    }

    /* Listado */
    .sponsors-list-header h5 {
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #9ca3af;
    }

    .sponsors-count-badge {
        background: rgba(15, 23, 42, 0.9);
        border-radius: 999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        color: #e5e7eb;
        border: 1px solid rgba(148, 163, 184, 0.6);
    }

    .sponsor-card {
        border-radius: 1.1rem;
        background: radial-gradient(circle at top, #0b1120, #020617 70%);
        border: 1px solid rgba(55, 65, 81, 0.9);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.9);
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .sponsor-card:hover {
        transform: translateY(-4px);
        border-color: #3b82f6;
        box-shadow: 0 24px 60px rgba(37, 99, 235, 0.75);
    }

    .sponsor-logo-wrapper {
        height: 96px;
        border-radius: 0.85rem;
        background: radial-gradient(circle at top, #020617, #020617 70%);
        border: 1px solid rgba(55, 65, 81, 0.9);
    }

    .sponsor-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: #f9fafb;
    }

    .sponsor-link-btn {
        border-radius: 999px;
        border: 1px solid rgba(156, 163, 175, 0.9);
        font-size: 0.8rem;
        padding: 0.4rem 0.75rem;
        color: #e5e7eb;
    }

    .sponsor-link-btn:hover {
        border-color: #3b82f6;
        background: rgba(37, 99, 235, 0.15);
        color: #f9fafb;
    }

    .empty-sponsors-text {
        color: #9ca3af;
        font-size: 0.9rem;
    }

    @media (max-width: 991.98px) {
        .sponsors-header {
            padding: 1.5rem 1.4rem;
        }

        .sponsors-header-title {
            font-size: 1.7rem;
        }

        .sponsors-page {
            padding-top: 1.8rem;
        }
    }
</style>
@endpush

@section('content')
<div class="sponsors-page">
    <div class="container page-container">

        {{-- CABECERA --}}
        <div class="mb-3">
            <div class="sponsors-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <span class="sponsors-badge mb-2 d-inline-flex align-items-center gap-2">
                            <span>🎯</span> Gestión de Patrocinadores
                        </span>
                        <h2 class="sponsors-header-title mb-1 text-white">
                            Sponsors del Evento
                        </h2>
                        <p>
                            Administra los logos y enlaces de las marcas que apoyan tus torneos.
                        </p>
                    </div>
                    <div class="text-md-end">
                        <span class="sponsors-updated-label d-block">
                            Última actualización
                        </span>
                        <span class="sponsors-updated-date">
                            {{ now()->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTÓN VOLVER --}}
        <div class="mb-3">
            <a href="{{ url('/eventos/crear-evento-developer') }}"
               class="btn btn-outline-light btn-sm d-inline-flex align-items-center gap-2 back-to-event-btn">
                <i class="bi bi-arrow-left"></i>
                Volver a crear evento
            </a>
        </div>

        {{-- CONTENEDOR PRINCIPAL --}}
        <div class="card sponsors-main-card border-0">
            <div class="card-body p-4 p-md-5">

                {{-- Mensajes --}}
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-4">
                    {{-- FORMULARIO --}}
                    <div class="col-lg-5">
                        <div class="sponsor-form-card p-3 p-md-4">
                            <h5>Agregar nuevo sponsor</h5>

                            <form action="{{ route('sponsors.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nombre del sponsor</label>
                                    <input
                                        type="text"
                                        name="nombre"
                                        class="form-control @error('nombre') is-invalid @enderror"
                                        value="{{ old('nombre') }}"
                                        required
                                    >
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">URL (opcional)</label>
                                    <input
                                        type="url"
                                        name="url"
                                        class="form-control @error('url') is-invalid @enderror"
                                        value="{{ old('url') }}"
                                        placeholder="https://tusponsor.com"
                                    >
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Logo / imagen</label>
                                    <input
                                        type="file"
                                        name="logo"
                                        class="form-control @error('logo') is-invalid @enderror"
                                        accept="image/*"
                                        required
                                    >
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">
                                        Formatos permitidos: JPG, JPEG, PNG, WEBP, GIF. Máx 2MB.
                                    </small>
                                </div>

                                <button type="submit" class="btn sponsor-submit-btn w-100 mt-2">
                                    Guardar sponsor
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- LISTADO --}}
                    <div class="col-lg-7">
                        <div class="d-flex justify-content-between align-items-center mb-3 sponsors-list-header">
                            <h5 class="mb-0">Sponsors actuales</h5>
                            <span class="sponsors-count-badge">
                                {{ $sponsors->count() }} registrados
                            </span>
                        </div>

                        @if ($sponsors->count())
                            <div class="row g-3">
                                @foreach ($sponsors as $sponsor)
                                    <div class="col-sm-6 col-md-4">
                                        <div class="card sponsor-card h-100 border-0">
                                            @if ($sponsor->logo)
                                                <div class="pt-3 px-3">
                                                    <div class="sponsor-logo-wrapper d-flex align-items-center justify-content-center">
                                                        <img
                                                            src="{{ asset('storage/' . $sponsor->logo) }}"
                                                            class="img-fluid"
                                                            alt="{{ $sponsor->nombre }}"
                                                            style="max-height: 72px; object-fit: contain;"
                                                        >
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="card-body d-flex flex-column">
                                                <h6 class="sponsor-name mt-3 mb-2 text-truncate">
                                                    {{ $sponsor->nombre }}
                                                </h6>

                                                @if ($sponsor->url)
                                                    <a
                                                        href="{{ $sponsor->url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="btn btn-sm sponsor-link-btn mt-auto align-self-start"
                                                    >
                                                        Ver sitio
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="empty-sponsors-text mb-0">
                                No hay sponsors registrados todavía. Agrega el primero usando el formulario de la izquierda.
                            </p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
