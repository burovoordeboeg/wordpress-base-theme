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