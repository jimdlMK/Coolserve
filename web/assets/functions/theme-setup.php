<?php
    // Extra menu-locatie voor de topbar (Storing melden, Klantenportaal, Downloads)
    add_action('after_setup_theme', function() {
        register_nav_menu('top_menu', 'Topmenu');
    });

    // Editor-only comfort styling (witruimte rond ACF-blokken in Gutenberg)
    add_action('after_setup_theme', function() {
        add_editor_style('assets/css/editor.css');
    });

    // Topmenu aanmaken indien niet aanwezig — alleen in de admin, niet op de frontend
    add_action('admin_init', function() {
        $menus    = wp_get_nav_menus();
        $existing = wp_list_pluck($menus, 'name');

        if (!in_array('Topmenu', $existing)) {
            $id                    = wp_create_nav_menu('Topmenu');
            $locations             = get_theme_mod('nav_menu_locations', []);
            $locations['top_menu'] = $id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    });
?>