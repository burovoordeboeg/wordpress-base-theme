<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

add_action( 'init', 'bvdb_register_block_styles' );

function bvdb_register_block_styles() {
	register_block_style(
        'core/button',
		array(
            'name' => 'link',
            'label' => __( 'Link', 'bvdb' ),
        )
	);
}