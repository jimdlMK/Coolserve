<div class="mk-mobile-menu">
    <div class="mk-mobile-menu__inner">
        <div class="mk-mobile-menu__inner__top">
            <img src="<?php echo esc_url(get_field('logo' , 'option')['url']);?>">
            <div class="close">
                <span class="lineone"></span>
                <span class="linetwo"></span>
            </div>
        </div>
        <div class="mk-mobile-menu__inner__menu">
            <?php wp_nav_menu( array( 'menu' => 'Hoofdmenu' ) ); ?>
        </div>
    </div>
</div>