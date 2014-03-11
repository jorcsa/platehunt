<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_buttons'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_buttons')) {
		
		function dd_add_shortcode_dd_buttons() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_buttons');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_buttons'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_buttons')) {
		
		function dd_add_shortcode_register_dd_buttons($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '|', "dd_buttons");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_buttons')) {
		
		function dd_add_shortcode_plugin_dd_buttons($plugin_array) {
			
			$plugin_array['dd_buttons'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/buttons/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>