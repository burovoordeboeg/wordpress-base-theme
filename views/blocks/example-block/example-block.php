<?php

	// Get the Gutenberg
	use BvdB\Gutenberg as Gutenberg;
	$gutenberg = Gutenberg::getInstance();

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
		'multiple' => true,
	), array( // TO-DO: Remove this from our gutenberg.php class. We include css and js in one main file.
		'frontend' => array(
			// 'script' => 'scripts.js'
		),
		'admin' => array(
			'script' => 'scripts.js'
		)
	) );
