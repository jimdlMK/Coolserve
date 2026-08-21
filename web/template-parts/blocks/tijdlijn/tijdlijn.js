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
        var connectors = Array.prototype.slice.call(lijn.querySelectorAll('[data-mk-tijdlijn-connector]'));

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

        // De lijn tussen twee jaartallen vult zich live mee met de scrollpositie,
        // zodat hij precies 'vastklikt' op het moment dat het volgende jaartal
        // in beeld komt, in plaats van in één keer te groeien.
        function updateConnectors() {
            connectors.forEach(function (connector) {
                var fill = connector.querySelector('[data-mk-tijdlijn-connector-fill]');
                if (!fill) return;

                var rect = connector.getBoundingClientRect();
                var viewportAnchor = window.innerHeight * 0.75;
                var progress = (viewportAnchor - rect.top) / rect.height;
                progress = Math.max(0, Math.min(1, progress));

                fill.style.transform = 'scaleY(' + progress + ')';
            });
        }

        if (!('IntersectionObserver' in window)) {
            items.forEach(function (item) {
                item.classList.add('is-visible');
            });
            connectors.forEach(function (connector) {
                var fill = connector.querySelector('[data-mk-tijdlijn-connector-fill]');
                if (fill) fill.style.transform = 'scaleY(1)';
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
            threshold: 0.15
        });

        items.forEach(function (item) {
            observer.observe(item);

            var rect = item.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                revealItem(item);
                observer.unobserve(item);
            }
        });

        if (connectors.length) {
            var ticking = false;
            window.addEventListener('scroll', function () {
                if (ticking) return;
                ticking = true;
                window.requestAnimationFrame(function () {
                    updateConnectors();
                    ticking = false;
                });
            }, { passive: true });

            updateConnectors();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mk-tijdlijn]').forEach(initTijdlijn);
    });
})();
