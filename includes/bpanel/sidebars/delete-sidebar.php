<?php

	//// IGNORE NON POST REQUESTS
	if(!$_POST) { exit('Nothing to see here. Please go back.'); }
	
	//// LOADS OUR WP-LOAD
	include('../../../../../../wp-load.php');
	
	//// OUR ERROR VARIABLE IS CURRENT EMPTY
	$return['error'] = false; $return['deleted'] = 'falseee';
	$sidebar_name = $_POST['sidebars'];
	
	
	
	//// IF IT'S NOT EQUALS TO FALSE
	if(get_option('dd_custom_sidebars')) {
		
		//// LEt'S SEE IF THE NAME EXISTS
		$sidebars = get_option('dd_custom_sidebars');
		$new_sidebars = array();
		foreach($sidebars as $sidebar) {
			
			$addTo = true;
			
			//// IF IT THE SAME NAME AS THE ONE WE'RE DELETING
			foreach($sidebar_name as $del_sidebar) {
				
				if($sidebar == $del_sidebar) { $addTo = false; } //nothing
				
			}
			
			if($addTo == true) { array_push($new_sidebars, $sidebar); }
			
		}
		
	}
	
	// updates the option
	update_option('dd_custom_sidebars', $new_sidebars);
	
	//returns the new sidebars
	$return['newSidebars'] = $new_sidebars;
	
	
	//// RETURNS THE FORM
	echo json_encode($return);
	

?>