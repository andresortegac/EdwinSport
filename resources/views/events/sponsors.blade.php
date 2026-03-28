{{-- resources/views/events/sponsors.blade.php --}}
@extends('layouts.app')

@section('title', 'Patrocinadores')

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/views/events/sponsors.css') }}">
@endpush

@section('content')
<div class="sponsors-page">
  <div class="container page-container">

    <div class="sponsors-header mb-3">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
          <span class="sponsors-badge d-inline-flex align-items-center gap-2 mb-2">
            <i class="fas fa-bullseye"></i> Gestion de Patrocinadores
          </span>
          <h2 class="sponsors-header-title">Sponsors del Evento</h2>
          <p>Administra logos y enlaces de marcas que apoyan tus torneos.</p>
        </div>
        <div class="text-md-end">
          <span class="updated-label d-block">Ultima actualizacion</span>
          <span class="updated-date">{{ now()->format('d M Y, H:i') }}</span>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <a href="{{ url('/eventos/crear-evento-developer') }}" class="btn btn-sm back-btn d-inline-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i>
        Volver a crear evento
      </a>
    </div>

    <div class="card sponsors-main-card border-0">
      <div class="card-body p-4 p-md-5">

        @if (session('success'))
          <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger mb-4">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="row g-4">
          <div class="col-lg-5">
            <div class="sponsor-form-card p-3 p-md-4">
              <h5>Agregar nuevo sponsor</h5>

              <form action="{{ route('sponsors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                  <label class="form-label" for="nombre">Nombre del sponsor</label>
                  <input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                  @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                  <label class="form-label" for="url">URL (opcional)</label>
                  <input id="url" type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" placeholder="https://tusponsor.com">
                  @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                  <label class="form-label" for="logo">Logo / imagen</label>
                  <div class="upload-box" id="logo-upload">
                    <input id="logo" type="file" name="logo" class="upload-input" accept="image/*" required>
                    <label class="upload-trigger" for="logo">
                      <i class="fas fa-cloud-upload-alt"></i>
                      Subir logo
                    </label>
                    <p id="logo-file-name" class="upload-name">Ningun archivo seleccionado</p>
                    <img id="logo-preview" class="upload-preview" alt="Vista previa del logo">
                  </div>
                  @error('logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                  <small class="text-muted d-block mt-1">Formatos: JPG, JPEG, PNG, WEBP, GIF. Max 2MB.</small>
                </div>

                <button type="submit" class="btn sponsor-submit-btn w-100 mt-2">Guardar sponsor</button>
              </form>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="sponsors-list-title mb-0">Sponsors actuales</h5>
              <span class="sponsors-count">{{ $sponsors->count() }} registrados</span>
            </div>

            @if ($sponsors->count())
              <div class="row g-3">
                @foreach ($sponsors as $sponsor)
                  <div class="col-sm-6 col-md-4">
                    <div class="card sponsor-card h-100 border-0">
                      <div class="pt-3 px-3">
                        <div class="sponsor-logo-wrapper d-flex align-items-center justify-content-center">
                          @if ($sponsor->logo)
                            <img
                              src="{{ route('sponsors.media', ['path' => ltrim($sponsor->logo, '/')]) }}"
                              data-sponsor-logo
                              class="img-fluid"
                              alt="{{ $sponsor->nombre }}"
                              style="max-height:72px; object-fit:contain;"
                            >
                          @else
                            <span class="text-muted small">Sin logo</span>
                          @endif
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column">
                        <h6 class="sponsor-name mt-3 mb-2 text-truncate">{{ $sponsor->nombre }}</h6>
                        @if ($sponsor->url)
                          <a href="{{ $sponsor->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm sponsor-link-btn mt-auto align-self-start">Ver sitio</a>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <p class="empty-text mb-0">No hay sponsors registrados todavia. Agrega el primero usando el formulario.</p>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script src="{{ asset('js/views/events/sponsors.js') }}"></script>
@endpush
@endsection

