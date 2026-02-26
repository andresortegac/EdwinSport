{{-- resources/views/events/sponsors.blade.php --}}
@extends('layouts.app')

@section('title', 'Patrocinadores')

@push('styles')
<style>
  nav.navbar { display: none !important; }
  body { padding-top: 0 !important; background: #020617; }
  main.py-4 { padding-top: 0 !important; }

  .sponsors-page {
    min-height: 100vh;
    padding: 2rem 0 2.6rem;
    color: #e5e7eb;
    background:
      radial-gradient(1000px 420px at 10% -5%, rgba(15,118,110,.22), transparent 55%),
      radial-gradient(900px 400px at 95% 0%, rgba(13,148,136,.15), transparent 50%),
      linear-gradient(180deg, #030712, #020617);
  }

  .page-container { max-width: 1180px; }

  .sponsors-header {
    border-radius: 1.25rem;
    padding: 1.35rem 1.5rem;
    border: 1px solid rgba(45,212,191,.26);
    background: linear-gradient(125deg, rgba(15,118,110,.35), rgba(15,23,42,.95) 55%);
    box-shadow: 0 24px 55px rgba(2, 6, 23, .7);
  }

  .sponsors-badge {
    background: rgba(248,250,252,.92);
    color: #0f172a;
    border-radius: 999px;
    padding: .28rem .78rem;
    font-size: .78rem;
    font-weight: 700;
  }

  .sponsors-header-title {
    color: #f8fafc;
    font-size: 2rem;
    margin-bottom: .25rem;
    font-weight: 700;
    letter-spacing: .02em;
  }

  .sponsors-header p { margin: 0; color: #cbd5e1; }

  .updated-label {
    color: #94a3b8;
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .12em;
  }

  .updated-date { color: #f8fafc; font-weight: 700; font-size: .92rem; }

  .back-btn {
    border-radius: 999px;
    border: 1px solid rgba(148,163,184,.7);
    color: #e5e7eb;
    font-size: .84rem;
    padding: .42rem .9rem;
  }

  .back-btn:hover {
    border-color: #14b8a6;
    background: rgba(20,184,166,.14);
    color: #fff;
  }

  .sponsors-main-card {
    border-radius: 1.25rem;
    border: 1px solid rgba(45,212,191,.2);
    background: linear-gradient(180deg, #030b18, #030712);
    box-shadow: 0 24px 80px rgba(2, 6, 23, .86);
  }

  .sponsor-form-card {
    border-radius: 1rem;
    border: 1px solid rgba(55,65,81,.85);
    background: rgba(2, 6, 23, .65);
  }

  .sponsor-form-card h5,
  .sponsors-list-title {
    font-size: .92rem;
    text-transform: uppercase;
    letter-spacing: .11em;
    color: #9ca3af;
    margin-bottom: 1rem;
  }

  .sponsors-page .form-label {
    font-size: .8rem;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .11em;
  }

  .sponsors-page .form-control {
    background: #020617;
    border: 1px solid #374151;
    color: #f8fafc;
    border-radius: .75rem;
    padding: .58rem .85rem;
  }

  .sponsors-page .form-control:focus {
    background: #020617;
    border-color: #14b8a6;
    box-shadow: 0 0 0 1px rgba(20,184,166,.55);
    color: #f8fafc;
  }

  .sponsors-page .form-control::placeholder { color: #6b7280; }

  .upload-box {
    border: 1px dashed rgba(148,163,184,.65);
    border-radius: 12px;
    background: rgba(15,23,42,.55);
    padding: 12px;
  }

  .upload-input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
  }

  .upload-trigger {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 999px;
    padding: .46rem .9rem;
    background: linear-gradient(90deg, #0f766e, #14b8a6);
    color: #fff;
    font-weight: 700;
    font-size: .84rem;
    margin-bottom: 0;
    cursor: pointer;
  }

  .upload-name {
    margin: 10px 0 0;
    color: #cbd5e1;
    font-size: .84rem;
  }

  .upload-preview {
    width: 100%;
    max-height: 130px;
    object-fit: contain;
    border-radius: 10px;
    border: 1px solid rgba(148,163,184,.5);
    background: #0b1120;
    margin-top: 10px;
    display: none;
  }

  .upload-box.has-file .upload-preview { display: block; }

  .sponsor-submit-btn {
    border: 0;
    border-radius: 999px;
    padding: .62rem 1rem;
    font-weight: 700;
    background: linear-gradient(90deg, #0f766e, #14b8a6);
    box-shadow: 0 12px 28px rgba(20,184,166,.35);
  }

  .sponsor-submit-btn:hover {
    transform: translateY(-1px);
    background: linear-gradient(90deg, #0d5f59, #0f766e);
  }

  .sponsors-count {
    font-size: .78rem;
    color: #e5e7eb;
    border: 1px solid rgba(148,163,184,.6);
    border-radius: 999px;
    padding: .24rem .72rem;
  }

  .sponsor-card {
    border-radius: 1rem;
    border: 1px solid rgba(55,65,81,.9);
    background: linear-gradient(180deg, #0b1120, #020617);
    box-shadow: 0 16px 36px rgba(2, 6, 23, .75);
    transition: transform .18s ease, border-color .18s ease;
  }

  .sponsor-card:hover {
    transform: translateY(-3px);
    border-color: #14b8a6;
  }

  .sponsor-logo-wrapper {
    height: 94px;
    border-radius: .8rem;
    border: 1px solid rgba(55,65,81,.85);
    background: #070f1f;
  }

  .sponsor-name {
    color: #f8fafc;
    font-size: .95rem;
    font-weight: 700;
  }

  .sponsor-link-btn {
    border: 1px solid rgba(148,163,184,.8);
    color: #e5e7eb;
    border-radius: 999px;
    font-size: .8rem;
    padding: .35rem .72rem;
  }

  .sponsor-link-btn:hover {
    border-color: #14b8a6;
    background: rgba(20,184,166,.12);
    color: #fff;
  }

  .empty-text { color: #94a3b8; font-size: .92rem; }

  @media (max-width: 991.98px) {
    .sponsors-header-title { font-size: 1.62rem; }
    .sponsors-page { padding-top: 1.4rem; }
  }
</style>
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
                              class="img-fluid"
                              alt="{{ $sponsor->nombre }}"
                              style="max-height:72px; object-fit:contain;"
                              onerror="this.closest('.sponsor-logo-wrapper').innerHTML = '<span class=&quot;text-muted small&quot;>Sin logo</span>'"
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('logo');
  const name = document.getElementById('logo-file-name');
  const preview = document.getElementById('logo-preview');
  const box = document.getElementById('logo-upload');

  if (!input || !name || !preview || !box) return;

  input.addEventListener('change', function () {
    const file = this.files && this.files[0] ? this.files[0] : null;
    if (!file) {
      name.textContent = 'Ningun archivo seleccionado';
      preview.removeAttribute('src');
      box.classList.remove('has-file');
      return;
    }

    name.textContent = file.name;
    box.classList.add('has-file');
    preview.src = URL.createObjectURL(file);
  });
});
</script>
@endsection
