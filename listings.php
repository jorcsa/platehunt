<?php /*

	Template Name: Listings Page

*/ ?><?php get_header(); ?>
        
        
        
        <?php
        
            //////////////////////////////////////////////////////
            //// PAGE LAYOUT
            //////////////////////////////////////////////////////
			$page_layout = get_page_layout($post->ID); $page_id = $post->ID;
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
			
			if(ddp('lst_logo') == 'on') { $content_class .= ' spots-alt'; }
			
			
		
		?>
        
        <?php
        
            //////////////////////////////////////////////////////
            //// LISTINGS HEADER
            //////////////////////////////////////////////////////
				
			get_template_part('includes/search/listings', 'header');
		
		?>
        
        <?php
        
            //////////////////////////////////////////////////////
            //// LISTING SUB HEADERS
            //////////////////////////////////////////////////////
				
			get_template_part('includes/search/listings', 'subheader');
		
		?>
        
        <div id="content">
        
        	<div class="wrapper row">
        
        	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            
            	<div id="main-content" class="sidebar-<?php echo $page_layout; ?> <?php echo $content_class; ?>">
                
                	<?php if(get_post_meta(get_the_ID(), 'page_title', true) == 'on') : ?><h1 class="page-title"><?php the_title(); ?><?php if(get_post_meta(get_the_ID(), 'slogan', true) != '') : ?> <small><?php echo get_post_meta(get_the_ID(), 'slogan', true); ?></small><?php endif; ?></h1><?php endif; ?>
                
                	<?php
					
						////// LETS LOOP OUR LISTINGS
						
						////// GETS ARGUMENTS BASED ON URL
						$args = _sf_get_listing_args($_POST);
						
						//echo '<pre>'; print_r($args); exit;
						
						///// OUR QUERY ARGS
						$Q = _sf_get_listing_query($args);
						
						//// IF OUR QUERY IS AN ARRAY IT MEANS WE'RE LOOPING FEATURED POSTS AND NORMAL ONES
						if(is_array($Q)) { $query = $Q[1]; $pagination_query = $Q[0]; }
						else { $query = $Q; $pagination_query = $Q; }
						
						//echo '<pre>'; print_r($Q); exit;
						
						//// IF WE HAVE FOUND LISTINGS
						if($query->have_posts()) :
					
						$i = 1;
					
					?>
                    
                    	<ul id="spots" class="spot-<?php echo _sf_get_list_view(); ?>">
                        
                        	<?php while($query->have_posts()) : $query->the_post(); ?>
                            
                            	<?php include(locate_template('includes/spots/loop.php')); ?>
                            
                            <?php $i++; endwhile; wp_reset_postdata(); ?>
                            
                            
                            
                            <?php if(is_array($Q) && isset($Q[2])) : while($Q[2]->have_posts()) : $Q[2]->the_post(); //// IF OUR QUERY 2 IS SET ?>
                            
                            	<?php include(locate_template('includes/spots/loop.php')); ?>
                            
                            <?php $i++; endwhile; wp_reset_postdata(); endif; ?>
                        
                        </ul>
                        <!-- #spots -->
                        
                        <ul id="pagination" class="border-color-input">
                                        
                            <?php
                    
                                //PAGINATION
                                $temp_query = $wp_query;
                                $wp_query = $pagination_query;
                                include(locate_template('includes/general/wp-pagenavi.php'));
                                if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
                                $wp_query = $temp_query;
                            
                            ?>
                        
                        </ul>
                        <!-- /#pagination/ -->
                    
                    <?php else : //// NO LISTSINGS FOUND ?>
                    
                    	<h1><?php _e('Oops! We couldn\'t find any results.', 'btoa'); ?></h1>
                        
                        <h4><?php _e('Try re-filtering your search or navigate our menu to find what you are looking for.', 'btoa'); ?></h4>
                        
                        <?php if(ddp('future_notification') == 'on') : ?><p><a href="#" class="notify-me"><i class="icon-export"></i> <?php _e('Notify me of future matching submissions', 'btoa'); ?></a></p><?php endif; ?>
                    
                    <?php endif; ?>
                
                </div>
                <!-- /#main-content/ -->
                
                <?php 
				
					//// LEFT SIDEBAR IF IS SET
					if($page_layout == 'left') {
						
						echo '<div id="sidebar-left" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'listings');
						echo '</div>';
						
					}
				
					//// RIGHT SIDEBAR IF IS SET
					if($page_layout == 'right') {
						
						echo '<div id="sidebar-right" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'listings');
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