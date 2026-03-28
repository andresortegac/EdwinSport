document.addEventListener('DOMContentLoaded', function () {
  var form = document.querySelector('[data-cancha-create-form]');
  var apertura = document.getElementById('hora_apertura');
  var cierre = document.getElementById('hora_cierre');

  if (!form || !apertura || !cierre) return;

  function validarHoras() {
    var ha = apertura.value;
    var hc = cierre.value;

    apertura.classList.remove('is-invalid');
    cierre.classList.remove('is-invalid');

    if (!ha || !hc) return true;

    if (hc <= ha) {
      cierre.classList.add('is-invalid');
      cierre.setCustomValidity('La hora de cierre debe ser mayor que la hora de apertura.');
      return false;
    }

    cierre.setCustomValidity('');
    return true;
  }

  apertura.addEventListener('change', validarHoras);
  cierre.addEventListener('change', validarHoras);

  form.addEventListener('submit', function (event) {
    if (!validarHoras()) {
      event.preventDefault();
      cierre.reportValidity();
    }
  });
});
