<?php
    $openingstijden = get_field('openingstijden', 'options');
    if (!$openingstijden) return;
?>
<div class="contact-card contact-card--hours">
    <span class="contact-card__icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </span>
    <span class="contact-card__title">Openingstijden</span>
    <span class="contact-card__value"><?php echo esc_html($openingstijden); ?></span>
    <span class="contact-card__note">Weekend op afspraak</span>
</div>
