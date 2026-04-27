@php
    $storeSubmenuDefault = session('store_success') ? 'store-submenu-published' : 'store-submenu-form';
    if ($errors->storeItem->any()) {
        $storeSubmenuDefault = 'store-submenu-form';
    }
@endphp

<div class="card shadow mb-4 store-module">
    <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h6 class="m-0 font-weight-bold">Modulo de tiendas</h6>
        <span class="store-module-chip">Carga y visualizacion</span>
    </div>

    <div class="card-body">
        <p class="store-module-help mb-3">
            Usa este submenu para registrar productos y revisar toda la informacion de empresa/catalogo en un solo lugar.
        </p>

        @if(session('store_success'))
            <div class="alert alert-success">
                {{ session('store_success') }}
                <a class="alert-link ml-2" href="{{ route('shop.index') }}">
                    Ver tienda
                </a>
            </div>
        @endif

        @if($errors->storeItem->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->storeItem->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="store-submenu" data-store-submenu data-store-submenu-default="{{ $storeSubmenuDefault }}">
            <button type="button" class="store-submenu-btn" data-store-submenu-target="store-submenu-form">
                Ingresar formulario
            </button>
            <button type="button" class="store-submenu-btn" data-store-submenu-target="store-submenu-published">
                Ver informacion cargada
            </button>
        </div>

        <section class="store-subpanel" data-store-submenu-panel="store-submenu-form">
            @if(auth()->check() && auth()->user()->isAdmin())
                <form action="{{ route('shop.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label" for="store_name">Nombre del producto</label>
                        <input
                            id="store_name"
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Ej: Uniforme de ciclismo"
                            required
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="store_category">Categoria</label>
                        <input
                            id="store_category"
                            type="text"
                            name="category"
                            class="form-control"
                            value="{{ old('category') }}"
                            placeholder="Ciclismo"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="store_price">Precio</label>
                        <input
                            id="store_price"
                            type="number"
                            step="0.01"
                            min="0"
                            name="price"
                            class="form-control"
                            value="{{ old('price') }}"
                            placeholder="69000"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="store_currency">Moneda</label>
                        <input
                            id="store_currency"
                            type="text"
                            name="currency"
                            class="form-control"
                            value="{{ old('currency', 'COP') }}"
                            placeholder="COP"
                        >
                    </div>

                    <div class="col-md-9">
                        <label class="form-label" for="store_purchase_url">Link de compra (opcional)</label>
                        <input
                            id="store_purchase_url"
                            type="url"
                            name="purchase_url"
                            class="form-control"
                            value="{{ old('purchase_url') }}"
                            placeholder="https://..."
                        >
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="store_description">Informacion breve del producto</label>
                        <textarea
                            id="store_description"
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Descripcion corta para mostrar en la tienda."
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_image">Imagen principal del producto</label>
                        <div class="store-upload-card">
                            <input
                                id="store_image"
                                type="file"
                                name="image"
                                class="store-upload-input"
                                accept=".jpg,.jpeg,.png,.webp,.gif"
                            >
                            <label for="store_image" class="store-upload-trigger">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Seleccionar imagen</span>
                            </label>
                            <p id="store-image-file-name" class="store-upload-file-name mb-0">
                                Ningun archivo seleccionado
                            </p>
                            <small class="store-module-help d-block mt-1">
                                Formatos: JPG, JPEG, PNG, WEBP, GIF (max. 4MB).
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_image_url">URL imagen principal (opcional)</label>
                        <input
                            id="store_image_url"
                            type="url"
                            name="image_url"
                            class="form-control"
                            value="{{ old('image_url') }}"
                            placeholder="https://images..."
                        >
                        <small class="store-module-help d-block mt-1">
                            Si subes archivo local, ese se usa primero.
                        </small>
                    </div>

                    <div class="col-12">
                        <div id="store-image-preview-shell" class="store-image-preview-shell is-empty">
                            <img id="store-image-preview" alt="Vista previa de imagen del producto">
                            <div class="store-image-preview-empty">
                                <i class="fas fa-image"></i>
                                <span>Vista previa de imagen principal</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <h6 class="store-subtitle mb-1">Informacion de la empresa</h6>
                        <p class="store-module-help mb-0">
                            Estos datos se muestran al dar clic en <strong>Ver informacion</strong>.
                        </p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="store_company_name">Nombre de la empresa</label>
                        <input
                            id="store_company_name"
                            type="text"
                            name="company_name"
                            class="form-control"
                            value="{{ old('company_name') }}"
                            placeholder="Ej: Edwin Sport Store"
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="store_company_phone">Telefono / celular</label>
                        <input
                            id="store_company_phone"
                            type="text"
                            name="company_phone"
                            class="form-control"
                            value="{{ old('company_phone') }}"
                            placeholder="3001234567"
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="store_company_email">Correo electronico</label>
                        <input
                            id="store_company_email"
                            type="email"
                            name="company_email"
                            class="form-control"
                            value="{{ old('company_email') }}"
                            placeholder="ventas@empresa.com"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_company_location">Direccion / ubicacion</label>
                        <input
                            id="store_company_location"
                            type="text"
                            name="company_location"
                            class="form-control"
                            value="{{ old('company_location') }}"
                            placeholder="Barranquilla, Colombia"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_company_website">Sitio web (opcional)</label>
                        <input
                            id="store_company_website"
                            type="url"
                            name="company_website"
                            class="form-control"
                            value="{{ old('company_website') }}"
                            placeholder="https://miempresa.com"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_company_logo">Logo de la empresa</label>
                        <div class="store-upload-card">
                            <input
                                id="store_company_logo"
                                type="file"
                                name="company_logo"
                                class="store-upload-input"
                                accept=".jpg,.jpeg,.png,.webp,.gif,.svg"
                            >
                            <label for="store_company_logo" class="store-upload-trigger">
                                <i class="fas fa-briefcase"></i>
                                <span>Seleccionar logo</span>
                            </label>
                            <p id="store-company-logo-file-name" class="store-upload-file-name mb-0">
                                Ningun archivo seleccionado
                            </p>
                            <small class="store-module-help d-block mt-1">
                                Formatos: JPG, PNG, WEBP, GIF, SVG (max. 4MB).
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_company_logo_url">URL logo (opcional)</label>
                        <input
                            id="store_company_logo_url"
                            type="url"
                            name="company_logo_url"
                            class="form-control"
                            value="{{ old('company_logo_url') }}"
                            placeholder="https://logo..."
                        >
                    </div>

                    <div class="col-12">
                        <div id="store-logo-preview-shell" class="store-image-preview-shell store-logo-preview-shell is-empty">
                            <img id="store-logo-preview" alt="Vista previa del logo de la empresa">
                            <div class="store-image-preview-empty">
                                <i class="fas fa-building"></i>
                                <span>Vista previa del logo</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <h6 class="store-subtitle mb-1">Catalogo de fotos con carrusel</h6>
                        <p class="store-module-help mb-0">
                            Sube varias fotos del producto o pega enlaces (uno por linea) para mostrarlas en carrusel.
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_catalog_images">Fotos del catalogo</label>
                        <div class="store-upload-card">
                            <input
                                id="store_catalog_images"
                                type="file"
                                name="catalog_images[]"
                                class="store-upload-input"
                                accept=".jpg,.jpeg,.png,.webp,.gif"
                                multiple
                            >
                            <label for="store_catalog_images" class="store-upload-trigger">
                                <i class="fas fa-images"></i>
                                <span>Seleccionar fotos</span>
                            </label>
                            <p id="store-catalog-files-name" class="store-upload-file-name mb-0">
                                Ningun archivo seleccionado
                            </p>
                            <small id="store-catalog-files-counter" class="store-module-help d-block mt-1">
                                0 fotos seleccionadas
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="store_catalog_image_urls">URLs del catalogo (opcional)</label>
                        <textarea
                            id="store_catalog_image_urls"
                            name="catalog_image_urls"
                            class="form-control"
                            rows="4"
                            placeholder="https://dominio.com/foto-1.jpg&#10;https://dominio.com/foto-2.jpg"
                        >{{ old('catalog_image_urls') }}</textarea>
                        <small class="store-module-help d-block mt-1">
                            Escribe un enlace por linea.
                        </small>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="store_catalog_summary">Informacion breve del catalogo</label>
                        <textarea
                            id="store_catalog_summary"
                            name="catalog_summary"
                            class="form-control"
                            rows="3"
                            placeholder="Ej: Coleccion 2026 con telas ligeras y secado rapido."
                        >{{ old('catalog_summary') }}</textarea>
                    </div>

                    <div class="col-12">
                        <div id="store-catalog-preview-grid" class="store-catalog-preview-grid">
                            <div class="store-catalog-preview-empty">
                                Aun no has agregado fotos al catalogo.
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary store-submit-btn">
                            Guardar en tienda
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning mb-4">
                    Solo un administrador puede publicar productos en la tienda.
                </div>
            @endif
        </section>

        <section class="store-subpanel d-none" data-store-submenu-panel="store-submenu-published">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Productos publicados</h6>
                <span class="badge badge-info px-3 py-2">{{ ($storeItems ?? collect())->count() }} items</span>
            </div>

            @if(($storeItems ?? collect())->count() > 0)
                <div class="row g-3">
                    @foreach($storeItems as $item)
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

                            $cardImage = $item->image_path
                                ? route('shop.media', ['path' => ltrim(str_replace('\\', '/', (string) $item->image_path), '/')])
                                : ($item->image_url ?: ($catalogImages->first() ?: null));

                            $companyLogo = $item->company_logo_path
                                ? route('shop.media', ['path' => ltrim(str_replace('\\', '/', (string) $item->company_logo_path), '/')])
                                : ($item->company_logo_url ?: null);
                        @endphp

                        <div class="col-md-6 col-xl-4">
                            <article
                                class="store-card-item h-100 store-card-clickable"
                                data-store-open-modal="store-company-modal-{{ $item->id }}"
                                role="button"
                                tabindex="0"
                                aria-label="Ver informacion de {{ $item->name }}"
                            >
                                <div class="store-card-media {{ $cardImage ? '' : 'is-fallback' }}">
                                    @if($cardImage)
                                        <img
                                            src="{{ $cardImage }}"
                                            alt="{{ $item->name }}"
                                            class="store-card-image"
                                            loading="lazy"
                                            referrerpolicy="no-referrer"
                                            onerror="this.style.display='none'; this.parentElement.classList.add('is-fallback');"
                                        >
                                    @endif
                                    <div class="store-card-fallback">
                                        <i class="fas fa-image"></i>
                                        <span>Sin imagen valida</span>
                                    </div>
                                </div>

                                <div class="store-card-body">
                                    <h6 class="mb-1">{{ $item->name }}</h6>
                                    <p class="mb-1 text-muted">{{ $item->category ?: 'Producto' }}</p>
                                    @if(!empty($item->price))
                                        <div class="store-price mb-2">${{ number_format((float) $item->price, 0, ',', '.') }} {{ $item->currency ?: 'COP' }}</div>
                                    @endif
                                    <p class="store-description mb-2">{{ $item->description ?: 'Sin descripcion.' }}</p>
                                    <p class="store-company-line mb-2">
                                        <i class="fas fa-building"></i>
                                        {{ $item->company_name ?: 'Empresa no registrada' }}
                                    </p>

                                    <div class="store-card-actions">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-light"
                                            data-store-open-modal="store-company-modal-{{ $item->id }}"
                                        >
                                            Ver informacion
                                        </button>
                                        @if($item->purchase_url)
                                            <a
                                                href="{{ $item->purchase_url }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                Ir al enlace
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </article>

                            <div class="modal fade" id="store-company-modal-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content store-modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Informacion de empresa y catalogo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="store-company-header">
                                                <div class="store-company-logo {{ $companyLogo ? '' : 'is-empty' }}">
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

                                            <ul class="store-company-list mt-3">
                                                <li><span>Telefono</span><strong>{{ $item->company_phone ?: 'Sin dato' }}</strong></li>
                                                <li><span>Correo</span><strong>{{ $item->company_email ?: 'Sin dato' }}</strong></li>
                                                <li><span>Lugar</span><strong>{{ $item->company_location ?: 'Sin dato' }}</strong></li>
                                                <li><span>Sitio web</span><strong>{{ $item->company_website ?: 'Sin dato' }}</strong></li>
                                            </ul>

                                            @if($item->catalog_summary)
                                                <div class="store-catalog-summary">
                                                    {{ $item->catalog_summary }}
                                                </div>
                                            @endif

                                            @if($catalogImages->count() > 0)
                                                <div
                                                    id="store-catalog-carousel-{{ $item->id }}"
                                                    class="carousel slide store-catalog-carousel mt-3"
                                                    data-ride="carousel"
                                                    data-interval="4200"
                                                >
                                                    @if($catalogImages->count() > 1)
                                                        <ol class="carousel-indicators">
                                                            @foreach($catalogImages as $catalogIndex => $catalogImage)
                                                                <li
                                                                    data-target="#store-catalog-carousel-{{ $item->id }}"
                                                                    data-slide-to="{{ $catalogIndex }}"
                                                                    class="{{ $catalogIndex === 0 ? 'active' : '' }}"
                                                                ></li>
                                                            @endforeach
                                                        </ol>
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
                                                        <a class="carousel-control-prev" href="#store-catalog-carousel-{{ $item->id }}" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Anterior</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#store-catalog-carousel-{{ $item->id }}" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Siguiente</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="store-empty-catalog mt-3">
                                                    Aun no hay fotos cargadas en el catalogo.
                                                </div>
                                            @endif

                                            @if($item->company_website)
                                                <a href="{{ $item->company_website }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-info mt-3">
                                                    Abrir sitio web
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mb-0">Aun no has publicado productos. Usa el formulario para agregar el primero.</p>
            @endif

            @if(($externalStoreItems ?? collect())->count() > 0)
                <hr class="my-4">
                <h6 class="mb-3">Contenido externo de apoyo</h6>
                <div class="row g-3">
                    @foreach($externalStoreItems->take(3) as $ext)
                        <div class="col-md-6 col-xl-4">
                            <article class="store-card-item h-100">
                                <div class="store-card-media {{ !empty($ext['image_url']) ? '' : 'is-fallback' }}">
                                    @if(!empty($ext['image_url']))
                                        <img
                                            src="{{ $ext['image_url'] }}"
                                            alt="{{ $ext['name'] ?? 'Item externo' }}"
                                            class="store-card-image"
                                            loading="lazy"
                                            referrerpolicy="no-referrer"
                                            onerror="this.style.display='none'; this.parentElement.classList.add('is-fallback');"
                                        >
                                    @endif
                                    <div class="store-card-fallback">
                                        <i class="fas fa-image"></i>
                                        <span>Imagen externa no disponible</span>
                                    </div>
                                </div>
                                <div class="store-card-body">
                                    <h6 class="mb-1">{{ $ext['name'] ?? 'Item externo' }}</h6>
                                    <p class="mb-1 text-muted">{{ $ext['category'] ?? 'Categoria' }}</p>
                                    @if(!empty($ext['price']))
                                        <div class="store-price mb-2">{{ $ext['price'] }}</div>
                                    @endif
                                    <p class="store-description mb-2">{{ $ext['description'] ?? '' }}</p>
                                    @if(!empty($ext['purchase_url']))
                                        <a href="{{ $ext['purchase_url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary">
                                            Ver referencia
                                        </a>
                                    @endif
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</div>
