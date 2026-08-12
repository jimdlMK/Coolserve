<?php if (have_rows('locaties', 'options')) : while (have_rows('locaties', 'options')) : the_row();
    $naam            = get_sub_field('naam');
    $straat          = get_sub_field('straat');
    $postcode_plaats = get_sub_field('postcode_plaats');
    $telefoon        = get_sub_field('telefoon');
    $email           = get_sub_field('email');
?>
    <div class="location-info">
        <h5><?php echo esc_html($naam); ?></h5>
        <?php if ($straat) : ?><span><?php echo esc_html($straat); ?></span><?php endif; ?>
        <?php if ($postcode_plaats) : ?><span><?php echo esc_html($postcode_plaats); ?></span><?php endif; ?>
        <?php if ($telefoon) : ?><span>Telefoonnummer <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $telefoon)); ?>"><?php echo esc_html($telefoon); ?></a></span><?php endif; ?>
        <?php if ($email) : ?><span>E-mail: <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span><?php endif; ?>
    </div>
<?php endwhile; endif; ?>
