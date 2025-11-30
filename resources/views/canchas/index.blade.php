@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Canchas Asociadas </h1>

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
                        <p><strong>N.º de canchas:</strong> {{ $cancha->num_canchas ?? 1 }}</p>
                        <a href="{{ route('canchas.show', $cancha->id) }}" class="btn btn-primary">Ver Agenda</a>
                        <form action="{{ route('canchas.destroy', $cancha->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta cancha?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger mt-2">Eliminar</button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
        
    </div>

    <br>

    {{-- BOTÓN PARA CREAR CANCHA NUEVA --}}
    <a href="{{ route('canchas.create') }}" class="btn btn-success">
        Agregar Cancha
    </a>
    
    

</div>
@yield('content')

    @include('components.footer')

@endsection


    

