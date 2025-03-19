<?php

	if (!defined('ABSPATH')) exit;

	include_once get_template_directory() . '/vendor/autoload.php';

	// Initialize instances
	$template = \BvdB\Templates\Autoloader::get_instance();
	$utilities = \BvdB\Utilities\Autoloader::get_instance();
	$gutenberg = \BvdB\Gutenberg\Blocks::get_instance();

	// ACF and Gutenberg Setup
	$acf_focuspoint = new \BvdB\ACF\FocusPoint();

	// Set Save and Load path for ACF
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


	// HMR server URL
	$hmr_server_url = 'http://localhost:3003';

	// Only use HMR on development environment
	$hmr_enabled = (defined('WP_ENV') && WP_ENV == 'development');

	// Setup assets loader
	$assets = $utilities->assets;
	
	// Location of manifest file
	$assets->set_manifest_location('/build/.vite/manifest.json');

	/**
	 * Autoload all theme files such as scripts/styles needed for the theme
	 * @see https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 */
	add_action('after_setup_theme', function () use ($assets, $hmr_enabled, $hmr_server_url) {
		
		if ($hmr_enabled && !is_wp_error($hmr_enabled)) 
		{
			// When in development mode
			$assets->enable_hmr($hmr_server_url);
			$assets->register('theme', 'script', 'main', $hmr_server_url . '/assets/scripts/main.js', [], ['in_footer' => true], true);
		}
		else
		{
			// When not in development mode
			$assets->register('theme', 'script', 'main', $assets->get_file_from_manifest('scripts/main.js'), [], true);
			$assets->register('theme', 'style', 'styles', $assets->get_file_from_manifest('styles/styles.css'), [], true);
		}

		$assets->register('theme', 'style', 'google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

		// Localize scripts
		$assets->localize('main', 'theme', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('ajax-nonce')
		));

		// Load assets
		$assets->load_theme_assets();

	}, 1);

	/**
	 * Load admin scripts and styles
	 */
	add_action('wp_enqueue_editor', function () use ($assets) 
	{
		// Load editor assets
		$assets->register('editor', 'script', 'bvdb-editor', $assets->get_file_from_manifest('scripts/editor.js'), [], true);
		$assets->register('editor', 'style', 'bvdb-styles', $assets->get_file_from_manifest('styles/editor-styles.css'), [], true);

		// Load assets
		$assets->load_editor_assets();
	}, 1);


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