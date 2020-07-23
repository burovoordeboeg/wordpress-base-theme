<?php

	// Get the Gutenberg class globally
	global $gutenberg;

	/**
	 * Register block
	 * See the readme: 
	 */
	$gutenberg->registerBlock( array(
		'name' => 'content-fullwidth',
		'title' => 'Content full width',
		'description' => 'This is a full width content block',
		'category' => 'formatting',
		'icon' => '<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500"><path d="M467,33V467H33V33H467M500,0H0V500H500Z" style="fill:#1d1d1b"/><rect x="92" y="100.25" width="315" height="30.73" style="fill:#1d1d1b"/><rect x="71.8" y="158.38" width="75.67" height="30.73" style="fill:#1d1d1b"/><rect x="162.08" y="158.38" width="270.92" height="30.73" style="fill:#1d1d1b"/><rect x="109.64" y="213.87" width="281.36" height="30.73" style="fill:#1d1d1b"/><rect x="71.8" y="305.02" width="355.2" height="30.73" style="fill:#1d1d1b"/><rect x="100" y="359.19" width="291" height="30.73" style="fill:#1d1d1b"/></svg>',
		'keywords' => array( 'content', 'full width' ),
		'post_types' => array( 'post', 'page' ),
		'mode' => 'preview',
		'align' => array( 'wide', 'full', 'center' ),
		'multiple' => true,
		'supports' => array(
			'align' => true,
			'mode' => false,
			'__experimental_jsx' => true
		)
	), array(
		'frontend' => array(
			'style' => 'front-end.css',
			'script' => 'scripts.js'
		),
		'admin' => array(
			'style' => 'back-end.css',
		)
	) );

	function allowedBlocksFullWidth() {
		$allowed_blocks = array( 'acf/content-columns', 'acf/image-grid', 'core/button' );
		echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" />';
	}

?>