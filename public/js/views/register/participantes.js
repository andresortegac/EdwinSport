document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-confirm-delete]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      var message = form.dataset.confirmDelete || '¿Confirmas esta eliminación?';
      if (!window.confirm(message)) {
        event.preventDefault();
      }
    });
  });
});
