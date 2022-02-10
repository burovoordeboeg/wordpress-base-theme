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

	// Error reporting
	if( is_user_logged_in() ) {
		error_reporting(E_ALL);
		ini_set('display_errors', 'on');
	}

	// Initialize theme
	include_once 'functions/init.php';
	
	// Add theme specific methods
	include_once 'functions/navigation.php';
  	include_once 'functions/options.php';

	  