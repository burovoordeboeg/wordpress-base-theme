<?php

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;

    /**
     * Add ajaxurl as variable
     */
    add_action('wp_head', function() {
        echo '<script>var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";</script>';
    });
