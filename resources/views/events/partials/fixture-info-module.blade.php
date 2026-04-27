@php
    $fixturePostMaxSize = (string) (ini_get('post_max_size') ?: '8M');
    $fixtureUploadMaxSize = (string) (ini_get('upload_max_filesize') ?: '2M');
@endphp

<div class="card shadow mb-4 fixture-info-module">
    <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h6 class="m-0 font-weight-bold">Modulo de informacion del encuentro</h6>
        <span class="fixture-module-chip">Menu lateral - por partido</span>
    </div>

    <div class="card-body">
        <p class="fixture-module-help mb-3">
            Todo lo que guardes aqui (marcador, tarjetas, resumen, fotos y videos) aparece en el detalle del encuentro:
            <code>/eventos/{event}/fixture/{grupo}/{jornada}/{partido}</code>.
        </p>

        @if(session('fixture_report_success'))
            <div id="fixture-report-success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Datos guardados correctamente.</strong>
                <span class="ml-1">{{ session('fixture_report_success') }}</span>
                @if(session('fixture_report_url'))
                    <a class="alert-link ml-2" href="{{ session('fixture_report_url') }}" target="_blank" rel="noopener noreferrer">
                        Ver encuentro
                    </a>
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->fixtureReport->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->fixtureReport->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(auth()->check() && auth()->user()->isAdmin())
            <form
                id="fixture-report-form-panel"
                method="POST"
                action="{{ route('events.fixture.report.store') }}"
                enctype="multipart/form-data"
                class="row g-3"
                data-post-max-size="{{ $fixturePostMaxSize }}"
                data-upload-max-size="{{ $fixtureUploadMaxSize }}"
            >
                @csrf

                <div class="col-12">
                    <h5 class="fixture-subtitle">Ubicacion del partido</h5>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="fixture_event_id">Evento (ID)</label>
                    <input id="fixture_event_id" type="number" name="event_id" class="form-control" min="1" value="{{ old('event_id') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="fixture_grupo_id">Grupo (ID)</label>
                    <input id="fixture_grupo_id" type="number" name="grupo_id" class="form-control" min="1" value="{{ old('grupo_id') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="fixture_jornada">Jornada</label>
                    <input id="fixture_jornada" type="number" name="jornada" class="form-control" min="1" value="{{ old('jornada') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="fixture_partido_numero">Partido (indice URL)</label>
                    <input id="fixture_partido_numero" type="number" name="partido_numero" class="form-control" min="0" value="{{ old('partido_numero') }}" required>
                </div>

                <div class="col-12">
                    <a id="fixture-preview-link" class="btn btn-outline-info btn-sm d-none" href="#" target="_blank" rel="noopener noreferrer">
                        Abrir vista previa del encuentro
                    </a>
                </div>

                <div class="col-12">
                    <h5 class="fixture-subtitle">Resultado y tarjetas</h5>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_score_local">Marcador local</label>
                    <input id="fixture_score_local" type="number" name="score_local" class="form-control" min="0" max="99" value="{{ old('score_local') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_score_visitante">Marcador visitante</label>
                    <input id="fixture_score_visitante" type="number" name="score_visitante" class="form-control" min="0" max="99" value="{{ old('score_visitante') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_yellow_cards">Tarjetas amarillas local</label>
                    <textarea id="fixture_local_yellow_cards" name="local_yellow_cards" class="form-control" rows="3" placeholder="Un jugador por linea">{{ old('local_yellow_cards') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_yellow_cards">Tarjetas amarillas visitante</label>
                    <textarea id="fixture_visitante_yellow_cards" name="visitante_yellow_cards" class="form-control" rows="3" placeholder="Un jugador por linea">{{ old('visitante_yellow_cards') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_red_cards">Tarjetas rojas local</label>
                    <textarea id="fixture_local_red_cards" name="local_red_cards" class="form-control" rows="3" placeholder="Un jugador por linea">{{ old('local_red_cards') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_red_cards">Tarjetas rojas visitante</label>
                    <textarea id="fixture_visitante_red_cards" name="visitante_red_cards" class="form-control" rows="3" placeholder="Un jugador por linea">{{ old('visitante_red_cards') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_blue_cards">Tarjetas azules local (opcional)</label>
                    <textarea id="fixture_local_blue_cards" name="local_blue_cards" class="form-control" rows="3" placeholder="Un jugador por linea">{{ old('local_blue_cards') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_blue_cards">Tarjetas azules visitante (opcional)</label>
                    <textarea id="fixture_visitante_blue_cards" name="visitante_blue_cards" class="form-control" rows="3" placeholder="Un jugador por linea">{{ old('visitante_blue_cards') }}</textarea>
                </div>

                <div class="col-12">
                    <h5 class="fixture-subtitle">Desenlace y contenido multimedia</h5>
                    <p class="fixture-module-help mb-0">
                        Limite actual del servidor: POST {{ $fixturePostMaxSize }}, archivo {{ $fixtureUploadMaxSize }}.
                    </p>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_lineup">Jugadores local que jugaron</label>
                    <textarea id="fixture_local_lineup" name="local_lineup" class="form-control" rows="4" placeholder="Un jugador por linea">{{ old('local_lineup') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_lineup">Jugadores visitante que jugaron</label>
                    <textarea id="fixture_visitante_lineup" name="visitante_lineup" class="form-control" rows="4" placeholder="Un jugador por linea">{{ old('visitante_lineup') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_top_scorer">Jugador local con mas goles</label>
                    <input id="fixture_local_top_scorer" type="text" name="local_top_scorer" class="form-control" value="{{ old('local_top_scorer') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_top_scorer_goals">Goles del goleador local</label>
                    <input id="fixture_local_top_scorer_goals" type="number" name="local_top_scorer_goals" class="form-control" min="0" max="99" value="{{ old('local_top_scorer_goals') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_top_scorer">Jugador visitante con mas goles</label>
                    <input id="fixture_visitante_top_scorer" type="text" name="visitante_top_scorer" class="form-control" value="{{ old('visitante_top_scorer') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_top_scorer_goals">Goles del goleador visitante</label>
                    <input id="fixture_visitante_top_scorer_goals" type="number" name="visitante_top_scorer_goals" class="form-control" min="0" max="99" value="{{ old('visitante_top_scorer_goals') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_best_goalkeeper">Arquero local destacado</label>
                    <input id="fixture_local_best_goalkeeper" type="text" name="local_best_goalkeeper" class="form-control" value="{{ old('local_best_goalkeeper') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_local_goalkeeper_goals_conceded">Goles recibidos arquero local</label>
                    <input id="fixture_local_goalkeeper_goals_conceded" type="number" name="local_goalkeeper_goals_conceded" class="form-control" min="0" max="99" value="{{ old('local_goalkeeper_goals_conceded') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_best_goalkeeper">Arquero visitante destacado</label>
                    <input id="fixture_visitante_best_goalkeeper" type="text" name="visitante_best_goalkeeper" class="form-control" value="{{ old('visitante_best_goalkeeper') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="fixture_visitante_goalkeeper_goals_conceded">Goles recibidos arquero visitante</label>
                    <input id="fixture_visitante_goalkeeper_goals_conceded" type="number" name="visitante_goalkeeper_goals_conceded" class="form-control" min="0" max="99" value="{{ old('visitante_goalkeeper_goals_conceded') }}">
                </div>

                <div class="col-md-6">
                    <div class="media-upload-card media-upload-images">
                        <div class="media-upload-head">
                            <h6 class="media-upload-title">
                                <i class="fas fa-camera-retro"></i>
                                Fotos del encuentro
                            </h6>
                            <span id="fixture_media_images_counter" class="media-upload-kpi">0 seleccionadas</span>
                        </div>
                        <p class="media-upload-copy">Sube evidencias fotograficas del partido para mostrar en el detalle.</p>
                        <input id="fixture_media_images" type="file" name="media_images[]" class="media-upload-input" accept=".jpg,.jpeg,.png,.webp,.gif" multiple>
                        <label for="fixture_media_images" class="media-upload-trigger">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Seleccionar fotos
                        </label>
                        <small class="fixture-module-help">Maximo 12 fotos por guardado (6MB por foto).</small>
                        <div id="fixture_media_images_preview" class="media-upload-preview-grid"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="media-upload-card media-upload-videos">
                        <div class="media-upload-head">
                            <h6 class="media-upload-title">
                                <i class="fas fa-video"></i>
                                Videos del encuentro
                            </h6>
                            <span id="fixture_media_videos_counter" class="media-upload-kpi">0 seleccionados</span>
                        </div>
                        <p class="media-upload-copy">Carga clips clave del desenlace: goles, jugadas o momentos disciplinarios.</p>
                        <input id="fixture_media_videos" type="file" name="media_videos[]" class="media-upload-input" accept=".mp4,.mov,.webm,.avi,.mkv" multiple>
                        <label for="fixture_media_videos" class="media-upload-trigger">
                            <i class="fas fa-film"></i>
                            Seleccionar videos
                        </label>
                        <small class="fixture-module-help">Maximo 4 videos por guardado (50MB por video).</small>
                        <div id="fixture_media_videos_preview" class="media-upload-preview-grid"></div>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label" for="fixture_highlights">Resumen del encuentro</label>
                    <textarea id="fixture_highlights" name="highlights" class="form-control" rows="4" placeholder="Ej: minuto a minuto, expulsiones, goles, incidencias">{{ old('highlights') }}</textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary fixture-submit-btn">
                        Guardar informacion del encuentro
                    </button>
                </div>
            </form>
        @else
            <div class="alert alert-warning mb-0">
                Solo un administrador puede guardar informacion del encuentro.
            </div>
        @endif
    </div>
</div>

@if(session('fixture_report_success'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = @json(session('fixture_report_success'));
        var successAlert = document.getElementById('fixture-report-success-alert');

        if (successAlert && typeof successAlert.scrollIntoView === 'function') {
            successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        window.setTimeout(function () {
            window.alert(successMessage || 'Datos guardados correctamente.');
        }, 120);
    });
    </script>
@endif
