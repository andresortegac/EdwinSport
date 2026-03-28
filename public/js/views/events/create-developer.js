document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('contenedor-formulario');
  var list = document.getElementById('contenedor-listado');

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
    activar('btn-crear-evento');
  }

  function mostrarListado() {
    if (form) form.style.display = 'none';
    if (list) list.style.display = 'block';
    activar('btn-listado-eventos');
  }

  mostrarFormulario();

  document.addEventListener('click', function (event) {
    var crear = event.target.closest('#btn-crear-evento');
    var listado = event.target.closest('#btn-listado-eventos');

    if (crear) {
      event.preventDefault();
      mostrarFormulario();
    }

    if (listado) {
      event.preventDefault();
      mostrarListado();
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
});
