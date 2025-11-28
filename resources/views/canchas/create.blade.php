@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nueva Cancha</h2>

    @if(session('success'))
        <div style="background: #c8e6c9; padding: 10px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- errores --}}
    @if ($errors->any())
        <div style="background:#ffcdd2; padding:10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('canchas.store') }}" method="POST">
        @csrf

        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>

        <label>Descripción:</label>
        <input type="text" name="descripcion" class="form-control" required>

        <label>Ubicación:</label>
        <input type="text" name="ubicacion" class="form-control" required>

        <label>Teléfono de contacto:</label>
        <input type="text" name="telefono_contacto" class="form-control" required>

        <label>Hora apertura:</label>
        <input type="time" name="hora_apertura" class="form-control" required>

        <label>Hora cierre:</label>
        <input type="time" name="hora_cierre" class="form-control" required>

        <br>
        <button class="btn btn-primary" type="submit">Guardar Cancha</button>
    </form>
</div>
@endsection
