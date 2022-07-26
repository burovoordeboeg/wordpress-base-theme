<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Button extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'button',
				'parent' => array('acf/buttons'),
				'title' => 'Button',
				'description' => 'This is a single button',
				'category' => 'custom',
				'icon' => 'button',
				'keywords' => array( 'image', 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array(''),
				'align_text' => false,
				'multiple' => true,
			));
		}
	}

	// Call block-class
	new Button();