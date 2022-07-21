<?php

	// Exit if accessed directly
	if (!defined('ABSPATH')) exit;

<<<<<<< HEAD
	/**
	 * Add functions to twig-allowlist
	 */
	add_filter('bvdb_allowed_twig_functions', function ($functions) {

		$allowed_functions = array(
			// Add array of allowed functions
		);

		// Return the array of current functions and add extra allowed functions
		return array_merge($functions, $allowed_functions);
	});
=======
add_filter('bvdb_allowed_twig_functions', function ($functions) {
	$functions[] = 'wp_get_attachment_image_url';
	$functions[] = 'wp_get_attachment_metadata';
	$functions[] = 'wp_get_attachment_caption';
	$functions[] = 'get_the_title';
	$functions[] = 'get_post_meta';
	return $functions;
});
>>>>>>> feature/media-blocks
