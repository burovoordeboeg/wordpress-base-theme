<?php

	// Exit if accessed directly
	if (!defined('ABSPATH')) exit;


	/**
	 * Get the WordPressObject by post_id
	 *
	 * @param int $post_id
	 * @return WordPressObject|null
	 */
	function get_object_by_post_id( int $post_id = null )
	{
		if( $post_id !== null ) {
			$object_loader = \BvdB\Templates\Objects::get_instance();
			return $object_loader->get_object(get_post($post_id));
		}

		return null;
	}


	// Remove Gutenberg stylesheets from frontend for performance
	function remove_gutenberg_stylesheets() {
		wp_dequeue_style('wp-block-library');              // Gutenberg blocks styles
		wp_dequeue_style('wp-block-library-theme');        // Gutenberg default theme styles
		wp_dequeue_style('wc-block-style');                // WooCommerce blocks styles
		wp_dequeue_style('storefront-gutenberg-blocks');   // Storefront theme's Gutenberg blocks styles (if applicable)
		// Add any other Gutenberg stylesheets you want to remove
	}
	add_action('wp_enqueue_scripts', 'remove_gutenberg_stylesheets', 100);
	
	// Remove Gutenberg stylesheets from backend for performance
	function remove_gutenberg_backend_styles() {
		wp_dequeue_style('wp-block-library');              // Gutenberg blocks styles
		wp_dequeue_style('wp-block-library-theme');        // Gutenberg default theme styles
		wp_dequeue_style('wc-block-style');                // WooCommerce blocks styles
		wp_dequeue_style('storefront-gutenberg-blocks');   // Storefront theme's Gutenberg blocks styles (if applicable)
	}
	add_action('admin_enqueue_scripts', 'remove_gutenberg_backend_styles', 100);

	// Disable unlocking of blocks by certain users
	function bvdb_admin_only_block_locking($settings, $context) {
		// admin level only
		// change current_user_can to 'delete_others_posts' for editor level+
		$settings['canLockBlocks'] = current_user_can('activate_plugins');
		return $settings;
	}
	
	add_filter('block_editor_settings_all', 'bvdb_admin_only_block_locking', 10, 2);