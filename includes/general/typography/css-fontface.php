<?php


	
	//// MAIN HEADER FILE
	$main_font = ddp('fontface_file_main');
	
	//// SECONDARY FILE
	$secondary_font = ddp('fontface_file_secondary');
	
	/// NOW WHICH HEADERS ARE WE APPLYING IT ON
	$header_string = '';
	for($i=1; $i<=6; $i++) {
		
		//// CHECKS IF WE'RE USING IT
		if($i == 3 && ddp('fontface_h3') == 'on') { $header_string .= 'h3:not(.page-slogan), '; }
		else { if(ddp('fontface_h'.$i) == 'on') { $header_string .= 'h'.$i.', '; } }
		
	}
	$header_string = trim($header_string, ', ');
	
	//// IF WE'RE SET TO SET THEM ALL
	if(ddp('fontface_all_headers') == 'on') { $header_string = 'h1, h2, h3:not(.page-slogan), h4, h5, h6'; }
	
	//// OUR MARKUP

?>

	<style type="text/css">
    
    	@font-face { font-family: '<?php echo ddp('fontface_name_main'); ?>'; src: url('<?php echo $main_font ?>'); }
		<?php if($secondary_font) : ?>@font-face { font-family: '<?php echo ddp('fontface_name_main'); ?>'; src: url('<?php echo $secondary_font ?>'); }<?php endif; ?>
		
		<?php echo $header_string; ?> { font-family: '<?php echo ddp('fontface_name_main'); ?>', <?php echo ddp('type_css_main'); ?>; }
    
    </style>