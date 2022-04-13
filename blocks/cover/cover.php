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
				'icon' => 'admin-comments',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array('wide', 'full',),
				'align_text' => false,
				'align_content'=> 'matrix',
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Cover();
?>