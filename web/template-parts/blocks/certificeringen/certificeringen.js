(function () {
    'use strict';

    function initSlider(section) {
        var viewport = section.querySelector('.mk-certificeringen__slider__viewport');
        var track = section.querySelector('[data-mk-certificeringen-track]');
        var prevBtn = section.querySelector('[data-mk-certificeringen-prev]');
        var nextBtn = section.querySelector('[data-mk-certificeringen-next]');
        if (!viewport || !track) return;

        var resumeTimer = null;

        function step(direction) {
            var item = track.querySelector('.mk-certificeringen__slider__track__item');
            var itemWidth = item ? item.getBoundingClientRect().width : 170;
            var gap = 60;
            var distance = (itemWidth + gap) * direction;

            track.classList.add('is-paused');
            viewport.scrollBy({ left: distance, behavior: 'smooth' });

            window.clearTimeout(resumeTimer);
            resumeTimer = window.setTimeout(function () {
                track.classList.remove('is-paused');
            }, 2500);
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                step(-1);
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                step(1);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mk-certificeringen').forEach(initSlider);
    });
})();
