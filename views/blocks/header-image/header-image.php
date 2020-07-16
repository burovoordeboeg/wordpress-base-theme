<?php

	// Get the Gutenberg class globally
	global $gutenberg;

	/**
	 * Register block
	 * See the readme: 
	 */
	$gutenberg->registerBlock( array(
		'name' => 'header-image',
		'title' => 'Header image',
		'description' => 'This is a header image block with title and optional subtitle',
		'category' => 'common',
		'icon' => '<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500"><path d="M467,33V467H33V33H467M500,0H0V500H500V0Z" style="fill:#1d1d1b"/><polyline points="89.3 414.29 393.15 414.29 292.08 173.19 226.69 268.31 158.53 231.31" style="fill:#1d1d1b"/><circle cx="142.8" cy="129.32" r="42.91" style="fill:#1d1d1b"/><rect x="38.36" y="307.4" width="240.34" height="61.75" style="fill:#fff"/></svg>',
		'keywords' => array( 'header', 'image', 'title' ),
		'post_types' => array( 'post', 'page' ),
		'mode' => 'preview',
		'align' => array( 'wide', 'full', 'center' ),
		'multiple' => false,
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