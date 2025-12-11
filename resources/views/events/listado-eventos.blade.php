@extends('layouts.app')

@section('content')

<style>
/* ===============================
   LISTADO DE EVENTOS - MEJORAS UI
   =============================== */

/* card más bonita */
.card.accent-gold{
    border: none;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: transform .2s ease, box-shadow .2s ease;
}
.card.accent-gold:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.12);
}

/* badge más compacto */
.card .badge{
    font-size: 12px;
    font-weight: 700;
    padding: 5px 10px;
    border-radius: 999px;
}

/* ==========================
   BOTONES EDITAR / ELIMINAR
   ========================== */

/* contenedor de acciones */
.event-actions{
    display: flex;
    justify-content: flex-end;
    gap: 10px;              /* separación bonita */
    margin-top: 12px;
}

/* botón base para ambos */
.event-actions a,
.event-actions button{
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    height: 36px;           /* ✅ tamaño elegante */
    padding: 0 16px !important;
    font-size: 14px;
    font-weight: 700;
    border-radius: 8px !important;
    border: none;
    cursor: pointer;
    transition: all .2s ease;
    white-space: nowrap;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

/* EDITAR */
.event-actions .btn-editar-evento{
    min-width: 100px;       /* ✅ evita que sea gigante */
    background: #ffc107 !important;
    color: #111 !important;
}
.event-actions .btn-editar-evento:hover{
    background: #ffb300 !important;
    transform: translateY(-1px);
}

/* ELIMINAR */
.event-actions .btn-eliminar-evento{
    min-width: 90px;
    background: #e74c3c !important;
    color: #fff !important;
}
.event-actions .btn-eliminar-evento:hover{
    background: #d63b2b !important;
    transform: translateY(-1px);
}

/* para que el form no rompa el flex */
.event-actions form{
    margin: 0;
}
</style>


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

                        {{-- ✅ BOTONES BONITOS --}}
                        <div class="event-actions">

                            {{-- Boton Editar --}}
                            <a id="btn-listado-eventos"
                               href="{{ route('editar-evento.edit', $evento->id) }}"
                               class="btn btn-warning btn-sm btn-editar-evento"
                               data-id="{{ $evento->id }}">
                                Editar
                            </a>

                            {{-- Botón Eliminar --}}
                            <form action="{{ route('eliminar-evento.destroy', $evento->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-eliminar-evento">
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
