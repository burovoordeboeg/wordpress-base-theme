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

