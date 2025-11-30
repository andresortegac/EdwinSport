@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Grupos del Torneo</h1>

    @foreach($grupos as $grupo)
        <div class="card mb-3">
            <div class="card-header">
                {{ $grupo->nombre }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach($grupo->equipos as $equipo)
                        <li>{{ $equipo->nombre }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach

</div>
@endsection
