  <div class="mk-footer__container">
    <div class="mk-footer__container__inner">
        <?php get_template_part('template-parts/contact/contact-info'); ?>
        <?php get_template_part('template-parts/contact/locations'); ?>
        <?php get_template_part('template-parts/footer/nav-footer'); ?>
    </div>
  </div>

  <div class="mk-footer__bottom">
    <div class="mk-footer__bottom__inner">
        <div class="mk-footer__bottom__left">
            <a class="mk-footer__bottom__logo" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/logo-white.png'); ?>" alt="<?php bloginfo('name'); ?>">
            </a>

            <div class="mk-footer__bottom__legal">
                <?php
                    $privacy      = get_field('privacyverklaring', 'options');
                    $voorwaarden_p = get_field('voorwaarden_particulier', 'options');
                    $voorwaarden_z = get_field('voorwaarden_zakelijk', 'options');
                ?>
                <div class="mk-footer__bottom__legal__links">
                    <?php if ($privacy) : ?><a href="<?php echo esc_url(get_permalink($privacy)); ?>">Privacyverklaring</a><?php endif; ?>
                    <?php if ($voorwaarden_p) : ?><a href="<?php echo esc_url(get_permalink($voorwaarden_p)); ?>">Algemene voorwaarden particulier</a><?php endif; ?>
                    <?php if ($voorwaarden_z) : ?><a href="<?php echo esc_url(get_permalink($voorwaarden_z)); ?>">Algemene voorwaarden zakelijk</a><?php endif; ?>
                </div>
                <span class="mk-footer__bottom__legal__copyright">&copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html(get_field('bedrijfsnaam', 'option')); ?>. Alle rechten voorbehouden.</span>
            </div>
        </div>

        <div class="mk-footer__bottom__right">
            <?php get_template_part('template-parts/contact/socials'); ?>
        </div>
    </div>

    <a href="#page_container" class="mk-footer__bottom__totop" aria-label="Naar boven">
        <?php echo file_get_contents(get_stylesheet_directory() . '/assets/images/up.svg'); ?>
    </a>
  </div>
