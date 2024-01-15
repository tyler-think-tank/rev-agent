<?php

// Automatically allow all ACF blocks
function my_allowed_block_types($allowed_blocks, $post) {

    $acf_blocks = array();
    $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

    // Loop through registered blocks to find ACF blocks
    foreach ($registered_blocks as $name => $block) {
        if (strpos($name, 'acf/') === 0) {
            $acf_blocks[] = $name;
        }
    }

    // If you are targeting a specific post type, uncomment the following lines
    // if ($post->post_type === 'your_post_type') {
    //     return $acf_blocks;
    // }

    return $acf_blocks;
}

add_filter('allowed_block_types', 'my_allowed_block_types', 10, 2);



function custom_scripts() {

    if(!is_admin()) {
        // Enqueue custom styles
        wp_enqueue_style( 'custom-styles', get_stylesheet_directory_uri() . '/dist/assets/css/global.css', array(), '1.0.0', 'all' );
        wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.0', 'all' );
        // Enqueue custom scripts
        wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/dist/assets/js/global.js', array( 'jquery' ), '1.0.0', true );
    }

    else {
        wp_enqueue_style( 'custom-styles-admin', get_stylesheet_directory_uri() . '/dist/assets/css/global-backend.css', array(), '1.0.0', 'all' );
    }


    wp_localize_script('main', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')));

}

add_action( 'wp_enqueue_scripts', 'custom_scripts' );
add_action( 'enqueue_block_editor_assets', 'custom_scripts' );


function remove_default_block_styles() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
}
add_action( 'wp_enqueue_scripts', 'remove_default_block_styles', 100 );
add_action( 'admin_enqueue_scripts', 'remove_default_block_styles', 100 );


add_filter('show_admin_bar', '__return_false');


  // localise script ajaxurl variable WP Rest API endpoint
function custom_ajaxurl() {
    echo '<script type="text/javascript">
        var ajaxurl = "' . admin_url('admin-ajax.php') . '";
    </script>';
}

add_action('wp_head', 'custom_ajaxurl');



function get_post_type_singular_name() {
    $post_type = get_post_type_object(get_post_type());
    return isset($post_type->labels->singular_name) ? $post_type->labels->singular_name : '';
}