<?php


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "popular_spots" );' ) );
	
	
	//// OUR WIDGET CLASS
	class popular_spots extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'rb_popular_spots', // BASE ID
				__('Popular Spots', ''), // NAME
				array('description' => __('Displays popular spots (by page view)', '')) // DESCRIPTION
			
			);
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// FRONT-END FUNCTION
		public function widget($args, $instance) {
			
			global $wpdb, $post;
				
				//// EXTRACT OUR INPUTS
				extract($args);
				extract($instance);
				$total = 0;
				$markup = '<ul class="popular-spots';
				
				if(ddp('lst_logo') == 'on') { $markup .= ' alt-popular-spots'; }
				
				$markup .= '">';
				
				//////////////////////////////////////////////////////
				///// LETS DO OUR ARGUMENTS FOR TAG BASED
				//////////////////////////////////////////////////////
				
				$args = array(
				
					'post_type' => 'spot',
					'posts_per_page' => $count,
					'post_status' => 'publish',
					'post__not_in'          => array( $post->ID ),
					'meta_key' => '_sf_view_count',
					'orderby' => 'meta_value_num',
				
				);
				
				$tQ = new WP_Query($args);
				
				///// IF WE HAVE ENOUGH POSTS
				if($tQ->have_posts()) {
					
					$total = $tQ->found_posts;
					
					while($tQ->have_posts()) { $tQ->the_post();
						
							//// IMAGE 
							$image = btoa_get_featured_image(get_the_ID());
							
							///// OUTPUTS IT
							if($image && !empty($image)) { $markup .= '<li><a href="'.get_permalink().'" title="'.get_the_title().'"><img src="'.ddTimthumb($image, 150, 150).'" alt="'.get_the_title().'" title="'.get_the_title().'" /></a>'; }
							else { $markup .= '<li class="no-image">'; }
								
							$markup .= '<h4><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h4>
								
								<h5><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_post_meta(get_the_ID(), 'slogan', true).'</a></h5>
								
								<div class="clear"></div>
							
							</li>';
						
					} wp_reset_postdata();
					
				}
				
				$markup .= '</ul>';
				
				///// NOW IF WE FOUND SIMILARP OSTS WE SHOW IT
				if($total > 0) {
				
					//// LET'S START OUR OUTPUT
					echo $before_widget;
					
					//// OUR TITLE
					if($title != '') { echo $before_title.$title.$after_title; }
					
					echo $markup;
					
					//// CLOSES OUR ITEM
					echo $after_widget;
				
				}
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			//// OUR DEFAULTS
			$defaults = array(
			
				'count' => '3',
				'title' => 'Popular Spots',
			
			);
			
			$instance = wp_parse_args((array) $instance, $defaults);
			
			//// OUR FORM ?>
            
            
            	<p style="border-bottom: 1px solid #dfdfdf; padding-bottom: 15px; margin-bottom: 15px;">
                
                	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'ultrasharp'); ?></label>
                	<input type="text" value="<?php echo $instance['title']; ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat">
                
                </p>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('count'); ?>">Number of popular spots</label> 
                	<input type="text" value="<?php echo $instance['count']; ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" class="widefat">
                
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
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


?>