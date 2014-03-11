<?php

	//Our array of options
	
	$typoOpts = array(
	
		array(
		
			'title' => 'General',
			'fields' => array (
			
				array(
				
					'type' => 'info',
					'description' => 'Customize the general typography of your theme.'
				
				),
				
				array(
				
					'type' => 'select',
					'name' => 'font_family',
					'title' => 'Font-Family',
					'description' => 'Font-family over your website general text.',
					'default' => 'Arial, Helvetica, sans-serif',
					'options' => array(
					
						'Arial, Helvetica, sans-serif',
						'Verdana, Geneva, sans-serif',
						'Georgia, \'Times New Roman\', Times, serif',
						'Tahoma, Geneva, sans-serif',
						'\'Trebuchet MS\', Arial, Helvetica, sans-serif',
						'\'Times New Roman\', Times, serif',
						'\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif',
						'Custom'
											
					)
				
				),
				
				array(
				
					'type' => 'text',
					'name' => 'font_family_custom',
					'description' => 'Your custom font-family. Only has effect if the field above is selected "Custom"',
					'title' => 'Custom Font-Family'
				
				),
				
				array(
				
					'type' => 'range',
					'name' => 'text_size',
					'title' => 'Text Size:',
					'description' => 'Description here',
					'default' => '12',
					'range' => '10,18'
				
				),
				
				array(
				
					'type' => 'range',
					'name' => 'line_height',
					'title' => 'Line Height:',
					'description' => 'Description here',
					'default' => '18',
					'range' => '12,30'
				
				),
				
				array(
				
					'name' => 'link_bold',
					'title' => 'Links bold:',
					'type' => 'check',
					'description' => 'Would you like to make all text links bold?'
				
				),
				
				array(
				
					'type' => 'check',
					'name' => 'link_underline',
					'title' => 'Underline Links on Hover:',
					'description' => 'Underline links when users hovers them?'
				
				)
			
			)
		
		),
		
		array(
		
			'title' => 'Headings',
			'fields' => array(
			
				array(
				
					'type' => 'info',
					'description' => 'Customize the typography of your headings'
				
				),
				
				array( 'type' => 'hidden', 'default' => 'Font-Family', 'name' => 'heading_styling' ),
				array( 'type' => 'hidden', 'default' => '', 'name' => 'heading_cufon' ),
				array( 'type' => 'hidden', 'default' => 'Nobile', 'name' => 'heading_google' ),
				array( 'type' => 'hidden', 'default' => '\'Century Gothic\', Helvetica, Arial, sans-serif', 'name' => 'heading_font_family' ),
				array( 'type' => 'hidden', 'default' => '\'Century Gothic\', Helvetica, Arial, sans-serif', 'name' => 'heading_custom' ),
				array( 'type' => 'hidden', 'default' => 'Cufon.replace(\'h1, h2, h3, h4, h5, h6\', {
	hover: true
});', 'name' => 'heading_cufon_adv' ),
				
				array(
				
					'type' => 'font-family'
				
				),
				
				array(
				
					'type' => 'check',
					'name' => 'heading_bold',
					'title' => 'Bold Heading',
					'default' => 'on',
					'description' => 'Make your heading bold or not?'
				
				),
				
				array(
				
					'title' => 'H1 Size',
					'name' => 'h1_size',
					'type' => 'range',
					'default' => '30',
					'description' => 'Font size of your H1 heading.',
					'range' => '10, 100'
				
				),
				
				array(
				
					'title' => 'H2 Size',
					'name' => 'h2_size',
					'type' => 'range',
					'default' => '24',
					'description' => 'Font size of your H2 heading.',
					'range' => '10,100'
				
				),
				
				array(
				
					'title' => 'H3 Size',
					'name' => 'h3_size',
					'type' => 'range',
					'default' => '22',
					'description' => 'Font size of your H3 heading.',
					'range' => '10,100'
				
				),
				
				array(
				
					'title' => 'H4 Size',
					'name' => 'h4_size',
					'type' => 'range',
					'default' => '18',
					'description' => 'Font size of your H4 heading.',
					'range' => '10,100'
				
				),
				
				array(
				
					'title' => 'H5 Size',
					'name' => 'h5_size',
					'type' => 'range',
					'default' => '14',
					'description' => 'Font size of your H5 heading.',
					'range' => '10,100'
				
				),
				
				array(
				
					'title' => 'H6 Size',
					'name' => 'h6_size',
					'type' => 'range',
					'default' => '12',
					'description' => 'Font size of your H6 heading.',
					'range' => '10,100'
				
				)
			
			)
		
		)
		
	);

?>