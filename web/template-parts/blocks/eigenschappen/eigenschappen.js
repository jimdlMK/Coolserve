(function () {
    'use strict';

    function animateCountUp(el) {
        var target = parseInt(el.getAttribute('data-countup'), 10) || 0;
        var duration = 1200;
        var start = null;

        function step(timestamp) {
            if (!start) start = timestamp;
            var progress = Math.min((timestamp - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.textContent = target;
            }
        }

        window.requestAnimationFrame(step);
    }

    function activateItem(item) {
        item.classList.add('is-active');
        var countEl = item.querySelector('[data-countup]');
        if (countEl) {
            animateCountUp(countEl);
        }
    }

    function initBadge(badge) {
        var items = Array.prototype.slice.call(badge.querySelectorAll('.mk-eigenschappen__badge__item'));
        if (!items.length) return;

        var index = 0;
        var interval = null;

        function start() {
            if (interval) return;
            activateItem(items[index]);

            if (items.length < 2) return;
            interval = window.setInterval(function () {
                items[index].classList.remove('is-active');
                index = (index + 1) % items.length;
                activateItem(items[index]);
            }, 3000);
        }

        if (!('IntersectionObserver' in window)) {
            start();
            return;
        }

        var observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                start();
                obs.unobserve(entry.target);
            });
        }, { threshold: 0.4 });

        observer.observe(badge);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-cijfer-badge]').forEach(initBadge);
    });
})();
