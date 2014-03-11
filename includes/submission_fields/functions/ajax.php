<?php

	

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION UPLOADS FILES
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_field_submission_upload', '_sf_field_submission_upload_function');
	add_action('wp_ajax_nopriv__sf_field_submission_upload', '_sf_field_submission_upload_function');
	
	function _sf_field_submission_upload_function() {
		
		global $wpdb; //Now WP database can be accessed
		global $post;
		
		$image_id = $_POST['data'];
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-field-submission-upload-nonce'))
			die('Busted!');
		
		if(isset($_FILES['_sf_upload_file_submission_'.$_POST['field_id']])) {
			
			$image_filename = $_FILES['_sf_upload_file_submission_'.$_POST['field_id']];
		
			$_FILES['temp']['name'] = $image_filename['name'][0];
			$_FILES['temp']['type'] = $image_filename['type'][0];
			$_FILES['temp']['tmp_name'] = $image_filename['tmp_name'][0];
			$_FILES['temp']['error'] = $image_filename['error'][0];
			$_FILES['temp']['size'] = $image_filename['size'][0];
			
		} else {
			
		
			
		}
		
		$image_filename = $_FILES['temp'];
		
		$override['test_form'] = false; //see http://wordpress.org/support/topic/269518?replies=6
		$override['action'] = 'wp_handle_upload';
		
		if($image_filename['size'] > 5000000) { 
			
			//// THROWS ERROR
			$return['error'] = true;
			$return['message'] = __('You can not upload files bigger than 5mb', 'btoa');
			
			echo json_encode($return);
			
			exit;
			
		}
		
		//// MAKES SURE ITS AN ALLOWED TYPE
		$allowed_types = array('text/plain', 'text/csv', 'text/richtext', 'application/rtf', 'application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow');
		if(!in_array($image_filename['type'], $allowed_types)) {
			
			//// THROWS ERROR
			$return['error'] = true;
			$return['message'] = __('You cannot upload this file type.', 'btoa');
			
			echo json_encode($return);
			
			exit;
			
		}
		
		$uploaded_image = wp_handle_upload($image_filename,$override);
		
		//// IF ISET POST ID WE ATTACH THIS IMAGE TO THE POST
		if(isset($_POST['post_id'])) {
			
			$post_id = $_POST['post_id'];
			
		} else { $post_id = ''; }
		
		/// INSERTS IN DABASE
		$attachment = array(
			'post_mime_type' => $uploaded_image['type'],
			'guid' => $uploaded_image['url'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($image_filename['name'])),
			'post_content' => '',
			'post_parent' => $post_id,
			'post_status' => 'inherit'
		);
		
		$id = wp_insert_attachment($attachment, $uploaded_image['file'], $post_id);
		
		if(!empty($uploaded_image['error'])){
			
			$return['error'] = true;
			$return['message'] = 'Error: ' . $uploaded_image['error'];
			
		} else {
			
			//// LETS RETURN THE FILE NAME AND SIZE IN KILOBYTES
			$return['file'] = array();
			$return['file']['name'] = $_FILES['temp']['name'];
			$return['file']['size'] = $_FILES['temp']['size'];
			$return['file']['type'] = get_post_mime_type($id);
			$return['file']['id'] = $id;
			
		}
		
		echo json_encode($return);
		
		exit;
		
	}


?>