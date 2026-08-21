(function () {
    'use strict';

    function animateCountUp(el) {
        var target = parseInt(el.getAttribute('data-countup'), 10) || 0;
        var duration = 1500;
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

    function initCountUps() {
        var groups = document.querySelectorAll('.mk-hero__content__cijfers');
        if (!groups.length || !('IntersectionObserver' in window)) return;

        var observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.querySelectorAll('[data-countup]').forEach(animateCountUp);
                obs.unobserve(entry.target);
            });
        }, { threshold: 0.4 });

        groups.forEach(function (group) {
            observer.observe(group);
        });
    }

    function initScrollLink() {
        var links = document.querySelectorAll('[data-mk-hero-scroll]');
        if (!links.length) return;

        links.forEach(function (link) {
            link.addEventListener('click', function (e) {
                var section = link.closest('.mk-hero');
                var next = section ? section.nextElementSibling : null;
                if (!next) return;

                e.preventDefault();

                var offset = 24;
                var top = next.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: top, behavior: 'smooth' });
            });
        });
    }

    function initVimeoLightbox() {
        var triggers = document.querySelectorAll('[data-vimeo-lightbox]');
        if (!triggers.length) return;

        triggers.forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                var id = trigger.getAttribute('data-vimeo-lightbox');
                var section = trigger.closest('.mk-hero');
                var modal = section ? section.nextElementSibling : null;
                if (!modal || !modal.hasAttribute('data-vimeo-lightbox-modal')) {
                    modal = document.querySelector('[data-vimeo-lightbox-modal]');
                }
                if (!modal) return;

                var player = modal.querySelector('.mk-hero-video-lightbox__player');
                player.innerHTML = '<iframe src="https://player.vimeo.com/video/' + id + '?autoplay=1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="Video"></iframe>';

                modal.hidden = false;
                document.body.classList.add('freeze');
            });
        });

        document.querySelectorAll('[data-vimeo-lightbox-close]').forEach(function (closeEl) {
            closeEl.addEventListener('click', function () {
                var modal = closeEl.closest('[data-vimeo-lightbox-modal]');
                if (!modal) return;
                modal.hidden = true;
                document.body.classList.remove('freeze');
                modal.querySelector('.mk-hero-video-lightbox__player').innerHTML = '';
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initCountUps();
        initScrollLink();
        initVimeoLightbox();
    });
})();
