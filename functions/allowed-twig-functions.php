<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Add functions to twig-allowlist
 */
add_filter('bvdb_allowed_twig_functions', function ($functions) {

	$allowed_functions = array(
		// Add array of allowed functions
		'wp_get_attachment_image_url',
		'wp_get_attachment_metadata',
		'wp_get_attachment_caption',
		'get_the_title',
		'get_post_meta',
		'get_object_by_post_id'
	);

	// Return the array of current functions and add extra allowed functions
	return array_merge($functions, $allowed_functions);
});