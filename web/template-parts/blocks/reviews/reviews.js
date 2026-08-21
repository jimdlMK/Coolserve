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

    function initPagination(section) {
        var slider = section.querySelector('[data-mk-drag-slider]');
        var pagination = section.querySelector('[data-mk-slider-pagination]');
        if (!slider || !pagination) return;

        var cards = Array.prototype.slice.call(slider.querySelectorAll('.mk-reviews__card'));
        var dots = Array.prototype.slice.call(pagination.querySelectorAll('[data-mk-slider-dot]'));
        if (!cards.length || !dots.length) return;

        dots.forEach(function (dot, index) {
            dot.addEventListener('click', function () {
                var card = cards[index];
                slider.scrollTo({
                    left: card.offsetLeft - slider.offsetLeft,
                    behavior: 'smooth'
                });
            });
        });

        if (!('IntersectionObserver' in window)) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var index = cards.indexOf(entry.target);
                if (index === -1) return;

                dots.forEach(function (dot) {
                    dot.classList.remove('is-active');
                });
                dots[index].classList.add('is-active');
            });
        }, {
            root: slider,
            threshold: 0.6
        });

        cards.forEach(function (card) {
            observer.observe(card);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-drag-slider]').forEach(initDragSlider);
        document.querySelectorAll('.mk-reviews').forEach(initPagination);
    });
})();
