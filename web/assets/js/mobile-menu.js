//when loaded is faster than ready
var documentloaded = false;
document.addEventListener("DOMContentLoaded", function () { documentloaded = true; });

//jquery
jQuery(document).ready(function($) {
    if ($('body').hasClass('admin-bar')) {
        var adminBarHeight = $('#wpadminbar').outerHeight();
        $('.mk-mobile-menu').css('padding-top', adminBarHeight + 'px');
    }

function setSubmenuTop() {

    var adminBarHeight = $('#wpadminbar').length ? $('#wpadminbar').outerHeight() : 0;
    var topHeight = $('.mk-mobile-menu__inner__menu').offset().top || 0;

    var totalTop = topHeight + adminBarHeight;

    // zet top op ALLE sub-menus (ook nested)
    $('.mk-mobile-menu__inner__menu > .menu-mobielmenu-container > .menu > li > .sub-menu ')
        .css({
            'top': totalTop + 'px'
        });
}
setSubmenuTop();
$(window).on('resize', setSubmenuTop);
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

    $(document).on('click', '.mk-mobile-menu__inner__menu .menu-mobielmenu-container .menu li .sub-menu .go-back', function(e) {
        e.preventDefault();
        $(this).closest('.sub-menu').removeClass('is-visible');
    });

});