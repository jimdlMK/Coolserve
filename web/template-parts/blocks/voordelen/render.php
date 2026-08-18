<?php
    $achtergrond_type = get_field('achtergrond_type') ?: 'wit';
    $label            = get_field('label');
    $titel            = get_field('titel');
    $tekst            = get_field('tekst');
    $voordelen        = get_field('voordelen');

    $classes = ['mk-voordelen', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="voordelen" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-voordelen__container">
        <div class="mk-voordelen__container__inner">

            <?php if ($label) : ?>
                <span class="mk-voordelen__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-voordelen__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($tekst) : ?>
                <p class="mk-voordelen__text"><?php echo esc_html($tekst); ?></p>
            <?php endif; ?>

            <?php if ($voordelen) : ?>
                <div class="mk-voordelen__grid">
                    <?php foreach ($voordelen as $item) :
                        $icoon = $item['icoon'];
                    ?>
                        <div class="mk-voordelen__grid__card">
                            <?php if ($icoon) : ?>
                                <img class="mk-voordelen__grid__card__icoon" src="<?php echo esc_url($icoon['url']); ?>" alt="<?php echo esc_attr($icoon['alt']); ?>">
                            <?php endif; ?>
                            <?php if (!empty($item['titel'])) : ?>
                                <h3 class="mk-voordelen__grid__card__titel"><?php echo esc_html($item['titel']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($item['tekst'])) : ?>
                                <p class="mk-voordelen__grid__card__tekst"><?php echo esc_html($item['tekst']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
