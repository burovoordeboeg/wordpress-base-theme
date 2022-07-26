<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Buttons extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block(array(
				'name' => 'buttons',
				'title' => 'Buttons',
				'description' => 'This is an button block',
				'category' => 'custom',
				'icon' => 'button',
				'keywords' => array('image', 'text'),
				'post_types' => array('post', 'page'),
				'mode' => 'preview',
				'align' => array('wide', 'full'),
				'align_text' => false,
				'align_content' => false,
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Buttons();
