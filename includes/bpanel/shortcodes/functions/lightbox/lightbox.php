<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR PORTFOLIO
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('dd_lightbox', 'ddshot_lightbox');
	
	//Our Funciton
	function ddshot_lightbox($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'url' => '#',
			'title' => ''
		
		), $atts));
		
		return '<a title="'.$title.'" href="'.$url.'" rel="prettyPhoto">'.$content.'</a>';
		
	}
	
	include('tinyMCE.php');

?>