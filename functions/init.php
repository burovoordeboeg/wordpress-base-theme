<?php

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;


    // Create theme instance and call the theme class to initialize globally.
	include_once get_template_directory() . '/vendor/autoload.php';

	use BvdB\Theme as Theme;
	use BvdB\Gutenberg as Gutenberg;

	// Use theme
	$theme = Theme::getInstance();
	$gutenberg = Gutenberg::getInstance();

	// Add theme support
	$theme->support->add('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
	$theme->support->add('post-thumbnails');
	$theme->support->add('title-tag');
	$theme->support->add('widgets', array(  ));

	// Add theme support for Gutenberg
	$theme->support->add('align-wide');
	$theme->support->add('align-full');
	$theme->support->add('editor-color-palette', array(
		array(
			'name' => 'Blauw',
			'slug' => 'blue',
			'color' => '#59bacc',
		),
		array(
			'name' => 'Grijs',
			'slug' => 'gray',
			'color' => '#ccc',
			),
		array(
			'name' => 'Donkergrijs',
			'slug' => 'darkgray',
			'color' => '#333',
		),
	));

	// Register image size
	$theme->support->imageSize('bigthumb', 500, 500, true);

	// Register widgets and navigation
	$theme->objects->widget->register('Filters', 'filters');
	$theme->objects->navigation->register('mainmenu', 'Hoofdnavigatie');
	$theme->objects->navigation->register('footer', 'Footer');
	$theme->objects->navigation->register('subfooter', 'Subfooter');

	// Set ACF to save and load local JSON files
	$theme->acf->settings->saveJSON( get_stylesheet_directory() . '/functions/acf/' );
	$theme->acf->settings->loadJSON();

	// Register option pages
	$theme->acf->optionspage->register( 'Site opties', 'Site opties', 'general-site-opties', '', 2, 'dashicons-editor-table' );

	// Load assets
	add_action('after_setup_theme', function() use ($theme, $gutenberg) {

		// Enqueue scripts
		$theme->assets->register('script', 'jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), false);
		$theme->assets->register('script', 'plugins', get_template_directory_uri() . '/dist/js/plugins.js', array('jquery'), true);
		$theme->assets->register('script', 'scripts', get_template_directory_uri() . '/dist/js/scripts.js', array('jquery'), true);

		// Enqueue styles
		$theme->assets->register('style', 'global', get_template_directory_uri() . '/dist/css/styles.css', array(), false);

		// Localize scripts
		$theme->assets->localize('scripts', 'theme', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		));
		
		// Enqueue all assets (keep at end of file)
		$theme->assets->load(); 


		
		
		// Enqueue editor styles for Gutenberg
		$gutenberg->enqueueEditorStyles(array(
			'editor-styles' => get_template_directory_uri() . '/dist/css/editor-styles.css',
			// 'editor-fonts' => ''
		));

		// Load the Gutenberg ACF-files
		$gutenberg->loadBlockJSON();

		// Set the allowed blocks
		$gutenberg->setAllowedBlock('gravityforms/form');

		// Or use an array:
		// $gutenberg->setAllowedBlocks(
		// 	array(
    //     'acf/example-block',

    //     // Gravity forms
		// 		'gravityforms/form'
		// 	)
		// );
	
		// Load all Gutenberg blocks
		$gutenberg->includeBlocks();

	}, 1);
