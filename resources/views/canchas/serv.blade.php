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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        {{-- COLUMNA IZQUIERDA: Imagen y fecha --}}
        <div class="col-md-6">
            <div class="reserva-card mb-3">
                <img src="{{ asset('/img/cancha vertical.jpg') }}" width="170px" height="200px" />
                   <h1>{{ $cancha->nombre }}</h1>
                    <p><strong>Ubicacion:</strong> {{ $cancha->ubicacion }}</p>
                    <p><strong>Contacto:</strong> {{ $cancha->telefono_contacto }}</p>
            </div>
        </div>

        {{-- COLUMNA DERECHA: Formulario --}}
        <div class="col-md-6">
            <div class="reserva-card">
                <form action="{{ route('user_reservas.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="cancha_id" value="{{ $cancha->id }}">

                        <label>Nombre</label>
                        <input type="text" name="nombre_cliente" class="form-control" required>

                        <label>Telefono</label>
                        <input type="text" name="telefono_cliente" class="form-control">

                        <label>Numero de cancha interna</label>
                        <select name="numero_subcancha" class="form-select" required>
                            @for ($i = 1; $i <= (int)($cancha->num_canchas ?? 1); $i++)
                                <option value="{{ $i }}" {{ old('numero_subcancha') == $i ? 'selected' : '' }}>
                                    Cancha {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <small class="text-muted">
                            Esta cancha maneja {{ (int)($cancha->num_canchas ?? 1) }} cancha(s) interna(s).
                        </small>

                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>

                        <label>Hora de reserva</label>
                        <input type="time"
                               name="hora"
                               class="form-control"
                               min="{{ \Carbon\Carbon::parse($cancha->hora_apertura)->format('H:i') }}"
                               max="{{ \Carbon\Carbon::parse($cancha->hora_cierre)->subMinute()->format('H:i') }}"
                               required>
                        <small class="text-muted">
                            Horario permitido:
                            {{ \Carbon\Carbon::parse($cancha->hora_apertura)->format('h:i A') }}
                            -
                            {{ \Carbon\Carbon::parse($cancha->hora_cierre)->format('h:i A') }}
                        </small>

                        <button class="btn btn-success w-100 mt-3">Reservar</button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
