<?php

	include('bpanel-config.php');
	
	//shortened function to return option
	function ddp($name) {
		
		return stripslashes(get_option('ddp_'.$name));
		
	}
	
	//function to check our check option and return checked if 'on'
	function ddp_check($field) {
		
		if($field == 'on') {
			
			return 'checked="checked"';
			
		}
		
	}
	
	//function to check for our select dropdown
	function ddp_select($name, $field) {
		
		if($field == $name) {
			
			return 'class="current"';
			
		}
		
	}
	
	//function to check for our current layout
	function ddp_layout($field, $curr) {
		
		if($field == $curr) {
			
			return 'class="current"';
			
		}
		
	}
	
	// CHECKS BG COLOR FOR OPACITY
	function ddp_bg_color($field, $custom_op = NULL) {
		
		//// GETS FIELD
		$color = ddp($field);
		$opacity = ddp($field.'_opacity');
		if($custom_op != NULL) { $opacity = $custom_op; }
		
		//// if opacity is 1 return hex, else return rgba
		if($opacity == 1) {
			
			return 'background-color: '.$color.';';
			
		} else {
			
			//// gets RGBA
			$rgb = hex2rgb($color);
			
			/// RETURN RGB WITH FALLBACK
			return 'background-color: '.$color.'; background-color: rgba('.$rgb[0].', '.$rgb[1].', '.$rgb[2].', '.$opacity.');';
			
		}
		
	}
	
	// CHECKS BG COLOR FOR OPACITY
	function ddp_color($field) {
		
		//// GETS FIELD
		$color = ddp($field);
		$opacity = ddp($field.'_opacity');
		
		//// if opacity is 1 return hex, else return rgba
		if($opacity == 1) {
			
			return 'color: '.$color.';';
			
		} else {
			
			//// gets RGBA
			$rgb = hex2rgb($color);
			
			/// RETURN RGB WITH FALLBACK
			return 'color: '.$color.'; color: rgba('.$rgb[0].', '.$rgb[1].', '.$rgb[2].', '.$opacity.');';
			
		}
		
	}
	
	function ddp_rgb($hex, $opacity) {
		
		//// TRANSFORMS HEX INTO RGB
		$rgb = hex2rgb($hex);
		return 'rgba('.$rgb[0].', '.$rgb[1].', '.$rgb[2].', '.$opacity.')';
		
	}
	
	function hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}

	//Add the menu link for our panel
	add_action('admin_menu', 'ddpAddMenu');
	
	//function to add our menu
	function ddpAddMenu() {
		
		//get our config array
		global $ddpConf;
		
		//Inserts our menu
		add_menu_page($ddpConf['theme_name'].' Options', $ddpConf['theme_name'], 'add_users', 'theme-panel', 'includebPanel');
		
	}
	
	//Our AJAX thingie
	if(version_compare($wp_version, "2.8", ">")) {
		
		//Make sure we load this in our <head>
		require_once('bpanel-ajax-upload.php');
	
	}
	
	//function to our page
	function includebPanel() {
		
		//get our config array
		global $ddpConf;
		
		//Our settings
		global $myOpts;
		
		include('bpanel-builder.php');
		
	}
	
	//// ENQUEUES SRIPTS

    function load_btoa_scripts() {
		
		wp_register_script('jquery-color-bundle', get_template_directory_uri().'/includes/bpanel/js/jquery.color.bundle.min.js', 'jquery');
        
		//// IF WERE IN THE THEME PAGE
		if(is_admin()) { if(isset($_GET['page'])) { if($_GET['page'] == 'theme-panel') {
			
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('jquery-color-bundle');
			
		} } }
		
		if(is_admin()) {
			
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-widget');
			wp_enqueue_script('jquery-ui-mouse');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('iris');
			
		}
		
    }
	add_action('init', 'load_btoa_scripts');
	
	
	//SHORTCODES FRAMEWORK
	include('shortcodes/shortcodes.php');
	
	function _btoa_rewrite_rules() {
		
		global $wp_rewrite;
		
		//flushes our rewrites
		$wp_rewrite->flush_rules();
		
	}

?>