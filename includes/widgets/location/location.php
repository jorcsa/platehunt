<?php


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "sf_location" );' ) );
	
	
	//// OUR WIDGET CLASS
	class sf_location extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'sf_location', // BASE ID
				__('Listing Location', 'ultrasharp'), // NAME
				array('description' => __('Shows listing location on a map. Displayed on a single listing page only', 'ultrasharp')) // DESCRIPTION
			
			);
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// FRONT-END FUNCTION
		public function widget($args, $instance) {
			
			global $wpdb, $post;
			
			//// EXTRACT OUR INPUTS
			extract($args);
			extract($instance);
			
			if(is_singular() && get_post_type() == 'spot') {
			
				//// LET'S START OUR OUTPUT
				echo $before_widget;
				
				//// OUR TITLE
				if($title != '') { echo $before_title.$title.$after_title; } ?>
				
				<script type="text/javascript">
				
					jQuery(document).ready(function() {
						
						jQuery('#listing-location').gmap3({
							
							map: {
								
								options: {
									
									zoom: 15,
									center: new google.maps.LatLng(<?php echo get_post_meta(get_the_ID(), 'latitude', true); ?>, <?php echo get_post_meta(get_the_ID(), 'longitude', true); ?>),
									disableDefaultUI: true,
									zoomControl: true
									
								}
								
							},
							
							marker: {
								
								options: {
									
									position: [<?php echo get_post_meta(get_the_ID(), 'latitude', true); ?>, <?php echo get_post_meta(get_the_ID(), 'longitude', true); ?>],
									icon: '<?php echo get_spot_pin($post->ID) ?>'
									
								},
								callback: function(marker) {
					
									<?php if(ddp('map_pin_twox') == 'on') : ?>
											
									//// LETS SET THE ICON WITH THE PROPER WIDTH AND HEIGHT
									marker.setIcon({
										
										url: 			'<?php echo get_spot_pin($post->ID) ?>',
										scaledSize:	new google.maps.Size(parseInt(<?php echo ddp('map_pin_2x_width'); ?>), parseInt(<?php echo ddp('map_pin_2x_height'); ?>)),
										
									});
									
									<?php endif; ?>
									
								}
								
							}
							
						});
						
					});
				
				</script>
				
				<div id="listing-location"></div>
				
				<?php //// CLOSES OUR ITEM
				echo $after_widget;
			
			}
			
			
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
                
                	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'btoa'); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
                
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
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


?>