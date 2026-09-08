(function () {
    'use strict';

    function closePanel(panel) {
        panel.style.height = panel.scrollHeight + 'px';
        requestAnimationFrame(function () {
            panel.style.height = '0px';
        });
        panel.classList.remove('is-open');

        window.setTimeout(function () {
            if (!panel.classList.contains('is-open')) {
                panel.hidden = true;
            }
        }, 350);
    }

    function openPanel(panel) {
        panel.hidden = false;
        panel.style.height = '0px';
        var target = panel.scrollHeight;
        requestAnimationFrame(function () {
            panel.style.height = target + 'px';
        });
        panel.classList.add('is-open');

        window.setTimeout(function () {
            if (panel.classList.contains('is-open')) {
                panel.style.height = 'auto';
            }
        }, 350);
    }

    function openToggle(toggle, panels, toggles, scroll) {
        var targetId = toggle.getAttribute('data-mk-formulieren-toggle');
        var section = toggle.closest('.mk-formulieren');
        if (!section) return;
        var targetPanel = section.querySelector('#' + targetId);
        if (!targetPanel) return;

        var alreadyOpen = targetPanel.classList.contains('is-open');

        panels.forEach(function (panel) {
            if (panel !== targetPanel && panel.classList.contains('is-open')) {
                closePanel(panel);
            }
        });
        toggles.forEach(function (t) {
            if (t !== toggle) {
                t.setAttribute('aria-expanded', 'false');
                t.classList.remove('is-active');
            }
        });

        if (alreadyOpen) {
            closePanel(targetPanel);
            toggle.setAttribute('aria-expanded', 'false');
            toggle.classList.remove('is-active');
        } else {
            openPanel(targetPanel);
            toggle.setAttribute('aria-expanded', 'true');
            toggle.classList.add('is-active');

            if (scroll) {
                window.setTimeout(function () {
                    var offset = 24;
                    var top = targetPanel.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }, 80);
            }
        }
    }

    function initFormulierenBlock(section) {
        var toggles = section.querySelectorAll('[data-mk-formulieren-toggle]');
        var panels = section.querySelectorAll('[data-mk-formulieren-panel]');

        toggles.forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                openToggle(toggle, panels, toggles, true);
            });
        });
    }

    // Links elders op de site (bv. het topmenu-item "Storing melden") linken naar
    // /contact#gf_{form_id} — dat matcht het anchor-formaat dat Gravity Forms zelf
    // gebruikt bij AJAX-formulieren. Bij het laden van de pagina met zo'n hash
    // openen we automatisch het accordion-item met dat formulier-ID.
    function openPanelForHash() {
        var match = /^#gf_(\d+)$/.exec(window.location.hash);
        if (!match) return;
        var formId = match[1];

        var toggle = document.querySelector(
            '.mk-formulieren [data-mk-formulieren-toggle][data-mk-formulieren-form-id="' + formId + '"]'
        );
        if (!toggle) return;

        var section = toggle.closest('.mk-formulieren');
        var toggles = section.querySelectorAll('[data-mk-formulieren-toggle]');
        var panels = section.querySelectorAll('[data-mk-formulieren-panel]');
        openToggle(toggle, panels, toggles, false);

        window.setTimeout(function () {
            var offset = 24;
            var top = toggle.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top: top, behavior: 'smooth' });
        }, 80);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mk-formulieren').forEach(initFormulierenBlock);
        openPanelForHash();
    });

    document.addEventListener('gform_confirmation_loaded', function () {
        document.querySelectorAll('.mk-formulieren [data-mk-formulieren-panel].is-open').forEach(function (panel) {
            panel.style.height = 'auto';
        });
    });
})();
