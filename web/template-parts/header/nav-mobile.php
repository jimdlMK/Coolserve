<div class="mk-mobile-menu">
    <div class="mk-mobile-menu__inner">
        <div class="mk-mobile-menu__inner__top">
            <?php echo mk_image(get_field('logo', 'option'), 'full'); ?>
            <div class="close">
                <span class="lineone"></span>
                <span class="linetwo"></span>
            </div>
        </div>
        <div class="mk-mobile-menu__inner__menu">
            <?php wp_nav_menu( array( 'menu' => 'Hoofdmenu' ) ); ?>

            <?php if (has_nav_menu('top_menu')) : ?>
                <div class="mk-mobile-menu__inner__menu__top">
                    <?php wp_nav_menu( array( 'menu' => 'Topmenu' ) ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>