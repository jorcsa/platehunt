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
			if((get_post_meta($post->ID, 'header_title', true) != '') || get_post_meta($post->ID, 'fancy_slogan', true) != '') {
				
				/// INCLUDES CUSTOM HEADER
				get_template_part('includes/page/custom-header');
				
			}
						
			global $paged;
		
		?>
        
        <div id="content">
        
        	<div class="wrapper row">
            
            	<div id="main-content" class="sidebar-<?php echo $page_layout; ?> <?php echo $content_class; ?>">
                
                	<?php if(get_post_meta(get_the_ID(), 'page_title', true) == 'on' && $paged == 0) : ?><h1 class="page-title" style="margin-bottom: 0;"><?php the_title(); ?><?php if(get_post_meta(get_the_ID(), 'slogan', true) != '') : ?> <small><?php echo get_post_meta(get_the_ID(), 'slogan', true); ?></small><?php endif; ?></h1><?php endif; ?>
                
                	<?php
								
						//////////////////////////////////////////////////////
						//// LET'S START LOOPING OUR BLOG POSTS
						//////////////////////////////////////////////////////
						
						$args = array(
						
							'post_type' => 'post',
							'posts_per_page' => get_option('posts_per_page'),
							'paged' => $paged,
						
						);
						
						$blogQuery = new WP_Query($args);
						
						if($blogQuery->have_posts()) : while($blogQuery->have_posts()) : $blogQuery->the_post();
						
						//// OUR FEATURED IMAGE
						$featured_image = getFeaturedImage(get_the_ID());
						
						$content_class = '';
					
					?>
                                
                          <div <?php post_class('post blog-post') ?> id="post-<?php the_id(); ?>">
                          
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
                                      <span class="comments"><a href="<?php the_permalink() ?>#comments"><?php comments_number(__('<strong>no</strong>', 'ultrasharp'),'<strong>'.__('One', 'btoa').'</strong>','<strong>%</strong>'); ?> <?php comments_number(__('comments', 'ultrasharp'), __('comment', 'ultrasharp'), __('comments', 'ultrasharp')); ?></a></span><br />
                                      <span class="categories"><strong><?php _e('Under', 'btoa'); ?></strong> <?php the_category(', '); ?></span>
                                      
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
                                $temp_query = $wp_query;
                                $wp_query = $blogQuery;
                                include(locate_template('includes/general/wp-pagenavi.php'));
                                if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
                                $wp_query = $temp_query;
                            
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
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->



	
<!-- /FOOTER STARTS/ -->
<?php get_footer(); ?>