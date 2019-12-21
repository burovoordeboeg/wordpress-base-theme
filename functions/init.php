<?php

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;


    // Create theme instance and call the theme class to initialize globally.
	include_once get_template_directory() . '/vendor/autoload.php';
	use BvdB\Theme as Theme;

	// Use theme
	$theme = Theme::getInstance();

	// Add theme support
	$theme->support->add('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
	$theme->support->add('post-thumbnails');
	$theme->support->add('title-tag');
	$theme->support->add('widgets', array(  ));

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

	// Enqueue scripts and styles
	$theme->assets->register('script', 'jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), false);
	$theme->assets->register('script', 'plugins', get_template_directory_uri() . '/dist/js/plugins.js', array('jquery'), true);
	$theme->assets->register('script', 'scripts', get_template_directory_uri() . '/dist/js/scripts.js', array('jquery'), true);
	// $theme->assets->register('style', 'fonts', '', array(), false);
	$theme->assets->register('style', 'global', get_template_directory_uri() . '/dist/css/styles.css', array(), false);

	// Enqueue all assets (keep at end of file)
    $theme->assets->load(); 
    
