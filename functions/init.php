<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


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
$theme->support->add('widgets', array());

// Add theme support for Gutenberg
$theme->support->add('align-wide');
$theme->support->add('align-full');
// $theme->support->add('editor-color-palette', array(
// 	array(
// 		'name' => 'Blauw',
// 		'slug' => 'blue',
// 		'color' => '#59bacc',
// 	),
// ));

// Register image size
// If you want to use these sizes to be used in Wordpress default wp_get_attachment_image sizes
// you can't add 'true'. 
// See https://wordpress.stackexchange.com/questions/241905/how-can-i-set-image-sizes-and-still-have-responsive-images-using-the-srcset-attr
$theme->support->imageSize('bigthumb', 500, 500);


// Register widgets and navigation
$theme->objects->widget->register('Filters', 'filters');
$theme->objects->navigation->register('mainmenu', 'Hoofdnavigatie');
$theme->objects->navigation->register('footer', 'Footer');
$theme->objects->navigation->register('subfooter', 'Subfooter');

// Set ACF to save and load local JSON files
$theme->acf->settings->saveJSON(get_stylesheet_directory() . '/functions/acf/');
$theme->acf->settings->loadJSON();

// Register option pages
$theme->acf->optionspage->register('Site opties', 'Site opties', 'general-site-opties', '', 2, 'dashicons-editor-table');

// Load assets
add_action('after_setup_theme', function () use ($theme, $gutenberg) {

	// Enqueue scripts
	$jsFilePath = glob( get_template_directory() . '/dist/js/scripts.*.js' );
	$jsFileURI = get_template_directory_uri() . '/dist/js/' . basename($jsFilePath[0]);
	$theme->assets->register('script', 'scripts', $jsFileURI , array('jquery'), true);
	
	// Enqueue styles
	$cssFilePath = glob( get_template_directory() . '/dist/css/styles.*' );
	$cssFileURI = get_template_directory_uri() . '/dist/css/' . basename($cssFilePath[0]);
	$theme->assets->register('style', 'global', $cssFileURI, array(), false);

	// Localize scripts
	$theme->assets->localize('scripts', 'theme', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));

	// Enqueue all assets (keep at end of file)
	$theme->assets->load();

	// Enqueue editor styles for Gutenberg
	// See Gutenberg.php and set content to 'add_editor_style();'
	$cssFileURIEditor = '/dist/css/' . basename($cssFilePath[0]);
	$gutenberg->addEditorStyles($cssFileURIEditor);
	
	// Load the Gutenberg ACF-files
	$gutenberg->loadBlockJSON();

	// Set the allowed blocks
	$gutenberg->setAllowedBlock('gravityforms/form');

	// Or use an array:
	$gutenberg->setAllowedBlocks(
		array(
			// 'acf/example-block',

			// Gravity forms
			'gravityforms/form',

			// Core Blocks
			'core/buttons',
			'core/button',
			'core/cover',
			'core/code',
			'core/embed',
			'core/file',
			'core/group',
			'core/heading',
			'core/image',
			'core/latest-posts',
			'core/list',
			'core/media-text',
			'core/paragraph',
			'core/pullquote',
			'core/query',
			'core/query-title',
			'core/quote',
			'core/separator',
			'core/spacer',
			'core/video'

		)
	);

	// Load all Gutenberg blocks

	$gutenberg->includeBlocks();
}, 1);


	


