<?php


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "us_text" );' ) );
	
	
	//// OUR WIDGET CLASS
	class us_text extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'us_text', // BASE ID
				__('Custom - Text', 'ultrasharp'), // NAME
				array('description' => __('Simple text widget that accepts shortcodes.', 'ultrasharp')) // DESCRIPTION
			
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
			
			echo do_shortcode($text);
			
			//// CLOSES OUR ITEM
			echo $after_widget;
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			//// OUR DEFAULTS
			$defaults = array(
			
				'username' => 'envato',
				'count' => '4',
			
			);
			$instance = wp_parse_args((array) $instance, $defaults);
			
			//// OUR FORM ?>
            
            	<p style="border-bottom: 1px solid #dfdfdf; padding-bottom: 15px; margin-bottom: 15px;">
                
                	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ultrasharp'); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
                
                </p>
            
            	<p style=" padding-bottom: 15px; margin-bottom: 15px;">
                
                	<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'ultrasharp'); ?></label> 
                    <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" cols="16" rows="20"><?php echo esc_attr($instance['text']); ?></textarea>
                
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
			$instance['text'] = strip_tags($new['text']);
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


?>