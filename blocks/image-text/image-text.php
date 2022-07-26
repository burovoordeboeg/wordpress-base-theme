<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Image_text extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'image_text',
				'title' => 'Image & text',
				'description' => 'This is an image and text block',
				'category' => 'custom',
				'icon' => 'align-pull-right',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array('wide', 'full',),
				'align_text' => false,
				'multiple' => true,
				'color' => array(
					'text' => false,
					'background' => true,
				),
			));
		}
	}

	// Call block-class
	new Image_text();
