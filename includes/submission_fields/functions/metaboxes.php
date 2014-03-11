<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// METABOXES
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'btoa_submission_field_metabox');
	add_action('save_post', 'btoa_submission_field_metabox_save');
	
	//// FUNCTION
	function btoa_submission_field_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_submission_field_metabox_meta', 'Submission Field Options', 'btoa_submission_field_metabox_create', 'submission_field', 'normal', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_submission_field_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_submission_field_metabox_save($post_id) {
		
		//// GLOBAL $POST
		global $post;
		
		//// CHECK IF IT'S AN AUTOSAVE
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
		
		if(isset($_POST['post_type'])) {
		
			//// VERIFY PERMISSIONS
			if('page' == $_POST['post_type']) {
				 
				//// IF USER CAN'T EDIT PAGE
				if(!current_user_can('edit_page', $post_id)) { return $post_id; }
				
				//// IF USER CAN'T EDIT POST
				if(!current_user_can('edit_post', $post_id)) { return $post_id; }
				
			}
			
			if('submission_field' == $_POST['post_type']) {
					
					
				if($_POST['field_category'] == '') { $_POST['field_category'] = array('all'); }
				if($_POST['markup'] == '') { $_POST['markup'] = '%%'; }
			
				//// FREE TO SAVE METABOX
				if(isset($_POST['field_type'])) { update_post_meta($post_id, 'field_type', htmlspecialchars($_POST['field_type'])); }
				if(isset($_POST['field_category'])) { update_post_meta($post_id, 'field_category', $_POST['field_category']); }
				if(isset($_POST['position'])) { update_post_meta($post_id, 'position', htmlspecialchars($_POST['position'])); }
				if(isset($_POST['dropdown_values'])) { update_post_meta($post_id, 'dropdown_values', htmlspecialchars($_POST['dropdown_values'])); }
				if(isset($_POST['listing_position'])) { update_post_meta($post_id, 'listing_position', htmlspecialchars($_POST['listing_position'])); }
				if(isset($_POST['markup'])) { update_post_meta($post_id, 'markup', htmlspecialchars($_POST['markup'])); }
				if(isset($_POST['required'])) { update_post_meta($post_id, 'required', htmlspecialchars($_POST['required'])); } else { update_post_meta($post_id, 'required', ''); }
				if(isset($_POST['allow_html'])) { update_post_meta($post_id, 'allow_html', htmlspecialchars($_POST['allow_html'])); } else { update_post_meta($post_id, 'allow_html', ''); }
				if(isset($_POST['allow_video'])) { update_post_meta($post_id, 'allow_video', htmlspecialchars($_POST['allow_video'])); } else { update_post_meta($post_id, 'allow_video', ''); }
				if(isset($_POST['file_count'])) { update_post_meta($post_id, 'file_count', htmlspecialchars($_POST['file_count'])); }
		  
		} }
		
	}
	
	

?>