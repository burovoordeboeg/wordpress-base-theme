<?php

	// Get the Gutenberg class globally
	global $gutenberg;

	/**
	 * Register block
	 * See the readme: 
	 */
	$gutenberg->registerBlock( array(
		'name' => 'content-columns',
		'title' => 'Content columns',
		'description' => 'This is a content column block',
		'category' => 'common',
		'icon' => '<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500"><path d="M467,33V467H33V33H467M500,0H0V500H500Z" style="fill:#1d1d1b"/><rect x="71.8" y="100.25" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="71.8" y="161.25" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="71.8" y="219.27" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="71.8" y="311.64" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="276.8" y="100.25" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="276.8" y="161.25" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="276.8" y="250" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="276.8" y="301" width="146" height="30.73" style="fill:#1d1d1b"/><rect x="276.8" y="352" width="146" height="30.73" style="fill:#1d1d1b"/></svg>',
		'keywords' => array( 'columns', 'text' ),
		'post_types' => array( 'post', 'page' ),
		'mode' => 'preview',
		'align' => array( 'wide', 'full', 'center' ),
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