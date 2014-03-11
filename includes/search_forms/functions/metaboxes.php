<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// METABOXES
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'btoa_search_form_metabox');
	add_action('save_post', 'btoa_search_form_metabox_save');
	
	//// FUNCTION
	function btoa_search_form_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_search_form_metabox_meta', 'Search Form Layout', 'btoa_search_form_metabox_create', 'search_form', 'normal', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_search_form_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_search_form_metabox_save($post_id) {
		
		//echo '<pre>'; print_r(json_decode(stripslashes($_POST['form_fields']))); exit;
		
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
			
			if('search_form' == $_POST['post_type']) {
		
			if(isset($_POST['column_layout'])) { update_post_meta($post_id, 'column_layout', htmlspecialchars($_POST['column_layout'])); }
			if(isset($_POST['form_fields'])) { update_post_meta($post_id, 'form_fields', htmlspecialchars($_POST['form_fields'])); }
			  
		} }
		
	}
	
	

?>