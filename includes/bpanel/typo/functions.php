<?php
	
	////////////////////////////////////////////////
	// INSERTS THE CSS STRING IN OUT WP_HEAD
	////////////////////////////////////////////////
	add_action('wp_head', 'ddPanelTypo');
	add_action('init', 'ddPanelCufon');
	
	function ddPanelTypo() {

		//creates our CSS string
		$css = '';
		$ddpJs = '';
		
		//font family
		if(ddp('font_family') != 'Custom') { 
		
			$css .= 'body, .half-post .post-info { font-family: '.ddp('font_family').'; }';
			
		} else {
			
			$css .= 'body, .half-post .post-info { font-family: '.ddp('font_family_custom').'; }';
			
		}
		
		//text size, line-height
		$css .= ' body { font-size: '.ddp('text_size').'px; line-height: '.ddp('line_height').'px; }';
		
		//links bold
		if(ddp('link_bold') == 'on') { $css .= ' a { font-weight: bold; }'; }
		
		//underline links
		if(ddp('link_underline') == 'on') { $css .= ' a:hover { text-decoration: underline; }'; }
		
		//headings font styling
		//if its font-family
		if(ddp('heading_styling') == 'Font-Family') {
			
			$css .= ' h1, h2, h3, h4, h5, h6, label, #main-menu li a, #nivo-caption .nivo-cats a, #nivo-caption a, .post .post-info, .half-post .post-cats, .pagination li a, #comments .author, .comment-no, #comments ul .collapse-text, #psSocial a, .psTabs li { font-family: '.ddp('heading_font_family').'; }';
			
		} elseif(ddp('heading_styling') == 'Use Default') {  }
		
		elseif(ddp('heading_styling') == 'Cufon') {
			
			//if the advances settings aren't set.
			if(ddp('heading_cufon_adv') == '') {
				
				$ddpJs .= 'Cufon.replace(\'h1, h2, h3, h4, h5, h6, label, #main-menu li a, #nivo-caption .nivo-cats a, #nivo-caption a, .post .post-info, .half-post .post-cats, .pagination li a, #comments .author, .comment-no, #comments ul .collapse-text, #psSocial a, .psTabs li\', { hover: true });';
				
			} else {
				
				$ddpJs .= ddp('heading_cufon_adv');
				
			}
			
		} elseif(ddp('heading_styling') == 'Google Fonts') {
			
			echo '<link href="http://fonts.googleapis.com/css?family='.ddp('heading_google').'" type="text/css" rel="stylesheet">';
			$css .= ' h1, h2, h3, h4, h5, h6, label, #main-menu li a, #nivo-caption .nivo-cats a, #nivo-caption a, .post .post-info, .half-post .post-cats, .pagination li a, #comments .author, .comment-no, #comments ul .collapse-text, #psSocial a, .psTabs li { font-family: '.ddp('heading_google').'; }';
			
		}
		
		$css .= ' h1 { font-size: '.ddp('h1_size').'px; } h2 {font-size: '.ddp('h2_size').'px;  } h3 { font-size: '.ddp('h3_size').'px; } h4 { font-size: '.ddp('h4_size').'px; } h5 { font-size: '.ddp('h5_size').'px; } h6 { font-size: '.ddp('h6_size').'px; }';
		
		if(ddp('heading_bold') == 'on') { $css .= ' h1, h2, h3, h4, h5, h6 { font-weight: bold; }'; } else { $css .= ' h1, h2, h3, h4, h5, h6 { font-weight: normal; }'; }
		
		echo '<style type="text/css"> '.$css.' </style>';
		echo '<script type="text/javascript"> '.$ddpJs.' </script>';
		
	}
	
	//ENQUEUES OUR CUFON FILES
	function ddPanelCufon() {
		
		if(ddp('heading_styling') == 'Cufon') {
			
			 wp_register_script( 'cufon', get_template_directory_uri().'/ddpanel/js/cufon-yui.js');
			 wp_register_script( 'cufon-font', ddp('heading_cufon'));
			 
			 wp_enqueue_script('jquery');
			 wp_enqueue_script('cufon');
			 wp_enqueue_script('cufon-font');
			
		}
		
	}

?>