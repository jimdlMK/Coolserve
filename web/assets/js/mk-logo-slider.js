(function () {
    'use strict';

    var ITEMS_VISIBLE = 3;
    var GAP = 60;
    var MAX_LOGO_WIDTH = 170;

    function applyWidth(container) {
        var width = container.getBoundingClientRect().width;
        if (!width) return;

        var itemWidth = Math.min(MAX_LOGO_WIDTH, (width - GAP * (ITEMS_VISIBLE - 1)) / ITEMS_VISIBLE);
        if (itemWidth <= 0) return;

        container.style.setProperty('--mk-logo-slider-item-width', itemWidth + 'px');
    }

    function init(container) {
        applyWidth(container);

        if ('ResizeObserver' in window) {
            var observer = new ResizeObserver(function () {
                applyWidth(container);
            });
            observer.observe(container);
        } else {
            window.addEventListener('resize', function () {
                applyWidth(container);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-logo-slider]').forEach(init);
    });
})();
