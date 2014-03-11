<?php

	//// CSS FILE
	header("Content-type: text/css; charset: UTF-8");
	
	//// LOADS OUR REQUIRED FUNCTIONS
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	
	//// HEADER VARIABLES
	$header_bg = ddp('header_bg_color');
	$header_border = ddp('header_border_color');

?>

body { background: red; }