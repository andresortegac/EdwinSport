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
});
