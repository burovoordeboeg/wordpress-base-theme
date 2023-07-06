<?php


	error_reporting(E_ALL & ~E_NOTICE);
	ini_set('display_errors', 'on');


// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Initialize theme
include_once 'functions/init.php';

// Add theme specific methods
include_once 'functions/allowed-twig-functions.php';
include_once 'functions/context.php';
include_once 'functions/cpt.php';
include_once 'functions/block-styles.php';
include_once 'functions/functions.php';