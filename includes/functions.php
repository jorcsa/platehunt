<?php

// DAHERO #1667466 STRT

	add_action('save_post', '_ph_save_post', 10, 1);
	
	function _ph_save_post($post_id) {
		if (!$post = get_post($post_id)) { return $post_id; }
		//// MAKES SURE IT'S A SPOT
		if ($post->post_type == 'spot') {
			if (!has_post_thumbnail($post_id)) {
				$args = array(
					'post_type' => 'attachment',
					'post_mime_type' =>'image',
					'post_status' => 'inherit',
					'posts_per_page' => -1,
					'post_parent' => $post_id,
					'orderby' => 'menu_order',
					'order' => 'ASC',
				);
				$galQ = get_posts($args);
				
				if (is_array($galQ) && is_object($galP = reset($galQ))) {
					add_post_meta($post_id, '_thumbnail_id', $galP->ID, true);
				}
			}
// DAHERO #1667515 STRT
			$lat = get_post_meta($post_id, 'latitude', true);
			$lng = get_post_meta($post_id, 'longitude', true);

			if ($lat != '' && $lng != '')
			{
    			$geocodeResponse = wp_remote_get('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false');
    			$address = json_decode($geocodeResponse['body']);

    			if (!is_wp_error($geocodeResponse) && !empty($address->results)) {
                    foreach ($address->results[0]->address_components as $ac) {
                        if (in_array("locality", $ac->types)) {
						    update_post_meta($post_id, 'address_city', $ac->long_name);
                        }
                        if (in_array("country", $ac->types)) {
						    update_post_meta($post_id, 'address_country', $ac->long_name);
                        }
                    }
				    update_post_meta($post_id, 'address', $address->results[0]->formatted_address);
    			} else {
					update_post_meta($post_id, 'address_city', '');
					update_post_meta($post_id, 'address_country', '');
    			}
			}
			else
			{	
				update_post_meta($post_id, 'address_city', '');
				update_post_meta($post_id, 'address_country', '');
			}
// DAHERO #1667515 STOP
		}
		return $post_id;
	}

// DAHERO #1667466 STOP

	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	
	/* ==OTHER FUNCTION === */
	
	function ddTimthumb($img = NULL, $width = NULL, $height = NULL) {
		
		//// IF AN imAGE HAS BEEN PROVIDED
		if($img != NULL) {
		
			$image = vt_resize('', $img, $width, $height, true );
			
			//// IF ITS NOT AN ERROR
			if(is_array($image)) { return $image['url']; } else { return ''; }
		
		} else { return ''; }
		
	}
	
	function v_resize($img = NULL, $width = NULL, $height = NULL) {
		
		//// IF AN imAGE HAS BEEN PROVIDED
		if($img != NULL) { return ddTimthumb($img, $width, $height); } else { return ''; }
		
	}
	
	function getFeaturedImage($post_id = NULL) {
		
		if($post_id != NULL) {
			
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
			return $image;
			
		}
		
	}
	
	function btoa_get_featured_image($post_id = NULL) {
		
		if($post_id != NULL) {
			
			//// IF ES HAVE A GALLERY
			if(get_post_meta($post_id, '_sf_gallery_images', true) != '') {
			
				$gallery = json_decode(htmlspecialchars_decode(get_post_meta($post_id, '_sf_gallery_images', true)));
				
				if(is_object($gallery)) {
					
					if(count((array)$gallery) > 0) {
						
						foreach($gallery as $attach_id) {
							
							//// RETURN THE IMAGE URL
							if($the_image = wp_get_attachment_image_src($attach_id, 'full')) { return $the_image[0]; } else { return false; }
							
						}
						
					} else {  return ddp('placeholder'); }
					
				} else {
					
					return ddp('placeholder');
					
				}
			
			} else {
				
				///// TRIES THE NORMAL FEATURED IMAGE
				$image = getFeaturedImage($post_id);
				
				if(!$image) { return ddp('placeholder'); }
				
				return $image[0];
				
			}
			
		} else { return false; }
		
	}
	
	function randomString($valid_chars, $length) {
		
		$random_string = "";
	
		$num_valid_chars = strlen($valid_chars);
	
		for ($i = 0; $i < $length; $i++) {
			
			$random_pick = mt_rand(1, $num_valid_chars);
	
			$random_char = $valid_chars[$random_pick-1];
			
			$random_string .= $random_char;
		}
	
		return $random_string;
	}
	
	function getProportionalHeight($original_width, $original_height, $new_width) {
		
		if($new_width) {
			
			$temp = $original_width / $new_width;
			return round($original_height / $temp);
			
		}
		
	}
	
	function format_price($price) {
		
		//// IF IS NUMERIC
		if(is_numeric($price)) {
		
			/// ADDS OUR SIGN BEFORE AND AFTER
			return ddp('price_sign_before').$price.ddp('price_sign_after');
			
		} else { return $price; }
		
	}


	//////////////////////////////////////////////
	// INSERTS THE NECESSARY SCRIPTS IN OUR WP_HEAD
	// INSERTS CSS AS WELL
	//////////////////////////////////////////////
	
	add_action('wp_enqueue_scripts', 'theme_styles');
	
	function theme_styles() {
		
		//// FOUNDATION FRAMEWORK
		wp_register_style('foundation_normalize',  get_template_directory_uri().'/css/normalize.min.css', array(), '20130402', 'all');
		wp_register_style('foundation_custom',  get_template_directory_uri().'/css/foundation.min.css', array(), '20130402', 'all');
		
		//// MAIN STYLE.CSS
		wp_register_style('main',  get_stylesheet_uri(), array(), '20130402', 'all');
		
		//// RESPONSIVE
// DAHERO #1667517 STRT
//		wp_register_style('responsive',  get_template_directory_uri().'/css/responsive.min.css', array(), '20130402', 'all');
		wp_register_style('responsive',  get_template_directory_uri().'/css/responsive.css', array(), '20130402', 'all');
// DAHERO #1667517 STOP
		
		//// RETINA.CSS
		wp_register_style('_sf_retina', get_template_directory_uri().'/css/retina.css', array(), '20130402', 'all');
		
		//// CUSTOM SCROLLBAR
		wp_register_style('cScrollbar',  get_template_directory_uri().'/css/jquery.mCustomScrollbar.min.css', array(), '20130402', 'all');
		
		//// LET'S ENQUEUE IT
		wp_enqueue_style('foundation_normalize');
		wp_enqueue_style('foundation_custom');
		wp_enqueue_style('main');
		wp_enqueue_style('responsive');
		wp_enqueue_style('_sf_retina');
		wp_enqueue_style('cScrollbar');
		
	}
	
	//// REGISTERS OUR SCRIPTS
	add_action('init', 'btoa_register_scripts');
	
	$wp_scripts = new WP_Scripts();
	function btoa_register_scripts() {
		
		//scripts js
		wp_register_script( 'modernizr', get_template_directory_uri().'/js/custom.modernizr.js');
		wp_register_script( 'zepto', get_template_directory_uri().'/js/zepto.min.js');
		wp_register_script( 'foundation', get_template_directory_uri().'/js/foundation.min.js');
		wp_register_script( 'foundation_placeholder', get_template_directory_uri().'/js/foundation.placeholder.min.js');
// DAHERO #1667517 STRT
//		wp_register_script( 'bScripts', get_template_directory_uri().'/js/sf.scripts.min.js');
		wp_register_script( 'bScripts', get_template_directory_uri().'/js/sf.scripts.js');
// DAHERO #1667517 STOP
// DAHERO #1667454 STRT
//		wp_register_script( 'btoaMap', get_template_directory_uri().'/js/sf.map.min.js');
		wp_register_script( 'btoaMap', get_template_directory_uri().'/js/sf.map.js');
// DAHERO #1667454 STOP
// DAHERO #1667540 STRT
//		wp_register_script( 'btoaUser', get_template_directory_uri().'/js/sf.users.min.js');
		wp_register_script( 'btoaUser', get_template_directory_uri().'/js/sf.users.js');
// DAHERO #1667540 STOP
		wp_register_script( 'clusterer', get_template_directory_uri().'/js/markerclusterer.min.js');
		wp_register_script( 'jquery-validate', get_template_directory_uri().'/js/jquery.validate.min.js');
		wp_register_script( 'cScrollbar', get_template_directory_uri().'/js/jquery.mCustomScrollbar.min.js');
		wp_register_script( 'jquery-ui-touchpunch', get_template_directory_uri().'/js/jquery.ui.touch-punch.min.js');
		wp_register_script( 'sf_rating', get_template_directory_uri().'/js/sf.rating.min.js');
		
		//// GMAP
		wp_register_script('gmap', get_template_directory_uri().'/js/gmap3.min.js', array('jquery'));

// DAHERO #1667462 REMOVED GOOGLE SCRIPT LOADING FROM HERE TO sf.map.js
	}
	
	//// ENQUEUES OUR SCRIPTS
	add_action('wp_enqueue_scripts', 'btoa_enqueue_scripts');
	
	function btoa_enqueue_scripts() {
		
			
		wp_localize_script('bScripts', 'sf', array(
		
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'dependent_fields_nonce' => wp_create_nonce('dependent-fields-nonce'),
			'load_tag_suggestions_nonce' => wp_create_nonce('load-tag-suggestions-nonce'),
			'search_spots_nonce' => wp_create_nonce('search-spots-nonce'),
			'get_overlay_markup' => wp_create_nonce('get-overlay-markup'),
			'contact_form_name_error' => __('You need to type in your name', 'btoa'),
			'contact_form_email_error' => __('You need to type in your email address', 'btoa'),
			'contact_form_message_error' => __('You need to type in your message', 'btoa'),
			'spot_enquiry_nonce' => wp_create_nonce('spot-enquiry-nonce'),
			'overlays' => get_map_overlay_status(),
			'overlays_width' => ddp('overlay_width'),
			'login_widget_signup_nonce' => wp_create_nonce('login-widget-nonce'),
			'_sf_us_fb_login_nonce_widget' => wp_create_nonce('sf-us-fb-login-widget-nonce'),
			'login_widget_login_nonce' => wp_create_nonce('login-widget-nonce-login'),
			'primary_color' => ddp('primary_color'),
			'enable_radius_resizing' => ddp('map_radius_resizing'),
			'radius_resizing_icon' => ddp('map_radius_resizing_icon_'),
			'google_api' => ddp('google_places_api'),
			
		));
		
			
		wp_localize_script('btoaUser', 'sf_us', array(
		
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'_sf_logout_nonce' => wp_create_nonce('sf-logout-nonce'),
			'_sf_edit_profile_nonce' => wp_create_nonce('sf-edit-profile-nonce'),
			'_sf_change_password_nonce' => wp_create_nonce('sf-change-password-nonce'),
			'_sf_lost_password_nonce' => wp_create_nonce('sf-lost-password-nonce'),
			'_sf_reset_password_nonce' => wp_create_nonce('sf-reset-password-nonce'),
			'_sf_login_nonce' => wp_create_nonce('sf-login-nonce'),
			'_sf_register_nonce' => wp_create_nonce('sf-register-nonce'),
			'_sf_gallery_upload_nonce' => wp_create_nonce('sf-gallery-upload-nonce'),
			'_sf_profile_pic_upload_nonce' => wp_create_nonce('sf-profile-pic-upload-nonce'),
			'_sf_gallery_upload_count' => ddp('pbl_images'),
			'_sf_gallery_upload_count_extra' => ddp('price_images_num'),
			'_sf_gallery_upload_count_message' => sprintf2(__('Sorry, you can not upload more than %num image(s).', 'btoa'), array('num' => ddp('pbl_images'))),
			'_sf_tags_count' => ddp('pbl_tags_no'),
			'_sf_tags_count_extra' => ddp('price_tags_num'),
			'_sf_tags_count_message' => sprintf2(__('Sorry, you can not add more than %num tags.', 'btoa'), array('num' => ddp('pbl_tags_no'))),
			'_sf_tags_count_message_extra' => sprintf2(__('Sorry, you can not add more than %num tags.', 'btoa'), array('num' => ddp('price_tags_num'))),
			'_sf_tags_exist_message' => __('Sorry, you have already chosen this tag.', 'btoa'),
			'error_message' => __('Oops! Seems like there\'s something wrong. Please review your information.', 'btoa'),
			'_sf_tags_empty_message' => __('Please type in a tag.', 'btoa'),
			'_sf_save_nonce' => wp_create_nonce('sf-save-nonce'),
			'_sf_draft_saved_message' => __('Draft successfully saved.', 'btoa'),
			'_sf_load_dependent_fields_nonce' => wp_create_nonce('load-dependent-fields-nonce'),
			'_sf_delete_submission_nonce' => wp_create_nonce('sf-delete-submission-nonce'),
			'_sf_submit_nonce' => wp_create_nonce('sf-submit-nonce'),
			'_sf_submit_translation_nonce' => wp_create_nonce('sf-submit-translation-nonce'),
			'submit_error_message' => __('Oops, there are some errors in your submission.', 'btoa'),
			'_sf_refresh_cart_nonce' => wp_create_nonce('sf-refresh-cart-nonce'),
			'_sf_add_to_cart_nonce' => wp_create_nonce('sf-add-to-cart-nonce'),
			'_sf_remove_from_cart_nonce' => wp_create_nonce('sf-remove-from-cart-nonce'),
			'_sf_checkout' => wp_create_nonce('sf-checkout-nonce'),
			'_sf_load_notification_signup_nonce' => wp_create_nonce('sf-load-notification-signup-nonce'),
			'_sf_send_notification_signup_nonce' => wp_create_nonce('sf-send-notification-signup-nonce'),
			'_sf_us_fb_login_nonce' => wp_create_nonce('sf-us-fb-login-nonce'),
			'_sf_us_placeholder' => ddTimthumb(ddp('pbl_profile_placeholder'), 92, 108),
			'_sf_field_submission_upload_nonce' => wp_create_nonce('sf-field-submission-upload-nonce'),
			'_sf_field_submission_upload_count_message' => __('Sorry, you cannot upload any more files.', 'btoa'),
			'_sf_load_subcategories_submission_nonce' => wp_create_nonce('_sf_load_subcategories_submission_nonce'),
			
		));
			
		wp_localize_script('btoaMap', 'sf_map', array(
	
			'search_visibile' => ddp('search_visibility'),
			'search_position' => ddp('search_position'),
			'pin_2x' => ddp('map_pin_twox'),
			'pin_2x_w' => ddp('map_pin_2x_width'),
			'pin_2x_h' => ddp('map_pin_2x_height'),
			
		));
		
		wp_localize_script('sf_rating', 'sf_r', array(
		
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'_sf_rating_nonce' => wp_create_nonce('sf-rating-nonce'),
			'_sf_report_review_nonce' => wp_create_nonce('sf-report-review-nonce'),
			'_sf_trash_review_nonce' => wp_create_nonce('sf-trash-review-nonce'),
			'_sf_restore_review_nonce' => wp_create_nonce('sf-restore-review-nonce'),
			
		));
		
		//enqueues our scripts. let's enqueue jquery first to just make sure its loaded first in any case
		wp_enqueue_script('jquery');
		wp_enqueue_script('modernizr');
		wp_enqueue_script('zepto');
		wp_enqueue_script('foundation');
		wp_enqueue_script('foundation_placeholder');
		wp_enqueue_script('bScripts');
		wp_enqueue_script('btoaMap');
		wp_enqueue_script('btoaUser');
		wp_enqueue_script('google_maps_api');
		wp_enqueue_script('gmap');
		wp_enqueue_script('clusterer');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-mouse');
		wp_enqueue_script('jquery-ui-slider');
		if(is_single()) { wp_enqueue_script('comment-reply'); }
		wp_enqueue_script('cScrollbar');
		
		//// IF WE LET THE USER RESIZE, ENQUEUE DRAGGABLE
		if(ddp('map_resize') == 'on') {
			
				wp_enqueue_script('jquery-ui-draggable');
			
		}
		
		/// RTL
		if(ddp('spotfinder_rtl') == 'on') {
			
			wp_enqueue_style('spotfinder-rtl', get_template_directory_uri().'/css/rtl.css');
			
		}
		
		//// IF WE ARE IN THE ADD NEW PAGE
		if(is_page_template('login.php')) {
			
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('btoa-ui-widgett', get_template_directory_uri().'/js/ui-widget.js');
			wp_enqueue_script('iframe-transport', get_template_directory_uri().'/js/jquery.iframe-transport.js');
			wp_enqueue_script('btoa-ajax-upload-frontend', get_template_directory_uri().'/js/ajaxupload.js');
			wp_enqueue_script('jquery-validate');
			
			//// FLOT GRAPHS
			wp_enqueue_script('flot', get_template_directory_uri().'/js/jquery.flot.min.js');
			wp_enqueue_script('flot-stack', get_template_directory_uri().'/js/jquery.flot.stack.min.js');
			wp_enqueue_script('flot-time', get_template_directory_uri().'/js/jquery.flot.time.min.js');
			
		}
		
		///// IF WE ARE IN A LISTING PAGE
		if(is_single()) { if('spot' == get_post_type()) { wp_enqueue_script('sf_rating'); } }
		
		//// ENQUEUES TOUCHPUNCH
		wp_enqueue_script('jquery-ui-touchpunch', get_template_directory_uri().'/js/jquery.ui.touch-punch.min.js', array('jquery'), '3.6', true);
		
	}
	
	/////// L:ETS INCLUDE FOUNDATION 3 FOR IE 8 AND LOWER
	add_action('wp_head', 'btoa_foundation_3');
	
	
	
	//// ENQUEUES IN THE ADMIN AREA
	add_action('admin_enqueue_scripts', 'btoa_enqueue_scripts_admin');
	
	function btoa_enqueue_scripts_admin() {
		
		$current_screen = get_current_screen();
		
		//// ENQUEUES DATEPICKER IN SPOT PAGE
		if($current_screen->post_type == 'spot') {
			
			wp_enqueue_script('jquery-ui-datepicker');
			wp_enqueue_style('jquery-ui-lightness', get_template_directory_uri().'/includes/backend/css/jquery-ui-1.10.3.custom.min.css');
			
		}
		
	}
	
	
	
	function btoa_foundation_3() {
		
echo '<!-- Foundation 3 for IE 8 and earlier -->
<!--[if lt IE 9]>

<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/css/foundation3.min.css" media="all" />

<![endif]-->';
		
	}
	
	//// GETS TAXONOMY CUSTOM FIELD
	function getTermCustomField($term_id, $custom_field) {
		
		$term_meta = get_option('taxonomy_'.$term_id);
		if(isset($term_meta[$custom_field])) { return $term_meta[$custom_field]; }
		else { return ''; }
		
	}
	
	//// ADDS ANALYTICS TO OUR FOOTER
	add_action('wp_footer', 'footer_analytics');
	
	function footer_analytics() {
            
            //// GOOGLE ANALYTICS
            if(ddp('google_analytics') != '') { echo ddp('google_analytics'); }
		
	}

	
	function select_lang() {
	
		// Retrieve the directory for the localization files
		$lang_dir = get_template_directory().'/lang';
		 
		// Set the theme's text domain using the unique identifier from above
		load_theme_textdomain('btoa', $lang_dir);
	 
	}
	add_action('after_setup_theme', 'select_lang');
	
	if ( ! isset( $content_width ) ) $content_width = 1000;
	
	
	//// BETTER SPRINTF
	function sprintf2($str='', $vars=array(), $char='%')
	{
		if (!$str) return '';
		if (count($vars) > 0)
		{
			foreach ($vars as $k => $v)
			{
				$str = str_replace($char . $k, $v, $str);
			}
		}
	
		return $str;
	}
	
	/*
* Gets the excerpt of a specific post ID or object
* @param - $post - object/int - the ID or object of the post to get the excerpt of
* @param - $length - int - the length of the excerpt in words
* @param - $tags - string - the allowed HTML tags. These will not be stripped out
* @param - $extra - string - text to append to the end of the excerpt
*/
	function get_excerpt_by_id2($post_if, $length = 75, $tags = '', $extra = '[...]') {
	 
		$post = get_post($post_if);
	 
		if(has_excerpt($post->ID)) {
			$the_excerpt = $post->post_excerpt;
			return apply_filters('the_content', $the_excerpt);
		} else {
			$the_excerpt = $post->post_content;
		}
	 
		$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
		$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
		$excerpt_waste = array_pop($the_excerpt);
		$the_excerpt = implode($the_excerpt);
		$the_excerpt = substr($the_excerpt, 0, $length);
		
		if($the_excerpt != '') {
		$the_excerpt .= $extra;
		} else { $the_excerpt = ''; }
	 
		return apply_filters('the_content', $the_excerpt);
		
	}
	
	/*
* Gets the excerpt of a specific post ID or object
* @param - $post - object/int - the ID or object of the post to get the excerpt of
* @param - $length - int - the length of the excerpt in words
* @param - $tags - string - the allowed HTML tags. These will not be stripped out
* @param - $extra - string - text to append to the end of the excerpt
*/
function get_excerpt_by_id($post, $length = 75, $tags = '', $extra = ' [...]') {
 
 	$post = get_post($post);
 	
	if(!is_object($post)) { return false; }
 
	if(has_excerpt($post->ID)) {
		$the_excerpt = $post->post_excerpt;
		return apply_filters('the_content', $the_excerpt);
	} else {
		$the_excerpt = strip_tags($post->post_content);
	}
 
	$the_excerpt = strip_shortcodes(strip_tags($the_excerpt));
	$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
	$excerpt_waste = array_pop($the_excerpt);
	$the_excerpt = implode($the_excerpt);
	$the_excerpt = substr($the_excerpt, 0, $length);
		
		if($the_excerpt != '') {
		$the_excerpt .= $extra;
		} else { $the_excerpt = ''; }
 
	return $the_excerpt;
}
	
	
	
	////// CHECKS SOME SETTINGS WITHIN THE ADMIN PANEL
	add_action('admin_notices', 'btoa_check_for_admin_choices');     
	
	function btoa_check_for_admin_choices() {
		
		//// IF USER IS USING NORMAIL SLIDERS AND PLUGIN ISN'T INSTALLED
		if(ddp('home_slider') != 'Map' && !is_plugin_active('revslider/revslider.php')) {
			
			 echo '<div id="btoa_message" class="error"><p><strong>SpotFinder Warning!</strong> Make sure to install the Revolution Slider Plguin included with your download file if you are using normal slides!</p></div>';
			
		}
		
		///// IF WE CAN'T FIND A LISTINGS PAGE
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => 'listings.php',
			'hierarchical' => 0
		));
		foreach($pages as $page) { $listing_url = get_permalink($page->ID); }
		if(count($pages) == 0) {
			
			 echo '<div id="btoa_message" class="error"><p><strong>SpotFinder Warning!</strong> Looks like you have not created your listings page yet. Please create a new page with the Listings template.</p></div>';
			
		}
		
	}
	
	function get_translated_wpml_value($field_id, $value) {
		
		//// GETS GLOBAL AND FIELD AS A POST
		global $sitepress;
		$translated_value = $value;
		if(isset($sitepress)) {
			
			//// IF WPML IS SET
			if($field = get_post($field_id)) {
				
				
				
				
				//// IF ITS A DROPDOWN
				if(get_post_meta($field_id, 'field_type', true) == 'dropdown') {
					
					$fields = json_decode(htmlspecialchars_decode(get_post_meta($field_id, 'dropdown_values', true)));
					
					/// GOES THROUGH FIELD BY FIELD
					foreach($fields as $single_field) {
						
						/// IF ITS THE FIELD WE'RE LOOKIGN FOR
						if($single_field->label == $value) {
							
							//// LETS CHECK FOR THE WPML
							if(isset($single_field->wpml)) {
								
								//// GETS THE WPML
								$wpml = (array)$single_field->wpml;
								$cur_lang = ICL_LANGUAGE_CODE;
										
								//// CHECKS FOR LANGUAGE
								if(isset($wpml[$cur_lang])) {
									
									if($wpml[$cur_lang] != '') {
										
										//// RETURNS IT
										return $wpml[$cur_lang];
										
									}
									
								} //// IF CHECKS FOR LANGUAGE
								
							} //// LTES CHECK FOR THE WPML
							
						} //// IF ITS THE FIELD WE ARE LOOKING FOR
						
					} //// FOREACH
					
				} //// IF ITS A DORPDOWN
				
				
				
				
				//// IF ITS A DEPENDENT
				if(get_post_meta($field_id, 'field_type', true) == 'dependent') {
					
					$fields = json_decode(htmlspecialchars_decode(get_post_meta($field_id, 'dependent_values', true)));
					
					//// GOES THROUGH SECTIONS
					foreach($fields as $section) {
					
						/// GOES THROUGH FIELD BY FIELD
						foreach($section as $single_field) {
							
							/// IF ITS THE FIELD WE'RE LOOKIGN FOR
							if($single_field->label == $value) {
								
								//// LETS CHECK FOR THE WPML
								if(isset($single_field->wpml)) {
									
									//// GETS THE WPML
									$wpml = (array)$single_field->wpml;
									$cur_lang = ICL_LANGUAGE_CODE;
											
									//// CHECKS FOR LANGUAGE
									if(isset($wpml[$cur_lang])) {
										
										if($wpml[$cur_lang] != '') {
											
											//// RETURNS IT
											return $wpml[$cur_lang];
											
										}
										
									} //// IF CHECKS FOR LANGUAGE
									
								} //// LTES CHECK FOR THE WPML
								
							} //// IF ITS THE FIELD WE ARE LOOKING FOR
							
						} //// FOREACH
					
					} //// ENDS FOREACH FOR SECTIONS
					
				} //// IF ITS A DORPDOWN
				
				
				
			}
			
		}
		
		return $translated_value;
		
	}
	
	
	///// TRIES TO GET A TRANSLATION FROM THE FORM FIELDS LABELS
	function get_form_wpml_label($field) {
		
		////global
		global $sitepress;
		
		///// CHECKS FOR WPML
		if(isset($sitepress)) {
			
			//// CHECKS FOR WPML
			if(isset($field->wpml)) {
				
				$wpml = (array)$field->wpml;
				$cur_lang = ICL_LANGUAGE_CODE;
				
				//// CHECKS FOR LANGUAGE
				if(isset($wpml[$cur_lang])) {
					
					//// IF IT HAS SOMETHING
					if($wpml[$cur_lang] != '') {
						
						return $wpml[$cur_lang];
						
					}
					
				}	
				
			}
			
		}
		
		
		return $field->label;
		
	}
	
	
	////// FIXES REL WARNING ON VALIDATIONS
	/**
  * Filters the_category() to output html 5 valid rel tag
  *
  * @param string $text
  * @return string
  */
function html_validate( $text ) {
	$string = 'rel="tag"';
	$replace = 'rel="category tag"';
	$text = str_replace( $replace, $string, $text );

	return $text;
}
add_filter( 'the_category', 'html_validate' );

?>