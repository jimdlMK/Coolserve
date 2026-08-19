<?php
    $achtergrond_type = isset($mk_eigenschappen_achtergrond_type) ? $mk_eigenschappen_achtergrond_type : (get_field('achtergrond_type') ?: 'grijs');
    $layout           = isset($mk_eigenschappen_layout) ? $mk_eigenschappen_layout : (get_field('layout') ?: 'grid');
    $label            = isset($mk_eigenschappen_label) ? $mk_eigenschappen_label : get_field('label');
    $titel            = isset($mk_eigenschappen_titel) ? $mk_eigenschappen_titel : get_field('titel');
    $tekst            = isset($mk_eigenschappen_tekst) ? $mk_eigenschappen_tekst : get_field('tekst');
    $afbeelding       = isset($mk_eigenschappen_afbeelding) ? $mk_eigenschappen_afbeelding : get_field('afbeelding');
    $toon_badge       = isset($mk_eigenschappen_toon_cijfer_badge) ? $mk_eigenschappen_toon_cijfer_badge : get_field('toon_cijfer_badge');
    $eigenschappen    = isset($mk_eigenschappen_items) ? $mk_eigenschappen_items : get_field('eigenschappen');

    if (!$eigenschappen) {
        return;
    }

    $is_tekst_badge = ($layout === 'tekst_badge');

    $classes = ['mk-eigenschappen', 'mk-bg-' . esc_attr($achtergrond_type)];
    if (in_array($achtergrond_type, ['gradient', 'blauw'], true)) {
        $classes[] = 'mk-bg-radius';
    }
    if ($is_tekst_badge) {
        $classes[] = 'mk-eigenschappen--tekst-badge';
    }

    if ($is_tekst_badge && $toon_badge) {
        $cijfers = [
            ['waarde' => get_field('cijfer_jaar_ervaring', 'options'), 'label' => 'Jaren ervaring', 'icoon' => 'medaille'],
            ['waarde' => get_field('cijfer_tevreden_klanten', 'options'), 'label' => 'Tevreden klanten', 'icoon' => 'duim'],
            ['waarde' => get_field('cijfer_professionals', 'options'), 'label' => 'Professionals', 'icoon' => 'team'],
        ];
        $cijfers = array_values(array_filter($cijfers, function ($c) {
            return !empty($c['waarde']);
        }));

        $badge_icons = [
            'medaille' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="9" r="6" stroke="currentColor" stroke-width="2"/><path d="m8.5 14-1.5 7 5-2.5 5 2.5-1.5-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'duim'      => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M7 11v9H4a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1h3Zm0 0 4.5-7.5a2 2 0 0 1 3.4 2L14 9h4.5a2 2 0 0 1 1.9 2.7l-2 6A2 2 0 0 1 16.5 19H10a3 3 0 0 1-3-3v-5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'team'      => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="2"/><path d="M3 20v-1a6 6 0 0 1 6-6h0a6 6 0 0 1 6 6v1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 4.2a3 3 0 0 1 0 5.6M19 20v-1a6 6 0 0 0-3.5-5.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        ];
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-eigenschappen__container">
        <div class="mk-eigenschappen__container__inner">

            <?php if ($is_tekst_badge) : ?>

                <div class="mk-eigenschappen__intro">
                    <div class="mk-eigenschappen__intro__tekst">
                        <?php if ($label) : ?>
                            <span class="mk-eigenschappen__label"><?php echo esc_html($label); ?></span>
                        <?php endif; ?>

                        <?php if ($titel) : ?>
                            <h2 class="mk-eigenschappen__title"><?php echo wp_kses_post($titel); ?></h2>
                        <?php endif; ?>

                        <?php if ($tekst) : ?>
                            <p class="mk-eigenschappen__intro__tekst__p"><?php echo esc_html($tekst); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if ($afbeelding) : ?>
                        <div class="mk-eigenschappen__intro__media">
                            <img src="<?php echo esc_url($afbeelding['url']); ?>" alt="<?php echo esc_attr($afbeelding['alt']); ?>">

                            <?php if (!empty($cijfers)) : ?>
                                <div class="mk-eigenschappen__badge" data-mk-cijfer-badge>
                                    <?php foreach ($cijfers as $i => $cijfer) : ?>
                                        <div class="mk-eigenschappen__badge__item<?php echo $i === 0 ? ' is-active' : ''; ?>">
                                            <span class="mk-eigenschappen__badge__item__icoon"><?php echo $badge_icons[$cijfer['icoon']]; ?></span>
                                            <span class="mk-eigenschappen__badge__item__body">
                                                <span class="mk-eigenschappen__badge__item__body__waarde"><span data-countup="<?php echo esc_attr($cijfer['waarde']); ?>">0</span>+</span>
                                                <span class="mk-eigenschappen__badge__item__body__label"><?php echo esc_html($cijfer['label']); ?></span>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mk-eigenschappen__grid mk-eigenschappen__grid--titels">
                    <?php foreach ($eigenschappen as $item) :
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
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else : ?>

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

            <?php endif; ?>

        </div>
    </div>
</section>

<?php if ($is_tekst_badge) :
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-eigenschappen', $theme_uri . '/template-parts/blocks/eigenschappen/eigenschappen.js', [], filemtime($theme_dir . '/template-parts/blocks/eigenschappen/eigenschappen.js'), true);
    wp_enqueue_script('mk-eigenschappen');
endif; ?>
