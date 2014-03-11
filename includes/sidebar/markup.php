<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// ULTRASHARP THEME — INCLUDES/SIDEBAR/MARKUP.PHP
//
//// SHOWS THE MARKUP OF OUR SIDEBAR
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
?>


	<div id="sidebar">
                
        <?php
        
            //// DEFINES IF WE'RE USING THE DEFAULT SIDEBAR OR A CUSTOM ONE
            $custom_sidebar = get_post_meta($post->ID, 'page_sidebar', true);
			
			
			
			//// IF IS SEARCH
			if(is_search()) { $custom_sidebar = ddp('search_custom_sidebar'); }
            
            //// IF IT'S THE DEFAULT
            if($custom_sidebar == 'Default' || is_category() || is_tax()) {
				
				
				//// IF IT'S THE BLOG
				if(is_page_template('blog-full.php') || is_page_template('blog-full.php') || is_page_template('blog-medium.php') || is_single() || is_category()) {
                
					//// DISPLAYS THE DEFAULT SIDEBAR — PAGE
					dynamic_sidebar('blog-sidebar');
					
				} elseif(is_page_template('portfolio.php') || is_tax('portfolio_cats')) {
                
					//// DISPLAYS THE DEFAULT SIDEBAR — PORTFOLIO
					dynamic_sidebar('portfolio-sidebar');
					
				}else {
                
					//// DISPLAYS THE DEFAULT SIDEBAR — PAGE
					dynamic_sidebar('page-sidebar');
					
				}
                
            } else {
            //// IF IT'S A CUSTOM SIDEBAR
                
                //// CHECK IF IT EXISTS IN THE DATABASE
                $sidebars = get_option('dd_custom_sidebars');
				$sidebar_exists = false;
				if($sidebars) {
					
					foreach($sidebars as $sidebar) {
						
						if($sidebar == $custom_sidebar) { $sidebar_exists = true; }
					
					}
					
				}
				
				//// IF IT EXISTS
				if($sidebar_exists) {
					
					//// SHOWS OUR DYNAMIC SIDEBAR — WITH THE PROPER NAME
					dynamic_sidebar(us_get_sidebar_id($custom_sidebar));
					
				} else {
					
					////SHOWS THE DEFAULT SIDEBAR
					dynamic_sidebar('page-sidebar');
					
				}
                
            }
        
        ?>
    
    </div>
    <!-- /#sidebar/ -->