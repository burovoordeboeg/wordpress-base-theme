<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Image extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block(array(
				'name' => 'image',
				'title' => 'Image',
				'description' => 'This is an image block',
				'category' => 'custom',
				'icon' => 'format-image',
				'keywords' => array('image', 'text'),
				'post_types' => array('post', 'page'),
				'mode' => 'preview',
				'align' => array('wide', 'full',),
				'align_content' => false,
				'align_text' => false,
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Image();