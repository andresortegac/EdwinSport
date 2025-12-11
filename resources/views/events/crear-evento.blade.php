{{-- resources/views/events/crear-evento.blade.php --}}

<style>
/* ====== CENTRADO FORM CREAR EVENTO ====== */
.wrap.formulario-evento{
    width: 100%;
    max-width: 950px;  /* ancho del formulario */
    margin: 0 auto;    /* ✅ centra horizontalmente */
    padding: 24px;
}

/* el form ocupa todo el contenedor */
.wrap.formulario-evento form{
    width: 100%;
}

/* tarjeta */
.wrap.formulario-evento .card{
    width: 100%;
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

/* grid del formulario */
.form-grid{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-top: 16px;
}

.field{
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field.full{
    grid-column: 1 / -1;
}

.field input,
.field select,
.field textarea{
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #dcdcdc;
    border-radius: 8px;
    outline: none;
}

.field input:focus,
.field select:focus,
.field textarea:focus{
    border-color: #3f61ff;
    box-shadow: 0 0 0 2px rgba(63,97,255,0.15);
}

/* botón */
.btn{
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    background: #3f61ff;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.btn:hover{
    background: #2f4be0;
}

/* responsive */
@media (max-width: 768px){
    .form-grid{
        grid-template-columns: 1fr;
    }
}
</style>


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
