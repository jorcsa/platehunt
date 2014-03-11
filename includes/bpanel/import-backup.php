<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// DELETE OUR SIDEBAR - POST REQUESTS ONLY
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////



	//// IGNORE NON POST REQUESTS
	if(!$_POST) { exit('Nothing to see here. Please go back.'); }
	
	//// LOADS OUR WP-LOAD
	include('../../../../../wp-load.php');
	
	//// OUR ERROR VARIABLE IS CURRENT EMPTY
	$return['error'] = false;
	$fields_json = explode('%%%', $_POST['fields']);
	
	$backup1 = $fields_json[0];
	$backup2 = $fields_json[1];
	
	$fields = array();
	
	//// LET S STORE OUR BACKUP 1
	if($backup1 = base64_decode($backup1)) {
		
		//// UNSERIALIZES IT
		if($fields = unserialize($backup1)) {
			
			//// GOES THROUGH FIELD BY FIELD
			foreach($fields as $field) {
				
				///// STORES VALUE AGAIN
				update_option($field['name'], $field['value']);
				
			}
			
		} else { $return['error'] = true; $return['message'] = 'Could not decrypt backup string. Error Code 8'; }
		
	} else { $return['error'] = true; $return['message'] = 'Could not decrypt backup string. Error Code 7'; }
	
	//// LET S STORE OUR BACKUP 1
	if($backup2 = base64_decode($backup2)) {
		
		//// UNSERIALIZES IT
		if($fields = unserialize($backup2)) {
			
			//// GOES THROUGH FIELD BY FIELD
			foreach($fields as $field) {
				
				///// STORES VALUE AGAIN
				update_option($field['name'], $field['value']);
				
			}
			
		} else { $return['error'] = true; $return['message'] = 'Could not decrypt backup string. Error Code 8'; }
		
	} else { $return['error'] = true; $return['message'] = 'Could not decrypt backup string. Error Code 7'; }
	
	
	echo json_encode($return);
	

?>