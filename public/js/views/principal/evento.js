document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-event-card-image]').forEach(function (image) {
    image.addEventListener('error', function () {
      var fallbackSrc = image.dataset.fallbackSrc;
      if (fallbackSrc && image.src !== fallbackSrc) {
        image.src = fallbackSrc;
        return;
      }

      image.remove();
    });
  });

  document.querySelectorAll('[data-sponsor-image]').forEach(function (image) {
    image.addEventListener('error', function () {
      image.style.display = 'none';
      var parent = image.parentElement;
      if (parent && !parent.querySelector('.sponsor-placeholder')) {
        parent.insertAdjacentHTML('afterbegin', '<div class="sponsor-placeholder">Sin logo</div>');
      }
    });
  });
});
