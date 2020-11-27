<?php

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;

    // Get the theme instance from global objects
    $theme = BvdB\Theme::getInstance();

	/**
	 * Register a post type within
	 * --
	 * For settings, see: 
	 * https://developer.wordpress.org/reference/functions/register_post_type/
	 */
	$theme->cpt->posttype->register(
        'faq',						// post-type
        'FAQ',						// name
        'FAQ',          			// singular
        'faq',          			// slug
        array(                      // Supports
            'title'
        ), 
        24,                         // Menu position
        'dashicons-editor-help', 	// Icon
        'post', 					// Capability type (default is post)
        false, 						// Override the default rewrite
        array(						// Override the arguments not mentioned above
            'has_archive' => false
        )
    );