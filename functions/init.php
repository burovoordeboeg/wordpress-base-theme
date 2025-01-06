<?php

	if (!defined('ABSPATH')) exit;

	include_once get_template_directory() . '/vendor/autoload.php';

	// Initialize instances
	$template = \BvdB\Templates\Autoloader::get_instance();
	$utilities = \BvdB\Utilities\Autoloader::get_instance();
	$gutenberg = \BvdB\Gutenberg\Blocks::get_instance();

	// ACF and Gutenberg Setup
	$acf_focuspoint = new \BvdB\ACF\FocusPoint();
	$utilities->acf->settings->set_save_load_paths(get_template_directory() . '/acf/');
	$utilities->acf->optionspage->register(array(
		'page_title' => 'Site opties', 
		'menu_title' => 'Site opties', 
		'position' => 3
	));

	$gutenberg->add_block_directory(get_template_directory() . '/templates/blocks');
	$gutenberg->save_acf_in_block_folder();
	$gutenberg->add_acf_blocks_load_path();

	// Theme support and navigation
	$utilities->navigation->register('mainmenu', 'Hoofd navigatie');
	$utilities->themesupport->add('html5', array('search-form', 'gallery', 'caption'));
	$utilities->themesupport->add('post-thumbnails');
	$utilities->themesupport->add('title-tag');
	$utilities->themesupport->add('widgets', array());
	$utilities->themesupport->add('editor-styles');
	$utilities->themesupport->remove('core-block-patterns');

	// Image sizes
	$utilities->images->add_image_size('bigthumb', 'Big thumbnail', 500, 500, true, true);
	$utilities->images->update_image_size('thumbnail', array(
		'size_w' => 300, 
		'size_h' => 300
	));


	/**
	 * Autoload all theme files such as scripts/styles needed for the theme
	 * @see https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 */
	add_action('after_setup_theme', function () use ($utilities) {

		// Setup assets loader
		$assets = $utilities->assets;

		// Set Hot Module Replacement server URL (default is http://localhost:3002)
		$hmr_server_url = 'http://localhost:3002';

		// Check if HMR is enabled
		if (wp_remote_get("$hmr_server_url/@vite/client")) 
		{
			$assets->enable_hmr($hmr_server_url);
		} 
		else 
		{
			// Use the default manifest
			$assets->set_manifest_location('/build/.vite/manifest.json');
	
			// Register scripts and styles
			$assets->register('theme', 'script', 'main', $assets->get_file_from_manifest('scripts/main.js'), array(), true);
			$assets->register('theme', 'style', 'styles', $assets->get_file_from_manifest('styles/styles.css'), array(), true);
	
			// Enqueue all assets
			$assets->load_theme_assets();
		}

	}, 1);


	

	/**
	 * Add Vite development hook for live reload.
	 */
	// function bvd_vite_dev_hook()
	// {
	// 	echo '<script type="module" crossorigin src="http://localhost:3002/@vite/client"></script>';
	// 	echo '<script type="module" crossorigin src="http://localhost:3002/assets/scripts/main.js"></script>';
	// }

	// /**
	//  * Enqueue assets for frontend and backend.
	//  */
	// function bvd_enqueue_assets()
	// {
	// 	$vite_env = defined('WP_ENV') ? WP_ENV : 'production'; // Use WP_ENV or default to production
	// 	$dist_uri = get_template_directory_uri() . '/build';
	// 	$manifest = bvd_load_manifest();

	// 	if (is_array($manifest)) {
	// 		$js_file = 'assets/scripts/main.js';

	// 		if ($vite_env === 'production') {
	// 			wp_enqueue_style('main', $dist_uri . '/' . $manifest[$js_file]['css'][0]);
	// 			wp_enqueue_script('main', $dist_uri . '/' . $manifest[$js_file]['file'], [], null, true);
	// 		}

	// 		if ($vite_env === 'development') {
	// 			// Add hooks for development live reload
	// 			add_action('wp_head', 'bvd_vite_dev_hook');
	// 			add_action('admin_head', 'bvd_vite_dev_hook'); // Explicitly add to admin
	// 		}
	// 	}
	// }

	// add_action('wp_enqueue_scripts', 'bvd_enqueue_assets');
	// add_action('admin_enqueue_scripts', 'bvd_enqueue_assets'); // Enqueue for backend as well


	/**
	 * Initialize Gutenberg blocks.
	 */
	add_action('init', function () use ($gutenberg) {
		$gutenberg->add_block_category('Lay-out', 'layout');
		$gutenberg->add_block_category('Streamers', 'streamers');
		$gutenberg->add_block_category('Projecten', 'projecten');
		$gutenberg->add_block_category('Overig', 'misc');
		$gutenberg->set_allowed_default_blocks(['gravityforms/form']);
		$gutenberg->load_blocks();
	});
