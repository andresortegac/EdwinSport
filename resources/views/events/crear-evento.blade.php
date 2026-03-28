@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/views/events/create.css') }}">
@endpush
{{-- resources/views/events/crear-evento.blade.php --}}






@if ($errors->any())
  <div style="background:#fee;border:1px solid #f99;padding:12px;border-radius:8px;margin-bottom:12px;">
    <strong>Errores:</strong>
    <ul>
      @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
  </div>
@endif

<div class="wrap formulario-evento" data-event-create data-success-message="{{ session('success') }}">

    <h1 class="hero-title">CREAR EVENTO</h1>
    <br>

    <form action="{{ route('crear-evento.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card" role="form">

            <h3 class="section-title">Información del evento</h3>

            <div class="form-grid">

                {{-- TITULO --}}
                <div class="field">
                    <label for="title">Título del evento</label>
                    <input id="title" type="text" name="title"
                           placeholder="Ej: Torneo Interbarrios 2026"
                           value="{{ old('title') }}" required>
                </div>

                {{-- SLUG --}}
                <div class="field">
                    <label for="slug">Slug</label>
                    <input id="slug" type="text" name="slug"
                           placeholder="Ej: torneo-interbarrios-2026"
                           value="{{ old('slug') }}" required>
                </div>

                {{-- CATEGORÍA --}}
                <div class="field">
                    <label for="category">Categoría</label>
                    <select id="category" name="category" required>
                        <option value="" hidden selected>Seleccione categoría...</option>
                        <option value="hombres">Hombres</option>
                        <option value="mujeres">Mujeres</option>
                        <option value="mixto">Mixto</option>
                        <option value="infantil">Infantil</option>
                        <option value="juvenil">Juvenil</option>
                        <option value="adultos">Adultos</option>
                    </select>
                </div>

                {{-- FECHA INICIO --}}
                <div class="field">
                    <label for="start_at">Fecha de inicio</label>
                    <input id="start_at" type="datetime-local" name="start_at"
                           value="{{ old('start_at') }}" required>
                </div>

                {{-- FECHA FINAL --}}
                <div class="field">
                    <label for="end_at">Fecha final</label>
                    <input id="end_at" type="datetime-local" name="end_at"
                           value="{{ old('end_at') }}">
                </div>

                {{-- UBICACIÓN --}}
                <div class="field">
                    <label for="location">Lugar / Dirección</label>
                    <input id="location" type="text" name="location"
                           placeholder="Ej: Coliseo Municipal"
                           value="{{ old('location') }}" required>
                </div>

                {{-- DESCRIPCION --}}
                <div class="field full">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" rows="5"
                              placeholder="Detalles del evento">{{ old('description') }}</textarea>
                </div>

                {{-- IMAGEN --}}
                <div class="field full">
                    <label for="image">Imagen del evento</label>
                    <div class="file-upload" id="image-upload">
                        <input id="image" class="file-input" type="file" name="image" accept="image/*">
                        <label class="file-upload-trigger" for="image">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Subir imagen
                        </label>
                        <p id="image-file-name" class="file-upload-name">Ningun archivo seleccionado</p>
                        <img id="image-preview" class="file-upload-preview" alt="Vista previa de la imagen">
                    </div>
                </div>

                {{-- ESTADO --}}
                <div class="field">
                    <label for="status">Estado</label>
                    <select id="status" name="status" required>
                        <option value="" hidden selected>Seleccione estado...</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="cerrado">Cerrado</option>
                    </select>
                </div>

            </div>

            <button class="btn" type="submit">GUARDAR EVENTO</button>
          
        </div>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/views/events/create.js') }}"></script>

