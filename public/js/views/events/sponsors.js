document.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById('logo');
  var name = document.getElementById('logo-file-name');
  var preview = document.getElementById('logo-preview');
  var box = document.getElementById('logo-upload');

  if (input && name && preview && box) {
    input.addEventListener('change', function () {
      var file = this.files && this.files[0] ? this.files[0] : null;
      if (!file) {
        name.textContent = 'Ningun archivo seleccionado';
        preview.removeAttribute('src');
        box.classList.remove('has-file');
        return;
      }

      name.textContent = file.name;
      box.classList.add('has-file');
      preview.src = URL.createObjectURL(file);
    });
  }

  document.querySelectorAll('[data-sponsor-logo]').forEach(function (image) {
    image.addEventListener('error', function () {
      var wrapper = image.closest('.sponsor-logo-wrapper');
      if (!wrapper) return;

      image.remove();
      wrapper.innerHTML = '<span class="text-muted small">Sin logo</span>';
    });
  });
});
