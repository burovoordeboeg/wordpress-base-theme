<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Post_grid extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'post_grid',
				'title' => 'Post Grid',
				'description' => 'This is an post grid block',
				'category' => 'custom',
				'icon' => 'grid-view',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array( 'wide', 'full',),
				'align_content' => false,
				'align_text' => false,
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Post_grid();
