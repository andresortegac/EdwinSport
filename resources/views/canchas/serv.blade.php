@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/views/canchas/serv.css') }}">
@endpush

@section('content')
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
                <img src="{{ asset('/img/cancha vertical.jpg') }}" alt="Imagen de la cancha {{ $cancha->nombre }}" class="cancha-img" />
                <h1>{{ $cancha->nombre }}</h1>
                <p><strong>Ubicacion:</strong> {{ $cancha->ubicacion }}</p>
                <p><strong>Ciudad:</strong> {{ $cancha->ciudad ?: 'No definida' }}</p>
                <p><strong>Contacto:</strong> {{ $cancha->telefono_contacto }}</p>
                <p><strong>Tenant:</strong> {{ $cancha->subdominio ?: 'Sin subdominio' }}</p>
            </div>

            @if(isset($solicitudesCliente) && $solicitudesCliente->isNotEmpty())
                <div class="reserva-card">
                    <h4 class="mb-3">Estado de tus solicitudes</h4>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle estado-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Subcancha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($solicitudesCliente as $solicitud)
                                    <tr>
                                        <td>{{ $solicitud->fecha }}</td>
                                        <td>{{ \Illuminate\Support\Str::of($solicitud->hora)->substr(0, 5) }}</td>
                                        <td>Cancha {{ $solicitud->numero_subcancha }}</td>
                                        <td>
                                            <span class="badge bg-{{ ($solicitud->estado_solicitud ?? 'pendiente') === 'confirmada' ? 'success' : (($solicitud->estado_solicitud ?? 'pendiente') === 'cancelada' ? 'danger' : 'warning text-dark') }}">
                                                {{ ucfirst($solicitud->estado_solicitud ?? 'pendiente') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <small class="text-muted">Mostramos las ultimas solicitudes asociadas a tu telefono en esta cancha.</small>
                </div>
            @endif
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
                    <input type="text" name="telefono_cliente" class="form-control" value="{{ request('telefono') }}">

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

                    <button class="btn btn-success w-100 mt-3">Enviar solicitud</button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
