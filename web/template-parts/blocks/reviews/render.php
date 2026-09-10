<?php
    $achtergrond_type = isset($mk_reviews_achtergrond_type) ? $mk_reviews_achtergrond_type : (get_field('achtergrond_type') ?: 'blauw');
    $label            = isset($mk_reviews_label) ? $mk_reviews_label : get_field('label');
    $titel            = isset($mk_reviews_titel) ? $mk_reviews_titel : get_field('titel');
    $review_ids       = isset($mk_reviews_items) ? $mk_reviews_items : get_field('reviews');

    $bron        = get_field('bron') ?: 'handmatig';
    $min_sterren = (int) (get_field('google_min_sterren') ?: 4);

    // Bij bron "Google": live reviews ophalen (1x/dag gecached) en filteren op het
    // ingestelde minimum aantal sterren. Lukt dat niet (geen Place ID/API key, de
    // aanroep mislukt, of er blijft na filteren niets over), dan valt dit blok
    // terug op de handmatige CPT-reviews hierboven — vandaar dat $review_ids
    // altijd nodig blijft, ook wanneer bron op Google staat.
    $google_reviews = null;
    if ($bron === 'google') {
        $place_id    = get_field('google_reviews_place_id', 'option');
        $api_key     = get_field('google_reviews_api_key', 'option');
        $google_data = mk_get_google_reviews($place_id, $api_key);

        if ($google_data && !empty($google_data['reviews'])) {
            $gefilterd = array_values(array_filter($google_data['reviews'], function ($review) use ($min_sterren) {
                return $review['sterren'] >= $min_sterren;
            }));

            if ($gefilterd) {
                $google_reviews = $gefilterd;
            }
        }
    }

    $gebruik_google = $bron === 'google' && $google_reviews;

    if (!$gebruik_google && !$review_ids) {
        return;
    }

    $aantal_kaarten = $gebruik_google ? count($google_reviews) : count($review_ids);

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

            <div class="mk-reviews__slider" data-mk-drag-slider data-mk-autoplay>
                <div class="mk-reviews__slider__track">
                    <?php if ($gebruik_google) : ?>
                        <?php foreach ($google_reviews as $review) : ?>
                            <div class="mk-reviews__card">
                                <?php echo mk_star_rating_html($review['sterren'], 'mk-reviews__card__sterren'); ?>
                                <h3 class="mk-reviews__card__titel"><?php echo esc_html($review['auteur']); ?></h3>
                                <?php if ($review['tekst']) : ?>
                                    <p class="mk-reviews__card__tekst">&#8220;<?php echo esc_html($review['tekst']); ?>&#8221;</p>
                                <?php endif; ?>
                                <div class="mk-reviews__card__auteur">
                                    <span class="mk-reviews__card__auteur__functie">
                                        Google review<?php echo $review['relatief'] ? ' · ' . esc_html($review['relatief']) : ''; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php foreach ($review_ids as $review_id) :
                            $tekst   = get_field('tekst', $review_id);
                            $naam    = get_field('naam', $review_id);
                            $functie = get_field('functie', $review_id);
                            $sterren = get_field('sterren', $review_id);
                        ?>
                            <div class="mk-reviews__card">
                                <?php if ($sterren) : ?>
                                    <?php echo mk_star_rating_html($sterren, 'mk-reviews__card__sterren'); ?>
                                <?php endif; ?>
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
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($aantal_kaarten > 1) : ?>
                <div class="mk-reviews__pagination" data-mk-slider-pagination>
                    <?php for ($index = 0; $index < $aantal_kaarten; $index++) : ?>
                        <button type="button" class="mk-reviews__pagination__dot<?php echo $index === 0 ? ' is-active' : ''; ?>" data-mk-slider-dot="<?php echo esc_attr($index); ?>" aria-label="Ga naar review <?php echo esc_attr($index + 1); ?>"></button>
                    <?php endfor; ?>
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
