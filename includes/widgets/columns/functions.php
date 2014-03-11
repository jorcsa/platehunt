<?php


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "btoa_columns" );' ) );
	
	
	//// OUR WIDGET CLASS
	class btoa_columns extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'rb_btoa_columns', // BASE ID
				__('Column', ''), // NAME
				array('description' => __('Lets you create a column within a widget area. Always remember to close a column by using the close column widget.', '')) // DESCRIPTION
			
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
			echo '<div class="'.$c_width;
			
			if($c_last == 'on') { echo ' last'; }
			
			echo '">';
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			
			$instance = wp_parse_args((array) $instance, $defaults);
			
			//// OUR FORM ?>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('c_width'); ?>">Column Width:</label> 
                    <select class="widefat" name="<?php echo $this->get_field_name( 'c_width' ); ?>" id="<?php echo $this->get_field_id( 'c_width' ); ?>">
                    
                    	<option value="one-half"<?php if($instance['c_width'] == 'one-half') { echo ' selected="selected"'; } ?>>One Half</option>
                    	<option value="one-third"<?php if($instance['c_width'] == 'one-third') { echo ' selected="selected"'; } ?>>One Third</option>
                    	<option value="two-thirds"<?php if($instance['c_width'] == 'two-thirds') { echo ' selected="selected"'; } ?>>Two Thirds</option>
                    	<option value="one-fourth"<?php if($instance['c_width'] == 'one-fourth') { echo ' selected="selected"'; } ?>>One Fourth</option>
                    	<option value="three-fourths"<?php if($instance['c_width'] == 'one-fourths') { echo ' selected="selected"'; } ?>>Three Fourths</option>
                    
                    </select>
                
                </p>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('c_last'); ?>">Last Column (remove margin):</label> 
                    <input type="checkbox" name="<?php echo $this->get_field_name('c_last'); ?>" id="<?php echo $this->get_field_id('c_last'); ?>" <?php if($instance['c_last'] == 'on') { echo 'checked="checked"'; } ?> style="float: right;" />
                
                </p>
            
            <?php
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// SAVE FUNCTION
		public function update($new, $old) {
			
			//// NEW INSTANCE ARRAY
			$instance = array();
			
			//// OUR FIELDS
			$instance['c_width'] = strip_tags($new['c_width']);
			$instance['c_last'] = strip_tags($new['c_last']);
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "btoa_columns_close" );' ) );
	
	
	//// OUR WIDGET CLASS
	class btoa_columns_close extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'rb_btoa_columns_close', // BASE ID
				__('Close Column', ''), // NAME
				array('description' => __('Close a column you have already opened on your sidebar.', '')) // DESCRIPTION
			
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
			echo '</div>';
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			
			
			
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// SAVE FUNCTION
		public function update($new, $old) {
			
			//// NEW INSTANCE ARRAY
			$instance = array();
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "btoa_columns_clear" );' ) );
	
	
	//// OUR WIDGET CLASS
	class btoa_columns_clear extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'rb_btoa_columns_clear', // BASE ID
				__('Clear Columns', ''), // NAME
				array('description' => __('Clear the float a set of columns', '')) // DESCRIPTION
			
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
			echo '<div class="clear"></div>';
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			
			
			
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// SAVE FUNCTION
		public function update($new, $old) {
			
			//// NEW INSTANCE ARRAY
			$instance = array();
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


?>