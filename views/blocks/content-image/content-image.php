<?php

	// Get the Gutenberg class globally
	global $gutenberg;

	/**
	 * Register block
	 * See the readme: 
	 */
	$gutenberg->registerBlock( array(
		'name' => 'content-image',
		'title' => 'Content image',
		'description' => 'This is a content image block',
		'category' => 'formatting',
		'icon' => '<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500"><path d="M467,33V467H33V33H467M500,0H0V500H500Z" style="fill:#1d1d1b"/><polyline points="283.16 393.06 446.09 393.06 391.9 242.65 357.72 343.24 320.28 278.91" style="fill:#1d1d1b"/><circle cx="380.6" cy="143.16" r="42.91" style="fill:#1d1d1b"/><rect x="64.8" y="100.25" width="165.95" height="30.73" style="fill:#1d1d1b"/><rect x="64.8" y="158.38" width="75.67" height="30.73" style="fill:#1d1d1b"/><rect x="155.08" y="158.38" width="75.67" height="30.73" style="fill:#1d1d1b"/><rect x="64.8" y="213.87" width="165.95" height="30.73" style="fill:#1d1d1b"/><rect x="64.8" y="305.02" width="165.95" height="30.73" style="fill:#1d1d1b"/><rect x="64.8" y="359.19" width="165.95" height="30.73" style="fill:#1d1d1b"/></svg>',
		'keywords' => array( 'image', 'text' ),
		'post_types' => array( 'post', 'page' ),
		'mode' => 'preview',
		'align' => array( 'wide', 'full', 'center' ),
		'multiple' => true,
		'styles' => array(
			[
				'name' => 'light',
				'label' => __('Light', 'abc'),
				'isDefault' => true,
			],
			[
				'name' => 'medium',
				'label' => __('Medium', 'abc'),
			],
			[
				'name' => 'dark',
				'label' => __('Dark', 'abc'),
			]
		)
	), array(
		'frontend' => array(
			'style' => 'front-end.css',
			'script' => 'scripts.js'
		),
		'admin' => array(
			'style' => 'back-end.css'
		)
	) );

	function allowedBlocksContentImage() {
		$allowed_blocks = array( 'core/button', 'core/image', 'core/paragraph', 'core/heading' );
		echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" />';
	}

?>