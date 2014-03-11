<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR ICONS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('font_icon', 'btoashort_icon');
	
	//Our Funciton
	function btoashort_icon($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'type' => 'star',
			'color' => '#484544',
			'size' => '45',
		
		), $atts));
		
		$return = '<i class="icon-'.$type.'" style="color: '.$color.'; font-size: '.$size.'px; line-height: '.($size+5).'px"></i>';
		
		return $return;
		
	}
	
	
	
?>