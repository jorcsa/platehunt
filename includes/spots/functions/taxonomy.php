<?php



	//// CREATES OUR SLIDER TAXONOMY
	add_action('init', 'create_spot_tags', 0);
	
	//// TAXONOMY FUNCTION
	function create_spot_tags() {
		
		$labels = array(
		
			'name' => __('Tags', 'btoa'),
			'singular_name' => __('Tag', 'btoa'),
			'menu_name' => __('Tags', 'btoa'),
			
		);
		
		 register_taxonomy('spot_tags', 'spot',
		 
		 	array(
		 
				'hierarchical' => false,
				'labels' => $labels,
				'show_ui' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array( 'slug' => 'tag' ),
			
			)
			
		); 
		
		$labels = array(
		
			'name' => __('Categories', 'btoa'),
			'singular_name' => __('Category', 'btoa'),
			'menu_name' => __('Categories', 'btoa'),
			
		);
		
		 register_taxonomy('spot_cats', 'spot',
		 
		 	array(
		 
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array( 'slug' => ddp('spot_cat_slug') ),
			
			)
			
		); 
		
	}
		
		
		//////////////////////////////////////////////////
		//// METABOX ON OUR CATEGORIES
		//////////////////////////////////////////////////
	
		/// ADDS THE HTML INPUT TO OUR TERM
		function add_fields_spot_cats() {
			
			include('meta/metabox-categories.php');
			
		}
		
		/// ADDS OUR ACTION
		add_action('spot_cats_add_form_fields', 'add_fields_spot_cats', 10, 2);
		add_action('spot_tags_add_form_fields', 'add_fields_spot_cats', 10, 2);

		/// ADDS THE HTML INPUT TO OUR TERM
		function edit_fields_spot_cats($term) {
			
			include('meta/metabox-categories-edit.php');
			
		}
		
		/// ADDS OUR ACTION
		add_action('spot_cats_edit_form_fields', 'edit_fields_spot_cats', 10, 2);
		add_action('spot_tags_edit_form_fields', 'edit_fields_spot_cats', 10, 2);
		
		//// SAVES OUR CUSTOM FIELDS
		function save_fields_spot_cats($term_id) {
			
			//// TERM ID
			$t_id = $term_id;
			
			//// ALL META
			$term_meta = get_option('taxonomy_'.$t_id);
			
			/// IF IS ARRAY (PREVENTS AJAX AERRORS
			if(is_array($_POST['term_meta'])) {
			
			//// LOOPS FIELDS AND SAVES THEM
			$cat_keys = array_keys($_POST['term_meta']);
			
		
		//print_r($_POST['term_meta']['related_suburbs']); exit;
		
			foreach ($cat_keys as $key) {
				
				//// OUR FIELD
				$term_meta[$key] = $_POST['term_meta'][$key];
				
			}
			
			if(!isset($_POST['term_meta']['cat_title'])) { $term_meta['cat_title'] = ''; }
			
			//// SAVES OPTION ARRAY
			update_option('taxonomy_'.$t_id, $term_meta);
			
		}
		
		}
		
		/// SAVE ACTION
		add_action('edited_spot_cats', 'save_fields_spot_cats', 10, 2);
		add_action('create_spot_cats', 'save_fields_spot_cats', 10, 2);
		add_action('edited_spot_tags', 'save_fields_spot_cats', 10, 2);
		add_action('create_spot_tags', 'save_fields_spot_cats', 10, 2);



?>