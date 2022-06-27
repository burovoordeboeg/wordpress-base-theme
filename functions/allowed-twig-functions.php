<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

add_filter('bvdb_allowed_twig_functions', function ($functions) {
	$functions[] = 'wp_get_attachment_image_url';
	return $functions;
});