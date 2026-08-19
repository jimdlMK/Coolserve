<?php
    $achtergrond_type = isset($mk_tijdlijn_achtergrond_type) ? $mk_tijdlijn_achtergrond_type : (get_field('achtergrond_type') ?: 'grijs');
    $label            = isset($mk_tijdlijn_label) ? $mk_tijdlijn_label : get_field('label');
    $titel            = isset($mk_tijdlijn_titel) ? $mk_tijdlijn_titel : get_field('titel');
    $tekst            = isset($mk_tijdlijn_tekst) ? $mk_tijdlijn_tekst : get_field('tekst');
    $tijdlijn         = isset($mk_tijdlijn_items) ? $mk_tijdlijn_items : get_field('tijdlijn');

    if (!$tijdlijn) {
        return;
    }

    $classes = ['mk-tijdlijn', 'mk-bg-' . esc_attr($achtergrond_type)];
    if (in_array($achtergrond_type, ['gradient', 'blauw'], true)) {
        $classes[] = 'mk-bg-radius';
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-tijdlijn__container">
        <div class="mk-tijdlijn__container__inner">

            <div class="mk-tijdlijn__info">
                <?php if ($label) : ?>
                    <span class="mk-tijdlijn__label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titel) : ?>
                    <h2 class="mk-tijdlijn__title"><?php echo wp_kses_post($titel); ?></h2>
                <?php endif; ?>

                <?php if ($tekst) : ?>
                    <div class="mk-tijdlijn__tekst"><?php echo wp_kses_post($tekst); ?></div>
                <?php endif; ?>
            </div>

            <div class="mk-tijdlijn__lijn" data-mk-tijdlijn>
                <?php foreach ($tijdlijn as $index => $item) : ?>
                    <div class="mk-tijdlijn__item" data-mk-tijdlijn-item>
                        <span class="mk-tijdlijn__item__jaar"><?php echo esc_html($item['jaar']); ?></span>
                        <span class="mk-tijdlijn__item__titel"><?php echo esc_html($item['titel']); ?></span>
                        <?php if ($index < count($tijdlijn) - 1) : ?>
                            <span class="mk-tijdlijn__item__connector"></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>

<?php
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-tijdlijn', $theme_uri . '/template-parts/blocks/tijdlijn/tijdlijn.js', [], filemtime($theme_dir . '/template-parts/blocks/tijdlijn/tijdlijn.js'), true);
    wp_enqueue_script('mk-tijdlijn');
?>
