<?php


  // Register prompt-form-banner
  acf_register_block_type(array(
      'name'              => 'Prompt Form Banner',
      'title'             => __('Prompt Form Banner'),
      'description'       => __('A custom Prompt Form Banner block.'),
      'render_callback'   => function($block, $content = '', $is_preview = false) {
        include(get_theme_file_path('/blocks/banners/prompt-form-banner/prompt-form-banner.php'));
      },
      'enqueue_style'     => get_template_directory_uri() . '/dist/assets/css/banners/prompt-form-banner/prompt-form-banner.css',
      'enqueue_script'    => get_template_directory_uri() . '/dist/assets/js/banners/prompt-form-banner/prompt-form-banner.js',
      'category'          => 'banners',
      'icon'              => 'admin-comments',
      'keywords'          => array( 'prompt', 'form', 'banner' ),
  ));
  
  // Register card-tabs
  acf_register_block_type(array(
      'name'              => 'Card Tabs',
      'title'             => __('Card Tabs'),
      'description'       => __('A custom Card Tabs block.'),
      'render_callback'   => function($block, $content = '', $is_preview = false) {
        include(get_theme_file_path('/blocks/tabs/card-tabs/card-tabs.php'));
      },
      'enqueue_style'     => get_template_directory_uri() . '/dist/assets/css/tabs/card-tabs/card-tabs.css',
      'enqueue_script'    => get_template_directory_uri() . '/dist/assets/js/tabs/card-tabs/card-tabs.js',
      'category'          => 'tabs',
      'icon'              => 'admin-comments',
      'keywords'          => array( 'card', 'tabs' ),
  ));
  
  // Register image-text
  acf_register_block_type(array(
      'name'              => 'Image Text',
      'title'             => __('Image Text'),
      'description'       => __('A custom Image Text block.'),
      'render_callback'   => function($block, $content = '', $is_preview = false) {
        include(get_theme_file_path('/blocks/text/image-text/image-text.php'));
      },
      'enqueue_style'     => get_template_directory_uri() . '/dist/assets/css/text/image-text/image-text.css',
      
      'category'          => 'text',
      'icon'              => 'format-image',
      'keywords'          => array( 'image', 'text' ),
  ));
  
  // Register simple-text
  acf_register_block_type(array(
      'name'              => 'Simple Text',
      'title'             => __('Simple Text'),
      'description'       => __('A custom Simple Text block.'),
      'render_callback'   => function($block, $content = '', $is_preview = false) {
        include(get_theme_file_path('/blocks/text/simple-text/simple-text.php'));
      },
      'enqueue_style'     => get_template_directory_uri() . '/dist/assets/css/text/simple-text/simple-text.css',
      
      'category'          => 'text',
      'icon'              => 'editor-textcolor',
      'keywords'          => array( 'simple', 'text' ),
  ));
  