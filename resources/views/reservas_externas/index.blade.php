@extends('layouts.admin-panel')

@section('title', $pageTitle ?? 'Reservas Externas')

@section('admin_content')
<div class="container py-4">
  <div class="mb-4">
    <h2 class="mb-1">{{ $pageTitle ?? 'Reservas externas' }}</h2>
    <p class="text-muted mb-0">{{ $pageSubtitle ?? 'Gestiona las solicitudes de reserva que llegan desde la pagina web Edwin Sport.' }}</p>
  </div>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($errors->has('general'))
    <div class="alert alert-danger">{{ $errors->first('general') }}</div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cancha</th>
            <th>Subcancha</th>
            <th>Cliente</th>
            <th>Telefono</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Sync</th>
            <th>Creada</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($reservas as $reserva)
            <tr>
              <td>{{ $reserva->id }}</td>
              <td>{{ $reserva->cancha->nombre ?? 'Cancha #'.$reserva->cancha_id }}</td>
              <td>{{ $reserva->numero_subcancha }}</td>
              <td>{{ $reserva->nombre_cliente }}</td>
              <td>{{ $reserva->telefono_cliente ?: 'Sin telefono' }}</td>
              <td>{{ $reserva->fecha }}</td>
              <td>{{ \Illuminate\Support\Str::of($reserva->hora)->substr(0, 5) }}</td>
              <td>
                <span class="badge bg-{{ $reserva->estado_solicitud === 'confirmada' ? 'success' : ($reserva->estado_solicitud === 'cancelada' ? 'danger' : 'warning text-dark') }}">
                  {{ ucfirst($reserva->estado_solicitud ?? 'pendiente') }}
                </span>
              </td>
              <td>
                <div class="small">{{ ucfirst(str_replace('_', ' ', $reserva->external_sync_status ?? 'pendiente')) }}</div>
                @if ($reserva->external_sync_message)
                  <div class="text-muted small">{{ $reserva->external_sync_message }}</div>
                @endif
              </td>
              <td>{{ optional($reserva->created_at)->format('Y-m-d H:i') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center py-4 text-muted">
                {{ ($viewMode ?? 'proximas') === 'historial' ? 'No hay historial de reservas externas.' : 'No hay reservas externas registradas.' }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{ $reservas->links() }}
    </div>
  </div>
</div>
@endsection
