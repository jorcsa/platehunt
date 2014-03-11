<?php


	//// CREATES OUR SLIDER TAXONOMY
	add_action('init', 'create_rating_taxonomy', 0);
	
	function create_rating_taxonomy() {
		
		$labels = array(
		
			'name' => __('Rating Fields', 'btoa'),
			'singular_name' => __('Rating Field', 'btoa'),
			'menu_name' => __('Rating Fields', 'btoa'),
			
		);
		
		 register_taxonomy('rating_field', 'rating',
		 
		 	array(
		 
				'hierarchical' => true,
				'labels' => $labels,
				'public' => false,
				'show_ui' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array( 'slug' => '_sf_rating_field' ),
			
			)
			
		); 
		
	} /// ENDS REGISTERING OUR TAXONOMY

?>