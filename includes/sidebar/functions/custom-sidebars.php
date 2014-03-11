<?php


	//// GETS OUR CUSTOM SIDEBARS
	$sidebars = get_option('dd_custom_sidebars');
	
	//// IF THEY EXIST
	if($sidebars) {
	
		//// LOOPS AND REGISTERS THEM
		foreach($sidebars as $sidebar) {
			
			$args = array(
			
				'name' => $sidebar.' &mdash; Custom',
				'id' => us_get_sidebar_id($sidebar),
				'description' => $sidebar.' &mdash; Custom Sidebar',
				'before_widget' => '<div class="sidebar-item">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			
			);
			
			//// REGISTERS IT
			register_sidebar($args);
			
		}
		
	}
	
	
	
	/// FUNCTION TO GENERATE OUR FRIENDLY NAME
	function us_get_sidebar_id($phrase) {
		
		$result = strtolower($phrase);
	
		$result = preg_replace("/[^a-z0-9\s-]/", "", $result);
		$result = trim(preg_replace("/[\s-]+/", " ", $result));
		$result = trim(substr($result, 0, 20));
		$result = preg_replace("/\s/", "-", $result);
	
		return $result;
		
	}


?>