@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="text-center mb-4" style="font-family: Oswald; font-weight:700;">
        LISTADO DE EVENTOS
    </h1>

    <div class="row">

        @forelse ($eventos as $evento)

            <div class="col-md-4 mb-4">
                <div class="card accent-gold p-0" style="border-radius:1rem; overflow:hidden;">

                    {{-- Imagen del evento --}}
                    
                    @if($evento->image)
                        <img src="{{ asset('storage/' . $evento->image) }}"
                            class="img-fluid"
                            alt="{{ $evento->title }}"
                            style="height: 180px; object-fit: cover;">
                    @else
                        <div style="height:180px; background:#eee; display:flex; align-items:center; justify-content:center;">
                            <span style="color:#999;">Sin imagen</span>
                        </div>
                    @endif


                    <div class="card-body">

                        <h4 style="font-family: Oswald; font-weight:700;">
                            {{ $evento->title }}
                        </h4>

                        <p class="text-muted" style="min-height:50px;">
                            {{ Str::limit($evento->description, 70) }}
                        </p>

                        <p><strong>Categoría:</strong> {{ ucfirst($evento->category) }}</p>
                        <p><strong>Ubicación:</strong> {{ $evento->location }}</p>

                        <p>
                            <strong>Inicio:</strong> 
                            {{ \Carbon\Carbon::parse($evento->start_at)->format('d/m/Y H:i') }}
                            <br>
                            <strong>Final:</strong> 
                            {{ $evento->end_at ? \Carbon\Carbon::parse($evento->end_at)->format('d/m/Y H:i') : 'No definido' }}
                        </p>

                        <span class="badge
                            @if($evento->status=='activo') bg-success
                            @elseif($evento->status=='inactivo') bg-secondary
                            @else bg-danger @endif
                        ">
                            {{ strtoupper($evento->status) }}
                        </span>

                        <div class="d-flex justify-content-between mt-3">

                            {{-- Boton Editar --}}
                            <a id="btn-listado-eventos" href="{{ route('editar-evento.edit', $evento->id) }}" 
                                class="btn btn-warning btn-sm mt-2 btn-editar-evento"
                                data-id="{{ $evento->id }}">
                                Editar
                            </a>

                            {{-- Botón Eliminar --}}
                            <form action="{{ route('eliminar-evento.destroy', $evento->id) }}" method="POST"
                                onsubmit="return confirm('¿Seguro que deseas eliminar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>

                        </div>


                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center mt-5">
                <h4>No hay eventos registrados.</h4>
            </div>
        @endforelse

    </div>

</div>
@endsection


