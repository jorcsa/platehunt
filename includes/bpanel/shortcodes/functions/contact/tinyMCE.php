<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_contact'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_contact')) {
		
		function dd_add_shortcode_dd_contact() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_contact');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_contact'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_contact')) {
		
		function dd_add_shortcode_register_dd_contact($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '', "dd_contact");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_contact')) {
		
		function dd_add_shortcode_plugin_dd_contact($plugin_array) {
			
			$plugin_array['dd_contact'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/contact/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>