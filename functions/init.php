<?php

	// Exit if accessed directly
	if (!defined('ABSPATH')) exit;

	// Create theme instance and call the theme class to initialize globally.
	include_once get_template_directory() . '/vendor/autoload.php';

	$template = \BvdB\Templates\Autoloader::get_instance();
	$utilities = \BvdB\Utilities\Autoloader::get_instance();
	$gutenberg = \BvdB\Gutenberg\Autoloader::get_instance();

	// Set ACF save path
	$utilities->acf->settings->set_save_load_paths(get_template_directory() . '/acf/');

	// Register an optionspage
	$utilities->acf->optionspage->register(array(
		'page_title' => 'Site opties',
		'menu_title' => 'Site opties',
		'position' => 3
	));

	/**
	 * Set the name of the field for which to load ACF color options for
	 * this needs to be a radio button, to be populated correctly
	 * @see https://www.advancedcustomfields.com/resources/acf-load_field/
	 *
	 */
	$utilities->acf->colorpicker->set_colorpicker_fields(array(
		'text_editor_color_picker',
		'bg_editor_color_picker'
	));

	// Register Nav menu
	$utilities->navigation->register('mainmenu', 'Hoofd navigatie');

	// Add themesupport
	$utilities->themesupport->add('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
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

	// Register custom post type
	// @see https://github.com/burovoordeboeg/class-theme-utilities/blob/master/docs/Posttype.md
	$utilities->posttype->register(
		'faq-item',
		'FAQ',
		'FAQ item',
		'faq',
		array('title'),
		12,
		'dashicons-format-chat'
	);

	/**
	 * Autoload all theme files such as scripts/styles and Gutenberg blocks
	 * @see https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 */
	add_action('after_setup_theme', function () use ($utilities, $gutenberg) {

		// Setup assets loader
		$assets = $utilities->assets;

		// Set the mix manifest location
		$assets->set_manifest_location('/build/mix-manifest.json');

		// Setup the scripts to enqueue
		$assets->register('theme', 'script', 'jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), true);
		$assets->register('theme', 'script', 'scripts', $assets->get_file_from_manifest('scripts/scripts.js'), array(), true);

		// Setup styles to enqueue
		$assets->register('theme', 'style', 'fonts', '//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap', array(), true);
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
		$assets->register('editor', 'style', 'open-sans', '//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
		$assets->register('editor', 'script', 'bvdb-scripts', $assets->get_file_from_manifest('scripts/scripts.js'));
		$assets->register('editor', 'script', 'bvdb-editor-scripts', $assets->get_file_from_manifest('scripts/editor.js'), array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'));

		// Load editor assets
		$assets->load_editor_assets();

		// Include the blocks
		$blocks_loaded = $gutenberg->blocks->include_blocks();

		// Specify which blocks not to load
		$ignore_blocks = array(
			'example',
			'button'
		);

		/**
		 * Select which blocks to load
		 */
		add_filter('allowed_block_types_all', function () use ($blocks_loaded, $ignore_blocks) {

			// Default allowed blocks
			$allowed_blocks = array(
				'core/columns'
			);

			// Loop registred blocks
			foreach ($blocks_loaded as $name => $path) {

				// Load when not ignored
				if( !in_array($name, $ignore_blocks) )
				{
					$allowed_blocks[] = 'acf/' . $name;
				}
			}

			// Return all allowed blocks
			return $allowed_blocks;
		});


	}, 1);
