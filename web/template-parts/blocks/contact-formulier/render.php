<?php
    $section_id = isset($mk_contact_formulier_id) ? $mk_contact_formulier_id : '';
    $label      = isset($mk_contact_formulier_label) ? $mk_contact_formulier_label : get_field('label');
    $titel      = isset($mk_contact_formulier_titel) ? $mk_contact_formulier_titel : get_field('titel');
    $tekst      = isset($mk_contact_formulier_tekst) ? $mk_contact_formulier_tekst : get_field('tekst');
    $form_id    = isset($mk_contact_formulier_form_id) ? $mk_contact_formulier_form_id : get_field('form_id');

    if (!$form_id || !function_exists('gravity_form')) {
        return;
    }

    // Titel: laatste woord automatisch lichtblauw
    $titel_html = '';
    if ($titel) {
        $woorden = explode(' ', trim($titel));
        $laatste = array_pop($woorden);
        $titel_html = ($woorden ? esc_html(implode(' ', $woorden)) . ' ' : '') . '<span>' . esc_html($laatste) . '</span>';
    }

    $telefoon       = get_field('telefoon', 'options');
    $email          = get_field('email', 'options');
    $openingstijden = get_field('openingstijden', 'options');
    $locaties       = get_field('locaties', 'options');

    $phone_icon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L14 13l5 2v4a2 2 0 0 1-2 2C9.5 21 3 14.5 3 6a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $email_icon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="m3.5 6 8.5 7 8.5-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $location_icon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2"/></svg>';
    $clock_icon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>

<section<?php echo $section_id ? ' id="' . esc_attr($section_id) . '"' : ''; ?> class="mk-contact-formulier">
    <div class="mk-contact-formulier__container">
        <div class="mk-contact-formulier__container__inner">

            <div class="mk-contact-formulier__info">
                <?php if ($label) : ?>
                    <span class="mk-contact-formulier__info__label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titel_html) : ?>
                    <h2 class="mk-contact-formulier__info__title"><?php echo $titel_html; ?></h2>
                <?php endif; ?>

                <?php if ($tekst) : ?>
                    <p class="mk-contact-formulier__info__text"><?php echo esc_html($tekst); ?></p>
                <?php endif; ?>

                <?php if ($telefoon || $email || $locaties || $openingstijden) : ?>
                    <div class="mk-contact-formulier__info__lijst">
                        <?php if ($telefoon) : ?>
                            <a class="mk-contact-formulier__info__item mk-contact-formulier__info__item--accent" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $telefoon)); ?>">
                                <span class="mk-contact-formulier__info__item__icon"><?php echo $phone_icon; ?></span>
                                <span class="mk-contact-formulier__info__item__body">
                                    <span class="mk-contact-formulier__info__item__body__label">Bel ons direct</span>
                                    <span class="mk-contact-formulier__info__item__body__waarde"><?php echo esc_html($telefoon); ?></span>
                                </span>
                            </a>
                        <?php endif; ?>

                        <?php if ($email) : ?>
                            <a class="mk-contact-formulier__info__item" href="mailto:<?php echo esc_attr($email); ?>">
                                <span class="mk-contact-formulier__info__item__icon"><?php echo $email_icon; ?></span>
                                <span class="mk-contact-formulier__info__item__body">
                                    <span class="mk-contact-formulier__info__item__body__label">E-mail</span>
                                    <span class="mk-contact-formulier__info__item__body__waarde"><?php echo esc_html($email); ?></span>
                                </span>
                            </a>
                        <?php endif; ?>

                        <?php if ($locaties) : foreach ($locaties as $locatie) :
                            $naam            = $locatie['naam'];
                            $straat          = $locatie['straat'];
                            $postcode_plaats = $locatie['postcode_plaats'];
                        ?>
                            <div class="mk-contact-formulier__info__item">
                                <span class="mk-contact-formulier__info__item__icon"><?php echo $location_icon; ?></span>
                                <span class="mk-contact-formulier__info__item__body">
                                    <span class="mk-contact-formulier__info__item__body__label">Vestiging <?php echo esc_html($naam); ?></span>
                                    <span class="mk-contact-formulier__info__item__body__waarde"><?php echo esc_html(trim($straat . ', ' . $postcode_plaats, ', ')); ?></span>
                                </span>
                            </div>
                        <?php endforeach; endif; ?>

                        <?php if ($openingstijden) : ?>
                            <div class="mk-contact-formulier__info__item">
                                <span class="mk-contact-formulier__info__item__icon"><?php echo $clock_icon; ?></span>
                                <span class="mk-contact-formulier__info__item__body">
                                    <span class="mk-contact-formulier__info__item__body__label">Openingstijden</span>
                                    <span class="mk-contact-formulier__info__item__body__waarde"><?php echo esc_html($openingstijden); ?></span>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mk-contact-formulier__form">
                <?php if ($label) : ?>
                    <h3 class="mk-contact-formulier__form__titel"><?php echo esc_html($label === 'Solliciteren' ? 'Solliciteer direct' : 'Neem contact op'); ?></h3>
                <?php endif; ?>
                <?php gravity_form($form_id, false, false, false, '', true, 0, true); ?>
            </div>

        </div>
    </div>
</section>
