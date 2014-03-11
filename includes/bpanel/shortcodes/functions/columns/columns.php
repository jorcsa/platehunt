<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR BIG BUTTONS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('clear', 'ddshort_column_clear');
	add_shortcode('raw', 'ddshort_column_raw');
	add_shortcode('column', 'ddshort_columns');
	add_shortcode('_column', 'ddshort_columns');
	add_shortcode('__column', 'ddshort_columns');
	add_shortcode('___column', 'ddshort_columns');
	add_shortcode('padding', 'ddshort_padding');
	
	//// COLUMN SHORTCODE
	function ddshort_columns($atts, $content = null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'size' => 'one',
			'last' => '',
			'background' => '',
			'pos' => 'top left'
				
		),$atts));
		
		//// STARTS OUR OUTPUT
		$output = '';
		
		//// BEGINNING OF IT
		$output .= '<div class="'.$size;
		
		//// IF LAST
		if($last != '') { $output .= ' last'; }
		
		
		//// CLOSES THE FIRST PART OF OUR COLUMN
		$output .= '"';
		
		/// IF IT HAS A BACKGROUND
		if($background != '') { $output .= ' style="background: url('.$background.') no-repeat '.$pos.';"'; }
		
		//// CLOSES THE DIV
		$output .= '>'.do_shortcode($content).'</div>';
		
		return $output;
		
	}
	
	//raw function
	function ddshort_column_clear($atts, $content = null) {
		
		return '<div class="clear"></div>';
		
	}
	
	add_action('init', 'addColumnsShorts');
	
	function addColumnsShorts() {
		
		if(is_admin()) wp_enqueue_script('custom_quicktags', get_template_directory_uri().'/includes/bpanel/shortcodes/functions/columns/columns.js', array('quicktags'), '1.0');
		
	}
	
	function ddshort_padding($atts, $content=null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'size' => '30',
				
		),$atts));
		
		return '<div class="padding" style="height: '.$size.'px;"></div>';
		
	}
	
	function ddshort_column_raw($atts, $content = null) {
		
		return $content;
		
	}
		
	
	
	//our TinyMCE
	//include('tinyMCE.php');

?>