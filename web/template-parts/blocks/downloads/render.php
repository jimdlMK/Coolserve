<?php
    $achtergrond_type = get_field('achtergrond_type') ?: 'grijs';
    $label            = get_field('label');
    $titel            = get_field('titel');
    $tekst            = get_field('tekst');
    $downloads        = get_field('downloads');

    if (!$downloads) {
        return;
    }

    $classes = ['mk-downloads', 'mk-bg-' . esc_attr($achtergrond_type)];
    if (in_array($achtergrond_type, ['gradient', 'blauw'], true)) {
        $classes[] = 'mk-bg-radius';
    }
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="mk-downloads__container">
        <div class="mk-downloads__container__inner">

            <?php if ($label || $titel || $tekst) : ?>
                <div class="mk-downloads__intro">
                    <?php if ($label) : ?>
                        <span class="mk-downloads__label"><?php echo esc_html($label); ?></span>
                    <?php endif; ?>

                    <?php if ($titel) : ?>
                        <h2 class="mk-downloads__title"><?php echo wp_kses_post($titel); ?></h2>
                    <?php endif; ?>

                    <?php if ($tekst) : ?>
                        <p class="mk-downloads__intro__tekst"><?php echo esc_html($tekst); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="mk-downloads__grid">
                <?php foreach ($downloads as $item) :
                    $item_titel  = $item['titel'];
                    $bestand     = $item['bestand'];
                    if (!$bestand) continue;

                    $bestandsgrootte = !empty($bestand['filesize']) ? size_format($bestand['filesize'], 1) : '';
                ?>
                    <a class="mk-downloads__grid__card" href="<?php echo esc_url($bestand['url']); ?>" download target="_blank" rel="noopener">
                        <span class="mk-downloads__grid__card__icoon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M7 3h7l5 5v10a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M14 3v5h5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M12 11v6m0 0-2.5-2.5M12 17l2.5-2.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>

                        <span class="mk-downloads__grid__card__body">
                            <span class="mk-downloads__grid__card__titel"><?php echo esc_html($item_titel); ?></span>
                            <span class="mk-downloads__grid__card__meta">PDF<?php echo $bestandsgrootte ? ' &middot; ' . esc_html($bestandsgrootte) : ''; ?></span>
                        </span>

                        <span class="mk-downloads__grid__card__arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M12 4v13m0 0 5-5m-5 5-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
