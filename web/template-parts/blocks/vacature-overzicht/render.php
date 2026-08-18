<?php
    $achtergrond_type = get_field('achtergrond_type') ?: 'wit';
    $label      = get_field('label');
    $titel      = get_field('titel');
    $tekst      = get_field('tekst');
    $leeg_tekst = get_field('leeg_tekst');

    $arrow_icon    = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');
    $koffer_icon   = file_get_contents(get_stylesheet_directory() . '/assets/images/koffer-icon.svg');
    $location_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/location-pin-grey.svg');
    $salaris_icon  = file_get_contents(get_stylesheet_directory() . '/assets/images/salaris-icon.svg');

    $vacatures_query = new WP_Query([
        'post_type' => 'vacature',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
    ]);

    $classes = ['mk-vacature-overzicht', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="vacature-overzicht" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-vacature-overzicht__container">
        <div class="mk-vacature-overzicht__container__inner">

            <?php if ($label) : ?>
                <span class="mk-vacature-overzicht__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-vacature-overzicht__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($tekst) : ?>
                <p class="mk-vacature-overzicht__text"><?php echo esc_html($tekst); ?></p>
            <?php endif; ?>

            <?php if ($vacatures_query->have_posts()) : ?>
                <div class="mk-vacature-overzicht__grid">
                    <?php while ($vacatures_query->have_posts()) : $vacatures_query->the_post();
                        $introtekst = get_field('introtekst', get_the_ID());
                        $locatie    = get_field('locatie', get_the_ID());
                        $uren       = get_field('uren', get_the_ID());
                        $salaris    = get_field('salaris', get_the_ID());
                        $locaties   = $locatie ? array_map('trim', explode(',', $locatie)) : [];
                    ?>
                        <a class="mk-vacature-overzicht__grid__card" href="<?php the_permalink(); ?>">
                            <div class="mk-vacature-overzicht__grid__card__main">
                                <h3 class="mk-vacature-overzicht__grid__card__main__titel"><?php the_title(); ?></h3>

                                <?php if ($uren || $locaties || $salaris) : ?>
                                    <div class="mk-vacature-overzicht__grid__card__main__labels">
                                        <?php if ($uren) : ?>
                                            <span class="mk-vacature-label mk-vacature-label--blauw"><?php echo $koffer_icon; ?><?php echo esc_html($uren); ?></span>
                                        <?php endif; ?>
                                        <?php foreach ($locaties as $loc) : ?>
                                            <span class="mk-vacature-label mk-vacature-label--grijs"><?php echo $location_icon; ?><?php echo esc_html($loc); ?></span>
                                        <?php endforeach; ?>
                                        <?php if ($salaris) : ?>
                                            <span class="mk-vacature-label mk-vacature-label--groen"><?php echo $salaris_icon; ?><?php echo esc_html($salaris); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($introtekst) : ?>
                                    <p class="mk-vacature-overzicht__grid__card__main__tekst"><?php echo esc_html($introtekst); ?></p>
                                <?php endif; ?>
                            </div>

                            <span class="mk-vacature-overzicht__grid__card__link">
                                <span>Vacature bekijken</span>
                                <?php echo $arrow_icon; ?>
                            </span>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php elseif ($leeg_tekst) : ?>
                <p class="mk-vacature-overzicht__leeg"><?php echo esc_html($leeg_tekst); ?></p>
            <?php endif; ?>

            <div class="mk-vacature-overzicht__cta">
                <h2 class="mk-vacature-overzicht__cta__titel">Geen passende vacature gevonden?</h2>
                <p class="mk-vacature-overzicht__cta__tekst">Stuur ons een open sollicitatie! We zijn altijd op zoek naar talent en horen graag waarom jij bij Coolserve wilt werken.</p>
                <a class="btn btn--primary" href="#solliciteren">
                    <span>Stuur open sollicitatie</span>
                    <?php echo $arrow_icon; ?>
                </a>
            </div>

        </div>
    </div>
</section>
