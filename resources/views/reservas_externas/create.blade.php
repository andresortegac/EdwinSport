@extends('layouts.admin-panel')

@section('title', 'Nueva Reserva Externa')

@section('admin_content')
<div class="container py-4">
  <h2 class="mb-4">Nueva reserva externa</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <form action="{{ route('reservas_externas.store') }}" method="POST">
        @csrf
        @php($submitLabel = 'Guardar reserva')
        @include('reservas_externas._form')
      </form>
    </div>
  </div>
</div>
@endsection
