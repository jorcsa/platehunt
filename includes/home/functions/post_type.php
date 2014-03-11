<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// ULTRASHARP THEME — INCLUDES/HOME/FUNCTIONS/POST_TYPE.PHP
//
//// REGISTERS OUR CUSTOM POST TYPE
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////



	//// CREATES OUR SLIDER POST TYPE
	add_action('init', 'btoa_home_post_post_type');	
	
	//// FUNCTION TO CREATE IT
	function btoa_home_post_post_type() {
		
		
		//// LABELS
		$labels = array(
		
			'name' => __('Home Posts', 'btoa'),
			'singular_name' => __('Home Post', 'btoa'),
			'add_new' => __('Add New', 'btoa'),
			'add_new_item' => __('Add New Home Post', 'btoa'),
			'edit_item' => __('Edit Home Post', 'btoa'),
			'new_item' => __('New Home Post', 'btoa'),
			'all_items' => __('All Home Posts', 'btoa'),
			'view_item' =>__('View Home Post', 'btoa'),
			'search_items' => __('Search Home Posts', 'btoa'),
			'not_found' =>  __('No Home Posts Found', 'btoa'),
			'not_found_in_trash' => __('No Home Posts found in trash.', 'btoa'),
			'parent_item_colon' => '',
			'menu_name' => 'Home Posts'
		
		);
		  
		  
		//// ARGUMENTS
		$args = array(
		
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title', 'editor', 'custom-fields', 'thumbnail')
		  
		);
		  
		
		//// REGISTERS IT
		register_post_type('home_posts', $args);
		
	}


?>