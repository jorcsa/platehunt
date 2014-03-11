<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('style_table', 'ddshort_style_table');
	
	//Our Funciton
	function ddshort_style_table($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'style' => '1'
		
		), $atts));
		
		return '<div class="table_style_'.$style.'">'.do_shortcode($content).'</div>';
		
	}

?>