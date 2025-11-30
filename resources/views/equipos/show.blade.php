@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-6 text-center">Sorteo del Torneo</h1>

    @php 
        $colores = ['borde-rojo', 'borde-verde', 'borde-azul', 'borde-amarillo'];
        $i = 0;
        $style = $style ?? 'default';
        $mode = $mode ?? 'normal';
    @endphp

    @foreach($groups as $groupName => $group)
        <div class="tarjeta-grupo">
            
            <h2 class="titulo-grupo">{{ $groupName }}</h2>

            @foreach($group as $team)
                <div class="tarjeta-equipo {{ $colores[$i % 4] }}">
                    {{ $team }}
                </div>
            @endforeach
        </div>

        @php $i++; @endphp
    @endforeach

    {{-- BOTÓN DE PDF BIEN POSICIONADO --}}
    <form action="{{ route('tournament.pdf') }}" method="POST" target="_blank">
        @csrf
        
        <input type="hidden" name="groups" value="{{ json_encode($groups) }}">
        <input type="hidden" name="style" value="{{ $style }}">
        <input type="hidden" name="mode" value="{{ $mode }}">

        <div class="w-full flex justify-center mt-8 mb-12">
            <button 
                type="submit"
                class="btn btn-success">
                Descargar PDF
            </button>
        </div>  

    </form>
    <form action="{{ route('torneo.guardar') }}" method="POST">
        @csrf
        <input type="hidden" name="groups" value="{{ json_encode($groups) }}">
        <button class="btn btn-success mt-3">Guardar Sorteo</button>
    </form>
</div>
@endsection
