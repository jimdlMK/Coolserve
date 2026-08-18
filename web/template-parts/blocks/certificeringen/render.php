<?php
    $label           = get_field('certificeringen_label', 'options');
    $titel           = get_field('certificeringen_titel', 'options');
    $certificeringen = get_field('certificeringen', 'options');
?>

<section id="certificeringen" class="mk-certificeringen">
    <div class="mk-certificeringen__container">
        <div class="mk-certificeringen__container__inner">

            <?php if ($label) : ?>
                <span class="mk-certificeringen__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-certificeringen__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($certificeringen) :
                // Genoeg herhalingen zodat de track altijd breder is dan het scherm,
                // ook bij weinig certificeringen — voorkomt een lege gap aan het einde van de loop.
                $herhalingen = max(2, (int) ceil(16 / count($certificeringen)));
            ?>
                <div class="mk-certificeringen__slider">
                    <button type="button" class="mk-certificeringen__slider__arrow mk-certificeringen__slider__arrow--prev" data-mk-certificeringen-prev aria-label="Vorige">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>

                    <div class="mk-certificeringen__slider__viewport" data-mk-logo-slider>
                        <div class="mk-certificeringen__slider__track" data-mk-certificeringen-track style="--mk-certificeringen-herhalingen: <?php echo esc_attr($herhalingen); ?>;">
                            <?php for ($i = 0; $i < $herhalingen; $i++) : ?>
                                <?php foreach ($certificeringen as $item) :
                                    $logo = $item['logo'];
                                    if (!$logo) continue;
                                ?>
                                    <div class="mk-certificeringen__slider__track__item">
                                        <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($item['naam']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <button type="button" class="mk-certificeringen__slider__arrow mk-certificeringen__slider__arrow--next" data-mk-certificeringen-next aria-label="Volgende">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-certificeringen', $theme_uri . '/template-parts/blocks/certificeringen/certificeringen.js', [], filemtime($theme_dir . '/template-parts/blocks/certificeringen/certificeringen.js'), true);
    wp_enqueue_script('mk-certificeringen');
?>
