<?php

	
	//// FOOTER COLUMNS
	$footer_columns = explode("\n", ddp('footer_column'));
	$total_footer_folumns = count($footer_columns);
	
	//// REGISTER SIDEBARS
	$i = 0;
	foreach($footer_columns as $column) {
		
		if($i <= $total_footer_folumns) {
			
			//// ARGUMENTS
			$args = array(
			
				'name' => 'Footer Column '.($i+1).' ('.trim($column).')',
				'id' => 'footer-column-'.($i+1),
				'description' => 'Footer Widget Column Number '.($i+1),
				'before_widget' => '<div class="footer-item">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			
			);
			
			//// REGISTERS IT
			register_sidebar( $args );
			
		}
		
		$i++;
		
	}


?>