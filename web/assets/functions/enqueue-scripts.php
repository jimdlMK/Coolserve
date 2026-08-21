<?php
    // =============================================================================
    // Enqueue Styles/Scripts in de block-editor
    // =============================================================================
    // De front-end styles/scripts worden geladen via mkbase_enqueue_styles()/
    // mkbase_enqueue_scripts() (parent theme, hook 'wp_enqueue_scripts'), maar die
    // hook draait niet binnen de Gutenberg-editor. Om de ACF-blocks in preview-mode
    // (block.json "mode": "preview") er identiek aan de front-end te laten uitzien,
    // laden we hier dezelfde gecompileerde CSS/JS ook in de editor-context.
    function mk_enqueue_editor_assets() {
        $child_uri = get_stylesheet_directory_uri();
        $child_dir = get_stylesheet_directory();

        wp_enqueue_style('mk-editor-style-main', $child_uri . '/dist/css/style-main.css', [], filemtime($child_dir . '/dist/css/style-main.css'));
        wp_enqueue_script('mk-editor-main-script', $child_uri . '/dist/scripts/scripts.min.js', ['jquery'], filemtime($child_dir . '/dist/scripts/scripts.min.js'), true);
    }
    add_action('enqueue_block_editor_assets', 'mk_enqueue_editor_assets');
?>
