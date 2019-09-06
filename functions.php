<?php
	
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;

	// Show error reporting by default
	// --
	// To see live logs running inside the container
	// --
	// $date: 			in format YYYY-MM-DDT00:00:00
	// $containerid:	get the id of the container with the "docker ps" 
	// 					command running on image jstreuper/wordpress-latest
	// --
	// Command:
	// docker logs -f --since=$date $containerid >/dev/null
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');


	// Create theme instance and call the theme class to initialize globally.
	include_once get_stylesheet_directory() . '/vendor/autoload.php';
	$theme = \VisualMasters\Theme::getInstance();

	// Enqueue scripts and styles
	$theme->assets->register('script', 'jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), false);
	$theme->assets->register('script', 'scripts', get_stylesheet_directory_uri() . '/dist/js/scripts.js', array('jquery'), true);
	$theme->assets->register('style', 'global', get_stylesheet_directory_uri() . '/dist/css/styles.css', array(), false);

	// Create project post type
	$theme->cpt->posttype->register('project', 'Projecten', 'Project', 'projecten', array('title', 'editor', 'menu_order'), 24, 'dashicons-admin-home');
	$theme->cpt->taxonomy->register( 'Status', 'project', 'Projectstatus', 'status', 'projectstatus' );

	// Enqueue all assets (keep at end of file)
	$theme->assets->load();


	// Theme functions
	include_once 'functions/data.php';


	
?>