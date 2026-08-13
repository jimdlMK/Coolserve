<?php
    $email  = get_field('email', 'options');
    $adres  = get_field('adres', 'options');
    $postcode = get_field('postcode', 'options');
    if (!$email) return;
?>
<a class="contact-card contact-card--email" href="mailto:<?php echo esc_attr($email); ?>">
    <span class="contact-card__icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="m3.5 6 8.5 7 8.5-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </span>
    <span class="contact-card__title">E-mail &amp; Postbus</span>
    <span class="contact-card__value"><?php echo esc_html($email); ?></span>
    <?php if ($adres) : ?>
        <span class="contact-card__note"><?php echo esc_html($adres); ?><?php if ($postcode) : ?> <?php echo esc_html($postcode); ?><?php endif; ?></span>
    <?php endif; ?>
</a>
