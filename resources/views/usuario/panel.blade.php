@extends('layouts.admin-panel')

@section('title', 'Edwin Sport | Panel')

@section('admin_content')
  @if (session('welcome_message'))
    <div class="alert alert-success welcome-alert">
      {{ session('welcome_message') }}
    </div>
  @endif

  <div class="welcome-panel mb-4">
    <div class="welcome-eyebrow">PANEL PRINCIPAL</div>
    <h1 class="h3 mb-2">Panel del Usuario</h1>
    <p class="mb-0 dashboard-subtitle">
      Bienvenido, {{ auth()->user()?->name ?? 'Admin' }}.
      Desde aqui puedes consultar el estado general del sistema y navegar a reservas externas.
    </p>
  </div>
@endsection
