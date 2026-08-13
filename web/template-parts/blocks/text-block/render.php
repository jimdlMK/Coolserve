<?php
    $achtergrond_type = get_field('achtergrond_type') ?: 'wit';
    $titel            = get_field('titel');
    $grote_tekst      = get_field('grote_tekst');
    $leestekst        = get_field('leestekst');
    $knop_type        = get_field('knop_type');
    $knop_link        = get_field('knop_link');

    $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');

    $classes = ['mk-text-block', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-text-block__container">
        <div class="mk-text-block__container__inner">

            <?php if ($titel) : ?>
                <h2 class="mk-text-block__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($grote_tekst) : ?>
                <div class="mk-text-block__grote-tekst"><?php echo wp_kses_post($grote_tekst); ?></div>
            <?php endif; ?>

            <?php if ($leestekst) : ?>
                <div class="mk-text-block__leestekst"><?php echo wp_kses_post($leestekst); ?></div>
            <?php endif; ?>

            <?php if ($knop_type && $knop_link && !empty($knop_link['url'])) :
                $target = !empty($knop_link['target']) ? ' target="' . esc_attr($knop_link['target']) . '"' : '';
            ?>
                <a class="btn btn--<?php echo esc_attr($knop_type); ?>" href="<?php echo esc_url($knop_link['url']); ?>"<?php echo $target; ?>>
                    <span><?php echo esc_html($knop_link['title']); ?></span>
                    <?php echo $arrow_icon; ?>
                </a>
            <?php endif; ?>

        </div>
    </div>
</section>
