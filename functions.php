<?php

$includes = array(
    'inc/general.php',
    'inc/ajax-functions.php',
    'inc/acf-blocks.php',
);

foreach ($includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'roots'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);



/*

function register_my_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
            'header-menu-2' => __( 'Header Menu 02' ),
            'footer-menu' => __( 'Footer Menu 01' ),
            'footer-menu-2' => __( 'Footer Menu 02' ),
        )
    );
}
add_action( 'init', 'register_my_menus' );

*/


function generateButton($text, $link, $customClasses = '', $target = '_self', $ariaLabel = '') {
    $class = 'button ' . $customClasses;
    $targetAttr = $target ? 'target="' . $target . '"' : '';
    $ariaLabelAttr = $ariaLabel ? 'aria-label="' . $ariaLabel . '"' : '';    
    return '<a href="' . $link . '" class="' . $class . '" ' . $targetAttr . ' role="button" ' . $ariaLabelAttr . '>' . $text . '</a>';
}


function generateLink($link) {
    $target = $link['target'] ? 'target="' . $link['target'] . '"' : '';
    $title = $link['title'] ? $link['title'] : '';
    $classes = $link['classes'] ? $link['classes'] : '';
    $ariaLabel = $link['aria-label'] ? 'aria-label="' . $link['aria-label'] . '"' : 'aria-label="' . $title . '"';
    
    return '<a href="' . $link['url'] . '" class="' . $classes . '" ' . $target . ' ' . $ariaLabel . '>' . svg('arrow-right--primary', ['alt' => 'Arrow right'], false) . '<span>' . $title . '</span></a>';
}


function svg($filename, $attributes = array(), $inline = false) {
    $svg_path = get_template_directory() . '/dist/assets/images/icons/' . $filename . '.svg';
    if (file_exists($svg_path)) {
        ob_start(); // Start output buffering
        readfile($svg_path); // Read the file and write to output buffer
        $svg = ob_get_clean(); // Get output buffer contents and clean buffer

        if ($inline) {
            $dom = new DOMDocument();
            $dom->loadXML($svg);
            $root = $dom->documentElement;
            foreach ($attributes as $key => $value) {
                $root->setAttribute($key, $value);
            }
            return $dom->saveXML($root);
        } else {
            $img_attributes = '';
            foreach ($attributes as $key => $value) {
                $img_attributes .= $key . '="' . $value . '" ';
            }
            return '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" ' . $img_attributes . '>';
        }
    } else {
        return 'Error: Could not read ' . $svg_path;
    }
}

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Global Settings',
        'menu_title'    => 'Global Settings',
        'menu_slug'     => 'global-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}


// Modify the main image URL
function modify_image_src($image, $attachment_id, $size, $icon) {
    // Check if the MIME type is an image type we want to change
    $mime_type = get_post_mime_type($attachment_id);

    if ($mime_type == 'image/jpeg' || $mime_type == 'image/png') {
        // Convert URL to server path
        $upload_dir = wp_get_upload_dir();
        $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image[0]);

        // Check if .webp file exists
        if (file_exists($image_path . '.webp')) {
            $image[0] .= '.webp';
        }
    }

    return $image;
}


// Modify the srcset
function modify_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    $mime_type = get_post_mime_type($attachment_id);

    if ($mime_type == 'image/jpeg' || $mime_type == 'image/png') {
        $upload_dir = wp_get_upload_dir();

        foreach ($sources as $key => $source) {
            $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $source['url']);

            if (file_exists($image_path . '.webp')) {
                $sources[$key]['url'] .= '.webp';
            }
        }
    }

    return $sources;
}

// Modify the image attributes to add lazy loading
function add_lazy_loading($attr, $attachment, $size) {
    $attr['loading'] = 'lazy';
    return $attr;
}


add_filter('wp_get_attachment_image_attributes', 'add_lazy_loading', 10, 3);
add_filter('wp_get_attachment_image_src', 'modify_image_src', 10, 4);
add_filter('wp_calculate_image_srcset', 'modify_image_srcset', 10, 5);



function custom_excerpt($excerpt, $length = 10) {
    $words = explode(' ', $excerpt);
    if (count($words) > $length) {
        $last_word = $words[$length - 1];
        if (substr($last_word, -1) === ',') {
            $words[$length - 1] = substr($last_word, 0, -1);
        }
        return implode(' ', array_slice($words, 0, $length)) . '...';
    } else {
        return $excerpt;
    }
}



function hide_posts_menu() {
    remove_menu_page('edit.php');
}

// add_action('admin_menu', 'hide_posts_menu');


function disable_comments_support() {
    // Post types for which comments should be disabled
    $post_types = get_post_types();
    
    // Loop through each post type and disable support for comments and trackbacks
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}

// Hook the function to the 'init' action
add_action('init', 'disable_comments_support');

// Optional: Remove comments from the admin menu
function remove_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}

add_action('admin_menu', 'remove_comments_admin_menu');


