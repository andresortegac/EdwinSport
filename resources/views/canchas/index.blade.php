@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Canchas Disponibles</h1>

    <div class="row">
        @foreach ($canchas as $cancha)
            <div class="col-md-4 mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4>{{ $cancha->nombre }}</h4>

                        <p><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
                        <p><strong>Horario:</strong> 
                            {{ $cancha->hora_apertura }} - {{ $cancha->hora_cierre }}
                        </p>

                        <a href="{{ route('canchas.show', $cancha->id) }}" class="btn btn-primary">Ver Agenda</a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
