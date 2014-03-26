<?php
	
	
	//// INCLUDES OUR TOOLTIP CLASS
	include('class-sf_tooltip.php');
	
	
	//// REGISTERS OUR DEFAULT PAGE SIDEBAR
	$args = array(
	
		'name' => 'Listings Sidebar',
		'id' => 'listings',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	
	);
	
	register_sidebar($args);
	
	
	//// REGISTERS OUR DEFAULT SPOT SIDEBAR
	$args = array(
	
		'name' => 'Spots Sidebar',
		'id' => 'spot-sidebar',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	
	);
	
	register_sidebar($args);

	
	//////////////////////////////////
	//// ADDS OUR POST TYPE
	//////////////////////////////////
	include('post_type.php');
	include('ajax.php');

	
	//////////////////////////////////
	//// ADDS OUR POST TYPE
	//////////////////////////////////
	include('taxonomy.php');
	
	
	
	//////////////////////////////////
	//// ADDS OUR METABOXES
	//////////////////////////////////
	include('metaboxes.php');
	
	
	
	//////////////////////////////////
	//// ADDS FIELDS FOR OUR USERS
	//////////////////////////////////
	include('user.php');



	//// GETS LATITUDE
	function get_spot_latitude($post_id) {
		
		return get_post_meta($post_id, 'latitude', true);
		
	}

	//// GETS LONGITUDE
	function get_spot_longitude($post_id) {
		
		return get_post_meta($post_id, 'longitude', true);
		
	}

	//// GETS PIN
	function get_spot_pin($post_id) {
		
		//// TRIES TO GET CUSTOM
		$pin = get_post_meta($post_id, 'pin', true);
		
		//// IF NO CUSTOM GET BY CATEGORY
		if($pin == '') {
			
			/// LOOPS EACH CATEGORY UNTIL A PIN IS FOUND - THAT IS NOT DEFAULT
			if($terms = get_the_terms($post_id, 'spot_cats')) {
				
				foreach($terms as $_term) {
					
					//// IF CUSTOM IS NOT EMPTY BREAK IT HERE, OTHERWISE USE DEFAULT
					$this_term_pin_custom = getTermCustomField($_term->term_id, 'custom_pin');
					if(!empty($this_term_pin_custom)) { $pin = $this_term_pin_custom; break; }
					
					//// IF THE DEFAULT PIN IS NOT DEFAULT WE BREAK IT HERE
					$this_term_pin_default = getTermCustomField($_term->term_id, 'default_pin');
					if($this_term_pin_default == '' || $this_term_pin_default == 'default') {  }
					else { $pin = get_template_directory_uri().'/images/pins/'.$this_term_pin_default.'.png'; break; }
					
					//// ELSE JUST KEEP GOING
					
				}
				
			}
			
		}
		
		//// IF OUR PIN IS EMPTY OR IS DEAFULT WE GET IR FROM THE BPANEL
		if(empty($pin) || $pin == 'default' || $pin == '') {
			
			$pin = ddp('map_default_pin');
			
		}
		
		return $pin;
		
	}
	
	
	//// GETS POST STATUS
	function get_spot_status($post_id) {
		
		$the_spot = get_post($post_id);
		
		switch($the_spot->post_status) {
			
			case 'publish':
				return '<span class="published">'.__('Published', 'btoa').'</span>';
				break;
			
			case 'pending':
				return '<span class="pending">'.__('Awaiting Approval', 'btoa').'</span>';
				break;
			
			case 'draft':
				return '<span class="draft">'.__('Draft', 'btoa').'</span>';
				break;
			
		}
		
	}
	
	//// ADDS OUR NEW ROLE
	$role = get_role('submitter');
	if(!$role) {
		
		//// LET'S CREATE OUR NEW ROLE
		add_role('submitter', __('Submitter', 'btoa'), array(
		
			//// ADDS OUR CAPABILITIES
			
			///// USER CAN'T REALLY DO ANYTHING - AT LEAST NOT VIA BACKEND
		
		));
		
	}
	
	
	///// DISABLES ADMIN BAR FOR USERS
	if(is_user_logged_in() && !current_user_can('edit_posts')) {
		
		add_filter('show_admin_bar', '__return_false');
		
	}
	
	
	///// WHEN WE PUBLISH A POST THAT WAS PENDING REVIEW WE SEND AN EMAIL TO THE USER
	add_action('transition_post_status', '_sf_send_user_publish_note', 10, 3);
	
	function _sf_send_user_publish_note($new_status, $old_status, $post) {
		
		//// IF ITS A SPOT
		if($post->post_type == 'spot') {
			
			$user = get_user_by('id', $post->post_author);
			
			//// IF THIS POST IS BEING PUBLISHED AND THE AUTHOR IS A SUBMITTER
			if($old_status != 'publish' && $new_status == 'publish' && isset($user->caps['submitter'])) {
				
				//// SENDS AN EMAIL SAYING HIS POST HAS BEEN SUBMITTED
				$message = sprintf2(__("Dear %user,
				
This is to inform you that your submission %title at %site_name has been approved and it is now published.

You can view it here at %link

Kind regards,
the %site_name team.", 'btoa'), array(
			
					'user' => $user->display_name,
					'title' => $post->post_title,
					'site_name' => get_bloginfo('name'),
					'link' => get_permalink($post->ID),
				
				));
				
				$subject = sprintf2(__('Submission approved at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
				
				$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
				
				wp_mail($user->user_email, $subject, $message, $headers);
				
			}
			
			///// IF ITS A SPOT
			if($post->post_type == 'spot') {
				
				if(ddp('future_notification') == 'on' && $old_status != 'publish' && $new_status == 'publish') {
					
					//// ALSO CHECKS FOR USER NOTIFICATIONS FOR MATCHING CRITERIA
					if(function_exists('_sf_check_for_user_notifications_matching_spot')) { _sf_check_for_user_notifications_matching_spot($post->ID); }
					
				}
			
				//// IF ITS BEING PUBLISHED AND WE HAVE AN EXPIRY DATE SET
				if($old_status != 'publish' && $new_status == 'publish' && ddp('submission_days') != '' && ddp('submission_days') != '0') {
					
					//// SETS UP OUR CRON JOB TO PUT IT BACK TO PENDING IN X AMOUNT OF DAYS
					_sf_set_spot_expiry_date($post);
					
				}
			
				//// IF ITS BEING PUBLISHED AND WE HAVE AN EXPIRY DATE SET FOR OUR FEATURED SUBMISSION - AND ITS INDEED FEATURED
				if($old_status != 'publish' && $new_status == 'publish' && ddp('price_featured_days') != '' && ddp('price_featured_days') != '0' && get_post_meta($post->ID, 'featured', true) == 'on') {
					
					//// SETS UP OUR CRON JOB TO PUT IT BACK TO NORMAL SUBMISSION AFTER X DAYS
					_sf_set_spot_expiry_date_featured($post);
					
				}
			
			}
		
		}
		
		
	}
	
	
	///// LETS ADD EVENTS FOR OUR EXPIRATION AND FEATURED SELECTION EXPIRE
	add_action('save_post', '_sf_execute_post_expiration_dates', 10, 1);
	
	function _sf_execute_post_expiration_dates($post_id) {
		
		if(!$post = get_post($post_id)) { return $post_id; }
		
		//// MAKES SURE IT'S A SPOT
		if($post->post_type == 'spot') {
			
			//// MAKES SURE WE ARE PUBLISHING THIS LISTING
			if($post->post_status == 'publish') {
				
				//// LETS CHECK FOR THE EXPIRY DATE SO WE CAN SET AN EVENT FOR IT
				if(get_post_meta($post->ID, 'expiry_date', true) != '') {
					
					/// WE HAVE AN EXPIRY DATE, SO LET'S SET A CRON TO CHECK FOR IT
					_sf_set_spot_expiry_date_new($post);
					
				}
				
				///// LET'S CHECKOUT FOR THE EXPIRY DATE FOR OUR FEATURED SUBMISSION
				if(get_post_meta($post->ID, 'featured_payment_expire', true) != '') {
					
					/// WE HAVE AN EXPIRY DATE, SO LET'S SET A CRON TO CHECK FOR IT
					_sf_set_spot_expiry_date_featured_new($post);
					
				}
				
			}
			
		}
		
		return $post_id;
		
	}
	
	
	///// SETS EXPIRY DATE FOR THIS SPOT - BY DEFAULT ACCORDING TO THE bPANEL
	function _sf_set_spot_expiry_date($post) {
		
		///// FIRSTLY LET'S ADD A METABOX FOR OUR EXPIRY DATE
		$exp_date = time() + (ddp('submission_days') * (60*60*24));
		
		$midnight_time = $exp_date;
		
		update_post_meta($post->ID, 'expiry_date', $midnight_time);
		
		///// SETS UP OUR CRON JOB
		wp_schedule_single_event($midnight_time, 'expire_spot_submission', array($post->ID, $post->post_title, $post->post_author, ''.$midnight_time.''));
		
	}
	
	
	///// SETS EXPIRY DATE FOR THIS SPOT
	function _sf_set_spot_expiry_date_new($post) {
		
		//// LETS GET THE EXPIRY DATE AND MAKE SURE IT'S IN THE FUTURE
		if(is_object($post)) { if($post->post_type == 'spot') {			
			
			$exp_date = get_post_meta($post->ID, 'expiry_date', true);
			$now = time();
			
			//// IF ITS IN THE FUTURE
			if($exp_date > $now) {
				
				//// SCHEDULE EVENT
				wp_schedule_single_event($exp_date, 'expire_spot_submission', array($post->ID, $post->post_title, $post->post_author, $exp_date));
				
			}
			
		} }
		
	}
	
	
	///// SETS EXPIRY DATE FOR THIS SPOT - BY DEFAULT ACCORDING TO THE bPANEL
	function _sf_set_spot_expiry_date_featured($post) {
		
		///// FIRSTLY LET'S ADD A METABOX FOR OUR EXPIRY DATE
		$exp_date = time() + (ddp('price_featured_days') * (60*60*24));
		
		$midnight_time = strtotime(date('d-m-Y', $exp_date));
		
		update_post_meta($post->ID, 'featured_payment_expire', $midnight_time);
		
		///// SETS UP OUR CRON JOB
		wp_schedule_single_event($midnight_time, 'expire_spot_featured', array($post->ID, $post->post_title, $post->post_author, ''.$midnight_time.''));
		
	}
	
	
	///// SETS EXPIRY DATE FOR THIS SPOT
	function _sf_set_spot_expiry_date_featured_new($post) {
		
		//// LETS GET THE EXPIRY DATE AND MAKE SURE IT'S IN THE FUTURE
		if(is_object($post)) { if($post->post_type == 'spot') {			
			
			$exp_date = get_post_meta($post->ID, 'featured_payment_expire', true);
			$now = time();
			
			//// IF ITS IN THE FUTURE
			if($exp_date > $now) {
				
				//// SCHEDULE EVENT
				wp_schedule_single_event($exp_date, 'expire_spot_featured', array($post->ID, $post->post_title, $post->post_author, $exp_date));
				
				//// MAKES SURE SPOT IS FAETURED 
				update_post_meta($post->ID, 'featured', 'on');
				
			}
			
		} }
		
	}
	
	///// THIS FUNCTION AND ACTION EXPIRES THE SPOT
	add_action('expire_spot_submission', 'expire_spot_submission_function', 10, 4);
	
	function expire_spot_submission_function($post_id, $post_title, $author, $exp_date) {
		
		if($post = get_post($post_id)) {
			
			if($post->post_status != 'publish') { return false; }
		
			//// LETS MAKE SURE THE TIME FOR THIS LISTINGS HAS PAST
			$now = time();
			$expiry = get_post_meta($post->ID, 'expiry_date', true);
			
			if($now >= $expiry) {
				
				//// LET'S CHECK FOR RECURRING PAYMENTS
				if(_sf_recurring_payments_submission($post_id)) { return true; }
				
				//// MAKES THE SPOT PENDING AGAIN
				$args = array();
				$args['ID'] = $post_id;
				$args['post_status'] = 'draft';
				
				///// LET'S CHECK FOR OUT CUSTOM FIELDS
				$cart_meta = _sf_check_cart_meta($post_id);
				
				///// PUTS PENDING AGAIN
				wp_update_post($args);
						
				//// UPDATES CART META
				if(count($cart_meta) > 0) { _sf_update_cart_meta($post_id, $cart_meta); }
				
				//// UPDATES OUR PAYMENT - SO MAKE SURE USER HAS TO PAY AGAIN
				update_post_meta($post_id, 'price_submission_payment', '');
				
				///// UPDATES POST EXPIRY DATE (META)
				update_post_meta($post_id, 'expiry_date', '');
				
				$user = get_user_by('id', $author);
				
				//// SENDS USER AN EMAIL
				$message = sprintf2(__("Dear %user,
				
This message is to inform that you submission %title at %site_name has expired.
		
Your submission has been put back to draft and you can login at any time and resubmit it. All your additionals have been saved.
		
Please visit %site_link and resubmit it!
		
Kind regards,
The %site_name team.", 'btoa'), array(
		
					'user' => $user->display_name,
					'title' => $post_title,
					'site_name' => get_bloginfo('name'),
					'site_link' => home_url(),
		
				));
				
				$subject = sprintf2(__('Submission expired at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
				
				$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
				
				//// SENDS EMAIL
				wp_mail($user->user_email, $subject, $message, $headers);
			
			}
			
		}
		
	}
	
	///// THIS FUNCTION EXPIRES FEATURED SELECTION
	add_action('expire_spot_featured', 'expire_spot_featured_function', 10, 4);
	
	function expire_spot_featured_function($post_id, $post_title, $author, $exp_date) {
		
		if($post = get_post($post_id)) {
			
			if($post->post_status != 'publish') { return false; }
		
			//// LETS MAKE SURE THE TIME FOR THIS LISTINGS HAS PAST
			$now = time();
			$expiry = get_post_meta($post->ID, 'featured_payment_expire', true);
			
			if($now >= $expiry) {
				
				//// LET'S CHECK FOR RECURRING PAYMENTS
				if(_sf_recurring_payments_featured($post_id)) { return true; }
				
				//// REMOVES FEATURED FROM IT
				update_post_meta($post_id, 'featured', '');
				
				///// UPDATES POST EXPIRY DATE (META)
				update_post_meta($post_id, 'featured_payment_expire', '');
				
				///// REMOVE THE PAYMENT AS WELL
				update_post_meta($post_id, 'price_featured', '');
				
				$user = get_user_by('id', $author);
				
				//// SENDS USER AN EMAIL
				$message = sprintf2(__("Dear %user,
				
This is an automated message to inform you that the featured selection for your listing %title, has expired.

If you wish to feature your listing again, please log in at our website and re-enable it.
		
Kind regards,
The %site_name team.", 'btoa'), array(
		
					'user' => $user->display_name,
					'title' => $post_title,
					'site_name' => get_bloginfo('name'),
					'site_link' => home_url(),
		
				));
				
				$subject = sprintf2(__('Featured selection expired at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
				
				$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
				
				//// SENDS EMAIL
				wp_mail($user->user_email, $subject, $message, $headers);
				
				die('a');
			
			}
			
		}
		
	}
	
	
	////////// THIS FUNCTION GETS ARGUMENTS FOR OUR LOOP
	function _sf_get_listing_args($post) {
		
		global $paged;
		
		//// STARTS BASIC ARGUMENTS
		$args = array(
		
			'post_type' => 'spot',
			'meta_query' => array(),
			'tax_query' => array(),
			'posts_per_page' => _sf_get_posts_per_page(),
			'paged' => $paged,
		
		);
		
		///// IF IT'S A CATEGORY PAGE
		if(is_tax('spot_cats')) { 
		
			$this_tax = get_term_by('name', single_cat_title('', false), 'spot_cats');
		
			$args['tax_query'][] = array(
			
				'taxonomy' => 'spot_cats',
				'terms' => $this_tax->term_id,
				'field' => 'ID',
			
			);
		
		}
		
		///// IF IT'S A TAG PAGE
		if(is_tax('spot_tags')) { 
		
			$this_tax = get_term_by('name', single_cat_title('', false), 'spot_tags');
		
			$args['tax_query'][] = array(
			
				'taxonomy' => 'spot_tags',
				'terms' => $this_tax->term_id,
				'field' => 'ID',
			
			);
		
		}
		
		if(isset($post['p_ids'])) { $post_ids = $post['p_ids']; }
		if(!is_array($post['p_ids'])) { 
			
			//// WE HAVE COMMAS IN IT, LET'S EXPLODE IT
			if(strpos($post['p_ids'], ',') !== false) {
				
				$post_ids = explode(',', $post['p_ids']);
				
			}
		
		}
		
		//// CHECKS IF WE ARE GETTING OLDEST FIRST
		if(_sf_get_list_sort() == 'oldest') {
			
			//// SETS OUR ORDER BY
			$args['order'] = 'ASC';
			
		}
		
		///// IF WE HAVE AN UNDERSCORE, WHICH MEANS WE ARE SORTING BY A FIELD
		if(strpos(_sf_get_list_sort(), '_')) {
			
			global $wpdb;
		
			//// LETS GET THE FIELD WE ARE SORTING BY
			$field_slug = array_shift(explode('_', _sf_get_list_sort()));
			$order = array_pop(explode('_', _sf_get_list_sort()));
			$field_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$field_slug."' AND post_type = 'search_field'");
			
			//// IF WE HAVE FOUND THE FIELD
			if(is_numeric($field_id)) {
				
				$search_field = get_post($field_id);
				
				//// BUILDS UP THE NEW QUERY
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = '_sf_field_'.$field_id;
				
				//// IF ITS LOW TO HIGH
				if($order == 'low') { $args['order'] = 'ASC'; }
				else { $args['order'] = 'DESC'; }
				
			}
		
		}
		
		if(!isset($post_ids)) {

			///// CHECKS FOR SEARCH FIELDS BUT PNLY IF WE DONT HAVE ALREADY A LIST OF POST IDS
			$fields = $_GET;
			if (!is_array($fields)) { $fields = array(); }

// DAHERO #1667462 STRT
			if ($fields['glat'] != '' &&
				$fields['glng'] != '' &&
				($lat_range = explode('|', $fields['glat'])) &&
				($lng_range = explode('|', $fields['glng'])) &&
				count($lat_range) * count($lng_range) == 4 &&
				abs($lat_range[0]) <= 90 && abs($lat_range[1]) <= 90 &&
				abs($lng_range[1]) <= 180 && abs($lng_range[1]) <= 180 // &&
//				$fields['_sf_enable_radius_search'] != 'true'
			) {
				if ($lat_range[0] > $lat_range[1]) $lat_range = array_reverse($lat_range);
				if ($lng_range[0] > $lng_range[1]) $lng_range = array_reverse($lng_range);
/*
				///// LETS CHECK FOR SENSITIVITY
				if (get_post_meta($field->ID, 'google_places_sensitivity', true) != '') {
					$sensitivity = get_post_meta($field->ID, 'google_places_sensitivity', true);
					//// IF ITS A NUMBER
					if(is_numeric($sensitivity) || is_float($sensitivity)) {
						//// IF WE ARE USING MILES LET'S PUT THAT TO KILOMETREST
						if(ddp('geo_distance_type') == 'Miles') { $sensitivity = $sensitivity/0.62137; }
						//// LET'S TRANSFORM THIS SENSITIVITY IN LATITUDE
						$lat_sensitivity = $sensitivity / 110.54;
						$lng_sensitivity = $sensitivity / (111.320*cos($lng_range[0]));
						///// LETS CHANGE OUR VARIABLES
						$lat_range[0] = $lat_range[0] - $lat_sensitivity;
						$lat_range[1] = $lat_range[1] + $lat_sensitivity;
						$lng_range[0] = $lng_range[0] - $lng_sensitivity;
						$lng_range[1] = $lng_range[1] + $lng_sensitivity;
					}
				}
*/
				//// LETS DO OUR QUERY
				$args['meta_query'][] = array(
					'key' => 'latitude',
					'value' => $lat_range[0],
					'compare' => '>=',
					'type' => 'DECIMAL',
				);
				$args['meta_query'][] = array(
					'key' => 'latitude',
					'value' => $lat_range[1],
					'compare' => '<=',
					'type' => 'DECIMAL',
				);
				//// LETS DO OUR QUERY
				$args['meta_query'][] = array(
					'key' => 'longitude',
					'value' => $lng_range[0],
					'compare' => '>=',
					'type' => 'DECIMAL',
				);
				$args['meta_query'][] = array(
					'key' => 'longitude',
					'value' => $lng_range[1],
					'compare' => '<=',
					'type' => 'DECIMAL',
				);
			}
// DAHERO #1667462 STOP
			
			//// GOES THROUGH EACH GET AND SEE IF IT"S A FIELD
			foreach($fields as $field => $value) {
				
				///// IF ITS A SEARCH FIELD
				if($this_field = get_posts(array('name' => $field, 'post_type' => 'search_field', 'post_status' => 'publish', 'numberposts' => '1'))) {
					
					$this_field = array_pop($this_field);
					///// FIELD TYPE
					$field_type = get_post_meta($this_field->ID, 'field_type', true);
					
					///// IF IT'S A DROPDOWN
					if($field_type == 'dropdown') {
						//// IF WE ARE USING CATEGORIES
						if(get_post_meta($this_field->ID, 'dropdown_type', true) == 'categories') { 
							/// FIRST LETS MAKE SURE THE TAXONOMY EXISTS
							if($this_tax = get_term_by('slug', $value, 'spot_cats')) {
								//// ADDS TO OUR QUERY
								$args['tax_query'][] = array(
									'taxonomy' => 'spot_cats',
									'field' => 'slug',
									'terms' => $value,
								);
							}
						} else {
							//// MAKES SURE THE VALUE EXISTS
							if(_sf_dropdown_value_exists($this_field->ID, $value)) {
								///// ADDS IT TO OUR QUERY
								$args['meta_query'][] = array(
									'key' => '_sf_field_'.$this_field->ID,
									'value' => $value,
									'compare' => 'LIKE',
								);
							}
						}
					} //// ENDS IF DROPDOWN
					
					///// IF IT'S A DEPENDENT
					if($field_type == 'dependent') {
						$parent_id = get_post_meta($this_field->ID, 'dependent_parent', true);
						//// IF THE DEPENDENTS PARENT IS A CATEGORY
						if(get_post_meta($parent_id, 'dropdown_type', true) == 'categories') {
							/// FIRST LETS MAKE SURE THE TAXONOMY EXISTS
							if($this_tax = get_term_by('slug', $value, 'spot_cats')) {
								//// ADDS TO OUR QUERY
								$args['tax_query'][] = array(
									'taxonomy' => 'spot_cats',
									'field' => 'slug',
									'terms' => $value,
								);
							}
						} else {
							//// MAKES SURE THE VALUE EXISTS
							if(_sf_dependent_value_exists($this_field->ID, $value)) {
								///// ADDS IT TO OUR QUERY
								$args['meta_query'][] = array(
									'key' => '_sf_field_'.$this_field->ID,
									'value' => $value,
									'compare' => 'LIKE',
								);
							}
						}
					} // ENDS IF DEPENDENT
					
					///// IF IT'S A RANGE
					if($field_type == 'range') {
						//// OUR MAXIMUM VALUE FIRST
						if(isset($fields[$field.'_max'])) {
							//// IF MAXIMUM FIELD IS SMALLER THAN OUR MAXIMUM
							if($fields[$field.'_max'] <= get_post_meta($this_field->ID, 'range_maximum', true)) {
								//// IF OUR MINIMUM IS GREATER THAN THE MAXIMUM
								if($fields[$field.'_min'] >= get_post_meta($this_field->ID, 'range_minimum', true)) {
									///// ADDS IT TO OUR QUERY
									$args['meta_query'][] = array(
										'key' => '_sf_field_'.$this_field->ID,
										'value' => array($fields[$field.'_min'], $fields[$field.'_max']),
										'compare' => 'BETWEEN',
										'type' => 'NUMERIC',
									);
								}
							}
						}
					} // ENDS IF RANGE
					
					///// IF IT'S A MINIMUM VALUE
					if($field_type == 'min_val' && is_numeric($value)) {
						///// ADDS IT TO OUR QUERY
						$args['meta_query'][] = array(
							'key' => '_sf_field_'.$this_field->ID,
							'value' => $value,
							'compare' => '>=',
							'type' => 'NUMERIC',
						);
					} // ENDS IF MINIMUM VALUE
					
					///// IF IT'S A MAXIMUM VALUE
					if($field_type == 'max_val' && is_numeric($value)) {
						///// ADDS IT TO OUR QUERY
						$args['meta_query'][] = array(
							'key' => '_sf_field_'.$this_field->ID,
							'value' => $value,
							'compare' => '<=',
							'type' => 'NUMERIC',
						);
					} // ENDS IF MINIMUM VALUE
					
					///// IF IT'S A CHECK FIELD
					if($field_type == 'check' && $value == true) {
						///// ADDS IT TO OUR QUERY
						$args['meta_query'][] = array(
							'key' => '_sf_field_'.$this_field->ID,
							'value' => 'on',
							'compare' => '==',
						);
					} // ENDS IF CHECKFIELD
					
					///// IF IT'S A KEYWORD
					if($field_type == 'text') {
						///// IF ITS A VALID TAG
						if($term = get_term_by('slug', $value, 'spot_tags')) {
							//// ADDS IT TO OUR QUERY
							$args['tax_query'][] = array(
								'terms' => $value,
								'field' => 'slug',
								'taxonomy' => 'spot_tags',
							);
						}
					} // ENDS IF KEYWORD

				} /// ENDS IF A SEARCH FIELD
			} //// ENDS FOREACH
		} //// ENDS IF WE DONT HAVE A LIST OF POST IDS
			
		if(isset($post_ids)) { $args['post__in'] = $post_ids; }
		
		//echo '<pre>'; print_r($args); exit;
		
		//////////////////////////////////////////////////////
		//// IF WE ARE ORDERING BY DISTANCE
		//////////////////////////////////////////////////////
		
		if(_sf_get_list_sort() == 'closest') {
			
			/// IF THE ADMIN AHS ENABLED IT
			if(ddp('map_geolocation_sort')) {
				
				///// IF WE CAN GET OUR LATITUDE AND LONGITUDE COOKIE
				if(isset($_COOKIE['user_latitude']) && isset($_COOKIE['user_longitude'])) {
					
					$latitude = $_COOKIE['user_latitude'];
					$longitude = $_COOKIE['user_longitude'];
				
					global $wpdb;
					
					//// IF WE HAVE A LIST OF POST IDS
					if(!isset($post_ids)) { $post_ids = array(); }
					if(!is_array($post_ids)) { $post_ids = array(); }
					
					//// MAEKS SURE WE DONT HAVE ANY INVALID POST IDS IN THERE
					$i = 0; foreach($post_ids as $single_id) { if(!is_numeric($single_id) || $single_id == '') { unset($post_ids[$i]); $i++;  } }
					
					//// LET'S DO A CUSTOM QUERY TO RETURN ALL POSSIBLE ITEMS BY DISTANCE
					$distance_query_string = "
					
						SELECT
							{$wpdb->prefix}posts.ID,
							latitude.meta_value as latitude,
							longitude.meta_value as longitude,
							6371 * acos( cos( radians({$latitude}) ) * cos( radians( latitude.meta_value ) ) * cos( radians ( longitude.meta_value ) - radians({$longitude}) ) + sin( radians({$latitude}) ) * sin( radians ( latitude.meta_value ) ) )  as 'distance'
							
						FROM 
							{$wpdb->prefix}postmeta as latitude,
							{$wpdb->prefix}postmeta as longitude,
							{$wpdb->prefix}posts
							
						WHERE ";
						
					//// IF WE HAVE A LIST OF POST IDS
					if(sizeof($post_ids) > 0) {
						
						$distance_query_string .= "
						
							1=1 AND {$wpdb->prefix}posts.ID IN
							(".implode(',', $post_ids).")
							
							AND
						
						";
						
					}
						
					$distance_query_string .= "(
							{$wpdb->prefix}posts.ID = latitude.post_id
							AND latitude.meta_key = 'latitude'
						)
							
						AND (
							{$wpdb->prefix}posts.ID = longitude.post_id
							AND longitude.meta_key = 'longitude'
						)
							
						AND {$wpdb->prefix}posts.post_status = 'publish'
						AND {$wpdb->prefix}posts.post_type = 'spot'
						
						ORDER BY distance
					
					";
					
					$results = $wpdb->get_results($distance_query_string);
					
					$post__in_arr = array();
					
					foreach($results as $single_result) { array_push($post__in_arr, $single_result->ID); }
					
					$args['post__in'] = $post__in_arr;
					$args['orderby'] = 'post__in';
					
					//// LET'S ADD SOME OF OUR METAQUERIES IN THERE JUST SO WE HAVE LESS STUFF TO GO THROUGH
				
				}
				
			}
			
		}
		
		///// IF WE ARE SORTING BY RATING
		if(_sf_get_list_sort() == 'ratingdesc' || _sf_get_list_sort() == 'ratingasc') {
			
			//// IF WE ARE ABLE TO
			if(ddp('rating') == 'on' && ddp('rating_sortby') == 'on') {
				
				//// IF WE ARE SORTING DESC
				if(_sf_get_list_sort() == 'ratingdesc') {
					
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = 'rating';
					$args['order'] = 'DESC';
					
				}
				
				//// IF WE ARE SORTING DESC
				if(_sf_get_list_sort() == 'ratingasc') {
					
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = 'rating';
					$args['order'] = 'ASC';
					
				}
				
			}
			
		}
		
		//// RETRUN ARGUMENTS
		return $args;
		
	}
		
		
	////////////////////////////////////////////////////////////////////////////////
	///// NOW IF WE ARE DISPLAYING OUR FEATURED ON TOP
	////////////////////////////////////////////////////////////////////////////////
	
	function _sf_get_listing_query($args) {
		
		//echo '<pre>'; print_r($args); exit;
		
		//// IF OUR FEATURED ONES ARE ON TOP AND WE ARE NOT SORTING BY MOST RELEVANT
		if(ddp('lst_featured') == 'on' && _sf_get_list_sort() == 'relevant') {
			
			global $paged;
			$posts_per_page = $args['posts_per_page'];
			
			//// CREATES A NEW ARGUMENT AND CREATES OUR FIRST QUERY FOR FEATURED ONES
			$f_args = $args;
			
			//// CREATES A QUERY WITH THEM ALL FOR PAGINATION PURPOSES
			$query = array(new WP_Query($args));
			
			//// ADDS TO OUR ARGUMENTS
			$f_args['meta_query'][] = array(
				
				'key' => 'featured',
				'value' => 'on',
				'compare' => '=',
			
			);
			
			///// CREATES OUR NEW QUERY
			$f_query = new WP_Query($f_args);
			
			///// IF WE HAVE STUFF TO SHOW WE ADD IT TO OUR QUERY
			if($f_query->post_count > 0) { $query[] = $f_query; }
			
			///// NOW WE NEED TO CALCULATE WHETHER WE WILL FILL THE ENTIRE PAGE WITH FEATURED ONES, ELSE WE LOOP NORMAL ONES AS WELL
			if($f_query->post_count < $posts_per_page) {
				
				//// NOW WE LOOP OUR NORMAL ONES
				$args['meta_query'][] = array(
				
					'key' => 'featured',
					'value' => 'on',
					'compare' => '!=',
				
				);
									
				//// MAKES SURE PAGED IS 1
				if($paged == 0) { $paged = 1; }
									
				//// IF WE ARE STILL SHOWING SOME FEATURED PROPERTIES
				if($paged == $f_query->max_num_pages) {
					
					$args['posts_per_page'] = ($posts_per_page - $f_query->post_count);
					$args['paged'] = 0;
					
					//// CREATES THE NON FEATURED QUERY
					$query[] = new WP_Query($args);
					
				} else {
					
					//// NOW WE HAVE ONLY NORMAL PROPERTIES TO SHOW
					
					//// FINDS THE OFFSET OF NORMAL PROPERTIES
					$f_args['paged'] = 0;
					$featuredQuery = new WP_Query($f_args);
					
					//// FINDS THE LEFT OVERS FOR FEATURED ITEMS
					$totalFeaturedItems = $featuredQuery->found_posts;
					for($i=1; $i<$featuredQuery->max_num_pages; $i++) { $totalFeaturedItems = $totalFeaturedItems - $args['posts_per_page']; }
					$offset = ($posts_per_page - $totalFeaturedItems);
					
					//// FINALLY GETS THE PAGINATION BASED ON THE CURRENT PAGINATION AND THE MAX NUMBER OF PAGES FOR FEATURED ITEMS
					$newPaged = ($paged - $featuredQuery->max_num_pages);
					if($newPaged == 1) { $newPaged = 0; }
										
					//// CHANGES OUR ARGUMENT QUERY
					$args['paged'] = $newPaged;
										
					//// OFFSET
					$args['offset'] = $offset;
					if($featuredQuery->found_posts == 0) { unset($args['offset']); }
					
					///// CREATES THIS QUERY
					$query[] = new WP_Query($args);
					
				}
				
			}
			
		} else {
			
			//// GETS THE QUERY LOOP THEM ALL
			$query = new WP_Query($args);
			
		}
		
		//die('a');
		
		return $query;
		
	}
	
	
	
	//////// CHECKS FOR DROPDOWN VALUE
	function _sf_dropdown_value_exists($post_id, $field_id) {
		
		///// GETS VALUES
		if($field = get_post($post_id)) {
			
			///// WE CAN GET VALUES
			if(get_post_meta($post_id, 'dropdown_values', true) != '') {
				
				$values = json_decode(htmlspecialchars_decode(get_post_meta($post_id, 'dropdown_values', true)));
				
				//// IF ITS AN OBJECT
				if(is_object($values)) {
					
					foreach($values as $val) {
						
						///// IF VALUE EXISTS
						if($val->id == $field_id) {
							
							return true;
							
						}
						
					}
					
				}
				
			}
			
		}
		
		return false;
		
	}
	
	
	
	//////// CHECKS FOR DEPENDENT VALUE
	function _sf_dependent_value_exists($post_id, $field_id) {
		
		///// GETS VALUES
		if($field = get_post($post_id)) {
			
			///// WE CAN GET VALUES
			if(get_post_meta($post_id, 'dependent_values', true) != '') {
				
				$values = json_decode(htmlspecialchars_decode(get_post_meta($post_id, 'dependent_values', true)));
				
				//// IF ITS AN OBJECT
				if(is_object($values)) {
					
					foreach($values as $section) { foreach($section as $val) {
						
						///// IF VALUE EXISTS
						if($val->id == $field_id) {
							
							return true;
							
						}
						
					} }
					
				}
				
			}
			
		}
		
		return false;
		
	}
	
	
	
	////////// GETS OUR LISTING IMAGE
	function _sf_get_spot_listing_image($post_id, $post_title = null) {
		
		//// GETS OUR FEATURED IMAGE
		$image = btoa_get_featured_image($post_id);
		
		//// GENERATES OUR MARKUP
		$markup = '';
		
		//// LINK TAG
		$markup .= '<a href="'.get_permalink($post_id).'" title="'.$post_title.'" class="spot-image">';
		
		///// IF IT'S FEATURED
		if(get_post_meta($post_id, 'featured', true) == 'on') { $markup .= '<span class="featured">'.__('Featured', 'btoa').'</span>'; }
		
		///// IMAGE
		$markup .= '<img src="'.ddTimthumb($image, 500, 350).'" alt="'.$post_title.'" title="'.$post_title.'" />';
		
		//// CLOSES LINK TAG
		$markup .= '</a>';
		
		return $markup;
		
	}
	
	
	///// GETS CURRENT LIST VIEW
	function _sf_get_list_view() {
		
		///// IF WE ARE USING THE ALTERNATE VIEW
		if(ddp('lst_logo') == 'on') { return 'list'; }
		
		//// IF ITS LIST
		if(_sf_is_list_view('List')) {
			
			return 'list';
			
		} else {
			
			return 'grid';
			
		}
		
	}
	
	
	/////// THIS HOOK WILL SET THE USERS INITIAL LIST VIEW
	add_action('init', '_sf_set_list_view_cookie');
	
	function _sf_set_list_view_cookie() {
		
		//// IF IT'S NOT SET WE SET IT
		if(!isset($_COOKIE['listing_view']))
			setcookie('listing_view', ddp('lst_view'), 0, '/');
			
		//// IF OUR VIEW IS SET WE SET THE COOKIE AS WELL
		if(isset($_GET['view'])) {
			
			if($_GET['view'] == 'grid') {
				setcookie('listing_view', 'Grid', 0, '/');
			} else {
				setcookie('listing_view', 'List', 0, '/');
			}
			
		}
		
	}
	
	
	///// CHECKS OUR LISTINGS VIEW
	function _sf_is_list_view($view) {
		
		//// GETS GET FIRST
		if(isset($_GET['view'])) {
			
			if($_GET['view'] == strtolower($view)) {
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		} else {
		
			//// CHECKS AGAINST COOKIE FIRST
			if(isset($_COOKIE['listing_view'])) {
				
				if($_COOKIE['listing_view'] == $view) {
					
					return true;
					
				} else {
					
					return false;
					
				}
				
			} else {
				
				if(ddp('lst_view') == $view) {
					
					return true;
					
				} else {
					
					return false;
					
				}
				
			}
		
		}
		
	}
	
	
	///// RETURNS LIST VIEW URL
	function _sf_get_list_view_url($view) {
			
		///// RETURNS THE NEW URL WITH OUR VIEW ARGUMENT
		$url = add_query_arg(array('view' => strtolower($view)));
		return $url;
		
	}
	
	///// GETS OUR POSTS PER PAGE SELECTED OPTION
	function _sf_get_posts_per_page() {
		
		$options = _sf_get_per_page_options();
		
		///// TRIES TO GET BY GET FIRST
		if(isset($_GET['per_page']) && in_array($_GET['per_page'], $options)) {
			
			$return = $_GET['per_page'];
			
		} else {
		
			///// TRIES TO GET OUR COOKIE
			if(isset($_COOKIE['per_page']) && in_array($_COOKIE['per_page'], $options)) {
				
				$return = $_COOKIE['per_page'];
				
			} else {
				
				$return = $options[0];
				
			}
		
		}
		
		return $return;
		
	}
	
	
	//// GETS ALL PER PAGE OPTIONS
	function _sf_get_per_page_options() {
		
		//// GETS THE ARRAY
		$values = explode("\n", ddp('lst_per_page'));
		if(!is_array($values)) { $values = array(9); }
		$opts = array();
		
		//// NEED TO VALIDATE THEM
		foreach($values as $val) {
			
			//// IF ITS A NUMBER
			if(is_numeric(trim($val))) {
				
				$opts[] = absint(trim($val));
				
			}
			
		}
		
		//// MAKES SURE ITS NOT EMPTY
		if(count($opts) == 0) { $opts[] = 9; }
		
		return $opts;
		
	}
	
	
	/////// THIS HOOK WILL SET THE USERS INITIAL PER PAGE
	add_action('init', '_sf_set_per_page_cookie');
	
	function _sf_set_per_page_cookie() {
		
		//// IF IT'S NOT SET WE SET IT
		if(!isset($_COOKIE['per_page'])){
			
			// GETS FIRST OPTION
			$opts = _sf_get_per_page_options();
			
			// SETS COOKIE
			setcookie('per_page', $opts[0], 0, '/');
			
		}
			
		//// IF OUR PER PAGE IS SET WE SET THE COOKIE AS WELL
		if(isset($_GET['per_page'])) {
			
			$options = _sf_get_per_page_options();
			
			///// MAKES SURE ITS A VALID OPTION
			if(in_array($_GET['per_page'], $options)) {
				
				//// SAVES IT
				setcookie('per_page', $_GET['per_page'], 0, '/');
				
			}
			
		}
		
	}
	
	
	///// RETURN THE URL FOR PER PAGE VIEW
	function _sf_get_per_page_option($option) {
		
		//// RETURNS THE URL
		$url = add_query_arg(array('per_page' => $option));
		return $url;
	
	}
	
	
	////// CHECKS FOR PER PAGE OPTIOON
	function _sf_is_per_page($option) {
		
		$options = _sf_get_per_page_options();
		
		//// GETS GET FIRST AND MAKES SUREITS A VALID OPTION
		if(isset($_GET['per_page']) && in_array($_GET['per_page'], $options)) {
			
			//// IF IT'S A VALID OPTION
			if(in_array($option, $options)) {
				
				//// IF ITS THE CURRENT ONE
				if($_GET['per_page'] == $option) {
					
					return true;
					
				} else {
					
					return false;
					
				}
				
			} else {
				
				return false;
				
			}
			
		} else {
			
			//// IF ITS A VALID OPTION
			if(in_array($option, $options)) {
					
				//// CHECKS AGAINST COOKIE FIRST
				if(isset($_COOKIE['per_page'])) {
					
					if($_COOKIE['per_page'] == $option) {
						
						return true;
						
					} else {
						
						return false;
						
					}
					
				} else {
					
					return false;
					
				}
				
			} else {
				
				return false;
				
			}
		
		}
		
	}
	
	//// FIXES OFFSET PAGINATION
	add_action('pre_get_posts', '_sf_query_offset', 1);
	function _sf_query_offset(&$query) {
		
		///// LETS MAKE SURE IT'S THE RIGHT QUERY
		if(!isset($query->query['offset'])) { return; }
		if(!$query->query['offset']) { return; }
	
		///// FIRST OUR DESIRED OFFSET
		$offset = $query->query['offset'];
		
		///// NEXT HOW MANY POSTS PER PAGE WE ACTUALLY WANT
		$ppp = $query->query['posts_per_page'];
		
		///// LETS DETECT AND HANDLE PAGINATION
		if($query->is_paged) {
	
			//Manually determine page query offset (offset + current page (minus one) x posts per page)
			$page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );
	
			//Apply adjust page offset
			$query->set('offset', $page_offset );
			
		} else {
			
			//// ITS OUR FIRST PAGE, JUST USE THE OFFSET
			$query->set('offset',$offset);
			
		}
		
	}
	
	
	/////// THIS HOOK WILL SET THE USERS INITIAL PER PAGE
	add_action('init', '_sf_set_sort_cookie');
	
	function _sf_set_sort_cookie() {
		
		//// IF IT'S NOT SET WE SET IT
		if(!isset($_COOKIE['sort'])){
			
			// SETS COOKIE
			setcookie('sort', 'relevant', 0, '/');
			
		}
			
		//// IF OUR PER PAGE IS SET WE SET THE COOKIE AS WELL
		if(isset($_GET['sort'])) {
			
			$options = array('relevant', 'oldest', 'newest', 'closest');
		
			///// IF WE HAVE RATING
			if(ddp('rating') == 'on' && ddp('rating_sortby') == 'on') { $options[] = 'ratingdesc'; $options[] = 'ratingasc'; }
			
			///// MAKES SURE ITS A VALID OPTION
			if(in_array($_GET['sort'], $options)) {
				
				//// SAVES IT
				setcookie('sort', $_GET['sort'], 0, '/');
				
			}
			
		}
		
	}
	
	
	///// GETS OUR SORT URL
	function _sf_get_list_sort_url($option) {
		
		//// RETURNS THE URL
		$url = add_query_arg(array('sort' => $option));
		return $url;
		
	}
	
	
	//// GETS SORT
	function _sf_get_list_sort() {
		
		$options = _sf_get_list_of_sort_options();
		
		///// TRIES TO GET BY GET FIRST
		if(isset($_GET['sort']) && in_array($_GET['sort'], $options)) {
			
			$return = $_GET['sort'];
			
		} else {
		
			///// TRIES TO GET OUR COOKIE
			if(isset($_COOKIE['sort']) && in_array($_COOKIE['sort'], $options)) {
				
				$return = $_COOKIE['sort'];
				
			} else {
				
				$return = $options[0];
				
			}
		
		}
		
		return $return;
		
	}
	
	
	////// CHECKS FOR PER PAGE OPTIOON
	function _sf_is_sort_by($option) {
		
		$options = _sf_get_list_of_sort_options();
		
		//// GETS GET FIRST AND MAKES SUREITS A VALID OPTION
		if(isset($_GET['sort']) && in_array($_GET['sort'], $options)) {
			
			//// IF IT'S A VALID OPTION
			if(in_array($option, $options)) {
				
				//// IF ITS THE CURRENT ONE
				if($_GET['sort'] == $option) {
					
					return true;
					
				} else {
					
					return false;
					
				}
				
			} else {
				
				return false;
				
			}
			
		} else {
			
			//// IF ITS A VALID OPTION
			if(in_array($option, $options)) {
					
				//// CHECKS AGAINST COOKIE FIRST
				if(isset($_COOKIE['sort'])) {
					
					if($_COOKIE['sort'] == $option) {
						
						return true;
						
					} else {
						
						return false;
						
					}
					
				} else {
					
					return false;
					
				}
				
			} else {
				
				return false;
				
			}
		
		}
		
	}
	
	
	///// THIS FUNCTION GETS A LIST OF SORTING OPTIONS
	function _sf_get_list_of_sort_options() {
		
		$options = array('relevant', 'oldest', 'newest', 'closest');
		
		///// IF WE HAVE RATING
		if(ddp('rating') == 'on' && ddp('rating_sortby') == 'on') { $options[] = 'ratingdesc'; $options[] = 'ratingasc'; }
		
		///// WE NEED TO GO THROUGH OUR FIELDS TO SEE IF ANY OF THEM IS A VALID OPTION
		$args = array(
							
			'post_type' => 'search_field',
			'meta_query' => array(
			
				array(
				
					'key' => 'enable_sort',
					'value' => 'on',
				
				),
				
				array(
				
					'key' => 'field_type',
					'value' => array('range', 'min_val', 'max_val'),
					'compare' => 'IN',
				
				)
			
			),
			'posts_per_page' => -1,
		
		);
		
		$sortQ = new WP_Query($args);
		
		if($sortQ->have_posts()) {
			
			foreach($sortQ->posts as $search_field) {
				
				$options[] = $search_field->post_name.'_low';
				$options[] = $search_field->post_name.'_high';
				
			}
			
		}
		
		return $options;
		
	}
	
	
	
	///// MAKES SURE OUR PAGINATION WORKS IN OUR TAXONOMY PAGE
	add_action( 'init', 'my_modify_posts_per_page', 0);
	
	function my_modify_posts_per_page() {
		
		add_filter( 'option_posts_per_page', 'my_option_posts_per_page' );
		
	}
	
	function my_option_posts_per_page( $value ) {
		
		$tax_posts_per_page = _sf_get_posts_per_page();
		
		if (is_tax('spot_cats') ) {
			
			return $tax_posts_per_page;
			
		} else {
			
			return $value;
			
		}
		
	}
	
	
	///// GETS LISTINGS HEADER TYPE
	function get_listings_header_type() {
		
		global $post;
		
		///// TRIES TO GET THE PAGE BY THE DDP FIRST
		if($page = get_post($post->ID)) {
			
			if(get_post_meta($post->ID, '_wp_page_template', true) == 'listings.php') {
				
				$list_type = get_post_meta($post->ID, 'list_map', true);
				return $list_type;
				
			}
			
		}
		
		///// TRIES TO GET THE PAGE BY THE DDP FIRST
		if($page = get_post(ddp('listing_page'))) {
			
			if(get_post_meta($page->ID, '_wp_page_template', true) == 'listings.php') {
				
				$list_type = get_post_meta($page->ID, 'list_map', true);
				return $list_type;
				
			}
			
		}
			
		$args = array('post_type' => 'page','meta_key' => '_wp_page_template','meta_value' => 'listings.php');
		$pageQuery = new WP_Query($args);
		
		if($pageQuery->found_posts > 0) { 
		
			$the_post = $pageQuery->posts;
		
			$list_type = get_post_meta($the_post[0]->ID, 'list_map', true);
		
		} else { 
		
			$list_type = 'on';
		
		}
		
		return $list_type;
		
	}
	
	
	//// WHETHER OR NOT WE ARE SHOWING OVERLAYS
	function get_map_overlay_status() {
		
		if(ddp('map_overlays') == 'on') { return true; }
		else { return false; }
		
	}
	
	
	
	///////////////////////////////////
	//// IF WE ARE VIEWING A SPOT
	///////////////////////////////////
	
	function is_user_viewing_spot() {
		
		global $post;
		
		//// IF THIS IS A PROPERTY PAGE
		if(is_singular('spot') && $post->post_status == 'publish') {
			
			/// LETS GET OUR COOKIE AND ADD THIS TO THE ARRAY
			
			//// IF IS NOT SET LET'S SET IT
			if(!isset($_COOKIE['viewed_spot'])) {
				
				$properties = array($post->ID);
				
			} else {
				
				//// GETS OUR ALREADY VIEWED PROPERTIES
				$properties = unserialize($_COOKIE['viewed_spot']);
				
				//// IF IT'S ALREADY IN OUR ARRAY
				if(in_array($post->ID, $properties)) {
					
					if(($key = array_search($post->ID, $properties)) !== false) {
						unset($properties[$key]);
					}
					
					//// ADDS IT TO THE TOP
					array_unshift($properties, $post->ID);
					
					
				} else {
					
					//// PUT IT AT THE TOP
					array_unshift($properties, $post->ID);
					
				}
				
			}
			
			//// MAKES SURE OUR ARRAY IS ONLY 10 PROPERTIES LONG
			if(count($properties) > 10) {
				
				$props = $properties;
				$properties = ''; $properties = array(); 
				
				for($i=0; $i<10; $i++) { $properties[] = $props[$i]; }
				
			}
			
			//print_r($properties); exit;
			
				//// SETS COOKIE
				setcookie('viewed_spot', serialize($properties), time()+(3600*24*30), '/');
			
		}
		
	}
	
	add_action('template_redirect', 'is_user_viewing_spot');
	
	
	function _sf_update_view_count($post_id = '') {
		
		///// GETS POST
		if($post_id != '' && $spot = get_post($post_id)) {
			
			///// IF ITS A SPOT
			if($spot->post_type == 'spot') {
				
				///// GETS VIEW VOUNT
				$spot_views = get_post_meta($spot->ID, '_sf_view_count', true);
				$spot_views_ips = get_post_meta($spot->ID, '_sf_view_count_ips', true);
				$spot_views_days = get_post_meta($spot->ID, '_sf_view_count_today', true);
				
				///// ADDS IT TO OUR ARRAY
				$ip = getRealIpAddr();
				$right_now = time();
				$today = mktime(0, 0, 0, date('n', time()), date('j', time()), date('Y', time()));
				$twenty_minutes_ago = time() - (60*20);
				
				if(!is_array($spot_views_ips)) { $spot_views_ips = array(); }
				if(!is_array($spot_views_days)) { $spot_views_days = array(); }
				
				if(!isset($spot_views_ips[$ip])) { $spot_views_ips[$ip] = array(); }
				if(!isset($spot_views_days[$today])) { $spot_views_days[$today] = array(); }
				
				$store_page_view = true;
				
				//// LETS GO THROUGH OUR VALUES FOR THIS IP TODAY AND SEE IF WE HAVE BEEN THERE IN THE LAST 20 MINUTES
				foreach($spot_views_ips[$ip] as $times) {
					
					//// IF THIS VALUE IS PAST THE LAST @) MINUTES
					if($times > $twenty_minutes_ago && $times < $right_now) {
						
						//// DO NOT STORE THE VALUE
						$store_page_view = false;
						
					}
					
				}
				
				///// CHECKS IF THIS IP HAS ALREADY VISITED IN THE LAST 20 MINUTES
				if($store_page_view) {
					
					//// SAVES THIS VISITORS FOR TODAY
					$spot_views_ips[$ip][] = $today;
					
					//// INCREASES THE VIEW COUNT
					if($spot_views == '') { $spot_views = 0; }
					$spot_views++;
					
					///// SAVES THIS IP IN THE TODAY ARRAY AS WELL
					array_push($spot_views_days[$today], $ip);
					
					///// UPDATES DATABASE
					update_post_meta($spot->ID, '_sf_view_count', $spot_views);
					update_post_meta($spot->ID, '_sf_view_count_ips', $spot_views_ips);
					update_post_meta($spot->ID, '_sf_view_count_today', $spot_views_days);
				
				}
				
				//// ELSE DO NOTHING
				
			}
			
		}
		
	}
	
	function getRealIpAddr()
	{
	  if (!empty($_SERVER['HTTP_CLIENT_IP']))
	  //check ip from share internet
	  {
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	  }
	  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	  //to check ip is pass from proxy
	  {
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	  }
	  else
	  {
		$ip=$_SERVER['REMOTE_ADDR'];
	  }
	  return $ip;
	}
	
	


?>