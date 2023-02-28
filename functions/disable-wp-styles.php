<?php

	// Exit if accessed directly
	if (!defined('ABSPATH')) exit;

	// This will remomve Wordpress base styles from frontend.
	remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
	remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
