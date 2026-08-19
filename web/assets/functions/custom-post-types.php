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
     * Custom Post Type: Medewerkers
     * Geen publieke front-end (geen single/archive) — puur databron voor het mk/team block.
     */
    function mk_cpt_medewerkers() {
        register_post_type('medewerker', [
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'has_archive' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'rewrite' => false,
            'labels' => [
                'name' => 'Medewerkers',
                'singular_name' => 'Medewerker',
                'add_new' => 'Nieuwe medewerker',
                'add_new_item' => 'Nieuwe medewerker toevoegen',
                'edit_item' => 'Medewerker bewerken',
                'new_item' => 'Nieuwe medewerker',
                'view_item' => 'Medewerker bekijken',
                'search_items' => 'Medewerkers zoeken',
                'not_found' => 'Geen medewerkers gevonden',
                'not_found_in_trash' => 'Geen medewerkers gevonden in prullenbak',
                'all_items' => 'Alle medewerkers',
                'menu_name' => 'Medewerkers',
            ],
            'supports' => ['title', 'thumbnail', 'page-attributes'],
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-groups',
            'menu_position' => 21,
        ]);
    }
    add_action('init', 'mk_cpt_medewerkers');

    /**
     * Custom Post Type: Vacatures
     */
    function mk_cpt_vacatures() {
        register_post_type('vacature', [
            'public' => true,
            'has_archive' => false,
            'rewrite' => ['slug' => 'vacatures', 'with_front' => false],
            'labels' => [
                'name' => 'Vacatures',
                'singular_name' => 'Vacature',
                'add_new' => 'Nieuwe vacature',
                'add_new_item' => 'Nieuwe vacature toevoegen',
                'edit_item' => 'Vacature bewerken',
                'new_item' => 'Nieuwe vacature',
                'view_item' => 'Vacature bekijken',
                'search_items' => 'Vacatures zoeken',
                'not_found' => 'Geen vacatures gevonden',
                'not_found_in_trash' => 'Geen vacatures gevonden in prullenbak',
                'all_items' => 'Alle vacatures',
                'menu_name' => 'Vacatures',
            ],
            'supports' => ['title', 'thumbnail'],
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-businessman',
            'menu_position' => 22,
        ]);
    }
    add_action('init', 'mk_cpt_vacatures');

    /**
     * Custom Post Type: Reviews
     * Geen publieke front-end (geen single/archive) — puur databron voor het mk/reviews block.
     */
    function mk_cpt_reviews() {
        register_post_type('review', [
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'has_archive' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'rewrite' => false,
            'labels' => [
                'name' => 'Reviews',
                'singular_name' => 'Review',
                'add_new' => 'Nieuwe review',
                'add_new_item' => 'Nieuwe review toevoegen',
                'edit_item' => 'Review bewerken',
                'new_item' => 'Nieuwe review',
                'view_item' => 'Review bekijken',
                'search_items' => 'Reviews zoeken',
                'not_found' => 'Geen reviews gevonden',
                'not_found_in_trash' => 'Geen reviews gevonden in prullenbak',
                'all_items' => 'Alle reviews',
                'menu_name' => 'Reviews',
            ],
            'supports' => ['title', 'page-attributes'],
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-format-quote',
            'menu_position' => 23,
        ]);
    }
    add_action('init', 'mk_cpt_reviews');

    /**
     * Eenmalige permalink-flush na registratie van de Diensten CPT.
     * Geen bestaand flush-mechanisme in dit project — versie-gate voorkomt
     * dat dit bij elke pageload gebeurt.
     */
    add_action('init', function() {
        if (get_option('mk_diensten_cpt_flushed') !== '5') {
            flush_rewrite_rules();
            update_option('mk_diensten_cpt_flushed', '5');
        }
    }, 20);
?>
