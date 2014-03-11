<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// METABOXES
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('add_meta_boxes' ,'btoa_spot_metabox');
	add_action('save_post', 'btoa_spot_metabox_save');
	
	//// FUNCTION
	function btoa_spot_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_spot_metabox_meta', 'Search Options', 'btoa_spot_metabox_create', 'spot', 'normal', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_spot_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_spot_metabox_save($post_id) {
		
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
			
			///// CUSTOM SUBMISSION FIELDS
			$fields = get_posts(array('post_type' => 'submission_field','posts_per_page' => -1));
			
			//// LOOPS EACH POST AND MAKES SURE THE META IS SET
			foreach($fields as $field) {
				
				//// IF THIS FIELD IS SET
				if(isset($_POST['_sf_submission_field_'.$field->ID])) {
					
					if(get_post_meta($field->ID, 'field_type', true) == 'file') {
						
						update_post_meta($post_id, '_sf_submission_field_'.$field->ID, htmlspecialchars(stripslashes(stripslashes(strip_tags(htmlspecialchars_decode($_POST['_sf_submission_field_'.$field->ID]))))));
						
					} else {
					
						//// UPDATES META
						update_post_meta($post_id, '_sf_submission_field_'.$field->ID, $_POST['_sf_submission_field_'.$field->ID]);
					
					}
					
				} else {
					
					update_post_meta($post_id, '_sf_submission_field_'.$field->ID, '');
					
				}
				
			}
		
			//// CUSTOM FIELDS
			if(isset($_POST['_sf_custom_fields'])) { update_post_meta($post_id, '_sf_custom_fields', htmlspecialchars($_POST['_sf_custom_fields'])); }
			if(isset($_POST['address'])) { update_post_meta($post_id, 'address', esc_attr($_POST['address'])); } 
			if(isset($_POST['latitude'])) { update_post_meta($post_id, 'latitude', esc_attr(trim($_POST['latitude']))); }
			if(isset($_POST['longitude'])) { update_post_meta($post_id, 'longitude', esc_attr(trim($_POST['longitude']))); }
			if(isset($_POST['pin'])) { update_post_meta($post_id, 'pin', htmlspecialchars($_POST['pin'])); }
			if(isset($_POST['_sf_gallery_images'])) { update_post_meta($post_id, '_sf_gallery_images', htmlspecialchars($_POST['_sf_gallery_images'])); }
			if(isset($_POST['contact_form'])) { update_post_meta($post_id, 'contact_form', htmlspecialchars($_POST['contact_form'])); } else { update_post_meta($post_id, 'contact_form', ''); }
			if(isset($_POST['featured'])) { update_post_meta($post_id, 'featured', htmlspecialchars($_POST['featured'])); } else { update_post_meta($post_id, 'featured', ''); }
			if(isset($_POST['slogan'])) { update_post_meta($post_id, 'slogan', htmlspecialchars($_POST['slogan'])); }
			
			//// EXPIRY DATE
			if(isset($_POST['expiry_date']) && isset($_POST['expiry_date_value'])) {
				
				///// LETS MAKE SURE WE DO STRTOTIME TO GET THE USERS CURRENT TIMEZONE INTO CONSIDERATION
				if($the_date = strtotime($_POST['expiry_date_value'])) {
					
					update_post_meta($post_id, 'expiry_date', $the_date);
					
				} else { update_post_meta($post_id, 'expiry_date', ''); }
				
			}
			
			//// EXPIRY DATE
			if(isset($_POST['featured_payment_expire']) && isset($_POST['featured_payment_expire_value'])) {
				
				///// LETS MAKE SURE WE DO STRTOTIME TO GET THE USERS CURRENT TIMEZONE INTO CONSIDERATION
				if($the_date = strtotime($_POST['featured_payment_expire_value'])) {
					
					update_post_meta($post_id, 'featured_payment_expire', $the_date);
					
				} else { update_post_meta($post_id, 'featured_payment_expire', ''); }
				
			}
			
			//// DEALS WITH RATINGS IN CASE WE HAE NOTHING SET
			if(ddp('rating') == 'on') {
				
				if(get_post_meta($post_id, 'rating', true) == '') {
					
					update_post_meta($post_id, 'rating', 0);
					update_post_meta($post_id, 'rating_count', 0);
					
				}
				
			}
			
		} }
		
	}
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// CART METABOXES
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('add_meta_boxes' ,'btoa_spotcart_metabox');
	add_action('save_post', 'btoa_spotcart_metabox_save');
	
	//// FUNCTION
	function btoa_spotcart_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_spotcart_metabox_meta', 'Cart Options', 'btoa_spotcart_metabox_create', 'spot', 'side', 'default' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_spotcart_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/cart.php');
		
	}
	
	//// SAVES THE CART METABOX
	function btoa_spotcart_metabox_save($post_id) {
		
		//// GLOBAL $POST
		global $post;
		
		//// CHECK IF IT'S AN AUTOSAVE
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
		
		if(isset($_POST['post_type'])) { if('spot' == $_POST['post_type']) {
			
			$fields = get_posts(array('post_type' => 'search_field','posts_per_page' => -1));
			
			//// LOOPS EACH POST AND MAKES SURE THE META IS SET
			foreach($fields as $field) {
				
				//// IF THIS FIELD IS SET
				if(isset($_POST['_sf_'.$field->ID]) || isset($_POST['_sf_'.$field->ID.'_cart'])) {
					
					//// UPDATES META
					if(isset($_POST['_sf_'.$field->ID])) { update_post_meta($post_id, '_sf_'.$field->ID, htmlspecialchars($_POST['_sf_'.$field->ID])); } else { update_post_meta($post_id, '_sf_'.$field->ID, ''); }
					if(isset($_POST['_sf_'.$field->ID.'_cart'])) { update_post_meta($post_id, '_sf_'.$field->ID.'_cart', htmlspecialchars($_POST['_sf_'.$field->ID.'_cart'])); } else { update_post_meta($post_id, '_sf_'.$field->ID.'_cart', ''); }
					
				} else {
					
					update_post_meta($post_id, '_sf_'.$field->ID, '');
					update_post_meta($post_id, '_sf_'.$field->ID.'_cart', '');
					
				}
				
			}
		
			///// LETS SAVE OUR CART META
			if(isset($_POST['price_submission_payment'])) { update_post_meta($post_id, 'price_submission_payment', htmlspecialchars($_POST['price_submission_payment'])); } else { update_post_meta($post_id, 'price_submission_payment', ''); }
			if(isset($_POST['price_images'])) { update_post_meta($post_id, 'price_images', htmlspecialchars($_POST['price_images'])); } else { update_post_meta($post_id, 'price_images', ''); }
			if(isset($_POST['price_images_cart'])) { update_post_meta($post_id, 'price_images_cart', htmlspecialchars($_POST['price_images_cart'])); } else { update_post_meta($post_id, 'price_images_cart', ''); }
			if(isset($_POST['price_featured'])) { update_post_meta($post_id, 'price_featured', htmlspecialchars($_POST['price_featured'])); } else { update_post_meta($post_id, 'price_featured', ''); }
			if(isset($_POST['price_featured_cart'])) { update_post_meta($post_id, 'price_featured_cart', htmlspecialchars($_POST['price_featured_cart'])); } else { update_post_meta($post_id, 'price_featured_cart', ''); }
			if(isset($_POST['price_tags'])) { update_post_meta($post_id, 'price_tags', htmlspecialchars($_POST['price_tags'])); } else { update_post_meta($post_id, 'price_tags', ''); }
			if(isset($_POST['price_tags_cart'])) { update_post_meta($post_id, 'price_tags_cart', htmlspecialchars($_POST['price_tags_cart'])); } else { update_post_meta($post_id, 'price_tags_cart', ''); }
			if(isset($_POST['price_custom_pin'])) { update_post_meta($post_id, 'price_custom_pin', htmlspecialchars($_POST['price_custom_pin'])); } else { update_post_meta($post_id, 'price_custom_pin', ''); }
			if(isset($_POST['price_custom_pin_cart'])) { update_post_meta($post_id, 'price_custom_pin_cart', htmlspecialchars($_POST['price_custom_pin_cart'])); } else { update_post_meta($post_id, 'price_custom_pin_cart', ''); }
			if(isset($_POST['price_custom_fields'])) { update_post_meta($post_id, 'price_custom_fields', htmlspecialchars($_POST['price_custom_fields'])); } else { update_post_meta($post_id, 'price_custom_fields', ''); }
			if(isset($_POST['price_custom_fields_cart'])) { update_post_meta($post_id, 'price_custom_fields_cart', htmlspecialchars($_POST['price_custom_fields_cart'])); } else { update_post_meta($post_id, 'price_custom_fields_cart', ''); }
			if(isset($_POST['price_contact_form'])) { update_post_meta($post_id, 'price_contact_form', htmlspecialchars($_POST['price_contact_form'])); } else { update_post_meta($post_id, 'price_contact_form', ''); }
			if(isset($_POST['price_contact_form_cart'])) { update_post_meta($post_id, 'price_contact_form_cart', htmlspecialchars($_POST['price_contact_form_cart'])); } else { update_post_meta($post_id, 'price_contact_form_cart', ''); }
			
			
		} }
	}
	
	

?>