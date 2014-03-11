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
						
			global $paged;
		
		?>
        
        <div id="content">
        
        	<div class="wrapper row">
            
            	<div id="main-content" class="sidebar-<?php echo $page_layout; ?> <?php echo $content_class; ?>">
                
                	<h1 class="page-title" style="margin-bottom: 0;"><?php the_title(); ?></h1>
                
                	<?php
								
						//////////////////////////////////////////////////////
						//// LET'S START LOOPING OUR BLOG POSTS
						//////////////////////////////////////////////////////
						
						if(have_posts()) : while(have_posts()) : the_post();
						
						//// OUR FEATURED IMAGE
						$featured_image = getFeaturedImage(get_the_ID());
						
						$content_class = '';
					
					?>
                                
                          <div class="post blog-post" id="post-<?php the_id(); ?>">
                          
                              <?php if($featured_image[0] != '') : //$content_class = 'has_image'; //// IF WE HAVE A FEATURED IMAGE ?>
                                  
                                  <div class="post-image"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo ddTimthumb($featured_image[0], 900, 400); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a></div>
                                  <!-- /.featured-image/ -->
                              
                              <?php endif; ?>
                                            
                              <div class="<?php echo $content_class; ?> post-content">
							  
							  <?php if(is_sticky()) : ?><h5 class="sticky"><span><?php _e('Sticky', 'btoa'); ?></h5></span><?php endif; ?>
                              
                                  <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                  
                                  <div class="post-info secondary-color">
                                  
                                      <span class="date"><strong><?php _e('On', 'btoa'); ?></strong> <?php the_time(get_option('date_format')); ?></span>
                                      <span class="author"><strong><?php _e('By:', 'btoa'); ?> </strong><?php the_author(); ?></span>
                                      
                                      
                                      
                                      <?php if(has_tag()) : ?><span class="tags"><?php the_tags(__('<strong>Tags:</strong> ', ', ', '')); ?></span><?php endif; ?>
                                      
                                  
                                  </div>
                                  <!-- /.post-info/ -->
                                  
                                 <p><?php the_excerpt(); ?></p>
                                 
                                 <p><a href="<?php the_permalink(); ?>" class="button-primary"><?php _e('Read more &rarr;', 'btoa'); ?></a></p>
                              
                              </div>
                              <!-- /.post-content/ -->
                                    
                          </div>
                          <!-- /.post/ -->
                    
                    <?php endwhile; wp_reset_postdata(); ?>
                        
                        <ul id="pagination" class="border-color-input">
                                        
                            <?php
                    
                                //PAGINATION
                                include(locate_template('includes/general/wp-pagenavi.php'));
                                if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
                            
                            ?>
                        
                        </ul>
                        <!-- /#pagination/ -->
                    
                    <?php else : ?>
                    
                    	<h2><?php _e('No posts found.', 'btoa'); ?></h2>
                    
                    <?php endif; ?>
                
                </div>
                <!-- /#main-content/ -->
                
                <?php 
				
					//// LEFT SIDEBAR IF IS SET
					if($page_layout == 'left') {
						
						echo '<div id="sidebar-left" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'search');
						echo '</div>';
						
					}
				
					//// RIGHT SIDEBAR IF IS SET
					if($page_layout == 'right') {
						
						echo '<div id="sidebar-right" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'search');
						echo '</div>';
						
					}
					
						
				?>
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->



	
<!-- /FOOTER STARTS/ -->
<?php get_footer(); ?>