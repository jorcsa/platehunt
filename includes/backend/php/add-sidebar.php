<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// ULTRASHARP THEME — INCLUDES/BACKEND/PHP/ADD-SIDEBAR.PHP
//
//// ADDS OUR SIDEBAR - POST REQUESTS ONLY
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////



	//// IGNORE NON POST REQUESTS
	if(!$_POST) { exit('Nothing to see here. Please go back.'); }
	
	//// LOADS OUR WP-LOAD
	include('../../../../../../wp-load.php');
	
	//// OUR ERROR VARIABLE IS CURRENT EMPTY
	$return['error'] = false;
	$sidebar_name = $_POST['sidebar_name'];
	
	
	
	//// IF IT'S NOT EQUALS TO FALSE
	if(get_option('dd_custom_sidebars')) {
		
		//// LEt'S SEE IF THE NAME ALREADY EXISTS
		$sidebars = get_option('dd_custom_sidebars');
		foreach($sidebars as $sidebar) {
			
			if($sidebar_name == $sidebar) {
				
				//// error = true
				$return['error'] = true;
				$return['error_msg'] = 'A sidebar with this name already exists.';	
				
			}
			
		}
		
	}
	
	
	if($return['error'] == false) {
		
		//// IF ERRORS ARE EMPTY WE ADD THE SIDEBAR TO THE ARRAY
		if(!get_option('dd_custom_sidebars')) { $sidebars_arr = array(); }
		else { $sidebars_arr = get_option('dd_custom_sidebars'); }
		
		//// ADDS THE SIDEBAR TO THE ARRAY
		array_push($sidebars_arr, $sidebar_name);
		
		//// UPDATES IT
		update_option('dd_custom_sidebars', $sidebars_arr);
		
		$return['sidebar_name'] = $sidebar_name;
		
	}
	
	
	//// RETURNS THE FORM
	echo json_encode($return);
	

?>