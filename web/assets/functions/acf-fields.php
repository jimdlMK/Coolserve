<?php
    /**
     * ACF Local Field Groups — child theme (Mediakanjers)
     * Footer: bedrijfsgegevens, vestigingen, legal-links
     */
    add_action('acf/include_fields', function () {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group(array(
            'key' => 'group_mk_footer_settings',
            'title' => 'Footer instellingen',
            'fields' => array(
                array(
                    'key' => 'field_mk_footer_tab_bedrijf',
                    'label' => 'Bedrijfsgegevens',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_mk_footer_kvk_nummer',
                    'label' => 'KvK-nummer',
                    'name' => 'kvk_nummer',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_mk_footer_btw_nummer',
                    'label' => 'BTW-nummer',
                    'name' => 'btw_nummer',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_mk_footer_contact_pagina',
                    'label' => 'Contact opnemen — link',
                    'name' => 'contact_pagina',
                    'type' => 'page_link',
                    'instructions' => 'Pagina waar de "Contact opnemen" knop in de footer naartoe linkt.',
                ),
                array(
                    'key' => 'field_mk_footer_tab_vestigingen',
                    'label' => 'Vestigingen',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_mk_footer_locaties',
                    'label' => 'Vestigingen',
                    'name' => 'locaties',
                    'type' => 'repeater',
                    'button_label' => 'Nieuwe vestiging',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mk_footer_locatie_naam',
                            'label' => 'Plaatsnaam (kolomtitel)',
                            'name' => 'naam',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mk_footer_locatie_straat',
                            'label' => 'Straat + huisnummer',
                            'name' => 'straat',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mk_footer_locatie_postcode',
                            'label' => 'Postcode + plaats',
                            'name' => 'postcode_plaats',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mk_footer_locatie_telefoon',
                            'label' => 'Telefoonnummer',
                            'name' => 'telefoon',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mk_footer_locatie_email',
                            'label' => 'E-mail',
                            'name' => 'email',
                            'type' => 'email',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mk_footer_tab_legal',
                    'label' => 'Legal links',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_mk_footer_privacyverklaring',
                    'label' => 'Privacyverklaring',
                    'name' => 'privacyverklaring',
                    'type' => 'page_link',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_mk_footer_voorwaarden_particulier',
                    'label' => 'Algemene voorwaarden particulier',
                    'name' => 'voorwaarden_particulier',
                    'type' => 'page_link',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_mk_footer_voorwaarden_zakelijk',
                    'label' => 'Algemene voorwaarden zakelijk',
                    'name' => 'voorwaarden_zakelijk',
                    'type' => 'page_link',
                    'wrapper' => array('width' => '34'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'acf-options-website-instellingen',
                    ),
                ),
            ),
            'active' => true,
        ));
    });
?>
