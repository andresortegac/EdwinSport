@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/canchas-create.css') }}">
@endpush

@push('scripts')
<script>
    (function () {
        const form = document.querySelector('form[action="{{ route('canchas.store') }}"]');
        const apertura = document.getElementById('hora_apertura');
        const cierre = document.getElementById('hora_cierre');

        if (!form || !apertura || !cierre) return;

        function validarHoras() {
            const ha = apertura.value;
            const hc = cierre.value;

            apertura.classList.remove('is-invalid');
            cierre.classList.remove('is-invalid');

            if (!ha || !hc) return true;

            if (hc <= ha) {
                cierre.classList.add('is-invalid');
                cierre.setCustomValidity('La hora de cierre debe ser mayor que la hora de apertura.');
                return false;
            }

            cierre.setCustomValidity('');
            return true;
        }

        apertura.addEventListener('change', validarHoras);
        cierre.addEventListener('change', validarHoras);

        form.addEventListener('submit', function (e) {
            if (!validarHoras()) {
                e.preventDefault();
                cierre.reportValidity();
            }
        });
    })();
</script>
@endpush

@section('content')
<div class="cancha-create-page py-4 py-lg-5">
    <div class="container">
        <section class="create-hero mb-4 mb-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <p class="eyebrow mb-2">NUEVO ESCENARIO</p>
                    <h1>Registrar una nueva cancha</h1>
                    <p class="hero-copy">
                        Crea el complejo, define horarios operativos y configura la cantidad de canchas internas para iniciar reservas.
                    </p>
                </div>
                <div class="col-lg-5">
                    <div class="helper-box">
                        <h4 class="mb-3">Recomendaciones</h4>
                        <ul class="mb-0">
                            <li>Usa un nombre facil de identificar.</li>
                            <li>Define un horario real de apertura y cierre.</li>
                            <li>Configura correctamente las canchas internas.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        @if(session('success'))
        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <section class="form-shell">
            <form action="{{ route('canchas.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre de la cancha</label>
                        <input id="nombre" type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="num_canchas" class="form-label">Numero de canchas internas (1-4)</label>
                        <select name="num_canchas" id="num_canchas" class="form-select" required>
                            @for ($i = 1; $i <= 4; $i++)
                                <option value="{{ $i }}" {{ old('num_canchas', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" placeholder="Ej: Complejo para torneos y entrenamientos">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="ubicacion" class="form-label">Ubicacion</label>
                        <input id="ubicacion" type="text" name="ubicacion" class="form-control" value="{{ old('ubicacion') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="telefono_contacto" class="form-label">Telefono de contacto</label>
                        <input id="telefono_contacto" type="text" name="telefono_contacto" class="form-control" value="{{ old('telefono_contacto') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="hora_apertura" class="form-label">Hora de apertura</label>
                        <input id="hora_apertura" type="time" name="hora_apertura" class="form-control" value="{{ old('hora_apertura') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="hora_cierre" class="form-label">Hora de cierre</label>
                        <input id="hora_cierre" type="time" name="hora_cierre" class="form-control" value="{{ old('hora_cierre') }}" required>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button class="btn btn-brand" type="submit">Guardar cancha</button>
                    <a href="{{ route('canchas.index') }}" class="btn btn-outline-brand">Cancelar</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
