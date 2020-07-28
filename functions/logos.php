<?php

	add_filter('acf/load_field/name=cpt', 'bvdb_acf_load_post_types');
	/*
	*  Load Select Field `select_post_type` populated with the value and labels of the singular 
	*  name of all public post types
	*/
	function bvdb_acf_load_post_types( $field ) {

		$choices = get_post_types( array( 'show_in_nav_menus' => true ), 'objects' );

		foreach ( $choices as $post_type ) :
			$field['choices'][$post_type->name] = $post_type->labels->singular_name;
		endforeach;
		return $field;
	}

	/**
	 * Get the clients from the cpt client
	 *
	 * @param integer
	 * @return array list of clients
	 */
	function getLogos() {

		$postType = get_field('cpt');


		// Setup query arguments
		$args = array(
			'post_type' => $postType,
			'post_status' => array('publish'),
			'showposts' => -1
		);

		$query = new WP_Query($args);

		$logos = array();

		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

			$logos[] = array(
				'title' => get_the_title(),
				'link' => get_field('website', get_the_id()),
				'image' => get_field('logo', get_the_id())
			);

		endwhile; endif; wp_reset_query();

		return $logos;

	}

?>