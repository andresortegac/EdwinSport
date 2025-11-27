@extends('layouts.app')

@section('content')
<div class="container">

    <h1>{{ $cancha->nombre }}</h1>
    <p>{{ $cancha->descripcion }}</p>

    <p><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
    <p><strong>Contacto:</strong> {{ $cancha->telefono_contacto }}</p>

    <h3>Agenda de la Semana</h3>

    @php
        // Generar horas disponibles
        $horaInicio = \Carbon\Carbon::parse($cancha->hora_apertura);
        $horaFin    = \Carbon\Carbon::parse($cancha->hora_cierre);
        $hours      = [];

        for ($h = $horaInicio->copy(); $h->lt($horaFin); $h->addHour()) {
            $hours[] = $h->format('H:i');
        }

        // Generar días de la semana
        $dias = [];
        for ($d = 0; $d < 7; $d++) {
            $dias[] = $startOfWeek->copy()->addDays($d);
        }
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hora / Día</th>
                @foreach ($dias as $dia)
                    <th>{{ $dia->format('D d') }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($hours as $hora)
                <tr>
                    <td>{{ $hora }}</td>

                    @foreach ($dias as $dia)
                        @php
                            $ocupada = $reservas->contains(function ($r) use ($dia, $hora) {
                                return $r->fecha == $dia->toDateString()
                                    && \Carbon\Carbon::parse($r->hora_inicio)->format('H:i') == $hora;
                            });
                        @endphp

                        <td>
                        @if ($ocupada)
                            <span class="badge bg-danger">Ocupada</span>

                        @else
                            <form method="POST" action="{{ route('reservas.store') }}">
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

                                <button class="btn btn-primary btn-sm w-100" type="submit">
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
@endsection
