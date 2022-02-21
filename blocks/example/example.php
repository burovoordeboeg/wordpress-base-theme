<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Example extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'example',
				'title' => 'Example',
				'description' => 'This is an example block',
				'category' => 'custom',
				'icon' => 'admin-comments',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array( 'wide', 'full' ),
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Example();
?>