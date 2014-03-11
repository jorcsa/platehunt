<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_boxed'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_boxed')) {
		
		function dd_add_shortcode_dd_boxed() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_boxed');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_boxed'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_boxed')) {
		
		function dd_add_shortcode_register_dd_boxed($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '', "dd_boxed");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_boxed')) {
		
		function dd_add_shortcode_plugin_dd_boxed($plugin_array) {
			
			$plugin_array['dd_boxed'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/boxed/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>