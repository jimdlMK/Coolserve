<?php
    $achtergrond_type = get_field('achtergrond_type') ?: 'wit';
    $label = get_field('label');
    $titel = get_field('titel');
    $items = get_field('items');

    $arrow_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg');

    static $mk_formulieren_instance = 0;
    $mk_formulieren_instance++;
    $block_uid = 'mk-formulieren-' . $mk_formulieren_instance;

    $classes = ['mk-formulieren', 'mk-bg-' . esc_attr($achtergrond_type)];
    if ($achtergrond_type === 'gradient') {
        $classes[] = 'mk-bg-radius';
    }
?>

<section id="formulieren" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-formulieren__container">
        <div class="mk-formulieren__container__inner">

            <?php if ($label) : ?>
                <span class="mk-formulieren__label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($titel) : ?>
                <h2 class="mk-formulieren__title"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($items) : ?>
                <div class="mk-formulieren__grid">
                    <?php foreach ($items as $index => $item) :
                        $kleur    = $item['kleur'] ?: 'blauw';
                        $icoon    = $item['icoon'];
                        $item_uid = $block_uid . '-item-' . $index;
                    ?>
                        <button type="button" class="mk-formulieren__grid__card mk-formulieren__grid__card--<?php echo esc_attr($kleur); ?>" data-mk-formulieren-toggle="<?php echo esc_attr($item_uid); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr($item_uid); ?>">
                            <?php if ($icoon) : ?>
                                <img class="mk-formulieren__grid__card__icoon" src="<?php echo esc_url($icoon['url']); ?>" alt="<?php echo esc_attr($icoon['alt']); ?>">
                            <?php endif; ?>
                            <?php if (!empty($item['titel'])) : ?>
                                <span class="mk-formulieren__grid__card__titel"><?php echo esc_html($item['titel']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($item['tekst'])) : ?>
                                <span class="mk-formulieren__grid__card__tekst"><?php echo esc_html($item['tekst']); ?></span>
                            <?php endif; ?>
                            <span class="mk-formulieren__grid__card__link">
                                <span><?php echo esc_html($item['link_tekst'] ?: 'Naar contactformulier'); ?></span>
                                <?php echo $arrow_icon; ?>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="mk-formulieren__panels">
                    <?php foreach ($items as $index => $item) :
                        $item_uid = $block_uid . '-item-' . $index;
                        $form_id  = !empty($item['form_id']) ? (int) $item['form_id'] : 0;
                    ?>
                        <div id="<?php echo esc_attr($item_uid); ?>" class="mk-formulieren__panel" data-mk-formulieren-panel hidden>
                            <div class="mk-formulieren__panel__inner">
                                <?php if ($form_id && function_exists('gravity_form')) : ?>
                                    <?php gravity_form($form_id, false, false, false, '', true, 0, true); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-formulieren', $theme_uri . '/template-parts/blocks/formulieren/formulieren.js', [], filemtime($theme_dir . '/template-parts/blocks/formulieren/formulieren.js'), true);
    wp_enqueue_script('mk-formulieren');
?>
