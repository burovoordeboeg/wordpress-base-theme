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


add_action('admin_enqueue_scripts',function(){
	wp_enqueue_script( 'jquery-ui-resizable');
});

add_action('admin_head', function() { ?>
	<style>
		.interface-interface-skeleton__sidebar .interface-complementary-area{ width:100%;}
		.edit-post-layout:not(.is-sidebar-opened) .interface-interface-skeleton__sidebar{ display:none;}
		.is-sidebar-opened .interface-interface-skeleton__sidebar{ width:25%;}
	</style>
<?php });