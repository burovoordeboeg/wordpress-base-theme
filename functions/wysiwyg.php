<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
function my_toolbars($toolbars)
{
	// Uncomment to view format of $toolbars

	// echo '<pre>';
	// print_r($toolbars);
	// echo '</pre>';
	// die;


	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Very Simple'] = array();
	$toolbars['Very Simple'][1] = array('bold', 'italic', 'underline', 'link', 'bullist');

	// Edit the "Full" toolbar and remove 'code'
	// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
	if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
		unset($toolbars['Full'][2][$key]);
	}

	// remove the 'Basic' toolbar completely
	unset($toolbars['Basic']);

	// return $toolbars - IMPORTANT!
	return $toolbars;
}
