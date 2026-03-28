document.addEventListener('DOMContentLoaded', function () {
  var root = document.querySelector('[data-event-create]');
  var input = document.getElementById('image');
  var name = document.getElementById('image-file-name');
  var preview = document.getElementById('image-preview');
  var upload = document.getElementById('image-upload');

  if (root && window.Swal) {
    var successMessage = root.dataset.successMessage || '';
    if (successMessage) {
      window.Swal.fire({
        icon: 'success',
        title: 'Operación exitosa',
        text: successMessage,
        confirmButtonColor: '#0f766e',
        timer: 3000,
        timerProgressBar: true
      });
    }
  }

  if (!input || !name || !preview || !upload) return;

  input.addEventListener('change', function () {
    var file = this.files && this.files[0] ? this.files[0] : null;

    if (!file) {
      name.textContent = 'Ningun archivo seleccionado';
      preview.removeAttribute('src');
      upload.classList.remove('has-file');
      return;
    }

    name.textContent = file.name;
    upload.classList.add('has-file');
    preview.src = URL.createObjectURL(file);
  });
});
