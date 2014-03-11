<?php


	/// OUR MAIN HEADER FONT NAME
	$main_header = ddp('google_font_main');
	
	/// SECONDARY FONT NAME
	$secondary_header = ddp('google_font_secondary');
	
	/// NOW WHICH HEADERS ARE WE APPLYING IT ON
	$header_string = '';
	for($i=1; $i<=6; $i++) {
		
		//// CHECKS IF WE'RE USING IT
		if($i == 3 && ddp('google_h3') == 'on') { $header_string .= 'h3:not(.page-slogan), '; }
		else { if(ddp('google_h'.$i) == 'on') { $header_string .= 'h'.$i.', '; } }
		
	}
	$header_string = trim($header_string, ', ');
	
	//// IF WE'RE SET TO SET THEM ALL
	if(ddp('google_all_headers') == 'on') { $header_string = 'h1, h2, h3:not(.page-slogan), h4, h5, h6'; }
	
	
	
?>

	<link href='http://fonts.googleapis.com/css?family=<?php echo $main_header; ?>' rel='stylesheet' type='text/css'>
    <?php if($secondary_header != '') : ?><link href='http://fonts.googleapis.com/css?family=<?php echo $secondary_header; ?>' rel='stylesheet' type='text/css'><?php endif; ?>

	<style type="text/css">
    
    	<?php echo $header_string; ?> { font-family: '<?php echo $main_header ?>', <?php echo ddp('type_css_main'); ?>; }
    
    </style>