document.addEventListener('DOMContentLoaded', function () {
  var telInput = document.getElementById('telefono_natural');
  var docInput = document.getElementById('documento');

  if (telInput) {
    telInput.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9+\-() ]/g, '');
    });
  }

  if (docInput) {
    docInput.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  }
});
