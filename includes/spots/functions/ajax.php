<?php


	///// DEALS WITH CHECKOUT AND PAYPAL TRANSACTIONS
	include('ajax-checkout.php');

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION LOGS IN USER
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_login', '_sf_login_function');
	add_action('wp_ajax_nopriv__sf_login', '_sf_login_function');
	add_action('wp_ajax_login_widget_login', '_sf_login_function');
	add_action('wp_ajax_nopriv_login_widget_login', '_sf_login_function');
	
	function _sf_login_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		$nonce_check = false;
		if(!wp_verify_nonce($nonce, 'sf-login-nonce')) {
		
			if(!wp_verify_nonce($nonce, 'login-widget-nonce-login')) { $nonce_check = false; }
			else { $nonce_check = true; }
			
		} else { $nonce_check = true; }
		if(!$nonce_check)
			die('Busted!');
			
		//// VERIFIES CREDENTIALS
		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$password = isset($_POST['password']) ? trim($_POST['password']) : '';
		
		//// CHECKS IF USERNAME EXISTS
		$user = get_user_by('login', $username);
		if($user) {
			
			//// CHECKS FOR PASSWORD AND USERNAME
			$password_results = wp_check_password($password, $user->user_pass, $user->ID);
			
			//// IF CHECKS WE SIGN THE USER IN
			if($password_results) {
				
				wp_signon(array(
				
					'user_login' => $username,
					'user_password' => $password,
					'remember' => false,
				
				));
				
				$return['message'] = __('Success! Logging you in now...', 'btoa');
				
			} else {
				
				$return['error'] = true; $return['message'] = __('Incorrect username and password combination.', 'btoa');
				
			}
			
		} else {
			
			//// RETURNS ERROR
			$return['error'] = true; $return['message'] = __('Incorrect username and password combination.', 'btoa');
			
		}
		
		///// IF WE HAVE A LOGI NURL WE NEED TO SEND THE URL
		if($_POST['login_url']) {
			
			$pages = get_pages(array(
				'meta_key' => '_wp_page_template',
				'meta_value' => 'login.php',
				'hierarchical' => 0
			));
			
			if(is_array($pages)) {
				
				foreach($pages as $page) { $return['url'] = get_permalink($page->ID); }
				
			}
			
		}
			
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION LOGS IN USER WITH FACEBOOK
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_us_fb_login', '_sf_us_fb_login_function');
	add_action('wp_ajax_nopriv__sf_us_fb_login', '_sf_us_fb_login_function');
	add_action('wp_ajax_nopriv__sf_us_fb_login_widget', '_sf_us_fb_login_function');
	add_action('wp_ajax__sf_us_fb_login_widget', '_sf_us_fb_login_function');
	
	function _sf_us_fb_login_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce_check = false;
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-us-fb-login-nonce')) {
			
			if(!wp_verify_nonce($nonce, 'sf-us-fb-login-widget-nonce')) { $nonce_check = false; }
			else { $nonce_check = true; }
			
		} else { $nonce_check = true; }
		if($nonce_check == false)
			die('Busted!');
			
		/// VERIFIES IF THE USER EXISTS
		$username = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
		$email = isset($_POST['email']) ? trim($_POST['email']) : '';
		
		//// GETS THE USER BY ID AND EMAIL
		$user = get_user_by('login', $username);
		$user_email = get_user_by('email', $email);
		
		if($user && $user_email) {
			
			//// THE USER EXISTS LOG HIM IN
			$return['message'] = 'LOG IN';
			
			//// LOGS THE USER IN
			wp_set_auth_cookie($user->ID, true, '');
			
		} else {
			
			//// CHECKS IF REGISTRATIONS ARE OPEN
			if(ddp('public_submissions_register') != 'on') {
				
				$return['error'] = true;
				$return['message'] = __('Registrations are currently closed.', 'btoa');
				
				echo json_encode($return);
				exit;
				
			}
			
			//// WE NEED TO REGISTER HIM	
			$password = wp_generate_password();
			
			//// FIRST NAME AND LAST NAME
			$first_name = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
			$last_name = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
			
			//// NOW WE CAN FINALLY REGISTER THE USER
			$args = array(
			
				'user_login' => $username,
				'user_email' => $email,
				'user_pass' => $password,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'display_name' => $first_name.' '.$last_name,
				'role' => 'submitter',
			
			);
			
			//// CREATES THE USER
			$user = wp_insert_user($args);
			
			//// MAKES SURE HE CAN"T SEE THE ADMIN BAR
			update_user_meta($user, 'show_admin_bar_front', 'false');
			
			//// LOGS THE USER IN
			wp_set_auth_cookie($user, true, '');
						
			///// SENDS THE EMAIL TO THE ADMINISTRATOR
			$message = sprintf2(__('Dear Admin,

A new user has signed up to your website.

Username: %username
Email Address: %email', 'btoa'), array(
			
				'username' => $username,
				'email' => $email,
			
			));
			
			$return['message2'] = $message;
			
			$subject = sprintf2(__('New user registration at %site_name.', 'btoa'), array('site_name' => get_bloginfo('name')));
			
			$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
			
			wp_mail(get_option('admin_email'), $subject, $message, $headers);
			
		}
		
			///// IF WE HAVE A LOGI NURL WE NEED TO SEND THE URL
			if($_POST['login_url']) {
				
				$pages = get_pages(array(
					'meta_key' => '_wp_page_template',
					'meta_value' => 'login.php',
					'hierarchical' => 0
				));
				
				if(is_array($pages)) {
					
					foreach($pages as $page) { $return['url'] = get_permalink($page->ID); }
					
				}
				
			}
			
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION DEALS WITH LOST PASSWORD
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_lost_password', '_sf_lost_password_function');
	add_action('wp_ajax_nopriv__sf_lost_password', '_sf_lost_password_function');
	
	function _sf_lost_password_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-lost-password-nonce'))
			die('Busted!');
			
		$input = isset($_POST['input']) ? trim($_POST['input']) : '';
			
		//// CHECKS IF USERNAME EXISTS
		$user = get_user_by('login', $input);
		
		//// IF NO USER, TRY BY EMAIL
		if(!$user) { $user = get_user_by('email', $input); }
		
		//// IF WE HAVE FOUND
		if($user) {
			
			//// GENERATES A KEY AND STORES IT IN DATABASE
			$new_key = randomString('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', 20);
			
			//// STORES IT IN THE USER FIELD
			global $wpdb;
			if($wpdb->update($wpdb->users, array('user_activation_key' => $new_key), array('ID' => $user->ID))) {
				
				///// LETS SET A JOB FOR 48 HOURS TO RESET USER ACTIVATION KEY
				$exp_date = time() + (2 * (60*60*24));
				wp_schedule_single_event($exp_date, '_sf_reset_user_activation_key', array($user->ID));
				
				//// SENDS THE USER AN EMAIL
				$message = sprintf2(__('A password reset request has been submitted at %site_name for your account:
				
Username: %username

If this was a mistake, just ignore this email.

To reset your password visit the following address:

%reset_link

This link is only valid for 48 hours.', 'btoa'), array(
				
					'site_name' => get_bloginfo('name'),
					'username' => $user->user_login,
					'reset_link' => add_query_arg(array('key' => $new_key), $_POST['page_url']),
				
				));
				
				$subject = sprintf2(__('%site_name - Password Reset', 'btoa'), array('site_name' => get_bloginfo('name')));
						
				$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
				
				///// SENDS THE EMAIL
				if(!wp_mail($user->user_email, $subject, $message, $headers)) {
					
					$return['error'] = true; $return['message'] = sprintf2(__('Unfortunately an error occurred sending you the email. Please visit %link', 'btoa'), array(
					
						'link' => add_query_arg(array('key' => $new_key), $_POST['page_url']),
					
					));
					
				} else { $return['message'] = __('Check your email inbox to reset your password.', 'btoa'); }
				
			} else {
				
				$return['error'] = true; $return['message'] = __('We were not able to process your request. Please contact the site administrator.', 'btoa');
				
			}
			
		} else {
			
			$return['error'] = true; $return['message'] = __('Username or email address not found.', 'btoa');
			
		}
			
		echo json_encode($return);
		
		exit;
		
	}
	
	
	add_action('_sf_reset_user_activation_key', '_sf_reset_user_activation_key_function', 10, 1);
	
	///// RESETS USER ACTIVATION KEY AFTER 48 HOURS
	function _sf_reset_user_activation_key_function($user_id) {
		
		global $wpdb;
		$wpdb->update($wpdb->users, array('user_activation_key' => ''), array('ID' => $user_id));
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION RESETS THE PASSWORD
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_reset_password', '_sf_reset_password_function');
	add_action('wp_ajax_nopriv__sf_reset_password', '_sf_reset_password_function');
	
	function _sf_reset_password_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-reset-password-nonce'))
			die('Busted!');
			
		//// VERIFIES PASSWORDS MATCH
		$password = isset($_POST['password']) ? trim($_POST['password']) : '';
		$password_2 = isset($_POST['password_c']) ? trim($_POST['password_c']) : '';
		
		///// MAKES SURE ITS AT LEAST 6 CHARS LENGTH
		if(strlen($password) >= 6) {
			
			//// MAKES SURE IT CONTAINS A LETTER
			if(preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password)) {
				
				//// MAKES SURE PASSWORDS MATCH
				if($password == $password_2) {
					
					///USER
					$user = get_user_by('login', $_POST['user']);
					
					//// SAVES THE USER PASSWORD
					wp_set_password($password, $user->ID);
					
					//// SENDS BACK MESSAGE
					$return['message'] = __('Your new password has been successfully changed. Please login using your new password. Redirecting you shortly...', 'btoa');
					
				} else { $return['error'] = true; $return['message'] = __('Your passwords did not match.', 'btoa'); }
				
			} else { $return['error'] = true; $return['message'] = __('Your new password must be at least 6 characters long and container at least one letter and one number.', 'btoa'); }
			
		} else { $return['error'] = true; $return['message'] = __('Your new password must be at least 6 characters long and container at least one letter and one number.', 'btoa'); }
		
			
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION REGISTER USER NAD CREATES OUR SPOT USER CLASS - WIDGET
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax_login_widget_signup', 'login_widget_signup_function');
	add_action('wp_ajax_nopriv_login_widget_signup', 'login_widget_signup_function');
	
	function login_widget_signup_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'login-widget-nonce'))
			die('Busted!');
			
		//// GETS OUR FIELDS
		$fields = array();
		parse_str($_POST['data'], $fields);
			
		//// VERIFIES CREDENTIALS
		$username = isset($fields['username']) ? trim($fields['username']) : '';
		$email = isset($fields['email']) ? trim($fields['email']) : '';
		
		//// MAKES SURE USER HAS FILLES USERNME AND EMAIL
		if($email == '' || !is_email($email)) { $return['error'] = true; $return['message'] = __('Please type in a valid email address.', 'btoa'); }
		if($username == '') { $return['error'] = true; $return['message'] = __('Please choose an username.', 'btoa'); }
		
		///// IF USER HAS FILLED USER AND PASS
		if($return['error'] == false) {
		
			$return_registration = _sf_process_user_registration($return, $email, $username);
			$return = $return_registration;
		
		}
			
			
		//// RETURNS DATA
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION REGISTER USER NAD CREATES OUR SPOT USER CLASS
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_register', '_sf_register_function');
	add_action('wp_ajax_nopriv__sf_register', '_sf_register_function');
	
	function _sf_register_function() {
		
		$return = array();
		$return['error'] = false;
		$return['message'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-register-nonce'))
			die('Busted!');
			
		//// VERIFIES CREDENTIALS
		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$email = isset($_POST['email']) ? trim($_POST['email']) : '';
		
		//// MAKES SURE USER HAS FILLES USERNME AND EMAIL
		if($email == '' || !is_email($email)) { $return['error'] = true; $return['message'] = __('Please type in a valid email address.', 'btoa'); }
		if($username == '') { $return['error'] = true; $return['message'] = __('Please choose an username.', 'btoa'); }
		
		///// IF USER HAS FILLED USER AND PASS
		if($return['error'] == false) {
		
			$return_registration = _sf_process_user_registration($return, $email, $username);
			$return = $return_registration;
		
		}
			
		echo json_encode($return);
		
		exit;
		
	}
	

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION PROCESSES REGISTRATIONS
	//////////////////////////////////////////////////////////////////////
	
	function _sf_process_user_registration($return, $email, $username) {
		
			//// CHECKS IF USERNAME EXISTS
			$user = new WP_User('', $username);
			if(!$user->exists()) {
				
				//// CHECK FOR USERNAMES EMAIL
				$user = get_user_by('email', $email);
				if(!$user) {
					
					$password = wp_generate_password();
					
					//// NOW WE CAN FINALLY REGISTER THE USER
					$args = array(
					
						'user_login' => esc_attr($username),
						'user_email' => $email,
						'user_pass' => $password,
						'role' => 'submitter',
					
					);
					
					//// CREATES THE USER
					$user = wp_insert_user($args);
						
					if(!is_object($user)) {
					
						//// MAKES SURE HE CAN"T SEE THE ADMIN BAR
						update_user_meta($user, 'show_admin_bar_front', 'false');
						
						$user = new WP_User($user);
						
						//// MAKES UP THE EMAIL WE SEND THE USER
						$message = sprintf2(__("Welcome to %site_name,

Here are your credentials ready for use:
Username: %username
Password: %password

Kind regards,
The %site_name team.", 'btoa'), array(

							'site_name' => get_bloginfo('name'),
							'username' => $username,
							'password' => $password,

						));
						
						$subject = sprintf2(__('Your %site_name credentials', 'btoa'), array('site_name' => get_bloginfo('name')));
						
						$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
						
						///// SENDS THE EMAIL
						if(!wp_mail($email, $subject, $message, $headers)) {
							
							$return['error'] = true; $return['message'] = sprintf2(__('Unfortunately an error occurred sending you the email. Your credentials are %username and %password', 'btoa'), array(
							
								'username' => $username,
								'password' => $password,
							
							));
							
						}
						
						///// SENDS THE EMAIL TO THE ADMINISTRATOR
						$message = sprintf2(__('Dear Admin,

A new user has signed up to your website.

Username: %username
Email Address: %email', 'btoa'), array(
						
							'username' => $username,
							'email' => $email,
						
						));
						
						$return['message2'] = $message;
						
						$subject = sprintf2(__('New user registration at %site_name.', 'btoa'), array('site_name' => get_bloginfo('name')));
						
						$headers = "From: ".get_bloginfo('name')." <".get_option('admin_email').">";
						
						wp_mail(get_option('admin_email'), $subject, $message, $headers);
						
						//// SENDS SUCCESS MESSAGE
						if($return['error'] == false) {
							
							$return['message'] = __('All Done! Check your email inbox for your password.', 'btoa');
							
						}
						
						
					} else { $return['error'] = true; $return['message'] = __('There was an error creating your user. Please contact the site administrator. (Error Code 23).', 'btoa'); }
					
				} else { $return['error'] = true; $return['message'] = __('Email address already in use.', 'btoa'); }
				
			} else { $return['error'] = true; $return['message'] = __('Username already in use.', 'btoa'); }
			
			return $return;
		
	}
	

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION LOGS OUT USER
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_logout', '_sf_logout_function');
	add_action('wp_ajax_nopriv__sf_logout', '_sf_logout_function');
	
	function _sf_logout_function() {
		
		$return = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-logout-nonce'))
			die('Busted!');
			
		//// LOGS USER OUT
		wp_logout();
			
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION EDITS USER PROFILE
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_edit_profile', '_sf_edit_profile_function');
	add_action('wp_ajax_nopriv__sf_edit_profile', '_sf_edit_profile_function');
	
	function _sf_edit_profile_function() {
		
		$return = array();
		$return['error'] = false;
		$return['error_field'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-edit-profile-nonce'))
			die('Busted!');
			
		//// GETS OUR FIELDS
		$fields = array();
		parse_str($_POST['data'], $fields);
			
		//// VERIFIES EMAIL ADDRESS
		$email = isset($fields['user_email']) ? trim($fields['user_email']) : '';
		$user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
		if(!is_email($email)) { $return['error'] = true; $return['error_field'][] = array('container' => 'email','message' => __('Invalid Email', 'btoa')); }
		
		//// CHECKS OTHER USERS BY THIS EMAIL ADDRESS
		if($possible_user = get_user_by('email', $email)) { if($possible_user->ID != $user_id) { $return['error'] = true; $return['error_field'][] = array('container' => 'email','message' => __('Email already in use', 'btoa')); } }
		
		//// IF IT ALL CLEARS SAVE DATA
		if($return['error'] == false) {
			
			$first_name = isset($fields['user_first_name']) ? sanitize_text_field(trim($fields['user_first_name'])) : '';
			$last_name = isset($fields['user_last_name']) ? sanitize_text_field(trim($fields['user_last_name'])) : '';
			
			//// LETS GET USER ID FROM SESSION TO PREVENT EDITING OF OTHER USERS
			$the_user = wp_get_current_user();
			$user_id = $the_user->ID;
			
			$args = array(
			
				'ID' => $user_id,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'user_email' => $email,
			
			);
			
			//// MAKES UP USERS DISPLYA NAME
			if($first_name != '' || $last_name != '') { $args['display_name'] = $first_name.' '.$last_name; }
			
			//// UPDATES USER
			if(!wp_update_user($args)) { $return['error'] = true; $return['error_field'][] = array('container' => 'form','message' => __('Could not save data. Please contact administrator', 'btoa')); }
			
			///// GOES THROUGH OUR OTHER CUSTOM FIELDS
			if(isset($fields['phone'])) { update_user_meta($user_id, 'phone', esc_attr($fields['phone'])); }
			if(isset($fields['position'])) { update_user_meta($user_id, 'position', esc_attr($fields['position'])); }
			if(isset($fields['description'])) { update_user_meta($user_id, 'description', esc_attr(strip_tags($fields['description']))); }
			if(isset($fields['public_profile'])) { update_user_meta($user_id, 'public_profile', 'on'); } else { update_user_meta($user_id, 'public_profile', 'off'); }
			if(isset($fields['profile_pic'])) { update_user_meta($user_id, 'profile_pic', esc_attr($fields['profile_pic'])); } else { update_user_meta($user_id, 'profile_pic', ''); }
			
		}
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION CHANGES THE PASSWORD
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_change_password', '_sf_change_password_function');
	add_action('wp_ajax_nopriv__sf_change_password', '_sf_change_password_function');
	
	function _sf_change_password_function() {
		
		$return = array();
		$return['error'] = false;
		$return['error_field'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-change-password-nonce'))
			die('Busted!');
			
		//// VERIFIES THE PASSWORDS ARE NOT EMPTY
		$new_pass = isset($_POST['new_pass']) ? trim($_POST['new_pass']) : '';
		$old_pass = isset($_POST['old_pass']) ? trim($_POST['old_pass']) : '';
		$new_pass_confirm = isset($_POST['new_pass_confirm']) ? trim($_POST['new_pass_confirm']) : '';
		
		if($new_pass == '') { $return['error'] = true; $return['error_field'][] = array('container' => 'new_password','message' => __('Password cannot be empty', 'btoa')); }
		
		//// IF IT"S NOT EMPTY, CHECK THE CONFIRM
		if($return['error'] == false) {
			
			if($new_pass != $new_pass_confirm) { $return['error'] = true; $return['error_field'][] = array('container' => 'new_password_confirm','message' => __('Passwords do not match', 'btoa')); }
			
			//// NOW CHECKS FOR OLD PASSWORD
			if($return['error'] == false) {
				
				$the_user = wp_get_current_user();
				$user = get_user_by('id', $the_user->ID);
				$user_id = $user->ID;
				
				//// IF PASSWORD IS VALID
				if($user && wp_check_password($old_pass, $user->user_pass, $user_id)) {
					
					//// SETS NEW PASSWORD
					wp_set_password($new_pass, $user_id);
					
				} else {
					
					$return['error'] = true; $return['error_field'][] = array('container' => 'old_password','message' => __('Current password is incorrect', 'btoa'));
					
				}
				
			}
			
		}
		
			
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION LOADS DEPENDENT FIELDS
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_load_dependent_fields', '_sf_load_dependent_fields_function');
	add_action('wp_ajax_nopriv__sf_load_dependent_fields', '_sf_load_dependent_fields_function');
	
	function _sf_load_dependent_fields_function() {
		
		$return = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'load-dependent-fields-nonce'))
			die('Busted!');
			
		//// GETS PARENT FIELD
		$parent = isset($_POST['parent_id']) ? trim($_POST['parent_id']) : '';
		$parent = get_post($parent);
		$all_parent_fields = json_decode(htmlspecialchars_decode(get_post_meta($parent->ID, 'dropdown_values', true)));
		if(get_post_meta($parent->ID, 'field_type', true) == 'dependent') { $all_parent_fields = json_decode(htmlspecialchars_decode(get_post_meta($parent->ID, 'dependent_values', true))); }
		
		//// GETS SELECTED PARENTS
		$parent_fields_all = $_POST['parent']; $parent_fields = array();
		if(!is_array($parent_fields_all)) { $parent_fields_all = array(); }
		$parent_fields = $parent_fields_all;
		
		if(!is_array($parent_fields)) { $parent_fields = array($parent_fields); }
		
		//// NOW LETS GO THROUGH THE FIELDS AND SEE IF THEY ARE CHIDREN OF THE PARENT
		$the_field = isset($_POST['dependent_id']) ? trim($_POST['dependent_id']) : ''; $return['sections'] = array();
		$all_child_fields = json_decode(htmlspecialchars_decode(get_post_meta($the_field, 'dependent_values', true)));
		
		$return['test'] = false;
		
		$return['test'] = $all_child_fields;
		
		//// IF PARENT IS A DROPDOWN
		if(get_post_meta($parent ->ID, 'field_type', true) == 'dropdown') {
		
			if(is_object($all_child_fields)) {
				
				//// GOES THROUGH EACH PARENT
				foreach($all_child_fields as $key => $parent_section) {
					
					//// IF THIS PARENT IS WITHIN OUR PARENT FIELDS
					if(in_array($key, $parent_fields)) {
						
						//// LETS ADD THE LABEL FOR THIS SECTION AS AN ARRAY
						//// SO THIS WAY WE CAN GROUP THE FIELDS IN CASE OF AN ARRAY
						
						foreach($all_parent_fields as $single_parent_field) { if($single_parent_field->id == $key) { $this_parent_field = $single_parent_field; break; } }
						
						
						
						$return['sections'][$key] = array(
						
							'label' => $this_parent_field->label,
							'fields' => array(),
						
						);
						
						//// WE CAN LOOP THIS SECTION AND ADD THE FIELDS TO OUR ARRAY
						foreach($parent_section as $_child_fields) {
							
							$return['sections'][$key]['fields'][] = $_child_fields;
							
						}
						
					}
					
				}
				
			} else { $return['fields'] = false; }
		
		} else {
		
			if(is_object($all_child_fields)) {
				
				$labels = array();
				
				//// LETS CREATE AN ARRAY WITH ALL LABELS
				foreach($all_parent_fields as $key => $_parent_field) {
					
					$labels[] = $_parent_field;
					
				}
				
				//// GOES THROUGH EACH PARENT
				$i_parent = 0;
				foreach($all_child_fields as $key => $parent_section) {
					
					//// IF THIS PARENT IS WITHIN OUR PARENT FIELDS
					if(in_array($key, $parent_fields)) {
						
						//// LETS ADD THE LABEL FOR THIS SECTION AS AN ARRAY
						//// SO THIS WAY WE CAN GROUP THE FIELDS IN CASE OF AN ARRAY
						
						//// LETS GO THROUGH ALL OUR PARENT FIELDS AND GET THE ONE WITH THE KEY
						foreach($all_parent_fields as $single_parent_field) {
							
							foreach($single_parent_field as $a_parent_field) {
								
								if($a_parent_field->id == $key) { $the_label = $a_parent_field->label; }
								
							}
							
						}
						
						
						$return['sections'][$key] = array(
						
							'label' => $the_label,
							'fields' => array(),
						
						);
						
						//// WE CAN LOOP THIS SECTION AND ADD THE FIELDS TO OUR ARRAY
						foreach($parent_section as $this_key => $_child_fields) {
							
							$return['sections'][$key]['fields'][] = $_child_fields;
							
						}
						
					}
				
					$i_parent++;
					
				}
				
			} else { $return['fields'] = false; }
			
		}
			
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION UPLOADS IMAGES
	//////////////////////////////////////////////////////////////////////
	
	include(locate_template('includes/backend/php/UploadHandler.php'));
	
	add_action('wp_ajax__sf_gallery_upload', '_sf_gallery_upload_function');
	add_action('wp_ajax_nopriv__sf_gallery_upload', '_sf_gallery_upload_function');
	
	function _sf_gallery_upload_function() {
		
		global $wpdb; //Now WP database can be accessed
		global $post;
		
		$image_id = $_POST['data'];
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-gallery-upload-nonce'))
			die('Busted!');
			
		//// VERIFIES IF THE USER CAN INDEED UPLOAD MORE IMAGES IN THIS SPOT
		//// FIRST GET THE TOTAL AMOUNT OF IMAGES ALREADY IN HIS GALLERY
		$images_count = isset($_POST['images_count']) ? trim($_POST['images_count']) : '';
		
		///// GETS THE AMOUNT OF IMAGES HE CAN UPLOAD INTO THIS IMAGE
		$images_max = ddp('pbl_images');
		
		//// IF HE CAN STILL UPLOAD
		if($images_count >= $images_max) {
			
			//// THROWS ERROR
			$return['error'] = true;
			$return['message'] = sprintf2(__('Sorry, you can not upload more than %num image(s).', 'btoa'), array('num' => $images_max));
			
			echo json_encode($return);
			
			exit;
			
		}
		
		if(isset($_FILES['_sf_gallery_upload'])) {
			
			$image_filename = $_FILES['_sf_gallery_upload'];
		
			$_FILES['temp']['name'] = $image_filename['name'][0];
			$_FILES['temp']['type'] = $image_filename['type'][0];
			$_FILES['temp']['tmp_name'] = $image_filename['tmp_name'][0];
			$_FILES['temp']['error'] = $image_filename['error'][0];
			$_FILES['temp']['size'] = $image_filename['size'][0];
			
		} elseif(isset($_FILES['_sf_user_profile_pic_upload'])) {
			
			$image_filename = $_FILES['_sf_user_profile_pic_upload'];
		
			$_FILES['temp']['name'] = $image_filename['name'];
			$_FILES['temp']['type'] = $image_filename['type'];
			$_FILES['temp']['tmp_name'] = $image_filename['tmp_name'];
			$_FILES['temp']['error'] = $image_filename['error'];
			$_FILES['temp']['size'] = $image_filename['size'];
			
		}
		
		$image_filename = $_FILES['temp'];
		
		$override['test_form'] = false; //see http://wordpress.org/support/topic/269518?replies=6
		$override['action'] = 'wp_handle_upload';
		
		if($image_filename['size'] > 5000000) { 
			
			//// THROWS ERROR
			$return['error'] = true;
			$return['message'] = __('You can not upload images bigger than 5mb', 'btoa');
			
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
			
			$w = 150;
			$h = 150;
			
			if(isset($_POST['thumb_size'])) {
				
				$w = array_shift(explode('_', $_POST['thumb_size']));
				$h = array_pop(explode('_', $_POST['thumb_size']));
				
			}
			
			$return['image'] = array(
			
				'thumb' => ddTimthumb($uploaded_image['url'], $w, $h),
				'id' => $id,
			
			);
			
		}
		
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// CHECK FOR OUR CART METABOXES IN CART ONLY
	//////////////////////////////////////////////////////////////////////
	
	function _sf_check_cart_only_meta($post_id) {
		
		//// CHECKS FOR NORMAL METABOXES FIRST
		$fields = array();
		$fields_to_check = array(
		
			'price_images_cart', 
			'price_tags_cart',  
			'price_featured_cart',  
			'price_custom_pin_cart', 
			'price_custom_fields_cart', 
			'price_contact_form_cart', 
			'submission_payment_profile_id', 
			'featured_payment_profile_id',
		
		);
		
		//// GOES THROUGH THESE AND CHECK TO SEE IF ITS ON
		foreach($fields_to_check as $_field) { if(get_post_meta($post_id, $_field, true) == 'on') { $fields[] = $_field; } }
		
		//// NOW GOES THROUGH THE SEARCH FIELDS
	
		///// NOW WE GET ALL OUR SEARCH FIELDS THAT HAVE A PRICE SET
		$args = array(
		
			'post_type' => 'search_field',
			'posts_per_page' => -1,
			'meta_query' => array(
			
				array(
				
					'key' => 'public_field_price',
					'value' => '0',
					'compare' => '>',
					'type' => 'NUMERIC',
				
				)
			
			),
		
		);
		
		$fieldsQ = new WP_Query($args);
		
		while($fieldsQ->have_posts()) { $fieldsQ->the_post();
		
			if(get_post_meta($post_id, '_sf_'.$_field, true) == 'on') { $fields[] = '_sf_'.$_field; }
			if(get_post_meta($post_id, '_sf_'.$_field.'_cart', true) == 'on') { $fields[] = '_sf_'.$_field.'_cart'; }
		
		}
		
		$the_post = get_post($post_id);
		
		///// CHECKS IF USER HAS ALREADY PAID FOR SUBMISSION
		if(ddp('price_submission') != 0 && ddp('price_submission') != '' && $the_post->post_status != 'publish') { if(get_post_meta($post_id, 'price_submission_payment', true) != 'on') { $fields[] = 'price_submission'; } }
		
		///// RETURNS FIELDS
		return $fields;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// CHECK FOR OUR CART METABOXES AND RETURN THEM IN AN ARRAY TO BE SAVED LATER
	//////////////////////////////////////////////////////////////////////
	
	function _sf_check_cart_meta($post_id) {
		
		//// CHECKS FOR NORMAL METABOXES FIRST
		$fields = array();
		$fields_to_check = array(
		
			'price_images', 
			'price_images_cart', 
			'price_tags', 
			'price_tags_cart', 
			'price_custom_pin', 
			'price_custom_pin_cart', 
			'price_featured', 
			'price_featured_cart', 
			'price_custom_fields', 
			'price_custom_fields_cart', 
			'price_contact_form', 
			'price_contact_form_cart', 
			'price_contact_form_cart', 
			'submission_payment_profile_id', 
			'featured_payment_profile_id', 
		
		);
		
		//// GOES THROUGH THESE AND CHECK TO SEE IF ITS ON
		foreach($fields_to_check as $_field) { if(get_post_meta($post_id, $_field, true) == 'on') { $fields[] = $_field; } }
		
		//// NOW GOES THROUGH THE SEARCH FIELDS
	
		///// NOW WE GET ALL OUR SEARCH FIELDS THAT HAVE A PRICE SET
		$args = array(
		
			'post_type' => 'search_field',
			'posts_per_page' => -1,
			'meta_query' => array(
			
				array(
				
					'key' => 'public_field_price',
					'value' => '0',
					'compare' => '>',
					'type' => 'NUMERIC',
				
				)
			
			),
		
		);
		
		$fieldsQ = new WP_Query($args);
		
		while($fieldsQ->have_posts()) { $fieldsQ->the_post();
		
			if(get_post_meta($post_id, '_sf_'.$_field, true) == 'on') { $fields[] = '_sf_'.$_field; }
			if(get_post_meta($post_id, '_sf_'.$_field.'_cart', true) == 'on') { $fields[] = '_sf_'.$_field.'_cart'; }
		
		}
		
		if(ddp('price_submission') != 0 && ddp('price_submission') != '') { if(get_post_meta($post_id, 'price_submission_payment', true) == 'on') { $fields[] = 'price_submission_payment'; } }
		
		///// RETURNS FIELDS
		return $fields;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// UPDATES CART META
	//////////////////////////////////////////////////////////////////////
	
	function _sf_update_cart_meta($post_id, $cart_meta) {
		
		//// GOES FIELD BY FIELD NAD UPDATES IT
		foreach($cart_meta as $_field) {
			
			//// UPDATES IT
			update_post_meta($post_id, $_field, 'on');
			
		}
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION SAVES DRAFTS
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_save', '_sf_save_function');
	add_action('wp_ajax_nopriv__sf_save', '_sf_save_function');
	
	function _sf_save_function() {
		
		$return = array();
		$return['error'] = false;
		$return['error_fields'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-save-nonce'))
			die('Busted!');
			
		//// VERIFIES CURRENT USER IS THE AUTHOR OF THIS POST
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
		if($post = get_post($post_id)) {
			
			$current_user = wp_get_current_user();
			if($post->post_author == $current_user->ID) {
				
				/// FIELDS
				$args = array('ID' => $post_id);
				$fields = array();
				parse_str($_POST['data'], $fields);
				
				//$return['fields'] = '';
				//foreach($fields as $key => $field) { $return['fields'] .= ' --- '.$key.' -> '.$field; };
				
				//// FIRSTLY LET US SAVE THE TITLE
				$title = $fields['_sf_title'];
				if($title == '') { $title = __('Draft', 'btoa'); }
				$args['post_title'] = $title;
				
				//// CONTENT
				$args['post_content'] = $fields['_sf_spot_content'];
				
				//// DATE
				$args['post_date'] = date('Y-m-d H:i:s', time());
				$args['post_date_gmt'] = gmdate('Y-m-d H:i:s', time());
				
				//// STATUS - BUT ONLY IF NOT ALREADY PUBLISHED
				if($post->post_status == 'draft' || $post->post_status == 'auto-draft') { $args['post_status'] = 'draft'; }
				else { $args['post_status'] = $post->post_status; } //// WE SAVE IT AS PENDING IF ITS PENDING
				
				//// WE NEED TO LOOK FOR ADD TO CART METABOXES THAT ARE ON AND SAVE THEM WITH OUR DRAFT
				$cart_meta = _sf_check_cart_meta($post_id);
				
				//// FINALLY SAVES AS A DRAFT
				wp_update_post($args);
				
				//// UPDATES CART META
				if(count($cart_meta) > 0) { _sf_update_cart_meta($post_id, $cart_meta); }
				
				//// GOES THROUGH OUR IMAGES ARRAY NAD MAKES SURE WE ARE SAVING JUST THE AMOUNT WE HAVE TO
				$images = json_decode(stripslashes($fields['_sf_gallery']));
				if(is_object($images)) {
					
					$max_images = _sf_get_maximum_images($post_id); $i = 0;
					$the_images = new stdClass();
					foreach($images as $_image) {
						
						if($i < $max_images) { $the_images->$i = $_image; }
						$i++;
						
					}
					update_post_meta($post_id, '_sf_gallery_images', htmlspecialchars(json_encode($the_images)));
				
				}
				
				//// SAVES THE SLOGAN
				$slogan = $fields['_sf_slogan'];
				update_post_meta($post_id, 'slogan', $slogan);
				
				
				
				//// CATEGORY – FIRST MAKES SURE WE CAN SELECT MULTIPLE OR JUST ONE CATEGORY
				if(isset($fields['_sf_category'])) {
						
					$categories = $fields['_sf_category'];
					if(ddp('pbl_cats') != 'on' && is_array($categories)) {
						
						//// ONLY SELECT THE FIRST ONE
						$categories = array($categories[0]);
						
					}
					/// UPDATES CATEGORIES
					wp_set_post_terms($post_id, $categories, 'spot_cats');
				
				}
				
				
				
				//// TAGS – MAKES SURE USER CAN ONLY ADD THE LIMIT NUMBER OF TAGS
				if($fields['_sf_tags'] != '') {
					
					$tags = json_decode(stripslashes(stripslashes($fields['_sf_tags'])));
					$max_tags = _sf_get_maximum_tags($post_id); $i = 0;
					$the_tags = array();
					foreach($tags as $_tag) {
						
						if($i < $max_tags) { $the_tags[] = $_tag; }
						$i++; 
						
					}
					
					//// UPDATES TAGS
					wp_set_post_terms($post_id, $the_tags, 'spot_tags', false);
					
				}
				
				
				//// SAVES ADDRESS
				$address = $fields['_sf_address'];
				update_post_meta($post_id, 'address', htmlspecialchars($address));
				
				
				//// SAVES LOCATION
				$lat = trim($fields['_sf_latitude']);
				$lng = trim($fields['_sf_longitude']);
				update_post_meta($post_id, 'latitude', $lat);
				update_post_meta($post_id, 'longitude', $lng);
				
				
				//// SAVES CONTACT FORM
				if(_sf_check_contact_form($post_id)) {
								
					//// IF IS TURNED ON
					if($fields['_sf_contact_form'] == 'on') {
						
						//// UPDATES IT
						update_post_meta($post_id, 'contact_form', 'on');
						
					} else {
						
						update_post_meta($post_id, 'contact_form', '');
						
					}
					
				} else { update_post_meta($post_id, 'contact_form', ''); }
				
				
				
				//// SAVES FEATURED SELECTION
				if(_sf_check_featured_selection($post_id)) {
								
					//// IF IS TURNED ON
					if($fields['_sf_featured'] == 'on') {
						
						//// UPDATES IT
						update_post_meta($post_id, 'featured', 'on');
						
					} else {
						
						update_post_meta($post_id, 'featured', '');
						
					}
					
				} else { update_post_meta($post_id, 'featured', ''); }
				
				
				
				//// SAVES CUSTOM PIN
				if(_sf_check_custom_pin($post_id)) {
					
					$pin = $fields['_sf_custom_pin'];
					update_post_meta($post_id, 'pin', $pin);
					
				}
				
				
				//// SAVES CUSTOM FIELDS
				if(ddp('pbl_custom_fields') == 'on') {
					
					if(isset($fields['_sf_custom_fields'])) {
						
						$custom_fields_test = json_decode(stripslashes(stripslashes($fields['_sf_custom_fields'])));
						
						//// IF IS OBJECT
						if(is_object($custom_fields_test)) {
							
							//// STRIP HTML TAGS
							$custom_fields = htmlspecialchars(stripslashes(stripslashes(strip_tags($fields['_sf_custom_fields']))));
							
							//// SAVES FIELDS
							update_post_meta($post_id, '_sf_custom_fields', $custom_fields);
							
						}
						
					}
					
				}
				
				
				//// OUR SEARCH FIELDS
				//// GOES THROUGH EACH FIELD AND CHECKS IF IT IS A CUSTOM FIELD OR A SUBMISSION FIELD
				foreach($fields as $key => $_search_field) {
					
					//// IF ITS A CUSTOM SUBMISISON FIELD
					if(strpos($key, '_sf_submission_field_') !== false) {
						
						//// LETS GET OUR FIELD IF
						$field_id = explode('_', $key);
						$field_id = $field_id[4];
						
						//// LETS TRY AND GET OUR POST
						if($the_field = get_post($field_id)) {
							
							/// IF ITS INDEED A CUSTOM FIELD
							if($the_field->post_type == 'submission_field') {
								
								//// IF ITS A TEXT FIELD LETS SEE IF WE ALLOW HTML SO WE CAN STRIP OUR TAGS
								$value =  $fields['_sf_submission_field_'.$field_id];
								if(get_post_meta($field_id, 'field_type', true) == 'text') {
									
									//// ITS TEXT CHECK FOR HTML
									if(get_post_meta($field_id, 'allow_html', true) != 'on') {
										
										strip_tags($value);
										
									}
									
								} //// ENDS IF ITS TEXT
								
								//// FI ITS A FILE WE NEED TO STRIP SLASHES TO STORE IT PROPERLY
								if(get_post_meta($field_id, 'field_type', true) == 'file') {
									
									$value = htmlspecialchars(stripslashes(stripslashes(strip_tags(htmlspecialchars_decode($value)))));
									
								}
								
								///// STORES IT
								update_post_meta($post_id, '_sf_submission_field_'.$field_id, $value);
								
							}
							
						}
						
					}
					
					//// IF IT CONTAINS THE BASIC OF OUR NAME
					elseif(strpos($key, '_sf_field') !== false) {
						
						/// FIELD IS
						$field_id = explode('_', $key);
						$field_id = $field_id[3];
						
						//// IF IT'S A SEARCH FIELD
						if($the_field = get_post($field_id)) {
							
							
							///////////////////////////////////
							//// IF IT'S A CHECKBOX
							///////////////////////////////////
							if(get_post_meta($the_field->ID, 'field_type', true) == 'check') {
								
								//// IF IS TURNED ON
								if($fields['_sf_field_'.$field_id] == 'on') {
									
									//// UPDATES IT
									update_post_meta($post_id, '_sf_field_'.$the_field->ID, 'on');
									
								} else {
									
									//// UPDATES IT
									update_post_meta($post_id, '_sf_field_'.$the_field->ID, '');
									
								}
								
							}
							
							
							///////////////////////////////////
							//// IF IT'S A RANGE
							///////////////////////////////////
							else if(get_post_meta($the_field->ID, 'field_type', true) == 'range') {
								
								//// MAKES SURE THE VALUE IS AN INTEGER
								if(is_numeric($fields['_sf_field_'.$field_id]) || empty($fields['_sf_field_'.$field_id])) {
									
									//// GETS MIN AND MAX VALUES
									$min = get_post_meta($field_id, 'range_minimum', true);
									$max = get_post_meta($field_id, 'range_maximum', true);
									
									//// MAKE SURE IT'S WITHIN THE PERMITTED VALUES
									if($fields['_sf_field_'.$field_id] >= $min && $fields['_sf_field_'.$field_id]<= $max) {
										
										//// STORES THE VALUES
										update_post_meta($post_id, '_sf_field_'.$the_field->ID, $fields['_sf_field_'.$field_id]);
										
									} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_range_'.$field_id.'_wrapper', 'message' => sprintf2(__('Sorry, Your value must be between %min and %max.', 'btoa'),array('min' => $min, 'max' => $max)), 'inside' => 'true'); }
									
								} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_range_'.$field_id.'_wrapper', 'message' => __('Your input must be a whole number.', 'btoa'), 'inside' => 'true'); }
								
							}
							
							
							///////////////////////////////////
							//// IF IT'S A MAX VALUE
							///////////////////////////////////
							else if(get_post_meta($the_field->ID, 'field_type', true) == 'max_val') {
								
								//// IF IS SET
								if(!empty($fields['_sf_field_'.$field_id])) {
								
									//// MAKES SURE THE VALUE IS AN INTEGER
									if(is_numeric($fields['_sf_field_'.$field_id]) || empty($fields['_sf_field_'.$field_id])) {
											
										//// STORES THE VALUES
										update_post_meta($post_id, '_sf_field_'.$the_field->ID, $fields['_sf_field_'.$field_id]);
										
									} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_'.$field_id.'_field', 'message' => __('Your input must be a number.', 'btoa'), 'inside' => 'true'); }
								
								}
								
							}
							
							
							///////////////////////////////////
							//// IF IT'S A MIN VALUE
							///////////////////////////////////
							else if(get_post_meta($the_field->ID, 'field_type', true) == 'min_val') {
								
								//// MAKES SURE THE VALUE IS AN INTEGER
								if(is_numeric($fields['_sf_field_'.$field_id]) || empty($fields['_sf_field_'.$field_id])) {
										
									//// STORES THE VALUES
									update_post_meta($post_id, '_sf_field_'.$the_field->ID, $fields['_sf_field_'.$field_id]);
									
								} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_'.$field_id.'_field', 'message' => __('Your input must be a number.', 'btoa'), 'inside' => 'true'); }
								
							}
							
							
							///////////////////////////////////
							//// IF IT'S A DROPDOWN
							///////////////////////////////////
							else if(get_post_meta($the_field->ID, 'field_type', true) == 'dropdown') {
								
								//// IF IT'S NOT AN ARRAY - WE MAKE IT AN ARRAY
								if(!is_array($fields['_sf_field_'.$field_id])) { $dropdown_field = array($fields['_sf_field_'.$field_id]); }
								else { $dropdown_field = $fields['_sf_field_'.$field_id]; }
								
								//// UPDATES IT
								update_post_meta($post_id, '_sf_field_'.$the_field->ID, $dropdown_field);
								
							}
							
							
							///////////////////////////////////
							//// IF IT'S A DEPENDENT
							///////////////////////////////////
							else if(get_post_meta($the_field->ID, 'field_type', true) == 'dependent') {
								
								//// IF IT'S NOT AN ARRAY - WE MAKE IT AN ARRAY
								if(!is_array($fields['_sf_field_'.$field_id])) { $dependent_field = array($fields['_sf_field_'.$field_id]); }
								else { $dependent_field = $fields['_sf_field_'.$field_id]; }
								
								//// UPDATES IT
								update_post_meta($post_id, '_sf_field_'.$the_field->ID, $dependent_field);
								
							}
							
						}
					
					}
					
				}
				
			}
			
		}
		
		
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS SUBMITS SPOTS
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_submit', '_sf_submit_function');
	add_action('wp_ajax_nopriv__sf_submit', '_sf_submit_function');
	
	function _sf_submit_function() {
		
		$return = array();
		$return['error'] = false;
		$return['error_fields'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-submit-nonce'))
			die('Busted!');
			
		//// VERIFIES CURRENT USER IS THE AUTHOR OF THIS POST
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
				
		if($post = get_post($post_id)) {
			
			//// CHECK FI THERE"S ANYTHING IN THE CART, IF SO, DO NOT PUBLISH
			$cart_meta = _sf_check_cart_only_meta($post_id);
			
			$return['cart_meta'] = $cart_meta;
			
			//// IF NO CART ITEMS
			if(count($cart_meta) > 0) {
				
				$return['error'] = true;
				$return['message'] = __('There are still items in your cart. Please make the payment or remove items from your cart before submitting.', 'btoa');
				
			} else {
			
				$current_user = wp_get_current_user();
				if($post->post_author == $current_user->ID) {
					
					/// FIELDS
					$args = array('ID' => $post_id);
					$fields = array();
					parse_str($_POST['data'], $fields);
					
					//$return['fields'] = '';
					//foreach($fields as $key => $field) { $return['fields'] .= ' --- '.$key.' -> '.$field; };
					
					//// FIRSTLY LET US SAVE THE TITLE
					$title = $fields['_sf_title'];
					$args['post_title'] = $title;
					
					//// CONTENT
					$args['post_content'] = strip_tags($fields['_sf_spot_content'], '<h2><h3><h4><h5><h6><a><p><ul><ol><strong><b><em><i><del><ins><img><li><code><small><big><br>');
					
					//// DATE
					//$args['post_date'] = date('Y-m-d H:i:s', time());
					//$args['post_date_gmt'] = gmdate('Y-m-d H:i:s', time());
					
					//// STATUS
					if(ddp('pbl_publish') == 'on' || $post->post_status == 'publish') { $args['post_status'] = 'publish'; }
					else { $args['post_status'] = 'pending'; }
					
					//// IF IT"S ALREADY PUBLISHED AND WE ARE EDITING, WE NEED TO SENT THE ADMIN AN EMAIL
					if($post->post_status == 'publish') { _sf_post_editing($post); }
					
					//// WE NEED TO LOOK FOR ADD TO CART METABOXES THAT ARE ON AND SAVE THEM WITH OUR DRAFT
					$cart_meta = _sf_check_cart_meta($post_id);
					
					//// FINALLY SAVES
					wp_update_post($args);
					
					//// UPDATES CART META
					if(count($cart_meta) > 0) { _sf_update_cart_meta($post_id, $cart_meta); }
					
					//// GOES THROUGH OUR IMAGES ARRAY NAD MAKES SURE WE ARE SAVING JUST THE AMOUNT WE HAVE TO
					$images = json_decode(stripslashes(stripslashes($fields['_sf_gallery'])));
					if(is_object($images)) {
						
						$max_images = _sf_get_maximum_images($post_id); $i = 0;
						$the_images = new stdClass();
						foreach($images as $_image) {
							
							if($i < $max_images) { $the_images->$i = $_image; }
							$i++;
							
						}
						update_post_meta($post_id, '_sf_gallery_images', htmlspecialchars(json_encode($the_images)));
					
					}
					
					//// SAVES THE SLOGAN
					$slogan = $fields['_sf_slogan'];
					update_post_meta($post_id, 'slogan', $slogan);
					
					
					
					//// CATEGORY – FIRST MAKES SURE WE CAN SELECT MULTIPLE OR JUST ONE CATEGORY
					if(isset($fields['_sf_category'])) {
							
						$categories = $fields['_sf_category'];
						if(ddp('pbl_cats') != 'on' && is_array($categories)) {
							
							//// ONLY SELECT THE FIRST ONE
							$categories = array($categories[0]);
							
						}
						/// UPDATES CATEGORIES
						wp_set_post_terms($post_id, $categories, 'spot_cats');
					
					}
					
					
					
					//// TAGS – MAKES SURE USER CAN ONLY ADD THE LIMIT NUMBER OF TAGS
					if($fields['_sf_tags'] != '') {
						
						$tags = json_decode(stripslashes(stripslashes($fields['_sf_tags'])));
						$max_tags = _sf_get_maximum_tags($post_id); $i = 0;
						$the_tags = array();
						foreach($tags as $_tag) {
							
							if($i < $max_tags) { $the_tags[] = $_tag; }
							$i++; 
							
						}
						
						//// UPDATES TAGS
						wp_set_post_terms($post_id, $the_tags, 'spot_tags', false);
						
					}
					
					
					//// SAVES ADDRESS
					$address = $fields['_sf_address'];
					update_post_meta($post_id, 'address', htmlspecialchars($address));
					
					
					//// SAVES LOCATION
					$lat = $fields['_sf_latitude'];
					$lng = $fields['_sf_longitude'];
					update_post_meta($post_id, 'latitude', $lat);
					update_post_meta($post_id, 'longitude', $lng);
					
					
					//// SAVES CUSTOM PIN
					if(_sf_check_custom_pin($post_id)) {
						
						$pin = $fields['_sf_custom_pin'];
						update_post_meta($post_id, 'pin', $pin);
						
					}
					
					
					//// SAVES CONTACT FORM
					if(_sf_check_contact_form($post_id)) {
									
						//// IF IS TURNED ON
						if($fields['_sf_contact_form'] == 'on') {
							
							//// UPDATES IT
							update_post_meta($post_id, 'contact_form', 'on');
							
						} else {
							
							update_post_meta($post_id, 'contact_form', '');
							
						}
						
					} else { update_post_meta($post_id, 'contact_form', ''); }
				
				
				
					//// SAVES FEATURED SELECTION
					if(_sf_check_featured_selection($post_id)) {
									
						//// IF IS TURNED ON
						if($fields['_sf_featured'] == 'on') {
							
							//// UPDATES IT
							update_post_meta($post_id, 'featured', 'on');
							
						} else {
							
							update_post_meta($post_id, 'featured', '');
							
						}
						
					} else { update_post_meta($post_id, 'featured', ''); }
					
					
					//// SAVES CUSTOM FIELDS
					if(ddp('pbl_custom_fields') == 'on' && _sf_check_custom_fields($post_id)) {
						
						if(isset($fields['_sf_custom_fields'])) {
							
							$custom_fields_test = json_decode(stripslashes(stripslashes($fields['_sf_custom_fields'])));
							
							//// IF IS OBJECT
							if(is_object($custom_fields_test)) {
								
								//// STRIP HTML TAGS
								$custom_fields = htmlspecialchars(strip_tags($fields['_sf_custom_fields']));
								
								//// SAVES FIELDS
								update_post_meta($post_id, '_sf_custom_fields', $custom_fields);
								
							}
							
						}
						
					}
					
					
					///// IF WE HAVE A RATING MAKE SURE WE SET THE INITIAL TO 0 - IF OF COURSE WE HAVE A ZERO VALUE
					if(ddp('rating') == 'on') {
						
						if(is_numeric(get_post_meta($post_id, 'rating', true))) {
							
							update_post_meta($post_id, 'rating', get_post_meta($post_id, 'rating', true));
							
						} else {
							
							update_post_meta($post_id, 'rating', 0);
							
						}
						
						if(is_numeric(get_post_meta($post_id, 'rating_count', true))) {
							
							update_post_meta($post_id, 'rating_count', get_post_meta($post_id, 'rating_count', true));
							
						} else {
							
							update_post_meta($post_id, 'rating_count', 0);
							
						}
						
					}
					
					//// OUR SEARCH FIELDS
					//// GOES THROUGH EACH FIELD AND CHECKS IF IT IS A CUSTOM FIELD
					foreach($fields as $key => $_search_field) {
					
						//// IF ITS A CUSTOM SUBMISISON FIELD
						if(strpos($key, '_sf_submission_field_') !== false) {
							
							//// LETS GET OUR FIELD IF
							$field_id = explode('_', $key);
							$field_id = $field_id[4];
							
							//// LETS TRY AND GET OUR POST
							if($the_field = get_post($field_id)) {
								
								/// IF ITS INDEED A CUSTOM FIELD
								if($the_field->post_type == 'submission_field') {
									
									//// IF ITS A TEXT FIELD LETS SEE IF WE ALLOW HTML SO WE CAN STRIP OUR TAGS
									$value =  $fields['_sf_submission_field_'.$field_id];
									if(get_post_meta($field_id, 'field_type', true) == 'text') {
										
										//// ITS TEXT CHECK FOR HTML
										if(get_post_meta($field_id, 'allow_html', true) != 'on') {
											
											strip_tags($value);
											
										}
										
									} //// ENDS IF ITS TEXT
									
									//// FI ITS A FILE WE NEED TO STRIP SLASHES TO STORE IT PROPERLY
									if(get_post_meta($field_id, 'field_type', true) == 'file') {
										
										$value = htmlspecialchars(stripslashes(stripslashes(strip_tags(htmlspecialchars_decode($value)))));
										
									}
									
									///// STORES IT
									update_post_meta($post_id, '_sf_submission_field_'.$field_id, $value);
									
								}
								
							}
							
						}
						
						//// IF IT CONTAINS THE BASIC OF OUR NAME
						elseif(strpos($key, '_sf_field') !== false) {
							
							/// FIELD IS
							$field_id = explode('_', $key);
							$field_id = $field_id[3];
							
							//// IF IT'S A SEARCH FIELD
							if($the_field = get_post($field_id)) {
								
								//// MAKES SURE ITS NOT PAID, AND IF IT IS, THAT USER HAS PAID FOR IT
								$field_paid = true;
								if(get_post_meta($the_field->ID, 'public_field_price', true) != '' && get_post_meta($the_field->ID, 'public_field_price', true) != '0') {
									
									$field_paid = false;
									
									//// IF USER HAS PAID FOR IT WE SET TO TRUE 
									if(get_post_meta($post_id, '_sf_'.$the_field->ID, true) == 'on') { $field_paid = true; }
									else { update_post_meta($post_id, '_sf_'.$the_field->ID, ''); update_post_meta($post_id, '_sf_field_'.$the_field->ID, ''); } /// TURN IT OFF AND DONT SAVE IT
									
								}
								
								///// IF USER HAS PAID FOR IT - AND IF THE FIELD IS FREE
								if($field_paid) {
								
									///////////////////////////////////
									//// IF IT'S A CHECKBOX
									///////////////////////////////////
									if(get_post_meta($the_field->ID, 'field_type', true) == 'check') {
										
										//// IF IS TURNED ON
										if($fields['_sf_field_'.$field_id] == 'on') {
											
											//// UPDATES IT
											update_post_meta($post_id, '_sf_field_'.$the_field->ID, 'on');
											
										} else {
											
											//// UPDATES IT
											update_post_meta($post_id, '_sf_field_'.$the_field->ID, '');
											
										}
										
									}
									
									
									///////////////////////////////////
									//// IF IT'S A RANGE
									///////////////////////////////////
									else if(get_post_meta($the_field->ID, 'field_type', true) == 'range') {
										
										//// MAKES SURE THE VALUE IS AN INTEGER
										if(is_numeric($fields['_sf_field_'.$field_id]) || empty($fields['_sf_field_'.$field_id])) {
											
											//// GETS MIN AND MAX VALUES
											$min = get_post_meta($field_id, 'range_minimum', true);
											$max = get_post_meta($field_id, 'range_maximum', true);
											
											//// MAKE SURE IT'S WITHIN THE PERMITTED VALUES
											if($fields['_sf_field_'.$field_id] >= $min && $fields['_sf_field_'.$field_id]<= $max) {
												
												//// STORES THE VALUES
												update_post_meta($post_id, '_sf_field_'.$the_field->ID, $fields['_sf_field_'.$field_id]);
												
											} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_range_'.$field_id.'_wrapper', 'message' => sprintf2(__('Sorry, Your value must be between %min and %max.', 'btoa'),array('min' => $min, 'max' => $max)), 'inside' => 'true'); }
											
										} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_range_'.$field_id.'_wrapper', 'message' => __('Your input must be a whole number.', 'btoa'), 'inside' => 'true'); }
										
									}
									
									
									///////////////////////////////////
									//// IF IT'S A MAX VALUE
									///////////////////////////////////
									else if(get_post_meta($the_field->ID, 'field_type', true) == 'max_val') {
										
										//// IF IS SET
										if(!empty($fields['_sf_field_'.$field_id])) {
										
											//// MAKES SURE THE VALUE IS AN INTEGER
											if(is_numeric($fields['_sf_field_'.$field_id]) || empty($fields['_sf_field_'.$field_id])) {
													
												//// STORES THE VALUES
												update_post_meta($post_id, '_sf_field_'.$the_field->ID, $fields['_sf_field_'.$field_id]);
												
											} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_'.$field_id.'_field', 'message' => __('Your input must be a number.', 'btoa'), 'inside' => 'true'); }
										
										}
										
									}
									
									
									///////////////////////////////////
									//// IF IT'S A MIN VALUE
									///////////////////////////////////
									else if(get_post_meta($the_field->ID, 'field_type', true) == 'min_val') {
										
										//// MAKES SURE THE VALUE IS AN INTEGER
										if(is_numeric($fields['_sf_field_'.$field_id]) || empty($fields['_sf_field_'.$field_id])) {
												
											//// STORES THE VALUES
											update_post_meta($post_id, '_sf_field_'.$the_field->ID, $fields['_sf_field_'.$field_id]);
											
										} else { $return['error'] = true; $return['error_fields'][] = array('field_id' => '_sf_field_'.$field_id.'_field', 'message' => __('Your input must be a number.', 'btoa'), 'inside' => 'true'); }
										
									}
									
									
									///////////////////////////////////
									//// IF IT'S A DROPDOWN
									///////////////////////////////////
									else if(get_post_meta($the_field->ID, 'field_type', true) == 'dropdown') {
										
										//// IF IT'S NOT AN ARRAY - WE MAKE IT AN ARRAY
										if(!is_array($fields['_sf_field_'.$field_id])) { $dropdown_field = array($fields['_sf_field_'.$field_id]); }
										else { $dropdown_field = $fields['_sf_field_'.$field_id]; }
										
										//// UPDATES IT
										update_post_meta($post_id, '_sf_field_'.$the_field->ID, $dropdown_field);
										
									}
									
									
									///////////////////////////////////
									//// IF IT'S A DEPENDENT
									///////////////////////////////////
									else if(get_post_meta($the_field->ID, 'field_type', true) == 'dependent') {
										
										//// IF IT'S NOT AN ARRAY - WE MAKE IT AN ARRAY
										if(!is_array($fields['_sf_field_'.$field_id])) { $dependent_field = array($fields['_sf_field_'.$field_id]); }
										else { $dependent_field = $fields['_sf_field_'.$field_id]; }
										
										//// UPDATES IT
										update_post_meta($post_id, '_sf_field_'.$the_field->ID, $dependent_field);
										
									}
								
								}
								
							}
						
						}
						
					}
					
					//// IF THERE WERE NO ERRORS
					if($return['error'] == false) {
						
						/// IF EVERYTHING WAS SUCCESSFULL
						$return['result'] = 'success';
						
						//// SENDS AN EMAIL TO THE ADMIN
						//// IF ITS FOR REVIEW
						if(ddp('pbl_publish') != 'on') {
							
							$message = sprintf2(__("Dear Admin,
						
A submission has been submitted for review at %site_name. Please review it at %review_link.

Kind Regards,
The %site_name team.", 'btoa'), array(
						
								'site_name' => get_bloginfo('name'),
								'review_link' => admin_url('post.php?post='.$post_id.'&action=edit'),
						
							));
						
						} else { /// IF PUBLISH DIRECTLY
							
							$message = sprintf2(__("Dear Admin,
						
A submission has been submitted at %site_name. Here is the submission %the_link.

Kind Regards,
The %site_name team.", 'btoa'), array(
						
								'site_name' => get_bloginfo('name'),
								'the_link' => get_permalink($post_id),
						
							));
							
						}
						
						$to = get_bloginfo('admin_email');
						$subject = sprintf2(__('Submission at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
						$headers = 'From: '.get_bloginfo('name').' <'.get_bloginfo('admin_email').'>' . "\r\n";
						
						//// SENDS EMAIL
						wp_mail($to, $subject, $message, $headers);
						
					}
					
				}
				
			}
			
		}
		
		echo json_encode($return);
		
		exit;
		
	}

	
	//////////////////////////////////////////////////////////////////////
	///// THIS SUBMITS SPOTS TRANSLATIONS
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_submit_translation', '_sf_submit_translation_function');
	add_action('wp_ajax_nopriv__sf_submit_translation', '_sf_submit_translation_function');
	
	function _sf_submit_translation_function() {
		
		$return = array();
		$return['error'] = false;
		$return['error_fields'] = array();
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-submit-translation-nonce'))
			die('Busted!');
			
		//// VERIFIES CURRENT USER IS THE AUTHOR OF THIS POST
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
				
		if($post = get_post($post_id)) {
			
			$current_user = wp_get_current_user();
			if($post->post_author == $current_user->ID) {
				
				/// FIELDS
				$args = array('ID' => $post_id);
				$fields = array();
				parse_str($_POST['data'], $fields);
				
				//// FIRSTLY LET US SAVE THE TITLE
				$title = $fields['_sf_title'];
				$args['post_title'] = $title;
				
				//// CONTENT
				$args['post_content'] = strip_tags($fields['_sf_spot_content'], '<h2><h3><h4><h5><h6><a><p><ul><ol><strong><b><em><i><del><ins><img><li><code><small><big><br>');
				
				//// STATUS
				if(ddp('pbl_publish') == 'on' || $post->post_status == 'publish') { $args['post_status'] = 'publish'; }
				else { $args['post_status'] = 'pending'; }
				
				//// IF IT"S ALREADY PUBLISHED AND WE ARE EDITING, WE NEED TO SENT THE ADMIN AN EMAIL
				if($post->post_status == 'publish') { _sf_post_editing($post); }
				
				//// WE NEED TO LOOK FOR ADD TO CART METABOXES THAT ARE ON AND SAVE THEM WITH OUR DRAFT
				$cart_meta = _sf_check_cart_meta($post_id);
				
				//// FINALLY SAVES
				wp_update_post($args);
				
				//// UPDATES CART META
				if(count($cart_meta) > 0) { _sf_update_cart_meta($post_id, $cart_meta); }
				
				//// SAVES THE SLOGAN
				$slogan = $fields['_sf_slogan'];
				update_post_meta($post_id, 'slogan', $slogan);
				
				
				//// SAVES ADDRESS
				$address = $fields['_sf_address'];
				update_post_meta($post_id, 'address', htmlspecialchars($address));
				
				
				//// SAVES CUSTOM FIELDS
				if(ddp('pbl_custom_fields') == 'on' && _sf_check_custom_fields($post_id)) {
					
					if(isset($fields['_sf_custom_fields'])) {
						
						$custom_fields_test = json_decode(stripslashes(stripslashes($fields['_sf_custom_fields'])));
						
						//// IF IS OBJECT
						if(is_object($custom_fields_test)) {
							
							//// STRIP HTML TAGS
							$custom_fields = htmlspecialchars(strip_tags($fields['_sf_custom_fields']));
							
							//// SAVES FIELDS
							update_post_meta($post_id, '_sf_custom_fields', $custom_fields);
							
						}
						
					}
					
				}
					
				//// OUR SEARCH FIELDS
				//// GOES THROUGH EACH FIELD AND CHECKS IF IT IS A CUSTOM FIELD
				foreach($fields as $key => $_search_field) {
				
					//// IF ITS A CUSTOM SUBMISISON FIELD
					if(strpos($key, '_sf_submission_field_') !== false) {
						
						//// LETS GET OUR FIELD IF
						$field_id = explode('_', $key);
						$field_id = $field_id[4];
						
						//// LETS TRY AND GET OUR POST
						if($the_field = get_post($field_id)) {
							
							/// IF ITS INDEED A CUSTOM FIELD
							if($the_field->post_type == 'submission_field') {
								
								//// IF ITS A TEXT FIELD LETS SEE IF WE ALLOW HTML SO WE CAN STRIP OUR TAGS
								$value =  $fields['_sf_submission_field_'.$field_id];
								if(get_post_meta($field_id, 'field_type', true) == 'text') {
									
									//// ITS TEXT CHECK FOR HTML
									if(get_post_meta($field_id, 'allow_html', true) != 'on') {
										
										strip_tags($value);
										
									}
									
								} //// ENDS IF ITS TEXT
								
								//// FI ITS A FILE WE NEED TO STRIP SLASHES TO STORE IT PROPERLY
								if(get_post_meta($field_id, 'field_type', true) == 'file') {
									
									$value = htmlspecialchars(stripslashes(stripslashes(strip_tags(htmlspecialchars_decode($value)))));
									
								}
								
								///// STORES IT
								update_post_meta($post_id, '_sf_submission_field_'.$field_id, $value);
								
							}
							
						}
						
					}
					
				}
				
				//// IF THERE WERE NO ERRORS
				if($return['error'] == false) {
					
					/// IF EVERYTHING WAS SUCCESSFULL
					$return['result'] = 'success';
					
					//// SENDS AN EMAIL TO THE ADMIN
					//// IF ITS FOR REVIEW
					if(ddp('pbl_publish') != 'on') {
						
						$message = sprintf2(__("Dear Admin,
					
A submission has been submitted for review at %site_name. Please review it at %review_link.

Kind Regards,
The %site_name team.", 'btoa'), array(
					
							'site_name' => get_bloginfo('name'),
							'review_link' => admin_url('post.php?post='.$post_id.'&action=edit'),
					
						));
					
					} else { /// IF PUBLISH DIRECTLY
						
						$message = sprintf2(__("Dear Admin,
					
A submission has been submitted at %site_name. Here is the submission %the_link.

Kind Regards,
The %site_name team.", 'btoa'), array(
					
							'site_name' => get_bloginfo('name'),
							'the_link' => get_permalink($post_id),
					
						));
						
					}
					
					$to = get_bloginfo('admin_email');
					$subject = sprintf2(__('Submission at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
					$headers = 'From: '.get_bloginfo('name').' <'.get_bloginfo('admin_email').'>' . "\r\n";
					
					//// SENDS EMAIL
					wp_mail($to, $subject, $message, $headers);
					
				}
				
			}
			
		}
		
		echo json_encode($return);
		
		exit;
		
	}
	
	
	////// IN CASE WE ARE EITING THE POST THE ADMIN NEEDS TO GET NOTIFIED
	function _sf_post_editing($post) {
		
		//// SA_MESSAGES
		$message = sprintf2(__("Dear Admin,
		
The submission %post_name has been edited at %site_name,

Please review the edit at %post_link.", 'btoa'), array(
		
			'post_name' => $post->post_title,
			'site_name' => get_bloginfo('name'),
			'post_link' => get_permalink($post->ID),
		
		));
		
		$subject = sprintf2(__('Submission edited at %site_name', 'btoa'), array(
		
			'site_name' => get_bloginfo('name'),
		
		));
		
		$to = get_option('admin_email');
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>'."\r\n";
		
		wp_mail($to, $subject, $message, $headers);
		
	}
	
	
	
	///// DELETES SUBMISSION
	add_action('wp_ajax__sf_delete_submission', '_sf_delete_submission_function');
	add_action('wp_ajax_nopriv__sf_delete_submission', '_sf_delete_submission_function');
	
	function _sf_delete_submission_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-delete-submission-nonce'))
			die('Busted!');
			
		//// POST ID
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
		if($post_id != '' && $post = get_post($post_id)) {
			
			//// MAKES SURE THE USER IS THE AUTHOR OF THIS SUBMISSION
			$the_user = wp_get_current_user();
			$user_id = $the_user->ID;
			
			if($post->post_author == $user_id) {
				
				//// TRASHES THE POST
				$args = array('ID' => $post_id);
				$args['post_status'] = 'trash';
				
				//// FINALLY SAVES AS A DRAFT
				wp_update_post($args);
				
				$return['message'] = __('Submission successfully deleted.', 'btoa');
				
			} else { $return['error'] = true; $return['message'] = __('You can not delete submissions that are not your own.', 'btoa'); }
			
		} else { $return['error'] = true; $return['message'] = __('The submission you are trying to delete does not exist.', 'btoa'); }
		
		echo json_encode($return);
		exit;
		
	}
	
	
	
	///// REFRESHES CART
	add_action('wp_ajax__sf_refresh_cart', '_sf_refresh_cart_function');
	add_action('wp_ajax_nopriv__sf_refresh_cart', '_sf_refresh_cart_function');
	
	function _sf_refresh_cart_function() {
		
		$return = array();
		$return['error'] = false;
		$return['cart_items'] = array();
		$return['cart_total'] = 0;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-refresh-cart-nonce'))
			die('Busted!');
			
		//// POST ID
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
		$the_post = get_post($post_id);
		
		//// LETS START WITH OUR SUBMISSION
		if(ddp('price_submission') != '' && ddp('price_submission') != '0' && $the_post->post_status != 'publish') {
			
			//// CHECKS IF USER HAS ALREADY PAID
			if(get_post_meta($post_id, 'price_submission_payment', true) != 'on') {
				
				//// IF WE HAVE A DATE SET WE CHANGE THE TEXT TO SHOW OUR DATA
				if(ddp('submission_days') != '' && ddp('submission_days') != '0') { $description = sprintf2(__('Publish your submission for %num days.', 'btoa'), array('num' => ddp('submission_days'))); }
				else { $description = __('Publish your submission', 'btoa'); }
				
				$this_price = format_price(ddp('price_submission'));
				
				//// IF IT'S RECURRING WE NEED TO ADD A PER CYCLE INFO
				if(ddp('price_submission_recurring') == 'on' && ddp('submission_days') != '' && ddp('submission_days') != 0) {
					
					$this_price = '<span onMouseOver="jQuery(this)._sf_show_recurring_tooltip();" onMouseOut="jQuery(this)._sf_hide_recurring_tooltip();">'.__('(recurring?)', 'btoa').' <input type="checkbox" id="_sf_submission_recurring" checked="checked" /><span class="_sf_recurring_tooltip"><span class="arrow"></span>'.sprintf2(__('If checked, we will attempt to renew your payment every %num days.', 'btoa'), array('num' => ddp('submission_days'))).'</span></span> '.$this_price;
					//// ADDS A SUFFIX TO THE CART
					
				}
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => __('Submission', 'btoa'),
					'description' => $description,
					'price' => $this_price,
					'trash' => false,
					'cartid' => 'price_submission',
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + ddp('price_submission'));
				
			}
			
		}
		
		//// OUR IMAGES
		if(ddp('price_images') != '' && ddp('price_images') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_images', true) != 'on' && get_post_meta($post_id, 'price_images_cart', true) == 'on') {
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => __('Extra Images', 'btoa'),
					'description' => sprintf2(__('Upload up to %num images in your submission.', 'btoa'), array('num' => ddp('price_images_num'))),
					'price' => format_price(ddp('price_images')),
					'trash' => true,
					'cartid' => 'price_images',
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + ddp('price_images'));
				
			}
			
		}
		
		//// OUR FEATURED SELECTION
		if(ddp('price_featured') != '' && ddp('price_featured') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_featured', true) != 'on' && get_post_meta($post_id, 'price_featured_cart', true) == 'on') {
				
				//// IF WE HAVE A DATE SET WE CHANGE THE TEXT TO SHOW OUR DATA
				if(ddp('price_featured_days') != '' && ddp('price_featured_days') != '0') { $description = sprintf2(__('Set your submission as featured at %site_name for %num days.', 'btoa'), array('site_name' => get_bloginfo('name'), 'num' => ddp('price_featured_days'))); }
				else { $description = sprintf2(__('Set your submission as featured at %site_name.', 'btoa'), array('site_name' => get_bloginfo('name'))); }
				
				$this_price = format_price(ddp('price_featured'));
				
				//// IF IT'S RECURRING WE NEED TO ADD A PER CYCLE INFO
				if(ddp('price_featured_recurring') == 'on' && ddp('price_featured_days') != '' && ddp('price_featured_days') != 0) {
					
					$this_price = '<span onMouseOver="jQuery(this)._sf_show_recurring_tooltip();" onMouseOut="jQuery(this)._sf_hide_recurring_tooltip();">'.__('(recurring?)', 'btoa').' <input type="checkbox" id="_sf_featured_recurring" checked="checked" /><span class="_sf_recurring_tooltip"><span class="arrow"></span>'.sprintf2(__('If checked, we will attempt to renew your payment every %num days.', 'btoa'), array('num' => ddp('price_featured_days'))).'</span></span> '.$this_price;
					//// ADDS A SUFFIX TO THE CART
					
				}
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => __('Featured Submission', 'btoa'),
					'description' => $description,
					'price' => $this_price,
					'trash' => true,
					'cartid' => 'price_featured',
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + ddp('price_featured'));
				
			}
			
		}
		
		//// OUR TAGS
		if(ddp('price_tags') != '' && ddp('price_tags') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_tags', true) != 'on' && get_post_meta($post_id, 'price_tags_cart', true) == 'on') {
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => __('Extra Tags', 'btoa'),
					'description' => sprintf2(__('Add up to %num tags in your submission.', 'btoa'), array('num' => ddp('price_tags_num'))),
					'price' => format_price(ddp('price_tags')),
					'trash' => true,
					'cartid' => 'price_tags',
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + ddp('price_tags'));
				
			}
			
		}
		
		//// CUSTOM PIN
		if((ddp('price_custom_pin') != '' && ddp('price_custom_pin') != '0') && (ddp('pbl_custom_pin') == 'on')) {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_custom_pin', true) != 'on' && get_post_meta($post_id, 'price_custom_pin_cart', true) == 'on') {
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => __('Custom Pin', 'btoa'),
					'description' => __('Assign a custom pin to your submission.', 'btoa'),
					'price' => format_price(ddp('price_custom_pin')),
					'trash' => true,
					'cartid' => 'price_custom_pin',
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + ddp('price_custom_pin'));
				
			}
			
		}
		
		//// CUSTOM FIELDS
		if((ddp('price_custom_fields') != '' && ddp('price_custom_fields') != '0') && (ddp('pbl_custom_fields') == 'on')) {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_custom_fields', true) != 'on' && get_post_meta($post_id, 'price_custom_fields_cart', true) == 'on') {
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => __('Custom Fields', 'btoa'),
					'description' => __('Assign custom fields to your submission.', 'btoa'),
					'price' => format_price(ddp('price_custom_fields')),
					'trash' => true,
					'cartid' => 'price_custom_fields',
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + ddp('price_custom_fields'));
				
			}
			
		}
		
		//// CONTACT FORM
		if((ddp('price_contact_form') != '' && ddp('price_contact_form') != '0') && (ddp('pbl_contact_form') == 'on')) {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_contact_form', true) != 'on' && get_post_meta($post_id, 'price_contact_form_cart', true) == 'on') {
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => __('Contact form', 'btoa'),
					'description' => __('Enable a contact form in your submission.', 'btoa'),
					'price' => format_price(ddp('price_contact_form')),
					'trash' => true,
					'cartid' => 'price_contact_form',
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + ddp('price_contact_form'));
				
			}
			
		}
		
		//// NOW DOES OUR SEARCH FIELDS THAT ARE PAID
	
		///// NOW WE GET ALL OUR SEARCH FIELDS THAT HAVE A PRICE SET
		$args = array(
		
			'post_type' => 'search_field',
			'posts_per_page' => -1,
			'meta_query' => array(
			
				array(
				
					'key' => 'public_field_price',
					'value' => '0',
					'compare' => '>',
					'type' => 'NUMERIC',
				
				)
			
			),
		
		);
		
		$fieldsQ = new WP_Query($args);
		
		while($fieldsQ->have_posts()) { $fieldsQ->the_post();
		
			//// IF THIS FIELD IN IN OUR CART
			if(get_post_meta($post_id, '_sf_'.get_the_ID().'_cart', true) == 'on') {
				
				/// ADDS TO OUR CART ITEMS
				$return['cart_items'][] = array(
				
					'title' => get_the_title(),
					'description' => get_post_meta(get_the_ID(), 'public_field_price_description', true),
					'price' => format_price(get_post_meta(get_the_ID(), 'public_field_price', true)),
					'trash' => true,
					'cartid' => '_sf_'.get_the_ID(),
				
				);
				
				$return['cart_total'] = ($return['cart_total'] + get_post_meta(get_the_ID(), 'public_field_price', true));
				
			}
		
		} wp_reset_postdata();
		
		//// FORMATS OUR CART TOTAL
		$return['cart_total'] = format_price($return['cart_total']);
		
		echo json_encode($return);
		exit;
		
	}
	
	
	
	///// ADDS TO CART
	add_action('wp_ajax__sf_add_to_cart', '_sf_add_to_cart_function');
	add_action('wp_ajax_nopriv__sf_add_to_cart', '_sf_add_to_cart_function');
	
	function _sf_add_to_cart_function() {
		
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-add-to-cart-nonce'))
			die('Busted!');
			
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
		$action = isset($_POST['field_action']) ? trim($_POST['field_action']) : '';
		
		///// VERIFIES STATUS OF THE POST - IF AUTO DRAFT WE NEED TO SAVE AS A DRAFT
		$post = get_post($post_id);
		if($post->post_status == 'auto-draft') {
				
			/// FIELDS
			$args = array('ID' => $post_id);
			
			//// STATUS
			$args['post_status'] = 'draft';
			
			//// FINALLY SAVES AS A DRAFT
			wp_update_post($args);
			
		}
			
		//// UPDATES META BASED ON ACTION
		update_post_meta($post_id, $action.'_cart', 'on');
		
		echo json_encode($return);
		exit;
		
	}
	
	
	
	///// REMOVES FROM CART
	add_action('wp_ajax__sf_remove_from_cart', '_sf_remove_from_cart_function');
	add_action('wp_ajax_nopriv__sf_remove_from_cart', '_sf_remove_from_cart_function');
	
	function _sf_remove_from_cart_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'sf-remove-from-cart-nonce'))
			die('Busted!');
			
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
		$action = isset($_POST['field_action']) ? trim($_POST['field_action']) : '';
			
		//// UPDATES META BASED ON ACTION
		update_post_meta($post_id, $action.'_cart', '');
		
		$return['aaa'] = $action.'_cart';
		
		echo json_encode($return);
		exit;
		
	}
	
	
	
	
	//// GETS THE MAXIMUM IMAGES FOR HTIS PROP
	function _sf_get_maximum_images($post_id) {
		
		//// IF PRICE IS 0 OR EMPTY GET THE FREE AMOUNT
		if(ddp('price_images') != '' && ddp('price_images') != '0') {
			
			//// CHECKS TO SEE IF THIS HAS BEEN PAID
			if(get_post_meta($post_id, 'price_images', true) == 'on') {
				
				return ddp('price_images_num');
				
			} else {
				
				return ddp('pbl_images');
				
			}
			
		} else {
		
			return ddp('pbl_images');
			
		}
		
	}
	
	
	
	//// GETS MAXIMUM OF TAGS
	function _sf_get_maximum_tags($post_id) {
		
		//// IF PRICE IS 0 OR EMPTY GET THE FREE AMOUNT
		if(ddp('price_tags') != '' && ddp('price_tags') != '0') {
			
			//// CHECKS TO SEE IF THIS HAS BEEN PAID
			if(get_post_meta($post_id, 'price_tags', true) == 'on') {
				
				return ddp('price_tags_num');
				
			} else {
				
				return ddp('pbl_tags_no');
				
			}
			
		} else {
		
			return ddp('pbl_tags_no');
			
		}
		
	}
	
	
	
	//// CHECKS FOR CUSTOM PIN
	function _sf_check_custom_pin($post_id) {
		
		//// IF PRICE IS 0 OR EMPTY GET THE FREE AMOUNT
		if(ddp('price_custom_pin') != '' && ddp('price_custom_pin') != '0') {
			
			//// CHECKS TO SEE IF THIS HAS BEEN PAID
			if(get_post_meta($post_id, 'price_tags', true) == 'on') {
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		} else {
		
			return true;
			
		}
		
	}
	
	
	
	//// CHECKS FOR CUSTOM FIELDS
	function _sf_check_custom_fields($post_id) {
		
		//// IF PRICE IS 0 OR EMPTY GET THE FREE AMOUNT
		if(ddp('price_custom_fields') != '' && ddp('price_custom_fields') != '0') {
			
			//// CHECKS TO SEE IF THIS HAS BEEN PAID
			if(get_post_meta($post_id, 'price_custom_fields', true) == 'on') {
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		} else {
		
			return true;
			
		}
		
	}
	
	
	
	//// CHECKS FOR CONTACT FORM
	function _sf_check_contact_form($post_id) {
		
		//// IF PRICE IS 0 OR EMPTY GET THE FREE AMOUNT
		if(ddp('price_contact_form') != '' && ddp('price_contact_form') != '0') {
			
			//// CHECKS TO SEE IF THIS HAS BEEN PAID
			if(get_post_meta($post_id, 'price_contact_form', true) == 'on') {
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		} else {
		
			return true;
			
		}
		
	}
	
	
	
	//// CHECKS FOR FEATURED SELECTION
	function _sf_check_featured_selection($post_id) {
		
		//// IF PRICE IS 0 OR EMPTY GET THE FREE AMOUNT
		if(ddp('price_featured') != '' && ddp('price_featured') != '0') {
			
			//// CHECKS TO SEE IF THIS HAS BEEN PAID
			if(get_post_meta($post_id, 'price_featured', true) == 'on') {
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		} else {
		
			return true;
			
		}
		
	}
	
	
	
	///// SENDS OUT CONTACT FORMS
	add_action('wp_ajax_spot_enquiry', 'spot_enquiry_function');
	add_action('wp_ajax_nopriv_spot_enquiry', 'spot_enquiry_function');
	
	function spot_enquiry_function() {
		
		$return = array();
		$return['error'] = false;
		$return['error_email'] = '';
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'spot-enquiry-nonce')) die('Busted!');
		
		//// VERIFIES EMAIL
		$email = isset($_POST['email']) ? trim($_POST['email']) : '';
		if(!is_email($email)) { $return['error'] = true; $return['error_message'] = __('The email address is invalid.', 'btoa').'<br />'; }
		
		//// IF EMAIL SI VALID
		if($return['error'] == '') {
			
			/// GETS OTHER VARS
			$name = isset($_POST['email']) ? trim($_POST['name']) : '';
			$the_message = isset($_POST['message']) ? trim($_POST['message']) : '';
			$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
			
			//// NOW WE GET OUR SPOT AND THE USER
			$spot = get_post($post_id);
			$user = get_user_by('id', $spot->post_author);
			
			//// STARTS OUR RECIPIENT ARRAY
			$to = $user->user_email;
			
			//// HEADERS
			$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>'."\r\n".
			'Reply-To: '.$email;
			
			$subject = sprintf2(__('%site_name Contact: %spot_name', 'btoa'), array('site_name' => get_bloginfo('name'), 'spot_name' => $spot->post_title));
			
			$message = sprintf2(__("Dear %author,
			
%user (email: %email) has sent you a message via %site_name:

-----

%message", 'btoa'), array(

				'author' => $user->display_name,
				'user' => $name,
				'email' => $email,
				'site_name' => get_bloginfo('name'),
				'message' => $the_message

			));
			
			//// SENDS OUT OUR EMAIL
			if(!wp_mail($to, $subject, stripslashes($message), $headers)) {
				
				$return['error'] = true; $return['error_email'] = sprintf2(__('There was a problem sending your enquiry. Please email us directly at %site_email', 'btoa'), array('site_email' => get_option('admin_email')));
				
			} else { $return['success'] = stripslashes($headers); }
			
		}
		
		echo json_encode($return);
		exit;
		
	}
	
	
	
	
	///// LOADS SUBCATEGORIES
	add_action('wp_ajax__sf_load_subcategories_submission', '_sf_load_subcategories_submission_function');
	add_action('wp_ajax_nopriv__sf_load_subcategories_submission', '_sf_load_subcategories_submission_function');
	
	function _sf_load_subcategories_submission_function() {
		
		$return = array();
		$return ['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, '_sf_load_subcategories_submission_nonce')) die('Busted!');
		
		///// LETS GET ALL TERMS THAT ARE AN IMMEDIATE CHILD OF THIS ITEM
		$terms = get_terms('spot_cats', array(
		
			'hide_empty' => false,
			'parent' => $_POST['parent'],
		
		));
		
		if($terms) {
			
			$return['terms'] = array();
		
			foreach($terms as $_term) {
				
				///// CHECKS IF THIS TERM HAS CHILDREN
				$has_children = false;
				if(get_terms('spot_cats', array('hide_empty' => false, 'parent' => $_term->term_id))) { $has_children = true; }
				
				$return['terms'][] = array(
				
					'ID' => $_term->term_id,
					'name' => $_term->name,
					'has_children' => $has_children,
				
				);
				
			}
		
		} else { $return ['error'] = true; }
		
		echo json_encode($return);
		exit;
		
	}


?>