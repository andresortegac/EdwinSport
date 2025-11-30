@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h1 class="text-center mb-5">Llaves del Torneo</h1>

    {{-- Cuartos --}}
    <h3 class="text-primary">Cuartos de Final</h3>
    <div class="row mb-4">
        @foreach ($cuartos as $i => $match)
            <div class="col-6 mb-3">
                <div class="card p-3 shadow-sm">
                    <strong>Partido {{ $i + 1 }}</strong>
                    <p>{{ $match[0] }} 🆚 {{ $match[1] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Semis --}}
    <h3 class="text-info">Semifinal</h3>
    <div class="row mb-4">
        <p class="text-muted">Aquí irán los ganadores automáticamente.</p>
    </div>

    {{-- Final --}}
    <h3 class="text-warning">Final</h3>
    <div class="row mb-4">
        <p class="text-muted">Ganadores de semifinal.</p>
    </div>

    {{-- Campeón --}}
    <h2 class="text-success text-center mt-5">🏆 Campeón: <span id="winner">?</span></h2>

</div>
@endsection
