<?php
    $achtergrond_type = isset($mk_diensten_overzicht_achtergrond_type) ? $mk_diensten_overzicht_achtergrond_type : (get_field('achtergrond_type') ?: 'grijs');
    $label = isset($mk_diensten_overzicht_label) ? $mk_diensten_overzicht_label : get_field('label');
    $titel = isset($mk_diensten_overzicht_titel) ? $mk_diensten_overzicht_titel : get_field('titel');
    $tekst = isset($mk_diensten_overzicht_tekst) ? $mk_diensten_overzicht_tekst : get_field('tekst');

    $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');

    $diensten_query = new WP_Query([
        'post_type' => 'dienst',
        'posts_per_page' => -1,
        'orderby' => 'menu_order date',
        'order' => 'ASC',
        'no_found_rows' => true,
    ]);

    $classes = ['mk-diensten-overzicht', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="diensten-overzicht" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-diensten-overzicht__container">
        <div class="mk-diensten-overzicht__container__inner">

            <?php if ($label) : ?>
                <span class="mk-diensten-overzicht__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-diensten-overzicht__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($tekst) : ?>
                <p class="mk-diensten-overzicht__text"><?php echo esc_html($tekst); ?></p>
            <?php endif; ?>

            <?php if ($diensten_query->have_posts()) : ?>
                <div class="mk-diensten-overzicht__grid">
                    <?php while ($diensten_query->have_posts()) : $diensten_query->the_post();
                        $icoon = get_field('icoon', get_the_ID());
                    ?>
                        <a class="mk-diensten-overzicht__grid__card" href="<?php the_permalink(); ?>">
                            <span class="mk-diensten-overzicht__grid__card__titel"><?php the_title(); ?></span>
                            <?php if ($icoon) : ?>
                                <img class="mk-diensten-overzicht__grid__card__icoon" src="<?php echo esc_url($icoon['url']); ?>" alt="<?php echo esc_attr($icoon['alt']); ?>">
                            <?php endif; ?>
                            <span class="mk-diensten-overzicht__grid__card__link">
                                <span>Lees meer</span>
                                <?php echo $arrow_icon; ?>
                            </span>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
