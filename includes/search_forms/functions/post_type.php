<?php



	//// CREATES OUR POST TYPE
	add_action('init', 'btoa_search_form_post_type');	
	
	//// FUNCTION TO CREATE IT
	function btoa_search_form_post_type() {
		
		
		//// LABELS
		$labels = array(
		
			'name' => __('Search Forms', 'btoa'),
			'singular_name' => __('Search Form', 'btoa'),
			'add_new' => __('Add New', 'btoa'),
			'add_new_item' => __('Add New Search Form', 'btoa'),
			'edit_item' => __('Edit Search Form', 'btoa'),
			'new_item' => __('New Search Form', 'btoa'),
			'all_items' => __('All Search Forms', 'btoa'),
			'view_item' =>__('View Search Form', 'btoa'),
			'search_items' => __('Search Search Forms', 'btoa'),
			'not_found' =>  __('No Search Forms Found', 'btoa'),
			'not_found_in_trash' => __('No Search Forms found in trash.', 'btoa'),
			'parent_item_colon' => '',
			'menu_name' => 'Search Forms'
		
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
		$args['capability_type'] = 'search_form';
		$args['capabilities'] = array(
		
			'publish_posts' => 'publish_search_form',
			'edit_posts' => 'edit_search_forms',
			'edit_others_posts' => 'edit_others_search_forms',
			'delete_posts' => 'delete_search_forms',
			'delete_others_posts' => 'delete_others_search_forms',
			'read_private_posts' => 'read_private_search_forms',
			'edit_post' => 'edit_search_form',
			'delete_post' => 'delete_search_form',
			'read_post' => 'read_search_form',
			'edit_page' => 'edit_search_form',
		
		);
		  
		
		//// REGISTERS IT
		register_post_type('search_form', $args);
		
		///// ADDS CAPABILITIES TO ADMIN ROLE
		$admin = get_role('administrator');
		
		//// IF CAPABILITIES ARE NOT ALREADY THERE
		if(!$admin->has_cap('publish_search_form')) {
		
			$admin->add_cap('publish_search_form');
			$admin->add_cap('edit_search_forms');
			$admin->add_cap('edit_others_search_forms');
			$admin->add_cap('delete_search_forms');
			$admin->add_cap('delete_others_search_forms');
			$admin->add_cap('read_private_search_forms');
			$admin->add_cap('edit_search_form');
			$admin->add_cap('delete_search_form');
			$admin->add_cap('read_search_form');
			$admin->add_cap('edit_search_form');
		
		}
		
	}


?>