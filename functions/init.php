<?php

if (!defined('ABSPATH')) exit;

include_once get_template_directory() . '/vendor/autoload.php';

// Initialize instances
$template = \BvdB\Templates\Autoloader::get_instance();
$utilities = \BvdB\Utilities\Autoloader::get_instance();
$gutenberg = \BvdB\Gutenberg\Blocks::get_instance();

// ACF and Gutenberg Setup
$acf_focuspoint = new \BvdB\ACF\FocusPoint();
$utilities->acf->settings->set_save_load_paths(get_template_directory() . '/acf/');
$gutenberg->add_block_directory(get_template_directory() . '/templates/blocks');
$gutenberg->save_acf_in_block_folder();
$gutenberg->add_acf_blocks_load_path();
$utilities->acf->optionspage->register(['page_title' => 'Site opties', 'menu_title' => 'Site opties', 'position' => 3]);

// Theme support and navigation
$utilities->navigation->register('mainmenu', 'Hoofd navigatie');
$utilities->themesupport->add('html5', ['search-form', 'gallery', 'caption']);
$utilities->themesupport->add('post-thumbnails');
$utilities->themesupport->add('title-tag');
$utilities->themesupport->add('widgets', []);
$utilities->themesupport->add('editor-styles');
$utilities->themesupport->remove('core-block-patterns');

// Image sizes
$utilities->images->add_image_size('bigthumb', 'Big thumbnail', 500, 500, true, true);
$utilities->images->update_image_size('thumbnail', ['size_w' => 300, 'size_h' => 300]);

/**
 * Load Vite manifest.
 */
function bvd_load_manifest()
{
	$manifest_path = get_template_directory() . '/build/.vite/manifest.json';
	if (file_exists($manifest_path)) {
		return json_decode(file_get_contents($manifest_path), true);
	}
	return null;
}

/**
 * Add Vite development hook for live reload.
 */
function bvd_vite_dev_hook()
{
	echo '<script type="module" crossorigin src="http://localhost:3002/@vite/client"></script>';
	echo '<script type="module" crossorigin src="http://localhost:3002/assets/scripts/main.js"></script>';
}

/**
 * Enqueue assets for frontend and backend.
 */
function bvd_enqueue_assets()
{
	$vite_env = defined('WP_ENV') ? WP_ENV : 'production'; // Use WP_ENV or default to production
	$dist_uri = get_template_directory_uri() . '/build';
	$manifest = bvd_load_manifest();

	if (is_array($manifest)) {
		$js_file = 'assets/scripts/main.js';

		if ($vite_env === 'production') {
			wp_enqueue_style('main', $dist_uri . '/' . $manifest[$js_file]['css'][0]);
			wp_enqueue_script('main', $dist_uri . '/' . $manifest[$js_file]['file'], [], null, true);
		}

		if ($vite_env === 'development') {
			// Add hooks for development live reload
			add_action('wp_head', 'bvd_vite_dev_hook');
			add_action('admin_head', 'bvd_vite_dev_hook'); // Explicitly add to admin
		}
	}
}

add_action('wp_enqueue_scripts', 'bvd_enqueue_assets');
add_action('admin_enqueue_scripts', 'bvd_enqueue_assets'); // Enqueue for backend as well


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
