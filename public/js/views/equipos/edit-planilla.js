document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-delete-player-form]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!window.confirm('¿Eliminar este jugador del equipo?')) {
        event.preventDefault();
      }
    });
  });
});
