{{-- resources/views/events/crear-evento.blade.php --}}

<style>
/* Estilo de la sección de "Agregar Jugadores / Participantes" */
.wrap.participantes {
    width: 100%;
    max-width: 950px;
    margin: 0 auto;
    padding: 24px;
    background: #1c2331;
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

/* ✅ Títulos de la sección (AQUÍ cambia el color de "CREAR EVENTO") */
.wrap.participantes .section-title {
    color: #ffffff; /* ✅ CAMBIO: antes #eaf0ff */
    font-weight: 700;
    margin-bottom: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

/* Título principal del formulario con alto contraste */
.wrap.formulario-evento .hero-title {
    color: #f8fafc !important;
    text-align: center;
    font-weight: 700;
    letter-spacing: 1px;
    text-shadow: 0 8px 24px rgba(2, 6, 23, 0.55);
    margin-bottom: 10px;
}

/* ✅ Labels blancas (por si usas <label> dentro de .field) */
.wrap.participantes .field label {
    color: #ffffff; /* ✅ CAMBIO */
    font-weight: 700;
}

/* Estilo de los campos dentro de "Agregar Jugadores / Participantes" */
.wrap.participantes .form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.wrap.participantes .field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* ✅ input y select (blancos) */
.wrap.participantes .field input,
.wrap.participantes .field select,
.wrap.participantes .field textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid rgba(148,163,184,0.9); /* ✅ CAMBIO: borde más visible */
    background: #ffffff; /* ✅ CAMBIO: antes rgba(8, 16, 32, 0.7) */
    color: #0f172a;      /* ✅ CAMBIO: antes #eaf0ff */
    outline: none;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

/* inputs on focus */
.wrap.participantes .field input:focus,
.wrap.participantes .field select:focus,
.wrap.participantes .field textarea:focus {
    border-color: rgba(20,184,166,0.75);
    box-shadow: 0 0 0 2px rgba(20,184,166,0.18);
}

/* Botón de guardar jugador */
.wrap.participantes .btn {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    background: linear-gradient(180deg, #0f766e 0%, #0d5f59 100%);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
    letter-spacing: 0.4px;
    box-shadow: 0 10px 24px rgba(15,118,110,0.28);
}

.wrap.participantes .btn:hover {
    filter: brightness(1.1);
    box-shadow: 0 12px 26px rgba(15,118,110,0.34);
}

.wrap.participantes .btn:active {
    transform: translateY(1px);
}

/* Estilo de la sección de equipos registrados */
.wrap.participantes .table {
    width: 100%;
    margin-top: 20px;
    border-radius: 12px;
    overflow: hidden;
}

.wrap.participantes .table th, .wrap.participantes .table td {
    padding: 12px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    text-align: left;
}

.wrap.participantes .table th {
    background-color: #2b3746;
    color: #eaf0ff;
    font-weight: bold;
}

.wrap.participantes .table tr:hover {
    background-color: rgba(20, 184, 166, 0.12);
}

/* Uploader moderno */
.file-upload {
    border: 1px dashed rgba(148,163,184,0.65);
    border-radius: 12px;
    background: rgba(15, 23, 42, 0.45);
    padding: 14px;
}

.file-input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
    pointer-events: none;
}

.file-upload-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    width: fit-content;
    background: linear-gradient(180deg, #0f766e 0%, #0d5f59 100%);
    color: #ffffff;
    font-weight: 700;
    border-radius: 999px;
    padding: 10px 14px;
    cursor: pointer;
    margin: 0;
    box-shadow: 0 8px 18px rgba(15,118,110,0.3);
}

.file-upload-name {
    margin: 10px 0 0;
    color: #cbd5e1;
    font-size: .95rem;
}

.file-upload-preview {
    margin-top: 12px;
    width: 100%;
    max-height: 220px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid rgba(148,163,184,0.6);
    display: none;
}

.file-upload.has-file .file-upload-preview {
    display: block;
}

/* Ajuste para dispositivos móviles */
@media (max-width: 768px) {
    .wrap.participantes .form-grid {
        grid-template-columns: 1fr;
    }
    .wrap.participantes .btn {
        width: 100%;
    }
}
</style>




@if ($errors->any())
  <div style="background:#fee;border:1px solid #f99;padding:12px;border-radius:8px;margin-bottom:12px;">
    <strong>Errores:</strong>
    <ul>
      @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
  </div>
@endif

<div class="wrap formulario-evento">

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

@if (session('success'))
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Operación exitosa',
          text: "{{ session('success') }}",
          confirmButtonColor: '#0f766e',
          timer: 3000,
          timerProgressBar: true
      });
  </script>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const name = document.getElementById('image-file-name');
    const preview = document.getElementById('image-preview');
    const upload = document.getElementById('image-upload');

    if (!input || !name || !preview || !upload) return;

    input.addEventListener('change', function () {
      const file = this.files && this.files[0] ? this.files[0] : null;

      if (!file) {
        name.textContent = 'Ningun archivo seleccionado';
        preview.removeAttribute('src');
        upload.classList.remove('has-file');
        return;
      }

      name.textContent = file.name;
      upload.classList.add('has-file');
      preview.src = URL.createObjectURL(file);
    });
  });
</script>
