<?php

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;


    // Create theme instance and call the theme class to initialize globally.
	include_once get_template_directory() . '/vendor/autoload.php';
	include_once get_template_directory() . '/classes/Gutenberg/Gutenberg.php';

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

	$theme->support->add('align-wide');
	$theme->support->add('align-full');


	// Register image size
	$theme->support->imageSize('bigthumb', 500, 500, true);

	// Register widgets and navigation
	$theme->objects->widget->register('Filters', 'filters');
	$theme->objects->navigation->register('mainmenu', 'Hoofdnavigatie');
	$theme->objects->navigation->register('footer', 'Footer');
	$theme->objects->navigation->register('subfooter', 'Subfooter');

	// Set ACF to save and load local JSON files
	$theme->acf->settings->save_local_json();
	$theme->acf->settings->load_local_json();

	// Register option pages
	$theme->acf->optionspage->register( 'Site opties', 'Site opties', 'general-site-opties', '', 2, 'dashicons-editor-table' );
	
	
	// Register theme colors for use in Gutenberg
	$gutenberg->registerColors(array(
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

	// Register the gutenberg blocks
	$gutenberg->registerBlock( array(
		'name' => 'custom-block',
		'title' => 'Header Image Block',
		'description' => 'A different image block.',
		'category' => 'formatting',
		'icon' => 'admin-comments',
		'keywords' => array( 'image', 'text' ),
		'post_types' => array( 'post', 'page' ),
		'mode' => 'preview',
		'align' => array( 'wide', 'full', 'center' ),
		'multiple' => false,
	), array(
		'frontend' => array(
			'style' => 'front-end.css',
			'script' => 'scripts.js'
		),
		'admin' => array(
			'style' => 'back-end.css',
		)
	) );

	$gutenberg->registerBlock( array(
		'name' => 'content-image',
		'title' => 'Content and image block',
		'description' => 'A block with a content section and an image left or right',
		'category' => 'formatting',
		'icon' => '<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300.64 235.26"><rect x="2.5" y="2.5" width="72.29" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="2.5" y="29.09" width="127.43" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="2.5" y="55.68" width="108.75" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="2.5" y="84.66" width="96.76" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="2.5" y="137.57" width="125.55" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="2.5" y="166.82" width="108.75" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="2.5" y="196.07" width="125.55" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="2.5" y="222.92" width="108.75" height="9.84" style="fill:#1d1d1b;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:5px"/><rect x="178.02" y="13.5" width="119.62" height="206.15" style="fill:none;stroke:#1d1d1b;stroke-miterlimit:10;stroke-width:6px"/><path d="M187,248.65H288.4V144.16l-39.72,78-18.2-30.49s-21.75,33.8-23.4,33.1S187,208.94,187,208.94Z" transform="translate(0.5 -39.17)" style="fill:#1d1d1b"/><circle cx="259.74" cy="71.18" r="17.26" style="fill:#1d1d1b"/></svg>',
		'keywords' => array( 'image', 'text' ),
		'post_types' => array( 'post', 'page' ),
		'mode' => 'preview',
		'align' => array( 'wide', 'full', 'center' ),
		'multiple' => true,
	), array(
		'frontend' => array(
			'style' => 'front-end.css',
			'script' => 'scripts.js'
		),
		'admin' => array(
			'style' => 'back-end.css',
		)
	) );

	// Enqueue scripts and styles
	$theme->assets->register('script', 'jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), false);
	$theme->assets->register('script', 'plugins', get_template_directory_uri() . '/dist/js/plugins.js', array('jquery'), true);
	$theme->assets->register('script', 'scripts', get_template_directory_uri() . '/dist/js/scripts.js', array('jquery'), true);
	$theme->assets->register('style', 'fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap', array(), false );
	$theme->assets->register('style', 'global', get_template_directory_uri() . '/dist/css/styles.css', array(), false);

	// Enqueue all assets (keep at end of file)
	$theme->assets->load(); 
    
