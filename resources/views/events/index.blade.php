@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">Eventos @if($sport) - {{ ucfirst($sport) }} @endif</h1>

  <div class="mb-4">
    <!-- filtros rápidos -->
    <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm">Todos</a>
    <a href="{{ route('events.bySport','futbol') }}" class="btn btn-outline-secondary btn-sm">Fútbol</a>
    <a href="{{ route('events.bySport','futbol_salon') }}" class="btn btn-outline-secondary btn-sm">Fútbol de salón</a>
    <a href="{{ route('events.bySport','baloncesto') }}" class="btn btn-outline-secondary btn-sm">Baloncesto</a>
    <a href="{{ route('events.bySport','ciclismo') }}" class="btn btn-outline-secondary btn-sm">Ciclismo</a>
    <a href="{{ route('events.bySport','natacion') }}" class="btn btn-outline-secondary btn-sm">Natación</a>
    <a href="{{ route('events.bySport','patinaje') }}" class="btn btn-outline-secondary btn-sm">Patinaje</a>
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
   @yield('content')

    @include('components.footer')
@endsection
