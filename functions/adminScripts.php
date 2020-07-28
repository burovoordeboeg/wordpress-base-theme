<?php

function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    if ('post.php' !== $hook) {
        return;
	}
	
    wp_enqueue_script('my_custom_script', get_template_directory_uri() . '/dist/js/plugins.js', array(), '1.0');
}

add_action('admin_enqueue_scripts', 'my_enqueue', 1, 99);
