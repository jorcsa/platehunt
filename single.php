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
        
        	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            
            	<div id="main-content" <?php post_class(array('sidebar-'.$page_layout, $content_class)) ?>>
				
					<?php if(is_sticky()) : ?><h5 class="sticky"><span><?php _e('Sticky', 'btoa'); ?></h5></span><?php endif; ?>
                
                	<?php if(get_post_meta(get_the_ID(), 'page_title', true) == 'on' || (get_post_meta(get_the_ID(), 'header_title', true) == '' && get_post_meta(get_the_ID(), 'fancy_slogan', true) == '')) : ?><h1 class="page-title"><?php the_title(); ?><?php if(get_post_meta(get_the_ID(), 'slogan', true) != '') : ?> <small><?php echo get_post_meta(get_the_ID(), 'slogan', true); ?></small><?php endif; ?></h1><?php endif; ?>
                
                	<?php the_content(); ?>
				
				
					 <?php 
					 
						$args = array(
							'before' => '<div id="page-pagination">',
							'after' => '</div>',
							'link_before' => '<span>',
							'link_after' => '</span>',
							'next_or_number' => 'number',
							'pagelink' => '%',
						);
						
						wp_link_pages( $args );
						
					?>
                        
                    <?php comments_template(); //// COMMENTS ?>
                
                </div>
                <!-- /#main-content/ -->
                
                <?php 
				
					//// LEFT SIDEBAR IF IS SET
					if($page_layout == 'left') {
						
						echo '<div id="sidebar-left" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'blog');
						echo '</div>';
						
					}
				
					//// RIGHT SIDEBAR IF IS SET
					if($page_layout == 'right') {
						
						echo '<div id="sidebar-right" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'blog');
						echo '</div>';
						
					}
					
						
				?>
            
            <?php endwhile; endif; ?>
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->

	
<!-- /FOOTER STARTS/ -->
<?php get_footer(); ?>