<?php


	//// OUR MAIN HEADERS FONT FAMILY & STYLE
	$main_family = ddp('type_css_main');
	
	/// SORTS OUT OUR STYLE
	$main_style = ddp('type_css_main_style');
	switch($main_style) {
		
		case 'Normal':
			$main_weight = 'normal';
			$main_style = 'normal';
			break;
		
		case 'Bold':
			$main_weight = 'bold';
			$main_style = 'normal';
			break;
		
		case 'Bold Italic':
			$main_weight = 'bold';
			$main_style = 'italic';
			break;
		
		case 'Italic':
			$main_weight = 'normal';
			$main_style = 'italic';
			break;
		
	}

	//// OUR SECONDARY HEADERS FONT FAMILY & STYLE
	$secondary_family = ddp('type_css_secondary');
	$secondary_style = ddp('type_css_secondary_style');
	switch($secondary_style) {
		
		case 'Normal':
			$secondary_weight = 'normal';
			$secondary_style = 'normal';
			break;
		
		case 'Bold':
			$secondary_weight = 'bold';
			$secondary_style = 'normal';
			break;
		
		case 'Bold Italic':
			$secondary_weight = 'bold';
			$secondary_style = 'italic';
			break;
		
		case 'Italic':
			$secondary_weight = 'normal';
			$secondary_style = 'italic';
			break;
		
	}
	
	//// OUR MARKUP

?>

	<style type="text/css">
    
    	h1, h2, h3, h4, h5, h6 { font-family: <?php echo $main_family; ?>; font-style: <?php echo $main_style; ?>; font-weight: <?php echo $main_weight; ?>; }
		
		h1 { font-size: <?php echo ddp('type_h1_size'); ?>px; line-height: <?php echo (ddp('type_h1_size')+4); ?>px; }
		h2 { font-size: <?php echo ddp('type_h2_size'); ?>px; line-height: <?php echo (ddp('type_h2_size')+4); ?>px; }
		h3 { font-size: <?php echo ddp('type_h3_size'); ?>px; line-height: <?php echo (ddp('type_h3_size')+4); ?>px; }
		h4 { font-size: <?php echo ddp('type_h4_size'); ?>px; line-height: <?php echo (ddp('type_h4_size')+4); ?>px; }
		h5 { font-size: <?php echo ddp('type_h5_size'); ?>px; line-height: <?php echo (ddp('type_h5_size')+4); ?>px; }
		h6 { font-size: <?php echo ddp('type_h6_size'); ?>px; line-height: <?php echo (ddp('type_h6_size')+4); ?>px; }
    
    </style>