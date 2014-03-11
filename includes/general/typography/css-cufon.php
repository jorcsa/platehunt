<?php


	//// OUR MAIN CUFON FILE
	$cufon_main = ddp('cufon_file_main');
	
	/// SECONDARY CUFON FILE
	$cufon_secondary = ddp('cufon_file_secondary');
	
	/// NOW WHICH HEADERS ARE WE APPLYING IT ON
	$header_string = '';
	for($i=1; $i<=6; $i++) {
		
		//// CHECKS IF WE'RE USING IT
		if($i == 3 && ddp('cufon_h3') == 'on') { $header_string .= 'h3:not(.page-slogan), '; }
		else { if(ddp('cufon_h'.$i) == 'on') { $header_string .= 'h'.$i.', '; } }
		
	}
	$header_string = trim($header_string, ', ');
	
	//// IF WE'RE SET TO SET THEM ALL
	if(ddp('cufon_all_headers') == 'on') { $header_string = 'h1, h2, h3:not(.page-slogan), h4, h5, h6'; }
	

?>

	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/cufon-yui.js"></script>
    <script type="text/javascript" src="<?php echo $cufon_main; ?>"></script>
    <?php if($cufon_secondary != '') : ?><script type="text/javascript" src="<?php echo $cufon_secondary; ?>"></script><?php endif; ?>
	
    <script type="text/javascript">
	
		Cufon.replace('<?php echo $header_string; ?>', {
			
			fontFamily: '<?php echo ddp('cufon_family_main'); ?>',
			hover: true
			
		});
		
		<?php if($cufon_secondary != '') : ?>
		Cufon.replace('.page-slogan', {
			
			fontFamily: '<?php echo ddp('cufon_family_secondary'); ?>',
			hover: true
			
		});
		<?php endif; ?>
	
	</script>