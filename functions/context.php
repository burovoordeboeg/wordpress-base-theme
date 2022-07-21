<?php

	// Exit if accessed directly
	if (!defined('ABSPATH')) exit;

	/**
	 * Add defaults to page context
	 */
	add_filter('bvdb_template_context_args', function ($context) {

		// Get instance of utilities
		$utilities = \BvdB\Utilities\Autoloader::get_instance();

		// Add menus to the page context
		$context['navigation'] = $utilities->navigation->get_menus();

		// Return the context of the page
		return $context;
	});