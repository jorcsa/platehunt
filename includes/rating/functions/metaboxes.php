<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// METABOXES
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('add_meta_boxes' ,'btoa_rating_metabox');
	add_action('save_post', 'btoa_rating_metabox_save');
	
	//// FUNCTION
	function btoa_rating_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_rating_metabox_meta', 'Rating Options', 'btoa_ratingt_metabox_create', 'rating', 'normal', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_ratingt_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_rating_metabox_save($post_id) {
		
		//// GLOBAL $POST
		global $post;
		
		//// CHECK IF IT'S AN AUTOSAVE
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
		
		if(isset($_POST['post_type'])) { if('rating' == $_POST['post_type']) {
			
			$fields = get_terms('rating_field', array('hide_empty' => false));
			$ratings = 0;
			
			//// LOOPS EACH POST AND MAKES SURE THE META IS SET
			foreach($fields as $field) {
				
				//// IF THIS FIELD IS SET
				if(isset($_POST['sf_rating_field_'.$field->term_id])) {
					
					//// UPDATES META
					update_post_meta($post_id, 'sf_rating_field_'.$field->term_id, $_POST['sf_rating_field_'.$field->term_id]);
					$ratings = $ratings+$_POST['sf_rating_field_'.$field->term_id];
					
				} else {
					
					update_post_meta($post_id, 'sf_rating_field_'.$field->ID, '');
					
				}
				
			}
			
			if($ratings != 0 && sizeof($fields) != 0) { $rating = round($ratings / sizeof($fields), 2); }
			else { $rating = 0; }
		
			//// CUSTOM FIELDS
			if(isset($rating)) { update_post_meta($post_id, 'rating', $rating); }
			if(isset($_POST['user'])) { update_post_meta($post_id, 'user', esc_attr($_POST['user'])); } 
			if(isset($_POST['user_email'])) { update_post_meta($post_id, 'user_email', esc_attr(trim($_POST['user_email']))); }
			if(isset($_POST['parent'])) { update_post_meta($post_id, 'parent', esc_attr(trim($_POST['parent']))); }
			if(isset($_POST['moderate'])) { update_post_meta($post_id, 'moderate', htmlspecialchars($_POST['moderate'])); }
			
		} }
		
	}

?>