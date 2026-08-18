<?php
    $achtergrond_type = isset($mk_merken_achtergrond_type) ? $mk_merken_achtergrond_type : (get_field('achtergrond_type') ?: 'wit');
    $label            = get_field('merken_label', 'options');
    $titel            = get_field('merken_titel', 'options');
    $merken           = get_field('merken', 'options');

    $classes = ['mk-merken', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="merken" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-merken__container">
        <div class="mk-merken__container__inner">

            <?php if ($label) : ?>
                <span class="mk-merken__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-merken__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($merken) :
                // Genoeg herhalingen zodat de track altijd breder is dan het scherm,
                // ook bij weinig merken — voorkomt een lege gap aan het einde van de loop.
                $herhalingen = max(2, (int) ceil(16 / count($merken)));
            ?>
                <div class="mk-merken__slider" data-mk-logo-slider>
                    <div class="mk-merken__slider__track" style="--mk-merken-herhalingen: <?php echo esc_attr($herhalingen); ?>;">
                        <?php for ($i = 0; $i < $herhalingen; $i++) : ?>
                            <?php foreach ($merken as $merk) :
                                $logo = $merk['logo'];
                                if (!$logo) continue;
                            ?>
                                <div class="mk-merken__slider__track__item">
                                    <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($merk['naam']); ?>">
                                </div>
                            <?php endforeach; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
