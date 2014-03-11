<?php

	
	//////////////////////////////////
	//// ADDS OUR POST TYPE
	//////////////////////////////////
	include('post_type.php');

	
	//////////////////////////////////
	//// ADDS OUR TAXONOMY
	//////////////////////////////////
	include('taxonomy.php');
	
	
	
	//////////////////////////////////
	//// ADDS OUR METABOXES
	//////////////////////////////////
	include('metaboxes.php');
	
	
	
	//////////////////////////////////
	//// AJAX METHODS
	//////////////////////////////////
	include('ajax.php');
	
	
	
	////////////////////////////////////////
	//// RETURNS THE RATING HTML WITH STARS
	////////////////////////////////////////
	
	function sf_get_rating_html($rating, $show_empty = true) {
		
		//// IN CASE ITS NOT BETWEEN 1 AND 5
		if(!is_numeric($rating)) { return false; }
		if($rating < 1 || $rating > 5) { return false; }
		
		//// RETURNS THE HTML
		//// IF 1 STAR
		if(round($rating, 2) >= 1 && round($rating, 2) <= 1.25) {
			
			$markup = '<i class="icon-star"></i>';
			if($show_empty) { $markup .= '<i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i>'; }
			return $markup;
			
		}
		
		//// IF 1.5 STAR
		if(round($rating, 2) > 1.25 && round($rating, 2) <= 1.75) {
			
			return '<i class="icon-star"></i><i class="icon-star-half-alt"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i>';
			
		}
		
		//// IF 2 STARS
		if(round($rating, 2) > 1.75 && round($rating, 2) <= 2.25) {
			
			$markup = '<i class="icon-star"></i><i class="icon-star"></i>';
			if($show_empty) { $markup .= '<i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i>'; }
			return $markup;
			
		}
		
		//// IF 2.5 STARS
		if(round($rating, 2) > 2.25 && round($rating, 2) <= 2.75) {
			
			return '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-half-alt"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i>';
			
		}
		
		//// IF 3 STARS
		if(round($rating, 2) > 2.75 && round($rating, 2) <= 3.25) {
			
			$markup = '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
			if($show_empty) { $markup .= '<i class="icon-star-empty"></i><i class="icon-star-empty"></i>'; }
			return $markup;
			
		}
		
		//// IF 3.5 STARS
		if(round($rating, 2) > 3.25 && round($rating, 2) <= 3.75) {
			
			return '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-half-alt"></i><i class="icon-star-empty"></i>';
			
		}
		
		//// IF 4 STARS
		if(round($rating, 2) > 3.75 && round($rating, 2) <= 4.25) {
			
			$markup = '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
			if($show_empty) { $markup .= '<i class="icon-star-empty"></i>'; }
			return $markup;
			
		}
		
		//// IF 4.5 STARS
		if(round($rating, 2) > 4.25 && round($rating, 2) <= 4.75) {
			
			return '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-half-alt"></i>';
			
		}
		
		//// IF 5 STARS
		if(round($rating, 2) > 4.75 && round($rating, 2) <= 5) {
			
			return '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
			
		}
		
	}
	
	
	
	
	////////////////////////////////////////////////////////////
	//// UPDATES THE POST PARENT WHEN WE SAVE A RATING
	////////////////////////////////////////////////////////////
	
	add_action('save_post', 'sf_update_post_parent_review', 10, 1);
	
	function sf_update_post_parent_review($post_id) {
		
		if(!$review = get_post($post_id)) { return $post_id; }
		
		//// MAKES SURE WE ARE SAVING A RATING
		if($review->post_type == 'rating') {
			
			//// MAKES SURE WE ARE PUBLISHING THIS LISTING
			if($review->post_status == 'publish') {
				
				//// GETS THE PARENT POST
				if($post = get_post(get_post_meta($post_id, 'parent', true))) {
					
					//// IF ITS A SPOT
					if($post->post_type == 'spot') {
						
						$the_rating = get_post_meta($post_id, 'rating', true);
						
						//// LETS GET ALL THE RATINGS FROM THIS POST AND REFRESH IT
						$rating = 0; $rating_count = 0;
						$args = array(
						
							'post_type' => 'rating',
							'posts_per_page' => -1,
							'meta_query' => array(
							
								array(
								
									'key' => 'parent',
									'value' => $post->ID,
									'compare' => '=',
								
								)
							
							),
							'post__not_in' => array($post_id),
						
						);
					
						//// IF WPML
						global $sitepress;
						if(isset($sitepress)) { $args['suppress_filters'] = TRUE; }
						
						$rQ = new WP_Query($args);
						
						if($rQ->have_posts()) { while($rQ->have_posts()) { $rQ->the_post(); $rating = $rating + get_post_meta(get_the_ID(), 'rating', true); $rating_count++; } }
						
						$rating = $rating + $the_rating; $rating_count++;
						
						$rating = round($rating / $rating_count, 2);
						
						///// UPDATES THE POST
						update_post_meta($post->ID, 'rating', $rating);
						update_post_meta($post->ID, 'rating_count', $rating_count);
					
						//// UPDATES TRANSLATIONS AS WELL
						if(isset($sitepress)) {
							
							_sf_wpml_update_translations_ratings($post->ID);
							
						}
						
					}
					
				}
				
			}
			
		}
		
		return $post_id;
		
	}
	
	
	
	
	////////////////////////////////////////////////////////////
	//// UPDATES THE POST PARENT WHEN WE PUBLISH A RATING
	////////////////////////////////////////////////////////////
	
	add_action('transition_post_status', 'sf_update_post_parent_review_publish', 10, 3);
	
	function sf_update_post_parent_review_publish($new_status, $old_status, $post) {
		
		//// MAKES SURE WE ARE PUBLISHING A REVIEW
		if($new_status == 'publish' && $old_status != 'publish') {
			
			//// MAKES SURE WE ARE SAVING A RATING
			if($post->post_type == 'rating') {
				
				//// MAKES SURE WE ARE PUBLISHING THIS LISTING
				if($post->post_status == 'publish') {
					
					//// GETS THE PARENT POST
					if($parent_post = get_post(get_post_meta($post->ID, 'parent', true))) {
						
						//// IF ITS A SPOT
						if($parent_post->post_type == 'spot') {
						
							$the_rating = get_post_meta($post_id, 'rating', true);
							
							//// LETS GET ALL THE RATINGS FROM THIS POST AND REFRESH IT
							$rating = 0; $rating_count = 0;
							$args = array(
							
								'post_type' => 'rating',
								'posts_per_page' => -1,
								'meta_query' => array(
								
									array(
									
										'key' => 'parent',
										'value' => $post->ID,
										'compare' => '=',
									
									)
								
								),
								'post__not_in' => array($post_id),
							
							);
					
							//// IF WPML
							global $sitepress;
							if(isset($sitepress)) { $args['suppress_filters'] = TRUE; }
							
							$rQ = new WP_Query($args);
							
							if($rQ->have_posts()) { while($rQ->have_posts()) { $rQ->the_post(); $rating = $rating + get_post_meta(get_the_ID(), 'rating', true); $rating_count++; } }
							
							$rating = $rating + $the_rating; $rating_count++;
							
							$rating = round($rating / $rating_count, 2);
							
							///// UPDATES THE POST
							update_post_meta($parent_post->ID, 'rating', $rating);
							update_post_meta($parent_post->ID, 'rating_count', $rating_count);
					
							//// UPDATES TRANSLATIONS AS WELL
							if(isset($sitepress)) {
								
								_sf_wpml_update_translations_ratings($parent_post->ID);
								
							}
							
							//$the_rating = get_post_meta($post->ID, 'rating', true);
//			
//							//// NOW LET'S GET THE CURRENT RATING OF OUR POST AND THE AMOUNT OF RATINGS IT HAS
//							$current_rating = get_post_meta($parent_post->ID, 'rating', true);
//							if($current_rating == '') { $current_rating = 0; }
//							$rating_count = get_post_meta($parent_post->ID, 'rating_count', true);
//							if($rating_count == '') { $rating_count = 0; }
//			
//							//// DOES THE NEW RATING
//							$new_post_rating = round((($current_rating * $rating_count) + $rating) / ($rating_count + 1), 2);
//				
//							///// NOW WE UPDATE OUR PARENT POST
//							update_post_meta($parent_post->ID, 'rating', $new_post_rating);
//							update_post_meta($parent_post->ID, 'rating_count', ($rating_count + 1));
							
						}
						
					}
					
				}
				
			}
			
		}
		
	}
	
	
	
	
	////////////////////////////////////////////////////////////
	//// WHEN WE DELETE A POST
	////////////////////////////////////////////////////////////
	
	add_action('trashed_post', 'sf_update_post_parent_review_trash', 10, 1);
	add_action('before_delete_post', 'sf_update_post_parent_review_trash', 10, 1);
	
	function sf_update_post_parent_review_trash($post_id) {
		
		$post = get_post($post_id);
		
		//// MAKES SURE WE ARE SAVING A RATING
		if($post->post_type == 'rating') {
				
			//// GETS THE PARENT POST
			if($parent_post = get_post(get_post_meta($post->ID, 'parent', true))) {
				
				//// IF ITS A SPOT
				if($parent_post->post_type == 'spot') { 
				
					$the_rating = get_post_meta($post->ID, 'rating', true);
					
					//// LETS GET ALL THE RATINGS FROM THIS POST AND REFRESH IT
					$rating = 0; $rating_count = 0;
					$args = array(
					
						'post_type' => 'rating',
						'posts_per_page' => -1,
						'meta_query' => array(
						
							array(
							
								'key' => 'parent',
								'value' => $parent_post->ID,
								'compare' => '=',
							
							)
						
						),
						'post__not_in' => array($post->ID),
					
					);
					
					//// IF WPML
					global $sitepress;
					if(isset($sitepress)) { $args['suppress_filters'] = TRUE; }
					
					$rQ = new WP_Query($args);
					
					if($rQ->have_posts()) { while($rQ->have_posts()) { $rQ->the_post(); $rating = $rating + get_post_meta(get_the_ID(), 'rating', true); $rating_count++; } }
					
					if($rating != 0 && $rating_count != 0) { $rating = round($rating / $rating_count, 2); }
					
					///// UPDATES THE POST
					update_post_meta($parent_post->ID, 'rating', $rating);
					update_post_meta($parent_post->ID, 'rating_count', $rating_count);
					
					//// UPDATES TRANSLATIONS AS WELL
					if(isset($sitepress)) {
						
						_sf_wpml_update_translations_ratings($parent_post->ID);
						
					}
					
				}
				
			}
			
		}
		
	}
	
	
	
	////////////////////////////////////////////////////////////
	//// ADDS THE PARENT LISTINGS COLUMN
	////////////////////////////////////////////////////////////
	
	//// ADDS COLUMN
	function sf_rating_columns_head($defaults) { 
	 
		$defaults['rating_parent'] = __('Parent ', 'btoa').ddp('spot_name');  
		return $defaults;  
	} 
	
	//// THE COLUMN CONTENT
	function sf_rating_columns_content($column_name, $post_ID) {
		
		echo '<a href="'.get_edit_post_link(get_post_meta($post_ID, 'parent', true)).'">'.get_the_title(get_post_meta($post_ID, 'parent', true)).'</a>';
		
	}
	
	//// REGISTER OUR STYLES ON FEATURED IMAGE COLUMN AND PUTS IN OUR ADMIN PAGE
	function sf_rating_style_register() {
		wp_register_style('FeaturedImageColumnStyle', get_template_directory_uri().'/includes/backend/css/featuredImageColumn.css');
		wp_enqueue_style('FeaturedImageColumnStyle');
	}
	
	///// BLOG POSTS AND SPOTS ONLY
	
	//// ADDS OUR HEAD
	add_filter('manage_rating_posts_columns', 'sf_rating_columns_head');  
	//// ADDS THE FEATURED IMAGE TO THE CONTENT
	add_action('manage_rating_posts_custom_column', 'sf_rating_columns_content', 10, 2);
	//// ADDS STYLE IN OUR HEAD SO THE FEATURED IMAGE COLUMN LOOKS IN PLACE
	add_action('admin_init', 'sf_rating_style_register');
	
	
	
	////////////////////////////////////////////////////////////
	//// UPDATES RATING VALUES ACROSS ALL TRANSLATIONS
	////////////////////////////////////////////////////////////
	
	function _sf_wpml_update_translations_ratings($post_id) {
		
		///// FIRST LETS MAKE SURE SITEPRESS IS SET
		global $sitepress;
		if(isset($sitepress)) {
			
			//// LETS GET THE MASTER ID
			if($post = get_post($post_id)) {
				
				$master_post = icl_object_id($post_id, 'spot', false, $sitepress->get_default_language());
				$rating = get_post_meta($master_post, 'rating', true);
				$rating_count = get_post_meta($master_post, 'rating_count', true);
				
				//// NOW LETS GO LANGUAGE BY LANGUAGE AND UPDATE THE POST
				$all_langs = $sitepress->get_active_languages();
				
				foreach($all_langs as $lang => $description) {
					
					$translated_post = icl_object_id($post_id, 'spot', false, $lang);
					
					///// UPDATES THIS
					update_post_meta($translated_post, 'rating', $rating);
					update_post_meta($translated_post, 'rating_count', $rating_count);
					
				}
				
			}
			
		}
		
	}
	

?>