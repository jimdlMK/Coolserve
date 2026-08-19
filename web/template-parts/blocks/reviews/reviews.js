(function () {
    'use strict';

    function initDragSlider(slider) {
        var isDown = false;
        var startX = 0;
        var scrollLeft = 0;
        var moved = false;

        function start(pageX) {
            isDown = true;
            moved = false;
            slider.classList.add('is-dragging');
            startX = pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        }

        function move(pageX) {
            if (!isDown) return;
            var x = pageX - slider.offsetLeft;
            var walk = x - startX;
            if (Math.abs(walk) > 5) moved = true;
            slider.scrollLeft = scrollLeft - walk;
        }

        function end() {
            isDown = false;
            slider.classList.remove('is-dragging');
        }

        slider.addEventListener('mousedown', function (e) {
            start(e.pageX);
        });
        slider.addEventListener('mousemove', function (e) {
            if (!isDown) return;
            e.preventDefault();
            move(e.pageX);
        });
        window.addEventListener('mouseup', end);
        slider.addEventListener('mouseleave', end);

        slider.addEventListener('touchstart', function (e) {
            start(e.touches[0].pageX);
        }, { passive: true });
        slider.addEventListener('touchmove', function (e) {
            move(e.touches[0].pageX);
        }, { passive: true });
        slider.addEventListener('touchend', end);

        slider.addEventListener('click', function (e) {
            if (moved) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-drag-slider]').forEach(initDragSlider);
    });
})();
