<?php

function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    if ('edit.php' !== $hook) {
        return;
    }
    wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . '/dist/js/plugins.js');
}

add_action('admin_enqueue_scripts', 'my_enqueue');
