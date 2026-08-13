<?php
    $telefoon = get_field('telefoon', 'options');
    if (!$telefoon) return;
?>
<a class="contact-card contact-card--phone" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $telefoon)); ?>">
    <span class="contact-card__icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L14 13l5 2v4a2 2 0 0 1-2 2C9.5 21 3 14.5 3 6a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </span>
    <span class="contact-card__title">Bel ons</span>
    <span class="contact-card__value"><?php echo esc_html($telefoon); ?></span>
    <span class="contact-card__note">Direct beschikbaar</span>
</a>
