<?php
    $logo_1 = get_field('logo_1');
    $logo_2 = get_field('logo_2');
    $label  = get_field('label');
    $titel  = get_field('titel');
    $tekst  = get_field('tekst');
    $usps   = get_field('usps');

    if (!$logo_1 && !$logo_2 && !$titel) {
        return;
    }

    $check_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/checkmark icon.svg');
?>

<section class="mk-samenwerking mk-bg-radius">
    <div class="mk-samenwerking__container">
        <div class="mk-samenwerking__container__inner">

            <?php if ($logo_1 || $logo_2) : ?>
                <div class="mk-samenwerking__logos">
                    <?php if ($logo_1) : ?>
                        <img class="mk-samenwerking__logos__logo" src="<?php echo esc_url($logo_1['url']); ?>" alt="<?php echo esc_attr($logo_1['alt']); ?>">
                    <?php endif; ?>
                    <?php if ($logo_1 && $logo_2) : ?>
                        <span class="mk-samenwerking__logos__x">×</span>
                    <?php endif; ?>
                    <?php if ($logo_2) : ?>
                        <img class="mk-samenwerking__logos__logo" src="<?php echo esc_url($logo_2['url']); ?>" alt="<?php echo esc_attr($logo_2['alt']); ?>">
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($label) : ?>
                <span class="mk-samenwerking__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-samenwerking__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($tekst) : ?>
                <div class="mk-samenwerking__tekst"><?php echo wp_kses_post($tekst); ?></div>
            <?php endif; ?>

            <?php if ($usps) : ?>
                <div class="mk-samenwerking__usps">
                    <?php foreach ($usps as $usp) : ?>
                        <div class="mk-samenwerking__usps__item">
                            <span class="mk-samenwerking__usps__item__icoon"><?php echo $check_icon; ?></span>
                            <div class="mk-samenwerking__usps__item__body">
                                <?php if (!empty($usp['titel'])) : ?>
                                    <span class="mk-samenwerking__usps__item__body__titel"><?php echo esc_html($usp['titel']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($usp['tekst'])) : ?>
                                    <span class="mk-samenwerking__usps__item__body__tekst"><?php echo esc_html($usp['tekst']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
