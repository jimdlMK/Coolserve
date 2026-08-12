<?php
    $companyname  = get_field('bedrijfsnaam', 'options');
    $kvk          = get_field('kvk_nummer', 'options');
    $btw          = get_field('btw_nummer', 'options');
    $contact_page = get_field('contact_pagina', 'options');
?>

<div class="contact-info">
    <h5>Neem contact met ons op</h5>
    <p>Neem contact op met <?php echo esc_html($companyname); ?> en bekijk wat de mogelijkheden voor jou zijn.</p>

    <div class="contact-info__numbers">
        <?php if ($kvk) : ?><span>KvK-nummer: <?php echo esc_html($kvk); ?></span><?php endif; ?>
        <?php if ($btw) : ?><span>BTW nummer: <?php echo esc_html($btw); ?></span><?php endif; ?>
    </div>

    <?php if ($contact_page) : ?>
        <a class="btn btn--primary" href="<?php echo esc_url(get_permalink($contact_page)); ?>">
            <span>Contact opnemen</span>
            <?php echo file_get_contents(get_stylesheet_directory() . '/assets/images/Icon awesome-arrow-right.svg'); ?>
        </a>
    <?php endif; ?>
</div>
