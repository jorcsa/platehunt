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
	
	//// LETS UNSERIALISE ALL OUR FIELDS
	$fields = array();
	parse_str($_POST['fields'], $fields);
	
	$return['fields'] = $fields;
	
	$backup = array();
	
	//// LETS LOOP FIELD BY FIELD AND ADD THEM TO OUR ARRAY
	$i = 1; $backup1 = array(); $backup2 = array();
	foreach($fields as $_key => $_field) {
		
		if($i < 98) {
		
			$backup1[] = array(
			
				'name' => $_key,
				'value' => $_field,
			
			);
			
		} else {
		
			$backup2[] = array(
			
				'name' => $_key,
				'value' => $_field,
			
			);
			
		}
		
		$i++; 
		
	}
	
	$backup1_encode = base64_encode(serialize($backup1));
	$backup2_encode = base64_encode(serialize($backup2));
	
	$return['backup'] = $backup1_encode.'%%%'.$backup2_encode;
	
	//$key = 'password to (en/de)crypt';
//$string = 'string to be encrypted';

//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	
	//$return['backup'] = base64_encode(serialize($backup));
	//$return['backup'] = base64_encode(serialize($backup));
	
	//$fields_array = array();
//	//// LOOPS THROUGH SECTIONS
//	foreach($fields_json as $section) {
//		
//		//// LOOPS THROUGJ OUR TABS
//		foreach($section['tabs'] as $tab) {
//			
//			//// LOOPS THOUGH OUR FIELDS
//			foreach($tab['fields'] as $field) {
//				
//				//// NOW LET'S GET THE FIELD VALUE AND CHUCK IN AN ARRAY
//				$thisFieldArray = array($field['name'], ddp($field['name']));
//				$fields_array[] = $thisFieldArray;
//				
//			}
//			
//		}
//		
//	}
//	
//	/// LET'S PUT THE TIMESTAMP AND A VERIFICATION ID IN THE ARRAY
//	$to_encrypt = array(ddp('bpanel_edited_time'), 'aisk8skIId', $fields_array);
//	
//	//// NOW LET'S SERIALIZE AND ENCRYPT OUR ARRAY
//	$return['backup'] = base64_encode(serialize($to_encrypt));
	
	
	
	echo json_encode($return);
	
	exit;
	

?>