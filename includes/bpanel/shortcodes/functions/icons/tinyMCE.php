<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_slider'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_slider')) {
		
		function dd_add_shortcode_dd_slider() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_slider');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_slider'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_slider')) {
		
		function dd_add_shortcode_register_dd_slider($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '', "dd_slider");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_slider')) {
		
		function dd_add_shortcode_plugin_dd_slider($plugin_array) {
			
			$plugin_array['dd_slider'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/slider/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>