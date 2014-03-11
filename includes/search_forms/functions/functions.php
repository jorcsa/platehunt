<?php

	
	//////////////////////////////////
	//// AJAX STUFF
	//////////////////////////////////
	include('ajax.php');

	
	//////////////////////////////////
	//// ADDS OUR POST TYPE
	//////////////////////////////////
	include('post_type.php');
	
	
	
	//////////////////////////////////
	//// ADDS OUR METABOXES
	//////////////////////////////////
	include('metaboxes.php');
	
	
	function is_if_field_display($status = false, $id) {
		
		if($status) {
			
			echo ' style="display: none;"';
			
		}
		
	}
	
	
	function is_if_field_display_and_class($status = false, $id) {
		
		if($status) {
			
			echo ' class="_sf_field_if_'.$id.'" style="display: none;"';
			
		}
		
	}
	
	
	function is_if_field_display_class($status = false, $id) {
		
		if($status) {
			
			echo ' _sf_field_if_'.$id;
			
		}
		
	}
	

?>