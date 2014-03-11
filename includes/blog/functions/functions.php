<?php



	//////////////////////////////////
	//// ADDS OUR SLIDER METABOXES
	//////////////////////////////////
	include('metaboxes.php');



	//////////////////////////////////
	//// ADDS HELP TABS TO THE PAGE SECTION
	//////////////////////////////////
	//include('help.php');



	//////////////////////////////////
	//// OTHER FUNCTIONS
	/////////////////////////////////
	
	register_sidebar($args);
	
	
	//// REGISTERS OUR DEFAULT PAGE SIDEBAR
	$args = array(
	
		'name' => 'Default Blog/News Sidebar',
		'id' => 'blog',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	
	);
	
	register_sidebar($args);
	
	
	//// RETURNS OUR SIDEBAR POSITION
	function us_get_blog_sidebar_position($pos) {
		
		//// IF IT'S RIGHT OR LEFT
		if($pos == 'left' || $pos == 'right') {
			
			return 'sidebar-'.$pos;
			
		} else { //// ANYTHING ELSE — FULL WIDTH
			
			return 'full-width';
			
		}
		
	}
	
	//// RETURNS OUR FEATURED IMAGE
	function us_get_featured_image($post_ID) {  
		$post_thumbnail_id = get_post_thumbnail_id($post_ID);  
		if ($post_thumbnail_id) {  
			$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');  
			return $post_thumbnail_img[0];  
		}  
	} 
	
	////////////////////////////////////////////////////////////
	//// LET'S ADD THE FEATURED IMAGE IN OUR POST LIST
	////////////////////////////////////////////////////////////
	
	//// ADDS COLUMN
	function us_columns_head($defaults) { 
	 
		$defaults['featured_image'] = 'Featured Image';  
		return $defaults;  
	} 
	
	//// THE COLUMN CONTENT
	function us_columns_content($column_name, $post_ID) {
		
		if ($column_name == 'featured_image') {  
			$post_featured_image = btoa_get_featured_image($post_ID);  
			if ($post_featured_image) {  
				echo '<img src="'.ddTimthumb($post_featured_image, 200, 100).'" />';  
			} else {
				echo '<img src="'.get_template_directory_uri().'/includes/backend/images/no_featured_image.gif" />';  
			}
		}
		
	}
	
	//// REGISTER OUR STYLES ON FEATURED IMAGE COLUMN AND PUTS IN OUR ADMIN PAGE
	function us_columns_style_register() {
		wp_register_style('FeaturedImageColumnStyle', get_template_directory_uri().'/includes/backend/css/featuredImageColumn.css');
		wp_enqueue_style('FeaturedImageColumnStyle');
	}
	
	///// BLOG POSTS AND SPOTS ONLY
	
	//// ADDS OUR HEAD
	add_filter('manage_post_posts_columns', 'us_columns_head');  
	add_filter('manage_spot_posts_columns', 'us_columns_head');  
	//// ADDS THE FEATURED IMAGE TO THE CONTENT
	add_action('manage_post_posts_custom_column', 'us_columns_content', 10, 2);
	add_action('manage_spot_posts_custom_column', 'us_columns_content', 10, 2);
	//// ADDS STYLE IN OUR HEAD SO THE FEATURED IMAGE COLUMN LOOKS IN PLACE
	add_action('admin_init', 'us_columns_style_register');


?>