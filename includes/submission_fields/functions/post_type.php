<?php



	//// CREATES OUR POST TYPE
	add_action('init', 'btoa_submission_field_post_type');	
	
	//// FUNCTION TO CREATE IT
	function btoa_submission_field_post_type() {
		
		
		//// LABELS
		$labels = array(
		
			'name' => __('Submission Fields', 'btoa'),
			'singular_name' => __('Submission Field', 'btoa'),
			'add_new' => __('Add New', 'btoa'),
			'add_new_item' => __('Add New Submission Field', 'btoa'),
			'edit_item' => __('Edit Submission Field', 'btoa'),
			'new_item' => __('New Submission Field', 'btoa'),
			'all_items' => __('All Submission Fields', 'btoa'),
			'view_item' =>__('View Submission Field', 'btoa'),
			'search_items' => __('Search Submission Fields', 'btoa'),
			'not_found' =>  __('No Submission Fields Found', 'btoa'),
			'not_found_in_trash' => __('No Submission Fields found in trash.', 'btoa'),
			'parent_item_colon' => '',
			'menu_name' => 'Submission Fields'
		
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
			'supports' => array('title', 'custom-fields', 'editor')
		  
		);
			
			
		//// CAPABILITIES
		$args['capability_type'] = 'submission_field';
		$args['capabilities'] = array(
		
			'publish_posts' => 'publish_submission_field',
			'edit_posts' => 'edit_submission_fields',
			'edit_others_posts' => 'edit_others_submission_fields',
			'delete_posts' => 'delete_submission_fields',
			'delete_others_posts' => 'delete_others_submission_fields',
			'read_private_posts' => 'read_private_submission_fields',
			'edit_post' => 'edit_submission_field',
			'delete_post' => 'delete_submission_field',
			'read_post' => 'read_submission_field',
			'edit_page' => 'edit_submission_field',
		
		);
		  
		
		//// REGISTERS IT
		register_post_type('submission_field', $args);
		
		///// ADDS CAPABILITIES TO ADMIN ROLE
		$admin = get_role('administrator');
		//print_r($admin); exit;
		
		//// IF CAPABILITIES ARE NOT ALREADY THERE
		if(!$admin->has_cap('publish_submission_field')) {
		
			$admin->add_cap('publish_submission_field');
			$admin->add_cap('edit_submission_fields');
			$admin->add_cap('edit_others_submission_fields');
			$admin->add_cap('delete_submission_fields');
			$admin->add_cap('delete_others_submission_fields');
			$admin->add_cap('read_private_submission_fields');
			$admin->add_cap('edit_submission_field');
			$admin->add_cap('delete_submission_field');
			$admin->add_cap('read_submission_field');
			$admin->add_cap('edit_submission_field');
		
		}
		
	}


?>