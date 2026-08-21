(function () {
    'use strict';

    var SPARK_COUNT = 8;
    var SPARK_COLORS = ['#00C2FF', '#3489F1', '#FFBD4B', '#FFFFFF'];

    function burstSparks(container) {
        if (!container) return;

        for (var i = 0; i < SPARK_COUNT; i++) {
            var spark = document.createElement('span');
            spark.className = 'mk-tijdlijn__item__sparks__spark';

            var angle = (360 / SPARK_COUNT) * i + (Math.random() * 30 - 15);
            var distance = 26 + Math.random() * 18;
            var rad = (angle * Math.PI) / 180;
            var x = Math.cos(rad) * distance;
            var y = Math.sin(rad) * distance;

            spark.style.setProperty('--mk-spark-x', x + 'px');
            spark.style.setProperty('--mk-spark-y', y + 'px');
            spark.style.backgroundColor = SPARK_COLORS[i % SPARK_COLORS.length];
            spark.style.animationDelay = (Math.random() * 80) + 'ms';

            container.appendChild(spark);
        }

        window.setTimeout(function () {
            container.innerHTML = '';
        }, 900);
    }

    function initTijdlijn(lijn) {
        var items = Array.prototype.slice.call(lijn.querySelectorAll('[data-mk-tijdlijn-item]'));

        function revealItem(item) {
            if (item.classList.contains('is-visible')) return;
            item.classList.add('is-visible');

            window.setTimeout(function () {
                burstSparks(item.querySelector('[data-mk-tijdlijn-sparks]'));
            }, 650);

            var connector = item.querySelector('.mk-tijdlijn__item__connector');
            if (!connector) return;

            var index = items.indexOf(item);
            var next = items[index + 1];
            if (!next) return;

            window.setTimeout(function () {
                revealItem(next);
            }, 1500);
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
