<?php

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION RETRIEVES THE DEPENDENT FIELDS BASED ON A PARENT
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax_reload_dependent_fields', 'reload_dependent_fields_function');
	add_action('wp_ajax_nopriv_reload_dependent_fields', 'reload_dependent_fields_function');
	
	function reload_dependent_fields_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'dependent-fields-nonce')) 
			die("Busted!");
			
		//// GETS OUR PARENT SEARCH FIELD
		if(get_post_meta(get_post_meta($_POST['post_id'], 'dependent_parent', true), 'dropdown_type', true) == 'categories') {
			
			//// GETS THE ID OF THE TERM IN QUESTION - IF SOMETHING IS SET
			if($parent_cat = get_term_by('slug', $_POST['parent'], 'spot_cats')) {
				
				//// CATEGORIES TO INCLUDE
				$include = get_post_meta($_POST['post_id'], 'dropdown_categories', true);
				if(!is_array($include)) { $include = array(); }
				elseif(in_array('all', $include)) { $include = array(); }
			
				//// ITS A CATEGORY SO WE NEED TO GET SUBCATEGORIES FOR THIS ITEM
				$the_terms = get_terms('spot_cats', array(
				
					'hide_empty' => false,
					'child_of' => $parent_cat->term_id,
					'include' => $include,
				
				));
				
				//// IF WE HAVE FOUND TERMS
				if($the_terms) {
					
					$return['fields'] = array(
					
						array(
						
							'id' => '',
							'label' => __('Any', 'btoa'),
						
						)
					
					);
					
					//// GOES TERM BY TERM AND RETRIEVES IT
					foreach($the_terms as $term) {
						
						$return['fields'][] = array(
						
							'id' => $term->slug,
							'label' => $term->name
						
						);
						
					}
						
					echo json_encode($return); exit;
					
					
				} else  {
				
					//// RETURNS NOTHING
					$return['found'] = TRUE;
					
					$return['fields'] = array(
					
						array(
						
							'id' => '',
							'label' => __('Any', 'btoa'),
						
						)
					
					);
					
					echo json_encode($return); exit;
				
				}
			
			} else {
						
				//// RETURN NOTHING
				$return['found'] = TRUE;
				
				$return['fields'] = array(
				
					array(
					
						'id' => '',
						'label' => __('Any', 'btoa'),
					
					)
				
				);
				
				echo json_encode($return); exit;
				
			}
			
		}
			
		//// LETS GET THE SELECTED PARENT
		if($field = get_post($_POST['post_id'])) {
			
			//// GETS ALL FIELDS FROM THIS FIELD
			$values = get_post_meta($field->ID, 'dependent_values', true);
			
			//// IF NOT EMPTY
			if(!empty($values)) {
				
				//// GOES THROUGH EACH FIELD UNTIL WE FIND OUR PARENT
				foreach(json_decode(htmlspecialchars_decode($values)) as $key => $parent) {
					
					//// IF IT'S OUR PARENT
					if($key == $_POST['parent']) {
						
						$return['found'] = TRUE;
						
						$return['fields'] = array(
						
							array(
							
								'id' => '0',
								'label' => __('Any', 'btoa'),
							
							)
						
						);
						
						global $sitepress;
						
						//// NOW LETS GO THROUGH EACH FIELD AND ADD TO OUR ARRAY
						foreach($parent as $key => $field) {
							
							$label = $field->label;
							
							///// CHECKS FOR WPML
							if(isset($sitepress)) {
								
								//// CHECKS TO SEE IF THIS OPTION HAS A LABEL TRANSLATED
								//// IF OUR WPML ISSET
								if(isset($field->wpml)) {
									
									$wpml = (array)$field->wpml;
									
									$cur_lang = ICL_LANGUAGE_CODE;
									
									//// CHECKS FOR LANGUAGE
									if(isset($wpml[$cur_lang])) {
										
										//// IF IT HAS SOMETHING
										if($wpml[$cur_lang] != '') {
											
											$label = $wpml[$cur_lang];
											
										}
										
									}
									
								}
								
							}
							
							$return['fields'][] = array(
							
								'id' => $field->id,
								'label' => $label
							
							);
							
						}
						
					}
					
				}
				
				if(!isset($return['found'])) { $return['error'] = true; }
				
			} else { $return['error'] = true; }
			
		} else { $return['error'] = true; }
		
		echo json_encode($return);
		
		exit;
		
	}
	
	

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION RETRIEVES TAG SUGGESTIONS FOR TEXT INPUT SEARCHES
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax_load_tag_suggestions', 'load_tag_suggestions_function');
	add_action('wp_ajax_nopriv_load_tag_suggestions', 'load_tag_suggestions_function');
	
	function load_tag_suggestions_function() {
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'load-tag-suggestions-nonce')) 
			die("Busted!");
			
		//// GETS OUR STRING
		$str = isset($_POST['string']) ? trim(sanitize_text_field($_POST['string'])) : '';
		
		/// GETS ALL TERMS BY NAME
		$return['results'] = get_terms('spot_tags', array(
		
			'search' => $str,
			'hide_empty' => '1',
			'number' => 5,
		
		));
		
		echo json_encode($return);
		
		exit;
		
	}
	
	

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION RETRIEVES OVERLAY MARKUP
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax_get_overlay_markup', 'get_overlay_markup_function');
	add_action('wp_ajax_nopriv_get_overlay_markup', 'get_overlay_markup_function');
	
	function get_overlay_markup_function() {
		
		//sleep(1);
		
		$return = array();
		$return['error'] = false;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'get-overlay-markup')) 
			die("Busted!");
			
		$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
			
		//// GETS THE PROPERTY ID
		if($post = get_post($_POST['post_id']) && $post_id != '') {
			
			/// MARKUP
			$return['markup'] = '';
			
			//// STARTS WITH OUR IMAGE
			if($image = btoa_get_featured_image($post_id) && ddp('lst_logo') != 'on') {
				
				$image = btoa_get_featured_image($post_id);
				
				$return['markup'] .= '<div class="overlay-image"><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'"><img src="'.ddTimthumb($image, ddp('overlay_image'), ddp('overlay_height')).'" alt="" title="" /></a></div>';
				
			}
			
			//// STARTS THE CONTENT
			$return['markup'] .= '<div class="overlay-content">';
			
			
				//// CHECKS FOR CATEGORIES
				if(ddp('overlay_cats') == 'on') {
					
					/// GETS TERMS
					if($terms = get_the_terms($post_id, 'spot_cats')) {
						
						$return['markup'] .= '<h5 class="overlay-cats">';
						
						$the_terms = '';
						foreach($terms as $cat) { $the_terms .= '<a href="'.get_term_link($cat, 'spot_cats').'" title="'.$cat->name.'">'.$cat->name.'</a>, '; }
						$return['markup'] .= rtrim($the_terms, ', ');
						
						$return['markup'] .= '</h5>';
						
					}
					
				}
				
				//// CHECK FOR RATING
				if(ddp('rating') == 'on' && ddp('rating_overlay') == 'on') {
					
					$rating = get_post_meta($post_id, 'rating', true);
					
					//// GETS THE RATING
					if($rating != '' && $rating != 0 && $rating != '0') {
						
						$return['markup'] .= '<p class="overlay-rating secondary-color">'.sf_get_rating_html($rating).'</p>';
						
					}
					
				}
				
				//// TITLE
				$return['markup'] .= '<h2><a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'">'.get_the_title($post_id).'</a></h2>';
				
				//// CHECKS FOR EXCERPT
				if(ddp('overlay_excerpt') == 'on') {
					
					$excerpt = get_excerpt_by_id($post_id, ddp('overlay_excerpt_length'));
					
					//// IF THE EXCERPT IS NOT EMPTY
					if($excerpt != '') {
						
						$return['markup'] .= '<p>'.$excerpt.'</p>';
						
					}
					
				}
				
				
				////////////////////////////////////////////////////
				///// CHECKS FOR SEARCH FIELDS TO INCLUDE
				////////////////////////////////////////////////////
				
				$args = array(
				
					'post_type' => 'search_field',
					'posts_per_page' => -1,
					'meta_query' => array(
					
						array(
						
							'key' => 'include_overlay',
							'value' => 'on',
						
						),
						
						array(
						
							'key' => 'overlay_markup',
							'value' => '',
							'compare' => '!=',
						
						)
					
					),
				
				);
				
				$sQ2 = new WP_Query($args);
				
				if($sQ2->have_posts()) {
					
					//// STARTS OUR MARKUP
					$return['markup'] .= '<ul class="fields_overlay">';
					
						//// NOW LETS GET ALL THE CATEGORIES IN THIS POST AND MAKE SURE WE ONLY DISPLAY THE NECESARY FIELDS
						//// WE ALSO CREATE AN ARRAY WITH ALL THE CATEGORIES
						$spot_terms = get_the_terms($post_id, 'spot_cats'); $spot_cats = array();
						if(is_array($spot_terms)) { foreach($spot_terms as $_term) { $spot_cats[] = $_term->term_id; } }
					
						while($sQ2->have_posts()) { $sQ2->the_post();
						
							//// NOW WE CHECK TO SEE IF THE FIELD HAS THIS CATEGORY ASSIGNED TO IT
							$is_field_in_cat = false;
							$field_cats = get_post_meta(get_the_ID(), 'public_field_category', true);
							if(is_array($field_cats)) {
								if(in_array('all', $field_cats) || empty($field_cats)) { $is_field_in_cat = true; } else {
					
									///// GOES THROUGH CATEGORY BY CATEGORY
									foreach($field_cats as $field_cat) {
										
										if(in_array($field_cat, $spot_cats)) { $is_field_in_cat = true; }
										
									}
								
								}
							}
							
							///// IF NOT AN ARRAY THE USER HASNT SET
							if($field_cats == '') { $is_field_in_cat = true; }
							
							//// IF THIS FIELD IS WITHIN THIS CATEGORY WE GO THROUGH
							if($is_field_in_cat) {
					
								//// CHECKS FOR RANGE FIELD
								if(get_post_meta(get_the_ID(), 'field_type', true) == 'range') {
									
									//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
									$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
									
									if($field != '') { $return['markup'] .= '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), $field).'</li>'; }
									
								}
						
								//// CHECKS FOR CHECK FIELD
								elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'check') {
									
									//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
									$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
									
									if($field == 'on') { $return['markup'] .= '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), '').'</li>'; }
									
								}
						
								//// CHECKS FOR MIN VAL FIELD
								elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'min_val') {
									
									//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
									$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
									
									if($field != '') { $return['markup'] .= '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), $field).'</li>'; }
									
								}
						
								//// CHECKS FOR MAX VAL FIELD
								elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'max_val') {
									
									//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
									$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
									
									if($field != '') { $return['markup'] .= '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), $field).'</li>'; }
									
								}
						
								//// CHECKS FOR DROPDOWN FIELD
								elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'dropdown') {
									
									//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
									$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
									
									if($field != '') { $return['markup'] .= '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup_dropdown(get_the_ID(), $field).'</li>'; }
									
								}
						
								//// CHECKS FOR DEPENDENT FIELD
								elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'dependent') {
									
									//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
									$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
									
									if($field != '') { $return['markup'] .= '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup_dependent(get_the_ID(), $field).'</li>'; }
									
								}
							
							}
							
							
						} wp_reset_postdata();
					
					
					//// CLOSES
					$return['markup'] .= '</ul>';
					
				}
				
				
				//// IF USER HAS CHOSEN GEOLOCATION AND DIRECTION
				if(ddp('map_directions') == 'on' && ddp('map_geolocation') == 'on') {
					
					$return['markup'] .= '<a class="get_directions" href="#" onclick="jQuery(\'#slider-map\').getDirections(event, '.$post_id.', \''.ddp('map_directions_travel').'\');">'.__('Get Directions', 'btoa').'</a>';
					$return['direction_message'] = __('Oops, directions from your location are not available', 'btoa');
					
				}
			
			
			//// CLOSES CONTAINER
			$return['markup'] .= '</div>';
			
			
			$return['height'] = ddp('overlay_height');
			
		} else { $return['error'] = true; $return['message'] = __('Oops, we couldn\'t find the post you are looking for.', 'btoa'); }
			
			
		echo json_encode($return);
		
		exit;
		
	}
	
	

	
	//////////////////////////////////////////////////////////////////////
	///// THIS FUNCTION RETRIEVES FIELTERED SPOTS EVERY TIME THE SEARCH
	///// BAR IS SUBMITTED
	//////////////////////////////////////////////////////////////////////
	
	add_action('wp_ajax_ajaxSearchSpots', 'ajaxSearchSpots_function');
	add_action('wp_ajax_nopriv_ajaxSearchSpots', 'ajaxSearchSpots_function');
	
	function ajaxSearchSpots_function() {
		//sleep(1);
		$return = array();
		$return['error'] = false;
		
		global $sitepress;
		
		//// VERIFIES NONCE
		$nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
		if(!wp_verify_nonce($nonce, 'search-spots-nonce')) 
			die("Busted!");
			
		//// WE NEED TO GO THROUGH OUR SENT DATA AND START BUILDING OUR ARRAY
		if(isset($_POST['data'])) {
			
			/// INITIAL QUERY
			$args = array(
			
				'post_type' => 'spot',
				'posts_per_page' => -1,
				'tax_query' => array(),
				'meta_query' => array(),
				'post_status' => 'publish',
			
			);
			
			/// CHECKS FOR LOAD TAX
			if($_POST['load_tax'] != NULL) { $args['tax_query'][] = array(
			
				'taxonomy' => 'spot_cats',
				'terms' => $_POST['load_tax'],
				'field' => 'ID',
			
			); }
			
			/// CHECKS FOR LOAD TAG 9TAGS ONLY HERE)
			if($_POST['load_tag'] != NULL) { $args['tax_query'][] = array(
			
				'taxonomy' => 'spot_tags',
				'terms' => $_POST['load_tag'],
				'field' => 'ID',
			
			); }
			
			/// FIELDS
			$fields = array();
			parse_str($_POST['data'], $fields);
			
			//// STARTS OUR GET STRING
			$get_url = array();
			
			$force_radius = false;
			$return['destroy_radius'] = false;
						
			///// IF WE HAVE FORCE RADIUS
			if(isset($_POST['force_radius'])) { if(is_numeric($_POST['force_radius'])) { $force_radius = $_POST['force_radius']; } }
			
			//// CHECKS IF WE ARE USING RADIUS - IF WE ARE WE'RE GOING TO DISABLE ALL LOCATION BASED SELECTION AND WORK ONLY WITH RADIUS
			if($fields['_sf_enable_radius_search']) {  }
			
			//// GOES THROUGH EACH FIELD AND BUILD UP OUR QUERY
			foreach($fields as $_key => $_field) {
				
				//// GETS THE TYPE OF FIELD BY IT'S SLUG - IF FALSE SKIP THIS FIELD
				if($field = get_page_by_path($_key, OBJECT, 'search_field')) {
					
					//// GETS THE TYPE OF THE POST
					$field_type = get_post_meta($field->ID, 'field_type', true);
					
					
					/////////////////////////////////////////////////////////////////
					///// CHECKS FOR IF FIELD
					/////////////////////////////////////////////////////////////////
					$if_enable = true;
					if(isset($fields['sf_if_'.$field->ID.'_parent'])) {
						
						$if_enable = false;
						
						$if_parent_id = $fields['sf_if_'.$field->ID.'_parent'];
						
						//// LET'S MAKE SURE OUR PARENT FIELD IS A SEARCH FIELD
						if($if_parent_field = get_post($if_parent_id)) {
							
							//// CHECKS TO SEE IF IT'S SET
							if(isset($fields[$if_parent_field->post_name])) {
								
								//// IF THIS PARENT FIELD IS A DROPDOWN, WE NEED TO GET OUR VALUES
								if(get_post_meta($if_parent_field->ID, 'field_type', true) == 'check') {
									
									//// IF PARENT FIELD IS ON
									$if_enable = true;
									
								} else {
									
									//// GETS APPROPRIATE VALUES - IF SET
									if(isset($fields['sf_if_'.$field->ID.'_values'])) {
										
										$if_values = explode('||', $fields['sf_if_'.$field->ID.'_values']);
										
										///// IF OUR SELECTED VALUE FOR OUR PARENT FIELD IS WITHIN OUR VALUES
										if(in_array($fields[$if_parent_field->post_name], $if_values)) {
											
											$if_enable = true;
											
										}
										
										///// IF ITS STILL FALSE CHECK FOR ALL
										if(!$if_enable && $fields[$if_parent_field->post_name] == '') {
											
											///// IF IT IS SET TO ALL AS A VALUE
											if(in_array('all', $if_values)) { $if_enable = true; }
											
										}
										
									}
									
								}
								
							}
							
						}
						
					}
					
					
					
					///// ONLY GO THROUGH IF FIELD IS ENABLED
					if($if_enable) {
					
					
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A TEXT FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'text') {
								
							///// GETS OUR DEFAULT TEXT
							$default_text = get_post_meta($field->ID, 'text_default', true);
							
							//// TRIES TO GET TRANSLATED DEFAULT TEXT
							if(isset($sitepress)) {
								
								$default_text_temp = get_post_meta($field->ID, 'text_default_'.ICL_LANGUAGE_CODE, true);
								
								if($default_text_temp != '') {
									
									$default_text = $default_text_temp;
									
								}
								
							}
							
							///// IF WE ARE USING GOOGLE MAPS API
							if(get_post_meta($field->ID, 'text_type', true) == 'google_places') {
								
								//// LETS CHECK FOR OUR LATITUDE AND LONGITUDE RANGE
								if(($fields['_sf_field_'.$field->ID.'_lat'] != '') && ($fields['_sf_field_'.$field->ID.'_lng'] != '')) {
									
									//// LETS GET THE LATITUDE RANGE
									$lat_range = explode('|', $fields['_sf_field_'.$field->ID.'_lat']);
									$lng_range = explode('|', $fields['_sf_field_'.$field->ID.'_lng']);
									
									///// LETS VALIDATE IT
									if(isset($lat_range[0])
									&& isset($lat_range[1])
									&& isset($lng_range[0])
									&& isset($lng_range[1])) {
										
										///// IF THEY ARE VALID LATITUDE AND LONGITUDES
										///// AND MAKES SURE WE'RE NOT USING RADIUS
										if($lat_range[0] >= -90 && $lat_range[0] <= 90
										&& $lat_range[1] >= -90 && $lat_range[1] <= 90
										&& $lng_range[0] >= -180 && $lng_range[1] <= 180
										&& $lng_range[1] >= -180 && $lng_range[1] <= 180
										&& $fields['_sf_enable_radius_search'] != 'true') {
											
											if($lat_range[0] > $lat_range[1]) {
												
												$temp_lat = $lat_range[0];
												$lat_range[0] = $lat_range[1];
												$lat_range[1] = $temp_lat;
												
											}
											
											if($lng_range[0] > $lng_range[1]) {
												
												$temp_lng = $lng_range[0];
												$lng_range[0] = $lng_range[1];
												$lng_range[1] = $temp_lng;
												
											}
											
											///// LETS CHECK FOR SENSITIVITY
											if(get_post_meta($field->ID, 'google_places_sensitivity', true) != '') {
												
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
											
											///// LETS ALSO ADD THIS ARGUMENTS TO OUR URL JUST SO WE CAN ALSO GET IT FROM THE URL
											$get_url['glat'] = $fields['_sf_field_'.$field->ID.'_lat'];
											$get_url['glng'] = $fields['_sf_field_'.$field->ID.'_lng'];
											$get_url['gplace'] = urlencode($fields[$field->post_name]);
											
										}
										
									}
									
								}
								
								///// LATITUDE AND LONGITUDE ISNT SET, LETS TRY GETTING FROM GOOGLE API DIRECTLY
								else if($_field != $default_text && $_field != '' && $fields['_sf_enable_radius_search'] != true) {
									
									//// MAKE SURE WE HAVE A GOOGLE PLACES API
									if(ddp('google_places_api') != '') {
										
										//// STARTS BUILDING OUR XML QUERY
										$google_places_url = 'https://maps.googleapis.com/maps/api/place/autocomplete/xml?key='.ddp('google_places_api').'&sensor=false&input='.$fields[$field->post_name].'&types=(regions)';
										
										//// IF WE HAVE SET A COUNTRY
										$country = get_post_meta($field->ID, 'google_places_country', true);
										if($country != '') { $google_places_url .= '&components=country:'.$country; }
										
										///// LETS TRY AND LOAD THIS
										$google_results = simplexml_load_file($google_places_url);
										
										//// IF WE HAVE AN OK STATUS
										if($google_results->status == 'OK') {
											
											//// IF WE HAVE MORE THAN ONE ONLY GET THE FIRST
											if(is_array($google_results->prediction)) { $prediction = array_shift($google_results->prediction); }
											else { $prediction = $google_results->prediction; }
											
											//// LETS GET THE REFERENCE AND GET MORE INFO ABOUT THIS PLACE
											$place_reference = $prediction->reference;
											
											//// NOW WE NOOD TO DO ANOTHER QUERY (AGAIN) AND GET THE REFERENCE DETAILS
											$reference_url = 'https://maps.googleapis.com/maps/api/place/details/xml?key='.ddp('google_places_api').'&sensor=false&reference='.$place_reference;
											$reference_result = simplexml_load_file($reference_url);
											
											//// REFRESHES OUR QUERY AND ADDS A RECENTER
											//// LETS DO OUR QUERY
											$args['meta_query'][] = array(
											
												'key' => 'latitude',
												'value' => (string)$reference_result->result->geometry->viewport->southwest->lat,
												'compare' => '<=',
												'type' => 'DECIMAL',
											
											);
											
											$args['meta_query'][] = array(
											
												'key' => 'latitude',
												'value' => (string)$reference_result->result->geometry->viewport->northeast->lat,
												'compare' => '>=',
												'type' => 'DECIMAL',
											
											);
											
											//// LETS DO OUR QUERY
											$args['meta_query'][] = array(
											
												'key' => 'longitude',
												'value' => (string)$reference_result->result->geometry->viewport->southwest->lng,
												'compare' => '>=',
												'type' => 'DECIMAL',
											
											);
											
											$args['meta_query'][] = array(
											
												'key' => 'longitude',
												'value' => (string)$reference_result->result->geometry->viewport->northeast->lng,
												'compare' => '<=',
												'type' => 'DECIMAL',
											
											);
											
											//// MAKES SURE WE RE LOCATE THE MAP
											$return['change_location'] = true;
											$return['change_location_lat'] = (string)$reference_result->result->geometry->location->lat;
											$return['change_location_lng'] = (string)$reference_result->result->geometry->location->lng;
											$return['change_zoom'] = 15;
											
											
										} else {
											
											$return['message'] = __('Something has gone wrong with our Google Places API Check.', 'btoa');
											
											//// IF ZERO RESULTS
											if($google_results->status == 'ZERO_RESULTS') { $return['message'] = __('We could not find the place you are looking for.', 'btoa'); }	
											
											///// IF SOMETHING WENT WRONG
											if($google_results->status == 'OVER_QUERY_LIMIT') { $return['message'] = __('You have gone over your Google Places API Query limit for today. Error code 223.', 'btoa'); }
											if($google_results->status == 'REQUEST_DENIED') { $return['message'] = __('The Google Places API Key you have provided is invalid.', 'btoa'); }
											if($google_results->status == 'INVALID_REQUEST') { $return['message'] = __('Search input is empty.', 'btoa'); }
											
											echo json_encode($return); exit;
											
										}
										
									} else {
										
										$return['message'] = __('Please provide a Google Places API Key', 'btoa');
										
									}
									
								} //// IF ITS NOT EMPTY
								
							} else  {
							
								//// MAKES SURE ITS NOT OUR DEFAULT TEXT _ IF NOT SEARCH FOR TAGS
								//// MAKES SURE ITS NOT EMPTY
								if($_field != $default_text && $_field != '') {
									
									//// GETS THE TAGS TYPED - IF IT EXISTS RETURN IT
									$tags = get_terms('spot_tags', array(
				
										'search' => $_field,
										'hide_empty' => '1'
									
									));
									
									//// PUTS ALL IDS WITHIN AN ARRAY
									$tag_array = array();
									foreach($tags as $single_tag) { $tag_array[] = $single_tag->slug; }
									
									//// IF WE HAVE FOUND AT LEAST ONE TAG
									if(count($tag_array) > 0) {
									
										$args['tax_query'][] = array(
										
											'taxonomy' => 'spot_tags',
											'field' => 'slug',
											'terms' => $tag_array,
										
										);
										
										//// ADDS TO OUR LISTING URL AS A PARAM
										$get_url[$_key] = $single_tag->slug;
										
									} else {
										
										$return['message'] = __('Invalid Keyword', 'btoa');
										
									}/// ENDS IF WE HAVE AT LEAST ONE TAG
									
								} //// END SIF NOT DEFAULT TEXT
							
							}//// ENDS IF ITS A TAG
							
						} //// ENDS IF TEXT FIELD
						
						
						
						
						
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A DROPDOWN FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'dropdown') {
							
							
							//// WHETHER WE ARE ACTUALLY LOOKING FOR A CITY OR IF IT'S ANY
							if($_field != '') {
								
								//// IF CUSTOM VALUES
								$dropdown_type = get_post_meta($field->ID, 'dropdown_type', true);
								
								if($dropdown_type != 'categories') {
									
									$pass_radius_query = true;
									
									$dropdown_fields = json_decode(htmlspecialchars_decode(get_post_meta($field->ID, 'dropdown_values', true)));
									
									//// LET'S CHECK IS THIS SELECTED FIELD HAS A RADIUS - INDEPENDENT OF WHETHER OR NOT WE'VE CHANGED IT
									if(get_post_meta($field->ID, 'dropdown_change_location', true) == 'on') { foreach($dropdown_fields as $dropdown_field) { if($dropdown_field->id == $_field) { if($dropdown_field->latitude != '' && $dropdown_field->longitude != '') { if(isset($dropdown_field->radius)) { if($dropdown_field->radius != '' & is_numeric($dropdown_field->radius)) { $pass_radius_query = false; } } } } } }
									
									//// CHECK IF A DEPENDENT HAS SET THIS TO FALSE
									if(isset($fields['_sf_ignore_sel_'.$field->ID.'_parent'])) { if($fields['_sf_ignore_sel_'.$field->ID.'_parent'] == $dropdown_field->id) { $pass_radius_check = false; } }
								
									//// IF IT'S SUPPOSED TO CHANGE LOCATION - ALSO CHECKS TO SEE IF USER HAS
									//// CHANGES THE FIELD OR IF HE CHANGED SOMETHING ELSE
									if(get_post_meta($field->ID, 'dropdown_change_location', true) == 'on' && $fields['has_changed_'.$_key] == 'true') {
									
										//// GETS THE SELECTED FIELD FOR LATITUDE AND LONGITUDE
										foreach($dropdown_fields as $dropdown_field) {
											
											//// IF IT'S THE FIELD WE AR ELOOKING FOR
											if($dropdown_field->id == $_field) {
												
												/// IF LATITUDE AND LONGITUDE ARE SET
												if($dropdown_field->latitude != '' && $dropdown_field->longitude != '') {
													
													/// CHECK IF WE ARE USING A RADIUS AND IF THE USER HAS EXPANDED THE RADIUS SECTION
													$pass_radius_check = true; $pass_radius_query = true;
													if(isset($fields['_sf_ignore_sel_'.$field->ID])) { if($fields['_sf_ignore_sel_'.$field->ID] == $dropdown_field->id) {  $pass_radius_check = false; } }
													if(isset($dropdown_field->radius)) { if($dropdown_field->radius != '' & is_numeric($dropdown_field->radius)) { $pass_radius_query = false; } }
													
													//// CHECK IF THERE IS NO RADIUS JSUT SO WE CAN DESTROY IT
													if(isset($dropdown_field->radius)) { if($dropdown_field->radius == '' || !is_numeric($dropdown_field->radius)) { $return['destroy_radius'] = true; } }
													else { $return['destroy_radius'] = true; }
													
													/// IF THE USER HAS NOT MESSED WITH THE RADIUS YET, LETS MOVE THE MAP AND SET THE INITIAL RADIUS IF BEING USED
													if($pass_radius_check) {
														
														//// IF WE ARE NOT USING RADIUS - OR IF THIS OUR RADIUS FIELD
														if($fields['_sf_enable_radius_search'] != 'true' || $fields['_sf_radius_field'] == $field->ID) {
													
															$return['change_location'] = true;
															$return['change_location_lat'] = $dropdown_field->latitude;
															$return['change_location_lng'] = $dropdown_field->longitude;
															
															//// CHECKS FOR ZOOM
															if($dropdown_field->zoom != '' && is_numeric($dropdown_field->zoom)) { if($dropdown_field->zoom >= 1 && $dropdown_field->zoom <= 20) { $return['change_zoom'] = $dropdown_field->zoom; } }
														
														}
														
														if(isset($dropdown_field->radius)) { if($dropdown_field->radius != '' & is_numeric($dropdown_field->radius)) {
															
															//// MAKES SURE WE SAY WHETHER WE'RE TALKING ABOUT MILES OR KILOMETRES AS WELL
															$return['radius_lat'] = $dropdown_field->latitude;
															$return['radius_lng'] = $dropdown_field->longitude;
															$return['change_radius'] = $dropdown_field->radius;
															if(isset($force_radius)) { if(is_numeric($force_radius)) { $return['change_radius'] = $force_radius; } }
															$return['distance_type'] = ddp('geo_distance_type');
															$return['radius_field_id'] = $field->ID;
															$return['radius_field_val'] = $dropdown_field->id;
															
															//// NO WE ALSO NEED TO SET A FORCE_USE RADIUS VARIABLE FOR LATER ON
															$force_radius = true;
															
															//// LETS GET THE MINIMUM AND MAXIMUM VALUE LATITUDE AND LONGITUDE BASED ON THE CENTER AND KILOMETER SO WE CAN ROUND OUT THE RESULTS
															$force_values = _sf_get_min_max_lat_lng($return['change_radius'], $dropdown_field->latitude, $dropdown_field->longitude);
															
															
															
														} }
														
													}
													
												}
											
											}
											
										}
										
									}//// ENDS IF IT'S SUPPOSED TO CHANGE LOCATION
								
								} /// ONLY CHECKS IF CUSTOM VALUES
								
								//// IF CUSTOM VALUES - AND IF NOT USING RADIUS
								if($dropdown_type != 'categories' && $pass_radius_query) {
								
									///// BUILD OUR QUERY
									$args['meta_query'][] = array(
									
										'key' => '_sf_field_'.$field->ID,
										'value' => $_field,
										'compare' => 'LIKE',
									
									);
								
								} else {
									
									/// FIRST LETS MAKE SURE THE TAXONOMY EXISTS
									if($this_tax = get_term_by('slug', $_field, 'spot_cats')) {
										
										//// ADDS TO OUR QUERY
										$args['tax_query'][] = array(
										
											'taxonomy' => 'spot_cats',
											'field' => 'slug',
											'terms' => $_field,
										
										);
										
									}
									
								}
									
								//// ADDS TO OUR LISTING URL AS A PARAM
								$get_url[$_key] = $_field;
								
								
							}/// ENDS IF WE ARE ACTUALLY LOOKING FOR A DROPDOWN
							
						} //// ENDS IF DROPDOWN FIELD
						
						
						
						
						
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A DEPENDENT FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'dependent') {
							
							//// CHECKS TO SEE IF THE PARENT IS A CATEGORY AND IF THE PARENT IS SET (IN CASE THE DROPDOWN HA BEEN CHANGED)
							if(get_post_meta(get_post_meta($field->ID, 'dependent_parent', true), 'dropdown_type', true) == 'categories') {
								
								//// LETS TRY AND GET THIS TERM BY SLUG
								//// USED TO BE THIS FOR SOME REASON -----	if($term = get_term_by('slug', $_field, 'spot_cats') && $fields['has_changed_'.$_key] == 'true') {
								if($term = get_term_by('slug', $_field, 'spot_cats')) {
									
									//// ADDS OUR TAX QUERY
									$args['tax_query'][] = array(
										
										'taxonomy' => 'spot_cats',
										'field' => 'slug',
										'terms' => $_field,
									
									);
										
									//// ADDS TO OUR LISTING URL AS A PARAM
									$get_url[$_key] = $_field;
									
								}
								
							} else {
							
								$pass_radius_query = true;
								$dependent_fields = json_decode(htmlspecialchars_decode(get_post_meta($field->ID, 'dependent_values', true)));
								
								//// LET'S CHECK IS THIS SELECTED FIELD HAS A RADIUS - INDEPENDENT OF WHETHER OR NOT WE'VE CHANGED IT
								if(get_post_meta($field->ID, 'dependent_change_location', true) == 'on') { foreach($dependent_fields as $parent_section) { foreach($parent_section as $dependent_field) { if($dependent_field->id == $_field) { if($dependent_field->latitude != '' && $dependent_field->longitude != '') { if(isset($dependent_field->radius)) { if($dependent_field->radius != '' & is_numeric($dependent_field->radius)) { $pass_radius_query = false; } } } } } } }
								
								//// WHETHER WE ARE ACTUALLY LOOKING FOR A FIELD OR IF IT'S ANY
								if($_field != '' && $_field != '-' && $_field != '0') {
									
									//// IF IT'S SUPPOSED TO CHANGE LOCATION - ALSO CHECKS TO SEE IF USER HAS
									//// CHANGES THE FIELD OR IF HE CHANGED SOMETHING ELSE
									if(get_post_meta($field->ID, 'dependent_change_location', true) == 'on' && $fields['has_changed_'.$_key] == 'true') {
									
										//// GETS THE SELECTED FIELD FOR LATITUDE AND LONGITUDE
										foreach($dependent_fields as $parent_section) {
											
											foreach($parent_section as $dependent_field) {
											
												//// IF IT'S THE FIELD WE AR ELOOKING FOR
												if($dependent_field->id == $_field) {
													
													/// IF LATITUDE AND LONGITUDE ARE SET
													if($dependent_field->latitude != '' && $dependent_field->longitude != '') {
														
														/// CHECK IF WE ARE USING A RADIUS AND IF THE USER HAS EXPANDED THE RADIUS SECTION
														$pass_radius_check = true; $pass_radius_query = true;
														if(isset($dependent_field->radius)) { if($dependent_field->radius != '' & is_numeric($dependent_field->radius)) { $pass_radius_query = false; } }
														
														//// CHECK IF THERE IS NO RADIUS JSUT SO WE CAN DESTROY IT
														if(isset($dependent_field->radius)) { if($dependent_field->radius == '' || !is_numeric($dependent_field->radius)) { $return['destroy_radius'] = true; } }
														else { $return['destroy_radius'] = true; }
														
														/// IF THE USER HAS NOT MESSED WITH THE RADIUS YET, LETS MOVE THE MAP AND SET THE INITIAL RADIUS IF BEING USED
														if($pass_radius_check) {
														
															$return['change_location'] = true;
															$return['change_location_lat'] = $dependent_field->latitude;
															$return['change_location_lng'] = $dependent_field->longitude;
														
															//// CHECKS FOR ZOOM
															if($dependent_field->zoom != '' && is_numeric($dependent_field->zoom)) { if($dependent_field->zoom >= 1 && $dependent_field->zoom <= 20) { $return['change_zoom'] = $dependent_field->zoom; } }
															
															if(isset($dependent_field->radius)) { if($dependent_field->radius != '' & is_numeric($dependent_field->radius)) {
																
																//// MAKES SURE WE SAY WHETHER WE'RE TALKING ABOUT MILES OR KILOMETRES AS WELL
																$return['radius_lat'] = $dependent_field->latitude;
																$return['radius_lng'] = $dependent_field->longitude;
																$return['change_radius'] = $dependent_field->radius;
																if(isset($force_radius)) { if(is_numeric($force_radius)) { $return['change_radius'] = $force_radius; } }
																$return['distance_type'] = ddp('geo_distance_type');
																$return['radius_field_id'] = $field->ID;
																$return['radius_field_val'] = $dependent_field->id;
																
																//// NO WE ALSO NEED TO SET A FORCE_USE RADIUS VARIABLE FOR LATER ON
																$force_radius = true;
																
																//// LETS GET THE MINIMUM AND MAXIMUM VALUE LATITUDE AND LONGITUDE BASED ON THE CENTER AND KILOMETER SO WE CAN ROUND OUT THE RESULTS
																$force_values = _sf_get_min_max_lat_lng($return['change_radius'], $dependent_field->latitude, $dependent_field->longitude);
																
															} }
															
														}
														
													}
												
												}
											
											}
											
										}
										
									}//// ENDS IF IT'S SUPPOSED TO CHANGE LOCATION
									
									
									///// BUILD OUR QUERY
									//// IF WE DONT HAVE A RADIUS
									if($pass_radius_query) {
										
										$args['meta_query'][] = array(
										
											'key' => '_sf_field_'.$field->ID,
											'value' => $_field,
											'compare' => 'LIKE',
										
										);
									
									} else {
										
										/// WE NEED TO MAKE SURE WE UNSET OUR PARENT AS WELL
										$unset_parent_location_field = '_sf_field_'.get_post_meta($field->ID, 'dependent_parent', true);
										
									}
										
									//// ADDS TO OUR LISTING URL AS A PARAM
									$get_url[$_key] = $_field;
									
									
								}/// ENDS IF WE ARE ACTUALLY LOOKING FOR A DROPDOWN
							
							}
							
						} //// ENDS IF DEPENDENT FIELD
						
						
						
						
						
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A MIN_VAL FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'min_val') {
							
							//// IF IS NOT EQUALS 0
							if($_field != '' && $_field != 0) {
							
							
								///// BUILDS OUR QUERY
								$args['meta_query'][] = array(
								
									'key' => '_sf_field_'.$field->ID,
									'value' => $_field,
									'compare' => '>=',
									'type' => 'NUMERIC',
								
								);
									
								//// ADDS TO OUR LISTING URL AS A PARAM
								$get_url[$_key] = $_field;
							
							}
							
						} //// ENDS IF MIN VAL FIELD
						
						
						
						
						
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A MAX_VAL FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'max_val') {
							
							//// IF IS NOT EQUALS 0
							if($_field != '' && $_field != 0) {
							
								///// BUILDS OUR QUERY
								$args['meta_query'][] = array(
								
									'key' => '_sf_field_'.$field->ID,
									'value' => $_field,
									'compare' => '<',
									'type' => 'NUMERIC',
								
								);
									
								//// ADDS TO OUR LISTING URL AS A PARAM
								$get_url[$_key] = $_field;
							
							}
							
						} //// ENDS IF MAX VAL FIELD
						
						
						
						
						
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A RANGE FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'range') {
							
							//// GETS MINIMUM AND MAXIMUM
							$min = $fields[$_key.'_min'];
							$max = $fields[$_key.'_max'];
							
							//// BUILDS OUR QUERY
							$args['meta_query'][] = array(
							
								'key' => '_sf_field_'.$field->ID,
								'value' => array($min, $max),
								'compare' => 'BETWEEN',
								'type' => 'NUMERIC',
							
							);
									
								//// ADDS TO OUR LISTING URL AS A PARAM
								$get_url[$_key] = 'true';
								$get_url[$_key.'_min'] = $min;
								$get_url[$_key.'_max'] = $max;
							
						} //// ENDS IF RANGE FIELD
						
						
						
						
						
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A RATING FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'rating' && ddp('rating') == 'on') {
							
							//// GETS MINIMUM AND MAXIMUM
							$min = $fields[$_key.'_min'];
							$max = $fields[$_key.'_max'];
							
							//// WE CAN'T USE BETWEEN BECAUSE WE ARE DEALING WITH FLOATED NUMBER
							
							//// BUILDS OUR QUERY
							$args['meta_query'][] = array(
							
								'key' => 'rating',
								'value' => $max,
								'compare' => '<=',
							
							);
							
							//// IF MINIMUM IS MORE THAN 1
							if($min > 1) {
							
								//// BUILDS OUR QUERY
								$args['meta_query'][] = array(
								
									'key' => 'rating',
									'value' => $min,
									'compare' => '>=',
								
								);
							
							}
									
							//// ADDS TO OUR LISTING URL AS A PARAM
							$get_url[$_key.'_min'] = $min;
							$get_url[$_key.'_max'] = $max;
							$get_url[$_key] = 'true';
							
						} //// ENDS IF RANGE FIELD
						
						
						
						
						
						/////////////////////////////////////////////////////////////////
						///// IF IT'S A CHECK FIELD
						/////////////////////////////////////////////////////////////////
						
						if($field_type == 'check') {
							
							//// IF FIELD IS ON
							if($_field == 'on') {
							
								//// BUILDS OUR QUERY
								$args['meta_query'][] = array(
								
									'key' => '_sf_field_'.$field->ID,
									'value' => 'on',
								
								);
								$get_url[$_key] = 'true';
								
							}
							
						} //// ENDS IF MIN VAL FIELD
						
					}
					
					
					
					
					
				} //// IF THE FIELD ACTUALLY EXISTS
				
				
				
			} //// ENDS THE FOREACH OF EACH FIELD;
			
			
			/////////////////////////////////////////////////////////////////
			//// IN CASE WE HAVE A RADIUS TO DEAL WITH FIRST - OR IF WE ARE FORCING RADIUS AND MAKE SURE WE HAVE SOMETHING SELECTED ON OUR DAIUS
			/////////////////////////////////////////////////////////////////
			if(($fields['_sf_enable_radius_search'] == 'true' || $force_radius) && !$return['destroy_radius']) {
															
															
				
				//// MAKES SURE OUR SELECT FIELD STILL HAS SOMETHING SELECTED
				if($fields['_sf_field_'.$fields['_sf_radius_field']] != 0 || $fields['_sf_field_'.$fields['_sf_radius_field']] != '') {
					
					$return['destroy_radius'] = true;
					
				} else {
					//// GETS ALL LATITUDE FROM AND TO
					$lat_1 = floatval($fields['_sf_radius_lat_from']);
					$lat_2 = floatval($fields['_sf_radius_lat_to']);
					$lng_1 = floatval($fields['_sf_radius_lng_from']);
					$lng_2 = floatval($fields['_sf_radius_lng_to']);
					$distance = floatval($fields['_sf_radius_distance']);
					$lat_center = floatval($fields['_sf_radius_center_lat']);
					$lng_center = floatval($fields['_sf_radius_center_lng']);
					
					//// CHECKS FOR FORCE LATITUDE AND LONGITUDE
					if(isset($force_values['lat1'])) { $lat_1 = floatval($force_values['lat1']); }
					if(isset($force_values['lat2'])) { $lat_2 = floatval($force_values['lat2']); }
					if(isset($force_values['lng1'])) { $lng_1 = floatval($force_values['lng1']); }
					if(isset($force_values['lng2'])) { $lng_2 = floatval($force_values['lng2']); }
					if(isset($force_values['center_lat'])) { $lat_center = floatval($force_values['center_lat']); }
					if(isset($force_values['center_lng'])) { $lng_center = floatval($force_values['center_lng']); }
					if(isset($force_values['distance'])) { $distance = floatval($force_values['distance']); }
					
					//// MAKES SURE THOSE ARE VALID LATITUDES AND LONGITUDES
					if(($lat_1 != '' && $lat_2 != '' && $lng_1 != '' && $lng_2 != '')
					&& ($lat_1 >= -90 &&  $lat_1 <= 90)
					&& ($lat_2 >= -90 &&  $lat_2 <= 90)
					&& ($lat_center >= -90 &&  $lat_center <= 90)
					&& ($lng_1 >= -180 && $lng_1 <= 180)
					&& ($lng_2 >= -180 && $lng_2 <= 180)
					&& ($lng_center >= -180 && $lng_center <= 180)
					&& ($distance != '' && is_numeric($distance))) {
						
						//// NOW WE DO A CUSTOM QUERY THAT RETURNS ALL OUR POST IDS WITHIN THIS LATITUDE AND LONGITUDE RANGE
						global $wpdb;
						
						$query_string = "
						
						SELECT
							{$wpdb->prefix}posts.ID,
							latitude.meta_value as latitude,
							longitude.meta_value as longitude,
							6371 * acos( cos( radians({$lat_center}) ) * cos( radians( latitude.meta_value ) ) * cos( radians ( longitude.meta_value ) - radians({$lng_center}) ) + sin( radians({$lat_center}) ) * sin( radians ( latitude.meta_value ) ) )  as 'distance'
						
						FROM 
							{$wpdb->prefix}postmeta as latitude,
							{$wpdb->prefix}postmeta as longitude,
							{$wpdb->prefix}posts
							
						WHERE (
							{$wpdb->prefix}posts.ID = latitude.post_id
							AND latitude.meta_key = 'latitude'
						)
							
						AND (
							{$wpdb->prefix}posts.ID = longitude.post_id
							AND longitude.meta_key = 'longitude'
						)
						
						AND latitude.meta_value > {$lat_1}
						AND latitude.meta_value < {$lat_2}
						
						AND longitude.meta_value > {$lng_1}
						AND longitude.meta_value < {$lng_2}
						
						AND {$wpdb->prefix}posts.post_status = 'publish'
						AND {$wpdb->prefix}posts.post_type = 'spot'
						
						HAVING distance < {$distance}
						
						";
						
						$results = $wpdb->get_results($query_string);
						
						$return['custom_query'] = $query_string;
						$return['custom_query_results'] = $results;
						
						//// WE DO A FOREACH AND PUT THEM IN A POST__IN OFOUR ARGS
						$post__in = array(0);
						foreach($results as $single_result) {
							
							$post__in[] = $single_result->ID;
							
						}
						
						///// ADDS THE PSOT IN TO OUR QUERY
						$args['post__in'] = $post__in;
															
						//// ADDS RADIUS TO OUR URL
						$get_url['radius'] = $distance;
						
						//// LETS ALSO MAKE SURE WE TAKE OUR
						
					}
				
				}
				
			} else if($fields['_sf_enable_radius_search']) {
				
				$return['destroy_radius'] = true;
				
			}
			
			//// AMKE SURE WE UNSET ANY NECESSARY PARENTS FOR THE RADIUS
			if(isset($unset_parent_location_field)) {
				//// GOES THROUGH OUR METAQUERIES
				$i = 0;
				foreach($args['meta_query'] as $meta) {
					
					//// IF THIS META MATCHES OUR PARENT
					if($meta['key'] == $unset_parent_location_field) { unset($args['meta_query'][$i]); }
					
					$i++;
					
				}
				
			}
			
			
			/////////////////////////////////////////////////////////////////
			//// ACTUALLY DOES THE QUERY
			/////////////////////////////////////////////////////////////////
			
			$sQ = new WP_Query($args);
			
			//// STARTS OUR POST ARRAY - EVERY FOUND POST IS INSERTED IN HERE IN ORDER TO ADD THE PINS
			$return['posts'] = array();
			$return['post_ids'] = array();
			
			/// LOOPS POSTS
			if($sQ->have_posts()) { while($sQ->have_posts()) { $sQ->the_post();
			
				///// GETS REQUIRED FIELDS TO INSERT IN THE ARRAY
				$latitude = get_spot_latitude(get_the_ID());
				$longitude = get_spot_longitude(get_the_ID());
				$pin = get_spot_pin(get_the_ID());
				
				$featured = 'false';
				$thumb = '';
				
				//// IF FEATURED OVERLAYS ARE SET
				if(ddp('map_featured_overlay') == 'on') {
					
					//// IF THIS IS FEATURED
					if(get_post_meta(get_the_ID(), 'featured', true) == 'on') { $featured = 'true'; }
					$thumb = ddTimthumb(btoa_get_featured_image(get_the_ID()), 150, 150);
					
				}
				
				//// ONLY ADDS TO THE ARRAY IN CASE WE HAVE A LATITUDE AND LONGITUDE
				if($latitude != '' && $longitude != '') {
				
					$return['posts'][] = array(
						
						'title' => get_the_title(),
						'id' => get_the_ID(),
						'latitude' => $latitude,
						'longitude' => $longitude,
						'pin' => $pin,
						'permalink' => get_permalink(),
						'featured' => $featured,
						'thumb' => $thumb,
						
					);
					
					$return['post_ids'][] = get_the_ID();
				
				} else {
					
					$return['posts'][] = array(
						
						'title' => get_the_title(),
						'error' => 'NO LATITUDE OR LONGITUDE'
						
					);
					
				}//// ENDS IF POST HAS LATITUDE AND LONGITUDE
				
			} }
			
			//// SENDS THE NUMBER OF PROPERTIE SFOUND
			$return['found'] = $sQ->found_posts;
			if($sQ->found_posts == 0) {
				
				//// IFUSER CAN SIGN UP FOR HIS NEWSLETTER
				if(ddp('future_notification') == 'on')  {
					
					$return['message'] = __('Oops! We couldn\'t find any results.', 'btoa').'<br><a href="#" class="notify-me">'.__('Notify me of future matching submissions', 'btoa').'</a>';
					
				} else {
					
					$return['message'] = __('Oops! We couldn\'t find any results.', 'btoa');
					
				}
				
			}
		
			/// SLIDER BAR COUNT
			if($sQ->found_posts > 1) { $return['slider_bar_count'] = str_replace('%count%', $sQ->found_posts, __('We found<strong> %count%</strong> listings matching your criteria <a href="#" onclick="jQuery(\'#slider-map\').fitMapToBounds(event);">Show me all &rarr;</a>', 'btoa')); }
			elseif($sQ->found_posts == 1) { $return['slider_bar_count'] = __('We found <strong>1</strong> listing matching your criteria <a href="#" onclick="jQuery(\'#slider-map\').fitMapToBounds(event);">Show me all &rarr;</a>', 'btoa'); }
			else { $return['slider_bar_count'] = __('Oops, we could not find any matching listings.', 'btoa'); }
			
			//// OUR LISTINGS URL
			if(isset($fields['_sf_listings_page_url'])) {
				
				$listing_url = $fields['_sf_listings_page_url'];
				
			} else {
			
				//// GETS THE LISTING URL
				if(ddp('listing_page') == '') {
					
					//// GETS PAGE BY TEMPLATE
					$pages = get_pages(array(
						'meta_key' => '_wp_page_template',
						'meta_value' => 'listings.php',
						'hierarchical' => 0
					));
					foreach($pages as $page) {
						
						$listing_url = get_permalink($page->ID);
						
					}
					if(count($pages) == 0) { $listing_url = home_url(); }
					
					$page_id = $page->ID;
					
				} else {
					
					$page_id = ddp('listing_page');
					$listing_url = get_permalink($page_id);
					
				}
						
				///// IF WE ARE RUNNING WPML, TRIES AND GET THE TRANSLATION OF THIS PAGE
				if(isset($sitepress)) {
					
					$translation_page = icl_object_id($page_id, 'page', true, ICL_LANGUAGE_CODE);
					
					if(is_numeric($translation_page)) {
						
						$listing_url = get_permalink($translation_page);
						
					}
					
				}
				
			}
			
			$return['list_url'] = add_query_arg($get_url, $listing_url);
			
		} else { $return['error'] = false; $return['message'] = __('Form data is empty.', 'btoa'); }
		
		
		$return['data'] = $fields;
		$return['ids'] = $post_ids;
		$return['query'] = $args;
		
		/// RETURNS DATA
		echo json_encode($return);
		
		exit;
		
	}
	
	function _sf_get_min_max_lat_lng($distance, $lat, $lng) {
															
		$force_center_lat = $lat;
		$force_center_lng = $lng;
		$force_distance = $distance;
		
		$return = array();
		
		$factorRad = 3.141592653 / 180;
		$distanceRad = $force_distance / 6371;
		if(ddp('geo_distance_type') == 'Miles') { $distanceRad = ($force_distance * 1.60934) / 6371; }
		$latRad = $force_center_lat * $factorRad;
		$lngRad = $force_center_lng * $factorRad;
		
		$force_lat_1_rad = asin(sin($latRad) * cos($distanceRad) + cos($latRad) * sin($distanceRad) * cos(180 * $factorRad));
		$force_lat_2_rad = asin(sin($latRad) * cos($distanceRad) + cos($latRad) * sin($distanceRad) * cos(0 * $factorRad));
		$force_lng_1_rad = ($lngRad + atan2(sin(270 * $factorRad) * sin($distanceRad) * cos($latRad), cos($distanceRad) - sin($latRad) * sin($force_lat_1_rad)));
		$force_lng_2_rad = ($lngRad + atan2(sin(90 * $factorRad) * sin($distanceRad) * cos($latRad), cos($distanceRad) - sin($latRad) * sin($force_lat_2_rad)));
		
		$return['lat1'] = $force_lat_1_rad / $factorRad;
		$return['lat2'] = $force_lat_2_rad / $factorRad;
		$return['lng1'] = $force_lng_1_rad / $factorRad;
		$return['lng2'] = $force_lng_2_rad / $factorRad;
		$return['center_lat'] = $lat;
		$return['center_lng'] = $lng;
		$return['distance'] = $distance;
		
		return $return;
		
	}
	
	
	add_filter('get_meta_sql','cast_decimal_precision');

	function cast_decimal_precision( $array ) {
	
		$array['where'] = str_replace('DECIMAL','DECIMAL(10,3)',$array['where']);
	
		return $array;
	}


?>