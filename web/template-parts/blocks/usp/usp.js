(function () {
    'use strict';

    var BREAKPOINT = 769;
    var INTERVAL = 3000;
    var TRANSITION_DURATION = 500;

    function initUspSlider(container) {
        var items = Array.prototype.slice.call(container.querySelectorAll('.mk-usp__item'));
        if (items.length < 2) return;

        var index = 0;
        var timer = null;

        function next() {
            var current = items[index];
            current.classList.remove('is-active');
            current.classList.add('is-leaving');

            index = (index + 1) % items.length;
            items[index].classList.add('is-active');

            window.setTimeout(function () {
                current.classList.remove('is-leaving');
            }, TRANSITION_DURATION);
        }

        function start() {
            if (timer || window.innerWidth >= BREAKPOINT) return;
            timer = window.setInterval(next, INTERVAL);
        }

        function stop() {
            window.clearInterval(timer);
            timer = null;
        }

        function sync() {
            if (window.innerWidth < BREAKPOINT) {
                start();
            } else {
                stop();
                items.forEach(function (item) {
                    item.classList.add('is-active');
                    item.classList.remove('is-leaving');
                });
            }
        }

        sync();
        window.addEventListener('resize', sync);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-usp-slider]').forEach(initUspSlider);
    });
})();
