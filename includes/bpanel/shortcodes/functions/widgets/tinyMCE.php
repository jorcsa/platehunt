<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_notifications'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_notifications')) {
		
		function dd_add_shortcode_dd_notifications() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_notifications');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_notifications'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_notifications')) {
		
		function dd_add_shortcode_register_dd_notifications($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '', "dd_notifications");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_notifications')) {
		
		function dd_add_shortcode_plugin_dd_notifications($plugin_array) {
			
			$plugin_array['dd_notifications'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/notifications/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>