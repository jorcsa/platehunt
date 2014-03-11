<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR IMAGE FRAMES AND LIGHTBOX
	///////////////////////////////////
	///////////////////////////////////
	
	
	//// OUR HOOK
	add_shortcode('image_frame', 'ddshort_image_frame');
	add_shortcode('image_hover', 'ddshort_image_hover');
	add_shortcode('image_preload', 'ddshort_image_preload');
	add_shortcode('lightbox', 'ddshort_lightbox');
	
	//// HEADER_STYLE FUNCTION
	function ddshort_image_frame($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'width' => '',
			'height' => '',
			'style' => 1,
			'caption' => '',
			'align' => '',
		
		), $atts));
		
		//// STARTS OUR OUTPUT BASED ON THE STYLE
		
		//// align
		if($align == 'left' || $align == 'right') { $align_class = ' frame-align-'.$align; } else { $align_class = ''; }
		
		//// IF STYLE = 1
		if($style == 1 || $style == 2) {
			
			//// STARTS OUT OUTPUT
			$return = '<span class="frame'.$style.$align_class.'">';
		   
		   //// IMAGE
		   $return .= do_shortcode($content);
		   
		   //// IF IT HAS CAPTION
		   if($caption != '') { $return .= '<span class="image_caption">'.$caption.'</span>'; }
		   
		   //// CLOSES OUTPUT 
		   $return .= '</span>';
			
		} elseif($style == 3) {
			
			//// STARTS OUT OUTPUT
			$return = '<span class="frame'.$style.$align_class.'">';
		   
		   //// IMAGE
		   $return .= do_shortcode($content);
		   
		   //// IF IT HAS CAPTION
		   if($caption != '') { $return .= '<span class="image_caption">'.$caption.'</span>'; }
		   
		   //// CLOSES OUTPUT 
		   $return .= '<span class="bottom-shadow"></span>
		   <span class="left-shadow"></span>
		   <span class="right-shadow"></span>
		   </span>';
			
		} elseif($style == 4 && $width != '' && $height != '') {
			
			//// STARTS OUT OUTPUT
			$return = '<span class="frame'.$style.$align_class.'" style="width: '.$width.'px">';
		   
		   //// IMAGE
		   $return .= do_shortcode($content);
		   
		   //// IF IT HAS CAPTION
		   if($caption != '') { $return .= '<span class="image_caption">'.$caption.'</span>'; }
		   
		   //// CLOSES OUTPUT 
		   $return .= '<span class="bottom-shadow" style="top: '.$height.'px"><img src="'.get_template_directory_uri().'/includes/bpanel/shortcodes/images/shortcodes/frames/frame4-bottom.png" width="'.$width.'" /></span>
		   </span>';
			
		}
		
		return $return;
		
	}
	
	//// HEADER_STYLE FUNCTION
	function ddshort_image_hover($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'style' => 'zoom',
			'icon' => '',
			'align' => '',
		
		), $atts));
		
		//// STARTS OUR OUTPUT
		$return = '<span class="image-hover';
		
		//// ALIGN
		if($align == 'left' || $align == 'right') { $return .= ' align-'.$align; }
		
		/// ICON OR DEFAULT
		if($icon != '') { $return .= '" style="background: #ffffff url('.$icon.') no-repeat 50% 50%;">'; }
		else { $return .= ' image-hover-'.$style.'">'; }
		
		//// CONTENT
		$return .= do_shortcode($content);
		
		//// CLOSES IT
		$return .= '</span>';
		
		return $return;
		
	}
	
	//// IMAGE PRELOAD FUNCTION
	function ddshort_image_preload($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'width' => '',
			'height' => '',
		  	'alt' => '',
		
		), $atts));
		
		//// CHECK WIDTH AND HEIGHT
		if($width != '' || $height != '') {
			
			$return = '<span class="imagePreload" style="width: '.$width.'px; height: '.$height.'px;" title="'.$alt.'">';
			
			$return .= '<span>'.$content.'</span>';
			
			$return .= '</span>';
			
		} else {
			
			$return = '<img src="'.$content.'" />';
			
		}
		
		return $return;
		
	}
	
	//// IMAGE PRELOAD FUNCTION
	function ddshort_lightbox($atts, $content = null) {
		
		extract(shortcode_atts(array(
		
			'link' => '#',
			'id' => '',
		
		), $atts));
		
		//// OUR MARKUP
		$output = '<a href="'.$link.'" rel="prettyPhoto';
		
		//// GALLERY ID
		if($id != '') { $output .= '['.$id.']'; }
		
		$output .= '">'.do_shortcode($content).'</a>';
		
		return $output;
		
	}
	
?>