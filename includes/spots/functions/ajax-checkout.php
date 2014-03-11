<?php


	///// INCLUDES OUR PAYPAL CLASS
	include('class-paypal.php');

	//////////////////////////////////////////////
	//// GENERATES PAYPAL LINK
	
	add_action('wp_ajax__sf_checkout', '_sf_checkout_function');
	add_action('wp_ajax_nopriv__sf_checkout', '_sf_checkout_function');
	
	function _sf_checkout_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// RESOLVES ENDPOINT
		if(ddp('paypal_sandbox') == 'on') { $endpoint = 'https://api-3t.sandbox.paypal.com/nvp'; }
		else { $endpoint = 'https://api-3t.paypal.com/nvp'; }
		
		/// LETS START OUR REQUEST
		$pp = new Paypal(ddp('paypal_user'), ddp('paypal_password'), ddp('paypal_signature'), $endpoint);
		
		//// OUR RETURN URL
		$url = $_POST['current_url'];
		$url = remove_query_arg(array('action', 'id', 'token', 'PayerID'), $url);
		
		//// OUR PSOT ID
		$post_id = $_POST['post_id'];
		$the_post = get_post($post_id);
		
		///// SETS A FEW PARAMENTERS
		$requestParams = array(
		   'RETURNURL' => add_query_arg(array('action' => 'edit','id' => $post_id), $url),
		   'CANCELURL' => add_query_arg(array('action' => 'edit','id' => $post_id), $url)
		);
		
		$return['params'] = $requestParams;
		
		
		////////////////////////////////////////////////////////////////////////////
		////// NOW WE ADD ALL CART ITEMS TO OUR PAYPAL REQUEST
		////////////////////////////////////////////////////////////////////////////
		
		$total = 0; $i = 0;
		$item = array();
		$codes = '';
		
		$recurring = false;
		
		
		//// LETS START WITH OUR SUBMISSION
		if(ddp('price_submission') != '' && ddp('price_submission') != '0' && $the_post->post_status != 'publish') {
			
			//// CHECKS IF USER HAS ALREADY PAID
			if(get_post_meta($post_id, 'price_submission_payment', true) != 'on') {
				
				/// ADDS TO OUR TOTAL
				$total = $total + ddp('price_submission');
				
				//// IF WE CHOSE TO RECURRING
				$recurring = false;
				if(isset($_POST['recurring_submission'])) { if($_POST['recurring_submission'] == 'true') { $recurring = true; } }
				
				//// IF WE HAVE A DATE SET WE CHANGE THE TEXT TO SHOW OUR DATA
				if(ddp('submission_days') != '' && ddp('submission_days') != '0') {
					
					$description = sprintf2(__('Publish your submission at %site_name for %num days.', 'btoa'), array('site_name' => get_bloginfo('name'), 'num' => ddp('submission_days')));
					
				} else {
					
					$description = sprintf2(__('Submission at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
					
				}
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = ddp('paypal_name');
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = $description; 
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = ddp('price_submission');
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// IF IT'S A RECURRING PAYMENT
				if(ddp('price_submission_recurring') == 'on' && $recurring) {
					
					$item['L_BILLINGTYPE'.$i] = 'RecurringPayments';
					$item['L_BILLINGAGREEMENTDESCRIPTION'.$i] = sprintf2(__('Renew your submission at %site_name every %num days.', 'btoa'), array('site_name' => get_bloginfo('name'), 'num' => ddp('submission_days')));
					
				}
				
				//// ITEM CODE
				$codes .= 'psYY';
				
				$i++;
				
			}
			
		}
		
		
		//// OUR IMAGES
		if(ddp('price_images') != '' && ddp('price_images') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_images', true) != 'on' && get_post_meta($post_id, 'price_images_cart', true) == 'on') {
				
				/// ADDS TO OUR TOTAL
				$total = $total + ddp('price_images');
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = __('Extra Images', 'btoa');
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = sprintf2(__('Upload up to %num images in your submission.', 'btoa'), array('num' => ddp('price_images_num')));
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = ddp('price_images');
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// ITEM CODE
				$codes .= 'imgYY';
				
				$i++;
				
			}
			
		}
		
		
		//// OUR FEATURED SELECTION
		if(ddp('price_featured') != '' && ddp('price_featured') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_featured', true) != 'on' && get_post_meta($post_id, 'price_featured_cart', true) == 'on') {
				
				/// ADDS TO OUR TOTAL
				$total = $total + ddp('price_featured');
				
				//// IF WE CHOSE TO RECURRING
				$recurring_f = false;
				if(isset($_POST['recurring_featured'])) { if($_POST['recurring_featured'] == 'true') { $recurring_f = true; } }
				
				//// IF WE HAVE A DATE SET WE CHANGE THE TEXT TO SHOW OUR DATA
				if(ddp('price_featured_days') != '' && ddp('price_featured_days') != '0') {
					
					$description = sprintf2(__('Set your submission as featured at %site_name for %num days', 'btoa'), array('site_name' => get_bloginfo('name'), 'num' => ddp('price_featured_days')));
					
				} else {
					
					$description = sprintf2(__('Set your submission as featured at %site_name', 'btoa'), array('site_name' => get_bloginfo('name')));
					
				}
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = __('Featured Submission', 'btoa');
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = $description;
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = ddp('price_featured');
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// IF IT'S A RECURRING PAYMENT
				if(ddp('price_featured_recurring') == 'on' && $recurring_f) {
					
					$item['L_BILLINGTYPE'.$i] = 'RecurringPayments';
					$item['L_BILLINGAGREEMENTDESCRIPTION'.$i] = sprintf2(__('Renew your submission as featured at %site_name every %num days', 'btoa'), array('site_name' => get_bloginfo('name'), 'num' => ddp('price_featured_days')));
					
				}
				
				//// ITEM CODE
				$codes .= 'ftrYY';
				
				$i++;
				
			}
			
		}
		
		
		//// OUR TAGS
		if(ddp('price_tags') != '' && ddp('price_tags') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_tags', true) != 'on' && get_post_meta($post_id, 'price_tags_cart', true) == 'on') {
				
				/// ADDS TO OUR TOTAL
				$total = $total + ddp('price_tags');
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = __('Extra Tags', 'btoa');
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = sprintf2(__('Add up to %num tags in your submission.', 'btoa'), array('num' => ddp('price_tags_num')));
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = ddp('price_tags');
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// ITEM CODE
				$codes .= 'tagYY';
				
				$i++;
				
			}
			
		}
		
		
		//// CUSTOM PIN
		if(ddp('price_custom_pin') != '' && ddp('price_custom_pin') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_custom_pin', true) != 'on' && get_post_meta($post_id, 'price_custom_pin_cart', true) == 'on') {
				
				/// ADDS TO OUR TOTAL
				$total = $total + ddp('price_custom_pin');
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = __('Custom Pin', 'btoa');
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = __('Assign a custom pin to your submission.', 'btoa');
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = ddp('price_custom_pin');
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// ITEM CODE
				$codes .= 'pinYY';
				
				$i++;
				
			}
			
		}
		
		
		//// CUSTOM FIELDS
		if(ddp('price_custom_fields') != '' && ddp('price_custom_fields') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_custom_fields', true) != 'on' && get_post_meta($post_id, 'price_custom_fields_cart', true) == 'on') {
				
				/// ADDS TO OUR TOTAL
				$total = $total + ddp('price_custom_fields');
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = __('Custom Fields', 'btoa');
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = __('Assign custom fields to your submission.', 'btoa');
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = ddp('price_custom_fields');
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// ITEM CODE
				$codes .= 'cfYY';
				
				$i++;
				
			}
			
		}
		
		
		//// CONTACT FORM
		if(ddp('price_contact_form') != '' && ddp('price_contact_form') != '0') {
			
			//// CHECKS IF USER HAS ALREADY PAID AND IF IT'S IN CART
			if(get_post_meta($post_id, 'price_contact_form', true) != 'on' && get_post_meta($post_id, 'price_contact_form_cart', true) == 'on') {
				
				/// ADDS TO OUR TOTAL
				$total = $total + ddp('price_contact_form');
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = __('Contact Form', 'btoa');
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = __('Enable a contact form in your submission.', 'btoa');
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = ddp('price_contact_form');
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// ITEM CODE
				$codes .= 'cntYY';
				
				$i++;
				
			}
			
		}
		
		///// SEARCH FIELDS
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
				
				/// ADDS TO OUR TOTAL
				$total = $total + get_post_meta(get_the_ID(), 'public_field_price', true);
				
				///// ADDS AS AN ITEM TO OUR CART
				$item['L_PAYMENTREQUEST_0_NAME'.$i] = get_the_title();
				$item['L_PAYMENTREQUEST_0_DESC'.$i] = get_post_meta(get_the_ID(), 'public_field_price_description', true);
				$item['L_PAYMENTREQUEST_0_AMT'.$i] = get_post_meta(get_the_ID(), 'public_field_price', true);
				$item['L_PAYMENTREQUEST_0_QTY'.$i] = 1;
				$item['L_PAYMENTREQUEST_0_ITEMCATEGORY'.$i] = 'Digital';
				
				//// ITEM CODE
				$codes .= get_the_ID().'YY';
				
				$i++;
				
			}
		
		}
		
		
		//// TOTALS
		$orderParams = array(
		   'PAYMENTREQUEST_0_AMT' => $total,
		   'PAYMENTREQUEST_0_CURRENCYCODE' => ddp('paypal_currency'),
		   'PAYMENTREQUEST_0_ITEMAMT' => $total,
		   'PAYMENTREQUEST_0_CUSTOM' => trim($codes, 'YY')
		);
		
		
		///// GENERATES THE PAYPAL LINK
		$response = $pp->request('SetExpressCheckout',$requestParams + $orderParams + $item);
		
		///// IF WE HAVE HAD SUCCESS
		if(is_array($response)) {
			
			//// IF SUCCESS
			if($response['ACK'] == 'Success') {
				
				//// TOKEN
				$token = $response['TOKEN'];
				
				///// REDIRECT URL
				$paypal_url = 'https://www.paypal.com/webscr?cmd=_express-checkout&token=';
				if(ddp('paypal_sandbox') == 'on') { $paypal_url = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token='; }
				
				//// OUR REDIRECT URL
				$return['redirect'] = $paypal_url.$token;
				
				//// OUR REDIRECT MESSAGE
				$return['message'] = __('Redirecting you to PayPal...', 'btoa');
				
			} else {
			
				$return['error'] = true;
				$return['error_message'] = sprintf2(__('There was an error processing your request. Please contact the site administrator. Error Code %num.', 'btoa'), array('num' => '12'));
				$return['error_long_message'] = $response['L_LONGMESSAGE0'];
				
			}
			
		} else {
			
			$return['error'] = true;
			$return['error_message'] = sprintf2(__('There was an error processing your request. Please contact the site administrator. Error Code %num.', 'btoa'), array('num' => '10'));
			
		}
		
		
		echo json_encode($return);
		
		exit;
		
	}
	
	
	
	//////////////////////////////////////////////////////////
	//// PROCESSES THE EXPRESS CHECKOUT
	//////////////////////////////////////////////////////////
	
	function _sf_checkout_function_process($post_id, $token, $payerid) {
		
		//// RESOLVES ENDPOINT
		if(ddp('paypal_sandbox') == 'on') { $endpoint = 'https://api-3t.sandbox.paypal.com/nvp'; }
		else { $endpoint = 'https://api-3t.paypal.com/nvp'; }
		
		/// LETS START OUR REQUEST
		$pp = new Paypal(ddp('paypal_user'), ddp('paypal_password'), ddp('paypal_signature'), $endpoint);
		
		//// GETS CHECKOUT DETAILS
		$details = $pp->request('GetExpressCheckoutDetails', array('TOKEN' => $token));
		
		//echo '<pre>'; print_r($details); exit;
		
		//// PROCESSES THE PAYMENT - PARAMETERS
		$requestParams = array(
		   'TOKEN' => $token,
		   'PAYMENTACTION' => 'Sale',
		   'PAYERID' => $payerid,
		   'PAYMENTREQUEST_0_AMT' => $details['AMT'], // Same amount as in the original request
		   'PAYMENTREQUEST_0_CURRENCYCODE' => ddp('paypal_currency') // Same currency as the original request
	   	);
		
		//// NOW WE PROCESS IT
		$response = $pp->request('DoExpressCheckoutPayment', $requestParams);
		
		//// IF ITS SUCCESSFULL
		if($response['ACK'] == 'Success') {
			
			///// RETURNS OUR MESSAGE
			$return = array(
			
				'message' => __('Your payment has been successfully processed. You can now add your additionals.', 'btoa'),
			
			);
			
			//// GETS OUR CUSTOM MESSAGE AND UPDATES OUR NECESSARY FIELDS
			if($details['PAYMENTREQUEST_0_CUSTOM']) {
				
				//// TRANSFORMS IT INTO AN ARRAY AND PROCESSES FIELDS
				$fields = explode('YY', $details['PAYMENTREQUEST_0_CUSTOM']);
				$the_post = get_post($post_id); $extra = '';
				
				//// LOOPS FIELDS
				foreach($fields as $_field) {
					
					//// IF PUBLIC SUBMISSION PAYMENT
					if($_field == 'ps') {
						
						update_post_meta($post_id, 'price_submission_payment', 'on');
						
						$extra .= __('Submission', 'btoa').', ';
						
						/////////////////////////////////////////////////////////////////////////////////////
						///// LET'S CHECK FOR RECURRING PAYMENTS HERE
						/////////////////////////////////////////////////////////////////////////////////////
						
						$billingaccepted = false;
						if(isset($details['BILLINGAGREEMENTACCEPTEDSTATUS'])) { if($details['BILLINGAGREEMENTACCEPTEDSTATUS'] == 1) { $billingaccepted = true; } }
						
						if(ddp('price_submission_recurring') == 'on' && ddp('submission_days') != 0 && ddp('submission_days') != '' && $billingaccepted) {
							
							$description = sprintf2(__('Renew your submission at %site_name every %num days.', 'btoa'), array('site_name' => get_bloginfo('name'), 'num' => ddp('submission_days')));
							
							$startdate = gmdate('c', time() + (ddp('submission_days') * (60*60*24)	));
							
							//// LETS CALL ANOTHER PAYPAL API REQUEST TO CREATE OUR PROFILE
							$params = array(
							
								'TOKEN' => $token,
								'PROFILESTARTDATE' => $startdate,
								'DESC' => $description,
								'BILLINGPERIOD' => 'Day',
								'BILLINGFREQUENCY' => ddp('submission_days'),
								'AMT' => ddp('price_submission'),
								'CURRENCYCODE' => ddp('paypal_currency'),
								'L_PAYMENTREQUEST_0_ITEMCATEGORY0' => 'Digital',
								'L_PAYMENTREQUEST_0_NAME0' => ddp('paypal_name'),
								'L_PAYMENTREQUEST_0_AMT0' => ddp('price_submission'),
								'L_PAYMENTREQUEST_0_QTY0' => '1',
							
							);
							
							///// LETS TRY AND CALL THIS PROFILE NOW
							$recurring_submission = $pp->request('CreateRecurringPaymentsProfile', $params);
							
							///// IF WE SUCCEEDED
							if($recurring_submission['ACK'] == 'Success') {
								
								//// LET'S SAVE OUR PROFILE ID
								update_post_meta($post_id, 'submission_payment_profile_id', $recurring_submission['PROFILEID']);
								
								///// LETS LET THE USER AND ADMIN KNOW THAT A RECURRING PAYMENT HAS BEEN MADE
				
								//// SENDS THE ADMINISTRATOR AN EMAIL
								//// MESSAGE
								$message = sprintf2(__('Dear Admin,
								
A new recurring payment has been made at %site_name:

Recurring payment for: Submission
Post: %post_title
Profile ID: %profile

Kind regards,
The %site_name team.', 'btoa'), array(
				
									'site_name' => get_bloginfo('name'),
									'post_title' => $the_post->post_title,
									'profile' => $recurring_submission['PROFILEID'],
				
								));
								
								$subject = sprintf2(__('Recurring Payment Created at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
								
								$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
								
								//// SENDS EMAIL
								wp_mail(get_option('admin_email'), $subject, $message, $headers);
								
								//// SENDS THE USER AN EMAIL
								//// MESSAGE
								$message = sprintf2(__('Dear %user,
								
A new recurring payment has been created for you at %site_name.

Recurring payment for: Submission
Post: %post_title
Profile ID: %profile', 'btoa'), array(
				
									'site_name' => get_bloginfo('name'),
									'user' => $user->display_name,
									'post_title' => $the_post->post_title,
									'profile' => $recurring_submission['PROFILEID'],
				
								));
								
								$subject = sprintf2(__('Recurring Payment Created at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
								
								$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
								
								//// SENDS EMAIL
								wp_mail($user->user_email, $subject, $message, $headers);
								
							} else { //// THERE WAS AN ERROR
							
								$return = new WP_Error('PP002', __('Your initial payment was processed but we were unable to create a recurring payment for your submission.', 'btoa'));
								
								return $return;
							
							} /// ENDS IF ERROR
							
						} //// ENDS RECURRING PAYMENT
						
					}
					
					//// IF IMAGES
					elseif($_field == 'img') {
						
						update_post_meta($post_id, 'price_images_cart', '');
						update_post_meta($post_id, 'price_images', 'on');
						
						$extra .= __('Extra Images', 'btoa').', ';
						
					}
					
					//// IF FEATURED
					elseif($_field == 'ftr') {
						
						update_post_meta($post_id, 'price_featured_cart', '');
						update_post_meta($post_id, 'price_featured', 'on');
						update_post_meta($post_id, 'featured', 'on');
						
						$extra .= __('Featured Submission', 'btoa').', ';
						
						/////////////////////////////////////////////////////////////////////////////////////
						///// LET'S CHECK FOR RECURRING PAYMENTS HERE
						/////////////////////////////////////////////////////////////////////////////////////
						
						$billingaccepted = false;
						if(isset($details['BILLINGAGREEMENTACCEPTEDSTATUS'])) { if($details['BILLINGAGREEMENTACCEPTEDSTATUS'] == 1) { $billingaccepted = true; } }
						
						if(ddp('price_featured_recurring') == 'on' && ddp('price_featured_days') != 0 && ddp('price_featured_days') != '' && $billingaccepted) {
							
							$description = sprintf2(__('Renew your submission as featured at %site_name every %num days', 'btoa'), array('site_name' => get_bloginfo('name'), 'num' => ddp('price_featured_days')));
							
							$startdate = gmdate('c', time() + (ddp('price_featured_days') * (60*60*24)	));
							
							//// LETS CALL ANOTHER PAYPAL API REQUEST TO CREATE OUR PROFILE
							$params = array(
							
								'TOKEN' => $token,
								'PROFILESTARTDATE' => $startdate,
								'DESC' => $description,
								'BILLINGPERIOD' => 'Day',
								'BILLINGFREQUENCY' => ddp('price_featured_days'),
								'AMT' => ddp('price_featured'),
								'CURRENCYCODE' => ddp('paypal_currency'),
								'L_PAYMENTREQUEST_0_ITEMCATEGORY0' => 'Digital',
								'L_PAYMENTREQUEST_0_NAME0' => __('Featured Submission', 'btoa'),
								'L_PAYMENTREQUEST_0_AMT0' => ddp('price_featured'),
								'L_PAYMENTREQUEST_0_QTY0' => '1',
							
							);
							
							///// LETS TRY AND CALL THIS PROFILE NOW
							$recurring_featured = $pp->request('CreateRecurringPaymentsProfile', $params);
							
							///// IF WE SUCCEEDED
							if($recurring_featured['ACK'] == 'Success') {
								
								//// LET'S SAVE OUR PROFILE ID
								update_post_meta($post_id, 'featured_payment_profile_id', $recurring_featured['PROFILEID']);
								
								///// LETS LET THE USER AND ADMIN KNOW THAT A RECURRING PAYMENT HAS BEEN MADE
				
								//// SENDS THE ADMINISTRATOR AN EMAIL
								//// MESSAGE
								$message = sprintf2(__('Dear Admin,
								
A new recurring payment has been made at %site_name:

Recurring payment for: Featured Listing
Post: %post_title
Profile ID: %profile

Kind regards,
The %site_name team.', 'btoa'), array(
				
									'site_name' => get_bloginfo('name'),
									'post_title' => $the_post->post_title,
									'profile' => $recurring_featured['PROFILEID'],
				
								));
								
								$subject = sprintf2(__('Recurring Payment Created at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
								
								$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
								
								//// SENDS EMAIL
								wp_mail(get_option('admin_email'), $subject, $message, $headers);
								
								//// SENDS THE USER AN EMAIL
								//// MESSAGE
								$message = sprintf2(__('Dear %user,
								
A new recurring payment has been created for you at %site_name.

Recurring payment for: Featured Listing
Post: %post_title
Profile ID: %profile', 'btoa'), array(
				
									'site_name' => get_bloginfo('name'),
									'user' => $user->display_name,
									'post_title' => $the_post->post_title,
									'profile' => $recurring_featured['PROFILEID'],
				
								));
								
								$subject = sprintf2(__('Recurring Payment Created at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
								
								$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
								
								//// SENDS EMAIL
								wp_mail($user->user_email, $subject, $message, $headers);
								
							} else { //// THERE WAS AN ERROR
							
								$return = new WP_Error('PP002', __('Your initial payment was processed but we were unable to create a recurring payment for your submission.', 'btoa'));
								
								return $return;
							
							} /// ENDS IF ERROR
							
						} //// ENDS RECURRING PAYMENT
						
					}
					
					//// IF TAGS
					elseif($_field == 'tag') {
						
						update_post_meta($post_id, 'price_tags_cart', '');
						update_post_meta($post_id, 'price_tags', 'on');
						
						$extra .= __('Extra Tags', 'btoa').', ';
						
					}
					
					//// IF CUSTOM PIN
					elseif($_field == 'pin') {
						
						update_post_meta($post_id, 'price_custom_pin_cart', '');
						update_post_meta($post_id, 'price_custom_pin', 'on');
						
						$extra .= __('Custom Pin', 'btoa').', ';
						
					}
					
					//// IF CUSTOM FIELDS
					elseif($_field == 'cf') {
						
						update_post_meta($post_id, 'price_custom_fields_cart', '');
						update_post_meta($post_id, 'price_custom_fields', 'on');
						
						$extra .= __('Custom Fields', 'btoa').', ';
						
					}
					
					//// IF CONTACT FORM
					elseif($_field == 'cnt') {
						
						update_post_meta($post_id, 'price_contact_form_cart', '');
						update_post_meta($post_id, 'price_contact_form', 'on');
						
						$extra .= __('Contact Form', 'btoa').', ';
						
					}
					
					//// NOW GOES FOR CUSTOM FIELDS
					elseif($search_field = get_post($_field)) {
						
						update_post_meta($post_id, '_sf_'.$_field.'_cart', '');
						update_post_meta($post_id, '_sf_'.$_field, 'on');
						
						$extra .= $search_field->post_title.', ';
						
					}
					
				}
				
				
				////////////////////////////////////////////////////////////////////////////////////////////////////
				///// NOW THAT WE'VE DONE THE EXPRESS CHECKOUT - LETS CHECK IF WE NEED TO CREATE RECURRING PAYMENTS
				////////////////////////////////////////////////////////////////////////////////////////////////////
				
				////////////////////////////////////////////////////////////////////////////////////////////////////
				///// CHECKS FOR SUBMISSION FIRST
				////////////////////////////////////////////////////////////////////////////////////////////////////
				
				
				$user = get_user_by('id', $the_post->post_author);
				
				//// SENDS THE ADMINISTRATOR AN EMAIL
				//// MESSAGE
				$message = sprintf2(__('Dear Admin,
				
A payment for extras has been made at %site_name:

Payment by: %user
Extras added to post: %post_title
Post ID: %post_id
Extras added: %extras
Payment Total: %total
Transaction ID: %trans_id', 'btoa'), array(

					'site_name' => get_bloginfo('name'),
					'user' => $user->display_name,
					'post_title' => $the_post->post_title,
					'post_id' => $post_id,
					'extras' => trim($extra, ', '),
					'total' => format_price($details['PAYMENTREQUEST_0_AMT']),
					'trans_id' => $response['PAYMENTINFO_0_TRANSACTIONID'],

				));
				
				$subject = sprintf2(__('Payment processed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
				
				$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
				
				//// SENDS EMAIL
				wp_mail(get_option('admin_email'), $subject, $message, $headers);
				
				//// SENDS THE USER AN EMAIL
				//// MESSAGE
				$message = sprintf2(__('Dear %user,
				
Your payment has been processed at %site_name:

Extras added to post: %post_title
Post ID: %post_id
Extras added: %extras
Payment Total: %total
Transaction ID: %trans_id,

Kind regards,
The %site_name team.', 'btoa'), array(

					'site_name' => get_bloginfo('name'),
					'user' => $user->display_name,
					'post_title' => $the_post->post_title,
					'post_id' => $post_id,
					'extras' => trim($extra, ', '),
					'total' => format_price($details['PAYMENTREQUEST_0_AMT']),
					'trans_id' => $response['PAYMENTINFO_0_TRANSACTIONID'],

				));
				
				$subject = sprintf2(__('Payment made at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
				
				$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
				
				//// SENDS EMAIL
				wp_mail($user->user_email, $subject, $message, $headers);
				
			} else {
				
				//// COULD NOT DO THE CUSTOM, DISPLAY ERROR MESSAGE
				$return = new WP_Error('PP002', __('Your payment has been processed but we were unable to update your information. Please contact the site administrator.', 'btoa'));
				
			}
			
			
		} else {
			
			/// THERE WAS AN ERROR, LETS CREATE A WP_Error Object
			$return = new WP_Error('PP001', $response['L_LONGMESSAGE0']);
			
		}
		
		return $return;
		
	}
	
	
	
	///////////////////////////////////////////////////
	///// CHECK FOR RECURRING PAYMENTS ON SUBMISSIONS
	///////////////////////////////////////////////////
	
	function _sf_recurring_payments_submission($post_id) {
		
		//// GETS POST FIRST
		if($post = get_post($post_id)) {
			
			//// IF ITS A SPOT
			if($post->post_type == 'spot') {
				
				//// CHECK IF WE HAVE A PROFILE ID
				if(get_post_meta($post->ID, 'submission_payment_profile_id', true) != '') {
					
					///// LET'S GET THE PROFILE STATUS
					//// RESOLVES ENDPOINT
					if(ddp('paypal_sandbox') == 'on') { $endpoint = 'https://api-3t.sandbox.paypal.com/nvp'; }
					else { $endpoint = 'https://api-3t.paypal.com/nvp'; }
					
					/// LETS START OUR REQUEST
					$pp = new Paypal(ddp('paypal_user'), ddp('paypal_password'), ddp('paypal_signature'), $endpoint);
					
					//// PARAMETERS
					$params = array(
					
						'PROFILEID' => get_post_meta($post->ID, 'submission_payment_profile_id', true),
					
					);
					
					//// LETS GET THE PROFILE DETAILS
					$profile_details = $pp->request('GetRecurringPaymentsProfileDetails', $params);
					
					///// IF WE SUCCEEDED
					if($profile_details['ACK'] == 'Success') {
					
						//// IF THE ADMIN HASNT CHANGED THE NUMBER OF DAYS ITS PUBLISHED
						if($profile_details['BILLINGFREQUENCY'] == ddp('submission_days')) {
							
							
							//// LET'S CHECK IF OUR PROFILE IS ACTIVE
							if($profile_details['STATUS'] == 'Active') {
								
								/// ITS ACTIVE LET'S RENEW IT
								/// GETS THE CURRENT EXPIRY DATE AND ADD ANOTHER SET OF DAYS
								_sf_recurring_payments_submission_renew($post, $profile_details);
								
								//// NOW WE HAVE RENEWED THE SUBMISSION WE CAN RETURN TRUE TO STOP THE FUNCTION TO PUTTING THE SUBMISSION AS A DRAFT
								return true;
								
							} // ENDS IF PROFILE IS ACTIVE
							/// ITS NOT ACTIVE
							else {
								
								//// IT'S CANCELED
								_sf_recurring_payments_submission_cancel($post, $profile_details);
								
							}
							
							
						}  else { //// IF THE BILLING CYCLE HAS CHANGED
								
							//// NUMBER OF DAYS IN THE CYCLE HAS CHANGED - WE NEED TO CANCEL IT
							_sf_recurring_payments_submission_cycle_changed($post, $profile_details);
						
						}
						
					
					} else {
						
						//// COULD NOT GET BILLING CYCLE WITH PROFILE ID
						_sf_recurring_payments_submission_invalid($post, $profile_details);
					
						
					} /// ENDS IF WE COULDNT GET BILLING CYCLE
					
				} /// ENDS IF PROFILE ID
				
			} //// ENDS IF IS SPOT
			
		}//// ENDS IF IS POSR
		
		return false;
		
	}
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// RENEWS BILLING CYCLE
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_submission_renew($post, $profile_details) {

		$current_expiry_date = get_post_meta($post->ID, 'expiry_date', true);
		$exp_date = time() + (ddp('submission_days') * (60*60*24));
		$midnight_time = strtotime(date('d-m-Y', $exp_date));
		
		///// UPDATES THE EXPIRYDATE
		update_post_meta($post->ID, 'expiry_date', $midnight_time);
		
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear %user,
		
This is an automated message to let you know that your listing %title has been renewed at %site_name.

Billing Cycle Profile ID: %billing_id

If you wish to cancel your billing agreement, please cancel your subscription on the Paypal website and you will no longer be billed.

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' => $profile_details['PROFILEID'],
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Submission renewed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		//// SENDS AN EMAIL TO THE ADMIN
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear Admin,
		
This is an automated message to let you know that the listing %title has been renewed at %site_name.

Billing Cycle Profile ID: %billing_id

Please visit your paypal account portal and ensure the payment has been processed by paypal.

Kind regards,
The %site_name team.'), array(
	
		'billing_id' => $profile_details['PROFILEID'],
		'title' => $post->post_title,
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Submission renewed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail(get_option('admin_email'), $subject, $message, $headers);
		
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// CANCELS BILLING CYCLE
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_submission_cancel($post, $profile_details) {

		//// UPDATES POST META FOR PROFILE ID
		
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear %user,
		
This is an automated message to let you know that we could not process your billing agreement at %site_name.

Please visit your paypal account and ensure your billing agreement is cancelled.

Billing Cycle Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' => $profile_details['PROFILEID'],
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Billing failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		//// SENDS AN EMAIL TO THE ADMIN
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear Admin,
		
This is an automated message to let you know that a billing cycle has been cancelled at %sitename.

This usually happend because the billing agreement has either been cancelled, suspended or it is pending on paypal.

We will attempy to cancel it but please visit your paypal page and ensure it has been cancelled.

Billing Cycle Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'billing_id' => $profile_details['PROFILEID'],
		'title' => $post->post_title,
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Billing failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail(get_option('admin_email'), $subject, $message, $headers);
		
		//// RESOLVES ENDPOINT
		if(ddp('paypal_sandbox') == 'on') { $endpoint = 'https://api-3t.sandbox.paypal.com/nvp'; }
		else { $endpoint = 'https://api-3t.paypal.com/nvp'; }
		$pp = new Paypal(ddp('paypal_user'), ddp('paypal_password'), ddp('paypal_signature'), $endpoint);
							
		//// CANCELS IT
		$params = array(
		
			'PROFILEID' => get_post_meta($post->ID, 'submission_payment_profile_id', true),
			'ACTION' => 'Cancel',
			'NOTE' => sprintf2(__('Billing Cycle changed. Please re-submit your listing at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'))),
		
		);
		
		//// ATTEMPTS TO CALCEL THE BILLING CYCLE
		$cancel = $pp->request('ManageRecurringPaymentsProfileStatus', $params);
		
		///// UPDATES THE EXPIRYDATE
		update_post_meta($post->ID, 'submission_payment_profile_id', '');
		
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// CANCELS BILLING CYCLE - DAYS HAVE CHANGED
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_submission_cycle_changed($post, $profile_details) {
		
		//// LET THE USER KNOW
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN SUSPENDED
		$message = sprintf2(__('Dear %user,
		
This is an automated email to let you know that we were unable to process your subscription at %site_name for your submission "%title" due to the fact that your billing cycle days has changed.

Please login at %site_name and submit your listing again to generate a new billing cycle. Your listings has been saved as a Draft.

We will attempt to cancel your billing agreement on paypal but please ensure that it has been effectively cancelled on your paypal page.

Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' =>get_post_meta($post->ID, 'submission_payment_profile_id', true),
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Billing Cycle cancelled at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		$params = array(
		
			'PROFILEID' => get_post_meta($post->ID, 'submission_payment_profile_id', true),
			'ACTION' => 'Reactivate',
			'NOTE' => sprintf2(__('Billing Cycle changed. Please re-submit your listing at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'))),
		
		);
		
		//// ATTEMPTS TO CALCEL THE BILLING CYCLE
		$cancel = $pp->request('ManageRecurringPaymentsProfileStatus', $params);
							
		//// UPDATES THE USERS PROFILE ID
		update_post_meta($post->ID, 'submission_payment_profile_id', '');
		
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// CANCELS BILLING CYCLE - INVALID PROFILE
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_submission_invalid($post, $profile_details) {
						
		
		//// LET THE USER KNOW
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear %user,
		
This is an automated email to let you know that we have failed to process your subscription at %site_name for your listing %title.

We will attempt to cancel your billing agreement on paypal but please ensure that it has been effectively cancelled on your paypal page.

Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' =>get_post_meta($post->ID, 'submission_payment_profile_id', true),
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Submission failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		///// SENDS AN EMAIL SAYING WE COULD NOT FIND BILLER ID TO THE ADMIN
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear admin,
		
This is an automated message to let you know that %site_name has failed to process a billing cycle.

Profile ID: %billing_id
Error: %error

Kind regards,
The %site_name team.'), array(
	
			'user' => $user->display_name,
			'title' => $post->post_title,
			'billing_id' =>get_post_meta($post->ID, 'submission_payment_profile_id', true),
			'site_name' => get_bloginfo('name'),
			'error' => $profile_details['L_LONGMESSAGE0'],
	
		));

		$subject = sprintf2(__('Submission failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail(get_option('admin_email'), $subject, $message, $headers);
		//// UPDATES THE USERS PROFILE ID
		update_post_meta($post->ID, 'submission_payment_profile_id', '');
						
	}
	
	
	
	///////////////////////////////////////////////////
	///// CHECK FOR RECURRING PAYMENTS ON FEATURED SEL
	///////////////////////////////////////////////////
	
	function _sf_recurring_payments_featured($post_id) {
		
		//// GETS POST FIRST
		if($post = get_post($post_id)) {
			
			//// IF ITS A SPOT
			if($post->post_type == 'spot') {
				
				//// CHECK IF WE HAVE A PROFILE ID
				if(get_post_meta($post->ID, 'featured_payment_profile_id', true) != '') {
					
					///// LET'S GET THE PROFILE STATUS
					//// RESOLVES ENDPOINT
					if(ddp('paypal_sandbox') == 'on') { $endpoint = 'https://api-3t.sandbox.paypal.com/nvp'; }
					else { $endpoint = 'https://api-3t.paypal.com/nvp'; }
					
					/// LETS START OUR REQUEST
					$pp = new Paypal(ddp('paypal_user'), ddp('paypal_password'), ddp('paypal_signature'), $endpoint);
					
					//// PARAMETERS
					$params = array(
					
						'PROFILEID' => get_post_meta($post->ID, 'featured_payment_profile_id', true),
					
					);
					
					//// LETS GET THE PROFILE DETAILS
					$profile_details = $pp->request('GetRecurringPaymentsProfileDetails', $params);
					
					///// IF WE SUCCEEDED
					if($profile_details['ACK'] == 'Success') {
					
						//// IF THE ADMIN HASNT CHANGED THE NUMBER OF DAYS ITS PUBLISHED
						if($profile_details['BILLINGFREQUENCY'] == ddp('price_featured_days')) {
							
							
							//// LET'S CHECK IF OUR PROFILE IS ACTIVE
							if($profile_details['STATUS'] == 'Active') {
								
								/// ITS ACTIVE LET'S RENEW IT
								/// GETS THE CURRENT EXPIRY DATE AND ADD ANOTHER SET OF DAYS
								_sf_recurring_payments_faetured_renew($post, $profile_details);
								
								//// NOW WE HAVE RENEWED THE SUBMISSION WE CAN RETURN TRUE TO STOP THE FUNCTION TO PUTTING THE SUBMISSION AS A DRAFT
								return true;
								
							} // ENDS IF PROFILE IS ACTIVE
							/// ITS NOT ACTIVE
							else {
								
								//// IT'S CANCELED
								_sf_recurring_payments_featured_cancel($post, $profile_details);
								
							}
							
							
						}  else { //// IF THE BILLING CYCLE HAS CHANGED
								
							//// NUMBER OF DAYS IN THE CYCLE HAS CHANGED - WE NEED TO CANCEL IT
							_sf_recurring_payments_featured_cycle_changed($post, $profile_details);
						
						}
						
					
					} else {
						
						//// COULD NOT GET BILLING CYCLE WITH PROFILE ID
						_sf_recurring_payments_featured_invalid($post, $profile_details);
					
						
					} /// ENDS IF WE COULDNT GET BILLING CYCLE
					
				} /// ENDS IF PROFILE ID
				
			} //// ENDS IF IS SPOT
			
		}//// ENDS IF IS POSR
		
		return false;
		
	}
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// RENEWS BILLING CYCLE
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_faetured_renew($post, $profile_details) {

		$current_expiry_date = get_post_meta($post->ID, 'expiry_date', true);
		$exp_date = time() + (ddp('price_featured_days') * (60*60*24));
		$midnight_time = strtotime(date('d-m-Y', $exp_date));
		
		///// UPDATES THE EXPIRYDATE
		update_post_meta($post->ID, 'expiry_date', $midnight_time);
		
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear %user,
		
This is an automated message to let you know that your featured selection at %title has been renewed at %site_name.

Billing Cycle Profile ID: %billing_id

If you wish to cancel your billing agreement, please cancel your subscription on the Paypal website and you will no longer be billed.

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' => $profile_details['PROFILEID'],
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Featured Selection renewed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		//// SENDS AN EMAIL TO THE ADMIN
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear Admin,
		
This is an automated message to let you know that a featured selection on %title has been renewed at %site_name.

Billing Cycle Profile ID: %billing_id

Please visit your paypal account portal and ensure the payment has been processed by paypal.

Kind regards,
The %site_name team.'), array(
	
		'billing_id' => $profile_details['PROFILEID'],
		'title' => $post->post_title,
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Featured Selection renewed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail(get_option('admin_email'), $subject, $message, $headers);
		
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// CANCELS BILLING CYCLE
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_featured_cancel($post, $profile_details) {

		//// UPDATES POST META FOR PROFILE ID
		
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear %user,
		
This is an automated message to let you know that we could not process your billing agreement at %site_name for your featured selection on the listing %title.

Please visit your paypal account and ensure your billing agreement is cancelled.

Billing Cycle Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' => $profile_details['PROFILEID'],
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Billing failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		//// SENDS AN EMAIL TO THE ADMIN
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear Admin,
		
This is an automated message to let you know that a billing cycle for featured selection has been cancelled at %sitename for the listing %title.

This usually happend because the billing agreement has either been cancelled, suspended or it is pending on paypal.

We will attempy to cancel it but please visit your paypal page and ensure it has been cancelled.

Billing Cycle Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'billing_id' => $profile_details['PROFILEID'],
		'title' => $post->post_title,
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Billing failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail(get_option('admin_email'), $subject, $message, $headers);
		
		//// RESOLVES ENDPOINT
		if(ddp('paypal_sandbox') == 'on') { $endpoint = 'https://api-3t.sandbox.paypal.com/nvp'; }
		else { $endpoint = 'https://api-3t.paypal.com/nvp'; }
		$pp = new Paypal(ddp('paypal_user'), ddp('paypal_password'), ddp('paypal_signature'), $endpoint);
							
		//// CANCELS IT
		$params = array(
		
			'PROFILEID' => get_post_meta($post->ID, 'featured_payment_profile_id', true),
			'ACTION' => 'Cancel',
			'NOTE' => sprintf2(__('Billing Cycle changed. Please re-submit your listing at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'))),
		
		);
		
		//// ATTEMPTS TO CALCEL THE BILLING CYCLE
		$cancel = $pp->request('ManageRecurringPaymentsProfileStatus', $params);
		
		///// UPDATES THE EXPIRYDATE
		update_post_meta($post->ID, 'featured_payment_profile_id', '');
		
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// CANCELS BILLING CYCLE - DAYS HAVE CHANGED
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_featured_cycle_changed($post, $profile_details) {
		
		//// LET THE USER KNOW
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN SUSPENDED
		$message = sprintf2(__('Dear %user,
		
This is an automated email to let you know that we were unable to process your billing agreement for a featured selection at %site_name for your submission "%title" due to the fact that your billing cycle days has changed.

Please login at %site_name and submit your listing again to generate a new billing cycle. Your listings has been saved as a Draft.

We will attempt to cancel your billing agreement on paypal but please ensure that it has been effectively cancelled on your paypal page.

Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' =>get_post_meta($post->ID, 'featured_payment_profile_id', true),
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Billing Cycle cancelled at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		$params = array(
		
			'PROFILEID' => get_post_meta($post->ID, 'featured_payment_profile_id', true),
			'ACTION' => 'Reactivate',
			'NOTE' => sprintf2(__('Billing Cycle changed. Please re-submit your listing at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'))),
		
		);
		
		//// ATTEMPTS TO CALCEL THE BILLING CYCLE
		$cancel = $pp->request('ManageRecurringPaymentsProfileStatus', $params);
							
		//// UPDATES THE USERS PROFILE ID
		update_post_meta($post->ID, 'featured_payment_profile_id', '');
		
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////
	/////// CANCELS BILLING CYCLE - INVALID PROFILE
	/////////////////////////////////////////////////////////////////////////////
	function _sf_recurring_payments_featured_invalid($post, $profile_details) {
						
		
		//// LET THE USER KNOW
		$user = get_user_by('id', $post->post_author);
		
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear %user,
		
This is an automated email to let you know that we have failed to process your billing agreement for a featured selection at %site_name for your listing %title.

We will attempt to cancel your billing agreement on paypal but please ensure that it has been effectively cancelled on your paypal page.

Profile ID: %billing_id

Kind regards,
The %site_name team.'), array(
	
		'user' => $user->display_name,
		'title' => $post->post_title,
		'billing_id' =>get_post_meta($post->ID, 'featured_payment_profile_id', true),
		'site_name' => get_bloginfo('name')
	
		));

		$subject = sprintf2(__('Submission failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail($user->user_email, $subject, $message, $headers);
		
		///// SENDS AN EMAIL SAYING WE COULD NOT FIND BILLER ID TO THE ADMIN
		///// SENDS OUT AN EMAIL TO THE USER SAYING THE HIS LISTING HAS BEEN RENEWED
		$message = sprintf2(__('Dear admin,
		
This is an automated message to let you know that %site_name has failed to process a billing agreement for a featured selection.

Profile ID: %billing_id
Error: %error

Kind regards,
The %site_name team.'), array(
	
			'user' => $user->display_name,
			'title' => $post->post_title,
			'billing_id' =>get_post_meta($post->ID, 'featured_payment_profile_id', true),
			'site_name' => get_bloginfo('name'),
			'error' => $profile_details['L_LONGMESSAGE0'],
	
		));

		$subject = sprintf2(__('Submission failed at %site_name', 'btoa'), array('site_name' => get_bloginfo('name'),));
		
		$headers = 'From: '.get_bloginfo('name').' <'.get_option('admin_email').'>' . "\r\n";
		
		//// SENDS EMAIL
		wp_mail(get_option('admin_email'), $subject, $message, $headers);
		//// UPDATES THE USERS PROFILE ID
		update_post_meta($post->ID, 'featured_payment_profile_id', '');
						
	}
	
	

?>