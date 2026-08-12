<div class="mk-mobile-menu">
    <div class="mk-mobile-menu__inner">
        <div class="mk-mobile-menu__inner__top">
            <div class="close">
                <span class="lineone"></span>
                <span class="linetwo"></span>
            </div>
            <img src="<?php echo esc_url(get_field('logo' , 'option')['url']);?>">
        </div>
        <div class="mk-mobile-menu__inner__menu">
            <?php wp_nav_menu( array( 'menu' => 'Hoofdmenu' ) ); ?>
        </div>
        <div class="mk-mobile-menu__inner__bottom">
            <?php get_template_part('template-parts/contact/socials'); ?>
        </div>
    </div>
</div>