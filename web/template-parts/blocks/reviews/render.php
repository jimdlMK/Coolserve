<?php
    $achtergrond_type = isset($mk_reviews_achtergrond_type) ? $mk_reviews_achtergrond_type : (get_field('achtergrond_type') ?: 'blauw');
    $label            = isset($mk_reviews_label) ? $mk_reviews_label : get_field('label');
    $titel            = isset($mk_reviews_titel) ? $mk_reviews_titel : get_field('titel');
    $review_ids       = isset($mk_reviews_items) ? $mk_reviews_items : get_field('reviews');

    if (!$review_ids) {
        return;
    }

    $classes = ['mk-reviews', 'mk-bg-' . esc_attr($achtergrond_type)];
    if (in_array($achtergrond_type, ['gradient', 'blauw'], true)) {
        $classes[] = 'mk-bg-radius';
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-reviews__container">
        <div class="mk-reviews__container__inner">

            <?php if ($label) : ?>
                <span class="mk-reviews__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-reviews__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <div class="mk-reviews__slider" data-mk-drag-slider>
                <div class="mk-reviews__slider__track">
                    <?php foreach ($review_ids as $review_id) :
                        $tekst   = get_field('tekst', $review_id);
                        $naam    = get_field('naam', $review_id);
                        $functie = get_field('functie', $review_id);
                    ?>
                        <div class="mk-reviews__card">
                            <h3 class="mk-reviews__card__titel"><?php echo esc_html(get_the_title($review_id)); ?></h3>
                            <?php if ($tekst) : ?>
                                <p class="mk-reviews__card__tekst">&#8220;<?php echo esc_html($tekst); ?>&#8221;</p>
                            <?php endif; ?>
                            <?php if ($naam || $functie) : ?>
                                <div class="mk-reviews__card__auteur">
                                    <?php if ($naam) : ?>
                                        <span class="mk-reviews__card__auteur__naam"><?php echo esc_html($naam); ?></span>
                                    <?php endif; ?>
                                    <?php if ($functie) : ?>
                                        <span class="mk-reviews__card__auteur__functie"><?php echo esc_html($functie); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (count($review_ids) > 1) : ?>
                <div class="mk-reviews__pagination" data-mk-slider-pagination>
                    <?php foreach ($review_ids as $index => $review_id) : ?>
                        <button type="button" class="mk-reviews__pagination__dot<?php echo $index === 0 ? ' is-active' : ''; ?>" data-mk-slider-dot="<?php echo esc_attr($index); ?>" aria-label="Ga naar review <?php echo esc_attr($index + 1); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-reviews', $theme_uri . '/template-parts/blocks/reviews/reviews.js', [], filemtime($theme_dir . '/template-parts/blocks/reviews/reviews.js'), true);
    wp_enqueue_script('mk-reviews');
?>
