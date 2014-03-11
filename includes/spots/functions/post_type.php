<?php



	//// CREATES OUR POST TYPE
	add_action('init', 'btoa_spots_post_type');	
	
	//// FUNCTION TO CREATE IT
	function btoa_spots_post_type() {
		
		
		//// LABELS
		$labels = array(
		
			'name' => ddp('spot_name_p'),
			'singular_name' => ddp('spot_name'),
			'add_new' => __('Add New ', 'btoa').ddp('spot_name'),
			'add_new_item' => __('Add New ', 'btoa').ddp('spot_name'),
			'edit_item' => __('Edit ', 'btoa').ddp('spot_name'),
			'new_item' => __('New ', 'btoa').ddp('spot_name'),
			'all_items' => __('All ', 'btoa').ddp('spot_name_p'),
			'view_item' =>__('View ', 'btoa').ddp('spot_name'),
			'search_items' => __('Search ', 'btoa').ddp('spot_name_p'),
			'not_found' =>  __('No ', 'btoa').ddp('spot_name_p').' Found',
			'not_found_in_trash' => __('No ', 'btoa').ddp('spot_name_p').' found in trash',
			'parent_item_colon' => '',
			'menu_name' => ddp('spot_name_p')
		
		);
		  
		  
		//// ARGUMENTS
		$args = array(
		
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array(
			
				'slug' => ddp('spot_slug'),
			
			),
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 7,
			'supports' => array('title', 'custom-fields', 'editor', 'author', 'thumbnail', 'excerpt')
		  
		);
			
			
		//// CAPABILITIES
		$args['capability_type'] = 'spot';
		$args['capabilities'] = array(
		
			'publish_posts' => 'publish_spot',
			'edit_posts' => 'edit_spots',
			'edit_others_posts' => 'edit_others_spots',
			'delete_posts' => 'delete_spots',
			'delete_others_posts' => 'delete_others_spots',
			'read_private_posts' => 'read_private_spots',
			'edit_post' => 'edit_spot',
			'delete_post' => 'delete_spot',
			'read_post' => 'read_spot',
			'edit_page' => 'edit_spot',
		
		);
		  
		
		//// REGISTERS IT
		register_post_type('spot', $args);
		
		///// ADDS CAPABILITIES TO ADMIN ROLE
		$admin = get_role('administrator');
		//print_r($admin); exit;
		
		//// IF CAPABILITIES ARE NOT ALREADY THERE
		if(!$admin->has_cap('publish_spot')) {
		
			$admin->add_cap('publish_spot');
			$admin->add_cap('edit_spots');
			$admin->add_cap('edit_others_spots');
			$admin->add_cap('delete_spots');
			$admin->add_cap('delete_others_spots');
			$admin->add_cap('read_private_spots');
			$admin->add_cap('edit_spot');
			$admin->add_cap('delete_spot');
			$admin->add_cap('read_spot');
			$admin->add_cap('edit_spot');
		
		}
		
	}


?>