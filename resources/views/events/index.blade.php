@extends('layouts.app')

@section('content')
<div class="container my-5">
  <div class="row">
    {{-- COLUMNA PRINCIPAL: EVENTOS --}}
    <div class="col-lg-9">
      <h1 class="mb-4">
        Eventos
        @if(!empty($category))
          - {{ ucfirst(str_replace('_',' ', $category)) }}
        @endif
      </h1>

      <div class="mb-4">
        <!-- filtros rápidos -->
        <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm">Todos</a>

        <a href="{{ route('events.index', ['category' => 'futbol']) }}" class="btn btn-outline-secondary btn-sm">Fútbol</a>
        <a href="{{ route('events.index', ['category' => 'futbol_salon']) }}" class="btn btn-outline-secondary btn-sm">Fútbol de salón</a>
        <a href="{{ route('events.index', ['category' => 'baloncesto']) }}" class="btn btn-outline-secondary btn-sm">Baloncesto</a>
        <a href="{{ route('events.index', ['category' => 'ciclismo']) }}" class="btn btn-outline-secondary btn-sm">Ciclismo</a>
        <a href="{{ route('events.index', ['category' => 'natacion']) }}" class="btn btn-outline-secondary btn-sm">Natación</a>
        <a href="{{ route('events.index', ['category' => 'patinaje']) }}" class="btn btn-outline-secondary btn-sm">Patinaje</a>
      </div>

      <div class="row g-4">
        @forelse($events as $event)
          <div class="col-md-6 col-lg-4">
            @include('partials.event-card', ['event' => $event])
          </div>
        @empty
          <p>No hay eventos.</p>
        @endforelse
      </div>

      <div class="mt-4">
        {{ $events->withQueryString()->links() }}
      </div>
    </div>

    {{-- COLUMNA DERECHA: PUBLICIDAD / PATROCINIOS --}}
    <div class="col-lg-3">

      {{-- BLOQUE DE PATROCINADORES DINÁMICOS --}}
      <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h4 class="mb-0">Patrocinadores</h4>
          <a href="{{ route('sponsors.create') }}" class="btn btn-primary btn-sm">
            +
          </a>
        </div>

        @if(session('success'))
          <div class="alert alert-success py-1 px-2 mb-2">
            {{ session('success') }}
          </div>
        @endif

        @php
          // Tomamos máximo 3 patrocinadores para el sidebar
          $sidebarSponsors = isset($sponsors) ? $sponsors->take(3) : collect();
        @endphp

        @forelse($sidebarSponsors as $sponsor)
          <div class="card mb-3">
            @if($sponsor->logo)
              <img
                src="{{ asset('storage/'.$sponsor->logo) }}"
                class="card-img-top"
                alt="{{ $sponsor->nombre }}"
                style="max-height: 130px; object-fit: cover;">
            @else
              {{-- Fallback si no hay imagen --}}
              <div class="bg-light d-flex align-items-center justify-content-center" style="height:130px;">
                <span class="text-muted">Sin imagen</span>
              </div>
            @endif

            <div class="card-body py-2">
              <h6 class="card-title mb-1">{{ $sponsor->nombre }}</h6>
              @if($sponsor->url)
                <a href="{{ $sponsor->url }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary">
                  Ver sitio
                </a>
              @endif
            </div>
          </div>
        @empty
          <p class="text-muted">No hay patrocinadores registrados.</p>
        @endforelse

        {{-- enlace para ver todos los patrocinadores --}}
        <div class="text-end mt-2">
          <a href="{{ route('sponsors.index') }}" class="btn btn-link btn-sm">
            Ver todos los patrocinadores
          </a>
        </div>
      </div>

      {{-- BANNERS ESTÁTICOS OPCIONALES --}}
      <div class="ad-box mb-4">
        <img src="{{ asset('img/ads/banner1.jpg') }}" class="img-fluid" alt="Publicidad 1">
      </div>

      <div class="ad-box mb-4">
        <img src="{{ asset('img/ads/banner2.jpg') }}" class="img-fluid" alt="Publicidad 2">
      </div>

    </div>
  </div>
</div>
@endsection
