<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOGGLE
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('toggle', 'ddshort_toggle');
	
	//Our Funciton
	function ddshort_toggle($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'type' => 'normal',
			'title' => 'Don\'t forget your title attribute!',
			'initial' => '',
			'color' => 'white',
			'id' => '',
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$output = '<div class="toggled';
		
		//// OUT TYPE
		if($type == 'boxed') { $output .= ' toggle-boxed'; } else { $output .= ' toggle-normal'; }
		
		//// OUR INITIAL STATE
		if($initial == 'open') {  $output .= ' toggle-open'; }
		
		//// OUR ID
		if($id != '') { $output .= ' toggleid-'.$id; }
		
		//// CLOSES THE INITIAL DIV
		$output .= '">';
		
		/// OUR TITLE
		//// IF IT'S BOXED
		if($type == 'boxed') {
			
			$output .= '<h6 class="'.$color.'" onclick="jQuery(this).ddToggle();"><span';
			if($initial == 'open') { $output .= ' class="close"'; }
			$output .= '></span>'.$title.'</h6>';
			
		} else {
			
			$output .= '<h6 onclick="jQuery(this).ddToggle();"><span class="'.$color.'"></span>'.$title.'</h6>';
			
		}
		
		//// CLOSES OUR TOGGLE WITH THE CONTENT AND REST OF DIVS
		$output .= '<div><p>'.do_shortcode($content).'</p></div></div>';
		
		return $output;
		
	}
	
	include('tinyMCE.php');

?>