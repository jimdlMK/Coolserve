<?php
    $label = get_field('label');
    $titel = get_field('titel');
    $tekst = get_field('tekst');
    $link  = get_field('link');

    $vacature_query = new WP_Query([
        'post_type' => 'vacature',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
    ]);

    if (!$vacature_query->have_posts()) {
        return;
    }

    $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');
    $clock_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/clock-full.svg');
    $location_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/location-full.svg');
?>

<section id="vacature-homepage" class="mk-vacature-homepage">
    <div class="mk-vacature-homepage__container">
        <div class="mk-vacature-homepage__container__inner">

            <div class="mk-vacature-homepage__content">
                <?php if ($label) : ?>
                    <span class="mk-vacature-homepage__content__label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titel) : ?>
                    <h2 class="mk-vacature-homepage__content__title"><?php echo esc_html($titel); ?></h2>
                <?php endif; ?>

                <?php if ($tekst) : ?>
                    <p class="mk-vacature-homepage__content__text"><?php echo esc_html($tekst); ?></p>
                <?php endif; ?>

                <?php if ($link && !empty($link['url'])) :
                    $target = !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '"' : '';
                ?>
                    <a class="btn btn--primary" href="<?php echo esc_url($link['url']); ?>"<?php echo $target; ?>>
                        <span><?php echo esc_html($link['title']); ?></span>
                        <?php echo $arrow_icon; ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php while ($vacature_query->have_posts()) : $vacature_query->the_post();
                $introtekst = get_field('introtekst', get_the_ID());
                $locatie    = get_field('locatie', get_the_ID());
                $uren       = get_field('uren', get_the_ID());
                $foto_url   = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
                <a class="mk-vacature-homepage__card" href="<?php the_permalink(); ?>">
                    <div class="mk-vacature-homepage__card__image" <?php if ($foto_url) : ?>style="background-image: url('<?php echo esc_url($foto_url); ?>');"<?php endif; ?>></div>
                    <div class="mk-vacature-homepage__card__body">
                        <h3 class="mk-vacature-homepage__card__body__titel"><?php the_title(); ?></h3>

                        <?php if ($uren || $locatie) : ?>
                            <div class="mk-vacature-homepage__card__body__meta">
                                <?php if ($uren) : ?>
                                    <span class="mk-vacature-homepage__card__body__meta__item"><?php echo $clock_icon; ?><?php echo esc_html($uren); ?></span>
                                <?php endif; ?>
                                <?php if ($locatie) : ?>
                                    <span class="mk-vacature-homepage__card__body__meta__item"><?php echo $location_icon; ?><?php echo esc_html($locatie); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($introtekst) : ?>
                            <p class="mk-vacature-homepage__card__body__tekst"><?php echo esc_html($introtekst); ?></p>
                        <?php endif; ?>

                        <span class="mk-vacature-homepage__card__body__link">Lees meer <?php echo $arrow_icon; ?></span>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>

        </div>
    </div>
</section>
