<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('tabs', 'ddshort_tabs');
	add_shortcode('tab', 'ddshort_tab');
	
	//Our Funciton
	function ddshort_tabs($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'style' => 1
		
		), $atts));
		
		if($style != 1 && $style != 2 && $style != 3) { $style = 1; }
		
		//// STARTS OUT OUTPUT
		$return = '<div class="dd-tab style'.$style.'">
		
		<ul class="dd-tabs">
		
			<li class="shadow-left"></li>
			<li class="shadow-right"></li>
			
		</ul>
		
		<ul class="dd-tabbed">';
		
		//// OUR TABS
		$return .= do_shortcode($content);
		
		//// closes our content
		$return .= '</ul></div>';
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_tab($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'title' => 'Tab Title Here'
		
		), $atts));
		
		//returns
		return '<li title="'.$title.'">'.do_shortcode($content).'</li>';
		
	}
	
	//include('tinyMCE.php');

?>