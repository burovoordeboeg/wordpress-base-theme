<?php   

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;
    
    /**
     * Get the site option fields
     *
     * @return array list of all site option fields
     */
    function getSiteOption( $fieldkey ) {

        $fieldvalue = get_field($fieldkey, 'option');
        return $fieldvalue;

    }


/**
 * Enqueue theme block editor scripts.
 */
function rich_block_editor_scripts() {
	$jsBlockFilePath = glob( get_template_directory() . '/dist/js/block-styles.*.js' );
	$jsBlockFileURI = get_template_directory_uri() . '/dist/js/' . basename($jsBlockFilePath[0]);
	wp_enqueue_script( 'rich-editor',  $jsBlockFileURI , array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'enqueue_block_editor_assets', 'rich_block_editor_scripts' );