@extends('layouts.app')

@section('content')

<style>
    .reserva-container {
        max-width: 900px;
        margin: auto;
        background: #f8f9fa;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .reserva-card {
        background: white;
        padding: 25px;
        border-radius: 20px;
    }
    .cancha-img {
        width: 100%;
        max-width: 300px;
        border-radius: 15px;
    }
</style>

<div class="reserva-container">

    <h2 class="text-center mb-4">Reserva de Cancha</h2>

    <div class="row">

        {{-- COLUMNA IZQUIERDA: Imagen y fecha --}}
        <div class="col-md-6">
            <div class="reserva-card mb-3">
                <img src="{{ asset('/img/cancha vertical.jpg') }}" width="170px" height="200px" />
                   <h1>{{ $cancha->nombre }}</h1>
                    <p><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
                    <p><strong>Contacto:</strong> {{ $cancha->telefono_contacto }}</p>           

                {{-- Calendario --}}
                <label for="fecha"><strong>Seleccionar fecha:</strong></label>
                <input type="date" class="form-control" id="fecha">
            </div>
        </div>

        {{-- COLUMNA DERECHA: Formulario --}}
        <div class="col-md-6">
            <div class="reserva-card">
                <form action="{{ route('reservas.preserva') }}" method="POST">
                    @csrf

                    <input type="hidden" name="cancha_id" value="{{ $cancha->id }}">

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hora de reserva</label>
                        <input type="time" name="hora" class="form-control" required>
                    </div>

                    <button class="btn btn-dark w-100 mt-2">Confirmar Reserva</button>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection
