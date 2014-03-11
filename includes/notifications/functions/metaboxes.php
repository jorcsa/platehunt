<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// METABOXES
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('add_meta_boxes' ,'btoa_user_notification_metabox');
	//add_action('save_post', 'btoa_user_notification_metabox_save');
	
	//// FUNCTION
	function btoa_user_notification_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_user_notification_metabox_meta', 'Notification Attributes', 'btoa_user_notification_metabox_create', 'user_notification', 'normal', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_user_notification_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_user_notification_metabox_save($post_id) {
		
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
		  
		}
		
		if(isset($_POST['post_type'])) { if('spot' == $_POST['post_type']) {
			
			$fields = get_posts(array('post_type' => 'search_field','posts_per_page' => -1));
			
			//// LOOPS EACH POST AND MAKES SURE THE META IS SET
			foreach($fields as $field) {
				
				//// IF THIS FIELD IS SET
				if(isset($_POST['_sf_field_'.$field->ID])) {
					
					//// UPDATES META
					update_post_meta($post_id, '_sf_field_'.$field->ID, $_POST['_sf_field_'.$field->ID]);
					
				} else {
					
					update_post_meta($post_id, '_sf_field_'.$field->ID, '');
					
				}
				
			}
			
		} }
		
		//// CUSTOM FIELDS
		if(isset($_POST['_sf_custom_fields'])) { update_post_meta($post_id, '_sf_custom_fields', htmlspecialchars($_POST['_sf_custom_fields'])); }
		if(isset($_POST['address'])) { update_post_meta($post_id, 'address', htmlspecialchars($_POST['address'])); } 
		if(isset($_POST['latitude'])) { update_post_meta($post_id, 'latitude', htmlspecialchars($_POST['latitude'])); }
		if(isset($_POST['longitude'])) { update_post_meta($post_id, 'longitude', htmlspecialchars($_POST['longitude'])); }
		if(isset($_POST['pin'])) { update_post_meta($post_id, 'pin', htmlspecialchars($_POST['pin'])); }
		if(isset($_POST['_sf_gallery_images'])) { update_post_meta($post_id, '_sf_gallery_images', htmlspecialchars($_POST['_sf_gallery_images'])); }
		if(isset($_POST['contact_form'])) { update_post_meta($post_id, 'contact_form', htmlspecialchars($_POST['contact_form'])); } else { update_post_meta($post_id, 'contact_form', ''); }
		if(isset($_POST['featured'])) { update_post_meta($post_id, 'featured', htmlspecialchars($_POST['featured'])); } else { update_post_meta($post_id, 'featured', ''); }
		if(isset($_POST['slogan'])) { update_post_meta($post_id, 'slogan', htmlspecialchars($_POST['slogan'])); }
		
	}
	
	

?>