@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/principal-home.css') }}">
<link rel="stylesheet" href="{{ asset('CSS/canchas-show.css') }}">
@endpush

@section('content')
<div class="cancha-show-page py-4 py-lg-5">
    <div class="container">
        <section class="cancha-hero mb-4 mb-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-8">
                    <p class="eyebrow mb-2">AGENDA DE CANCHA</p>
                    <h1>{{ $cancha->nombre }}</h1>
                    <p class="hero-copy">Gestiona reservas por franja horaria durante la semana. Revisa disponibilidad en tiempo real y organiza tu operacion deportiva sin cruces.</p>
                    <div class="hero-meta d-flex flex-wrap gap-2 mt-3">
                        <span><i class="bi bi-geo-alt"></i> {{ $cancha->ubicacion ?: 'Ubicacion por definir' }}</span>
                        <span><i class="bi bi-telephone"></i> {{ $cancha->telefono_contacto ?: 'Sin telefono registrado' }}</span>
                        <span><i class="bi bi-clock"></i>
                            {{ \Carbon\Carbon::parse($cancha->hora_apertura)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($cancha->hora_cierre)->format('h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="quick-actions">
                        <h4 class="mb-3">Acciones rapidas</h4>
                        <a href="{{ route('user_reservas.create', $cancha->id) }}" class="btn btn-brand w-100 mb-2">Nueva reserva</a>
                        <a href="{{ route('canchas.index') }}" class="btn btn-outline-brand w-100">Volver a canchas</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-4">
            <div class="status-legend">
                <span><i class="bi bi-circle-fill text-success"></i> Disponible</span>
                <span><i class="bi bi-circle-fill text-danger"></i> Ocupada</span>
                <span><i class="bi bi-info-circle"></i> Solo lectura: visualiza quien ocupa cada cancha</span>
            </div>
        </section>

        <section class="calendar-shell">
            <div class="calendar-head d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h2 class="mb-0">Agenda semanal</h2>
                <p class="mb-0">{{ $dias[0]->locale('es')->translatedFormat('d M') }} - {{ $dias[6]->locale('es')->translatedFormat('d M') }}</p>
            </div>

            <div class="calendar-container">
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            @foreach ($dias as $dia)
                                <th>{{ $dia->locale('es')->translatedFormat('D d') }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hours as $hora)
                            <tr>
                                <td class="hour-cell">{{ \Carbon\Carbon::createFromFormat('H:i', $hora)->format('h:i A') }}</td>

                                @foreach ($dias as $dia)
                                    @php
                                        $res = $reservas->first(function($r) use($dia,$hora) {
                                            $horaReserva = \Carbon\Carbon::parse($r->hora_inicio)->format('H:00');
                                            return $r->fecha == $dia->toDateString() &&
                                                   $horaReserva == $hora;
                                        });

                                        $ocupada = $res !== null;
                                    @endphp

                                    <td class="slot-cell">
                                        @if ($ocupada)
                                            <div class="cell-ocupada">
                                                <strong>{{ $res->nombre_cliente }}</strong>
                                                <small>{{ $res->telefono_cliente }}</small>
                                                <small>Hora: {{ \Carbon\Carbon::parse($res->hora_inicio)->format('h:i A') }}</small>
                                                <small>
                                                    {{ $res->subcancha->nombre ?? $res->subcancha_label ?? 'Sin subcancha' }}
                                                </small>
                                            </div>
                                        @else
                                            <div class="reserva-form text-center">
                                                <small>Disponible</small>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

</div>
@endsection
