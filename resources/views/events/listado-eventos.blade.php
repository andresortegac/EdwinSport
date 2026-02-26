@extends('layouts.app')

@section('content')

<style>
/* ===============================
   LISTADO DE EVENTOS - MEJORAS UI
   =============================== */

.card.accent-gold{
    border: none;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: transform .2s ease, box-shadow .2s ease;
}
.card.accent-gold:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.12);
}

.card .badge{
    font-size: 12px;
    font-weight: 700;
    padding: 5px 10px;
    border-radius: 999px;
}

.event-actions{
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 12px;
}

.event-actions a,
.event-actions button{
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    height: 36px;
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

.event-actions .btn-editar-evento{
    min-width: 100px;
    background: #ffc107 !important;
    color: #111 !important;
}
.event-actions .btn-editar-evento:hover{
    background: #ffb300 !important;
    transform: translateY(-1px);
}

.event-actions .btn-eliminar-evento{
    min-width: 90px;
    background: #e74c3c !important;
    color: #fff !important;
}
.event-actions .btn-eliminar-evento:hover{
    background: #d63b2b !important;
    transform: translateY(-1px);
}

.event-actions form{
    margin: 0;
}

.event-image-wrap{
    position: relative;
    height: 180px;
    background: #0f172a;
}

.event-image-wrap img{
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
}

.event-image-fallback{
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    background: linear-gradient(135deg, #111827, #1f2937);
    font-weight: 600;
}

.event-image-wrap.is-broken .event-image-fallback{
    display: flex;
}
</style>

<div class="container-fluid">

    <h1 class="text-center mb-4" style="font-family: Oswald; font-weight:700;">
        LISTADO DE EVENTOS
    </h1>

    <div class="row">

        @forelse ($eventos as $evento)

            <div class="col-md-4 mb-4">
                <div class="card accent-gold p-0"
                    style="border-radius:1rem; overflow:hidden; cursor:pointer;"
                    data-url="{{ route('competicion', $evento->id) }}"
                    onclick="goToEvento(this)">

                    {{-- Imagen del evento --}}
                    @if($evento->image)
                        @php
                            $imageUrl = \Illuminate\Support\Str::startsWith($evento->image, ['http://', 'https://'])
                                ? $evento->image
                                : route('events.media', ['path' => ltrim($evento->image, '/')]);
                        @endphp
                        <div class="event-image-wrap">
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $evento->title }}"
                                 onerror="this.closest('.event-image-wrap').classList.add('is-broken'); this.remove();">
                            <div class="event-image-fallback">Sin imagen</div>
                        </div>
                    @else
                        <div class="event-image-wrap is-broken">
                            <div class="event-image-fallback">Sin imagen</div>
                        </div>
                    @endif

                    <div class="card-body">

                        <h4 style="font-family: Oswald; font-weight:700;">
                            {{ $evento->title }}
                        </h4>

                        <p class="text-muted" style="min-height:50px;">
                            {{ Str::limit($evento->description, 70) }}
                        </p>

                        <p><strong>Categor&iacute;a:</strong> {{ ucfirst($evento->category) }}</p>
                        <p><strong>Ubicaci&oacute;n:</strong> {{ $evento->location }}</p>

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

                        <div class="event-actions">
                            <a id="btn-listado-eventos"
                               href="{{ route('editar-evento.edit', $evento->id) }}"
                               class="btn btn-warning btn-sm btn-editar-evento"
                               data-id="{{ $evento->id }}"
                               onclick="event.stopPropagation();">
                                Editar
                            </a>

                            <form action="{{ route('eliminar-evento.destroy', $evento->id) }}"
                                  method="POST"
                                  onsubmit="event.stopPropagation(); return confirm('&iquest;Seguro que deseas eliminar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-eliminar-evento"
                                    onclick="event.stopPropagation();">
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

<script>
    function goToEvento(element) {
        event.stopPropagation();
        window.location.href = element.getAttribute('data-url');
    }
</script>

@endsection
