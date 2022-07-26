<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Wysiwyg extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'wysiwyg',
				'title' => 'Wysiwyg',
				'description' => 'This is an wysiwyg block',
				'category' => 'custom',
				'icon' => 'text',
				'keywords' => array( 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array( 'wide', 'full',),
				'align_text' => false,
				'align_content' => false,
				'multiple' => true,
				'color' => array(
					'text' => true,
					'background' => true,
				),
			));
		}
	}

	// Call block-class
	new Wysiwyg();
