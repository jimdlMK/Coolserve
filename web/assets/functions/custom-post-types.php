<?php
    /**
     * Custom Post Type: Diensten
     */
    function mk_cpt_diensten() {
        register_post_type('dienst', [
            'public' => true,
            'has_archive' => false,
            'rewrite' => ['slug' => 'diensten', 'with_front' => false],
            'labels' => [
                'name' => 'Diensten',
                'singular_name' => 'Dienst',
                'add_new' => 'Nieuwe dienst',
                'add_new_item' => 'Nieuwe dienst toevoegen',
                'edit_item' => 'Dienst bewerken',
                'new_item' => 'Nieuwe dienst',
                'view_item' => 'Dienst bekijken',
                'search_items' => 'Diensten zoeken',
                'not_found' => 'Geen diensten gevonden',
                'not_found_in_trash' => 'Geen diensten gevonden in prullenbak',
                'all_items' => 'Alle diensten',
                'menu_name' => 'Diensten',
            ],
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-admin-tools',
            'menu_position' => 20,
            'template' => [
                ['mk/hero'],
                ['mk/usp'],
                ['mk/voordelen'],
                ['mk/systemen'],
                ['mk/diensten-sectie'],
            ],
            'template_lock' => false,
        ]);
    }
    add_action('init', 'mk_cpt_diensten');

    /**
     * Eenmalige permalink-flush na registratie van de Diensten CPT.
     * Geen bestaand flush-mechanisme in dit project — versie-gate voorkomt
     * dat dit bij elke pageload gebeurt.
     */
    add_action('init', function() {
        if (get_option('mk_diensten_cpt_flushed') !== '2') {
            flush_rewrite_rules();
            update_option('mk_diensten_cpt_flushed', '2');
        }
    }, 20);
?>
