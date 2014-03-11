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
	
	
	
	//// APPLIES MARKUP FOR THE FIELD
	function apply_field_overlay_markup($field_id, $value) {
		
		global $sitepress;
		$field_markup = htmlspecialchars_decode(get_post_meta($field_id, 'overlay_markup', true));
		
		if(isset($sitepress)) {
						
			//// CHECKS IF THE LABEL HAS A TRANSLATION
			if(get_post_meta($field_id, 'overlay_markup_wpml_'.ICL_LANGUAGE_CODE, true) != '') {
				
				$field_markup = htmlspecialchars_decode(get_post_meta($field_id, 'overlay_markup_wpml_'.ICL_LANGUAGE_CODE, true));
				
			}
			
		}
		
		if($field_markup != '') {
			
			//// DOES OUR MULTIPLIER
			$multiplier = explode('%_*VAL_%', $field_markup);
			if(count($multiplier) > 1 && is_numeric($value)) {
				
				$multiplied = '';
				for($i=0; $i<$value; $i++) { $multiplied .= $multiplier[1]; }
				
				$field_markup = $multiplier[0].$multiplied;
				
			}
			
			//// IF ITS A PRICE
			if(get_post_meta($field_id, 'range_price', true) == 'on') { $value = number_format($value); }
		
			//// APPLYES THE FIELD TO OUR MARKUP
			return str_replace('%%', $value, $field_markup);
			
		}
		
	}
	
	
	//// APPLIES MARKUP FOR THE FIELD
	function apply_field_overlay_markup_dropdown($field_id, $value) {
		
		global $sitepress;
		$field_markup = htmlspecialchars_decode(get_post_meta($field_id, 'overlay_markup', true));
		$fields = json_decode(htmlspecialchars_decode(get_post_meta($field_id, 'dropdown_values', true)));
		
		if(isset($sitepress)) {
						
			//// CHECKS IF THE LABEL HAS A TRANSLATION
			if(get_post_meta($field_id, 'overlay_markup_wpml_'.ICL_LANGUAGE_CODE, true) != '') {
				
				$field_markup = htmlspecialchars_decode(get_post_meta($field_id, 'overlay_markup_wpml_'.ICL_LANGUAGE_CODE, true));
				
			}
			
		}
		
		if($field_markup != '') {
			
			$string = '';
			
			//// GOES THROUGH EACH FIELD AND CHECKS IF IT"S SELECTED THEN ADDS TO THE STRING
			foreach($fields as $single_field) { if(in_array($single_field->id, $value)) { $string .= get_translated_wpml_value($field_id, $single_field->label).', '; } }
		
			//// APPLYES THE FIELD TO OUR MARKUP
			return str_replace('%%', rtrim($string, ', '), $field_markup);
			
		}
		
	}
	
	
	//// APPLIES MARKUP FOR THE FIELD
	function apply_field_overlay_markup_dependent($field_id, $value) {
		
		global $sitepress;
		$field_markup = htmlspecialchars_decode(get_post_meta($field_id, 'overlay_markup', true));
		$fields = json_decode(htmlspecialchars_decode(get_post_meta($field_id, 'dependent_values', true)));
		
		if(isset($sitepress)) {
						
			//// CHECKS IF THE LABEL HAS A TRANSLATION
			if(get_post_meta($field_id, 'overlay_markup_wpml_'.ICL_LANGUAGE_CODE, true) != '') {
				
				$field_markup = htmlspecialchars_decode(get_post_meta($field_id, 'overlay_markup_wpml_'.ICL_LANGUAGE_CODE, true));
				
			}
			
		}
		
		if($field_markup != '') {
			
			$string = '';
			
			//// GOES THROUGH EACH FIELD AND CHECKS IF IT"S SELECTED THEN ADDS TO THE STRING
			foreach($fields as $section) { foreach($section as $single_field) { if(in_array($single_field->id, $value)) { $string .= get_translated_wpml_value($field_id, $single_field->label).', '; } } }
		
			//// APPLYES THE FIELD TO OUR MARKUP
			return str_replace('%%', rtrim($string, ', '), $field_markup);
			
		}
		
	}
	
	
	///// GETS PAGE SEARCH FORM
	function _sf_get_page_search_form() {
		
		global $post;
		
		//// IF FRONT PAGE
		if(is_front_page()) { return ddp('search_form'); }
		
		//// IF IT'S A PAGE
		if(is_page()) {
			
			//// MAKES SURE IT'S A LISTING PAGE
			$page = get_page($post->ID);
			$form = get_post_meta($post->ID, 'list_form', true);
			
			//// IF EMPTY GETS HOMEPAGE
			if($form == '') { $form = ddp('search_form'); }
			
		}
		
		///// IF IT'S A CATEGORY PAGE
		if(is_tax('spot_cats')) {
			
			$term = get_term_by('name', single_cat_title('', false), 'spot_cats');
			$form = getTermCustomField($term->term_id, 'search_form');
			
			if($form == '') { $form = ddp('search_form'); }
			
		}
		
		//// RETURNS FORM
		return $form;
		
	}
	

?>