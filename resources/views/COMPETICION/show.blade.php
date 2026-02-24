<h2 class="mb-3">
    Competición del evento {{ $evento->title }}
</h2>

{{-- Mensajes flash --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(!$competicion)
    {{-- Crear competición --}}
    <form method="POST" action="{{ route('competicion.crear', $evento->id) }}">
        @csrf
        <button class="btn btn-success">
            Crear competición
        </button>
    </form>
@else
    {{-- Estado --}}
    <p>
        <strong>Estado:</strong>
        <span class="badge bg-info text-dark">
            {{ $competicion->estado }}
        </span>
    </p>

    {{-- Equipos inscritos --}}
    <h4>Equipos inscritos ({{ $equipos->count() }})</h4>
    <ul class="list-group mb-3">
        @foreach($equipos as $equipo)
            <li class="list-group-item">
                {{ $equipo->nombre_equipo }}
            </li>
        @endforeach
    </ul>

    {{-- Botón generar grupos --}}
    @if($competicion->estado === 'creada')
        <form method="POST" action="{{ route('competicion.grupos', $competicion->id) }}">
            @csrf
            <button class="btn btn-primary mb-4">
                Generar divisiones automóticamente
            </button>
        </form>
    @endif
@endif

{{-- Mostrar grupos --}}
@if($grupos->count())
    <h4 class="mt-4 mb-3">Grupos generados</h4>

    <div class="row">
        @foreach($grupos as $grupo)
            <div class="col-md-3 col-sm-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        {{ $grupo->nombre_grupo }}

                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach($grupo->equipos as $equipo)
                            <li class="list-group-item text-center">
                                {{ $equipo->nombre_equipo }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endif
