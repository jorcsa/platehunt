<?php

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION OPENS OUR NOTIFICATION BOX
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_load_notification_signup', '_sf_load_notification_signup_function');
	add_action('wp_ajax_nopriv__sf_load_notification_signup', '_sf_load_notification_signup_function');
	
	function _sf_load_notification_signup_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-load-notification-signup-nonce'))
			die('Busted!');
			
		//// LOADS OUR INNER HTML - BEFORE
		include(locate_template('includes/notifications/markup-form.php'));
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION SENDS OUR NOTIFICATION AND STORES IT
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_send_notification_signup', '_sf_send_notification_signup_function');
	add_action('wp_ajax_nopriv__sf_send_notification_signup', '_sf_send_notification_signup_function');
	
	function _sf_send_notification_signup_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-send-notification-signup-nonce'))
			die('Busted!');
			
		//// GETS ALL OUR FIELDS
		$fields = array();
		parse_str($_POST['data'], $fields);
		
		//// MAKES SURE OUR NAME AND EMAIL ARE SET
		if($fields['name'] == '' || $fields['name'] == __('Your Name', 'btoa')) {
			
			//// ERROR TRUE
			$return['error'] = true;
			$return['message'][] = array(
			
				'field' => 'name',
				'message' => __('Please type your name.', 'btoa'),
			
			);
			
		}
		
		//// MAKES SURE OUR NAME AND EMAIL ARE SET
		if($fields['email'] == '' || $fields['name'] == __('Email Address', 'btoa')) {
			
			//// ERROR TRUE
			$return['error'] = 'field';
			$return['message'][] = array(
			
				'field' => 'email',
				'message' => __('Please type your email.', 'btoa'),
			
			);
			
		} else { 
		
			//// MAKES SURE OUR NAME AND EMAIL ARE SET
			if(!is_email($fields['email'])) {
				
				//// ERROR TRUE
				$return['error'] = 'field';
				$return['message'][] = array(
				
					'field' => 'email',
					'message' => __('Please type in a valid email.', 'btoa'),
				
				);
				
			}
		
		}
		
		
		///// IF ALL WENT WELL LET'S INSERT THIS POST INTO OUR DATABASE
		if($return['error'] == false) {
			
			$args = array();
			
			//// LETS START OUR POST
			$args['post_title'] = $fields['name'];
			$args['post_type'] = 'user_notification';
			$args['post_author'] = 1;
			
			//// DATE
			$args['post_date'] = date('Y-m-d H:i:s', time());
			$args['post_date_gmt'] = gmdate('Y-m-d H:i:s', time());
			
			//// PUBLISH IT DIRECTLY
			$args['post_status'] = 'publish';
			
			//// INSERTS IT AND GETS THE ID
			$post_id = wp_insert_post($args);
			
			//// UPDATES THE EMAIL
			update_post_meta($post_id, 'email', $fields['email']);
			
			//// SUBSCRIPTION KEY
			$new_key = randomString('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', 60);
			update_post_meta($post_id, 'key', $new_key);
			
			$all_fields = array();
			
			///// NOW LETS GO THROUGH OUR FIELDS AND STORE THEM AS CUSTOM FIELDS
			foreach($fields as $key => $_field) {
				
				//// IF IT LOOKS LIKE A CUSTOM FIELD
				if(strpos($key, '_sf') !== false) {
					
					/// HEY, THIS LOOKS LIKE A SEARCH FIELD, LETS GET IT AND ADD IT
					$field_id = explode('_', $key);
					$field_id = $field_id[3];
					$field = get_post($field_id);
					$type = get_post_meta($field->ID, 'field_type', true);
					
					$all_fields[] = $field_id;
					
					//// IF ITS A RANGE WE NEED TO SET MINIMUM AND MAXIMUM VALUE
					if($type == 'range') {
						
						/// WE ADD THE FIELD, MINIMUM AND MAXIMUM VALUE
						update_post_meta($post_id, $key, 'on');
						update_post_meta($post_id, $key.'_min', $fields['range_'.$field_id.'_min']);
						update_post_meta($post_id, $key.'_max', $fields['range_'.$field_id.'_max']);
						
					} else {
					
						/// WE ONLY NEED A SINGLE VALUE - UPDATES POST META
						update_post_meta($post_id, $key, $_field);
						
					}
					
				}
				
			}
			
			//// ALSO STORES ALL FIELDS IN THIS FIELD
			update_post_meta($post_id, 'all_fields', $all_fields);
			
		}
		
			
		echo json_encode($return);
		
		exit;
		
	}


?>