<?php

    function getDefaultData () {

        $data = array();

        // Default information about the website
        $data['defaults'] = array(
            'absolute_theme_path' => get_template_directory(),
            'absolute_theme_uri' => get_template_directory_uri(),
            'current_year' => date('Y'),
            'home_url' => esc_url( home_url( '/' )),
        );

        // Set the navigation array
        $data['navigation'] = array(

        );

        // Return page data
        $data['page'] = array(
            'title' => wp_title('', false),
        );


        // Return the data object
        return $data;

    }



?>