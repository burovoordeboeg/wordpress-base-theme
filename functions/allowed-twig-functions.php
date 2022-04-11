<?php

    // Exit if accessed directly
    if (!defined('ABSPATH')) exit;

	add_filter( 'bvdb_allowed_twig_functions', function ($functions) {
		return array_merge( $functions, array(
			'wp_get_attachment_image_src',
			'wp_get_attachment_image'
		) );
	} );