<?php



	//// CREATES OUR POST TYPE
	add_action('init', 'btoa_rating_post_type');	
	
	//// FUNCTION TO CREATE IT
	function btoa_rating_post_type() {
		
		
		//// LABELS
		$labels = array(
		
			'name' => __('Ratings', 'btoa'),
			'singular_name' => __('Rating', 'btoa'),
			'add_new' => __('Add New', 'btoa'),
			'add_new_item' => __('Add New Rating', 'btoa'),
			'edit_item' => __('Edit Rating', 'btoa'),
			'new_item' => __('New Rating', 'btoa'),
			'all_items' => __('All Ratings', 'btoa'),
			'view_item' =>__('View Rating', 'btoa'),
			'search_items' => __('Search Ratings', 'btoa'),
			'not_found' =>  __('No Ratings Found', 'btoa'),
			'not_found_in_trash' => __('No Ratings found in trash.', 'btoa'),
			'parent_item_colon' => '',
			'menu_name' => 'Ratings'
		
		);
		  
		  
		//// ARGUMENTS
		$args = array(
		
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => true,
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 7,
			'supports' => array('title', 'custom-fields', 'editor')
		  
		);
			
			
		//// CAPABILITIES
		$args['capability_type'] = 'rating';
		$args['capabilities'] = array(
		
			'publish_posts' => 'publish_rating',
			'edit_posts' => 'edit_ratings',
			'edit_others_posts' => 'edit_others_ratings',
			'delete_posts' => 'delete_ratings',
			'delete_others_posts' => 'delete_others_ratings',
			'read_private_posts' => 'read_private_ratings',
			'edit_post' => 'edit_rating',
			'delete_post' => 'delete_rating',
			'read_post' => 'read_rating',
			'edit_page' => 'edit_rating',
		
		);
		  
		
		//// REGISTERS IT
		register_post_type('rating', $args);
		
		///// ADDS CAPABILITIES TO ADMIN ROLE
		$admin = get_role('administrator');
		
		//// IF CAPABILITIES ARE NOT ALREADY THERE
		if(!$admin->has_cap('publish_rating')) {
		
			$admin->add_cap('publish_rating');
			$admin->add_cap('edit_ratings');
			$admin->add_cap('edit_others_ratings');
			$admin->add_cap('delete_ratings');
			$admin->add_cap('delete_others_ratings');
			$admin->add_cap('read_private_ratings');
			$admin->add_cap('edit_rating');
			$admin->add_cap('delete_rating');
			$admin->add_cap('read_rating');
			$admin->add_cap('edit_rating');
		
		}
		
	}


?>