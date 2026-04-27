document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('contenedor-formulario');
  var list = document.getElementById('contenedor-listado');
  var fixtureInfo = document.getElementById('contenedor-info-encuentro');
  var storeModule = document.getElementById('contenedor-modulo-tiendas');

  function activar(idBtn) {
    document.querySelectorAll('.sidebar .nav-item').forEach(function (item) {
      item.classList.remove('active');
    });

    var btn = document.getElementById(idBtn);
    if (btn && btn.closest('.nav-item')) {
      btn.closest('.nav-item').classList.add('active');
    }
  }

  function mostrarFormulario() {
    if (form) form.style.display = 'block';
    if (list) list.style.display = 'none';
    if (fixtureInfo) fixtureInfo.style.display = 'none';
    if (storeModule) storeModule.style.display = 'none';
    activar('btn-crear-evento');
  }

  function mostrarListado() {
    if (form) form.style.display = 'none';
    if (list) list.style.display = 'block';
    if (fixtureInfo) fixtureInfo.style.display = 'none';
    if (storeModule) storeModule.style.display = 'none';
    activar('btn-listado-eventos');
  }

  function mostrarInfoEncuentro() {
    if (form) form.style.display = 'none';
    if (list) list.style.display = 'none';
    if (fixtureInfo) fixtureInfo.style.display = 'block';
    if (storeModule) storeModule.style.display = 'none';
    activar('btn-info-encuentro');
  }

  function mostrarModuloTiendas() {
    if (form) form.style.display = 'none';
    if (list) list.style.display = 'none';
    if (fixtureInfo) fixtureInfo.style.display = 'none';
    if (storeModule) storeModule.style.display = 'block';
    activar('btn-modulo-tiendas');
  }

  var initialPanel = ((document.body && document.body.dataset.initialPanel) || 'crear-evento').toLowerCase();
  if (initialPanel === 'listado-eventos') {
    mostrarListado();
  } else if (initialPanel === 'info-encuentro') {
    mostrarInfoEncuentro();
  } else if (initialPanel === 'modulo-tiendas') {
    mostrarModuloTiendas();
  } else {
    mostrarFormulario();
  }

  document.addEventListener('click', function (event) {
    var crear = event.target.closest('#btn-crear-evento');
    var listado = event.target.closest('#btn-listado-eventos');
    var info = event.target.closest('#btn-info-encuentro');
    var tiendas = event.target.closest('#btn-modulo-tiendas');

    if (crear) {
      event.preventDefault();
      mostrarFormulario();
    }

    if (listado) {
      event.preventDefault();
      mostrarListado();
    }

    if (info) {
      event.preventDefault();
      mostrarInfoEncuentro();
    }

    if (tiendas) {
      event.preventDefault();
      mostrarModuloTiendas();
    }
  });

  var sidebar = document.getElementById('accordionSidebar');
  var toggleBtn = document.getElementById('sidebarToggle');

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('toggled');
      try {
        localStorage.setItem('sidebarToggled', sidebar.classList.contains('toggled'));
      } catch (error) {}
    });

    try {
      if (localStorage.getItem('sidebarToggled') === 'true') {
        sidebar.classList.add('toggled');
      }
    } catch (error) {}
  }

  var eventIdInput = document.getElementById('fixture_event_id');
  var grupoIdInput = document.getElementById('fixture_grupo_id');
  var jornadaInput = document.getElementById('fixture_jornada');
  var partidoInput = document.getElementById('fixture_partido_numero');
  var previewLink = document.getElementById('fixture-preview-link');

  function parsePositiveInt(value, min) {
    var parsed = parseInt(value, 10);
    if (Number.isNaN(parsed)) return null;
    if (parsed < min) return null;
    return parsed;
  }

  function syncFixturePreviewLink() {
    if (!previewLink) return;

    var eventId = parsePositiveInt(eventIdInput && eventIdInput.value, 1);
    var grupoId = parsePositiveInt(grupoIdInput && grupoIdInput.value, 1);
    var jornada = parsePositiveInt(jornadaInput && jornadaInput.value, 1);
    var partido = parsePositiveInt(partidoInput && partidoInput.value, 0);

    if (eventId === null || grupoId === null || jornada === null || partido === null) {
      previewLink.classList.add('d-none');
      previewLink.removeAttribute('href');
      return;
    }

    previewLink.href = '/eventos/' + eventId + '/fixture/' + grupoId + '/' + jornada + '/' + partido;
    previewLink.classList.remove('d-none');
  }

  [eventIdInput, grupoIdInput, jornadaInput, partidoInput].forEach(function (input) {
    if (!input) return;
    input.addEventListener('input', syncFixturePreviewLink);
    input.addEventListener('change', syncFixturePreviewLink);
  });

  function formatBytes(bytes) {
    if (!Number.isFinite(bytes) || bytes <= 0) return '';
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
  }

  function renderMediaEmpty(previewEl, text) {
    if (!previewEl) return;
    previewEl.innerHTML = '';
    var empty = document.createElement('div');
    empty.className = 'media-upload-empty';
    empty.textContent = text;
    previewEl.appendChild(empty);
  }

  function bindMediaPreview(inputId, previewId, counterId, kind) {
    var inputEl = document.getElementById(inputId);
    var previewEl = document.getElementById(previewId);
    var counterEl = document.getElementById(counterId);
    if (!inputEl || !previewEl || !counterEl) return;

    var emptyText = kind === 'videos'
      ? 'Aun no has seleccionado videos.'
      : 'Aun no has seleccionado fotos.';

    function update() {
      var files = Array.prototype.slice.call(inputEl.files || []);
      var count = files.length;
      var singularLabel = kind === 'videos' ? 'seleccionado' : 'seleccionada';
      var pluralLabel = kind === 'videos' ? 'seleccionados' : 'seleccionadas';
      counterEl.textContent = count === 1
        ? '1 ' + singularLabel
        : count + ' ' + pluralLabel;

      if (!count) {
        renderMediaEmpty(previewEl, emptyText);
        return;
      }

      previewEl.innerHTML = '';
      files.forEach(function (file) {
        var thumb = document.createElement('figure');
        thumb.className = 'media-upload-thumb';

        var mediaNode;
        var sourceUrl = URL.createObjectURL(file);
        if (kind === 'videos') {
          mediaNode = document.createElement('video');
          mediaNode.preload = 'metadata';
          mediaNode.muted = true;
          mediaNode.controls = true;
          mediaNode.src = sourceUrl;
        } else {
          mediaNode = document.createElement('img');
          mediaNode.loading = 'lazy';
          mediaNode.src = sourceUrl;
          mediaNode.alt = file.name || 'Archivo';
        }

        var caption = document.createElement('figcaption');
        caption.className = 'media-upload-caption';
        caption.textContent = (file.name || 'Archivo') + (file.size ? ' - ' + formatBytes(file.size) : '');

        thumb.appendChild(mediaNode);
        thumb.appendChild(caption);
        previewEl.appendChild(thumb);
      });
    }

    renderMediaEmpty(previewEl, emptyText);
    inputEl.addEventListener('change', update);
  }

  bindMediaPreview('fixture_media_images', 'fixture_media_images_preview', 'fixture_media_images_counter', 'images');
  bindMediaPreview('fixture_media_videos', 'fixture_media_videos_preview', 'fixture_media_videos_counter', 'videos');

  function parseIniSizeToBytes(rawValue) {
    var value = String(rawValue || '').trim();
    if (!value) return 0;

    var match = value.match(/^(\d+(?:\.\d+)?)\s*([KMGTP]?)/i);
    if (!match) return 0;

    var amount = parseFloat(match[1]);
    var unit = (match[2] || '').toUpperCase();
    var multiplier = 1;

    if (unit === 'K') multiplier = 1024;
    if (unit === 'M') multiplier = 1024 * 1024;
    if (unit === 'G') multiplier = 1024 * 1024 * 1024;
    if (unit === 'T') multiplier = 1024 * 1024 * 1024 * 1024;
    if (unit === 'P') multiplier = 1024 * 1024 * 1024 * 1024 * 1024;

    return Math.floor(amount * multiplier);
  }

  function renderUploadGuardErrors(formEl, errors) {
    if (!formEl) return;

    var box = formEl.querySelector('[data-upload-guard-errors]');
    if (!errors.length) {
      if (box) box.remove();
      return;
    }

    if (!box) {
      box = document.createElement('div');
      box.className = 'alert alert-danger col-12';
      box.setAttribute('data-upload-guard-errors', '1');
      formEl.prepend(box);
    }

    box.innerHTML = '';
    var listEl = document.createElement('ul');
    listEl.className = 'mb-0';
    errors.forEach(function (msg) {
      var item = document.createElement('li');
      item.textContent = msg;
      listEl.appendChild(item);
    });

    box.appendChild(listEl);
  }

  function attachFixtureUploadGuard() {
    var reportForm = document.getElementById('fixture-report-form-panel');
    var imagesInput = document.getElementById('fixture_media_images');
    var videosInput = document.getElementById('fixture_media_videos');

    if (!reportForm || !imagesInput || !videosInput) return;

    var postLimitBytes = parseIniSizeToBytes(reportForm.getAttribute('data-post-max-size'));
    var uploadLimitBytes = parseIniSizeToBytes(reportForm.getAttribute('data-upload-max-size'));
    var imageRuleMaxBytes = 6 * 1024 * 1024;
    var videoRuleMaxBytes = 50 * 1024 * 1024;
    var effectiveImageMax = uploadLimitBytes > 0 ? Math.min(imageRuleMaxBytes, uploadLimitBytes) : imageRuleMaxBytes;
    var effectiveVideoMax = uploadLimitBytes > 0 ? Math.min(videoRuleMaxBytes, uploadLimitBytes) : videoRuleMaxBytes;
    var safePostLimitBytes = postLimitBytes > 0 ? Math.floor(postLimitBytes * 0.95) : 0;

    reportForm.addEventListener('submit', function (event) {
      var errors = [];
      var imageFiles = Array.prototype.slice.call(imagesInput.files || []);
      var videoFiles = Array.prototype.slice.call(videosInput.files || []);
      var allFiles = imageFiles.concat(videoFiles);

      if (imageFiles.length > 12) {
        errors.push('Solo se permiten 12 fotos por guardado.');
      }

      if (videoFiles.length > 4) {
        errors.push('Solo se permiten 4 videos por guardado.');
      }

      imageFiles.forEach(function (file) {
        if (file && file.size > effectiveImageMax) {
          errors.push('La foto "' + (file.name || 'sin nombre') + '" supera el maximo permitido de ' + formatBytes(effectiveImageMax) + '.');
        }
      });

      videoFiles.forEach(function (file) {
        if (file && file.size > effectiveVideoMax) {
          errors.push('El video "' + (file.name || 'sin nombre') + '" supera el maximo permitido de ' + formatBytes(effectiveVideoMax) + '.');
        }
      });

      var totalBytes = allFiles.reduce(function (sum, file) {
        return sum + ((file && file.size) ? file.size : 0);
      }, 0);

      if (safePostLimitBytes > 0 && totalBytes > safePostLimitBytes) {
        errors.push('El peso total seleccionado (' + formatBytes(totalBytes) + ') supera el limite de la solicitud del servidor (' + formatBytes(postLimitBytes) + ').');
      }

      if (errors.length) {
        event.preventDefault();
        renderUploadGuardErrors(reportForm, errors);
        return;
      }

      renderUploadGuardErrors(reportForm, []);
    });
  }

  attachFixtureUploadGuard();
  
  function attachStoreSubmenu() {
    var submenu = document.querySelector('[data-store-submenu]');
    if (!submenu) return;

    var buttons = Array.prototype.slice.call(submenu.querySelectorAll('[data-store-submenu-target]'));
    if (!buttons.length) return;

    var panels = Array.prototype.slice.call(document.querySelectorAll('[data-store-submenu-panel]'));
    var defaultTarget = submenu.getAttribute('data-store-submenu-default') || buttons[0].getAttribute('data-store-submenu-target');

    function activatePanel(targetId) {
      buttons.forEach(function (buttonEl) {
        var isActive = buttonEl.getAttribute('data-store-submenu-target') === targetId;
        buttonEl.classList.toggle('is-active', isActive);
        buttonEl.setAttribute('aria-pressed', isActive ? 'true' : 'false');
      });

      panels.forEach(function (panelEl) {
        var shouldShow = panelEl.getAttribute('data-store-submenu-panel') === targetId;
        panelEl.classList.toggle('d-none', !shouldShow);
      });
    }

    buttons.forEach(function (buttonEl) {
      buttonEl.addEventListener('click', function () {
        var targetId = buttonEl.getAttribute('data-store-submenu-target');
        activatePanel(targetId);
      });
    });

    activatePanel(defaultTarget);
  }

  function attachStoreImagePreview(inputId, urlInputId, previewShellId, previewImageId, fileNameLabelId, emptyText) {
    var imageInput = document.getElementById(inputId);
    var imageUrlInput = urlInputId ? document.getElementById(urlInputId) : null;
    var previewShell = document.getElementById(previewShellId);
    var previewImage = document.getElementById(previewImageId);
    var fileNameLabel = fileNameLabelId ? document.getElementById(fileNameLabelId) : null;

    if (!imageInput || !previewShell || !previewImage) return;

    var fallbackText = emptyText || 'Vista previa';
    var objectUrl = null;

    function clearObjectUrl() {
      if (objectUrl) {
        URL.revokeObjectURL(objectUrl);
        objectUrl = null;
      }
    }

    function setEmptyText(text) {
      var emptyTextEl = previewShell.querySelector('.store-image-preview-empty span');
      if (emptyTextEl) emptyTextEl.textContent = text;
    }

    function showEmpty(text) {
      previewShell.classList.add('is-empty');
      previewImage.removeAttribute('src');
      setEmptyText(text || fallbackText);
    }

    function showImage(src) {
      if (!src) {
        showEmpty(fallbackText);
        return;
      }

      previewImage.onerror = function () {
        showEmpty('No se pudo cargar la imagen');
      };

      previewImage.onload = function () {
        previewShell.classList.remove('is-empty');
      };

      previewImage.src = src;
    }

    imageInput.addEventListener('change', function () {
      clearObjectUrl();
      var files = Array.prototype.slice.call(imageInput.files || []);
      if (!files.length) {
        if (fileNameLabel) fileNameLabel.textContent = 'Ningun archivo seleccionado';
        if (imageUrlInput && imageUrlInput.value.trim() !== '') {
          showImage(imageUrlInput.value.trim());
        } else {
          showEmpty(fallbackText);
        }
        return;
      }

      var file = files[0];
      if (fileNameLabel) fileNameLabel.textContent = file.name || 'Archivo seleccionado';
      objectUrl = URL.createObjectURL(file);
      showImage(objectUrl);
    });

    if (imageUrlInput) {
      function syncFromUrl() {
        if ((imageInput.files || []).length > 0) {
          return;
        }
        var raw = imageUrlInput.value.trim();
        if (!raw) {
          showEmpty(fallbackText);
          return;
        }
        showImage(raw);
      }

      imageUrlInput.addEventListener('change', syncFromUrl);
      imageUrlInput.addEventListener('blur', syncFromUrl);

      if (imageUrlInput.value.trim() !== '') {
        syncFromUrl();
      } else {
        showEmpty(fallbackText);
      }
    } else {
      showEmpty(fallbackText);
    }
  }

  function attachStoreCatalogPreview() {
    var catalogInput = document.getElementById('store_catalog_images');
    var catalogUrlsInput = document.getElementById('store_catalog_image_urls');
    var previewGrid = document.getElementById('store-catalog-preview-grid');
    var fileNameLabel = document.getElementById('store-catalog-files-name');
    var counterLabel = document.getElementById('store-catalog-files-counter');

    if (!catalogInput || !previewGrid) return;

    var objectUrls = [];

    function clearObjectUrls() {
      objectUrls.forEach(function (url) {
        URL.revokeObjectURL(url);
      });
      objectUrls = [];
    }

    function parseUrlLines() {
      if (!catalogUrlsInput) return [];
      return catalogUrlsInput.value
        .split(/\r\n|\r|\n/g)
        .map(function (line) { return line.trim(); })
        .filter(function (line) { return line.length > 0; });
    }

    function showEmpty() {
      previewGrid.innerHTML = '';
      var empty = document.createElement('div');
      empty.className = 'store-catalog-preview-empty';
      empty.textContent = 'Aun no has agregado fotos al catalogo.';
      previewGrid.appendChild(empty);
    }

    function appendThumb(src, caption) {
      var thumb = document.createElement('figure');
      thumb.className = 'store-catalog-preview-thumb';

      var image = document.createElement('img');
      image.loading = 'lazy';
      image.src = src;
      image.alt = caption || 'Foto del catalogo';

      var text = document.createElement('figcaption');
      text.className = 'store-catalog-preview-caption';
      text.textContent = caption || 'Foto del catalogo';

      thumb.appendChild(image);
      thumb.appendChild(text);
      previewGrid.appendChild(thumb);
    }

    function refreshPreview() {
      clearObjectUrls();
      previewGrid.innerHTML = '';

      var files = Array.prototype.slice.call(catalogInput.files || []);
      var urlLines = parseUrlLines();

      if (fileNameLabel) {
        if (!files.length) {
          fileNameLabel.textContent = 'Ningun archivo seleccionado';
        } else if (files.length === 1) {
          fileNameLabel.textContent = files[0].name || '1 archivo seleccionado';
        } else {
          fileNameLabel.textContent = files.length + ' archivos seleccionados';
        }
      }

      if (counterLabel) {
        var totalCount = files.length + urlLines.length;
        counterLabel.textContent = totalCount === 1
          ? '1 foto seleccionada'
          : totalCount + ' fotos seleccionadas';
      }

      files.forEach(function (file) {
        var src = URL.createObjectURL(file);
        objectUrls.push(src);
        appendThumb(src, file.name || 'Foto local');
      });

      urlLines.forEach(function (url, index) {
        appendThumb(url, 'URL ' + (index + 1));
      });

      if (!files.length && !urlLines.length) {
        showEmpty();
      }
    }

    catalogInput.addEventListener('change', refreshPreview);
    if (catalogUrlsInput) {
      catalogUrlsInput.addEventListener('input', refreshPreview);
      catalogUrlsInput.addEventListener('blur', refreshPreview);
    }

    refreshPreview();
  }

  attachStoreSubmenu();
  attachStoreImagePreview(
    'store_image',
    'store_image_url',
    'store-image-preview-shell',
    'store-image-preview',
    'store-image-file-name',
    'Vista previa de imagen principal'
  );
  attachStoreImagePreview(
    'store_company_logo',
    'store_company_logo_url',
    'store-logo-preview-shell',
    'store-logo-preview',
    'store-company-logo-file-name',
    'Vista previa del logo'
  );
  attachStoreCatalogPreview();

  function openStoreModal(modalId) {
    if (!modalId) return;
    var modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    if (window.bootstrap && window.bootstrap.Modal) {
      var bsModal = window.bootstrap.Modal.getOrCreateInstance(modalEl);
      bsModal.show();
      return;
    }

    if (window.jQuery && window.jQuery.fn && typeof window.jQuery.fn.modal === 'function') {
      window.jQuery(modalEl).modal('show');
      return;
    }

    modalEl.style.display = 'block';
    modalEl.classList.add('show');
    modalEl.setAttribute('aria-modal', 'true');
    modalEl.removeAttribute('aria-hidden');
  }

  document.addEventListener('click', function (event) {
    var trigger = event.target.closest('[data-store-open-modal]');
    if (!trigger) return;

    if (trigger.classList.contains('store-card-clickable') && event.target.closest('.store-card-actions')) {
      return;
    }

    event.preventDefault();
    event.stopPropagation();

    var modalId = trigger.getAttribute('data-store-open-modal');
    openStoreModal(modalId);
  });

  document.addEventListener('keydown', function (event) {
    var trigger = event.target.closest('.store-card-clickable[data-store-open-modal]');
    if (!trigger) return;

    if (event.key !== 'Enter' && event.key !== ' ') return;

    event.preventDefault();
    var modalId = trigger.getAttribute('data-store-open-modal');
    openStoreModal(modalId);
  });

  syncFixturePreviewLink();
});
