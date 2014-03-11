<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_toggle'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_toggle')) {
		
		function dd_add_shortcode_dd_toggle() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_toggle');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_toggle'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_toggle')) {
		
		function dd_add_shortcode_register_dd_toggle($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '', "dd_toggle");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_toggle')) {
		
		function dd_add_shortcode_plugin_dd_toggle($plugin_array) {
			
			$plugin_array['dd_toggle'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/toggle/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>