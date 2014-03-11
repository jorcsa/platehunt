<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('list', 'ddshort_list');
	add_shortcode('highlight', 'ddshort_highlight');
	add_shortcode('dropcap', 'ddshort_dropcap');
	add_shortcode('icon', 'ddshort_icon');
	
	//Our Funciton
	function ddshort_list($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'style' => 'standard'
		
		), $atts));
		
		if($style != 'standard') {
			$return = '<ul class="ddshortlist ddshortlist-'.$style.'">';
		} else { $return = '<ul>'; }
		
		$return .= do_shortcode($content);
		
		$return .= '</ul>';
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_highlight($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'style' => '1'
		
		), $atts));
		
		return '<span class="highlight'.$style.'">'.$content.'</span>';
		
	}
	
	function ddshort_list_li($atts, $content = null) {
		
		return '<li>'.do_shortcode($content).'</li>';
		
	}
	
	function ddshort_dropcap($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'style' => 1,
		
		), $atts));
		
		return '<span class="dropcap'.$style.'">'.$content.'</span>';
		
	}
	
	function ddshort_icon($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'type' => 'box',
		
		), $atts));
		
		//// IF TYPE ISNT NULL
		if($type != '') {
			
			return '<span class="ddicon ddicon-'.$type.'">'.$content.'</span>';
			
		}
		
	}
	
	include('tinyMCE.php');

?>