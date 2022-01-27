<?php

    // Exit if accessed directly
    if (!defined('ABSPATH')) exit;

    // define('WP_DEBUG', true);
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');


    // Create theme instance and call the theme class to initialize globally.
    include_once get_template_directory() . '/vendor/autoload.php';

    $template = \BvdB\Templates\Autoloader::get_instance();
    $utilities = \BvdB\Utilities\Autoloader::get_instance();
    $gutenberg = \BvdB\Gutenberg\Autoloader::get_instance();

    // Set ACF save path
    $utilities->acf->settings->set_save_load_paths( get_template_directory() . '/acf/' );

    // Register an optionspage
    $utilities->acf->optionspage->register(array(
        'page_title' => 'Site opties',
        'menu_title' => 'Site opties',
        'position' => 3
    ));

    // Register Nav menu
    $utilities->navigation->register( 'mainmenu', 'Hoofd navigatie' );

    // Add themesupport
    $utilities->themesupport->add('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
    $utilities->themesupport->add('post-thumbnails');
    $utilities->themesupport->add('title-tag');
    $utilities->themesupport->add('widgets', array());

    // Add theme support for Gutenberg
	$utilities->themesupport->add('editor-styles');
    $utilities->themesupport->add('align-wide');
    $utilities->themesupport->add('align-full');


    // Add colors to color palette
    // $utilities->themesupport->add('editor-color-palette', array(
    // 	array(
    // 		'name' => 'Blauw',
    // 		'slug' => 'blue',
    // 		'color' => '#59bacc',
    // 	),
    // ));

    // Register new image size (ID, name, width, height, crop, show in admin)
    $utilities->images->add_image_size('bigthumb', 'Big thumbnail', 500, 500, true, true);

    // Change size of thumbnail
    $utilities->images->update_image_size('thumbnail', array(
        'size_w' => 300,
        'size_h' => 300
    ));

    // Register custom post type
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
    add_action('after_setup_theme', function() use ($utilities, $gutenberg) {

        // Setup the scripts to enqueue
        $scripts = $utilities->assets->get_hashed_files_in_dir( get_template_directory() . '/dist/js', '*.js' );
        $utilities->assets->register_multiple( 'script', $scripts, array('jquery'), true );

        // Setup the styles to enqueue
        $styles = $utilities->assets->get_hashed_files_in_dir( get_template_directory() . '/dist/css', '*.css' );
        $utilities->assets->register_multiple( 'style', $styles );

        // Add ajaxurl als default param to scripts
        $utilities->assets->localize('scripts', 'theme', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

		// Editor styles
		$cssFilePath = glob( get_template_directory() . '/dist/css/styles.*' );
		$cssFileURIEditor = '/dist/css/' . basename($cssFilePath[0]);
		add_editor_style( $cssFileURIEditor );

        // Enqueue all assets (keep at end of file)
        $utilities->assets->load();
        
        // Include the blocks
        $blocks_loaded = $gutenberg->blocks->include_blocks();

    }, 1);

    

    // =================================================================================
    // Add WooCommerce support
    $utilities->themesupport->add('woocommerce', array());

    // Temp fix for WooCommerce
    add_filter( 'woocommerce_sort_countries', '__return_false' );

    // Remove WooCommerce template loader
    add_action('wp', function() {
        remove_filter('template_include', 'WC_Template_Loader::template_loader' );
    });
    // =================================================================================

	// Removes core block support
	remove_theme_support('core-block-patterns');
	