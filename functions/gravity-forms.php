<?php

add_filter( 'gform_address_display_format', 'address_format' );
function address_format( $format ) {
    return 'zip_before_city';
}