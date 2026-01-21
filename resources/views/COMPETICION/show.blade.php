<h2>Competición del evento {{ $evento }}</h2>

@if(!$competicion)
    <form method="POST" action="{{ route('competicion.crear', $evento) }}">
        @csrf
        <button class="btn btn-success">
            Crear competición
        </button>
    </form>
@else
    <p><strong>Estado:</strong> {{ $competicion->estado }}</p>

    <h4>Equipos inscritos ({{ $equipos->count() }})</h4>
    <ul>
        @foreach($equipos as $equipo)
            <li>{{ $equipo->nombre_equipo }}</li>
        @endforeach
    </ul>

    @if($competicion->estado === 'creada')
        <form method="POST" action="{{ route('competicion.grupos', $competicion->id) }}">
            @csrf
            <button class="btn btn-primary">
                Generar divisiones automáticamente
            </button>
        </form>
    @endif
@endif
