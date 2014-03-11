<?php

	
	//// FOOTER COLUMNS
	$footer_columns = explode("\n", ddp('footer_column'));
	$total_footer_folumns = count($footer_columns);
	
	//// REGISTER SIDEBARS
	$i = 0;
	foreach($footer_columns as $column) {
		
		if(($i+1) < $total_footer_folumns) {
			
			//// OPENS OUR COLUMN
			echo '<div class="'.$column.'">';
			
		} else {
			
			//// OPENS OUR COLUMN WITH THE LAST CLASS	
			echo '<div class="'.$column.' last">';
			
		}
			
			//// SHOWS OUR COLUMN'S CONTENT
			dynamic_sidebar('footer-column-'.($i+1));
			
			//// CLOSES OUR COLUMN
			echo '</div>';
		
		$i++;
		
	}


?>