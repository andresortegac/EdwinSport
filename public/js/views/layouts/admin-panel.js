(function () {
  var storageKey = 'edwinsport-admin-sidebar-toggled';
  var collapseSelector = '.sidebar .collapse';

  function applySidebarState() {
    if (window.innerWidth < 768) return;

    var shouldBeToggled = localStorage.getItem(storageKey) === 'true';
    var body = document.body;
    var sidebar = document.querySelector('.sidebar');

    if (!sidebar) return;

    body.classList.toggle('sidebar-toggled', shouldBeToggled);
    sidebar.classList.toggle('toggled', shouldBeToggled);
  }

  function isDesktopCollapsed() {
    var sidebar = document.querySelector('.sidebar');
    return window.innerWidth >= 768 && sidebar && sidebar.classList.contains('toggled');
  }

  function hideFloatingSubmenus() {
    document.querySelectorAll(collapseSelector).forEach(function (collapse) {
      collapse.classList.remove('show');
    });
  }

  function syncSidebarTooltips() {
    var collapsed = isDesktopCollapsed();

    $('[data-toggle-tooltip="tooltip"]').each(function () {
      var $element = $(this);

      if (collapsed) {
        if (!$element.data('bs.tooltip')) {
          $element.tooltip({ trigger: 'hover', container: 'body' });
        }
        return;
      }

      $element.tooltip('hide');
      if ($element.data('bs.tooltip')) {
        $element.tooltip('dispose');
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    applySidebarState();

    if (isDesktopCollapsed()) hideFloatingSubmenus();
    syncSidebarTooltips();

    var toggleButton = document.getElementById('sidebarToggle');
    if (toggleButton) {
      toggleButton.addEventListener('click', function () {
        window.setTimeout(function () {
          var sidebar = document.querySelector('.sidebar');
          var isToggled = sidebar && sidebar.classList.contains('toggled');
          localStorage.setItem(storageKey, isToggled ? 'true' : 'false');
          if (isToggled) hideFloatingSubmenus();
          syncSidebarTooltips();
        }, 0);
      });
    }

    document.querySelectorAll('.sidebar .nav-link[data-toggle="collapse"]').forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        if (!isDesktopCollapsed()) return;

        var targetSelector = trigger.getAttribute('data-target');
        window.setTimeout(function () {
          document.querySelectorAll(collapseSelector).forEach(function (collapse) {
            if (!collapse.matches(targetSelector)) {
              collapse.classList.remove('show');
            }
          });
        }, 0);
      });
    });

    document.querySelectorAll('.sidebar .collapse-item').forEach(function (item) {
      item.addEventListener('click', function () {
        if (isDesktopCollapsed()) hideFloatingSubmenus();
      });
    });

    document.addEventListener('click', function (event) {
      if (!isDesktopCollapsed()) return;
      if (!event.target.closest('.sidebar')) hideFloatingSubmenus();
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth < 768) {
        localStorage.removeItem(storageKey);
        document.body.classList.remove('sidebar-toggled');
        var sidebar = document.querySelector('.sidebar');
        if (sidebar) sidebar.classList.remove('toggled');
        syncSidebarTooltips();
        return;
      }

      applySidebarState();
      if (isDesktopCollapsed()) hideFloatingSubmenus();
      syncSidebarTooltips();
    });
  });
})();
