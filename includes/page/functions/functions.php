<?php



	//////////////////////////////////
	//// ADDS OUR SLIDER METABOXES
	//////////////////////////////////
	include('metaboxes.php');



	//////////////////////////////////
	//// OTHER FUNCTIONS
	/////////////////////////////////
	
	
	//// REGISTERS OUR DEFAULT SIDEBAR
	$args = array(
	
		'name' => 'General Sidebar (All Sidebars)',
		'id' => 'general',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	
	);
	
	register_sidebar($args);
	
	
	//// REGISTERS OUR DEFAULT PAGE SIDEBAR
	$args = array(
	
		'name' => 'Page Sidebar',
		'id' => 'page',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	
	);
	
	register_sidebar($args);
	
	
	//// REGISTERS OUR DEFAULT PAGE SIDEBAR
	$args = array(
	
		'name' => '404 Sidebar',
		'id' => '404',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	
	);
	
	register_sidebar($args);
	
	
	//// REGISTERS OUR DEFAULT PAGE SIDEBAR
	$args = array(
	
		'name' => 'Search Sidebar',
		'id' => 'search',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	
	);
	
	register_sidebar($args);
	
	
	//// GETS PAGE SIDEBAR
	function get_page_sidebar($post_id) {
		
		$page_sidebar = get_post_meta($post_id, 'sidebar_position', true);
		
		//// IF IS 404 OR SEARCH
		if(is_404() || is_search()) { $page_sidebar = ddp('sidebar_default'); }
		
		if($page_sidebar == 'default' || $page_sidebar == '') { $page_sidebar = ddp('sidebar_default'); }
		
		return $page_sidebar;
		
	}
	
	
	//// GETS PAGE SIZE
	function get_page_layout($post_id) {
	
		$page_sidebar = get_page_sidebar($post_id);
		
		//// IF TAXONOMY GET PROPERTIES PAGE LAYOUT
		if(is_tax('spot_cats')) {
			
			$args = array('post_type' => 'page','meta_key' => '_wp_page_template','meta_value' => 'listings.php');
			$pageQuery = new WP_Query($args);
			
			if($pageQuery->found_posts > 0) { 
			
				while($pageQuery->have_posts()) { $pageQuery->the_post(); $page_sidebar = get_page_sidebar(get_the_ID()); break; } wp_reset_postdata();
			
			}
			
		}
						
		switch($page_sidebar) {
			
			case 'Left Side':
				$layout = 'left';
				break;
			
			case 'Right Side':
				$layout = 'right';
				break;
			
			case 'Both Sidebars':
				$layout = 'both';
				break;
			
			case 'No Sidebar (Full Width)':
				$layout = 'none';
				break;
				
			default:
				$layout = 'none';
				break;
			
		}
		
		return $layout;
		
	}
	
	//// GET SIDEBAR ID
	function get_page_custom_sidebar($post_id, $default) {
		
		dynamic_sidebar('general');
		
		if(get_post_meta($post_id, 'page_sidebar', true) == 'Default' || !get_post_meta($post_id, 'page_sidebar', true)) { dynamic_sidebar($default); }
		else { dynamic_sidebar(get_post_meta($post_id, 'page_sidebar', true)); }
		
	}
	
	//// GETS HEADER BG
	function get_page_header_bg($post_id = '') {
		
		//// TRIES THE CUSTOM META
		$bg = get_post_meta($post_id, 'header_bg', true);
		
		if($bg == '') {
			$bg = ddp('header_bg');
		}
		
		return $bg;
		
	}
	
	
	///// THIS FILTER TAKES CARE OF OUR SUBMIT PAGE WHEN WE HAVE A DIFFERENT TITLE FOR WHEN THE USER  wp_page_menu
	add_filter('the_title', 'sf_submit_page_title_logged_in', 10 , 2);
	add_filter('wp_setup_nav_menu_item', 'sf_submit_page_title_logged_in_menu', 10 , 2);
	
	function sf_submit_page_title_logged_in($title, $post_id) {
		
		//// IF IT'S OUR SUBMIT PAGE
		if(get_post_type($post_id) == 'page') {
			
			if(get_post_meta($post_id, '_wp_page_template', true) == 'login.php') {
				
				//// HCECKS IF ITS SET
				if(get_post_meta($post_id, 'submit_loggedin', true) != '' && is_user_logged_in() && !is_admin()) {
					
					$title = get_post_meta($post_id, 'submit_loggedin', true);
					
				}
				
			}
			
		}
		
		return $title;
		
	}
	
	function sf_submit_page_title_logged_in_menu($menu_item) {
		
		///// IF ITS A PAGE
		if($menu_item->type == 'post_type' && $menu_item->type_label == 'Page') {
			
			//// ITS A PAGE
			if(isset($menu_item->object_id)) {
				
				if(get_post_type($menu_item->object_id) == 'page') {
			
					if(get_post_meta($menu_item->object_id, '_wp_page_template', true) == 'login.php') {
						
						//// HCECKS IF ITS SET
						if(get_post_meta($menu_item->object_id, 'submit_loggedin', true) != '' && is_user_logged_in() && !is_admin()) {
							
							$menu_item->title = get_post_meta($menu_item->object_id, 'submit_loggedin', true);
							
						}
						
					}
					
					
				}
				
			}
			
		}
		
		return $menu_item;
		
	}


?>