<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('image_slider', 'ddshort_slider');
	add_shortcode('slide_item', 'ddshort_slider_slide');
	
	//Our Funciton
	function ddshort_slider($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'width' => '900',
			'height' => '300',
		  	'selector' => 'true',
			'autoslide' => '',
		
		), $atts));
		
		//// OUR MAIN CONTAINER HEIGHT DEPENDING ON THE SELECTOR CHOICE
		if($selector == 'false') { $totalHeight = $height; $overShadow = ''; }
		else { $totalHeight = $height+100; $overShadow = '<span class="over-shadow"></span>'; }
		
		//// OUR MARKUP — IF USER HAS SET WIDHT AND HEIGHT
		$return = '<div class="dd-image-slider';
		
		//// IF USER HAS SET AUTOSLIDE
		if($autoslide != '') { $return .= ' sliderauto-'.$autoslide; }
		
		//// CLOSES IT
		$return .= '" style="height: '.$totalHeight.'px; width: '.$width.'px;">
		
			<div class="full-image loading" style="height: '.$height.'px;">
			
				<a href="#"><span class="title"><span></span></span></a>
			
				'.$overShadow.'
				<span class="prev-slide"></span>
				<span class="next-slide"></span>
			
			</div>
			
			<div class="slider-selector"';
			
		//// IF SELECTOR IS HIDDEN
		if($selector == 'false') { $return .= ' style="display: none;">'; }
		else { $return .= '>'; }
		
		$return .= '<ul>'.do_shortcode(trim(strip_tags($content))).'</ul>
		
			</div>
			
			<span class="left-arrow"></span>
			<span class="right-arrow"></span>
	
		</div>';
		
		return $return;
		
	}
	
	//Our Funciton
	function ddshort_slider_slide($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'title' => '',
			'description' => '',
		  	'type' => 'lightbox',
			'link' => '#',
			'width' => '',
			'height' => '',
		
		), $atts));
		
		/// STARTS OUTPUT
		$return = '<li>
		<img src="'.ddTimthumb(trim(strip_tags($content)), 60, 60).'"';
		
		//// IF TITLE
		if($title != '') { $return .= ' title="'.$title.'"'; }
		
		//// IF DESCRIPTION
		if($description != '') { $return .= ' alt="'.$description.'"'; }
		
		//// IF LIGHTBOX
		if($type == 'link') { $return .= ' class="link"'; }
		else { $return .= ' class="lightbox"'; }
		
		//// CLOSES IMG TAG
		$return .= '/>';
		
		//// IF USER SETS WIDTH AND HEIGHT
		if($width != '' && $height != '') { $return .= '<span class="full">'.ddTimthumb(trim(strip_tags($content)), $width, $height).'</span>'; }
		else { $return .= '<span class="full">'.trim(strip_tags($content)).'</span>'; }
		
		//// LINK
		$return .= '<span class="link '.$type.'">'.$link.'</span>';
		
		$return .= '</li>';
		
		return $return;
		
	}
	
	include('tinyMCE.php');

?>