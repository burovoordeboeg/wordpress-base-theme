<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Cover extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'cover',
				'title' => 'Cover',
				'description' => 'This is an cover block',
				'category' => 'custom',
				'icon' => 'cover-image',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array('wide', 'full',),
				'align_text' => false,
				'align_content'=> 'matrix',
				'full_height' => true,
				'multiple' => true,
				'color' => array(
					'text' => true,
					'background' => false,
				),
			));
		}
	}

	// Call block-class
	new Cover();
