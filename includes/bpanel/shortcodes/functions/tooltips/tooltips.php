<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('tooltip', 'ddshort_tooltip');
	add_shortcode('tooltip_content', 'ddshort_tooltip_content');
	
	//Our Funciton
	function ddshort_tooltip($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'width' => '',
			'position' => 'top',
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$output = '<div class="tooltip tooltip-side-'.$position.'"';
		
		//// WIDTH
		if($width != '') { $output .= ' style="width: '.$width.'"'; }
		
		//// CLOSES THE START OF OUR TOOLTIP
		$output .= '>';
		
		//// OUR TOOLTIP TRIGGER
		$output .= do_shortcode($content);
		
		//// Closes our tooltip main container
		$output .= '</div>';
		
		return $output;
		
	}
	
	//Our Funciton
	function ddshort_tooltip_content($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'color' => 'white',
			'width' => '',
			'fixed' => '',
		
		), $atts));
		
		//// STARTS OUR CONTENT
		$output = '<div class="tooltip-content"';
		
		//// OUR WIDTH
		if($width != '') { $output .= ' style="width: '.$width.';"'; }
		
		//// CLOSES THE OPENING
		$output .= '>';
		
		//// COLOR TOOTIP
		$output .= '<div class="'.$color.'">';
		
			//// OUR ARROW
			$output .= '<span class="arrow"></span>';
			
			//// IF IT'S FIXED
			if($fixed == 'true') { $output .= '<span class="close"></span>'; }
			
			//// OUR CONTENT
			$output .= do_shortcode($content);
		
		//// CLOSES THE CONTAINER
		$output .= '</div></div>';
		
		return $output;
		
	}
	
	include('tinyMCE.php');

?>