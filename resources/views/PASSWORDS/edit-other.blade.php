@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 520px; margin-top: 30px;">
    <h2 style="margin-bottom: 10px;">
        Cambiar contraseña de {{ $otherUser->role }}
    </h2>

    <p style="margin-bottom: 20px;">
        <strong>Usuario:</strong> {{ $otherUser->email }}
    </p>

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

    <form method="POST" action="{{ route('password.other.update') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">
                Tu contraseña actual (para confirmar)
            </label>
            <input type="password" name="my_current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">
                Nueva contraseña para {{ $otherUser->role }}
            </label>
            <input type="password" name="password" class="form-control" required minlength="8">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required minlength="8">
        </div>

        <button class="btn btn-warning w-100">
            Actualizar contraseña del otro usuario
        </button>
    </form>
</div>
@endsection
