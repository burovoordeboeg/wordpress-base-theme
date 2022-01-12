<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

register_block_style(
	'core/button',
		array(
			'name'  => 'cta',
			'label' => __( 'Call to Action', 'bvdb' ),
			'is_default'   => true,
			'inline_style' => '.is-style-primary {  
		   		border-radius: 6px;
			}',
		)
);


// register_block_style(
//     'core/quote',
//     array(
//         'name'         => 'blue-quote',
//         'label'        => __( 'Blue Quote', 'textdomain' ),
//         'inline_style' => '.wp-block-quote.is-style-blue-quote { color: blue; }',
//     )
// );

