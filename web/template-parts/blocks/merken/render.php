<?php
    $achtergrond_type = isset($mk_merken_achtergrond_type) ? $mk_merken_achtergrond_type : (get_field('achtergrond_type') ?: 'wit');
    $label            = get_field('merken_label', 'options');
    $titel            = get_field('merken_titel', 'options');
    $merken           = get_field('merken', 'options');

    $classes = ['mk-merken', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="merken" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-merken__container">
        <div class="mk-merken__container__inner">

            <?php if ($label) : ?>
                <span class="mk-merken__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-merken__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($merken) :
                // Genoeg herhalingen zodat de track altijd breder is dan het scherm,
                // ook bij weinig merken — voorkomt een lege gap aan het einde van de loop.
                $herhalingen = max(2, (int) ceil(16 / count($merken)));
            ?>
                <div class="mk-merken__slider">
                    <button type="button" class="mk-merken__slider__arrow mk-merken__slider__arrow--prev" data-mk-merken-prev aria-label="Vorige">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>

                    <div class="mk-merken__slider__viewport" data-mk-logo-slider>
                        <div class="mk-merken__slider__track" data-mk-merken-track style="--mk-merken-herhalingen: <?php echo esc_attr($herhalingen); ?>;">
                            <?php for ($i = 0; $i < $herhalingen; $i++) : ?>
                                <?php foreach ($merken as $merk) :
                                    $logo = $merk['logo'];
                                    if (!$logo) continue;
                                ?>
                                    <div class="mk-merken__slider__track__item">
                                        <?php echo mk_image($logo, 'medium', ['alt' => $merk['naam']]); ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <button type="button" class="mk-merken__slider__arrow mk-merken__slider__arrow--next" data-mk-merken-next aria-label="Volgende">
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
    wp_register_script('mk-merken', $theme_uri . '/template-parts/blocks/merken/merken.js', [], filemtime($theme_dir . '/template-parts/blocks/merken/merken.js'), true);
    wp_enqueue_script('mk-merken');
?>
