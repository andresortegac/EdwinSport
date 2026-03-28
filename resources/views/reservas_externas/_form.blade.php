@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Cancha</label>
    <select name="cancha_id" class="form-select" required>
      <option value="">Selecciona una cancha</option>
      @foreach ($canchas as $cancha)
        <option value="{{ $cancha->id }}" @selected(old('cancha_id', $reserva->cancha_id ?? '') == $cancha->id)>
          {{ $cancha->nombre }}{{ $cancha->ubicacion ? ' - '.$cancha->ubicacion : '' }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3">
    <label class="form-label">Subcancha</label>
    <input type="number" min="1" name="numero_subcancha" class="form-control" value="{{ old('numero_subcancha', $reserva->numero_subcancha ?? 1) }}" required>
  </div>

  <div class="col-md-3">
    <label class="form-label">Hora</label>
    <input type="time" name="hora" class="form-control" value="{{ old('hora', isset($reserva) ? \Illuminate\Support\Str::of($reserva->hora)->substr(0,5) : '') }}" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Nombre cliente</label>
    <input type="text" name="nombre_cliente" class="form-control" value="{{ old('nombre_cliente', $reserva->nombre_cliente ?? '') }}" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Telefono cliente</label>
    <input type="text" name="telefono_cliente" class="form-control" value="{{ old('telefono_cliente', $reserva->telefono_cliente ?? '') }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">Fecha</label>
    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $reserva->fecha ?? '') }}" required>
  </div>
</div>

<div class="mt-4 d-flex gap-2">
  <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
  <a href="{{ route('reservas_externas.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>
