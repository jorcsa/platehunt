<?php

	sleep(1);

	// Ignore non-POST requests
	if ( ! $_POST)
		exit('Nothing to see here. Please go back.');

	// Was this an AJAX request or not?
	$ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	$return['error'] = false;

	// Set the correct HTTP headers
	header('Content-Type: text/'.($ajax ? 'plain' : 'html').'; charset=utf-8');
	
	//// VARIABLES
	$name = isset($_POST['name']) ? trim($_POST['name']) : '';
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	if(!preg_match('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD', $email)) {
		
		$return['error_msg'] = 'Please insert a valid email.<br>';
		$return['error'] = true;
		
	}
	$message = isset($_POST['message']) ? trim($_POST['message']) : '';
	$emailTo = isset($_POST['emailTo']) ? trim($_POST['emailTo']) : '';
	
	
	//// IF THERE ARE NO ERRORS
	if(!$return['error']) {
		
		$subject = 'Contact message from '.$name;
		
		//// HEADERS
		// Additional mail headers
			$headers  = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
			$headers .= 'From: '.$email;
			
		//// LETS MAIL THE SHIT OUT OF IT
		if(mail($emailTo, $subject, $message, $headers)) {  } else {
			
			$return['error'] = true;
			$return['error_msg'] = 'There was an error sending your email. Please contact the site administrator or try again later.'; 
			
		}
		
	}
	
	echo json_encode($return);

?>