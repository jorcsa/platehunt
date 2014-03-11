<?php



	//// CREATES OUR POST TYPE
	add_action('init', 'btoa_search_post_type');	
	
	//// FUNCTION TO CREATE IT
	function btoa_search_post_type() {
		
		
		//// LABELS
		$labels = array(
		
			'name' => __('Search Fields', 'btoa'),
			'singular_name' => __('Search Field', 'btoa'),
			'add_new' => __('Add New', 'btoa'),
			'add_new_item' => __('Add New Search Field', 'btoa'),
			'edit_item' => __('Edit Search Field', 'btoa'),
			'new_item' => __('New Search Field', 'btoa'),
			'all_items' => __('All Search Fields', 'btoa'),
			'view_item' =>__('View Search Field', 'btoa'),
			'search_items' => __('Search Search Fields', 'btoa'),
			'not_found' =>  __('No Search Fields Found', 'btoa'),
			'not_found_in_trash' => __('No Search Fields found in trash.', 'btoa'),
			'parent_item_colon' => '',
			'menu_name' => 'Search Fields'
		
		);
		  
		  
		//// ARGUMENTS
		$args = array(
		
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => false,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => true,
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 7,
			'supports' => array('title', 'custom-fields')
		  
		);
			
			
		//// CAPABILITIES
		$args['capability_type'] = 'search_field';
		$args['capabilities'] = array(
		
			'publish_posts' => 'publish_search_field',
			'edit_posts' => 'edit_search_fields',
			'edit_others_posts' => 'edit_others_search_fields',
			'delete_posts' => 'delete_search_fields',
			'delete_others_posts' => 'delete_others_search_fields',
			'read_private_posts' => 'read_private_search_fields',
			'edit_post' => 'edit_search_field',
			'delete_post' => 'delete_search_field',
			'read_post' => 'read_search_field',
			'edit_page' => 'edit_search_field',
		
		);
		  
		
		//// REGISTERS IT
		register_post_type('search_field', $args);
		
		///// ADDS CAPABILITIES TO ADMIN ROLE
		$admin = get_role('administrator');
		//print_r($admin); exit;
		
		//// IF CAPABILITIES ARE NOT ALREADY THERE
		if(!$admin->has_cap('publish_search_field')) {
		
			$admin->add_cap('publish_search_field');
			$admin->add_cap('edit_search_fields');
			$admin->add_cap('edit_others_search_fields');
			$admin->add_cap('delete_search_fields');
			$admin->add_cap('delete_others_search_fields');
			$admin->add_cap('read_private_search_fields');
			$admin->add_cap('edit_search_field');
			$admin->add_cap('delete_search_field');
			$admin->add_cap('read_search_field');
			$admin->add_cap('edit_search_field');
		
		}
		
	}


?>