<?php
    $usps = get_field('usps');
    if (!$usps) return;

    $swoosh_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/usps.svg');
?>

<section class="mk-usp">
    <div class="mk-usp__container">
        <div class="mk-usp__container__inner" data-mk-usp-slider>
            <?php foreach ($usps as $index => $usp) : ?>
                <div class="mk-usp__item<?php echo $index === 0 ? ' is-active' : ''; ?>">
                    <span class="mk-usp__item__icon"><?php echo $swoosh_icon; ?></span>
                    <span class="mk-usp__item__tekst"><?php echo esc_html($usp['tekst']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (count($usps) > 1) :
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-usp', $theme_uri . '/template-parts/blocks/usp/usp.js', [], filemtime($theme_dir . '/template-parts/blocks/usp/usp.js'), true);
    wp_enqueue_script('mk-usp');
endif; ?>
