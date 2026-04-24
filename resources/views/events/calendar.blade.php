@extends('layouts.app')

@section('title', 'Calendario de eventos')

@push('styles')
<style>
  .calendar-page{
    background:
      radial-gradient(1000px 500px at -10% 0%, rgba(2,132,199,.15), transparent 55%),
      radial-gradient(900px 550px at 110% -10%, rgba(59,130,246,.18), transparent 50%),
      linear-gradient(180deg, #f7fbff 0%, #eef4ff 100%);
    border-radius: 26px;
    border: 1px solid rgba(15,23,42,.08);
    box-shadow: 0 20px 45px rgba(15,23,42,.08);
    padding: 1.6rem;
  }

  .calendar-hero{
    background: linear-gradient(135deg, #082f49, #172554 65%, #0f172a);
    border-radius: 20px;
    border: 1px solid rgba(148,163,184,.35);
    box-shadow: 0 18px 40px rgba(2,6,23,.35);
    padding: 1.4rem 1.45rem;
    color: #eaf2ff;
    position: relative;
    overflow: hidden;
  }

  .calendar-hero::after{
    content: "";
    position: absolute;
    right: -70px;
    top: -80px;
    width: 270px;
    height: 270px;
    border-radius: 999px;
    background: radial-gradient(circle, rgba(96,165,250,.35), transparent 62%);
    filter: blur(14px);
  }

  .calendar-title{
    margin: 0;
    font-size: clamp(1.55rem, 1.6vw + 1rem, 2.15rem);
    font-weight: 800;
    letter-spacing: .2px;
    color: #f8fbff !important;
    text-shadow: 0 2px 10px rgba(2,6,23,.35);
  }

  .calendar-sub{
    margin: .45rem 0 0;
    color: rgba(226,232,240,.9);
    max-width: 70ch;
  }

  .calendar-actions{
    display: flex;
    gap: .65rem;
    flex-wrap: wrap;
    margin-top: 1rem;
  }

  .btn-hero{
    border-radius: 12px;
    font-weight: 700;
    padding: .62rem .95rem;
    text-decoration: none;
    transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
  }

  .btn-hero.primary{
    color: #fff;
    border: 1px solid rgba(125,211,252,.55);
    background: linear-gradient(135deg, #0ea5e9, #1d4ed8);
    box-shadow: 0 9px 20px rgba(29,78,216,.4);
  }

  .btn-hero.soft{
    color: #e2e8f0;
    border: 1px solid rgba(148,163,184,.45);
    background: rgba(15,23,42,.4);
  }

  .btn-hero:hover{
    transform: translateY(-1px);
    filter: brightness(1.04);
  }

  .filter-card{
    margin-top: 1rem;
    background: #ffffff;
    border: 1px solid rgba(148,163,184,.28);
    border-radius: 16px;
    box-shadow: 0 14px 25px rgba(30,41,59,.08);
    padding: 1rem;
  }

  .filter-label{
    font-size: .82rem;
    letter-spacing: .4px;
    text-transform: uppercase;
    color: #475569;
    font-weight: 800;
    margin-bottom: .35rem;
    display: inline-block;
  }

  .filter-input{
    border-radius: 12px;
    border: 1px solid rgba(148,163,184,.45);
    padding: .62rem .75rem;
    width: 100%;
    background: #f8fafc;
  }

  .filter-input:focus{
    outline: none;
    border-color: rgba(14,165,233,.7);
    box-shadow: 0 0 0 3px rgba(14,165,233,.16);
    background: #fff;
  }

  .btn-filter{
    border: none;
    border-radius: 12px;
    color: #fff;
    background: linear-gradient(135deg, #0284c7, #1d4ed8);
    font-weight: 800;
    padding: .68rem 1rem;
  }

  .btn-clear{
    border-radius: 12px;
    font-weight: 700;
    padding: .68rem 1rem;
    border: 1px solid rgba(148,163,184,.45);
    color: #1e293b;
    background: #fff;
    text-decoration: none;
  }

  .results-chip{
    margin-top: .8rem;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(14,165,233,.12);
    color: #075985;
    border: 1px solid rgba(14,165,233,.3);
    border-radius: 999px;
    font-weight: 700;
    font-size: .84rem;
    padding: .35rem .8rem;
  }

  .day-block{
    margin-top: 1.1rem;
    background: #fff;
    border: 1px solid rgba(148,163,184,.24);
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(30,41,59,.07);
    overflow: hidden;
  }

  .day-head{
    display: flex;
    justify-content: space-between;
    gap: .85rem;
    align-items: center;
    flex-wrap: wrap;
    padding: .95rem 1rem;
    border-bottom: 1px solid rgba(148,163,184,.2);
    background: linear-gradient(180deg, rgba(241,245,249,.95), rgba(248,250,252,.95));
  }

  .day-title{
    margin: 0;
    color: #0f172a;
    font-weight: 800;
    font-size: 1.08rem;
  }

  .day-pill{
    border-radius: 999px;
    background: rgba(30,64,175,.1);
    color: #1e3a8a;
    border: 1px solid rgba(59,130,246,.24);
    font-size: .77rem;
    padding: .3rem .65rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .45px;
  }

  .day-list{
    padding: .9rem;
    display: grid;
    gap: .75rem;
  }

  .event-card{
    border: 1px solid rgba(148,163,184,.3);
    border-radius: 14px;
    background: #fff;
    padding: .95rem;
    display: grid;
    gap: .62rem;
  }

  .event-top{
    display: flex;
    justify-content: space-between;
    gap: .7rem;
    align-items: flex-start;
    flex-wrap: wrap;
  }

  .event-name{
    margin: 0;
    color: #0f172a;
    font-size: 1.03rem;
    font-weight: 800;
    letter-spacing: .2px;
  }

  .event-meta{
    color: #475569;
    margin: 0;
    font-size: .93rem;
  }

  .event-grid{
    display: grid;
    grid-template-columns: repeat(2, minmax(120px, 1fr));
    gap: .45rem .8rem;
  }

  .meta-line{
    color: #334155;
    font-size: .9rem;
  }

  .meta-line strong{
    color: #0f172a;
    font-weight: 700;
  }

  .badge-insc{
    border-radius: 999px;
    padding: .33rem .72rem;
    font-size: .74rem;
    font-weight: 800;
    letter-spacing: .35px;
    text-transform: uppercase;
  }

  .badge-insc.open{
    background: rgba(34,197,94,.12);
    color: #166534;
    border: 1px solid rgba(34,197,94,.35);
  }

  .badge-insc.closed{
    background: rgba(239,68,68,.11);
    color: #991b1b;
    border: 1px solid rgba(239,68,68,.32);
  }

  .badge-insc.pause{
    background: rgba(251,191,36,.18);
    color: #92400e;
    border: 1px solid rgba(245,158,11,.32);
  }

  .badge-insc.prep{
    background: rgba(148,163,184,.13);
    color: #334155;
    border: 1px solid rgba(148,163,184,.42);
  }

  .btn-detail{
    width: fit-content;
    text-decoration: none;
    border-radius: 10px;
    border: 1px solid rgba(59,130,246,.35);
    color: #1d4ed8;
    background: rgba(219,234,254,.6);
    font-weight: 700;
    padding: .42rem .76rem;
    transition: background .15s ease, transform .15s ease;
  }

  .btn-detail:hover{
    background: rgba(59,130,246,.2);
    transform: translateY(-1px);
  }

  .empty-card{
    margin-top: 1.1rem;
    border: 1px dashed rgba(148,163,184,.55);
    border-radius: 16px;
    padding: 1.3rem;
    text-align: center;
    background: rgba(255,255,255,.78);
    color: #475569;
  }

  @media (max-width: 767.98px){
    .calendar-page{
      padding: 1rem;
      border-radius: 18px;
    }

    .calendar-hero{
      padding: 1.08rem 1rem;
      border-radius: 16px;
    }

    .day-list{
      padding: .75rem;
    }

    .event-card{
      padding: .8rem;
    }

    .event-grid{
      grid-template-columns: 1fr;
    }
  }
</style>
@endpush

@section('content')
@php
  $groupedEvents = $events->getCollection()->groupBy(function ($event) {
      if (!$event->start_at) {
          return 'sin-fecha';
      }

      return $event->start_at->timezone('America/Bogota')->format('Y-m-d');
  });
@endphp

<div class="container py-4 py-lg-5">
  <section class="calendar-page">
    <header class="calendar-hero">
      <h1 class="calendar-title">Calendario de agenda e inscripciones</h1>
      <p class="calendar-sub">Visualiza agenda y estado de inscripciones por fecha, con filtros para revisar rapidamente cada jornada.</p>

      <div class="calendar-actions">
        <a href="{{ route('register') }}" class="btn-hero soft">
          <i class="bi bi-arrow-left-circle me-1"></i>
          Volver al panel
        </a>
        <a href="{{ route('events.index') }}" class="btn-hero primary">
          <i class="bi bi-grid me-1"></i>
          Ver catalogo general
        </a>
      </div>
    </header>

    <section class="filter-card">
      <form method="GET" action="{{ route('events.calendar') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
          <label for="fecha" class="filter-label">Filtrar por fecha</label>
          <input type="date" id="fecha" name="fecha" value="{{ $fecha }}" class="filter-input">
        </div>
        <div class="col-md-4">
          <label for="estado" class="filter-label">Estado de inscripcion</label>
          <select id="estado" name="estado" class="filter-input">
            <option value="">Todos</option>
            <option value="activo" {{ $estado === 'activo' ? 'selected' : '' }}>Inscripciones abiertas</option>
            <option value="cerrado" {{ $estado === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
            <option value="inactivo" {{ $estado === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
          </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button type="submit" class="btn-filter flex-grow-1">
            <i class="bi bi-funnel me-1"></i>
            Aplicar filtros
          </button>
          @if($fecha !== '' || $estado !== '')
            <a href="{{ route('events.calendar') }}" class="btn-clear">Limpiar</a>
          @endif
        </div>
      </form>

      <span class="results-chip">
        <i class="bi bi-calendar2-week"></i>
        {{ $events->total() }} resultado(s)
      </span>
    </section>

    @forelse($groupedEvents as $dateKey => $items)
      @php
        if ($dateKey === 'sin-fecha') {
            $dateTitle = 'Fecha por definir';
            $datePill = 'Sin fecha';
        } else {
            $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $dateKey, 'America/Bogota');
            $dateTitle = $dateObj->translatedFormat('l, d M Y');
            $daysDiff = $today->diffInDays($dateObj, false);

            if ($daysDiff === 0) {
                $datePill = 'Hoy';
            } elseif ($daysDiff === 1) {
                $datePill = 'Manana';
            } elseif ($daysDiff > 1) {
                $datePill = 'En ' . $daysDiff . ' dias';
            } else {
                $datePill = 'Hace ' . abs($daysDiff) . ' dias';
            }
        }
      @endphp

      <article class="day-block">
        <div class="day-head">
          <h2 class="day-title">{{ $dateTitle }}</h2>
          <span class="day-pill">{{ $datePill }}</span>
        </div>

        <div class="day-list">
          @foreach($items as $event)
            @php
              $status = strtolower((string) ($event->status ?? ''));
              $badgeClass = 'prep';
              $badgeText = 'En preparacion';

              if ($status === 'activo') {
                  $badgeClass = 'open';
                  $badgeText = 'Inscripciones abiertas';
              } elseif ($status === 'cerrado') {
                  $badgeClass = 'closed';
                  $badgeText = 'Cerrado';
              } elseif ($status === 'inactivo') {
                  $badgeClass = 'pause';
                  $badgeText = 'Inactivo';
              }
            @endphp

            <div class="event-card">
              <div class="event-top">
                <div>
                  <h3 class="event-name">{{ $event->title ?: 'Evento sin titulo' }}</h3>
                  <p class="event-meta">{{ $event->description ?: 'Sin descripcion registrada para este evento.' }}</p>
                </div>
                <span class="badge-insc {{ $badgeClass }}">{{ $badgeText }}</span>
              </div>

              <div class="event-grid">
                <div class="meta-line">
                  <strong>Hora:</strong>
                  {{ $event->start_at ? $event->start_at->timezone('America/Bogota')->format('H:i') : 'Por definir' }}
                </div>
                <div class="meta-line">
                  <strong>Categoria:</strong>
                  {{ $event->category ?: 'No definida' }}
                </div>
                <div class="meta-line">
                  <strong>Lugar:</strong>
                  {{ $event->location ?: 'Sede por definir' }}
                </div>
                <div class="meta-line">
                  <strong>Fin:</strong>
                  {{ $event->end_at ? $event->end_at->timezone('America/Bogota')->translatedFormat('d M Y') : 'Sin fecha final' }}
                </div>
              </div>

              <a href="{{ route('events.show', $event->id) }}" class="btn-detail">
                <i class="bi bi-eye me-1"></i>
                Ver detalle
              </a>
            </div>
          @endforeach
        </div>
      </article>
    @empty
      <div class="empty-card">
        <h3 class="h5 mb-2">No se encontraron eventos con esos filtros</h3>
        <p class="mb-0">Prueba con otra fecha o cambia el estado de inscripcion para ver la agenda.</p>
      </div>
    @endforelse

    @if($events->hasPages())
      <div class="mt-3">
        {{ $events->links() }}
      </div>
    @endif
  </section>
</div>
@endsection
