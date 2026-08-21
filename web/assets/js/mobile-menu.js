//when loaded is faster than ready
var documentloaded = false;
document.addEventListener("DOMContentLoaded", function () { documentloaded = true; });

//jquery
jQuery(document).ready(function($) {
    if ($('body').hasClass('admin-bar')) {
        var adminBarHeight = $('#wpadminbar').outerHeight();
        $('.mk-mobile-menu').css('padding-top', adminBarHeight + 'px');
    }

    // Open menu
    $('.open-mobile-menu').on('click', function(e) {
        e.preventDefault();
        $('.mk-mobile-menu').addClass('is-active');
        $('body').addClass('freeze');
    });

    // Close menu
    $('.mk-mobile-menu__inner__top .close').on('click', function(e) {
        e.preventDefault();
        $('.mk-mobile-menu').removeClass('is-active');
        $('body').removeClass('freeze');
    });


    $('.mk-mobile-menu__inner__menu .sub-menu').each(function() {
        if (!$(this).find('.go-back').length) {
            $(this).prepend(
                '<div class="go-back">' +
                    '<span>Ga terug</span>' +
                '</div>'
            );
        }
    });

    // Klikbaar pijltje op menu-items met een submenu
    $('.mk-mobile-menu__inner__menu .menu li.menu-item-has-children').each(function() {
        var $link = $(this).children('a');
        if (!$link.find('.submenu-toggle').length) {
            $link.append('<span class="submenu-toggle" aria-label="Submenu openen"></span>');
        }
    });

    // Submenu's koppelen aan hun toggle via een uniek ID, dan verplaatsen naar <body>
    // zodat position:fixed weer relatief is aan de viewport i.p.v. aan .mk-mobile-menu
    // (die zelf een transform heeft, wat anders een nieuw containing block voor
    // fixed-elementen zou vormen — daardoor opende het submenu niet volledig scherm).
    var submenuCounter = 0;
    $('.mk-mobile-menu__inner__menu li.menu-item-has-children').each(function() {
        var $li = $(this);
        var $submenu = $li.children('.sub-menu');
        if (!$submenu.length) return;

        submenuCounter++;
        var id = 'mk-submenu-' + submenuCounter;
        $li.children('a').find('.submenu-toggle').attr('data-submenu-target', id);
        $submenu.attr('data-submenu-id', id).appendTo('body');
    });

    $(document).on('click', '.mk-mobile-menu__inner__menu .menu li.menu-item-has-children > a .submenu-toggle', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).attr('data-submenu-target');
        $('body > .sub-menu[data-submenu-id="' + id + '"]').addClass('is-visible');
        $('body').addClass('freeze');
    });

    $(document).on('click', 'body > .sub-menu .go-back', function(e) {
        e.preventDefault();
        $(this).closest('.sub-menu').removeClass('is-visible');
    });

});
