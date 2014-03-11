<?php


	///////////////////////////////
	//// PROCESSES THE RATING FORM
	///////////////////////////////
	
	add_action('wp_ajax_sf_rating', 'sf_rating_function');
	add_action('wp_ajax_nopriv_sf_rating', 'sf_rating_function');
	
	function sf_rating_function() {
		
		$return = array();
		$return['error'] = false;
		$return['error_fields'] = array();
		
		//// CEHCKS FOR WP NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-rating-nonce'))
			die('Busted!');
			
		//// UNSERIALZIES OUR FIELDS
		$fields = array();
		parse_str($_POST['data'], $fields);
		
		$return['fields'] = $fields;
			
		//// VALDIATES EMAI LADDRESS
		if(!is_email($fields['email'])) {
			
			$return['error'] = true;
			//$return['error_message'] = __('Please type in a valid email address', 'btoa');
			$return['error_fields'][] = array(
			
				'field' => 'post-review-email',
				'message' => __('Please type in a valid email address', 'btoa'),
			
			);
			
		}
		
		///// IF THERE ARE NO ERRORS
		if($return['error'] == false) {
			
			//// NOW LET'S PROCESS THE REVIEW
			
			//// MAKES SURE ITS A VALID PSOT
			$post = get_post($fields['post_parent']);
			if(!$post || $post->post_type != 'spot') {
					
				$return['error'] = true;
				$return['error_message'] = __('An error occurred. We could not find the listing you are trying to review.', 'btoa');
				echo json_encode($return); exit;
				
			}
			
			//// IF WPML IS SET, MAKES SURE WE ADD THIS RATING TO OUR MASTER POST
			global $sitepress;
			if(isset($sitepress)) {
				
				//// DEFAULT LANGUAGE
				$default_language = $sitepress->get_default_language();
				
				$master_post = icl_object_id($fields['post_parent'], 'spot', false, $default_language);
				$fields['post_parent'] = $master_post;
				
			}
			
			//// LETS GET OUR RATING FIELDS AND PROCESS THEM
			$terms = get_terms('rating_field', array('hide_empty' => false));
			$all_ratings = 0;
			if($terms) {
				
				//// GOES FIELD BY FIELD CHECKING FOR VALUES
				foreach($terms as $rating_field) {
					
					//// MAKES SURE ITS A VALUE BWTWEEN 1 AND 5
					if(isset($fields['sf_rating_field_'.$rating_field->term_id])) {
						
						//// IF ITS NOT BETWEEN 1 AND 5
						if($fields['sf_rating_field_'.$rating_field->term_id] < 1 || $fields['sf_rating_field_'.$rating_field->term_id] > 5) {
						
							$return['error'] = true;
							$return['error_message'] = __('Please ensure you have select a rating for all fields', 'btoa');
							echo json_encode($return); exit;
						
						} else {
							
							//// ADDS IT TO OUR OVERALL SO WE CAN DO AN AVERAGE WITH IT
							$all_ratings = $all_ratings+$fields['sf_rating_field_'.$rating_field->term_id];
							
						}
						
					} else {
					
						/// FIELD DOE NOT EXIST
						$return['error'] = true;
						$return['error_message'] = __('Please ensure you have select a rating for all fields', 'btoa');
						echo json_encode($return); exit;
				
					}
					
				}
			
				//// GENERATES OUR OVERALL RATING
				$rating = round(($all_ratings / sizeof($terms)), 2);
				
			} else {
				
				//// ENSURE THE OVERALL RATING IS BETWEEN 1 AND 5
				if($fields['sf_rating'] < 1 || $fields['sf_rating'] > 5) {
					
					$return['error'] = true;
					$return['error_message'] = __('Please ensure you have select a valid rating', 'btoa');
					echo json_encode($return); exit;
					
				}
				
				//// ADDS ONE TO OUR ARRAY SO WE CAN DIVIDE IT LATER
				$rating = $fields['sf_rating'];
				
			}
			
			//// LETS ADD THIS REVIEW AS A POST
			$args = array(
			
				'post_title' => stripslashes(strip_tags($fields['title'])),
				'post_content' => stripslashes(strip_tags($fields['comment'])),
				'post_status' => 'publish',
				'post_author' => 1,
				'post_type' => 'rating',
			
			);
			
			//// IN CASE WE NEED TO HOLD IT FOR REVIEW
			if(ddp('rating_review') == 'on') { $args['post_status'] = 'pending'; }
			
			//// LETS ADD IN OUR POST AND UPDATE THE META
			$review_id = wp_insert_post($args, true);
			
			///// IF WE HAVE SUCCESSFULLY INSERTED THE POST
			if(!is_object($review_id)) {
				
				//// UPDATES THE USER INFO
				update_post_meta($review_id, 'user', $fields['user']);
				update_post_meta($review_id, 'user_email', $fields['email']);
				
				//// UPDATES OVERALL RATING
				update_post_meta($review_id, 'rating', $rating);
				
				//// UPDATES INDIVIDUAL RATINGS
				$terms = get_terms('rating_field', array('hide_empty' => false));
				if(is_array($terms)) { foreach($terms as $single_field) {
					
					$rating_field_id = $single_field->term_id;
					
					///// MAKES SURE WE DO THE RIGHT FIELDS AND NOT ON THE TRANSLATION
					if(isset($sitepress)) {
						
						$rating_field_id = icl_object_id($single_field->term_id, 'rating_field', false, $default_language);
						
					}

					update_post_meta($review_id, 'sf_rating_field_'.$rating_field_id , $fields['sf_rating_field_'.$single_field->term_id]);
					
				} }
				
				//// LETS DO A FULL ON QUERY TO AVOID BUGS. GETS ALL THE REVIEWS TO THIS POST
				$args = array(
				
					'post_type' => 'rating',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'meta_query' => array(
					
						array(
						
							'key' => 'parent',
							'value' => $fields['post_parent'],
						
						)
					
					),
				
				);
				
				//// SUPRESS FILTERS
				if(isset($sitepress)) { $args['suppress_filters'] = TRUE; }
				
				$spot_ratings = new WP_Query($args);
				
				//// IF IT HAS REVIEWS
				if($spot_ratings->have_posts()) {
					
					//// LETS SET SOEM VARIBLAES SO WE CAN GET THE CURRENT RATING AND THE RATING COUNT
					$current_rating = 0;
					$rating_count = 0;
					
					//// GOES THROUGH EACH ONE OF THEM AND SETS UP THE AVERAGE AS WELL AS THE COUNT
					while($spot_ratings->have_posts()) {
						
						$spot_ratings->the_post();
						
						//// UPDATES CURRENT RATING AND RATING COUNT
						$current_rating = $current_rating + get_post_meta(get_the_ID(), 'rating', true);
						$rating_count++;
						
					}
					
					//// UPDATES CURRENT RATING
					$current_rating = round(($current_rating / $rating_count), 2);
					
				} else {
					
					//// SET IS AS 0 SINCE WE HAVE NO REVIEWS FOR THIS POST
					$current_rating = 0;
					$rating_count = 0;
				}
				
				//// IF THE REVIEW IS BEING PUBLISHED STRAIGHT AWAY
				if(ddp('rating_review') != 'on') {
		
					//// DOES THE NEW RATING
					$new_post_rating = round((($current_rating * $rating_count) + $rating) / ($rating_count + 1), 2);
				
					///// NOW WE UPDATE OUR PARENT POST
					update_post_meta($fields['post_parent'], 'rating', $new_post_rating);
					update_post_meta($fields['post_parent'], 'rating_count', ($rating_count + 1));
					
					//// IF WPML IS SET THAT MEANS WE HAVE TO UPDATE OUR TRANSLATIONS AS WELL
					//// THIS WAY WE ENSURE THAT THE SEARCH FUNCTIONALITY WILL WORK WITH TRANSLATIONS TOO
					if(isset($sitepress)) {
						
						_sf_wpml_update_translations_ratings($fields['post_parent']);
						
					}
					
				}
				
				//// PSOT PARENT
				update_post_meta($review_id, 'parent', $fields['post_parent']);
				
				$return['message'] = __('Thank you! Your review has been successfully submitted', 'btoa');
				
				if(ddp('rating_review') == 'on') {
					
					$return['message'] = __('Thank you! Your review has been successfully submitted and an admin will review it shortly.', 'btoa');
					//// SENDS THE USER A MESSAGE SAYING IT'S ALL GOOD
				
					///// IF IT REQUIRES REVIEW WE NEED TO SEND THE ADMIN AN EMAIL
					$message = sprintf2("Dear Admin,
					
This is an automated message to inform you that a review has been submitted for %post_title and requires review.

Please visit to %edit_link to review it.", array(

						'post_title' => get_the_title($fields['post_parent']),
						'edit_link' => get_edit_post_link($review_id),

					));
				
					$subject = sprintf2(__('Review submitted at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
					
					$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
					
					wp_mail(get_option('admin_email'), $subject, $message, $headers);
				
				}
				
			} else {
				
				//// THERE WAS AN ERROR
				$return['error'] = true;
				$return['error_message'] = sprintf2(__('There was an error processing your review. Error: %error', 'btoa'), array('error' => $review_id->get_error_message()));
				echo json_encode($return); exit;
				
			}
			
		}
			
		//// RETURNS DATA
		echo json_encode($return);
		exit;
		
	}


	///////////////////////////////
	//// REPORTS REVIEWS
	///////////////////////////////
	
	add_action('wp_ajax_sf_report_review', 'sf_report_review_function');
	add_action('wp_ajax_nopriv_sf_report_review', 'sf_report_review_function');
	
	function sf_report_review_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// CEHCKS FOR WP NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-report-review-nonce'))
			die('Busted!');
			
		//// MAKES SURE ITS A VALID POST
		if($post = get_post($_POST['post_id'])) {
			
			//// ITS A VALID REVIEW
			if($post->post_type == 'rating') {
				
				///// UPDATES THE META
				update_post_meta($post->ID, 'moderate', 'on');
				
				///// SENDS EMAIL TO ADMIN
				$message = sprintf2(__('Dear Admin,
				
Someone has flagged a review at %site_name.

Please visit %link and review it.', 'btoa'), array(
				
					'site_name' => get_bloginfo('name'),
					'link' => get_permalink(get_post_meta($post->ID, 'parent', true)).'#review-'.$post->ID,
				
				));
				
				$subject = sprintf2(__('Review flagged at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
				
				$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
				
				wp_mail(get_option('admin_email'), $subject, $message, $headers);
				
				$return['message'] = __('Thank you. This review has been flagged and will be reviewed by our team shortly.', 'btoa');
				
			} else { $return['error'] = __('Oops! We could not find the review you are looking for!', 'btoa'); }
			
		} else { $return['error'] = __('Oops! We could not find the review you are looking for!', 'btoa'); }
		
		echo json_encode($return);
		exit;
		
	}


	///////////////////////////////
	//// TRASHES REVIEWS
	///////////////////////////////
	
	add_action('wp_ajax_sf_trash_review', 'sf_report_trash_function');
	add_action('wp_ajax_nopriv_sf_trash_review', 'sf_report_trash_function');
	
	function sf_report_trash_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// CEHCKS FOR WP NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-trash-review-nonce'))
			die('Busted!');
			
		//// IF USER ACN TRASH IT
		if(current_user_can('install_plugins')) {
			
			//// MAKES SURE ITS A VALID POST
			if($post = get_post($_POST['post_id'])) {
				
				//// ITS A VALID REVIEW
				if($post->post_type == 'rating') {
					
					 wp_trash_post($_POST['post_id']);
					
				}
				
			}
		
		} else { $return['error'] = __('Oops! You do not have enough permission to trash this review!', 'btoa'); }
		
		echo json_encode($return);
		exit;
		
	}


	///////////////////////////////
	//// RESTORE REVIEWS
	///////////////////////////////
	
	add_action('wp_ajax_sf_restore_review', 'sf_report_restore_function');
	add_action('wp_ajax_nopriv_sf_restore_review', 'sf_report_restore_function');
	
	function sf_report_restore_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// CEHCKS FOR WP NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-restore-review-nonce'))
			die('Busted!');
			
		//// IF USER ACN restore IT
		if(current_user_can('install_plugins')) {
			
			//// MAKES SURE ITS A VALID POST
			if($post = get_post($_POST['post_id'])) {
				
				//// ITS A VALID REVIEW
				if($post->post_type == 'rating') {
					
					 update_post_meta($post->ID, 'moderate', 'off');
					 
					 $return['message'] = __('Review successfully restored', 'btoa');
					
				}
				
			}
		
		} else { $return['error'] = __('Oops! You do not have enough permission to restore this review!', 'btoa'); }
		
		echo json_encode($return);
		exit;
		
	}


?>