<?php
    $layout = get_field('layout') ?: 'standaard';

    $titel        = get_field('titel');
    $subtitel     = get_field('subtitel');
    $tekst        = get_field('tekst');
    $knop_type    = get_field('knop_type');
    $knop_link    = get_field('knop_link');
    $snel_naar    = get_field('snel_naar');
    $toon_cijfers = get_field('toon_cijfers');

    $achtergrond_afbeelding = get_field('achtergrond_afbeelding');
    $vimeo_id               = get_field('vimeo_id');

    $split_afbeelding = get_field('split_afbeelding');
    $split_vimeo_id   = get_field('split_vimeo_id');

    $is_front = is_front_page();

    $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');

    $classes = ['mk-hero', 'mk-hero--' . esc_attr($layout)];
    if ($is_front) {
        $classes[] = 'mk-hero--home';
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">

    <?php if ($layout !== 'split') : ?>
        <div class="mk-hero__media">
            <?php if ($achtergrond_afbeelding) : ?>
                <img class="mk-hero__media__image" src="<?php echo esc_url($achtergrond_afbeelding['url']); ?>" alt="<?php echo esc_attr($achtergrond_afbeelding['alt']); ?>">
            <?php endif; ?>

            <?php if ($vimeo_id) : ?>
                <div class="mk-hero__media__video">
                    <iframe
                        src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_id); ?>?background=1&autoplay=1&loop=1&muted=1&autopause=0"
                        frameborder="0"
                        allow="autoplay; fullscreen"
                        title="Achtergrondvideo"
                    ></iframe>
                </div>
            <?php endif; ?>

            <div class="mk-hero__media__overlay"></div>
        </div>
    <?php endif; ?>

    <div class="mk-hero__container">
        <div class="mk-hero__container__inner">

            <div class="mk-hero__content">
                <?php if ($titel) : ?>
                    <h1 class="mk-hero__content__title"><?php echo wp_kses($titel, ['span' => []]); ?></h1>
                <?php endif; ?>

                <?php if ($subtitel) : ?>
                    <p class="mk-hero__content__subtitel"><?php echo esc_html($subtitel); ?></p>
                <?php endif; ?>

                <?php if ($tekst) : ?>
                    <p class="mk-hero__content__text"><?php echo esc_html($tekst); ?></p>
                <?php endif; ?>

                <?php if ($knop_type && $knop_link && !empty($knop_link['url'])) :
                    $target = !empty($knop_link['target']) ? ' target="' . esc_attr($knop_link['target']) . '"' : '';
                ?>
                    <?php if ($knop_type === 'hyperlink') : ?>
                        <a class="mk-hero__content__link" href="<?php echo esc_url($knop_link['url']); ?>"<?php echo $target; ?>>
                            <span><?php echo esc_html($knop_link['title']); ?></span>
                            <?php echo $arrow_icon; ?>
                        </a>
                    <?php else : ?>
                        <a class="btn btn--<?php echo esc_attr($knop_type); ?>" href="<?php echo esc_url($knop_link['url']); ?>"<?php echo $target; ?>>
                            <span><?php echo esc_html($knop_link['title']); ?></span>
                            <?php echo $arrow_icon; ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($snel_naar) : ?>
                    <div class="mk-hero__content__snel-naar">
                        <span class="mk-hero__content__snel-naar__label">Snel naar:</span>
                        <?php foreach ($snel_naar as $item) : ?>
                            <?php if (!empty($item['link'])) : ?>
                                <a href="<?php echo esc_url($item['link']); ?>"><?php echo esc_html($item['label']); ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($toon_cijfers) :
                    $cijfer_jaar_ervaring     = get_field('cijfer_jaar_ervaring', 'options');
                    $cijfer_tevreden_klanten  = get_field('cijfer_tevreden_klanten', 'options');
                    $cijfer_professionals     = get_field('cijfer_professionals', 'options');
                ?>
                    <div class="mk-hero__content__cijfers">
                        <?php if ($cijfer_jaar_ervaring) : ?>
                            <div class="mk-hero__content__cijfers__item">
                                <span class="mk-hero__content__cijfers__item__value"><span class="mk-hero__content__cijfers__item__number" data-countup="<?php echo esc_attr($cijfer_jaar_ervaring); ?>">0</span><span class="mk-hero__content__cijfers__item__suffix">+</span></span>
                                <span class="mk-hero__content__cijfers__item__label">Jaar ervaring</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($cijfer_tevreden_klanten) : ?>
                            <div class="mk-hero__content__cijfers__item">
                                <span class="mk-hero__content__cijfers__item__value"><span class="mk-hero__content__cijfers__item__number" data-countup="<?php echo esc_attr($cijfer_tevreden_klanten); ?>">0</span><span class="mk-hero__content__cijfers__item__suffix">+</span></span>
                                <span class="mk-hero__content__cijfers__item__label">Tevreden klanten</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($cijfer_professionals) : ?>
                            <div class="mk-hero__content__cijfers__item">
                                <span class="mk-hero__content__cijfers__item__value"><span class="mk-hero__content__cijfers__item__number" data-countup="<?php echo esc_attr($cijfer_professionals); ?>">0</span><span class="mk-hero__content__cijfers__item__suffix">+</span></span>
                                <span class="mk-hero__content__cijfers__item__label">Professionals</span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($layout === 'contact') : ?>
                    <div class="mk-hero__content__contact-grid">
                        <?php get_template_part('template-parts/contact/phone'); ?>
                        <?php get_template_part('template-parts/contact/email'); ?>
                        <?php get_template_part('template-parts/contact/locations-inline'); ?>
                        <?php get_template_part('template-parts/contact/opening-hours'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($layout === 'split') : ?>
                <div class="mk-hero__split-media">
                    <?php if ($split_vimeo_id) : ?>
                        <div class="mk-hero__split-media__video">
                            <iframe
                                src="https://player.vimeo.com/video/<?php echo esc_attr($split_vimeo_id); ?>?background=1&autoplay=1&loop=1&muted=1&autopause=0"
                                frameborder="0"
                                allow="autoplay; fullscreen"
                                title="Video"
                            ></iframe>
                        </div>
                    <?php elseif ($split_afbeelding) : ?>
                        <img src="<?php echo esc_url($split_afbeelding['url']); ?>" alt="<?php echo esc_attr($split_afbeelding['alt']); ?>">
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if ($layout !== 'split') : ?>
        <?php if ($is_front) : ?>
            <a href="#main-content" class="mk-hero__scroll">
                <span class="mk-hero__scroll__mouse"><span></span></span>
                <span class="mk-hero__scroll__label">Scroll verder</span>
            </a>
        <?php endif; ?>

        <?php if ($vimeo_id) : ?>
            <div class="mk-hero__bottom-bar">
                <button type="button" class="mk-hero__bottom-bar__video-btn" data-vimeo-lightbox="<?php echo esc_attr($vimeo_id); ?>">
                    <span>Bekijk de hele video</span>
                    <?php echo $arrow_icon; ?>
                </button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</section>

<?php if ($vimeo_id) : ?>
    <div class="mk-hero-video-lightbox" data-vimeo-lightbox-modal hidden>
        <div class="mk-hero-video-lightbox__backdrop" data-vimeo-lightbox-close></div>
        <div class="mk-hero-video-lightbox__inner">
            <button type="button" class="mk-hero-video-lightbox__close" data-vimeo-lightbox-close aria-label="Sluiten">&times;</button>
            <div class="mk-hero-video-lightbox__player"></div>
        </div>
    </div>
<?php endif; ?>

<?php
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-hero', $theme_uri . '/template-parts/blocks/hero/hero.js', [], filemtime($theme_dir . '/template-parts/blocks/hero/hero.js'), true);
    wp_enqueue_script('mk-hero');
?>
