<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Heading extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'heading',
				'title' => 'Heading',
				'description' => 'This is an example block',
				'category' => 'custom',
				'icon' => 'heading',
				'keywords' => array( 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array( 'wide', 'full',),
				'default-align' => 'full',
				'multiple' => true,
				'align_content' => false
			), array(
				'heading' => array(
					'text' => 'Hallo!',
					'type' => 'h2',
					'size' => 'large',
				)
			));
		}
	}

	// Call block-class
	new Heading();