<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Create theme instance and call the theme class to initialize globally.
include_once get_template_directory() . '/vendor/autoload.php';


// Load template classes
$template = \BvdB\Templates\Autoloader::get_instance();
$utilities = \BvdB\Utilities\Autoloader::get_instance();
$gutenberg = \BvdB\Gutenberg\Blocks::get_instance();

// Load ACF focuspoint field
$acf_focuspoint = new \BvdB\ACF\FocusPoint();

// Set ACF save path
$utilities->acf->settings->set_save_load_paths(get_template_directory() . '/acf/');

// Add block directory
$gutenberg->add_block_directory(get_template_directory() . '/templates/blocks');

// Set option to save ACF in block folder
$gutenberg->save_acf_in_block_folder();

// Add gutenberg blocks as load path
$gutenberg->add_acf_blocks_load_path();

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
 * Initialize the Gutenberg blocks
 * @see https://developer.wordpress.org/reference/hooks/init/
 */
add_action('init', function () use ($gutenberg) {

	// Add block category
	$gutenberg->add_block_category('Lay-out', 'layout');
	$gutenberg->add_block_category('Streamers', 'streamers');
	$gutenberg->add_block_category('Projecten', 'projecten');
	$gutenberg->add_block_category('Overig', 'misc');

	// Set allowed default_blocks
	$gutenberg->set_allowed_default_blocks(array(
		'gravityforms/form',
	));

	// Load all blocks
	$gutenberg->load_blocks();
});


add_action('wp_enqueue_scripts', function () { {

		if (file_exists(get_template_directory() . '/config.json')) {
			$config   = json_decode(file_get_contents(get_template_directory() . '/config.json'), true);
			$vite_env = $config['vite']['environment'] ?? 'production';
		}

		$dist_uri  = get_template_directory_uri() . '/dist';
		$dist_path = get_template_directory() . '/dist';
		$manifest  = null;

		if (file_exists($dist_path . '/.vite/manifest.json')) {
			$manifest = json_decode(file_get_contents($dist_path . '/.vite/manifest.json'), true);
		}

		if (is_array($manifest)) {
			echo '<script>console.log("Manifest loaded")</script>';
			if ($vite_env === 'production' || is_admin()) {
				$js_file = 'assets/scripts/main.js';
				wp_enqueue_style('main', $dist_uri . '/' . $manifest[$js_file]['css'][0]);
				wp_enqueue_script(
					'main',
					$dist_uri . '/' . $manifest[$js_file]['file'],
					array(),
					'',
					array(
						'strategy'  => 'async',
						'in_footer' => false,
					)
				);
			}
		}

		if ($vite_env === 'development') {
			function vite_head_module_hook()
			{
				echo '<script type="module" crossorigin src="http://localhost:3002/@vite/client"></script>';
				echo '<script type="module" crossorigin src="http://localhost:3002/assets/scripts/main.js"></script>';
			}
			add_action('wp_head', 'vite_head_module_hook');
		}
	}
});

add_action('enqueue_block_editor_assets', function () {
	$dist_uri = get_template_directory_uri() . '/dist';
	$dist_path = get_template_directory() . '/dist';

	if (file_exists($dist_path . '/.vite/manifest.json')) {
		$manifest = json_decode(file_get_contents($dist_path . '/.vite/manifest.json'), true);
		$js_file = 'assets/scripts/main.js';

		if (isset($manifest[$js_file]['css'][0])) {
			wp_enqueue_style(
				'editor-style',
				$dist_uri . '/' . $manifest[$js_file]['css'][0],
				array(),
				null
			);
		}
	}
});
