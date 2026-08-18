<?php
    $achtergrond_type = get_field('achtergrond_type') ?: 'gradient';
    $label            = get_field('label');
    $titel            = get_field('titel');
    $tekst            = get_field('tekst');
    $toon_werking     = get_field('toon_werking');
    $werking_titel    = get_field('werking_titel');
    $werking_stappen  = get_field('werking_stappen');
    $types_titel      = get_field('types_titel');
    $systemen         = get_field('systemen');
    $knop_tekst       = get_field('knop_tekst');
    $knop_url         = get_field('knop_url');

    $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');

    $classes = ['mk-systemen', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="systemen" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-systemen__container">
        <div class="mk-systemen__container__inner">

            <?php if ($label) : ?>
                <span class="mk-systemen__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-systemen__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($tekst) : ?>
                <p class="mk-systemen__text"><?php echo esc_html($tekst); ?></p>
            <?php endif; ?>

            <?php if ($toon_werking && $werking_stappen) :
                $totaal_stappen = count($werking_stappen);
            ?>
                <?php if ($werking_titel) : ?>
                    <h3 class="mk-systemen__werking-titel"><?php echo esc_html($werking_titel); ?></h3>
                <?php endif; ?>

                <div class="mk-systemen__werking">
                    <?php foreach ($werking_stappen as $i => $stap) :
                        $icoon   = $stap['icoon'];
                        $nummer  = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                        $is_last = ($i === $totaal_stappen - 1);
                    ?>
                        <div class="mk-systemen__werking__step">
                            <div class="mk-systemen__werking__step__card">
                                <span class="mk-systemen__werking__step__card__nummer"><?php echo esc_html($nummer); ?></span>
                                <?php if ($icoon) : ?>
                                    <img class="mk-systemen__werking__step__card__icoon" src="<?php echo esc_url($icoon['url']); ?>" alt="<?php echo esc_attr($icoon['alt']); ?>">
                                <?php endif; ?>
                                <?php if (!empty($stap['titel'])) : ?>
                                    <h4 class="mk-systemen__werking__step__card__titel"><?php echo esc_html($stap['titel']); ?></h4>
                                <?php endif; ?>
                                <?php if (!empty($stap['tekst'])) : ?>
                                    <p class="mk-systemen__werking__step__card__tekst"><?php echo esc_html($stap['tekst']); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if (!$is_last) : ?>
                                <span class="mk-systemen__werking__step__arrow" aria-hidden="true">
                                    <?php echo $arrow_icon; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($types_titel) : ?>
                <h3 class="mk-systemen__types-titel"><?php echo esc_html($types_titel); ?></h3>
            <?php endif; ?>

            <?php if ($systemen) : ?>
                <div class="mk-systemen__grid">
                    <?php foreach ($systemen as $item) :
                        $icoon = $item['icoon'];
                    ?>
                        <div class="mk-systemen__grid__card">
                            <?php if ($icoon) : ?>
                                <img class="mk-systemen__grid__card__icoon" src="<?php echo esc_url($icoon['url']); ?>" alt="<?php echo esc_attr($icoon['alt']); ?>">
                            <?php endif; ?>
                            <?php if (!empty($item['titel'])) : ?>
                                <h3 class="mk-systemen__grid__card__titel"><?php echo esc_html($item['titel']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($item['tekst'])) : ?>
                                <div class="mk-systemen__grid__card__tekst"><?php echo wp_kses_post($item['tekst']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($knop_tekst && $knop_url) : ?>
                <a class="btn btn--primary" href="<?php echo esc_url($knop_url); ?>">
                    <span><?php echo esc_html($knop_tekst); ?></span>
                    <?php echo $arrow_icon; ?>
                </a>
            <?php endif; ?>

        </div>
    </div>
</section>
