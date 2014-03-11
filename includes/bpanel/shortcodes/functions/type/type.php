<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR HEADERS AND TYPOGRAPHY
	///////////////////////////////////
	///////////////////////////////////
	
	
	//// OUR HOOK
	add_shortcode('header', 'ddshort_header');
	add_shortcode('get_the_code', 'ddshort_get_the_code');
	add_shortcode('blockquote', 'ddshort_blockquote');
	add_shortcode('pullquote', 'ddshort_pullquote');
	add_shortcode('divider_top', 'ddshort_divider_top');
	add_shortcode('teaser', 'ddshort_teaser');
	
	add_shortcode('slogan_slider', 'ddshort_slogan_slider');
	add_shortcode('slogan_slide', 'ddshort_slogan_slide');
	
	//// HEADER_STYLE FUNCTION
	function ddshort_header($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'type' => 'h5',
			'style' => 'divider',
			'id' => '',
			'text_align' => 'left',
		
		), $atts));
		
		//// TYPE — DIVIDER
		if($style == 'divider') {
			
			//// if type isnt set set the default
			if(dd_get_header_type($type)) { $type = 'h5'; }
			
			//// Returns it
			$return = '<'.$type.' class="header-'.$style.'" style="text-align: '.$text_align.';"';
			
			if($id != '') { $return .= ' id="'.$id.'"'; }
			
			$return .= '>'.$content.'</'.$type.'>';
			
		}
		
		//// TYPE — FANCY1
		else {
			
			//// if type isnt set set the default
			if(dd_get_header_type($type)) { $type = 'h4'; }
			
			//// Returns it
			$return = '<'.$type.' class="'.$style.'" style="text-align: '.$text_align.';"';
			
			if($id != '') { $return .= ' id="'.$id.'"'; }
			
			$return .= '>'.$content.'</'.$type.'>';
			
		}
		
		return $return;
		
	}
	function ddshort_divider_top($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'text' => 'top',
		
		), $atts));
		
		return '<div class="divider-top" onclick="jQuery(this).ddGoToTop();"><span>'.$text.'</span></div><div class="clear"></div>';
		
	}
	
	function ddshort_blockquote($atts, $content = null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'style' => 'quote',
			'author' => ''
				
		),$atts));
		
		if($style == 'quote' || $style == 'box' || $style == 'box2' || $style == 'quote2' || $style == 'quote3') {
		
			$return = '<blockquote class="'.$style.'">
			'.$content;
			
			if($author != '') { $return .= '<span>&mdash; '.$author.'</span>'; }
                            
            $return .= '</blockquote>';
			
		}
		
		return $return;
		
	}
	
	function ddshort_pullquote($atts, $content = null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'style' => 'quote',
			'side' => 'left',
			'author' => ''
				
		),$atts));
		
		if($style == 'quote' || $style == 'box' || $style == 'box2' || $style == 'quote2' || $style == 'quote3') {
		
			$return = '<blockquote class="'.$style.' pullquote-'.$side.'">
			'.$content;
			
			if($author != '') { $return .= '<span>&mdash; '.$author.'</span>'; }
                            
            $return .= '</blockquote>';
			
		}
		
		return $return;
		
	}
	
	function ddshort_get_the_code($atts, $content = null) {
		
		return '<div class="clear"></div><div class="get_the_code"><h6 onclick="jQuery(this).ddGetTheCode();" class="open">Get The Code</h6><div>'.do_shortcode($content).'</div></div>';	
		
	}
	
	function dd_get_header_type($type) {
		
		if($type != 'h1' && $type != 'h2' && $type != 'h3' && $type != 'h4' && $type != 'h5' && $type != 'h6') {
			
			return true;
			
		} else {
			
			return false;
			
		}
		
	}
	
	//// TEASER SHORTCODE
	function ddshort_teaser($atts, $content = null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'style' => '1',
			
		),$atts));
		
		return '<div class="ddteaser-'.$style.'">'.do_shortcode($content).'</div>';
		
	}
	
	//// TEASER SHORTCODE
	function ddshort_slogan_slider($atts, $content = null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'delay' => '5000',
			
		),$atts));
		
		return '<div class="ddslogan_slider delay-'.$delay.'">'.do_shortcode($content).'<ul class="ddslogan_slider_selector"></ul></div>';
		
	}
	
	//// TEASER SHORTCODE
	function ddshort_slogan_slide($atts, $content = null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'author' => '',
			
		),$atts));
		
		return '<div class="ddslogan_slide">'.do_shortcode($content).'</div>';
		
	}
	
?>