<?php if (!have_rows('locaties', 'options')) return;

    $locatie_namen = [];
    while (have_rows('locaties', 'options')) : the_row();
        $locatie_namen[] = get_sub_field('naam');
    endwhile;
    $eerste_locatie = $locatie_namen[0];
    $extra_locaties = count($locatie_namen) - 1;
?>
<div class="contact-card contact-card--locations">
    <span class="contact-card__icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2"/></svg>
    </span>
    <span class="contact-card__title">Locaties</span>
    <span class="contact-card__value contact-card__value--compact">
        <?php echo esc_html($eerste_locatie); ?><?php if ($extra_locaties > 0) : ?> <span class="contact-card__value--compact__extra">+<?php echo esc_html($extra_locaties); ?></span><?php endif; ?>
    </span>
    <div class="contact-card__locations">
        <?php while (have_rows('locaties', 'options')) : the_row();
            $naam            = get_sub_field('naam');
            $straat          = get_sub_field('straat');
            $postcode_plaats = get_sub_field('postcode_plaats');
            $maps_url        = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($naam . ' ' . $straat . ' ' . $postcode_plaats);
        ?>
            <div class="contact-card__locations__item">
                <span class="contact-card__locations__item__naam"><?php echo esc_html($naam); ?></span>
                <?php if ($straat) : ?><span><?php echo esc_html($straat); ?></span><?php endif; ?>
                <?php if ($postcode_plaats) : ?><span><?php echo esc_html($postcode_plaats); ?></span><?php endif; ?>
                <a href="<?php echo esc_url($maps_url); ?>" target="_blank" rel="noopener">Bekijk op kaart</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
