<?php

	// Get the Gutenberg class globally
	global $gutenberg;

	/**
	 * Register block
	 * See the readme: 
	 */
	$gutenberg->registerBlock( array(
		'name' => 'example-block',
		'title' => 'Example block',
		'description' => 'This is an example block',
		'category' => 'formatting',
		'icon' => 'admin-comments',
		'keywords' => array( 'image', 'text' ),
		'post_types' => array( 'post', 'page' ),
		'mode' => 'preview',
		'align' => array( 'center', 'wide', 'full' ),
		'default_align' => 'center',
		'multiple' => true,
	), array(
		'frontend' => array(
			'style' => 'front-end.css',
			'script' => 'scripts.js'
		),
		'admin' => array(
			'style' => 'back-end.css',
		)
	) );

?>