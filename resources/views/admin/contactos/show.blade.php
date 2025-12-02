@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Detalle del mensaje</h4>
        </div>

        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $contacto->nombre }}</p>
            <p><strong>Correo:</strong> {{ $contacto->correo }}</p>
            <p><strong>Teléfono:</strong> {{ $contacto->telefono ?? 'No registrado' }}</p>
            <p><strong>Mensaje:</strong></p>
            <p>{{ $contacto->mensaje }}</p>

            <p><strong>Fecha:</strong> {{ $contacto->created_at->format('Y-m-d H:i') }}</p>

            @if(!$contacto->leido)
                <div class="alert alert-warning mt-3">
                    <strong>Este mensaje aún no ha sido marcado como leído.</strong>
                </div>
            @endif

            <a href="{{ route('usuario.panel') }}" class="btn btn-secondary mt-3">Regresar</a>
        </div>
    </div>
</div>
@endsection
