(function () {
    'use strict';

    var BREAKPOINT = 769;
    var INTERVAL = 3000;

    function initUspSlider(container) {
        var items = Array.prototype.slice.call(container.querySelectorAll('.mk-usp__item'));
        if (items.length < 2) return;

        var index = 0;
        var timer = null;

        function start() {
            if (timer || window.innerWidth >= BREAKPOINT) return;
            timer = window.setInterval(function () {
                items[index].classList.remove('is-active');
                index = (index + 1) % items.length;
                items[index].classList.add('is-active');
            }, INTERVAL);
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
