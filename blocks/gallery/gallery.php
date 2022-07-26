<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Gallery extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'gallery',
				'title' => 'Gallery',
				'description' => 'This is an gallery block',
				'category' => 'custom',
				'icon' => 'format-gallery',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array( 'wide', 'full',),
				'align_content' => false,
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
	new Gallery();
