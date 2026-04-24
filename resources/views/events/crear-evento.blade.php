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

.discipline-first-note {
    margin: 0 0 16px;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid rgba(56, 189, 248, 0.35);
    background: rgba(14, 165, 233, 0.12);
    color: #e6f5ff;
    font-weight: 700;
}

.wrap.participantes .form-grid .field.full {
    grid-column: 1 / -1;
}

.discipline-helper {
    margin: 6px 0 0;
    color: #cde9ff;
    font-size: .92rem;
}

.discipline-block {
    border: 1px solid rgba(148, 163, 184, 0.42);
    border-radius: 12px;
    background: rgba(12, 22, 38, 0.5);
    padding: 14px;
}

.discipline-block.is-hidden {
    display: none;
}

.discipline-title {
    margin: 0 0 8px;
    color: #f1f8ff;
    font-weight: 800;
    letter-spacing: 0.4px;
}

.discipline-subtitle {
    margin: 0 0 10px;
    color: #bfddf4;
    font-size: .9rem;
}

.discipline-subgrid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
}

@media (max-width: 768px) {
    .discipline-subgrid {
        grid-template-columns: 1fr;
    }
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
    <p class="discipline-first-note">Paso 1: selecciona primero la disciplina deportiva del evento.</p>
    <br>

    <form action="{{ route('crear-evento.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card" role="form">

            <h3 class="section-title">Información del evento</h3>

            <div class="form-grid">

                {{-- DISCIPLINA / DEPORTE (PRIMERO) --}}
                <div class="field">
                    <label for="category">Disciplina deportiva</label>
                    <select id="category" name="category" required>
                        <option value="" hidden {{ old('category') ? '' : 'selected' }}>Seleccione disciplina...</option>
                        <option value="futbol" {{ old('category') === 'futbol' ? 'selected' : '' }}>Futbol</option>
                        <option value="baloncesto" {{ old('category') === 'baloncesto' ? 'selected' : '' }}>Baloncesto</option>
                        <option value="voleibol" {{ old('category') === 'voleibol' ? 'selected' : '' }}>Voleibol</option>
                        <option value="futbol_salon" {{ old('category') === 'futbol_salon' ? 'selected' : '' }}>Futbol de salon</option>
                        <option value="natacion" {{ old('category') === 'natacion' ? 'selected' : '' }}>Natacion</option>
                        <option value="ciclismo" {{ old('category') === 'ciclismo' ? 'selected' : '' }}>Ciclismo</option>
                        <option value="crossfit" {{ old('category') === 'crossfit' ? 'selected' : '' }}>Crossfit</option>
                        <option value="patinaje" {{ old('category') === 'patinaje' ? 'selected' : '' }}>Patinaje</option>
                        <option value="atletismo" {{ old('category') === 'atletismo' ? 'selected' : '' }}>Atletismo</option>
                        <option value="tenis" {{ old('category') === 'tenis' ? 'selected' : '' }}>Tenis</option>
                        <option value="otro" {{ old('category') === 'otro' ? 'selected' : '' }}>Otra disciplina</option>
                    </select>
                    <p class="discipline-helper">Según la disciplina se habilitan campos de registro específicos.</p>
                </div>

                <div id="category-custom-wrap" class="field" style="{{ old('category') === 'otro' ? '' : 'display:none;' }}">
                    <label for="category_custom">Especifica la disciplina</label>
                    <input
                        id="category_custom"
                        type="text"
                        name="category_custom"
                        value="{{ old('category_custom') }}"
                        placeholder="Ej: Rugby, Boxeo, Calistenia"
                    >
                </div>

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
                           value="{{ old('slug') }}">
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
                        <option value="" hidden {{ old('status') ? '' : 'selected' }}>Seleccione estado...</option>
                        <option value="activo" {{ old('status') === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('status') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="cerrado" {{ old('status') === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </div>

                {{-- CAMPOS DINAMICOS: DEPORTES DE EQUIPO --}}
                <div class="field full discipline-block is-hidden" data-discipline-group="team">
                    <h4 class="discipline-title">Configuracion para deportes de equipo</h4>
                    <p class="discipline-subtitle">Aplica para futbol, futbol de salon, baloncesto y voleibol.</p>
                    <div class="discipline-subgrid">
                        <div class="field">
                            <label for="team_format">Formato de competencia</label>
                            <select id="team_format" name="team_format" data-when-required="1">
                                <option value="" hidden {{ old('team_format') ? '' : 'selected' }}>Seleccione formato...</option>
                                <option value="liga" {{ old('team_format') === 'liga' ? 'selected' : '' }}>Liga</option>
                                <option value="copa" {{ old('team_format') === 'copa' ? 'selected' : '' }}>Copa</option>
                                <option value="eliminacion" {{ old('team_format') === 'eliminacion' ? 'selected' : '' }}>Eliminacion directa</option>
                                <option value="grupos_y_eliminacion" {{ old('team_format') === 'grupos_y_eliminacion' ? 'selected' : '' }}>Grupos y eliminacion</option>
                                <option value="amistoso" {{ old('team_format') === 'amistoso' ? 'selected' : '' }}>Amistoso</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="team_count">Numero de equipos</label>
                            <input id="team_count" type="number" name="team_count" min="2" max="128" value="{{ old('team_count') }}" data-when-required="1" placeholder="Ej: 16">
                        </div>

                        <div class="field">
                            <label for="team_players_per_team">Jugadores por equipo</label>
                            <input id="team_players_per_team" type="number" name="team_players_per_team" min="3" max="30" value="{{ old('team_players_per_team') }}" data-when-required="1" placeholder="Ej: 11">
                        </div>

                        <div class="field">
                            <label for="team_match_duration_min">Duracion por partido (min)</label>
                            <input id="team_match_duration_min" type="number" name="team_match_duration_min" min="10" max="180" value="{{ old('team_match_duration_min') }}" data-when-required="1" placeholder="Ej: 90">
                        </div>
                    </div>
                </div>

                {{-- CAMPOS DINAMICOS: ATLETISMO --}}
                <div class="field full discipline-block is-hidden" data-discipline-group="atletismo">
                    <h4 class="discipline-title">Configuracion para atletismo</h4>
                    <p class="discipline-subtitle">Define prueba, distancia y cupos para la jornada atletica.</p>
                    <div class="discipline-subgrid">
                        <div class="field">
                            <label for="athletics_modality">Modalidad</label>
                            <select id="athletics_modality" name="athletics_modality" data-when-required="1">
                                <option value="" hidden {{ old('athletics_modality') ? '' : 'selected' }}>Seleccione modalidad...</option>
                                <option value="pista" {{ old('athletics_modality') === 'pista' ? 'selected' : '' }}>Pista</option>
                                <option value="campo" {{ old('athletics_modality') === 'campo' ? 'selected' : '' }}>Campo</option>
                                <option value="ruta" {{ old('athletics_modality') === 'ruta' ? 'selected' : '' }}>Ruta</option>
                                <option value="trail" {{ old('athletics_modality') === 'trail' ? 'selected' : '' }}>Trail</option>
                                <option value="maraton" {{ old('athletics_modality') === 'maraton' ? 'selected' : '' }}>Maraton</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="athletics_distance_m">Distancia principal (metros)</label>
                            <input id="athletics_distance_m" type="number" name="athletics_distance_m" min="50" max="100000" value="{{ old('athletics_distance_m') }}" data-when-required="1" placeholder="Ej: 1500">
                        </div>

                        <div class="field">
                            <label for="athletics_heat_count">Numero de pruebas/series</label>
                            <input id="athletics_heat_count" type="number" name="athletics_heat_count" min="1" max="50" value="{{ old('athletics_heat_count') }}" data-when-required="1" placeholder="Ej: 8">
                        </div>

                        <div class="field">
                            <label for="athletics_participant_cap">Cupo de participantes</label>
                            <input id="athletics_participant_cap" type="number" name="athletics_participant_cap" min="2" max="5000" value="{{ old('athletics_participant_cap') }}" data-when-required="1" placeholder="Ej: 120">
                        </div>
                    </div>
                </div>

                {{-- CAMPOS DINAMICOS: CICLISMO --}}
                <div class="field full discipline-block is-hidden" data-discipline-group="ciclismo">
                    <h4 class="discipline-title">Configuracion para ciclismo</h4>
                    <p class="discipline-subtitle">Define modalidad, kilometraje y estructura del recorrido.</p>
                    <div class="discipline-subgrid">
                        <div class="field">
                            <label for="cycling_modality">Modalidad</label>
                            <select id="cycling_modality" name="cycling_modality" data-when-required="1">
                                <option value="" hidden {{ old('cycling_modality') ? '' : 'selected' }}>Seleccione modalidad...</option>
                                <option value="ruta" {{ old('cycling_modality') === 'ruta' ? 'selected' : '' }}>Ruta</option>
                                <option value="mtb" {{ old('cycling_modality') === 'mtb' ? 'selected' : '' }}>MTB</option>
                                <option value="pista" {{ old('cycling_modality') === 'pista' ? 'selected' : '' }}>Pista</option>
                                <option value="bmx" {{ old('cycling_modality') === 'bmx' ? 'selected' : '' }}>BMX</option>
                                <option value="crono" {{ old('cycling_modality') === 'crono' ? 'selected' : '' }}>Contrarreloj</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="cycling_distance_km">Distancia total (km)</label>
                            <input id="cycling_distance_km" type="number" name="cycling_distance_km" min="1" max="500" step="0.1" value="{{ old('cycling_distance_km') }}" data-when-required="1" placeholder="Ej: 85.5">
                        </div>

                        <div class="field">
                            <label for="cycling_elevation_m">Desnivel acumulado (m)</label>
                            <input id="cycling_elevation_m" type="number" name="cycling_elevation_m" min="0" max="10000" value="{{ old('cycling_elevation_m') }}" data-when-required="1" placeholder="Ej: 1200">
                        </div>

                        <div class="field">
                            <label for="cycling_stage_count">Numero de etapas</label>
                            <input id="cycling_stage_count" type="number" name="cycling_stage_count" min="1" max="30" value="{{ old('cycling_stage_count') }}" data-when-required="1" placeholder="Ej: 3">
                        </div>
                    </div>
                </div>

                {{-- CAMPOS DINAMICOS: NATACION --}}
                <div class="field full discipline-block is-hidden" data-discipline-group="natacion">
                    <h4 class="discipline-title">Configuracion para natacion</h4>
                    <p class="discipline-subtitle">Configura tipo de prueba, estilo y parametros de piscina/recorrido.</p>
                    <div class="discipline-subgrid">
                        <div class="field">
                            <label for="swim_environment">Tipo de escenario</label>
                            <select id="swim_environment" name="swim_environment" data-when-required="1">
                                <option value="" hidden {{ old('swim_environment') ? '' : 'selected' }}>Seleccione escenario...</option>
                                <option value="piscina" {{ old('swim_environment') === 'piscina' ? 'selected' : '' }}>Piscina</option>
                                <option value="aguas_abiertas" {{ old('swim_environment') === 'aguas_abiertas' ? 'selected' : '' }}>Aguas abiertas</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="swim_style">Estilo principal</label>
                            <select id="swim_style" name="swim_style" data-when-required="1">
                                <option value="" hidden {{ old('swim_style') ? '' : 'selected' }}>Seleccione estilo...</option>
                                <option value="libre" {{ old('swim_style') === 'libre' ? 'selected' : '' }}>Libre</option>
                                <option value="pecho" {{ old('swim_style') === 'pecho' ? 'selected' : '' }}>Pecho</option>
                                <option value="espalda" {{ old('swim_style') === 'espalda' ? 'selected' : '' }}>Espalda</option>
                                <option value="mariposa" {{ old('swim_style') === 'mariposa' ? 'selected' : '' }}>Mariposa</option>
                                <option value="mixto" {{ old('swim_style') === 'mixto' ? 'selected' : '' }}>Mixto</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="swim_distance_m">Distancia (metros)</label>
                            <input id="swim_distance_m" type="number" name="swim_distance_m" min="25" max="10000" value="{{ old('swim_distance_m') }}" data-when-required="1" placeholder="Ej: 400">
                        </div>

                        <div class="field">
                            <label for="swim_lane_count">Numero de carriles</label>
                            <input id="swim_lane_count" type="number" name="swim_lane_count" min="1" max="20" value="{{ old('swim_lane_count') }}" data-when-required="1" placeholder="Ej: 8">
                        </div>
                    </div>
                </div>

                {{-- CAMPOS DINAMICOS: CROSSFIT --}}
                <div class="field full discipline-block is-hidden" data-discipline-group="crossfit">
                    <h4 class="discipline-title">Configuracion para crossfit</h4>
                    <p class="discipline-subtitle">Registra nivel competitivo, WODs y estructura de heats.</p>
                    <div class="discipline-subgrid">
                        <div class="field">
                            <label for="crossfit_level">Nivel</label>
                            <select id="crossfit_level" name="crossfit_level" data-when-required="1">
                                <option value="" hidden {{ old('crossfit_level') ? '' : 'selected' }}>Seleccione nivel...</option>
                                <option value="iniciacion" {{ old('crossfit_level') === 'iniciacion' ? 'selected' : '' }}>Iniciacion</option>
                                <option value="intermedio" {{ old('crossfit_level') === 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                                <option value="rx" {{ old('crossfit_level') === 'rx' ? 'selected' : '' }}>RX</option>
                                <option value="elite" {{ old('crossfit_level') === 'elite' ? 'selected' : '' }}>Elite</option>
                                <option value="master" {{ old('crossfit_level') === 'master' ? 'selected' : '' }}>Master</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="crossfit_wod_count">Numero de WODs</label>
                            <input id="crossfit_wod_count" type="number" name="crossfit_wod_count" min="1" max="20" value="{{ old('crossfit_wod_count') }}" data-when-required="1" placeholder="Ej: 5">
                        </div>

                        <div class="field">
                            <label for="crossfit_heat_duration_min">Duracion por heat (min)</label>
                            <input id="crossfit_heat_duration_min" type="number" name="crossfit_heat_duration_min" min="5" max="120" value="{{ old('crossfit_heat_duration_min') }}" data-when-required="1" placeholder="Ej: 20">
                        </div>

                        <div class="field">
                            <label for="crossfit_athlete_cap">Cupo de atletas</label>
                            <input id="crossfit_athlete_cap" type="number" name="crossfit_athlete_cap" min="2" max="500" value="{{ old('crossfit_athlete_cap') }}" data-when-required="1" placeholder="Ej: 80">
                        </div>
                    </div>
                </div>

                {{-- CAMPOS DINAMICOS: DISCIPLINAS GENERALES --}}
                <div class="field full discipline-block is-hidden" data-discipline-group="generic">
                    <h4 class="discipline-title">Configuracion para disciplina general</h4>
                    <p class="discipline-subtitle">Completa estos datos cuando la disciplina no entra en los grupos anteriores.</p>
                    <div class="discipline-subgrid">
                        <div class="field">
                            <label for="generic_competition_type">Tipo de competencia</label>
                            <input id="generic_competition_type" type="text" name="generic_competition_type" maxlength="120" value="{{ old('generic_competition_type') }}" data-when-required="1" placeholder="Ej: Ranking, exhibicion, circuito">
                        </div>

                        <div class="field">
                            <label for="generic_participant_cap">Cupo de participantes</label>
                            <input id="generic_participant_cap" type="number" name="generic_participant_cap" min="1" max="10000" value="{{ old('generic_participant_cap') }}" data-when-required="1" placeholder="Ej: 150">
                        </div>

                        <div class="field full">
                            <label for="generic_notes">Reglas o notas especiales</label>
                            <textarea id="generic_notes" name="generic_notes" rows="3" placeholder="Ej: requisitos de equipamiento, categorias por edad">{{ old('generic_notes') }}</textarea>
                        </div>
                    </div>
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
    const category = document.getElementById('category');
    const categoryCustomWrap = document.getElementById('category-custom-wrap');
    const categoryCustomInput = document.getElementById('category_custom');
    const disciplineBlocks = Array.from(document.querySelectorAll('[data-discipline-group]'));

    if (input && name && preview && upload) {
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
    }

    if (!category) {
      return;
    }

    const groupedDisciplines = {
      team: ['futbol', 'futbol_salon', 'baloncesto', 'voleibol'],
      atletismo: ['atletismo'],
      ciclismo: ['ciclismo'],
      natacion: ['natacion'],
      crossfit: ['crossfit']
    };

    function resolveGroup(selectedDiscipline) {
      const value = (selectedDiscipline || '').trim().toLowerCase();
      if (!value) return '';

      for (const [groupName, values] of Object.entries(groupedDisciplines)) {
        if (values.includes(value)) {
          return groupName;
        }
      }

      return 'generic';
    }

    function syncCategoryCustom() {
      if (!categoryCustomWrap || !categoryCustomInput) return;
      const isOther = category.value === 'otro';
      categoryCustomWrap.style.display = isOther ? '' : 'none';
      categoryCustomInput.required = isOther;
    }

    function syncDisciplineBlocks() {
      const activeGroup = resolveGroup(category.value);

      disciplineBlocks.forEach((block) => {
        const shouldShow = activeGroup !== '' && block.dataset.disciplineGroup === activeGroup;
        block.classList.toggle('is-hidden', !shouldShow);

        block.querySelectorAll('input, select, textarea').forEach((field) => {
          if (field.dataset.whenRequired === '1') {
            field.required = shouldShow;
          }
        });
      });
    }

    syncCategoryCustom();
    syncDisciplineBlocks();

    category.addEventListener('change', () => {
      syncCategoryCustom();
      syncDisciplineBlocks();
    });
  });
</script>
