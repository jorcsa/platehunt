<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// LAYOUT METABOX
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'five_page_layout_metabox');
	add_action('save_post', 'five_page_layout_save');
	
	//// FUNCTION
	function five_page_layout_metabox() {
		
		//// ADDS METABOX
		add_meta_box('five_page_layout_meta', 'Page Layout', 'five_page_layout_meta_create', 'page', 'side', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function five_page_layout_meta_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// CREATES NONCE FIELD
		wp_nonce_field( plugin_basename( __FILE__ ), 'wp_nonce_sidebar_position', false, true);
		
		//// METABOX MARKUP
		include('meta/layout.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function five_page_layout_save($post_id) {
		
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
		
			//// FREE TO SAVE METABOX
			if(isset($_POST['sidebar_position'])) { update_post_meta($post_id, 'sidebar_position', htmlspecialchars($_POST['sidebar_position'])); }
		  
		}
		
	}
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// CUSTOM SIDEBAR METABOX
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'five_page_sidebar_metabox');
	add_action('save_post', 'five_page_sidebar_save');
	
	//// FUNCTION
	function five_page_sidebar_metabox() {
		
		//// ADDS METABOX
		add_meta_box('five_page_sidebar_meta', 'Custom Sidebar', 'five_page_sidebar_meta_create', 'page', 'side', 'low' );
		add_meta_box('five_page_sidebar_meta', 'Custom Sidebar', 'five_page_sidebar_meta_create', 'post', 'side', 'low' );
		add_meta_box('five_page_sidebar_meta', 'Custom Sidebar', 'five_page_sidebar_meta_create', 'spot', 'side', 'low' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function five_page_sidebar_meta_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// CREATES NONCE FIELD
		wp_nonce_field( plugin_basename( __FILE__ ), 'wp_nonce_sidebar', false, true);
		
		//// METABOX MARKUP
		include('meta/sidebar-meta.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function five_page_sidebar_save($post_id) {
		
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
			
			if('page' == $_POST['post_type'] || 'post' == $_POST['post_type'] || 'spot' == $_POST['post_type']) {
		
				//// FREE TO SAVE METABOX
				if(isset($_POST['page_sidebar'])) { update_post_meta($post_id, 'page_sidebar', htmlspecialchars($_POST['page_sidebar'])); }
				
			}
		  
		}
		
	}
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// GENERAL OPTIONS
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'btoa_page_metabox');
	add_action('save_post', 'btoa_page_metabox_save');
	
	//// FUNCTION
	function btoa_page_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_page_metabox', 'Page Options', 'btoa_page_metabox_create', 'page', 'normal', 'high' );
		add_meta_box('btoa_page_metabox', 'Post Options', 'btoa_page_metabox_create_post', 'post', 'normal', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_page_metabox_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes.php');
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_page_metabox_create_post() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/metaboxes-post.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_page_metabox_save($post_id) {
		
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
		
		//// FREE TO SAVE METABOX
		if(isset($_POST['header_bg'])) { update_post_meta($post_id, 'header_bg', htmlspecialchars($_POST['header_bg'])); }
		if(isset($_POST['header_title'])) { update_post_meta($post_id, 'header_title', htmlspecialchars($_POST['header_title'])); }
		if(isset($_POST['header_color'])) { update_post_meta($post_id, 'header_color', htmlspecialchars($_POST['header_color'])); }
		if(isset($_POST['slogan'])) { update_post_meta($post_id, 'slogan', htmlspecialchars($_POST['slogan'])); }
		if(isset($_POST['fancy_slogan'])) { update_post_meta($post_id, 'fancy_slogan', htmlspecialchars($_POST['fancy_slogan'])); }
		if(isset($_POST['page_title'])) { update_post_meta($post_id, 'page_title', htmlspecialchars($_POST['page_title'])); } else { update_post_meta($post_id, 'page_title', ''); }
		if(isset($_POST['list_map'])) { update_post_meta($post_id, 'list_map', htmlspecialchars($_POST['list_map'])); } else { update_post_meta($post_id, 'list_map', ''); }
		if(isset($_POST['list_form'])) { update_post_meta($post_id, 'list_form', htmlspecialchars($_POST['list_form'])); }
		if(isset($_POST['submit_loggedin'])) { update_post_meta($post_id, 'submit_loggedin', esc_attr($_POST['submit_loggedin'])); }
		
	}
	

?>