document.addEventListener('DOMContentLoaded', function () {
  if (typeof window.createSnow === 'function') {
    window.createSnow(20);
  }

  document.querySelectorAll('[data-print-tournament]').forEach(function (button) {
    button.addEventListener('click', function () {
      window.print();
    });
  });
});
