<?php
    $mk_location_index = 0;
    if (have_rows('locaties', 'options')) : while (have_rows('locaties', 'options')) : the_row();
    $naam            = get_sub_field('naam');
    $straat          = get_sub_field('straat');
    $postcode_plaats = get_sub_field('postcode_plaats');
    $telefoon        = get_sub_field('telefoon');
    $email           = get_sub_field('email');
    $mk_location_index++;
    $location_uid = 'mk-location-' . $mk_location_index;
?>
    <div class="location-info">
        <button type="button" class="location-info__toggle" data-mk-location-toggle aria-expanded="false" aria-controls="<?php echo esc_attr($location_uid); ?>">
            <h5><?php echo esc_html($naam); ?></h5>
        </button>
        <div id="<?php echo esc_attr($location_uid); ?>" class="location-info__body" data-mk-location-body>
            <?php if ($straat) : ?><span><?php echo esc_html($straat); ?></span><?php endif; ?>
            <?php if ($postcode_plaats) : ?><span><?php echo esc_html($postcode_plaats); ?></span><?php endif; ?>
            <?php if ($telefoon) : ?><span>Telefoonnummer <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $telefoon)); ?>"><?php echo esc_html($telefoon); ?></a></span><?php endif; ?>
            <?php if ($email) : ?><span>E-mail: <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span><?php endif; ?>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();
    wp_register_script('mk-location-toggle', $theme_uri . '/template-parts/contact/location-toggle.js', [], filemtime($theme_dir . '/template-parts/contact/location-toggle.js'), true);
    wp_enqueue_script('mk-location-toggle');
?>
