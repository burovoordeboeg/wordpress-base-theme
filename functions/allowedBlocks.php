{# <?php

	function allowedBlocks() {
		$allowed_blocks = array( 'acf/content-columns', 'acf/image-grid' );
		echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" />';
	}

?> #}