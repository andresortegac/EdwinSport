@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <img src="{{ asset('img/'.$event->image) }}" class="img-fluid mb-3" alt="">
      <h1>{{ $event->title }}</h1>
      <p><strong>Disciplina:</strong> {{ ucfirst($event->sport) }}</p>
      <p><strong>Fecha:</strong> {{ $event->start_at->format('d M, Y H:i') }}</p>
      <p><strong>Lugar:</strong> {{ $event->location }}</p>
      <p>{{ $event->description }}</p>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <p><strong>Categoría:</strong> {{ $event->category }}</p>
        <p><strong>Cupos:</strong> {{ $event->capacity }}</p>
        <p><strong>Precio:</strong> ${{ $event->price }}</p>
        <a href="#" class="btn btn-success w-100">Inscribirme</a>
      </div>
    </div>
  </div>
</div>
@endsection
