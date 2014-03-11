<?php

	
	//////////////////////////////////
	//// ADDS OUR POST TYPE
	//////////////////////////////////
	include('post_type.php');
	
	include('ajax.php');
	
	
	
	//////////////////////////////////
	//// ADDS OUR METABOXES
	//////////////////////////////////
	include('metaboxes.php');
	
	
	//// IN CASE OUR NKEY IS SET
	if(isset($_GET['nkey'])) {
		
		//// GETS A POST WITH THIS KEY
		$args = array(
		
			'post_type' => 'user_notification',
			'post_status' => 'publish',
			'posts_per_page' => '1',
			'meta_query' => array(
			
				array(
				
					'value' => $_GET['nkey'],
					'key' => 'key',
					'compare' => '=',
				
				)
			
			),
		
		);
		
		$keyQ = new WP_Query($args);
		
		if($keyQ->have_posts()) {
			
			//// TRASHES THE POST
			$pid = $keyQ->posts[0];
			wp_trash_post($pid->ID);
			
			//// ADDS AN ACTION TO INFORM THE USER
			add_action('wp_head', create_function( '', '
			
				echo "<script type=\"text/javascript\">
				
					jQuery(window).load(function() {
						
						alert(\"'.sprintf2(__('Thank you %name. You will no longer receive notifications.', 'btoa'), array('name' => $pid->post_title)).'\");
						
					});
				
				</script>";
			
			' ));
			
		}
		
	}
	
	///// CEHCKS FOR NOTIFICATIONS BASED ON POST FIELDS
	function _sf_check_for_user_notifications_matching_spot($post_id) {
		
		$the_post = get_post($post_id);
		
		$current_notification = 1;
		
		//// LETS GO THROUGH NOTIFICATION BY NOTIFICATION AND SEE IF ANY FITS
		$args = array(
		
			'post_type' => 'user_notification',
			'posts_per_page' => -1,
			'post_status' => 'publish',
		
		);
		
		$uQ = new WP_Query($args);
		
		while($uQ->have_posts()) : $uQ->the_post();
			
			//// NOW WE NEED TO SEE IF THE ATTRIBUTES FOR THIS NOTIFICATION MEET THE ONES FOR THIS POST
			$all_field = get_post_meta(get_the_ID(), 'all_fields', true);
			$meets = true;
			
			//// GOES FIELD BNY FIELD AND CHECK IT
			foreach($all_field as $_field) {
				
				/// FIRST CHECKS IF META IS SET TO NOT WASTE PROCESSING POWER
				$this_field_post = get_post_meta($post_id, '_sf_field_'.$_field, true);
				
				$type = get_post_meta($_field, 'field_type', true);
				
				///// IF IT ACTUALLY EXISTS OR IF ITS A TAG
				if($this_field_post != '' || $type == 'text' || ($type == 'dropdown' && get_post_meta($_field, 'dropdown_type', true) == 'categories')) {
							
					
					//// NOW THAT WE KNOW IT EXISTS LETS GET THE TYPE OF FIELD THIS IS SO WE CAN CHECK AGAINST THE SELECTED FIELD
					$notification_field_value = get_post_meta(get_the_ID(), '_sf_field_'.$_field, true);
					
					//// IF IT"S A DROPDOWN OR A DEPENDENT
					if($type == 'dropdown' || $type == 'dependent') {
						
						//// IF IT'S NOT A CATEGORY
						if(get_post_meta($_field, 'dropdown_type', true) == 'custom') {
						
							//// IF THIS NOTIFICATION VALUE IS NOT ON OUR ARRAY, BREAK IT AND SKIP IT
							if(!in_array($notification_field_value, $this_field_post)) { $meets = false; break; }
						
						} else {
							
							//// MAKES SURE THE TAG EXISTS
							$the_cats = get_the_terms($post_id, 'spot_cats'); $spot_cats = array();
							if(is_array($the_cats)) {
								
								//// CREATES OUR ARRAY
								foreach($the_cats as $_cat) { $spot_cats[] = $_cat->term_id; }
								
								//// NOW LET'S SEE IF ANY OF THESE CATEGORIES MATCHES OUR CATEGORIES
								if(!in_array($notification_field_value, $spot_cats)) { $meets = false; break; }
								
							}
							
						}
						
					}
					
					//// IF ITS A MINIMUM VALUE
					if($type == 'min_val') {
						
						//// IF THE POST VALUE IS NOT GREATER THAN OUR REQUIRED VALUE BREAK IT
						if($notification_field_value < $this_field_post) { $meets = false; break; }
						
					}
					
					//// IF ITS A MAXIMUM VALUE
					if($type == 'max_val') {
						
						//// IF THE POST VALUE IS NOT SMALLER THAN OUR REQUIRED VALUE BREAK IT
						if($notification_field_value > $this_field_post) { $meets = false; break; }
						
					}
					
					//// IF ITS A RANGE
					if($type == 'range') {
						
						//// MAKES SURE THE VALUE IS IN BETWEEN OUR VALUES
						$min = get_post_meta(get_the_ID(), '_sf_field_'.$_field.'_min', true);
						$max = get_post_meta(get_the_ID(), '_sf_field_'.$_field.'_max', true);
						
						if($this_field_post > $max) { $meets = false; break; }
						if($this_field_post < $min) { $meets = false; break; }
						
					}
					
					//// IF ITS TEXT
					if($type == 'text') {
						
						//// IF THE POST DOES NOT HAVE THAT TAG
						if(!has_term($notification_field_value, 'spot_tags', $post_id)) { $meets = false; break; }
						
					}
					
				} else {
					
					//// SETS THIS GUY TO FALSE
					$meets = false;
					break;
					
				}
				
			}
				
				
			///// IF MEETS THE REQUIREMENTS, LET'S SCHEDULE THE EMAIL WITH 2 minute DELAYS WITHIN EACH TO AVOID LONG WAITING TIMES
			if($meets == true) {
				
				$exp_date = time() + (($current_notification * 1) * 60);
				wp_schedule_single_event($exp_date, '_sf_notify_user_of_submission', array(get_the_ID(), $post_id));
				
				$current_notification++;
				
			}
			
		endwhile;
		
	}
	
	//// ADDS OUR ACTION FOR USER NOTIFICATIONS
	add_action('_sf_notify_user_of_submission', '_sf_notify_user_of_submission_function', 10, 2);
	
	function _sf_notify_user_of_submission_function($not_id, $post_id) {
		
		//// LETS GET THE USERS EMAIL ADDRESS AND SUBMISSION
		//$user = get_post($not_id);
		//$post = get_post($post_id);
		
		$unsubscribe_link = add_query_arg(array('nkey' => get_post_meta($not_id, 'key', true)), home_url());
		
		//// SENDS OUT EMAIL
		$message = sprintf2(__('Dear %user,
		
A new submission matching your chosen criteria has been published at %site_name.

Visit %link to check it out!

If you do not wish to be notified anymore please visit %unsubscribe_link

Kind regards,
The %site_name team.', 'btoa'), array(
		
			'site_name' => get_bloginfo('name'),
			'user' => get_the_title($not_id),
			'link' => get_permalink($post_id),
			'unsubscribe_link' => $unsubscribe_link,
		
		));
		
		$subject = sprintf2(__('%site_name: Matching Submission', 'btoa'), array('site_name' => get_bloginfo('name')));
		
		$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
		
		$to = get_post_meta($not_id, 'email', true);
		
		//// SENDS EMAIL
		wp_mail($to, $subject, $message, $headers);
		
	}


?>