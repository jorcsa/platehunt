<?php



	//// CREATES OUR POST TYPE
	add_action('init', 'btoa_notifications_post_type');	
	
	//// FUNCTION TO CREATE IT
	function btoa_notifications_post_type() {
		
		
		//// LABELS
		$labels = array(
		
			'name' => __('User Notifications', 'btoa'),
			'singular_name' => __('User Notification', 'btoa'),
			'add_new' => __('Add New', 'btoa'),
			'add_new_item' => __('Add New User Notification', 'btoa'),
			'edit_item' => __('Edit User Notification', 'btoa'),
			'new_item' => __('New User Notification', 'btoa'),
			'all_items' => __('All User Notifications', 'btoa'),
			'view_item' =>__('View User Notification', 'btoa'),
			'search_items' => __('Search User Notifications', 'btoa'),
			'not_found' =>  __('No User Notifications Found', 'btoa'),
			'not_found_in_trash' => __('No User Notifications found in trash.', 'btoa'),
			'parent_item_colon' => '',
			'menu_name' => 'User Notifications'
		
		);
		  
		  
		//// ARGUMENTS
		$args = array(
		
			'labels' => $labels,
			'public' => false,
			'exclude_from_search' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => true,
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 7,
			'supports' => array('title', 'custom-fields')
		  
		);
		  
		
		//// REGISTERS IT
		register_post_type('user_notification', $args);
		
	}


?>