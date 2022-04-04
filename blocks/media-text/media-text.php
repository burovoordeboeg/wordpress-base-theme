<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Media_text extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'media_text',
				'title' => 'Media text',
				'description' => 'This is an media text block',
				'category' => 'custom',
				'icon' => 'admin-comments',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array('wide', 'full',),
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Media_text();
?>