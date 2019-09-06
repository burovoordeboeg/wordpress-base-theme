<?php

	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;

    // Create theme instance and call the theme class to initialize globally.
	include_once get_stylesheet_directory() . '/vendor/autoload.php';
    $theme = \VisualMasters\Theme::getInstance();

    // Get data
    $global_data = getDefaultData();

    // Load header
    $theme->twig->render( 'defaults/head', array(
        'global' => $global_data,
        'wp_head' => $theme->helpers->outputBufferComponent('wp_head'),
    ) );

    
    if (have_posts()) : 
        while (have_posts()) : the_post();

            $theme->twig->render( 'page', array(
                'global' => $global_data,
                'post_title' => get_the_title(),
                'post_content' => apply_filters('the_content', get_the_content())
            ) );

        endwhile; 
    else: 
        
        // Load 404 page template
        

    endif;

    // Load footer
    $theme->twig->render( 'defaults/footer', array(
        'global' => $global_data,
        'wp_footer' => $theme->helpers->outputBufferComponent('wp_footer')
    ) );
