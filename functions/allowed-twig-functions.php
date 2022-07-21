<?php

	// Exit if accessed directly
	if (!defined('ABSPATH')) exit;

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