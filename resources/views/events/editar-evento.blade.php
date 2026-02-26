@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Barra superior: Volver + Título --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-dark">
            ← Volver
        </a>

        <h2 class="m-0 text-center flex-grow-1" style="font-family: Oswald; font-weight:700;">
            Editar Evento
        </h2>

        {{-- Espaciador para centrar el título (mismo ancho que el botón) --}}
        <div style="width: 96px;"></div>
    </div>

    <form action="{{ route('actualizar-evento.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ $evento->title }}" required>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $evento->description }}</textarea>
        </div>

        {{-- Categoría --}}
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <input type="text" name="category" class="form-control" value="{{ $evento->category }}" required>
        </div>

        {{-- Ubicación --}}
        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <input type="text" name="location" class="form-control" value="{{ $evento->location }}" required>
        </div>

        {{-- Fecha Inicio --}}
        <div class="mb-3">
            <label class="form-label">Fecha Inicio</label>
            <input type="datetime-local" name="start_at" class="form-control"
                value="{{ \Carbon\Carbon::parse($evento->start_at)->format('Y-m-d\TH:i') }}" required>
        </div>

        {{-- Fecha Fin --}}
        <div class="mb-3">
            <label class="form-label">Fecha Final</label>
            <input type="datetime-local" name="end_at" class="form-control"
                value="{{ $evento->end_at ? \Carbon\Carbon::parse($evento->end_at)->format('Y-m-d\TH:i') : '' }}">
        </div>

        {{-- Estado --}}
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="status" class="form-select" required>
                <option value="activo" {{ $evento->status == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $evento->status == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                <option value="cancelado" {{ $evento->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        {{-- Imagen --}}
        <div class="mb-3">
            <label class="form-label">Imagen Actual</label><br>

            @if($evento->image)
                <img src="{{ route('events.media', ['path' => ltrim($evento->image, '/')]) }}" alt="" class="img-thumbnail mb-3" width="220">
            @else
                <p>No tiene imagen asignada.</p>
            @endif

            <input type="file" name="image" class="form-control">
            <small class="text-muted">Si subes una imagen nueva, reemplazará la actual.</small>
        </div>

        {{-- Botones del formulario --}}
        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-primary">
                Guardar Cambios
            </button>

            {{-- Cancelar: se queda en la página y revierte cambios --}}
            <button type="reset" class="btn btn-secondary">
                Cancelar edición
            </button>
        </div>

    </form>

</div>
@endsection
