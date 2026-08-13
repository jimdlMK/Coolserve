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
                    'key' => 'field_mk_footer_openingstijden',
                    'label' => 'Openingstijden',
                    'name' => 'openingstijden',
                    'type' => 'text',
                    'instructions' => 'Bijv. "Ma-Vr: 08:30 - 17:00"',
                    'wrapper' => array('width' => '50'),
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

        /**
         * ACF Local Field Group — Cijfers (opties-pagina)
         * Gebruikt door mk/hero block ("Cijfers tonen" toggle)
         */
        acf_add_local_field_group(array(
            'key' => 'group_mk_cijfers_settings',
            'title' => 'Cijfers',
            'fields' => array(
                array(
                    'key' => 'field_mk_cijfers_jaar_ervaring',
                    'label' => 'Jaar ervaring',
                    'name' => 'cijfer_jaar_ervaring',
                    'type' => 'number',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_mk_cijfers_tevreden_klanten',
                    'label' => 'Tevreden klanten',
                    'name' => 'cijfer_tevreden_klanten',
                    'type' => 'number',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_mk_cijfers_professionals',
                    'label' => 'Professionals',
                    'name' => 'cijfer_professionals',
                    'type' => 'number',
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

        /**
         * ACF Local Field Group — mk/hero block
         */
        acf_add_local_field_group(array(
            'key' => 'group_mk_hero',
            'title' => 'Hero block',
            'fields' => array(
                array(
                    'key' => 'field_mk_hero_layout',
                    'label' => 'Layout',
                    'name' => 'layout',
                    'type' => 'select',
                    'choices' => array(
                        'standaard' => 'Standaard',
                        'split'     => '2-koloms met media rechts',
                        'contact'   => 'Contact-info',
                    ),
                    'default_value' => 'standaard',
                    'return_format' => 'value',
                    'ui' => 1,
                ),

                // ===== Achtergrond (standaard + contact layout) =====
                array(
                    'key' => 'field_mk_hero_tab_achtergrond',
                    'label' => 'Achtergrond',
                    'type' => 'tab',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_mk_hero_layout',
                                'operator' => '!=',
                                'value' => 'split',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mk_hero_achtergrond_afbeelding',
                    'label' => 'Achtergrond afbeelding',
                    'name' => 'achtergrond_afbeelding',
                    'type' => 'image',
                    'instructions' => 'Verplicht — dient ook als fallback/poster zolang de video (indien ingesteld) nog laadt.',
                    'required' => 1,
                    'return_format' => 'array',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_mk_hero_layout',
                                'operator' => '!=',
                                'value' => 'split',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mk_hero_vimeo_id',
                    'label' => 'Vimeo video-ID',
                    'name' => 'vimeo_id',
                    'type' => 'text',
                    'instructions' => 'Optioneel. Alleen het ID (bijv. 76979871), geen volledige URL. Video speelt gemuted/loop af als achtergrond; toont ook de "Bekijk de hele video" knop.',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_mk_hero_layout',
                                'operator' => '!=',
                                'value' => 'split',
                            ),
                        ),
                    ),
                ),

                // ===== Content =====
                array(
                    'key' => 'field_mk_hero_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_mk_hero_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                    'instructions' => 'Gebruik <span>tekst</span> rond het deel dat lichtblauw moet worden.',
                ),
                array(
                    'key' => 'field_mk_hero_tekst',
                    'label' => 'Tekst',
                    'name' => 'tekst',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_mk_hero_knop_type',
                    'label' => 'Knop',
                    'name' => 'knop_type',
                    'type' => 'select',
                    'choices' => array(
                        ''          => 'Geen knop',
                        'primary'   => 'Primary button',
                        'secondary' => 'Secondary button',
                        'hyperlink' => 'Hyperlink',
                    ),
                    'default_value' => '',
                    'return_format' => 'value',
                    'allow_null' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_mk_hero_knop_link',
                    'label' => 'Knop link',
                    'name' => 'knop_link',
                    'type' => 'link',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_mk_hero_knop_type',
                                'operator' => '!=empty',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mk_hero_snel_naar',
                    'label' => 'Snel naar',
                    'name' => 'snel_naar',
                    'type' => 'repeater',
                    'button_label' => 'Link toevoegen',
                    'layout' => 'table',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mk_hero_snel_naar_label',
                            'label' => 'Label',
                            'name' => 'label',
                            'type' => 'text',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_mk_hero_snel_naar_link',
                            'label' => 'Link (URL of #anchor)',
                            'name' => 'link',
                            'type' => 'text',
                            'wrapper' => array('width' => '60'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mk_hero_toon_cijfers',
                    'label' => 'Cijfers tonen',
                    'name' => 'toon_cijfers',
                    'type' => 'true_false',
                    'instructions' => 'Toont de 3 cijfers uit Mediakanjers → Website instellingen → Cijfers, met een optel-animatie.',
                    'ui' => 1,
                    'default_value' => 0,
                ),

                // ===== Media (alleen split-layout) =====
                array(
                    'key' => 'field_mk_hero_tab_media',
                    'label' => 'Media (rechterkolom)',
                    'type' => 'tab',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_mk_hero_layout',
                                'operator' => '==',
                                'value' => 'split',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mk_hero_split_afbeelding',
                    'label' => 'Afbeelding',
                    'name' => 'split_afbeelding',
                    'type' => 'image',
                    'return_format' => 'array',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_mk_hero_layout',
                                'operator' => '==',
                                'value' => 'split',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_mk_hero_split_vimeo_id',
                    'label' => 'Vimeo video-ID',
                    'name' => 'split_vimeo_id',
                    'type' => 'text',
                    'instructions' => 'Optioneel. Als ingevuld wordt de video getoond in plaats van de afbeelding.',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_mk_hero_layout',
                                'operator' => '==',
                                'value' => 'split',
                            ),
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'mk/hero',
                    ),
                ),
            ),
            'active' => true,
        ));
    });
?>
