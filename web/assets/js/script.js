//when loaded is faster than ready
var documentloaded = false;
document.addEventListener("DOMContentLoaded", function () { documentloaded = true; });

//jquery
jQuery(document).ready(function($) {
    console.log('script.js is loaded');
});

// Merken/certificeringen logo-slider — houdt altijd exact 3 logo's zichtbaar
(function () {
    'use strict';

    var MK_LOGO_SLIDER_ITEMS_VISIBLE = 3;
    var MK_LOGO_SLIDER_GAP = 60;
    var MK_LOGO_SLIDER_MAX_WIDTH = 170;

    function mkLogoSliderApplyWidth(container) {
        var width = container.getBoundingClientRect().width;
        if (!width) return;

        var itemWidth = Math.min(MK_LOGO_SLIDER_MAX_WIDTH, (width - MK_LOGO_SLIDER_GAP * (MK_LOGO_SLIDER_ITEMS_VISIBLE - 1)) / MK_LOGO_SLIDER_ITEMS_VISIBLE);
        if (itemWidth <= 0) return;

        container.style.setProperty('--mk-logo-slider-item-width', itemWidth + 'px');
    }

    function mkLogoSliderInit(container) {
        mkLogoSliderApplyWidth(container);

        if ('ResizeObserver' in window) {
            var observer = new ResizeObserver(function () {
                mkLogoSliderApplyWidth(container);
            });
            observer.observe(container);
        } else {
            window.addEventListener('resize', function () {
                mkLogoSliderApplyWidth(container);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-logo-slider]').forEach(mkLogoSliderInit);
    });
})();

// Mega-menu: positioneert het paneel exact onder de header, gecentreerd op het scherm,
// en houdt het even open na het verlaten zodat de muis er makkelijk naartoe kan bewegen.
(function () {
    'use strict';

    var CLOSE_DELAY = 300;

    document.addEventListener('DOMContentLoaded', function () {
        var header = document.querySelector('.mk-header');
        var items = document.querySelectorAll('.mk-nav-main .has-mega-menu');
        if (!header || !items.length) return;

        function positionPanel(panel) {
            var headerBottom = header.getBoundingClientRect().bottom;
            panel.style.top = headerBottom + 'px';
        }

        items.forEach(function (item) {
            var panel = item.querySelector('.mk-mega-menu');
            if (!panel) return;

            var closeTimer = null;

            function open() {
                window.clearTimeout(closeTimer);
                positionPanel(panel);
                item.classList.add('is-open');
            }

            function scheduleClose() {
                window.clearTimeout(closeTimer);
                closeTimer = window.setTimeout(function () {
                    item.classList.remove('is-open');
                }, CLOSE_DELAY);
            }

            item.addEventListener('mouseenter', open);
            item.addEventListener('focusin', open);
            item.addEventListener('mouseleave', scheduleClose);
            item.addEventListener('focusout', function (e) {
                if (!item.contains(e.relatedTarget)) {
                    scheduleClose();
                }
            });
        });

        window.addEventListener('resize', function () {
            items.forEach(function (item) {
                var panel = item.querySelector('.mk-mega-menu');
                if (panel && item.classList.contains('is-open')) positionPanel(panel);
            });
        });
    });
})();