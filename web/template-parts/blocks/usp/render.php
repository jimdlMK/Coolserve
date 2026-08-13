<?php
    $usps = get_field('usps');
    if (!$usps) return;

    $swoosh_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/usps.svg');
?>

<section class="mk-usp">
    <div class="mk-usp__container">
        <div class="mk-usp__container__inner">
            <?php foreach ($usps as $usp) : ?>
                <div class="mk-usp__item">
                    <span class="mk-usp__item__icon"><?php echo $swoosh_icon; ?></span>
                    <span class="mk-usp__item__tekst"><?php echo esc_html($usp['tekst']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
