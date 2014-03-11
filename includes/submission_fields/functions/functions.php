<?php

	
	//////////////////////////////////
	//// ADDS OUR POST TYPE
	//////////////////////////////////
	include('post_type.php');
	
	
	
	//////////////////////////////////
	//// ADDS OUR METABOXES
	//////////////////////////////////
	include('metaboxes.php');
	
	
	
	//////////////////////////////////
	//// AJAX METHODS
	//////////////////////////////////
	include('ajax.php');
	
	
	
	
	//////////////////////////////////
	//// RETURNS AN ARRAY OF SECTIONS
	//// TO CREATE ACTIONS AT
	//////////////////////////////////
	
	function _sf_get_submission_field_actions() {
		
		$actions = array();
		
		$args = array(
				
			'post_type' => 'submission_field',
			'posts_per_page' => -1,
			'post_status' => 'publish',
		
		);
		
		$sfQ = new WP_Query($args);
		
		if($sfQ->have_posts()) {
			
			while($sfQ->have_posts()) {
				
				$sfQ->the_post();
				
				$actions[] = array(
				
					'position' => get_post_meta(get_the_ID(), 'position', true),
					'ID' => get_the_ID(),
					'type' => get_post_meta(get_the_ID(), 'field_type', true),
					
				);
				
			} wp_reset_postdata();
			
		} /// ENDS IF HAVE POSTS
		
		return $actions;
		
	}
	
	
	
	//////////////////////////////////
	//// CREATES ACTIONS FOR OUR
	//// FIELDS
	//////////////////////////////////
	
	function sf_create_public_submission_action($action, $field_arr, $spot_id) {
		
		//// LETS GO FIELD BY FIELD AND SEE IF ANY OF THEM ARE IN THIS ACTION
		foreach($field_arr as $field) {
			
			//// IF ITS IN THIS ACTION
			if($field['position'] == $action) {
				
				///// LETS CALL A DO ACTION
				do_action('_sf_submission_field_'.$field['ID'], $field['ID'], $field['position'], $spot_id);
				
			}
			
		}
		
	}
	
	
	//////////////////////////////////
	//// CALLS OUR ACTIONS BY FIELD
	//////////////////////////////////
	add_action('template_redirect', '_sf_custom_submission_fields_init', 10);
	
	function _sf_custom_submission_fields_init() {
		
		///// IF WE ARE IN A SUBMISSION FORM
		if(is_page_template('login.php')) {
			
			/// CHECK IF WE ARE EITING OR ADDING A NEW PAGE
			if($_GET['action'] == 'add-new' || $_GET['action'] == 'edit') {
				
				///// LETS LOOP OUR CUSTOM SUBMISSION FIELDS AND THEN ADD THEM AS ACTIONS
				$args = array(
				
					'post_type' => 'submission_field',
					'posts_per_page' => -1,
					'post_status' => 'publish',
				
				);
				
				$sfQ = new WP_Query($args);
				
				if($sfQ->have_posts()) {
					
					while($sfQ->have_posts()) {
						
						$sfQ->the_post();
						
						///// NOW WE NEED TO GET WHERE TO DISPLAY IT AND ADD AS AN ACTION
						$the_action = get_post_meta(get_the_ID(), 'position', true);
						$type = get_post_meta(get_the_ID(), 'field_type', true);
						
						//// IF ITS A TEXT FIELD
						if($type == 'text') { add_action('_sf_submission_field_'.get_the_ID(), '_sf_custom_submission_field_text', 10, 3); }
						
						//// IF ITS A SELECT FIELD
						if($type == 'dropdown') { add_action('_sf_submission_field_'.get_the_ID(), '_sf_custom_submission_field_select', 10, 3); }
						
						//// IF ITS A FILE UPLOAD
						if($type == 'file') { add_action('_sf_submission_field_'.get_the_ID(), '_sf_custom_submission_field_file', 10, 3); }
						
					} wp_reset_postdata();
					
				} /// ENDS IF HAVE POSTS
				
			}
			
		}
		
	}
	
	
	
	//////////////////////////////////
	//// OUR TEXT FIELD MARKUP
	//////////////////////////////////
	
	function _sf_custom_submission_field_text($field_id, $position, $spot_id) {
		
		//// LETS CHECK IF WE ARE EDITING THE SAME LANGUAGE
				
		///// CHECKS FOR WPML
		global $sitepress;
		if(isset($sitepress)) {
			
			global $wpdb;
			
			//// GETS SPOT LANGUAGE
			$spot_language = wpml_get_language_information($spot_id);
			$query = $wpdb->get_row('SELECT code FROM ' . $wpdb->prefix . 'icl_languages WHERE default_locale="'.$spot_language['locale'].'"');
			$spot_language = $query->code;
			
			//// IF THE CURRENT LANGUAGE IS NOT THE DEFAULT ONE
			if($sitepress->get_default_language() != $spot_language) {
			
				//// GETS THE TRANSLATION OF THIS CUSTOM FIELD
				$translation_id = icl_object_id($field_id, 'submission_field', false, $spot_language);
				
				/// IF THE TRANSLATION ID IS NUMERIC
				if(is_numeric($translation_id)) {
					
					$field_id = $translation_id;
					
				}
				
			}
			
		}
		
		//// LETS DISPLAY THE MARKUP FOR THIS FIELD
		include(locate_template('includes/submission_fields/markup-text-submission.php'));
		
	}
	
	
	
	//////////////////////////////////
	//// OUR SELECT FIELD MARKUP
	//////////////////////////////////
	
	function _sf_custom_submission_field_select($field_id, $position, $spot_id) {
		
		//// LETS CHECK IF WE ARE EDITING THE SAME LANGUAGE
				
		///// CHECKS FOR WPML
		global $sitepress;
		if(isset($sitepress)) {
			
			global $wpdb;
			
			//// GETS SPOT LANGUAGE
			$spot_language = wpml_get_language_information($spot_id);
			$query = $wpdb->get_row('SELECT code FROM ' . $wpdb->prefix . 'icl_languages WHERE default_locale="'.$spot_language['locale'].'"');
			$spot_language = $query->code;
			
			//// IF THE CURRENT LANGUAGE IS NOT THE DEFAULT ONE
			if($sitepress->get_default_language() != $spot_language) {
			
				//// GETS THE TRANSLATION OF THIS CUSTOM FIELD
				$translation_id = icl_object_id($field_id, 'submission_field', false, $spot_language);
				
				/// IF THE TRANSLATION ID IS NUMERIC
				if(is_numeric($translation_id)) {
					
					$field_id = $translation_id;
					
				}
				
			}
			
		}
		
		//// LETS DISPLAY THE MARKUP FOR THIS FIELD
		include(locate_template('includes/submission_fields/markup-select-submission.php'));
		
	}
	
	
	
	//////////////////////////////////
	//// OUR FILE FIELD MARKUP
	//////////////////////////////////
	
	function _sf_custom_submission_field_file($field_id, $position, $spot_id) {
		
		//// LETS CHECK IF WE ARE EDITING THE SAME LANGUAGE
				
		///// CHECKS FOR WPML
		global $sitepress;
		if(isset($sitepress)) {
			
			global $wpdb;
			
			//// GETS SPOT LANGUAGE
			$spot_language = wpml_get_language_information($spot_id);
			$query = $wpdb->get_row('SELECT code FROM ' . $wpdb->prefix . 'icl_languages WHERE default_locale="'.$spot_language['locale'].'"');
			$spot_language = $query->code;
			
			//// IF THE CURRENT LANGUAGE IS NOT THE DEFAULT ONE
			if($sitepress->get_default_language() != $spot_language) {
			
				//// GETS THE TRANSLATION OF THIS CUSTOM FIELD
				$translation_id = icl_object_id($field_id, 'submission_field', false, $spot_language);
				
				/// IF THE TRANSLATION ID IS NUMERIC
				if(is_numeric($translation_id)) {
					
					$field_id = $translation_id;
					
				}
				
			}
			
		}
		
		//// LETS DISPLAY THE MARKUP FOR THIS FIELD
		include(locate_template('includes/submission_fields/markup-file-submission.php'));
		
	}
	
	
	
	
	//////////////////////////////////
	//// RETURNS AN ARRAY OF SECTIONS
	//// TO CREATE ACTIONS AT
	//////////////////////////////////
	
	add_action('template_redirect', '_sf_custom_submission_fields_single_init');
	
	function _sf_custom_submission_fields_single_init() {
		
		//// LETS MAKE SURE ITS A SINGLE PAGE
		if(is_single()) {
			
			//// AND ITS A SPOT
			if(get_post_type() == 'spot') {
				
				//// NOW LETS GET OUR CUSTOM SUBMISSION FIELDS AND ADD THEM AS ACTIONS
				$args = array(
				
					'post_type' => 'submission_field',
					'posts_per_page' => -1,
					'post_status' => 'publish',
				
				);
				
				$sQ = new WP_Query($args);
				
				if($sQ->have_posts()) {
					
					$actions = array();
					
					while($sQ->have_posts()) {
						
						$sQ->the_post();
						
						///// NOW WE NEED TO GET WHERE TO DISPLAY IT AND ADD AS AN ACTION
						$the_action = get_post_meta(get_the_ID(), 'listing_position', true);
						$type = get_post_meta(get_the_ID(), 'field_type', true);
						
						$call_action = false;
						if(!isset($actions[$the_action])) { $call_action = true; }
						else {
							
							//// THIS ACTION HAS BEEN CALLED, LETS SEE IF WE HAVE THIS TYPE IN THERE ALREADY
							if(!isset($actions[$the_action][$type])) { $call_action = true; }
							
						}
						
						///// IF WE HAVE NOT ALREADY CALLED THIS ACTION
						if($call_action) {
						
							//// IF ITS A TEXT FIELD
							if($type == 'text') { add_action('single_spot_'.$the_action, '_sf_custom_submission_field_single_text', 10, 2); }
						
							//// IF ITS A TEXT FIELD
							if($type == 'dropdown') { add_action('single_spot_'.$the_action, '_sf_custom_submission_field_single_dropdown', 10, 2); }
						
							//// IF ITS A TEXT FIELD
							if($type == 'file') { add_action('single_spot_'.$the_action, '_sf_custom_submission_field_single_file', 10, 2); }
							
							//// ADDS IT TO OUR ARRAY
							$actions[$the_action][$type] = true;
						
						}
						
					} wp_reset_postdata();
					
				}
				
			}
			
		}
		
	}
	
	
	
	
	///// TEXT FIELD MARKUP
	function _sf_custom_submission_field_single_text($post_id, $position) {
		
		//// WE NEED TO GET ALL THE SUBMISSION FIELDS WITHIN THIS ACTION
		$args = array(
		
			'post_type' => 'submission_field',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => array(
			
				array(
				
					'key' => 'field_type',
					'value' => 'text',
				
				),
			
				array(
				
					'key' => 'listing_position',
					'value' => $position,
				
				),
			
			),
		
		);
		
		$sQ = new WP_Query($args);
		
		if($sQ->have_posts()) {
			
			while($sQ->have_posts()) {
				
				$sQ->the_post();
				
				//// NOW LETS CHECK IF WE HAVE A VALUE TO DISPLAY AND IF WE'RE IN THE RIGHT CATEGORY
				if(get_post_meta($post_id, '_sf_submission_field_'.get_the_ID(), true)!= '') {
					
					//// DISPLAYS OUR MARKUP
					include(locate_template('includes/submission_fields/single-text-submission.php'));
					
				}
				
			}
			wp_reset_postdata();
			
		}
		
	}
	
	
	
	
	///// TEXT FIELD MARKUP
	function _sf_custom_submission_field_single_dropdown($post_id, $position) {
		
		//// WE NEED TO GET ALL THE SUBMISSION FIELDS WITHIN THIS ACTION
		$args = array(
		
			'post_type' => 'submission_field',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => array(
			
				array(
				
					'key' => 'field_type',
					'value' => 'dropdown',
				
				),
			
				array(
				
					'key' => 'listing_position',
					'value' => $position,
				
				),
			
			),
		
		);
		
		$sQ = new WP_Query($args);
		
		if($sQ->have_posts()) {
			
			while($sQ->have_posts()) {
				
				$sQ->the_post();
				
				//// NOW LETS CHECK IF WE HAVE A VALUE TO DISPLAY AND IF WE'RE IN THE RIGHT CATEGORY
				if(get_post_meta($post_id, '_sf_submission_field_'.get_the_ID(), true)!= '') {
					
					//// DISPLAYS OUR MARKUP
					include(locate_template('includes/submission_fields/single-select-submission.php'));
					
				}
				
			}
			wp_reset_postdata();
			
		}
		
	}
	
	
	
	
	///// TEXT FIELD MARKUP
	function _sf_custom_submission_field_single_file($post_id, $position) {
		
		//// WE NEED TO GET ALL THE SUBMISSION FIELDS WITHIN THIS ACTION
		$args = array(
		
			'post_type' => 'submission_field',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => array(
			
				array(
				
					'key' => 'field_type',
					'value' => 'file',
				
				),
			
				array(
				
					'key' => 'listing_position',
					'value' => $position,
				
				),
			
			),
		
		);
		
		$sQ = new WP_Query($args);
		
		if($sQ->have_posts()) {
			
			while($sQ->have_posts()) {
				
				$sQ->the_post();
				
				//// NOW LETS CHECK IF WE HAVE A VALUE TO DISPLAY AND IF WE'RE IN THE RIGHT CATEGORY
				if(get_post_meta($post_id, '_sf_submission_field_'.get_the_ID(), true)!= '') {
					
					//// DISPLAYS OUR MARKUP
					include(locate_template('includes/submission_fields/single-file-submission.php'));
					
				}
				
			}
			wp_reset_postdata();
			
		}
		
	}
	
	
	
	
?>