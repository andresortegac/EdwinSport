@extends('layouts.admin-panel')

@section('title', 'Editar Reserva Externa')

@section('admin_content')
<div class="container py-4">
  <h2 class="mb-4">Editar reserva externa #{{ $reserva->id }}</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <form action="{{ route('reservas_externas.update', $reserva) }}" method="POST">
        @csrf
        @method('PUT')
        @php($submitLabel = 'Actualizar reserva')
        @include('reservas_externas._form')
      </form>
    </div>
  </div>
</div>
@endsection
