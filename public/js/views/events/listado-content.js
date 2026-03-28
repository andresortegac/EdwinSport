document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-event-card]').forEach(function (card) {
    card.addEventListener('click', function () {
      var url = card.getAttribute('data-url');
      if (url) {
        window.location.href = url;
      }
    });
  });

  document.querySelectorAll('[data-stop-card-nav]').forEach(function (element) {
    element.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  });

  document.querySelectorAll('[data-delete-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      event.stopPropagation();
      if (!window.confirm('¿Seguro que deseas eliminar este evento?')) {
        event.preventDefault();
      }
    });
  });

  document.querySelectorAll('[data-event-image]').forEach(function (image) {
    image.addEventListener('error', function () {
      var wrapper = image.closest('.event-image-wrap');
      if (!wrapper) return;

      wrapper.classList.add('is-broken');
      image.remove();
    });
  });
});
