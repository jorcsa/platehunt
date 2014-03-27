	<script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			//// WHEN THE USER CHANGES THE GRID VIEW
			jQuery('.listing-view li a')._sf_list_view_click();
			
			//// WHEN THE USER CHANGES THE PER PAGE
			jQuery('#listing-count-form select').change(function() {
				
				jQuery(this).find('option:selected')._sf_change_per_page_view();
				
			});
			
			//// WHEN THE USER CHANGES THE SORT BY
			jQuery('#listing-sort-form select').change(function() {
				
				jQuery(this).find('option:selected')._sf_change_sort_view();
				
			});
			
			//// WHEN THE USER CLICKS PAGINATION
			jQuery('#pagination a')._sf_pagination_click();
			
		});
	
	</script>

    <div id="subheader">
    
		<div class="wrapper">
        
        	<div class="left">
			
				<?php if(ddp('lst_logo') != 'on') : ?>
            
            	<ul class="listing-view border-color-input">
                
                	<li class="border-color-input"><a href="<?php echo _sf_get_list_view_url('Grid'); ?>" class="type-color<?php if(_sf_is_list_view('Grid')) { echo ' current'; } ?>"><i class="icon-th"></i> <?php _e('Grid', 'btoa'); ?></a></li>
                
                	<li class="border-color-input"><a href="<?php echo _sf_get_list_view_url('List'); ?>" class="type-color<?php if(_sf_is_list_view('List')) { echo ' current'; } ?>"><i class="icon-th-list"></i> <?php _e('List', 'btoa'); ?></a></li>
                
                </ul>
                <!-- .listing-view -->
				
				<?php endif; //// ENDS IF WE ARE USING THE LOGO ?>
            
            </div>
            <!-- .left -->
                    
			<?php
            
                //// DOES WITH OUR LISTINGS PER PAGE
                $options = _sf_get_per_page_options();
				
				//// IF WE HAVE MORE THAN ONE
				if(count($options) > 1) :
            
            ?>

                <div class="right type-color" id="listing-count">
                
                    <form id="listing-count-form" action="<?php echo home_url(); ?>" method="get">
                    
                        <label class="type-color"><?php _e('Per Page:', 'btoa'); ?></label>
                        
                        <select name="listing-count">
                        
                        	<?php foreach($options as $option) : ?>
                        
                            	<option value="<?php echo _sf_get_per_page_option($option); ?>"<?php if(_sf_is_per_page($option)) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
                                
                            <?php endforeach; ?>
                        
                        </select>
                        
                    </form>
                    <!-- #listing-srot -->
                    
                
                </div>
                <!-- .center -->
            
            <?php endif; ?>
            
            <div class="<?php if(ddp('lst_logo') == 'on') : ?>left<?php else : ?>center<?php endif; ?> type-color" id="listing-sort">
            
            	<form id="listing-sort-form" action="<?php echo home_url(); ?>" method="get">
					
					<?php
					
						//// IF USER HAS ENABLED SORT BY DISTANCE
						if(ddp('map_geolocation_sort') == 'on') {
							
								$sort_distance = true;
								
								if(isset($_COOKIE['user_latitude'])) { $user_lat = $_COOKIE['user_latitude']; } else { $user_lat = ''; }
								if(isset($_COOKIE['user_longitude'])) { $user_lng = $_COOKIE['user_longitude']; } else { $user_lng = ''; }
							
							?>
							
							<input type="hidden" id="_sf_user_latitude" name="_sf_user_latitude" value="<?php echo $user_lat; ?>" />
							<input type="hidden" id="_sf_user_longitude" name="_sf_user_longitude" value="<?php echo $user_lng; ?>" />
							
						<?php }
					
					?>
                
            		<label class="type-color"><?php _e('Sort By:', 'btoa'); ?></label>
                    
                    <select name="listing-sort">
                    
                    	<option value="<?php echo _sf_get_list_sort_url('relevant'); ?>"<?php if(_sf_is_sort_by('relevant')) { echo ' selected="selected"'; } ?>><?php _e('Most Relevant', 'btoa'); ?></option>
                    	<option id="_sf_user_select_distance_sort" value="<?php echo _sf_get_list_sort_url('closest'); ?>"<?php if(_sf_is_sort_by('closest')) { echo ' selected="selected"'; } ?>><?php _e('Distance (Closest First)', 'btoa'); ?></option>
                    	<option value="<?php echo _sf_get_list_sort_url('newest'); ?>"<?php if(_sf_is_sort_by('newest')) { echo ' selected="selected"'; } ?>><?php _e('Date (Newest to Oldest)', 'btoa'); ?></option>
                    	<option value="<?php echo _sf_get_list_sort_url('oldest'); ?>"<?php if(_sf_is_sort_by('oldest')) { echo ' selected="selected"'; } ?>><?php _e('Date (Oldest to Newest)', 'btoa'); ?></option>
						
						<?php
						
							///// RATINGS
							if(ddp('rating') == 'on' && ddp('rating_sortby') == 'on') :
						
						?>
						
							<option value="<?php echo _sf_get_list_sort_url('ratingdesc'); ?>"<?php if(_sf_is_sort_by('ratingdesc')) { echo ' selected="selected"'; } ?>><?php _e('Rating (Highest to Lowest)', 'btoa'); ?></option>
							<option value="<?php echo _sf_get_list_sort_url('ratingasc'); ?>"<?php if(_sf_is_sort_by('ratingasc')) { echo ' selected="selected"'; } ?>><?php _e('Rating (Lowest to Highest)', 'btoa'); ?></option>
						
						<?php endif; ?>
						
						<?php
						
							//// LETS GET ALL SEARCH FIELDS THAT HAVE SORT BY ENABLED
							$args = array(
							
								'post_type' => 'search_field',
								'meta_query' => array(
								
									array(
									
										'key' => 'enable_sort',
										'value' => 'on',
									
									),
									
									array(
									
										'key' => 'field_type',
										'value' => array('range', 'min_val', 'max_val'),
										'compare' => 'IN',
									
									)
								
								),
								'posts_per_page' => -1,
							
							);
							
							$sortQ = new WP_Query($args);
							
							if($sortQ->have_posts()) : while($sortQ->have_posts()) : $sortQ->the_post();
							
								$slug = $post->post_name;
								
								$option_title = get_the_title();
								
								///// CHECKS FOR WPML AND IF SO GET THE TRANSLATION OF THIS FIELD
								global $sitepress;
								if(isset($sitepress)) {
									
									//// GETS THE TRANSLATED TITLE VALUE
									$translated_value = get_post_meta(get_the_ID(), 'title_'.ICL_LANGUAGE_CODE, true);
									
									//// IF IT IS SET
									if($translated_value != '') { $option_title = $translated_value; }
									
								}
						
						?>
						
							<option value="<?php echo _sf_get_list_sort_url($slug.'_low'); ?>"<?php if(_sf_is_sort_by($slug.'_low')) { echo ' selected="selected"'; } ?>><?php echo $option_title; ?> <?php _e('(Lowest to Highest)', 'btoa'); ?></option>
							<option value="<?php echo _sf_get_list_sort_url($slug.'_high'); ?>"<?php if(_sf_is_sort_by($slug.'_high')) { echo ' selected="selected"'; } ?>><?php echo $option_title; ?> <?php _e('(Highest to Lowest)', 'btoa'); ?></option>
						
						<?php endwhile; wp_reset_postdata(); endif; ?>
                    
                    </select>
					
						<?php if(ddp('map_geolocation_sort') == 'on') : ?>
						<script type="text/javascript">
							
							jQuery(document).ready(function() {
								
								var geolocation_sort = false;
								//// CHECKS FOOR COOKIE FIRST
								var user_latitude = jQuery.cookie('user_latitude');
								var user_longitude = jQuery.cookie('user_longitude');
								
								var the_sort_item_text = jQuery('#_sf_user_select_distance_sort').text();
								var the_sort_item_url = jQuery('#_sf_user_select_distance_sort').val();
								
// DAHERO #1757941 STRT
								//// TRIES TO GET THE USERS POSITION
								if (navigator.geolocation) {
									
									navigator.geolocation.getCurrentPosition(function(position) {
					
										//// SAVES IT IN COOKIES
										jQuery.cookie('user_latitude', position.coords.latitude, { path: '/' });
										jQuery.cookie('user_longitude', position.coords.longitude, { path: '/' });
										geolocation_sort = true;
										
										//// PUTS IT BACK IN
										jQuery('select[name="listing-sort"] option:first').after('<option value="'+the_sort_item_url+'">'+the_sort_item_text+'</option>');
										
									});
									
								} else if (user_latitude != undefined && user_longitude != undefined) {
										geolocation_sort = true;
										//// PUTS IT BACK IN
										jQuery('select[name="listing-sort"] option:first').after('<option value="'+the_sort_item_url+'">'+the_sort_item_text+'</option>');
								}
// DAHERO #1757941 STOP
								//// UPDATES FIELDS
								if(geolocation_sort) {
									
									jQuery('#_sf_user_latitude').val(jQuery.cookie('user_latitude'));
									jQuery('#_sf_user_longitude').val(jQuery.cookie('user_longitude'));
									
								} else { jQuery('#_sf_user_select_distance_sort').remove(); }
								
							});
							
						</script>
						<?php endif; ?>
                    
                </form>
                <!-- #listing-srot -->
               	
            
            </div>
            <!-- .center -->
        
        </div>
        <!-- #subheader .wrapper -->    
    
    </div>
    <!-- #subheader -->