<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR BOXED CONTENT
	///////////////////////////////////
	///////////////////////////////////
	
	//// HOOK
	add_shortcode('boxed_content', 'ddshort_boxed');
	
	//// FUNCTION
	function ddshort_boxed($atts, $content = null) {
		
		//// OUR DEFAULTS
		extract(shortcode_atts(array(
		
			'title' => 'Box Title',
			'color' => strtolower(ddp('color')),
		
		), $atts));
		
		$content = do_shortcode($content);
		
		//// STARTS OUR OUTPUT
		$output = '<div class="boxed">';
		
		/// TITLE
		$output .= '<h6 class="'.$color.'">'.$title.'</h6>';
		
		//// CLOSES OUTPUT
		$output .= '<div><p>'.$content.'</p></div></div>';
		
		//// RETURNS OUTPUT
		return $output;
		
	}
	
	//// OUR BUTTON
	include('tinyMCE.php');

?>