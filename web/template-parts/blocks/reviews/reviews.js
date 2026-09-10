(function () {
    'use strict';

    var SWIPE_THRESHOLD = 40;
    var AUTOPLAY_INTERVAL = 5000;

    function initSwiper(section) {
        var slider = section.querySelector('[data-mk-drag-slider]');
        var track = slider ? slider.querySelector('.mk-reviews__slider__track') : null;
        if (!slider || !track) return;

        var cards = Array.prototype.slice.call(track.querySelectorAll('.mk-reviews__card'));
        if (cards.length < 2) return;

        var dots = Array.prototype.slice.call(section.querySelectorAll('[data-mk-slider-dot]'));
        var autoplayEnabled = slider.hasAttribute('data-mk-autoplay');
        var autoplayTimer = null;
        var index = 0;
        var isDown = false;
        var startX = 0;
        var currentDelta = 0;

        function cardOffset(i) {
            return cards[i].offsetLeft;
        }

        function goTo(newIndex) {
            // Loopt door naar het begin/einde i.p.v. te stoppen bij de randen,
            // zodat autoplay eindeloos kan doorschuiven.
            index = ((newIndex % cards.length) + cards.length) % cards.length;
            track.style.transform = 'translateX(' + (-cardOffset(index)) + 'px)';

            dots.forEach(function (dot, i) {
                dot.classList.toggle('is-active', i === index);
            });
        }

        function stopAutoplay() {
            if (autoplayTimer) {
                window.clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }

        function startAutoplay() {
            if (!autoplayEnabled) return;
            stopAutoplay();
            autoplayTimer = window.setInterval(function () {
                goTo(index + 1);
            }, AUTOPLAY_INTERVAL);
        }

        function start(pageX) {
            isDown = true;
            currentDelta = 0;
            startX = pageX;
            slider.classList.add('is-dragging');
            track.classList.add('is-dragging');
            stopAutoplay();
        }

        function move(pageX) {
            if (!isDown) return;
            currentDelta = pageX - startX;
            track.style.transform = 'translateX(' + (-cardOffset(index) + currentDelta) + 'px)';
        }

        function end() {
            if (!isDown) return;
            isDown = false;
            slider.classList.remove('is-dragging');
            track.classList.remove('is-dragging');

            if (currentDelta <= -SWIPE_THRESHOLD) {
                goTo(index + 1);
            } else if (currentDelta >= SWIPE_THRESHOLD) {
                goTo(index - 1);
            } else {
                goTo(index);
            }

            currentDelta = 0;
            startAutoplay();
        }

        slider.addEventListener('mousedown', function (e) {
            start(e.pageX);
        });
        window.addEventListener('mousemove', function (e) {
            if (!isDown) return;
            e.preventDefault();
            move(e.pageX);
        });
        window.addEventListener('mouseup', end);

        slider.addEventListener('touchstart', function (e) {
            start(e.touches[0].pageX);
        }, { passive: true });
        slider.addEventListener('touchmove', function (e) {
            move(e.touches[0].pageX);
        }, { passive: true });
        slider.addEventListener('touchend', end);

        slider.addEventListener('click', function (e) {
            if (Math.abs(currentDelta) > 5) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);

        dots.forEach(function (dot, i) {
            dot.addEventListener('click', function () {
                goTo(i);
                startAutoplay();
            });
        });

        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);

        window.addEventListener('resize', function () {
            goTo(index);
        });

        goTo(0);
        startAutoplay();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mk-reviews').forEach(initSwiper);
    });
})();
