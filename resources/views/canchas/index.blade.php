@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Canchas Asociadas</h1>

    <div class="row">
        @forelse ($canchas as $cancha)
            <div class="col-md-4 mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div>
                            <img src="{{ asset('/img/cancha.jpg') }}"
                                 width="330"
                                 height="170"
                                 alt="Imagen de cancha" />
                        </div>

                        <h4 class="mt-2">{{ $cancha->nombre }}</h4>

                        <p><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
                        <p>
                            <strong>Horario:</strong>
                            {{ $cancha->hora_apertura }} - {{ $cancha->hora_cierre }}
                        </p>
                        <p><strong>N.º de canchas:</strong> {{ $cancha->num_canchas ?? 1 }}</p>

                        <a href="{{ route('user_reservas.create', $cancha->id) }}" class="btn btn-primary">
                            RESERVA
                        </a>

                        <form action="{{ route('canchas.destroy', $cancha->id) }}"
                              method="POST"
                              class="mt-2"
                              onsubmit="return confirm('¿Seguro que deseas eliminar esta cancha?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 mt-3">
                <p>No hay canchas registradas.</p>
            </div>
        @endforelse
    </div>

    <br>

    {{-- BOTÓN PARA CREAR CANCHA NUEVA --}}
    <a href="{{ route('canchas.create') }}" class="btn btn-success">
        Agregar Cancha
    </a>
</div>

{{-- Footer de la página --}}
@include('components.footer')
@endsection
