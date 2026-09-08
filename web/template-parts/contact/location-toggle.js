(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-location-toggle]').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                var panel = toggle.parentElement.querySelector('[data-mk-location-body]');
                if (!panel) return;

                var isOpen = panel.classList.toggle('is-open');
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        });
    });
})();
