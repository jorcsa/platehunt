<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR TOOLTIPS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('audio', 'ddshort_audio');
	add_shortcode('video_html5', 'ddshort_video_html5');
	add_shortcode('video', 'ddshort_video');
	
	//Our Funciton
	function ddshort_audio($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'file' => ''
		
		), $atts));
		
		if($file != '') {
			
			//// CSS FILE
			$return = '<link rel="stylesheet" href="'.get_template_directory_uri().'/includes/bpanel/shortcodes/css/mediaelementplayer.min.css" />';
			
			//// AUDIO ELEMENT
			$return .= '<div class="video_wrapper"><audio id="player2" class="audioPlayer" src="'.$file.'" type="audio/mp3" controls="controls"></audio></div>';
			
			//// jQuery Thingo
			$return .= '<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				
				jQuery("audio").mediaelementplayer();
				
			});
			</script>';
			
			return $return;	
			
		}
		
	}
	
	function ddshort_video_html5($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'poster' => '',
			'file' => '',
			'width' => '660',
			'height' => '360',
			'preload' => 'none',
		
		), $atts));
		
		if($file != '') {
			
			//// CSS FILE
			$return = '<link rel="stylesheet" href="'.get_template_directory_uri().'/includes/bpanel/shortcodes/css/mediaelementplayer.min.css" />';
			
			//// ELEMENT
			$return .= '<div class="video_wrapper" style="width: '.$width.'px; height: '.$height.'px;"><video width="'.$width.'" height="'.$height.'" src="'.$file.'" type="video/mp4" 
	id="player1" poster="'.$poster.'" 
	controls="controls" preload="'.$preload.'"></video></div>';
			
			//// jQuery Thingo
			$return .= '<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				
				jQuery("video").mediaelementplayer();
				
			});
			</script>';
			
			return $return;
			
		}
		
	}
	
	function ddshort_video($atts, $content=null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'type' => 'youtube',
			'video_id' => '',
			'width' => '660',
			'height' => '360',
			'autoplay' => 'false',
		
		), $atts));
		
		$return = '';
		
		if($type == 'youtube') {
			
			$return .= '<div class="video_wrapper" style="width: '.$width.'px; height: '.$height.'px;"><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe></div>';
			
		} elseif($type == 'vimeo') {
			
			$return .= '<div class="video_wrapper" style="width: '.$width.'px; height: '.$height.'px;"><iframe src="http://player.vimeo.com/video/'.$video_id.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
			
		} elseif($type == 'dailymotion') {
			
			$return .= '<div class="video_wrapper" style="width: '.$width.'px; height: '.$height.'px;"><iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe></div>';
			
		}
		
		return $return;
		
	}
	
	include('tinyMCE.php');

?>