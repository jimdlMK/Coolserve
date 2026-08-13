<?php
    $achtergrond_type = get_field('achtergrond_type') ?: 'wit';
    $label            = get_field('label');
    $titel            = get_field('titel');
    $tekst            = get_field('tekst');
    $diensten_items   = get_field('diensten_items');

    $check_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/checkmark icon.svg');

    $classes = ['mk-diensten-sectie', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-diensten-sectie__container">
        <div class="mk-diensten-sectie__container__inner">

            <?php if ($label) : ?>
                <span class="mk-diensten-sectie__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-diensten-sectie__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($tekst) : ?>
                <p class="mk-diensten-sectie__text"><?php echo esc_html($tekst); ?></p>
            <?php endif; ?>

            <?php if ($diensten_items) : ?>
                <div class="mk-diensten-sectie__grid">
                    <?php foreach ($diensten_items as $item) :
                        $icoon      = $item['icoon'];
                        $checkmarks = $item['checkmarks'];
                    ?>
                        <div class="mk-diensten-sectie__grid__card">
                            <div class="mk-diensten-sectie__grid__card__head">
                                <?php if ($icoon) : ?>
                                    <img class="mk-diensten-sectie__grid__card__head__icoon" src="<?php echo esc_url($icoon['url']); ?>" alt="<?php echo esc_attr($icoon['alt']); ?>">
                                <?php endif; ?>
                                <?php if (!empty($item['titel'])) : ?>
                                    <h3 class="mk-diensten-sectie__grid__card__head__titel"><?php echo esc_html($item['titel']); ?></h3>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($item['tekst'])) : ?>
                                <p class="mk-diensten-sectie__grid__card__tekst"><?php echo esc_html($item['tekst']); ?></p>
                            <?php endif; ?>

                            <?php if ($checkmarks) : ?>
                                <div class="mk-diensten-sectie__grid__card__checkmarks">
                                    <?php foreach ($checkmarks as $check) : ?>
                                        <span class="mk-diensten-sectie__grid__card__checkmarks__item">
                                            <?php echo $check_icon; ?>
                                            <?php echo esc_html($check['tekst']); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
