<?php
    $achtergrond_type = isset($mk_eigenschappen_achtergrond_type) ? $mk_eigenschappen_achtergrond_type : (get_field('achtergrond_type') ?: 'grijs');
    $label            = isset($mk_eigenschappen_label) ? $mk_eigenschappen_label : get_field('label');
    $titel            = isset($mk_eigenschappen_titel) ? $mk_eigenschappen_titel : get_field('titel');
    $afbeelding       = isset($mk_eigenschappen_afbeelding) ? $mk_eigenschappen_afbeelding : get_field('afbeelding');
    $eigenschappen    = isset($mk_eigenschappen_items) ? $mk_eigenschappen_items : get_field('eigenschappen');

    if (!$eigenschappen) {
        return;
    }

    $classes = ['mk-eigenschappen', 'mk-bg-' . esc_attr($achtergrond_type)];
    if (in_array($achtergrond_type, ['gradient', 'blauw'], true)) {
        $classes[] = 'mk-bg-radius';
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-eigenschappen__container">
        <div class="mk-eigenschappen__container__inner">

            <?php if ($label) : ?>
                <span class="mk-eigenschappen__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-eigenschappen__title"><?php echo wp_kses_post($titel); ?></h2>
            <?php endif; ?>

            <div class="mk-eigenschappen__grid">
                <?php foreach ($eigenschappen as $index => $item) :
                    $icoon = $item['icoon'];
                ?>
                    <div class="mk-eigenschappen__grid__card">
                        <div class="mk-eigenschappen__grid__card__head">
                            <?php if ($icoon) : ?>
                                <span class="mk-eigenschappen__grid__card__icoon">
                                    <img src="<?php echo esc_url($icoon['url']); ?>" alt="<?php echo esc_attr($icoon['alt']); ?>">
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($item['titel'])) : ?>
                                <h3 class="mk-eigenschappen__grid__card__titel"><?php echo esc_html($item['titel']); ?></h3>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($item['tekst'])) : ?>
                            <p class="mk-eigenschappen__grid__card__tekst"><?php echo esc_html($item['tekst']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if ($index === 0 && $afbeelding) : ?>
                        <div class="mk-eigenschappen__grid__media">
                            <img src="<?php echo esc_url($afbeelding['url']); ?>" alt="<?php echo esc_attr($afbeelding['alt']); ?>">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
