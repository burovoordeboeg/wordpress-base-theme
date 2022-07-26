<?php

	namespace BvdB\Blocks;

	use BvdB\Gutenberg;
	use BvdB\Gutenberg\Blocks as Blocks;

	class Paragraph extends Blocks
	{
		/**
		 * Register the block
		 */
		public function __construct()
		{
			PARENT::register_block( array(
				'name' => 'paragraph',
				'title' => 'Paragraph',
				'description' => 'This is an paragraph block',
				'category' => 'custom',
				'icon' => 'editor-table',
				'keywords' => array( 'text' ),
				'post_types' => array( 'post', 'page' ),
				'mode' => 'preview',
				'align' => array( 'wide', 'full',),
				'align_content' => false,
				'multiple' => true,
				'color' => array(
					'text' => true,
					'background' => false,
				),
			));
		}
	}

	// Call block-class
	new Paragraph();
