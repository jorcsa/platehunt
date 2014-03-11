<?php

	//// OUR SHORTCODES GENERATOR CONFIGS
	include('shortcodes-config.php');
	
	
	/////////////////////////////////////////////////////////////////////////
	//// LET'S INCLUDE OUR METABOX
	add_action('admin_menu' ,'bpanel_shortcodes_generator');
	
	//// FUNCTION
	function bpanel_shortcodes_generator() {

		//// OUR SHORTCODES GENERATOR CONFIGS
		include('shortcodes-config.php');
	
		//// ADDS METABOX
		foreach($post_type as $type) {
			add_meta_box('bpanel_shortcodes_generator', 'Shortcode Generator:', 'bpanel_shortcodes_generator_create', $type, 'normal', 'high' );
		}
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function bpanel_shortcodes_generator_create() {
		
		//// GLOBAL $POST
		global $post;

		//// OUR SHORTCODES GENERATOR CONFIGS
		include('shortcodes-config.php');
		
		//// METABOX MARKUP
		include('shortcodes-builder.php');
		
	}

?>