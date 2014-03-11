<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR ROUNDED SMALL BUTTONS
	///////////////////////////////////
	///////////////////////////////////
	
	//// HOOK
	add_shortcode('button', 'ddshort_button');
	add_shortcode('link_style', 'ddshort_link_style');
	
	//// FUNCTION
	function ddshort_button($atts, $content = null) {
		
		//// OUR DEFAULTS
		extract(shortcode_atts(array(
		
			'link' => '#',
			'color' => 'blue',
			'type' => '',
			'description' => '',
			'background' => '',
			'title' => '',
			'target' => '',
			'class' => '',
			'id' => '',
			'size' => 'small',
			'onClick' => '',
		
		), $atts));
		
		//// CHECKS THE TYPE AND STARTS OUR OUTPUT
		if($class != '') {
		
		$output = '<a href="'.$link.'" class="button '.$class.'';	
		
		} elseif($type != 'big') {
			
			//// IF NORMAL
			$output = '<a href="'.$link.'" class="button';	
			
			
		} else {
			
			//// IF BIG
			$output = '<a href="'.$link.'" class="big-button';	
			
		}
		
		//// SIZE
		if($size != 'small' && $type != 'big') { $output .= ' button-'.$size.''; }
		
		//// NOW WE CHECK THE COLOR IS BACKGROUND ISN'T SET
		if($background == '') {
			
			//// HAS A DEFINED COLOR
			$output .= ' '.$color.'"';
			
		} else {
			
			//// HAS A DEFINED BACKGROUND
			$output .= '" style="background-color: #'.$background.' !important;"';
			
		}
		
		//// ID ATTRIBUTE
		if($id != '') { $output .= ' id="'.$id.'"'; }
		
		//// onclick
		if($onClick != '') { $output .= ' onclick="'.$onClick.'"'; }
		
		//// TARGET ATTRIBUTE
		if($target != '') { $output .= ' target="'.$target.'"'; }
		
		//// ADDS TITLE
		if($title != '') { $output .= ' title="'.$title.'">'; } else { $output .= '>'; }
		
		//// OUR TEXT
		if($type == 'big') {
			
			$output .= $content.'<span>'.$description.'</span></a>';
			
		} else {
			
			$output .= $content.'</a>';
			
		}
		
		//// RETURNS OUTPUT
		return $output;
		
	}
	
	//// OUR BUTTON
	include('tinyMCE.php');

?>