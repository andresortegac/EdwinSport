@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 520px; margin-top: 30px;">
    <h2 style="margin-bottom: 15px;">Cambiar mi contraseña</h2>

    {{-- Mensaje de éxito --}}
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Mensajes de error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left: 18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.my.update') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Contraseña actual</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required minlength="8">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required minlength="8">
        </div>

        <button class="btn btn-primary w-100">
            Actualizar mi contraseña
        </button>
    </form>
</div>
@endsection
