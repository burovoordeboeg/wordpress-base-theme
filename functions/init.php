<?php

    // Exit if accessed directly
    if (!defined('ABSPATH')) exit;

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
	
	// Remove theme support
	remove_theme_support('core-block-patterns');

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
    add_action('after_setup_theme', function() use ($utilities, $gutenberg) {
		
		// Set the mix manifest location
		$utilities->assets->set_manifest_location( '/build/mix-manifest.json' );

        // Setup the scripts to enqueue
		$utilities->assets->register('theme', 'script', 'jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), true);
		$utilities->assets->register('theme', 'script', 'scripts', $utilities->assets->get_file_from_manifest( 'scripts/scripts.js' ), array(), false);

		// Setup styles to enqueue
		$utilities->assets->register('theme', 'style', 'fonts', '//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap', array(), true);
		$utilities->assets->register('theme', 'style', 'styles', $utilities->assets->get_file_from_manifest( 'styles/styles.css' ), array(), true);

        // Add ajaxurl als default param to scripts
        $utilities->assets->localize('scripts', 'theme', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

		// Editor styles		
		$utilities->assets->add_editor_style('/build/styles/editor-styles.css');
		
        // Enqueue all assets
        $utilities->assets->load_theme_assets();

		// Setup editor assets to enqueue
		$utilities->assets->register('editor', 'style', 'open-sans', '//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap' );
		$utilities->assets->register('editor', 'script', 'bvdb-scripts', $utilities->assets->get_file_from_manifest( 'scripts/scripts.js' ) );
		$utilities->assets->register('editor', 'script', 'bvdb-editor-scripts', $utilities->assets->get_file_from_manifest( 'scripts/editor.js' ), array('wp-blocks','wp-dom-ready', 'wp-edit-post') );

		// Load editor assets
		$utilities->assets->load_editor_assets();
        
        // Include the blocks
        $blocks_loaded = $gutenberg->blocks->include_blocks();

		add_filter('allowed_block_types_all', function() use ($blocks_loaded) {
			$allowed_blocks = [
				'core/columns'
			];
	
			foreach ($blocks_loaded as $name => $path) {
				$allowed_blocks[] = 'acf/' . $name;
			}
	
			return $allowed_blocks;
		});

    }, 1);


