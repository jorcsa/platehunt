<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('notification', 'ddshort_notification');
	add_shortcode('alert_box', 'ddshort_alert_box');
	
	//Our Funciton
	function ddshort_notification($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'color' => strtolower(ddp('color'))
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$output = '<div class="notification">';
		
		//// COLOR
		$output .= '<span class="'.$color.'">';
		
		//// CLOSES OUR OUTPUT
		$output .= do_shortcode($content).'</span></div>';
		
		return $output;
		
	}
	
	//OUR FUNCTION
	function ddshort_alert_box($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'type' => 'blank'
		
		), $atts));
		
		if($type == 'none') { $type = 'blank'; }
		
		//// STARTS OUR OUTPUT
		$output = '<div class="alert-box alert-'.$type.'"><span class="icon"></span>';
		
		//// CLOSES OUR OUTPUT
		$output .= do_shortcode($content).'</div>';
		
		return $output;
		
	}
	
	include('tinyMCE.php');

?>