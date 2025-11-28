@extends('layouts.app')

@section('content')
<div class="container">

    <h1>{{ $cancha->nombre }}</h1>
    <p><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
    <p><strong>Contacto:</strong> {{ $cancha->telefono_contacto }}</p>

    <h2 class="mb-4">Agenda de la Semana</h2>

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
                        <td class="hour-cell">{{ $hora }}</td>

                        @foreach ($dias as $dia)
                            @php
                                $ocupada = $reservas->contains(function ($r) use ($dia, $hora) {
                                    return $r->fecha == $dia->toDateString()
                                        && \Carbon\Carbon::parse($r->hora_inicio)->format('H:i') == $hora;
                                });
                            @endphp

                            <td>
                                {{-- Celda ocupada --}}
                                @if ($ocupada)
                                    <div class="cell-ocupada">
                                        OCUPADA
                                    </div>

                                {{-- Celda disponible --}}
                                @else
                                    <form class="reserva-form" method="POST" action="{{ route('reservas.store') }}">
                                        @csrf

                                        <input type="hidden" name="cancha_id" value="{{ $cancha->id }}">
                                        <input type="hidden" name="fecha" value="{{ $dia->toDateString() }}">
                                        <input type="hidden" name="hora_inicio" value="{{ $hora }}">

                                        <input class="form-control mb-1"
                                            type="text"
                                            name="nombre_cliente"
                                            placeholder="Nombre"
                                            required>

                                        <input class="form-control mb-1"
                                            type="text"
                                            name="telefono_cliente"
                                            placeholder="Teléfono">

                                        <button class="btn-reservar" type="submit">
                                            Reservar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endforeach

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
@endsection
