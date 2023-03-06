<?php

	// Exit if accessed directly
	if (!defined('ABSPATH')) exit;

	// Create theme instance and call the theme class to initialize globally.
	include_once get_template_directory() . '/vendor/autoload.php';

	$template = \BvdB\Templates\Autoloader::get_instance();
	$utilities = \BvdB\Utilities\Autoloader::get_instance();
	$gutenberg = \BvdB\Gutenberg\Blocks::get_instance();

	// Set ACF save path
	$utilities->acf->settings->set_save_load_paths(get_template_directory() . '/acf/');

	// Register an optionspage
	$utilities->acf->optionspage->register(array(
		'page_title' => 'Site opties',
		'menu_title' => 'Site opties',
		'position' => 3
	));

	// Register Nav menu
	$utilities->navigation->register('mainmenu', 'Hoofd navigatie');

	// Add themesupport
	$utilities->themesupport->add('html5', array('search-form', 'gallery', 'caption'));
	$utilities->themesupport->add('post-thumbnails');
	$utilities->themesupport->add('title-tag');
	$utilities->themesupport->add('widgets', array());

	// Add theme support for Gutenberg
	$utilities->themesupport->add('editor-styles');
	$utilities->themesupport->add('align-wide');
	$utilities->themesupport->add('align-full');

	// Remove theme support
	$utilities->themesupport->remove('core-block-patterns');

	// Register new image size (ID, name, width, height, crop, show in admin)
	// @see https://github.com/burovoordeboeg/class-theme-utilities/blob/master/docs/Images.md
	$utilities->images->add_image_size('bigthumb', 'Big thumbnail', 500, 500, true, true);

	// Change size of thumbnail
	// @see https://github.com/burovoordeboeg/class-theme-utilities/blob/master/docs/Images.md
	$utilities->images->update_image_size('thumbnail', array(
		'size_w' => 300,
		'size_h' => 300
	));

	



	/**
	 * Autoload all theme files such as scripts/styles needed for the theme
	 * @see https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 */
	add_action('after_setup_theme', function () use ( $utilities ) {

		// Setup assets loader
		$assets = $utilities->assets;

		// Set the mix manifest location
		$assets->set_manifest_location('/build/mix-manifest.json');

		// Setup the scripts to enqueue
		$assets->register('theme', 'script', 'scripts', $assets->get_file_from_manifest('scripts/scripts.js'), array(), true);

		// Setup styles to enqueue
		$assets->register('theme', 'style', 'fonts', '', array(), true);
		$assets->register('theme', 'style', 'styles', $assets->get_file_from_manifest('styles/styles.css'), array(), true);

		// Add ajaxurl als default param to scripts
		$assets->localize('scripts', 'theme', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));

		// Editor styles		
		$assets->add_editor_style('/build/styles/editor-styles.css');

		// Enqueue all assets
		$assets->load_theme_assets();

		// Setup editor assets to enqueue
		$assets->register('editor', 'script', 'bvdb-scripts', $assets->get_file_from_manifest('scripts/scripts.js'));
		$assets->register('editor', 'script', 'bvdb-editor-scripts', $assets->get_file_from_manifest('scripts/editor.js'), array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'));

		// Load editor assets
		$assets->load_editor_assets();

	}, 1);



	/**
	 * Initialize the Gutenberg blocks
	 * @see https://developer.wordpress.org/reference/hooks/init/
	 */
	add_action('init', function() use ( $gutenberg ) {

		// Add block category
		$gutenberg->add_block_category('Lay-out', 'layout');
		
		// Set allowed default_blocks
		$gutenberg->set_allowed_default_blocks( array(
			'gravityforms/form',
		) );

		// Load all blocks
		$blocks = $gutenberg->load_blocks();
		
	});