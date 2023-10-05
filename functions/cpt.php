<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Register custom post type
 * @see https://github.com/burovoordeboeg/class-theme-utilities/blob/master/docs/Posttype.md
 */
$utilities->posttype->register(
	'faq-item',
	'FAQ',
	'FAQ item',
	'faq',
	array('title'),
	12,
	'dashicons-format-chat'
);
