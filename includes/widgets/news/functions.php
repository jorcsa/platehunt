<?php


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "latest_news" );' ) );
	
	
	//// OUR WIDGET CLASS
	class latest_news extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'rb_latest_news', // BASE ID
				__('Latest News', ''), // NAME
				array('description' => __('Displays latest news', '')) // DESCRIPTION
			
			);
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// FRONT-END FUNCTION
		public function widget($args, $instance) {
			
			global $wpdb, $post;
			
			//// EXTRACT OUR INPUTS
			extract($args);
			extract($instance);
			
			//// LET'S START OUR OUTPUT
			echo $before_widget;
			
			//// OUR TITLE
			if($title != '') { echo $before_title.$title.$after_title; }
			
			//// STARTS OUR LOOP
			$args = array(
			
				'post_type' => 'post',
				'posts_per_page' => $count,
			
			);
			
			if($no_cats != 'all') { $args['cat'] = $no_cats; }
			
			//// LOOPS POSTS
			$newsQ = new WP_Query($args);
			
			
			echo '<ul class="latest-news">';
			
			while($newsQ->have_posts()) : $newsQ->the_post();
			
			$featured = getFeaturedImage(get_the_ID());
			
				echo '<li>';
                            
                            	if($featured[0] != '') { echo '<a href="'.get_permalink().'" title="'.get_the_title().'" class="news-image"><img src="'.ddTimthumb($featured[0], 150, 150).'" alt="'.get_the_title().'" title="'.get_the_title().'" /></a>'; }
                                
                                echo '<h5><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h5>
								
								<h6>';
								
								the_category(', ');
								
								echo '</h6>
                                
                                <div class="clear"></div>
                            
                            </li>
                            <!-- /.news-item/ -->';
				
			
			endwhile; wp_reset_postdata();
                        
             echo '</ul>
                        <!-- /.suburbs/ -->';
			
			//// CLOSES OUR ITEM
			echo $after_widget;
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			//// OUR DEFAULTS
			$defaults = array(
			
				'count' => '3',
				'title' => 'Latest News',
				'no_cats' => '',
			
			);
			
			$instance = wp_parse_args((array) $instance, $defaults);
			
			//// OUR FORM ?>
            
            
            	<p style="border-bottom: 1px solid #dfdfdf; padding-bottom: 15px; margin-bottom: 15px;">
                
                	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'ultrasharp'); ?></label>
                	<input type="text" value="<?php echo $instance['title']; ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat">
                
                </p>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('count'); ?>">Number of latest News</label> 
                	<input type="text" value="<?php echo $instance['count']; ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" class="widefat">
                
                </p>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('no_cats'); ?>">Category:</label> 
                    <select class="widefat" name="<?php echo $this->get_field_name( 'no_cats' ); ?>" id="<?php echo $this->get_field_id( 'no_cats' ); ?>">
                    
                    	<option value="any"<?php if($instance['no_cats'] == 'any') { echo ' selected="selected"'; } ?>>Any</option>
                    
                    	<?php
						
							foreach(get_categories() as $cat) { ?>
								
								<option value="<?php echo $cat->term_id ?>"<?php if($cat->term_id == $instance['no_cats']) { echo ' selected="selected"'; } ?>><?php echo $cat->name ?></option>
								
							<?php }
						
						?>
                    
                    </select>
                
                </p>
            
            <?php
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// SAVE FUNCTION
		public function update($new, $old) {
			
			//// NEW INSTANCE ARRAY
			$instance = array();
			
			//// OUR FIELDS
			$instance['count'] = strip_tags($new['count']);
			$instance['title'] = strip_tags($new['title']);
			$instance['no_cats'] = strip_tags($new['no_cats']);
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


?>