<?php

	
	//// OUR GENERAL STUFF - SIZES & COLORS
	get_template_part('includes/general/typography/css', 'general');
	

	////////////////////////////////////////////////////////
	//// LET'S SEE WHICH MODE THE USER HAS CHOSEN
	$font_mode = ddp('type_type');
	
	/// IF ITS NORMAL CSS
	if($font_mode == 'Default CSS') {
		
		//// SHOWS MARKUP FOR OUR NORMAL CSS HEADERS
		get_template_part('includes/general/typography/css', 'normal');
		
	}
	//// IF IT'S CUFON
	elseif($font_mode == 'Cufon') {
		
		//// SHOWS MARKUP FOR OUR CUFON HEADERS
		get_template_part('includes/general/typography/css', 'cufon');
		
	}
	//// IF IT'S GOOGLE
	elseif($font_mode == 'Google Fonts') {
		
		//// SHOWS MARKUP FOR OUR CUFON HEADERS
		get_template_part('includes/general/typography/css', 'google');
		
	}
	//// IF IT'S FONT-FACE
	elseif($font_mode == '@Font-Face') {
		
		//// SHOWS MARKUP FOR OUR CUFON HEADERS
		get_template_part('includes/general/typography/css', 'fontface');
		
	}
	

?>