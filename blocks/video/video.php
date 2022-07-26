<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Video extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block(array(
				'name' => 'video',
				'title' => 'Video',
				'description' => 'This is an video block',
				'category' => 'custom',
				'icon' => 'video-alt3',
				'keywords' => array('image', 'text'),
				'post_types' => array('post', 'page'),
				'mode' => 'preview',
				'align' => array('wide', 'full',),
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Video();