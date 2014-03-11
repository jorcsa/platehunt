<?php


	//// ADDS OUR ACTION
	add_action('init', 'dd_add_shortcode_dd_audioandvideo'); 
	
	
	/////////////////////////////////////////////////////////
	//// OUR FUNCTION TO ADD THE BUTTON
	if(!function_exists('dd_add_shortcode_dd_audioandvideo')) {
		
		function dd_add_shortcode_dd_audioandvideo() {
			
			//// CHECK PERMISSIONS
			if(current_user_can('edit_posts') && current_user_can('edit_pages')) { 
			 
				 add_filter('mce_external_plugins', 'dd_add_shortcode_plugin_dd_audioandvideo');  
				 add_filter('mce_buttons', 'dd_add_shortcode_register_dd_audioandvideo'); 
				  
			}
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR BUTTON
	if(!function_exists('dd_add_shortcode_register_dd_audioandvideo')) {
		
		function dd_add_shortcode_register_dd_audioandvideo($buttons) {
			
			//// ADDS THE BUTTON TO THE ARRAY
			array_push($buttons, '', "dd_audioandvideo");  
			return $buttons;
			
		}
	
	}
	
	
	/////////////////////////////////////////////////////////
	//// REGISTERS OUR PLUGIN
	if(!function_exists('dd_add_shortcode_plugin_dd_audioandvideo')) {
		
		function dd_add_shortcode_plugin_dd_audioandvideo($plugin_array) {
			
			$plugin_array['dd_audioandvideo'] = get_template_directory_uri().'/includes/bpanel/shortcodes/functions/audioandvideo/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}

?>