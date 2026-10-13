(function () {
    'use strict';

    var SWIPE_THRESHOLD = 40;
    var AUTOPLAY_INTERVAL = 5000;
    var TRANSITION_MS = 450;

    function initSwiper(section) {
        var slider = section.querySelector('[data-mk-drag-slider]');
        var track = slider ? slider.querySelector('.mk-reviews__slider__track') : null;
        if (!slider || !track) return;

        var realCards = Array.prototype.slice.call(track.querySelectorAll('.mk-reviews__card'));
        if (realCards.length < 2) return;

        var total = realCards.length;

        // Voor een naadloze oneindige loop (geen "terugspring" bij het einde):
        // een kloon van de laatste kaart vóór de eerste, en een kloon van de
        // eerste kaart ná de laatste. displayIndex 0 = kloon-laatste,
        // 1..total = echte kaarten, total+1 = kloon-eerste. Na de overgang naar
        // zo'n kloon springt de echte positie er onzichtbaar (zonder transitie)
        // overheen naar het bijbehorende echte exemplaar.
        var lastClone = realCards[total - 1].cloneNode(true);
        var firstClone = realCards[0].cloneNode(true);
        lastClone.setAttribute('aria-hidden', 'true');
        firstClone.setAttribute('aria-hidden', 'true');
        track.insertBefore(lastClone, realCards[0]);
        track.appendChild(firstClone);

        var cards = Array.prototype.slice.call(track.children);

        var dots = Array.prototype.slice.call(section.querySelectorAll('[data-mk-slider-dot]'));
        var prevBtn = section.querySelector('[data-mk-reviews-prev]');
        var nextBtn = section.querySelector('[data-mk-reviews-next]');
        var autoplayEnabled = slider.hasAttribute('data-mk-autoplay');
        var autoplayTimer = null;
        var boundaryTimer = null;
        var displayIndex = 1;
        var isDown = false;
        var startX = 0;
        var currentDelta = 0;

        function cardOffset(i) {
            return cards[i].offsetLeft;
        }

        function updateDots() {
            var realIndex = (displayIndex - 1 + total) % total;
            dots.forEach(function (dot, i) {
                dot.classList.toggle('is-active', i === realIndex);
            });
        }

        function correctBoundary() {
            if (displayIndex === 0) {
                goTo(total, true);
            } else if (displayIndex === total + 1) {
                goTo(1, true);
            }
        }

        function goTo(newIndex, skipTransition) {
            displayIndex = newIndex;
            window.clearTimeout(boundaryTimer);

            if (skipTransition) {
                track.classList.add('is-dragging');
            }

            track.style.transform = 'translateX(' + (-cardOffset(displayIndex)) + 'px)';
            updateDots();

            if (skipTransition) {
                // Forceer reflow zodat de transitionloze stap echt zonder animatie
                // toegepast wordt voordat 'is-dragging' er weer af gaat.
                // eslint-disable-next-line no-unused-expressions
                track.offsetHeight;
                track.classList.remove('is-dragging');
            } else {
                // Een vaste timeout i.p.v. "transitionend" luisteren: dat event
                // wordt gemist zodra een volgende beweging de lopende transitie
                // onderbreekt (bv. autoplay + resize kort na elkaar), waardoor de
                // loop-correctie soms wel en soms niet aansloeg.
                boundaryTimer = window.setTimeout(correctBoundary, TRANSITION_MS);
            }
        }

        function goToReal(realIndex) {
            goTo(((realIndex % total) + total) % total + 1);
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
                goTo(displayIndex + 1);
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
            track.style.transform = 'translateX(' + (-cardOffset(displayIndex) + currentDelta) + 'px)';
        }

        function end() {
            if (!isDown) return;
            isDown = false;
            slider.classList.remove('is-dragging');
            track.classList.remove('is-dragging');

            if (currentDelta <= -SWIPE_THRESHOLD) {
                goTo(displayIndex + 1);
            } else if (currentDelta >= SWIPE_THRESHOLD) {
                goTo(displayIndex - 1);
            } else {
                goTo(displayIndex);
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
                goToReal(i);
                startAutoplay();
            });
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                goTo(displayIndex - 1);
                startAutoplay();
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                goTo(displayIndex + 1);
                startAutoplay();
            });
        }

        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);

        window.addEventListener('resize', function () {
            goTo(displayIndex, true);
        });

        goTo(1, true);
        startAutoplay();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mk-reviews').forEach(initSwiper);
    });
})();
