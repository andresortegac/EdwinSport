document.addEventListener('DOMContentLoaded', function () {
  var refreshMs = 30000;
  var timerId = null;

  function schedule() {
    clearTimeout(timerId);
    timerId = setTimeout(function () {
      if (document.visibilityState === 'visible') {
        window.location.reload();
        return;
      }

      schedule();
    }, refreshMs);
  }

  document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible') {
      schedule();
    }
  });

  schedule();
});
