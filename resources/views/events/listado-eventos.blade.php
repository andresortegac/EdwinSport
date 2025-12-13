@extends('layouts.app')

@section('content')

<style>
/* ===============================
   LISTADO DE EVENTOS - UI + TEXTO BLANCO
   (Solo afecta este listado)
   =============================== */

#contenedor-listado .card.accent-gold{
  border: none;
  border-radius: 1rem;
  overflow: hidden;

  /* ✅ Fondo oscuro + texto blanco dentro de la tarjeta */
  background: rgba(8, 18, 48, .96) !important;
  color: #fff !important;

  box-shadow: 0 6px 18px rgba(0,0,0,0.25);
  transition: transform .2s ease, box-shadow .2s ease;
}

#contenedor-listado .card.accent-gold:hover{
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.35);
}

/* ✅ Todo el contenido interno en blanco */
#contenedor-listado .card.accent-gold .card-body,
#contenedor-listado .card.accent-gold .card-body *{
  color: inherit !important;
  opacity: 1 !important;
}

/* ✅ Reemplazo de "text-muted" para tarjetas oscuras */
#contenedor-listado .event-desc{
  color: rgba(255,255,255,.88) !important;
  min-height: 50px;
}

/* ✅ Texto "Sin imagen" en blanco tenue */
#contenedor-listado .no-image{
  color: rgba(255,255,255,.70) !important;
}

/* Badge */
#contenedor-listado .card .badge{
  font-size: 12px;
  font-weight: 700;
  padding: 5px 10px;
  border-radius: 999px;
}

/* ==========================
   BOTONES EDITAR / ELIMINAR
   ========================== */

#contenedor-listado .event-actions{
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 12px;
}

#contenedor-listado .event-actions a,
#contenedor-listado .event-actions button{
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
  box-shadow: 0 2px 6px rgba(0,0,0,0.20);
}

/* EDITAR */
#contenedor-listado .btn-editar-evento{
  min-width: 100px;
  background: #ffc107 !important;
  color: #111 !important;
}
#contenedor-listado .btn-editar-evento:hover{
  background: #ffb300 !important;
  transform: translateY(-1px);
}

/* ELIMINAR */
#contenedor-listado .btn-eliminar-evento{
  min-width: 90px;
  background: #e74c3c !important;
  color: #fff !important;
}
#contenedor-listado .btn-eliminar-evento:hover{
  background: #d63b2b !important;
  transform: translateY(-1px);
}

#contenedor-listado .event-actions form{ margin: 0; }
</style>

<div class="container-fluid">

  <h1 class="text-center mb-4" style="font-family: Oswald; font-weight:700;">
    LISTADO DE EVENTOS
  </h1>

  <div class="row">
    @forelse ($eventos as $evento)

      <div class="col-md-4 mb-4">
        <div class="card accent-gold p-0">

          {{-- Imagen del evento --}}
          @if($evento->image)
            <img src="{{ asset('storage/' . $evento->image) }}"
                 class="img-fluid"
                 alt="{{ $evento->title }}"
                 style="height: 180px; object-fit: cover;">
          @else
            <div style="height:180px; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center;">
              <span class="no-image">Sin imagen</span>
            </div>
          @endif

          <div class="card-body">

            <h4 style="font-family: Oswald; font-weight:700;">
              {{ $evento->title }}
            </h4>

            {{-- ✅ ya no usamos text-muted --}}
            <p class="event-desc">
              {{ Str::limit($evento->description, 70) }}
            </p>

            <p><strong>Categoría:</strong> {{ ucfirst($evento->category) }}</p>
            <p><strong>Ubicación:</strong> {{ $evento->location }}</p>

            <p>
              <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($evento->start_at)->format('d/m/Y H:i') }}<br>
              <strong>Final:</strong> {{ $evento->end_at ? \Carbon\Carbon::parse($evento->end_at)->format('d/m/Y H:i') : 'No definido' }}
            </p>

            <span class="badge
              @if($evento->status=='activo') bg-success
              @elseif($evento->status=='inactivo') bg-secondary
              @else bg-danger @endif
            ">
              {{ strtoupper($evento->status) }}
            </span>

            <div class="event-actions">

              {{-- ✅ IMPORTANTE: quitamos el id que chocaba con el sidebar --}}
              <a href="{{ route('editar-evento.edit', $evento->id) }}"
                 class="btn btn-warning btn-sm btn-editar-evento"
                 data-id="{{ $evento->id }}">
                Editar
              </a>

             <form action="{{ route('events.destroy', $evento->id) }}" method="POST">
  @csrf
  @method('DELETE')

  <!-- Campo oculto que guarda la URL actual -->
  <input type="hidden" name="redirect_to" value="{{ url()->full() }}">

  <button type="submit" class="btn btn-danger">Eliminar</button>
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
