<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// BACKGROUND COLOR METABOX
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'btoa_home_posts_background_metabox');
	add_action('save_post', 'btoa_home_posts_background_save');
	
	//// FUNCTION
	function btoa_home_posts_background_metabox() {
		
		//// ADDS METABOX
		add_meta_box('btoa_background_home_posts_meta', 'Background', 'btoa_home_posts_background_create', 'home_posts', 'side', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function btoa_home_posts_background_create() {
		
		//// GLOBAL $POST
		global $post;
		
		
		//// METABOX MARKUP
		include('meta/background-color.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function btoa_home_posts_background_save($post_id) {
		
		//// GLOBAL $POST
		global $post;
		
		//// VERIFY NONCE FIELD
		
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
		if(isset($_POST['background_color'])) { update_post_meta($post_id, 'background_color', htmlspecialchars($_POST['background_color'])); }
		if(isset($_POST['top_border_color'])) { update_post_meta($post_id, 'top_border_color', htmlspecialchars($_POST['top_border_color'])); }
		if(isset($_POST['top_border_size'])) { update_post_meta($post_id, 'top_border_size', htmlspecialchars($_POST['top_border_size'])); }
		if(isset($_POST['bottom_border_color'])) { update_post_meta($post_id, 'bottom_border_color', htmlspecialchars($_POST['bottom_border_color'])); }
		if(isset($_POST['bottom_border_size'])) { update_post_meta($post_id, 'bottom_border_size', htmlspecialchars($_POST['bottom_border_size'])); }
		
	}
	
	

?>