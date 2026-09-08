<?php
    $layout           = get_field('layout') ?: 'standaard';
    $achtergrond_type = get_field('achtergrond_type') ?: 'wit';
    $label            = get_field('label');
    $titel            = get_field('titel');
    $tekst            = get_field('tekst');
    $link             = get_field('link');

    $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');

    $medewerkers_query = new WP_Query([
        'post_type' => 'medewerker',
        'posts_per_page' => -1,
        'orderby' => 'menu_order date',
        'order' => 'ASC',
        'no_found_rows' => true,
    ]);

    $classes = ['mk-team', 'mk-team--' . esc_attr($layout), 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="team" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-team__container">
        <div class="mk-team__container__inner">

            <div class="mk-team__content">
                <?php if ($label) : ?>
                    <span class="mk-team__content__label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titel) : ?>
                    <h2 class="mk-team__content__title"><?php echo esc_html($titel); ?></h2>
                <?php endif; ?>

                <?php if ($tekst) : ?>
                    <p class="mk-team__content__text"><?php echo esc_html($tekst); ?></p>
                <?php endif; ?>

                <?php if ($link && !empty($link['url'])) :
                    $target = !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '"' : '';
                ?>
                    <a class="mk-team__content__link" href="<?php echo esc_url($link['url']); ?>"<?php echo $target; ?>>
                        <span><?php echo esc_html($link['title']); ?></span>
                        <?php echo $arrow_icon; ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($layout === 'overzicht') : ?>

                <?php
                    // Groepeert de medewerkers op hun "categorie" (bijv. vestiging). De
                    // volgorde van de groepen volgt simpelweg de volgorde waarin elke
                    // categorie voor het eerst voorkomt in de medewerkers-sortering zelf
                    // (dezelfde drag & drop-volgorde als bij Diensten) — geen apart
                    // "groepsvolgorde"-veld nodig.
                    $mk_team_groepen = [];
                    while ($medewerkers_query->have_posts()) : $medewerkers_query->the_post();
                        $mk_team_categorie = get_field('categorie', get_the_ID()) ?: '';
                        $mk_team_groep_key = $mk_team_categorie !== '' ? $mk_team_categorie : '__mk_team_zonder_categorie__';

                        if (!isset($mk_team_groepen[$mk_team_groep_key])) {
                            $mk_team_groepen[$mk_team_groep_key] = [
                                'titel' => $mk_team_categorie,
                                'leden' => [],
                            ];
                        }

                        $mk_team_groepen[$mk_team_groep_key]['leden'][] = [
                            'id'       => get_the_ID(),
                            'naam'     => get_the_title(),
                            'foto_url' => get_the_post_thumbnail_url(get_the_ID(), 'medium_large'),
                            'functie'  => get_field('functie', get_the_ID()),
                        ];
                    endwhile;
                    wp_reset_postdata();
                ?>

                <?php foreach ($mk_team_groepen as $mk_team_groep) : ?>
                    <div class="mk-team__groep">
                        <?php if ($mk_team_groep['titel']) : ?>
                            <h3 class="mk-team__groep__titel"><?php echo esc_html($mk_team_groep['titel']); ?></h3>
                        <?php endif; ?>

                        <div class="mk-team__grid mk-team__grid--overzicht">
                            <?php foreach ($mk_team_groep['leden'] as $mk_team_lid) : ?>
                                <a class="mk-team__grid__item" href="<?php echo esc_url(home_url('/over-ons/')); ?>" <?php if ($mk_team_lid['foto_url']) : ?>style="background-image: url('<?php echo esc_url($mk_team_lid['foto_url']); ?>');"<?php endif; ?>>
                                    <div class="mk-team__grid__item__overlay"></div>
                                    <div class="mk-team__grid__item__info">
                                        <span class="mk-team__grid__item__info__naam"><?php echo esc_html($mk_team_lid['naam']); ?></span>
                                        <?php if ($mk_team_lid['functie']) : ?>
                                            <span class="mk-team__grid__item__info__functie"><?php echo esc_html($mk_team_lid['functie']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php elseif ($medewerkers_query->have_posts()) : ?>
                <div class="mk-team__grid">
                    <?php while ($medewerkers_query->have_posts()) : $medewerkers_query->the_post();
                        $foto_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                        $functie  = get_field('functie', get_the_ID());
                    ?>
                        <a class="mk-team__grid__item" href="<?php echo esc_url(home_url('/over-ons/')); ?>" <?php if ($foto_url) : ?>style="background-image: url('<?php echo esc_url($foto_url); ?>');"<?php endif; ?>>
                            <div class="mk-team__grid__item__overlay"></div>
                            <div class="mk-team__grid__item__info">
                                <span class="mk-team__grid__item__info__naam"><?php the_title(); ?></span>
                                <?php if ($functie) : ?>
                                    <span class="mk-team__grid__item__info__functie"><?php echo esc_html($functie); ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
