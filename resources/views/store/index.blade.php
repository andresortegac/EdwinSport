@extends('layouts.app')

@section('title', 'Ver tienda | Edwin Sport')

@push('styles')
<link rel="stylesheet" href="{{ asset('CSS/views/store/index.css') }}">
@endpush

@section('content')
<section class="store-page">
    <div class="container">
        <div class="store-head mb-4">
            <p class="store-eyebrow mb-1">TIENDA DEPORTIVA</p>
            <h1 class="store-title mb-2">Ver tienda</h1>
            <p class="store-copy mb-0">
                Aqui se muestra todo lo que subiste desde <code>/eventos/crear-evento-developer</code> en el modulo de tiendas.
            </p>
        </div>

        @if(($uploadedItems ?? collect())->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="store-section-title mb-0">Productos publicados</h2>
                <span class="badge rounded-pill bg-success px-3 py-2">{{ $uploadedItems->count() }} items</span>
            </div>

            <div class="row g-4 mb-5">
                @foreach($uploadedItems as $item)
                    @php
                        $catalogImages = collect(is_array($item->catalog_images) ? $item->catalog_images : [])
                            ->map(function ($entry) {
                                if (is_array($entry)) {
                                    $entryType = (string) ($entry['type'] ?? '');
                                    if ($entryType === 'upload' && !empty($entry['path'])) {
                                        return route('shop.media', ['path' => ltrim(str_replace('\\', '/', (string) $entry['path']), '/')]);
                                    }

                                    if ($entryType === 'url' && !empty($entry['url'])) {
                                        return trim((string) $entry['url']);
                                    }

                                    return null;
                                }

                                if (is_string($entry) && trim($entry) !== '') {
                                    $raw = trim($entry);
                                    if (preg_match('/^https?:\/\//i', $raw)) {
                                        return $raw;
                                    }

                                    return route('shop.media', ['path' => ltrim(str_replace('\\', '/', $raw), '/')]);
                                }

                                return null;
                            })
                            ->filter()
                            ->values();

                        $image = $item->image_path
                            ? route('shop.media', ['path' => ltrim(str_replace('\\', '/', (string) $item->image_path), '/')])
                            : ($item->image_url ?: ($catalogImages->first() ?: null));

                        $priceText = $item->price !== null
                            ? '$' . number_format((float) $item->price, 0, ',', '.') . ' ' . ($item->currency ?: 'COP')
                            : 'Precio por confirmar';

                        $companyLogo = $item->company_logo_path
                            ? route('shop.media', ['path' => ltrim(str_replace('\\', '/', (string) $item->company_logo_path), '/')])
                            : ($item->company_logo_url ?: null);
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <article class="shop-card h-100">
                            <div class="shop-card-media {{ $image ? '' : 'is-fallback' }}">
                                @if($image)
                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $item->name }}"
                                        class="shop-card-image"
                                        loading="lazy"
                                        referrerpolicy="no-referrer"
                                        onerror="this.style.display='none'; this.parentElement.classList.add('is-fallback');"
                                    >
                                @endif
                                <div class="shop-card-fallback">
                                    <i class="bi bi-image"></i>
                                    <span>Imagen no disponible</span>
                                </div>
                            </div>
                            <div class="shop-card-body">
                                <h3 class="shop-card-title">{{ $item->name }}</h3>
                                <p class="shop-card-category">{{ $item->category ?: 'Producto' }}</p>
                                <p class="shop-card-price">{{ $priceText }}</p>
                                <p class="shop-card-description">{{ $item->description ?: 'Sin descripcion cargada.' }}</p>

                                <div class="shop-card-actions">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-light mt-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#shop-info-modal-{{ $item->id }}"
                                    >
                                        Ver informacion
                                    </button>

                                    @if($item->purchase_url)
                                        <a href="{{ $item->purchase_url }}" class="btn btn-sm btn-outline-info mt-2" target="_blank" rel="noopener noreferrer">
                                            Ir al enlace
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>

                        <div class="modal fade" id="shop-info-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content shop-modal-content">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title">Informacion de empresa y catalogo</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="shop-company-header">
                                            <div class="shop-company-logo {{ $companyLogo ? '' : 'is-empty' }}">
                                                @if($companyLogo)
                                                    <img
                                                        src="{{ $companyLogo }}"
                                                        alt="Logo de {{ $item->company_name ?: $item->name }}"
                                                        loading="lazy"
                                                        referrerpolicy="no-referrer"
                                                        onerror="this.style.display='none'; this.parentElement.classList.add('is-empty');"
                                                    >
                                                @endif
                                                <span>Logo</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $item->company_name ?: 'Empresa no registrada' }}</h6>
                                                <p class="mb-0 text-muted">{{ $item->name }}</p>
                                            </div>
                                        </div>

                                        <ul class="shop-company-list mt-3">
                                            <li><span>Telefono</span><strong>{{ $item->company_phone ?: 'Sin dato' }}</strong></li>
                                            <li><span>Correo</span><strong>{{ $item->company_email ?: 'Sin dato' }}</strong></li>
                                            <li><span>Lugar</span><strong>{{ $item->company_location ?: 'Sin dato' }}</strong></li>
                                            <li><span>Sitio web</span><strong>{{ $item->company_website ?: 'Sin dato' }}</strong></li>
                                        </ul>

                                        @if($item->catalog_summary)
                                            <div class="shop-catalog-summary">
                                                {{ $item->catalog_summary }}
                                            </div>
                                        @endif

                                        @if($catalogImages->count() > 0)
                                            <div id="shop-catalog-carousel-{{ $item->id }}" class="carousel slide shop-catalog-carousel mt-3">
                                                @if($catalogImages->count() > 1)
                                                    <div class="carousel-indicators">
                                                        @foreach($catalogImages as $catalogIndex => $catalogImage)
                                                            <button
                                                                type="button"
                                                                data-bs-target="#shop-catalog-carousel-{{ $item->id }}"
                                                                data-bs-slide-to="{{ $catalogIndex }}"
                                                                class="{{ $catalogIndex === 0 ? 'active' : '' }}"
                                                                aria-label="Slide {{ $catalogIndex + 1 }}"
                                                            ></button>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <div class="carousel-inner">
                                                    @foreach($catalogImages as $catalogIndex => $catalogImage)
                                                        <div class="carousel-item {{ $catalogIndex === 0 ? 'active' : '' }}">
                                                            <img
                                                                src="{{ $catalogImage }}"
                                                                class="d-block w-100"
                                                                alt="Catalogo {{ $item->name }} - {{ $catalogIndex + 1 }}"
                                                                loading="lazy"
                                                                referrerpolicy="no-referrer"
                                                            >
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if($catalogImages->count() > 1)
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#shop-catalog-carousel-{{ $item->id }}" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Anterior</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#shop-catalog-carousel-{{ $item->id }}" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Siguiente</span>
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <div class="shop-empty-catalog mt-3">
                                                Aun no hay fotos de catalogo para este producto.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mb-5">
                Aun no hay productos publicados desde el panel. Abre el modulo de tiendas para cargar el primero.
            </div>
        @endif

        @if(($externalItems ?? collect())->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="store-section-title mb-0">Contenido externo para inspiracion</h2>
                <span class="badge rounded-pill bg-primary px-3 py-2">{{ $externalItems->count() }} referencias</span>
            </div>

            <div class="row g-4">
                @foreach($externalItems as $item)
                    @php
                        $extImage = $item['image_url'] ?? null;
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <article class="shop-card external h-100">
                            <div class="shop-card-media {{ $extImage ? '' : 'is-fallback' }}">
                                @if(!empty($extImage))
                                    <img
                                        src="{{ $extImage }}"
                                        alt="{{ $item['name'] ?? 'Producto externo' }}"
                                        class="shop-card-image"
                                        loading="lazy"
                                        referrerpolicy="no-referrer"
                                        onerror="this.style.display='none'; this.parentElement.classList.add('is-fallback');"
                                    >
                                @endif
                                <div class="shop-card-fallback">
                                    <i class="bi bi-image"></i>
                                    <span>Imagen externa no disponible</span>
                                </div>
                            </div>
                            <div class="shop-card-body">
                                <h3 class="shop-card-title">{{ $item['name'] ?? 'Producto externo' }}</h3>
                                <p class="shop-card-category">{{ $item['category'] ?? 'Categoria' }}</p>
                                <p class="shop-card-price">{{ $item['price'] ?? 'Precio referencial' }}</p>
                                <p class="shop-card-description">{{ $item['description'] ?? '' }}</p>
                                @if(!empty($item['purchase_url']))
                                    <a href="{{ $item['purchase_url'] }}" class="btn btn-sm btn-outline-light mt-2" target="_blank" rel="noopener noreferrer">
                                        Ver referencia
                                    </a>
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
