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

    function initFormulierenBlock(section) {
        var toggles = section.querySelectorAll('[data-mk-formulieren-toggle]');
        var panels = section.querySelectorAll('[data-mk-formulieren-panel]');

        toggles.forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                var targetId = toggle.getAttribute('data-mk-formulieren-toggle');
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

                    window.setTimeout(function () {
                        targetPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 80);
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mk-formulieren').forEach(initFormulierenBlock);
    });

    document.addEventListener('gform_confirmation_loaded', function () {
        document.querySelectorAll('.mk-formulieren [data-mk-formulieren-panel].is-open').forEach(function (panel) {
            panel.style.height = 'auto';
        });
    });
})();
