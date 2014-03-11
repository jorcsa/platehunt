<?php
	
	

	
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//// BLOG POST METABOXES (CONTROLS THE LAYOUT - SINGLE)
	////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	add_action('admin_menu' ,'ultrasharp_post_layout_metabox');
	add_action('save_post', 'ultrasharp_post_layout_save');
	
	//// FUNCTION
	function ultrasharp_post_layout_metabox() {
		
		//// ADDS METABOX
		add_meta_box('ultrasharp_post_layout_meta', 'Page Layout', 'ultrasharp_post_layout_meta_create', 'post', 'side', 'high' );
		
	}
	
	//// CREATE THEINLINE CONTENT METABOX
	function ultrasharp_post_layout_meta_create() {
		
		//// GLOBAL $POST
		global $post;
		
		//// METABOX MARKUP
		include('meta/layout-post.php');
		
	}
	
	//// SAVES THE INLINE CONTENT METABOX
	function ultrasharp_post_layout_save($post_id) {
		
		//// GLOBAL $POST
		global $post;
		
		//// CHECK IF IT'S AN AUTOSAVE
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
		
		if(isset($_POST['post_type'])) {
		
			//// VERIFY PERMISSIONS
			if('post' == $_POST['post_type']) {
				 
				//// IF USER CAN'T EDIT PAGE
				if(!current_user_can('edit_page', $post_id)) { return $post_id; }
				
				//// IF USER CAN'T EDIT POST
				if(!current_user_can('edit_post', $post_id)) { return $post_id; }
				
			}
		  
		}
		
		//// FREE TO SAVE METABOX
		if(isset($_POST['sidebar_position'])) { update_post_meta($post_id, 'sidebar_position', htmlspecialchars($_POST['sidebar_position'])); }
		
	}
		
		
		//////////////////////////////////////////////////
		//// SUBURBS METABOX
		//////////////////////////////////////////////////
	
		/// ADDS THE HTML INPUT TO OUR TERM
		function add_fields_categories() {
			
			include('meta/metabox-categories.php');
			
		}
		
		/// ADDS OUR ACTION
		//add_action('category_add_form_fields', 'add_fields_categories', 10, 2);

		/// ADDS THE HTML INPUT TO OUR TERM
		function edit_fields_categories($term) {
			
			include('meta/metabox-categories-edit.php');
			
		}
		
		/// ADDS OUR ACTION
		//add_action('category_edit_form_fields', 'edit_fields_categories', 10, 2);
		
		//// SAVES OUR CUSTOM FIELDS
		function save_fields_categories($term_id) {
			
			//// TERM ID
			$t_id = $term_id;
			
			//// ALL META
			$term_meta = get_option('taxonomy_'.$t_id);
			
			/// IF IS ARRAY (PREVENTS AJAX AERRORS
			if(is_array($_POST['term_meta'])) {
			
			//// LOOPS FIELDS AND SAVES THEM
			$cat_keys = array_keys($_POST['term_meta']);
			
		
		//print_r($_POST['term_meta']['related_categories']); exit;
		
			foreach ($cat_keys as $key) {
				
				//// OUR FIELD
				$term_meta[$key] = $_POST['term_meta'][$key];
				
			}
			
			//// SAVES OPTION ARRAY
			update_option('taxonomy_'.$t_id, $term_meta);
			
		}
		
		}
		
		/// SAVE ACTION
		//add_action('edited_category', 'save_fields_categories', 10, 2);
		//add_action('create_category', 'save_fields_categories', 10, 2);
	

?>