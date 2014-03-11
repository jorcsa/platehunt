
<?php get_header(); ?>
        
        
        
        <?php
        
            //////////////////////////////////////////////////////
            //// PAGE LAYOUT
            //////////////////////////////////////////////////////
			$page_layout = get_page_layout($post->ID);
			$content_class = '';
			switch($page_layout) {
				
				case 'right' :
					$content_class = 'large-8 columns';
					break;
				
				case 'left' :
					$content_class = 'large-8 columns';
					break;
				
				default :
					$content_class = 'large-12';
					break;
				
			}
		
		?>
        
        <?php
        
            //////////////////////////////////////////////////////
            //// CUSTOM HEADER
            //////////////////////////////////////////////////////
			if(get_post_meta(get_the_ID(), 'header_bg', true) != '' && (get_post_meta(get_the_ID(), 'header_title', true) != '') || get_post_meta(get_the_ID(), 'fancy_slogan', true) != '') {
				
				/// INCLUDES CUSTOM HEADER
				get_template_part('includes/page/custom-header');
				
			}
		
		?>
        
        <div id="content">
        
        	<div class="wrapper row">
            
            	<div id="main-content" class="sidebar-<?php echo $page_layout; ?> <?php echo $content_class; ?>">
                
                	<h1 class="page-title"><?php _e('404 - Page not Found', 'btoa'); ?></h1>
                
                	<p><strong><?php _e('Oops! Looks like we could not find what you were looking for.', 'btoa'); ?></strong></p>
					
					<p><?php _e('Please re-check your URL or navigate our website using our menu at the top of the page.', 'btoa'); ?></p>
                
                </div>
                <!-- /#main-content/ -->
                
                <?php 
				
					//// LEFT SIDEBAR IF IS SET
					if($page_layout == 'left') {
						
						echo '<div id="sidebar-left" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, '404');
						echo '</div>';
						
					}
				
					//// RIGHT SIDEBAR IF IS SET
					if($page_layout == 'right') {
						
						echo '<div id="sidebar-right" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, '404');
						echo '</div>';
						
					}
					
						
				?>
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->

	
<!-- /FOOTER STARTS/ -->
<?php get_footer(); ?>