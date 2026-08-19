(function () {
    'use strict';

    function initTijdlijn(lijn) {
        var items = Array.prototype.slice.call(lijn.querySelectorAll('[data-mk-tijdlijn-item]'));

        function revealItem(item) {
            if (item.classList.contains('is-visible')) return;
            item.classList.add('is-visible');

            var connector = item.querySelector('.mk-tijdlijn__item__connector');
            if (!connector) return;

            var index = items.indexOf(item);
            var next = items[index + 1];
            if (!next) return;

            window.setTimeout(function () {
                revealItem(next);
            }, 550);
        }

        if (!('IntersectionObserver' in window)) {
            items.forEach(function (item) {
                item.classList.add('is-visible');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    revealItem(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.4,
            rootMargin: '0px 0px -10% 0px'
        });

        items.forEach(function (item) {
            observer.observe(item);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-tijdlijn]').forEach(initTijdlijn);
    });
})();
