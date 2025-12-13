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

/* Títulos de la sección */
.wrap.participantes .section-title {
    color: #eaf0ff;
    font-weight: 700;
    margin-bottom: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
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

/* input y select */
.wrap.participantes .field input,
.wrap.participantes .field select,
.wrap.participantes .field textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(8, 16, 32, 0.7);
    color: #eaf0ff;
    outline: none;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

/* inputs on focus */
.wrap.participantes .field input:focus,
.wrap.participantes .field select:focus,
.wrap.participantes .field textarea:focus {
    border-color: rgba(63,97,255,0.75);
    box-shadow: 0 0 0 2px rgba(63,97,255,0.15);
}

/* Botón de guardar jugador */
.wrap.participantes .btn {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    background: linear-gradient(180deg, #3f61ff 0%, #2f4be0 100%);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
    letter-spacing: 0.4px;
    box-shadow: 0 10px 24px rgba(63,97,255,0.25);
}

.wrap.participantes .btn:hover {
    filter: brightness(1.1);
    box-shadow: 0 12px 26px rgba(63,97,255,0.3);
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
    background-color: rgba(63, 97, 255, 0.1);
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
                    <input id="image" type="file" name="image" accept="image/*">
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
          confirmButtonColor: '#3f61ff',
          timer: 3000,
          timerProgressBar: true
      });
  </script>
@endif
