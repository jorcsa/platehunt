<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_tooltip'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_tooltip')) {
		
		function dd_add_shortcode_dd_tooltip() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_tooltip');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_tooltip'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_tooltip')) {
		
		function dd_add_shortcode_register_dd_tooltip($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '', "dd_tooltip");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_tooltip')) {
		
		function dd_add_shortcode_plugin_dd_tooltip($plugin_array) {
			
			$plugin_array['dd_tooltip'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/tooltips/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>