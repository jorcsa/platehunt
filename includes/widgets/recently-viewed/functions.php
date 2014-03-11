<?php


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "rb_latest_properties" );' ) );
	
	
	//// OUR WIDGET CLASS
	class rb_latest_properties extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'rb_latest_properties_view', // BASE ID
				__('Recently Viewed Spots', ''), // NAME
				array('description' => __('Shows recently viewed spots by the user', '')) // DESCRIPTION
			
			);
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// FRONT-END FUNCTION
		public function widget($args, $instance) {
			
			global $wpdb, $post;
			
			//// EXTRACT OUR INPUTS
			extract($args);
			extract($instance);
			
			//// READ OUR COOKIE
			$properties = unserialize($_COOKIE['viewed_spot']);
			
			if($count == '') { $count = 10; }
			
			//// IF WE HAVE VIEWED AT LEASE ONE PROPERTY THAT'S NOT THE CURRENT ONE
			if(count($properties) >= 1 && is_array($properties)) {
				
				//// MAKRE SURE IF WE HAVE ONE, ITS NOT THE ONE WE'RE SEEING
				if(count($properties) == 1 && $post->ID == $properties[0]) { $error = true; } else { $error = false; }
				
				if($error == false) {
			
					echo $before_widget;
					
					//// OUR TITLE
					if($title != '') { echo $before_title.$title.$after_title; }
					
					echo '<ul class="recently-viewed">';
					
					//// LETS GET OUR PROPERTIES
					$theI = 1;
			
					foreach($properties as $p_id) {
						
						if(is_singular('spot') && $p_id == $post->ID) { $error = true; }
						else { $error = false; }
						
						if($this_post = get_post($p_id)) { 
						
							if(get_post_type($this_post) == 'spot' && $this_post->post_status == 'publish') {  }
							else { $error = true; }
						
						}
						else { $error = true; }
						
						//// IF ITS NOT OUR CURRENT ITEM
						if($error == false) {
						
							$image = btoa_get_featured_image($p_id);
							
							/// IF ITS UNDER OUR COUNT
							if($theI <= $count) {
							
								///// OUTPUTS IT
								if($image && !empty($image)) { echo '<li><a href="'.get_permalink($p_id).'" title="'.get_the_title($p_id).'"><img src="'.ddTimthumb($image, 150, 150).'" alt="'.get_the_title($p_id).'" title="'.get_the_title($p_id).'" /></a>'; }
								else { echo '<li class="no-image">'; }
								
								echo '
									
									<h4><a href="'.get_permalink($p_id).'" title="'.get_the_title($p_id).'">'.get_the_title($p_id).'</a></h4>
									
									<h5><a href="'.get_permalink($p_id).'" title="'.get_the_title($p_id).'">'.get_post_meta($p_id, 'slogan', true).'</a></h5>
									
									<div class="clear"></div>
								
								</li>';
								
							}
							
							$theI++;
						
						}
						
					}
					
					echo '</ul>';
					
					echo $after_widget;
					
				}
			
			}
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			$defaults = array(
			
				'count' => '3',
				'title' => 'Recently Viewed Spots',
			
			);
			
			
			$instance = wp_parse_args((array) $instance, $defaults);
			
			//// OUR FORM ?>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
                	<input type="text" value="<?php echo $instance['title']; ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat">
                
                </p>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('count'); ?>">Number of Spots:</label> 
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
			$instance['title'] = strip_tags($new['title']);
			$instance['count'] = strip_tags($new['count']);
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


?>