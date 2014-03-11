<?php

	//Save image via AJAX
	add_action('wp_ajax_ddpanel_ajax_upload', 'ddpanel_ajax_upload'); //Add support for AJAX save

	function ddpanel_ajax_upload(){
		
		sleep(1);
		
		global $wpdb; //Now WP database can be accessed
		global $post;
		
		$image_id = $_POST['data'];
		 
		$image_filename = $_FILES[$image_id];
		
		$override['test_form'] = false; //see http://wordpress.org/support/topic/269518?replies=6
		$override['action'] = 'wp_handle_upload';    
		
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
			
			echo 'Error: ' . $uploaded_image['error'];
			
		} else {
			
			if(isset($_POST['post_id'])) {
				
				/// RETURNS AN ARRAY INSTEAD
				echo json_encode(array(
				
					'url' => $uploaded_image['url'],
					'id' => $id,
					'thumb' => ddTimthumb($uploaded_image['url'], 150, 150)
				
				));
				
			} else {
			 
				//update_option($image_id, $uploaded_image['url']);
						 
				echo $uploaded_image['url'];
			
			}
			
		}
				
		die();
	
	}
	
?>