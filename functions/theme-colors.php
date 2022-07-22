<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

	/**
	 * Register the theme colors for the color palette
	 */
	$utilities->themesupport->add('editor-color-palette', array(
		array(
			'name' => 'Wit',
			'slug' => 'white',
			'color' => '#fff',
		),
		array(
			'name' => 'Geel',
			'slug' => 'yellow',
			'color' => '#D3A403',
		),
		array(
			'name' => 'Licht blauw',
			'slug' => 'brightblue',
			'color' => '#009FE3',
		),
		array(
			'name' => 'Medium blauw',
			'slug' => 'medium_blue',
			'color' => '#004B8C',
		),
		array(
			'name' => 'Donker blauw',
			'slug' => 'dark_blue',
			'color' => '#002341',
		),
		array(
			'name' => 'Donker grijs',
			'slug' => 'dark_gray',
			'color' => '#374151',
		),  
	));