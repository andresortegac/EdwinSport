document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-delete-admin-form]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!window.confirm('¿Eliminar este usuario?')) {
        event.preventDefault();
      }
    });
  });
});
