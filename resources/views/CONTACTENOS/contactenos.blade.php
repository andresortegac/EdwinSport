@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/contactenos.css') }}">
@endpush

@section('content')
<div class="contact-page py-4 py-lg-5">
    <div class="container">
        <section class="contact-hero mb-4 mb-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <p class="eyebrow mb-2">CONTACTO COMERCIAL Y DEPORTIVO</p>
                    <h1>Hablemos de tu evento, torneo o escuela deportiva</h1>
                    <p class="hero-copy">Completa el formulario y nuestro equipo revisara tu solicitud para ayudarte con organizacion, escenarios, logistica y administracion deportiva.</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel">
                        <h4 class="mb-2">Respuesta rapida</h4>
                        <p class="mb-0">Atendemos solicitudes en horario de oficina y priorizamos eventos con fecha cercana.</p>
                    </div>
                </div>
            </div>
        </section>

        @if(session('success'))
            <div class="alert alert-success rounded-3">{{ session('success') }}</div>
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

        <section class="contact-shell">
            <form action="{{ route('contactenos.store') }}" method="POST" novalidate>
                @csrf

                <h3 class="section-title">Informacion de contacto</h3>
                <div class="form-grid">
                    <div class="field">
                        <label for="tipo">Tipo de solicitante</label>
                        <select id="tipo" name="tipo" required>
                            <option value="" disabled {{ old('tipo') ? '' : 'selected' }} hidden>Seleccione tipo...</option>
                            <option value="natural" {{ old('tipo') === 'natural' ? 'selected' : '' }}>Persona Natural</option>
                            <option value="empresa" {{ old('tipo') === 'empresa' ? 'selected' : '' }}>Empresa</option>
                            <option value="escuela" {{ old('tipo') === 'escuela' ? 'selected' : '' }}>Escuela Deportiva</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="nombre_completo">Nombres y apellidos</label>
                        <input id="nombre_completo" type="text" name="nombre_completo" value="{{ old('nombre_completo') }}"
                               placeholder="Ej: Juan Perez" autocomplete="name" required>
                    </div>

                    <div class="field">
                        <label for="documento">Documento de identidad</label>
                        <input id="documento" type="text" name="documento" value="{{ old('documento') }}"
                               placeholder="Ej: 1023456789" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <label for="telefono_natural">Telefono</label>
                        <input id="telefono_natural" type="text" name="telefono_natural" value="{{ old('telefono_natural') }}"
                               placeholder="Ej: +57 300 123 4567" autocomplete="tel">
                    </div>

                    <div class="field">
                        <label for="correo_electronico">Correo electronico</label>
                        <input id="correo_electronico" type="email" name="correo_electronico" value="{{ old('correo_electronico') }}"
                               placeholder="ejemplo@correo.com" autocomplete="email" required>
                    </div>

                    <div class="field">
                        <label for="razon_social">Nombre de la entidad</label>
                        <input id="razon_social" type="text" name="razon_social" value="{{ old('razon_social') }}"
                               placeholder="Si aplica, nombre de la entidad" autocomplete="organization">
                    </div>
                </div>

                <h3 class="section-title mt-4">Informacion del evento</h3>
                <div class="form-grid">
                    <div class="field">
                        <label for="evento_nombre">Nombre del evento</label>
                        <input id="evento_nombre" type="text" name="evento_nombre" value="{{ old('evento_nombre') }}"
                               placeholder="Ej: Torneo Intercolegial 2026">
                    </div>

                    <div class="field">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" required>
                            <option value="" disabled {{ old('categoria') ? '' : 'selected' }} hidden>Seleccione categoria...</option>
                            <option value="hombres" {{ old('categoria') === 'hombres' ? 'selected' : '' }}>Hombres</option>
                            <option value="mujeres" {{ old('categoria') === 'mujeres' ? 'selected' : '' }}>Mujeres</option>
                            <option value="infantil" {{ old('categoria') === 'infantil' ? 'selected' : '' }}>Infantil</option>
                            <option value="mixto_adultos" {{ old('categoria') === 'mixto_adultos' ? 'selected' : '' }}>Mixto adultos</option>
                            <option value="mixto_infantil" {{ old('categoria') === 'mixto_infantil' ? 'selected' : '' }}>Mixto infantil</option>
                        </select>
                    </div>

                    <div class="field full">
                        <label for="descripcion">Descripcion del evento</label>
                        <textarea id="descripcion" name="descripcion" rows="5"
                                  placeholder="Describe brevemente el objetivo, numero de participantes, edad aproximada y necesidades logísticas.">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="field">
                        <label for="fecha_inicial">Fecha inicial del evento</label>
                        <input id="fecha_inicial" type="date" name="fecha_inicial" value="{{ old('fecha_inicial') }}">
                    </div>

                    <div class="field">
                        <label for="fecha_final">Fecha final del evento</label>
                        <input id="fecha_final" type="date" name="fecha_final" value="{{ old('fecha_final') }}">
                    </div>
                </div>

                <button class="btn btn-brand w-100 mt-4" type="submit">Enviar solicitud</button>
            </form>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const telInput = document.getElementById('telefono_natural');
    const docInput = document.getElementById('documento');

    telInput?.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9+\-() ]/g, '');
    });

    docInput?.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush
