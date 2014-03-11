<?php

	$original_post = $post;

	//// OUR VARIABLE
	$field_type = get_post_meta($post->ID, 'field_type', true);
	$text_autoload = get_post_meta($post->ID, 'text_autoload', true);
	$text_type = get_post_meta($post->ID, 'text_type', true);
	$text_default = get_post_meta($post->ID, 'text_default', true);
	$dropdown_change_location = get_post_meta($post->ID, 'dropdown_change_location', true);
	$dependent_change_location = get_post_meta($post->ID, 'dependent_change_location', true);
	$dropdown_values = htmlspecialchars_decode(get_post_meta($post->ID, 'dropdown_values', true));
	$dependent_values = htmlspecialchars_decode(get_post_meta($post->ID, 'dependent_values', true));
	$min_val_values = htmlspecialchars_decode(get_post_meta($post->ID, 'min_val_values', true));
	$max_val_values = htmlspecialchars_decode(get_post_meta($post->ID, 'max_val_values', true));
	$range_minimum = get_post_meta($post->ID, 'range_minimum', true);
	$range_maximum = get_post_meta($post->ID, 'range_maximum', true);
	$range_label = get_post_meta($post->ID, 'range_label', true);
	$range_input = get_post_meta($post->ID, 'range_input', true);
	$range_price = get_post_meta($post->ID, 'range_price', true);
	$enable_sort = get_post_meta($post->ID, 'enable_sort', true);
	$overlay_markup = get_post_meta($post->ID, 'overlay_markup', true);
	$include_overlay = get_post_meta($post->ID, 'include_overlay', true);
	$range_increments = get_post_meta($post->ID, 'range_increments', true);
	$dependent_parent = get_post_meta($post->ID, 'dependent_parent', true);
	$public_field = get_post_meta($post->ID, 'public_field', true);
	$public_field_required = get_post_meta($post->ID, 'public_field_required', true);
	$public_field_selection = get_post_meta($post->ID, 'public_field_selection', true);
	$public_field_description = get_post_meta($post->ID, 'public_field_description', true);
	$public_field_price = get_post_meta($post->ID, 'public_field_price', true);
	$public_field_price_description = get_post_meta($post->ID, 'public_field_price_description', true);
	$public_field_category = get_post_meta($post->ID, 'public_field_category', true);
	if(!is_array($public_field_category)) { $public_field_category = array(); }
	$dropdown_type = get_post_meta($post->ID, 'dropdown_type', true);
	$dropdown_categories = get_post_meta($post->ID, 'dropdown_categories', true);
	$include_rating_overlay = get_post_meta($post->ID, 'include_rating_overlay', true);
	$google_places_api = get_post_meta($post->ID, 'google_places_api', true);
	$google_places_country = get_post_meta($post->ID, 'google_places_country', true);
	$google_places_sensitivity = get_post_meta($post->ID, 'google_places_sensitivity', true);
	
	if(!$field_type || $field_type == '') { $field_type = 'text'; }
	if(!is_array($dropdown_categories)) { $dropdown_categories = array(); }
	
	
	//// IF WPML IS ACTIVE LETS GET THE SITEPRESS GLOBAL
	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
		
		global $sitepress;
		
	}

?>

<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/gmap3.min.js"></script>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?sensor=false'></script>

<div class="bpanel-tabbed-meta">

	<ul class="tabs">
    
    	<li class="bpanel-tab current general" style="padding-left: 30px;">Field Type</li>
    
    	<li class="bpanel-tab atts" style="padding-left: 38px;">Field Attributes</li>
    
    	<li class="bpanel-tab values" style="padding-left: 42px;">Field Values</li>
    
    	<li class="bpanel-tab front-end" style="padding-left: 30px;">Front-End Options</li>
    
    	<li class="bpanel-tab submission" style="padding-left: 30px;">Submission Options</li>
    
    	<li class="bpanel-tab general" id="google-places-api-tab" style="padding-left: 30px; display: none;">Google Places API</li>
    
    </ul>
    <!-- /.tabs/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->
    
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('#post').submit(function(e) {
				
				//// REFRESHES ALL FIELDS
				jQuery('#dependent-values-wrapper > ul').refreshDependentInput();
				jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();
				jQuery('#min_val-values-wrapper ul').refreshMinValInput();
				jQuery('#max_val-values-wrapper ul').refreshMaxValInput();
				
			});
			
			//// CHEKS IF WE ARE USING THE GOOGLE PLACES API
			if(jQuery('#field_type').val() == 'text' && jQuery('#text_type').val() == 'google_places') {
				
				jQuery('#google-places-api-tab').show();
				
			} else { jQuery('#google-places-api-tab').hide(); }
			jQuery('#text_type').change(function() { if(jQuery('#field_type').val() == 'text' && jQuery('#text_type').val() == 'google_places') { jQuery('#google-places-api-tab').show(); } else { jQuery('#google-places-api-tab').hide(); } });
			
			jQuery(document).keydown(function(e) {
				
				if(e.keyCode == 13) {
				
					//// IS USER IS FOCUSED ON ANY OF THESE
					if(jQuery('input:focus').attr('id') == 'add_new_dropdown_name' || jQuery('input:focus').attr('id') == 'add_new_dropdown_latitude' || jQuery('input:focus').attr('id') == 'add_new_dropdown_longitude' || jQuery('input:focus').attr('id') == 'add_new_dropdown_zoom') {
						
						jQuery('#post').submit(function(x) {
							
							if(jQuery('input:focus').attr('id') == 'add_new_dropdown_name' || jQuery('input:focus').attr('id') == 'add_new_dropdown_latitude' || jQuery('input:focus').attr('id') == 'add_new_dropdown_longitude' || jQuery('input:focus').attr('id') == 'add_new_dropdown_zoom') {
							
								x.preventDefault();
								jQuery('#publishing-action .spinner').hide();
								jQuery('#publish').removeAttr("disabled");
							
							}
							
						});
						
						//// SUBMITS THE FIELD
						jQuery('#add_new_dropdown_button').addNewDropDownValue('dropdown-values-wrapper', 'dropdown_values');
						
						return false;
						
					}
				
					//// IS USER IS FOCUSED ON ANY OF THESE
					if(jQuery('input:focus').attr('id') == 'add_new_dependent_name' || jQuery('input:focus').attr('id') == 'add_new_dependent_latitude' || jQuery('input:focus').attr('id') == 'add_new_dependent_longitude' || jQuery('input:focus').attr('id') == 'add_new_dependent_zoom') {
						
						jQuery('#post').submit(function(x) {
							
							if(jQuery('input:focus').attr('id') == 'add_new_dependent_name' || jQuery('input:focus').attr('id') == 'add_new_dependent_latitude' || jQuery('input:focus').attr('id') == 'add_new_dependent_longitude' || jQuery('input:focus').attr('id') == 'add_new_dependent_zoom') {
							
								x.preventDefault();
								jQuery('#publishing-action .spinner').hide();
								jQuery('#publish').removeAttr("disabled");
							
							}
							
						});
						
						//// SUBMITS THE FIELD
						jQuery('#add_new_dependent_button').addNewDependentValue('dependent-values-wrapper', 'dependent_values');
						
						return false;
						
					}
				
					//// IS USER IS FOCUSED ON ANY OF THESE
					if(jQuery('input:focus').attr('id') == 'add_new_min_val_label' || jQuery('input:focus').attr('id') == 'add_new_min_val_value') {
						
						jQuery('#post').submit(function(x) {
							
							if(jQuery('input:focus').attr('id') == 'add_new_min_val_label' || jQuery('input:focus').attr('id') == 'add_new_min_val_value') {
							
								x.preventDefault();
								jQuery('#publishing-action .spinner').hide();
								jQuery('#publish').removeAttr("disabled");
							
							}
							
						});
						
						//// SUBMITS THE FIELD
						jQuery('#add_new_min_val_button').addNewMinValValue('min_val-values-wrapper', 'min_val_values');
						
						return false;
						
					}
				
					//// IS USER IS FOCUSED ON ANY OF THESE
					if(jQuery('input:focus').attr('id') == 'add_new_max_val_label' || jQuery('input:focus').attr('id') == 'add_new_max_val_value') {
						
						jQuery('#post').submit(function(x) {
							
							if(jQuery('input:focus').attr('id') == 'add_new_max_val_label' || jQuery('input:focus').attr('id') == 'add_new_max_val_value') {
							
								x.preventDefault();
								jQuery('#publishing-action .spinner').hide();
								jQuery('#publish').removeAttr("disabled");
							
							}
							
						});
						
						//// SUBMITS THE FIELD
						jQuery('#add_new_max_val_button').addNewMaxValValue('max_val-values-wrapper', 'max_val_values');
						
						return false;
						
					}
				
				}
				
			});
			
			jQuery('#text_autoload').iphoneStyle();
			jQuery('#enable_sort').iphoneStyle();
			jQuery('#dropdown_change_location').iphoneStyle();
			jQuery('#dependent_change_location').iphoneStyle();
			jQuery('#range_input').iphoneStyle();
			jQuery('#range_price').iphoneStyle();
			jQuery('#public_field').iphoneStyle();
			jQuery('#public_field_required').iphoneStyle();
			jQuery('#include_overlay').iphoneStyle();
			jQuery('#include_rating_overlay').iphoneStyle();
			
			jQuery('.bpanel-tabbed-meta .tabs li').click(function() {
				
				if(jQuery(this).attr('class').indexOf('current') == -1) {
					
					var clickedIndex = jQuery(this).index();
					jQuery(this).addClass('current').siblings('.current').removeClass('current');
					
					jQuery(this).parent().siblings('.tabbed').children('li.current').removeClass('current');
					jQuery(this).parent().siblings('.tabbed').children('li:eq('+clickedIndex+')').addClass('current');
					
				}
				
			});
			
			var selectedField = jQuery('#field_type option:selected').val();
			jQuery('.tabbed li .type-'+selectedField).show();
				
				if(selectedField == 'rating') { jQuery('.not-type.type-rating, .bpanel-tabbed-meta ul li.submission').hide(); }
				else { jQuery('.not-type.type-rating, .bpanel-tabbed-meta ul li.submission').show(); }
			
			/// on change
			jQuery('#field_type').change(function() {
				
				var selectedField = jQuery('#field_type option:selected').val();
				jQuery('.tabbed li > .type').hide();
				jQuery('.tabbed li > .type-'+selectedField).show();
				
				if(selectedField == 'rating') { jQuery('.not-type.type-rating, .bpanel-tabbed-meta ul li.submission').hide(); }
				else { jQuery('.not-type.type-rating, .bpanel-tabbed-meta ul li.submission').show(); }
				
			});
			
		});
	
	</script>
    
    <ul class="tabbed">
    
    	<li class="current">
        
        	<div class="one-fifth"><label for="field_type"><?php _e('Field Type', 'btoa'); ?></label></div>
            <div class="two-fifths"><select name="field_type" id="field_type" class="widefat">
            
            	<option value="text"<?php if($field_type == 'text') { echo ' selected="selected"'; } ?>><?php _e('Text Field', 'btoa'); ?></option>
            	<option value="dropdown"<?php if($field_type == 'dropdown') { echo ' selected="selected"'; } ?>><?php _e('Dropdown Field', 'btoa'); ?></option>
            	<option value="min_val"<?php if($field_type == 'min_val') { echo ' selected="selected"'; } ?>><?php _e('Min. Value Field', 'btoa'); ?></option>
            	<option value="max_val"<?php if($field_type == 'max_val') { echo ' selected="selected"'; } ?>><?php _e('Max. Value Field', 'btoa'); ?></option>
            	<option value="range"<?php if($field_type == 'range') { echo ' selected="selected"'; } ?>><?php _e('Range Field', 'btoa'); ?></option>
            	<option value="check"<?php if($field_type == 'check') { echo ' selected="selected"'; } ?>><?php _e('Check Field', 'btoa'); ?></option>
            	<option value="dependent"<?php if($field_type == 'dependent') { echo ' selected="selected"'; } ?>><?php _e('Dependent Dropdown Field', 'btoa'); ?></option>
            	<?php if(ddp('rating')) : ?><option value="rating"<?php if($field_type == 'rating') { echo ' selected="selected"'; } ?>><?php _e('Rating Field', 'btoa'); ?></option><?php endif; ?>
            
            </select></div>
            <div class="two-fifths description last"><?php _e('Type of your search field. ', 'btoa'); ?></div>
            
            <div class="clear"></div>
        
        </li>
        
        <li>
        
        	<div class="type type-text" style="display: none;">
        
                <div class="one-fifth"><label for="text_autoload"><?php _e('Load Suggestions', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="text_autoload" id="text_autoload"<?php if($text_autoload == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('Whether or not to show ajax suggestions as user is entering data.', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="text_default"><?php _e('Default Text', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="text" name="text_default" id="text_default" class="widefat" value="<?php echo $text_default; ?>" />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('Whether or not to show ajax suggestions as user is entering data.', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
				
					<?php
							 
						//// IF THE USER HAS WPML
						if(isset($sitepress)) :
						
							//// IF WE HAVE MORE THAN 1 LANGUAGE
							if(count($sitepress->get_active_languages()) > 1) :
							
								/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
								foreach($sitepress->get_active_languages() as $lang) :
								
									///// IF ITS NOT THE NATIVE LANGUAGE
									if($lang['code'] != $sitepress->get_default_language()) {
										
										$flag = $sitepress->get_flag($lang['code']);
										
										//// GTES THE FLAG URL
										if($flag->from_template) {
											
											$wp_upload_dir = wp_upload_dir();
											$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
											
										} else {
											
											$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
											
										}
							
							?>
						
								<div class="one-fifth"><label for="text_default_<?php echo $lang['code'] ?>"><img src="<?php echo $flag_url ?>" /> &nbsp;<?php _e('Default Text', 'btoa'); ?> (<?php echo $lang['display_name']; ?>)</label></div>
								<div class="two-fifths"><input type="text" name="text_default_<?php echo $lang['code'] ?>" id="text_default_<?php echo $lang['code'] ?>" class="widefat" value="<?php echo get_post_meta(get_the_ID(), 'text_default_'.$lang['code'], true); ?>" />&nbsp;</div>
								<div class="two-fifths description last"><?php _e('Whether or not to show ajax suggestions as user is entering data.', 'btoa'); ?></div>

								<div class="clear"></div>
								<div class="bDivider"></div>
							
							<?php } endforeach; ?>
					 
					 <?php
						
							endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
					 
						endif; /// ENDS IF SITEPRESS
						
					?>
        
                <div class="one-fifth"><label for="text_type"><?php _e('Input Searches For:', 'btoa'); ?></label></div>
                <div class="two-fifths"><select name="text_type" id="text_type">
                
                	<option value="google_places"<?php if($text_type == 'google_places') { echo ' selected="selected"'; } ?>>Google Places API</option>
                	<option value="tags"<?php if($text_type == 'tags') { echo ' selected="selected"'; } ?>>Tags</option>
                
                </select></div>
                <div class="two-fifths description last"><?php _e('This is what the input will search for<br>Keywords searches for content in general such as title and text.<br>WP Tags will search for tags assigned to that spot.', 'btoa'); ?></div>
    
                <div class="clear"></div>
            
            </div>
        
        	<div class="type type-rating" style="display: none;">
        
                <h2 style="margin: 15px;"><?php _e('This input type does not take any attributes', 'btoa'); ?></h2>
    
                <div class="clear"></div>
            
            </div>
        
        	<div class="type type-dropdown" style="display: none;">
        
                <div class="one-fifth"><label for="dropdown_change_location"><?php _e('Change map location upon selecting value', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="dropdown_change_location" id="dropdown_change_location"<?php if($dropdown_change_location == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('Whether the map should change its center when the user select an item', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="dropdown_type"><?php _e('Dropdown Type', 'btoa'); ?></label></div>
                <div class="two-fifths"><select class="widefat" name="dropdown_type" id="dropdown_type">
					
						<option value="custom"<?php if($dropdown_type == 'custom') { echo ' selected="selected"'; } ?>>Custom Values</option>
						<option value="categories"<?php if($dropdown_type == 'categories') { echo ' selected="selected"'; } ?>>Categories</option>
					
					</select></div>
                <div class="two-fifths description last"><?php _e('If Custom Values you need to insert your field values manually. If categories please select them below', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
            
            </div>
			
			<div class="type type-dropdown type-dependent" style="display: none;">
        
                <div class="one-fifth"><label for="dropdown_categories"><?php _e('Dropdown/Dependent Categories', 'btoa'); ?></label></div>
                <div class="two-fifths"><select class="widefat" name="dropdown_categories[]" id="dropdown_categories" multiple>
				
						<option value="all"<?php if(in_array('all', $dropdown_categories) || empty($dropdown_categories)) { echo ' selected="selected"'; } ?>><?php _e('All', 'btoa'); ?></option>
					
						<?php
						
							//// GETS OUR CATEGORIES
							$spot_cats = get_terms('spot_cats', array('hide_empty' => 0, 'orderby' => 'name'));
							
							if(is_array($spot_cats)) : foreach($spot_cats as $_cat) :
						
						?>
						
							<option value="<?php echo $_cat->term_id ?>" <?php if(in_array($_cat->term_id, $dropdown_categories)) { echo ' selected="selected"'; } ?>><?php echo $_cat->name ?></option>
							
						<?php endforeach; endif; ?>
					
					</select></div>
                <div class="two-fifths description last"><?php _e('If you have selected categories as your dropdown type please select the categories you wish to include in yoru dropdown', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
			
			</div>
        
        	<div class="type type-min_val" style="display: none;">
        
                <h2 style="margin: 15px;"><?php _e('This input type does not take any attributes', 'btoa'); ?></h2>
    
                <div class="clear"></div>
            
            </div>
        
        	<div class="type type-max_val" style="display: none;">
        
                <h2 style="margin: 15px;"><?php _e('This input type does not take any attributes', 'btoa'); ?></h2>
    
                <div class="clear"></div>
            
            </div>
        
        	<div class="type type-range" style="display: none;">
        
                <div class="one-fifth"><label for="range_minimum"><?php _e('Minimum Value (Number)', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="number" name="range_minimum" id="range_minimum" value="<?php echo $range_minimum; ?>" /></div>
                <div class="two-fifths description last"><?php _e('Minimum range allowed', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="range_maximum"><?php _e('Maximum Value (Number)', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="number" name="range_maximum" id="range_maximum" value="<?php echo $range_maximum; ?>" /></div>
                <div class="two-fifths description last"><?php _e('Maximum range allowed', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="range_increments"><?php _e('Increment Steps', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="number" name="range_increments" id="range_increments" value="<?php echo $range_increments; ?>" /></div>
                <div class="two-fifths description last"><?php _e('Increments. This will let your slider slide in steps, for instance in multiples of 20.', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="range_label"><?php _e('Label', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="text" name="range_label" id="range_label" value="<?php echo $range_label; ?>" /></div>
                <div class="two-fifths description last"><?php _e('This is the label of your range. Use % sign to represent the number. For example for prices use $%.', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="range_price"><?php _e('Simulate Price', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="range_price" id="range_price"<?php if($range_price == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('If enabled the numbers typed in this field will have commas.', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="range_input"><?php _e('Enable Input', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="range_input" id="range_input"<?php if($range_input == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('If this is enabled the user will be able to insert a value manually without using the slider bar.', 'btoa'); ?></div>
    
                <div class="clear"></div>
            
            </div>
        
        	<div class="type type-check" style="display: none;">
        
                <h2 style="margin: 15px;"><?php _e('This input type does not take any attributes', 'btoa'); ?></h2>
    
                <div class="clear"></div>
            
            </div>
        
        	<div class="type type-dependent" style="display: none;">
        
                <div class="one-fifth"><label for="dependent_change_location"><?php _e('Change map location upon selecting value', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="dependent_change_location" id="dependent_change_location"<?php if($dependent_change_location == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('Whether the map should change its center when the user select an item', 'btoa'); ?></div>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="dependent_parent"><?php _e('Parent Dropdown:', 'btoa'); ?></label></div>
                <div class="two-fifths">
                
                	<?php
					
						//// LETS GET ALL FIELDS WITH THE TYPE DROPDOWN
						$args = array(
						
							'post_type' => 'search_field',
							'meta_query' => array(
							
								array(
								
									'key' => 'field_type',
									'value' => array('dropdown', 'dependent'),
								
								),
							
							),
							'post__not_in' => array($post->ID),
							'posts_per_page' => -1,
						
						);
						
						$dQ = new WP_Query($args);
						
						if($dQ->have_posts()) : ?>
                        
                        	<select name="dependent_parent" id="dependent_parent" class="widefat">
                        
						
						<?php while($dQ->have_posts()) : $dQ->the_post(); ?>
                    
                    		<option value="<?php echo get_the_ID() ?>"<?php if($dependent_parent == get_the_ID()) { echo ' selected="selected"'; } ?>><?php the_title(); ?></option>
                    
						<?php endwhile; wp_reset_postdata(); ?>
                    
                            </select></div>
                            <div class="two-fifths description last"><?php _e('Select the parent dropdown.', 'btoa'); ?></div>
                        
                        
                        <?php else : ?>
                        
                        	<?php _e('You do not have any dropdown fields created.', 'btoa'); ?></div>
                            <div class="two-fifths description last"><?php _e('Select the parent dropdown.', 'btoa'); ?></div>
                        
                        <?php endif; ?>
    
                <div class="clear"></div>
        
        </li>
        
        
        
        
        
        
        
        
        <li>
        
        	<div class="type type-text" style="display: none;"><h2 style="margin: 15px;"><?php _e('This input type does not take any values', 'btoa'); ?></h2></div>
            
            <div class="type type-dependent" style="display: none;">
            
            	<?php if($dependent_parent != '') : ?>
                    
				<?php
                
                    //// LET'S GET ALL DROPDOWNS FROM OUR PARENT DROPDOWN
                    $args = array(
                    
                        'post_type' => 'search_field',
                        'p' => $dependent_parent,
                    
                    );
                    $tQ = new WP_Query($args);
                    while($tQ->have_posts()) { $tQ->the_post(); $parent_field = $post; break; } wp_reset_postdata();
					
					  //// IF ITS A DROPDOWN
					  if(get_post_meta($parent_field->ID, 'field_type', true) == 'dropdown') {
						  
						  $parent_type = 'dropdown';
						  $values = json_decode(htmlspecialchars_decode(get_post_meta($parent_field->ID, 'dropdown_values', true)));
						  
					  } else {
						  
						//// ITS A DEPENDENT  
						$parent_type = 'dependent';
						$_values = json_decode(htmlspecialchars_decode(get_post_meta($parent_field->ID, 'dependent_values', true)));
						
						$values = new stdClass();
						
						$i = 0;
						foreach($_values as $_key => $_value) {
							
							///// FOR EACH SECTION
							foreach($_value as $this_key => $this_value) {
								
								$this_section = $this_value;
								
								$values->$i = $this_section;
								
								$i++;
								
							}
							
						}
						  
					  }
                    
                    //// IF WE HAVE AN OBJECT
                    if(count($values) > 0) : ?>
                    
        
                <div class="one-fifth">
                
                	<label><?php _e('Add New Value', 'btoa'); ?></label>
    
                    <div class="clear"></div>
                    <div class="bDivider"></div>
                                
                    <div id="dependent-values-add-new">
                    
                    	<p><label style="margin-bottom: 4px;">Label</label>
                        <input type="text" class="widefat value_name" value="" id="add_new_dependent_name" /></p>
                    
                    	<p><label style="margin-bottom: 4px;">Parent Item</label>
                        <select class="widefat value_parent">
                        
							<?php foreach($values as $key => $value) : ?>
                            
                            <option value="<?php echo $value->id; ?>"><?php echo $value->label; ?></option>
                            
                            <?php endforeach; ?>
                        
                        </select></p>
                    
                    	<p><label style="margin-bottom: 4px;">Latitude</label>
                        <input type="text" class="widefat value_latitude" value="" id="add_new_dependent_latitude" /></p>
                    
                    	<p><label style="margin-bottom: 4px;">Longitude</label>
                        <input type="text" class="widefat value_longitude" value="" id="add_new_dependent_longitude" /></p>
                    
                    	<p><label style="margin-bottom: 4px;">Zoom</label>
                        <input type="text" class="widefat value_zoom" value="" id="add_new_dependent_zoom" /></p>
                    
                    	<p><label style="margin-bottom: 4px;">Radius (<?php echo ddp('geo_distance_type'); ?>)</label>
                        <input type="text" class="widefat value_radius" value="" id="add_new_dependent_radius" /></p>
											
												
						 <?php
						 
							//// IF THE USER HAS WPML
							if(isset($sitepress)) :
							
								//// IF WE HAVE MORE THAN 1 LANGUAGE
								if(count($sitepress->get_active_languages()) > 1) :
						 
						 ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
							
							<h2><?php _e('Translations', 'btoa'); ?></h2>
							
								<?php
								
									/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
									foreach($sitepress->get_active_languages() as $lang) :
									
										///// IF ITS NOT THE NATIVE LANGUAGE
										if($lang['code'] != $sitepress->get_default_language()) {
											
											$flag = $sitepress->get_flag($lang['code']);
											
											//// GTES THE FLAG URL
											if($flag->from_template) {
												
												$wp_upload_dir = wp_upload_dir();
												$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
												
											} else {
												
												$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
												
											}
								
								?>
								
									<p><label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
									<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="" /></p>
								
								<?php } endforeach; ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
						 
						 <?php
							
								endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
						 
							endif; /// ENDS IF SITEPRESS
							
						?>
                        
                        <input type="button" class="button" value="<?php _e('Insert Value', 'btoa'); ?>" id="add_new_dependent_button" onclick="jQuery(this).addNewDependentValue('dependent-values-wrapper', 'dependent_values');" />
                    
                    </div>
                    
                </div>
                
                <div class="four-fifths last values-dependent" id="dependent-values-wrapper">
                
                	<input type="hidden" value="<?php echo htmlspecialchars($dependent_values); ?>" name="dependent_values" />
                    
                    <ul>
                    
							<script type="text/javascript">
                            
                                jQuery(document).ready(function() {
                                    
                                    jQuery('#dependent-values-wrapper ul ul').sortable({
											
										handle: jQuery('#dependent-values-wrapper ul ul .head'),
										items: '> li',
										connectWith: '.dependent-connect',
										stop: function(ui, event) {
											
											jQuery('#dependent-values-wrapper > ul').refreshDependentInput();
											
										}
                                        
                                    });
                                    
                                });
                            
                            </script>
                            
                            
                            
                            <?php
							
							//// IF PARENT IS NORMAL DROPDOWN
							
							foreach($values as $key => $value) :
						
						?>
                        
                        	<li id="parent-<?php echo $value->id; ?>">
							
                            	<span class="header"><?php echo $value->label; ?></span>
                                
                                <ul class="dependent-connect">
                    
									<?php
                                    
                                        //// GETS THE VALUES AND DISPLAY THEM. IF IS AN ARRAY
                                        $the_values = json_decode($dependent_values);
                                        
                                        /// IF IS AN OBJECT
                                        if(is_object($the_values)) :
                                        
										//// LOOPS THIS UL ONLY
                                        foreach($the_values as $_key => $_value) :
										
										//// MAKE SURE IT BELONGS TO THIS PARENT
										if($_key == $value->id) :
										
										//// NOW LETS ACTUALLU LOOP THE FIELDS
										foreach($_value as $__key => $__value) :
										
                                    
                                    ?>
                                    
                                    <li class="item-id-<?php echo $__value->id ?>">
                                    
                                    	<div class="head" onclick="jQuery(this).openInsider();">
                            
                                            <span class="title"><?php echo $__value->label ?></span>
                                            
                                            <span class="arrow"></span>
                                            <!-- /.arrow/ -->
                                        
                                        </div>
                                        <!-- /.head/ -->
                            
                                        <div class="insider" style="display: none;">
                                        
                                            <label><?php _e('Label', 'btoa'); ?></label>
                                            <input type="text" class="widefat value_name" value="<?php echo $__value->label ?>" onblur="jQuery(this).valueChangeLabel();" />
                                            <em style="margin: 10px 0 0; display: block;"><?php _e('Label of your dropdown', 'btoa'); ?></em>
                
                                            <div class="clear"></div>
                                            <div class="bDivider"></div>
                                            
                                            <label><?php _e('Location Address', 'btoa'); ?></label>
                                            <input type="text" class="widefat value_address" value="<?php echo $__value->address ?>" onblur="jQuery(this).updateLatitudeLongitude();" />
                                            <em style="margin: 5px 0 0; display: block;"><?php _e('Only used in case the options "Change Location" is enabled.', 'btoa'); ?></em>
                                            
                                            <br /><br />
                                            
                                            <div class="one-third"><label><?php _e('Latitude', 'btoa'); ?></label>
                                            <input type="text" class="widefat value_latitude" value="<?php echo $__value->latitude ?>" />
                                            <em style="margin: 5px 0 0; display: block;"><?php _e('Automatically gotten from address input or get it from', 'btoa'); ?> <a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>
                                            
                                            <div class="one-third"><label><?php _e('Longitude', 'btoa'); ?></label>
                                            <input type="text" class="widefat value_longitude" value="<?php echo $__value->longitude ?>" />
                                            <em style="margin: 5px 0 0; display: block;"><?php _e('Automatically gotten from address input or get it from', 'btoa'); ?> <a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>
                                            
                                            <div class="one-third last"><label><?php _e('Zoom Level', 'btoa'); ?></label>
                                            <input type="text" class="widefat value_zoom" value="<?php echo $__value->zoom ?>" />
                                            <em style="margin: 5px 0 0; display: block;"><?php _e('Value between 1 and 20 for your zoom. Leave blank to not change zoom', 'btoa'); ?></em></div>
                
                                            <div class="clear"></div>
                                            <div class="bDivider"></div>
                                            
                                            <label><?php _e('Radius', 'btoa'); ?></label>
                                            <input type="text" class="widefat value_radius" value="<?php if(isset($__value->radius)) { echo $__value->radius; } ?>" />
                                            <em style="margin: 5px 0 0; display: block;">Set a radius in <?php echo ddp('geo_distance_type'); ?> for when the user selects this location, we will filter based on this radius. Leave blank to disable and search by search field selection only</em>
                
                                            <div class="clear"></div>
                                            <div class="bDivider"></div>
											
												
												 <?php
												 
													//// IF THE USER HAS WPML
													if(isset($sitepress)) :
													
														//// IF WE HAVE MORE THAN 1 LANGUAGE
														if(count($sitepress->get_active_languages()) > 1) :
												 
												 ?>
													
														<?php
														
															/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
															foreach($sitepress->get_active_languages() as $lang) :
															
																///// IF ITS NOT THE NATIVE LANGUAGE
																if($lang['code'] != $sitepress->get_default_language()) {
																	
																	$flag = $sitepress->get_flag($lang['code']);
																	
																	//// GTES THE FLAG URL
																	if($flag->from_template) {
																		
																		$wp_upload_dir = wp_upload_dir();
																		$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
																		
																	} else {
																		
																		$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
																		
																	}
																	
																	$lang_val = '';
																	
																	if(isset($__value->wpml)) {
																		
																		$lang_val = (array)$__value->wpml;
																		if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
																		
																	}
														
														?>
														
															<label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
															<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="<?php echo $lang_val; ?>" />
					
													<div class="clear"></div>
													<div class="bDivider"></div>
														
														<?php } endforeach; ?>
												 
												 <?php
													
														endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
												 
													endif; /// ENDS IF SITEPRESS
													
												?>
												
                                            
                                            <input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeDependentValue();" />
                
                                            <div class="clear"></div>
                                        
                                        </div>
                                        <!-- /.inside/ -->
                                    
                                    </li>
                                    
                                    <?php endforeach;
									endif;
									endforeach;
									endif; ?>
                                
                                </ul>
                            
                            </li>
                        
                        <?php endforeach; ?>
                    
                    </ul> </div><?php else : ?>
                        
                        	<h2>Your Parent dropdown does not have any values yet.</h2>
                        
                        <?php endif; ?>
                
                <?php else : ?>
                
                	<h2><?php _e('Please select a parent dropdown in your attributes, save the field and edit this area.', 'btoa'); ?></h2>
                
                <?php endif; ?>
                
             	
                
                <div class="clear"></div>
                <!-- /.clear/ -->
                
            
            </div>
            <!-- /.type type-dropdown/ -->
            
            <div class="type type-dropdown" style="display: none;">
        
                <div class="one-fifth">
                
                	<label><?php _e('Values', 'btoa'); ?></label>
    
                    <div class="clear"></div>
                    <div class="bDivider"></div>
                                
                    <div id="dropdown-values-add-new">
                    
                    	<p><label style="margin-bottom: 4px;"><?php _e('Label', 'btoa'); ?></label>
                        <input type="text" class="widefat value_name" value="" id="add_new_dropdown_name" /></p>
                    
                    	<p><label style="margin-bottom: 4px;"><?php _e('Latitude', 'btoa'); ?></label>
                        <input type="text" class="widefat value_latitude" value="" id="add_new_dropdown_latitude" /></p>
                    
                    	<p><label style="margin-bottom: 4px;"><?php _e('Longitude', 'btoa'); ?></label>
                        <input type="text" class="widefat value_longitude" value="" id="add_new_dropdown_longitude" /></p>
                    
                    	<p><label style="margin-bottom: 4px;"><?php _e('Zoom Level', 'btoa'); ?></label>
                        <input type="text" class="widefat value_zoom" value="" id="add_new_dropdown_zoom" /></p>
                    
                    	<p><label style="margin-bottom: 4px;">Radius (<?php echo ddp('geo_distance_type'); ?>)</label>
                        <input type="text" class="widefat value_radius" value="" id="add_new_dependent_radius" /></p>
											
												
						 <?php
						 
							//// IF THE USER HAS WPML
							if(isset($sitepress)) :
							
								//// IF WE HAVE MORE THAN 1 LANGUAGE
								if(count($sitepress->get_active_languages()) > 1) :
						 
						 ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
							
							<h2><?php _e('Translations', 'btoa'); ?></h2>
							
								<?php
								
									/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
									foreach($sitepress->get_active_languages() as $lang) :
									
										///// IF ITS NOT THE NATIVE LANGUAGE
										if($lang['code'] != $sitepress->get_default_language()) {
											
											$flag = $sitepress->get_flag($lang['code']);
											
											//// GTES THE FLAG URL
											if($flag->from_template) {
												
												$wp_upload_dir = wp_upload_dir();
												$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
												
											} else {
												
												$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
												
											}
								
								?>
								
									<p><label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
									<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="" /></p>
								
								<?php } endforeach; ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
						 
						 <?php
							
								endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
						 
							endif; /// ENDS IF SITEPRESS
							
						?>
                        
                        <input type="button" class="button" value="<?php _e('Insert Value', 'btoa'); ?>" id="add_new_dropdown_button" onclick="jQuery(this).addNewDropDownValue('dropdown-values-wrapper', 'dropdown_values');" />
                    
                    </div>
                    
                </div>
                
                <div class="four-fifths last values" id="dropdown-values-wrapper">
                
                	<input type="hidden" value="<?php echo htmlspecialchars($dropdown_values); ?>" name="dropdown_values" />
                    
                    <script type="text/javascript">
                    
                    	jQuery(document).ready(function() {
							
							jQuery('#dropdown-values-wrapper ul').sortable({
								
								handle: jQuery('#dropdown-values-wrapper li .head'),
								items: '> li',
								stop: function(event, ui) {
									
									/// RETURN FALSE FOR SHOWING THE CONTENT
									jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();
									
								}
								
							});
							
						});
                    
                    </script>
                    
                    <ul>
                    
                    	<?php
						
							//// GETS THE VALUES AND DISPLAY THEM. IF IS AN ARRAY
							$the_values = json_decode($dropdown_values);
							
							/// IF IS AN OBJECT
							if(is_object($the_values)) :
							
							foreach($the_values as $key => $value) :
						
						?>
                    
                    	<li class="item-id-<?php echo $value->id; ?>">
                        
                        	<div class="head" onclick="jQuery(this).openInsider();">
                            
                            	<span class="title"><?php echo $value->label; ?></span>
                                
                                <span class="arrow"></span>
                                <!-- /.arrow/ -->
                            
                            </div>
                            <!-- /.head/ -->
                            
                            <div class="insider" style="display: none;">
                            
                            	<label><?php _e('Label', 'btoa'); ?></label>
                                <input type="text" class="widefat value_name" value="<?php echo $value->label; ?>" onblur="jQuery(this).valueChangeLabel(); jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();" />
                                <em style="margin: 10px 0 0; display: block;"><?php _e('Label of your dropdown', 'btoa'); ?></em>
    
                                <div class="clear"></div>
                                <div class="bDivider"></div>
                                
                                <label><?php _e('Location Address', 'btoa'); ?></label>
                                <input type="text" class="widefat value_address" value="<?php echo $value->address; ?>" onblur="jQuery(this).updateLatitudeLongitude(); jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();" />
                                <em style="margin: 5px 0 0; display: block;"><?php _e('Only used in case the options "Change Location" is enabled.', 'btoa'); ?></em>
                                
                                <br /><br />
                                
                                <div class="one-third"><label><?php _e('Latitude', 'btoa'); ?></label>
                                <input type="text" class="widefat value_latitude" value="<?php echo $value->latitude; ?>" />
                                <em style="margin: 5px 0 0; display: block;"><?php _e('Automatically gotten from address input or get it from', 'btoa'); ?> <a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>
                                
                                <div class="one-third"><label><?php _e('Longitude', 'btoa'); ?></label>
                                <input type="text" class="widefat value_longitude" value="<?php echo $value->longitude; ?>" />
                                <em style="margin: 5px 0 0; display: block;"><?php _e('Automatically gotten from address input or get it from', 'btoa'); ?> <a href="#http://itouchmap.com/latlong.html" target="_blank">here</a>.</em></div>
                                
                                <div class="one-third last"><label><?php _e('Zoom Level', 'btoa'); ?></label>
                                <input type="text" class="widefat value_zoom" value="<?php echo $value->zoom; ?>" />
                                <em style="margin: 5px 0 0; display: block;"><?php _e('Value between 1 and 20 for your zoom. Leave blank to not change zoom', 'btoa'); ?></em></div>
    
                                <div class="clear"></div>
                                <div class="bDivider"></div>
                                            
									<label><?php _e('Radius', 'btoa'); ?></label>
									<input type="text" class="widefat value_radius" value="<?php if(isset($value->radius)) { echo $value->radius; } ?>" />
									<em style="margin: 5px 0 0; display: block;">Set a radius in <?php echo ddp('geo_distance_type'); ?> for when the user selects this location, we will filter based on this radius. Leave blank to disable and search by search field selection only</em>
		
									<div class="clear"></div>
									<div class="bDivider"></div>
											
												
									 <?php
									 
										//// IF THE USER HAS WPML
										if(isset($sitepress)) :
										
											//// IF WE HAVE MORE THAN 1 LANGUAGE
											if(count($sitepress->get_active_languages()) > 1) :
									 
									 ?>
										
											<?php
											
												/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
												foreach($sitepress->get_active_languages() as $lang) :
												
													///// IF ITS NOT THE NATIVE LANGUAGE
													if($lang['code'] != $sitepress->get_default_language()) {
														
														$flag = $sitepress->get_flag($lang['code']);
														
														//// GTES THE FLAG URL
														if($flag->from_template) {
															
															$wp_upload_dir = wp_upload_dir();
															$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
															
														} else {
															
															$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
															
														}
														
														$lang_val = '';
														
														if(isset($value->wpml)) {
															
															$lang_val = (array)$value->wpml;
															if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
															
														}
											
											?>
											
												<label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
												<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="<?php echo $lang_val; ?>" onblur="jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();" />
		
										<div class="clear"></div>
										<div class="bDivider"></div>
											
											<?php } endforeach; ?>
									 
									 <?php
									 	
											endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
									 
									 	endif; /// ENDS IF SITEPRESS
										
									?>
                                
                                <input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeDropDownValue();" />
    
                                <div class="clear"></div>
                            
                            </div>
                            <!-- /.inside/ -->
                        
                        </li>
                        
                        <?php endforeach; endif; ?>
                    
                    </ul>
                
                </div>
                <!-- /dropdown-value/ -->
                
                <div class="clear"></div>
                <!-- /.clear/ -->
            
            </div>
            <!-- /.type type-dropdown/ -->
            
            <div class="type type-min_val" style="display: none;">
        
                <div class="one-fifth">
                
                	<label><?php _e('Values', 'btoa'); ?></label>
    
                    <div class="clear"></div>
                    <div class="bDivider"></div>
                                
                    <div id="minval-values-add-new">
                    
                    	<p><label style="margin-bottom: 4px;">Label</label>
                        <input type="text" class="widefat value_name" value="" id="add_new_min_val_label" /></p>
                    
                    	<p><label style="margin-bottom: 4px;">Value (Integer)</label>
                        <input type="number" class="widefat value_value" value="" id="add_new_min_val_value" /></p>
												
						 <?php
						 
							//// IF THE USER HAS WPML
							if(isset($sitepress)) :
							
								//// IF WE HAVE MORE THAN 1 LANGUAGE
								if(count($sitepress->get_active_languages()) > 1) :
						 
						 ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
							
							<h2><?php _e('Translations', 'btoa'); ?></h2>
							
								<?php
								
									/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
									foreach($sitepress->get_active_languages() as $lang) :
									
										///// IF ITS NOT THE NATIVE LANGUAGE
										if($lang['code'] != $sitepress->get_default_language()) {
											
											$flag = $sitepress->get_flag($lang['code']);
											
											//// GTES THE FLAG URL
											if($flag->from_template) {
												
												$wp_upload_dir = wp_upload_dir();
												$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
												
											} else {
												
												$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
												
											}
								
								?>
								
									<p><label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
									<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="" /></p>
								
								<?php } endforeach; ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
						 
						 <?php
							
								endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
						 
							endif; /// ENDS IF SITEPRESS
							
						?>
                        
                        <input type="button" class="button" value="<?php _e('Insert Value', 'btoa'); ?>" id="add_new_min_val_button" onclick="jQuery(this).addNewMinValValue('min_val-values-wrapper', 'min_val_values');" />
                    
                    </div>
                    
                </div>
                
                <div class="four-fifths last values" id="min_val-values-wrapper">
                
                	<input type="hidden" value="<?php echo htmlspecialchars($min_val_values); ?>" name="min_val_values" />
                    
                    <script type="text/javascript">
                    
                    	jQuery(document).ready(function() {
							
							jQuery('#min_val-values-wrapper ul').sortable({
								
								handle: jQuery('#min_val-values-wrapper li .head'),
								items: '> li',
								stop: function(event, ui) {
									
									/// RETURN FALSE FOR SHOWING THE CONTENT
									jQuery('#min_val-values-wrapper ul').refreshMinValInput();
									
								}
								
							});
							
						});
                    
                    </script>
                    
                    <ul>
                    
                    	<?php
						
							//// GETS THE VALUES AND DISPLAY THEM. IF IS AN ARRAY
							$the_values = json_decode($min_val_values);
							
							/// IF IS AN OBJECT
							if(is_object($the_values)) :
							
							foreach($the_values as $key => $value) :
						
						?>
                    
                    	<li class="item-id-<?php echo $key; ?>">
                        
                        	<div class="head" onclick="jQuery(this).openInsider();">
                            
                            	<span class="title"><?php echo $value->label ?></span>
                                
                                <span class="arrow"></span>
                                <!-- /.arrow/ -->
                            
                            </div>
                            <!-- /.head/ -->
                            
                            <div class="insider" style="display: none;">
                            
                            	<div class="one-half"><label><?php _e('Label', 'btoa'); ?></label>
                                <input type="text" class="widefat value_name" value="<?php echo $value->label ?>" onblur="jQuery(this).valueChangeLabel2(); jQuery('#dropdown-values-wrapper ul').refreshMinValInput();" />
                                <em style="margin: 10px 0 0; display: block;"><?php _e('Label of your min value', 'btoa'); ?></em></div>
                                
                                <div class="one-half last"><label><?php _e('Minimum Value (Integer)', 'btoa'); ?></label>
                                <input type="number" class="widefat value_value" value="<?php echo $value->value ?>" />
                                <em style="margin: 10px 0 0; display: block;"><?php _e('This is your minimum value. This must be an integer (a number). Leave Blank to not include', 'btoa'); ?></em></div>
    
                                <div class="clear"></div>
                                <div class="bDivider"></div>
											
												
									 <?php
									 
										//// IF THE USER HAS WPML
										if(isset($sitepress)) :
										
											//// IF WE HAVE MORE THAN 1 LANGUAGE
											if(count($sitepress->get_active_languages()) > 1) :
									 
									 ?>
										
											<?php
											
												/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
												foreach($sitepress->get_active_languages() as $lang) :
												
													///// IF ITS NOT THE NATIVE LANGUAGE
													if($lang['code'] != $sitepress->get_default_language()) {
														
														$flag = $sitepress->get_flag($lang['code']);
														
														//// GTES THE FLAG URL
														if($flag->from_template) {
															
															$wp_upload_dir = wp_upload_dir();
															$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
															
														} else {
															
															$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
															
														}
														
														$lang_val = '';
														
														if(isset($value->wpml)) {
															
															$lang_val = (array)$value->wpml;
															if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
															
														}
											
											?>
											
												<label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
												<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="<?php echo $lang_val; ?>" onblur="jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();" />
		
										<div class="clear"></div>
										<div class="bDivider"></div>
											
											<?php } endforeach; ?>
									 
									 <?php
									 	
											endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
									 
									 	endif; /// ENDS IF SITEPRESS
										
									?>
                                
                                <input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeMinValue();" />
    
                                <div class="clear"></div>
                            
                            </div>
                            <!-- /.inside/ -->
                        
                        </li>
                        
                        <?php endforeach; endif; ?>
                    
                    </ul>
                
                </div>
                <!-- /dropdown-value/ -->
                
                <div class="clear"></div>
                <!-- /.clear/ -->
            
            </div>
            <!-- /.type .type-min_val/ -->
            
            <div class="type type-max_val" style="display: none;">
        
                <div class="one-fifth">
                
                	<label><?php _e('Values', 'btoa'); ?></label>
    
                    <div class="clear"></div>
                    <div class="bDivider"></div>
                                
                    <div id="maxval-values-add-new">
                    
                    	<p><label style="margin-bottom: 4px;">Label</label>
                        <input type="text" class="widefat value_name" value="" id="add_new_max_val_label" /></p>
                    
                    	<p><label style="margin-bottom: 4px;">Value (Integer)</label>
                        <input type="number" class="widefat value_value" value="" id="add_new_max_val_value" /></p>
												
						 <?php
						 
							//// IF THE USER HAS WPML
							if(isset($sitepress)) :
							
								//// IF WE HAVE MORE THAN 1 LANGUAGE
								if(count($sitepress->get_active_languages()) > 1) :
						 
						 ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
							
							<h2><?php _e('Translations', 'btoa'); ?></h2>
							
								<?php
								
									/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
									foreach($sitepress->get_active_languages() as $lang) :
									
										///// IF ITS NOT THE NATIVE LANGUAGE
										if($lang['code'] != $sitepress->get_default_language()) {
											
											$flag = $sitepress->get_flag($lang['code']);
											
											//// GTES THE FLAG URL
											if($flag->from_template) {
												
												$wp_upload_dir = wp_upload_dir();
												$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
												
											} else {
												
												$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
												
											}
								
								?>
								
									<p><label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
									<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="" /></p>
								
								<?php } endforeach; ?>

							<div class="clear"></div>
							<div class="bDivider"></div>
						 
						 <?php
							
								endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
						 
							endif; /// ENDS IF SITEPRESS
							
						?>
                        
                        <input type="button" class="button" value="<?php _e('Insert Value', 'btoa'); ?>" id="add_new_max_val_button" onclick="jQuery(this).addNewMaxValValue('max_val-values-wrapper', 'max_val_values');" />
                    
                    </div>
                    
                </div>
                
                <div class="four-fifths last values" id="max_val-values-wrapper">
                
                	<input type="hidden" value="<?php echo htmlspecialchars($max_val_values); ?>" name="max_val_values" />
                    
                    <script type="text/javascript">
                    
                    	jQuery(document).ready(function() {
							
							jQuery('#max_val-values-wrapper ul').sortable({
								
								handle: jQuery('#max_val-values-wrapper li .head'),
								items: '> li',
								stop: function(event, ui) {
									
									/// RETURN FALSE FOR SHOWING THE CONTENT
									jQuery('#max_val-values-wrapper ul').refreshMaxValInput();
									
								}
								
							});
							
						});
                    
                    </script>
                    
                    <ul>
                    
                    	<?php
						
							//// GETS THE VALUES AND DISPLAY THEM. IF IS AN ARRAY
							$the_values = json_decode($max_val_values);
							
							/// IF IS AN OBJECT
							if(is_object($the_values)) :
							
							foreach($the_values as $key => $value) :
						
						?>
                    
                    	<li class="item-id-<?php echo $key; ?>">
                        
                        	<div class="head" onclick="jQuery(this).openInsider();">
                            
                            	<span class="title"><?php echo $value->label ?></span>
                                
                                <span class="arrow"></span>
                                <!-- /.arrow/ -->
                            
                            </div>
                            <!-- /.head/ -->
                            
                            <div class="insider" style="display: none;">
                            
                            	<div class="one-half"><label><?php _e('Label', 'btoa'); ?></label>
                                <input type="text" class="widefat value_name" value="<?php echo $value->label ?>" onblur="jQuery(this).valueChangeLabel2(); jQuery('#dropdown-values-wrapper ul').refreshMaxValInput();" />
                                <em style="margin: 10px 0 0; display: block;"><?php _e('Label of your max value', 'btoa'); ?></em></div>
                                
                                <div class="one-half last"><label><?php _e('Maximum Value (Integer)', 'btoa'); ?></label>
                                <input type="number" class="widefat value_value" value="<?php echo $value->value ?>" />
                                <em style="margin: 10px 0 0; display: block;"><?php _e('This is your maximum value. This must be an integer (a number). Leave Blank to not include', 'btoa'); ?></em></div>
    
                                <div class="clear"></div>
                                <div class="bDivider"></div>
											
												
									 <?php
									 
										//// IF THE USER HAS WPML
										if(isset($sitepress)) :
										
											//// IF WE HAVE MORE THAN 1 LANGUAGE
											if(count($sitepress->get_active_languages()) > 1) :
									 
									 ?>
										
											<?php
											
												/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
												foreach($sitepress->get_active_languages() as $lang) :
												
													///// IF ITS NOT THE NATIVE LANGUAGE
													if($lang['code'] != $sitepress->get_default_language()) {
														
														$flag = $sitepress->get_flag($lang['code']);
														
														//// GTES THE FLAG URL
														if($flag->from_template) {
															
															$wp_upload_dir = wp_upload_dir();
															$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
															
														} else {
															
															$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
															
														}
														
														$lang_val = '';
														
														if(isset($value->wpml)) {
															
															$lang_val = (array)$value->wpml;
															if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
															
														}
											
											?>
											
												<label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label>
												<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="<?php echo $lang_val; ?>" onblur="jQuery('#dropdown-values-wrapper ul').refreshDropDownInput();" />
		
										<div class="clear"></div>
										<div class="bDivider"></div>
											
											<?php } endforeach; ?>
									 
									 <?php
									 	
											endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
									 
									 	endif; /// ENDS IF SITEPRESS
										
									?>
                                
                                <input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeMaxValue();" />
    
                                <div class="clear"></div>
                            
                            </div>
                            <!-- /.inside/ -->
                        
                        </li>
                        
                        <?php endforeach; endif; ?>
                    
                    </ul>
                
                </div>
                <!-- /dropdown-value/ -->
                
                <div class="clear"></div>
                <!-- /.clear/ -->
            
            </div>
            <!-- /.type .type-max_val/ -->
        
        	<div class="type type-range" style="display: none;"><h2 style="margin: 15px;"><?php _e('This input type does not take any values', 'btoa'); ?></h2></div>
        
        	<div class="type type-check" style="display: none;"><h2 style="margin: 15px;"><?php _e('This input type does not take any values', 'btoa'); ?></h2></div>
        
        	<div class="type type-rating" style="display: none;"><h2 style="margin: 15px;"><?php _e('This input type does not take any values', 'btoa'); ?></h2></div>
        
        </li>
        
        
        
        <li>
		
				<div class="type type-rating" style="display: none;">
        
                <div class="one-fifth"><label for="include_rating_overlay"><?php _e('Enable on Map Overlay', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="include_rating_overlay" id="include_rating_overlay"<?php if($include_rating_overlay == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('Display rating on overlay??', 'btoa'); ?></div>
                
                <div class="clear"></div>
				
				</div>
				<!-- type-rating -->
				
				<div class="not-type type-rating">
				
					<?php
					
						if(isset($sitepress)) :
						
							//// NOW LETS LOOP OUR LANGAUGES AND ADD A TRANSLATED TITLE FOR THIS
							foreach($sitepress->get_active_languages() as $lang => $details) :
							
							///// IF NOT DEFAULT LANGUAGE
							if($lang != $sitepress->get_default_language()) :
							
								$flag = $sitepress->get_flag($lang);
														
								//// GTES THE FLAG URL
								if($flag->from_template) {
									
									$wp_upload_dir = wp_upload_dir();
									$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
									
								} else {
									
									$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
									
								}
						
					?>
        
						<div class="one-fifth"><label for="title_<?php echo $lang ?>"><img src="<?php echo $flag_url ?>" /> &nbsp;<?php _e('Title in ', 'btoa'); ?> <?php echo $details['display_name']; ?></label></div>
						<div class="two-fifths"><input type="text" name="title_<?php echo $lang ?>" id="title_<?php echo $lang ?>" class="widefat" value="<?php echo get_post_meta($original_post->ID, 'title_'.$lang, true); ?>" /></div>
						<div class="two-fifths description last"><?php _e('Title of your search field in ', 'btoa'); ?><?php echo $details['display_name']; ?></div>
						
						<div class="clear"></div>
						<div class="bDivider"></div>
					
					<?php endif; endforeach; endif; ?>
        
                <div class="one-fifth"><label for="include_overlay"><?php _e('Enable on Front-End', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="include_overlay" id="include_overlay"<?php if($include_overlay == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('DIsplay this value in front end?', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="overlay_markup"><?php _e('Front End Markup', 'btoa'); ?></label></div>
                <div class="two-fifths"><textarea name="overlay_markup" id="overlay_markup" class="widefat" cols="" rows="4"><?php echo $overlay_markup; ?></textarea></div>
                <div class="two-fifths description last"><?php _e('This is the markup that is displayed in your front end. You can use the variable %% to display the chosen value.<br>For example to display the price you can type "Price: $%%" where %% will be replaced with the chosen value if provided.<br>
				You can also use %_*VAL_% to multiply an element based on the value. For example if your field is a number, use "%_*VAL_% ELEMENT" to multiple the string ELEMENT by the amount of times the user has chosen.', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
											
				 <?php
				 
					//// IF THE USER HAS WPML
					if(isset($sitepress)) :
					
						//// IF WE HAVE MORE THAN 1 LANGUAGE
						if(count($sitepress->get_active_languages()) > 1) :
				 
				 ?>
					
						<?php
						
							/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
							foreach($sitepress->get_active_languages() as $lang) :
							
								///// IF ITS NOT THE NATIVE LANGUAGE
								if($lang['code'] != $sitepress->get_default_language()) {
									
									$flag = $sitepress->get_flag($lang['code']);
									
									//// GTES THE FLAG URL
									if($flag->from_template) {
										
										$wp_upload_dir = wp_upload_dir();
										$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
										
									} else {
										
										$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
										
									}
									
									$lang_val = '';
									
									if(isset($value->wpml)) {
										
										$lang_val = (array)$value->wpml;
										if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
										
									}
						
						?>
        
							<div class="one-fifth"><label for="overlay_markup_wpml"><?php _e('Front End Markup', 'btoa'); ?><br><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label></div>
							<div class="two-fifths"><textarea name="overlay_markup_wpml_<?php echo $lang['code'] ?>" id="overlay_markup_wpml_<?php echo $lang['code'] ?>" class="widefat" cols="" rows="4"><?php echo get_post_meta($original_post->ID, 'overlay_markup_wpml_'.$lang['code'], true); ?></textarea></div>
							<div class="two-fifths description last">&nbsp;</div>

					<div class="clear"></div>
					<div class="bDivider"></div>
						
						<?php } endforeach; ?>
				 
				 <?php
					
						endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
				 
					endif; /// ENDS IF SITEPRESS
					
				?>
        
                <div class="one-fifth"><label for="enable_sort"><?php _e('Enable on Sort By', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="enable_sort" id="enable_sort"<?php if($enable_sort == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('If enabled the user will be able to sort his listing results by this field. Please note that this will only work for numeric fields such as range, minimum and maximum values.', 'btoa'); ?></div>
                
                <div class="clear"></div>
				
				</div>
				<!-- .not-type type-rating -->
                
        
        </li>
        
        
        
        <li>
        
                <div class="one-fifth"><label for="public_field"><?php _e('Enable Field on Public Submissions', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="public_field" id="public_field"<?php if($public_field == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('If enabled, users submitting propertie swill be able to select the value for this field', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="public_field_required"><?php _e('Required', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="checkbox" name="public_field_required" id="public_field_required"<?php if($public_field_required == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
                <div class="two-fifths description last"><?php _e('Is this field required?', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="public_field_category"><?php _e('Categories', 'btoa'); ?></label></div>
                <div class="two-fifths"><select name="public_field_category[]" id="public_field_category" class="widefat" multiple>
				
					<option value="all"<?php if($public_field_category == '' || in_array('all', $public_field_category)) { echo ' selected="selected"'; } ?>><?php _e('All Categories', 'btoa'); ?></option>
					
					<?php
					
						/// GET CATEGORIES
						$_cats = get_terms('spot_cats', array('hide_empty' => false, 'orderby' => 'name'));
						
						foreach($_cats as $cat) {
							
							echo '<option';
							
							if(in_array($cat->term_id, $public_field_category)) { echo ' selected="selected"'; }
							
							echo ' value="'.$cat->term_id.'">'.$cat->name.'</option>';
							
						}
					
					?>
				
				  </select></div>
                <div class="two-fifths description last"><?php _e('Allow this field to be set only with the specified categories. This means that this search field will only be available for selection in case the user has checked the selected category.', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="public_field_description"><?php _e('Description', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="text" name="public_field_description" id="public_field_description" class="widefat" value="<?php echo $public_field_description; ?>" /></div>
                <div class="two-fifths description last"><?php _e('Description for this field shown in backend', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
											
				 <?php
				 
					//// IF THE USER HAS WPML
					if(isset($sitepress)) :
					
						//// IF WE HAVE MORE THAN 1 LANGUAGE
						if(count($sitepress->get_active_languages()) > 1) :
				 
				 ?>
					
						<?php
						
							/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
							foreach($sitepress->get_active_languages() as $lang) :
							
								///// IF ITS NOT THE NATIVE LANGUAGE
								if($lang['code'] != $sitepress->get_default_language()) {
									
									$flag = $sitepress->get_flag($lang['code']);
									
									//// GTES THE FLAG URL
									if($flag->from_template) {
										
										$wp_upload_dir = wp_upload_dir();
										$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
										
									} else {
										
										$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
										
									}
									
									$lang_val = '';
									
									if(isset($value->wpml)) {
										
										$lang_val = (array)$value->wpml;
										if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
										
									}
						
						?>
        
							<div class="one-fifth"><label for="public_field_description_wpml"><?php _e('Description', 'btoa'); ?><br><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label></div>
							<div class="two-fifths"><input type="text" name="public_field_description_wpml_<?php echo $lang['code'] ?>" id="public_field_description_wpml_<?php echo $lang['code'] ?>" class="widefat" value="<?php echo get_post_meta($original_post->ID, 'public_field_description_wpml_'.$lang['code'], true); ?>" /></div>
							<div class="two-fifths description last">&nbsp;</div>

					<div class="clear"></div>
					<div class="bDivider"></div>
						
						<?php } endforeach; ?>
				 
				 <?php
					
						endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
				 
					endif; /// ENDS IF SITEPRESS
					
				?>
        
                <div class="one-fifth"><label for="public_field_selection"><?php _e('Dropdown Multiple or Single', 'btoa'); ?></label></div>
                <div class="two-fifths"><select class="widefat" name="public_field_selection">
                
                	<option value="single"<?php if($public_field_selection == 'single') { echo ' selected="selected"'; } ?>><?php _e('Single', 'btoa'); ?></option>
                	<option value="multiple"<?php if($public_field_selection == 'multiple') { echo ' selected="selected"'; } ?>><?php _e('Multiple', 'btoa'); ?></option>
                
                </select></div>
                <div class="two-fifths description last"><?php _e('Enable users to select one value or multiple values for this field?', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="public_field_price"><?php _e('Search field price', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="number" name="public_field_price" id="public_field_price" class="widefat" value="<?php echo $public_field_price; ?>" /></div>
                <div class="two-fifths description last"><?php _e('Enter a value to charge users to set this custom field.', 'btoa'); ?></div>
                
                <div class="clear"></div>
                <div class="bDivider"></div>
        
                <div class="one-fifth"><label for="public_field_price_description"><?php _e('Cart description', 'btoa'); ?></label></div>
                <div class="two-fifths"><input type="text" name="public_field_price_description" id="public_field_price_description" class="widefat" value="<?php echo $public_field_price_description; ?>" /></div>
                <div class="two-fifths description last"><?php _e('Message displayed when user adds this to cart.', 'btoa'); ?></div>
											
				 <?php
				 
					//// IF THE USER HAS WPML
					if(isset($sitepress)) :
					
						//// IF WE HAVE MORE THAN 1 LANGUAGE
						if(count($sitepress->get_active_languages()) > 1) :
				 
				 ?>
				 	<div class="clear"></div>
					
						<?php
						
							/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
							foreach($sitepress->get_active_languages() as $lang) :
							
								///// IF ITS NOT THE NATIVE LANGUAGE
								if($lang['code'] != $sitepress->get_default_language()) {
									
									$flag = $sitepress->get_flag($lang['code']);
									
									//// GTES THE FLAG URL
									if($flag->from_template) {
										
										$wp_upload_dir = wp_upload_dir();
										$flag_url = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
										
									} else {
										
										$flag_url = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
										
									}
									
									$lang_val = '';
									
									if(isset($value->wpml)) {
										
										$lang_val = (array)$value->wpml;
										if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
										
									}
						
						?>
					<div class="bDivider"></div>
        
							<div class="one-fifth"><label for="public_field_price_description_wpml"><?php _e('Cart Description', 'btoa'); ?><br><img src="<?php echo $flag_url ?>" /> &nbsp;<?php echo $lang['display_name']; ?>: </label></div>
							<div class="two-fifths"><input type="text" name="public_field_price_description_wpml_<?php echo $lang['code'] ?>" id="public_field_price_description_wpml_<?php echo $lang['code'] ?>" class="widefat" value="<?php echo get_post_meta($original_post->ID, 'public_field_price_description_wpml_'.$lang['code'], true); ?>" /></div>
							<div class="two-fifths description last">&nbsp;</div>

					<div class="clear"></div>
						
						<?php } endforeach; ?>
				 
				 <?php
					
						endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
				 
					endif; /// ENDS IF SITEPRESS
					
				?>
                
                <div class="clear"></div>
                
        
        </li>
		
		
		
		
		<li>
        
			<div class="one-fifth"><label for="google_places_api"><?php _e('Your Google Places API Key', 'btoa'); ?></label></div>
			<div class="two-fifths"><input type="text" name="google_places_api" id="google_places_api" class="widefat" value="<?php echo $google_places_api; ?>" /></div>
			<div class="two-fifths description last"><?php _e('If you do not have a google places API please visit ', 'btoa'); ?><a href="https://code.google.com/apis/console/">https://code.google.com/apis/console/</a></div>
			
			<div class="clear"></div>
			<div class="bDivider"></div>
        
			<div class="one-fifth"><label for="google_places_country"><?php _e('Which country to retrieve results from (Use a ISO 2-character country code)', 'btoa'); ?></label></div>
			<div class="two-fifths"><input type="text" name="google_places_country" id="google_places_country" class="widefat" value="<?php echo $google_places_country; ?>" /></div>
			<div class="two-fifths description last">To get your country code please visit:<a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2</a> Leave blank to include places from all over the world.</div>
			
			<div class="clear"></div>
			<div class="bDivider"></div>
		
        
			<div class="one-fifth"><label for="google_places_sensitivity"><?php _e('Radius sensitivity', 'btoa'); ?><br>(in <?php echo ddp('geo_distance_type'); ?>)</label></div>
			<div class="two-fifths"><input type="text" name="google_places_sensitivity" id="google_places_sensitivity" class="widefat" value="<?php echo $google_places_sensitivity; ?>" /></div>
			<div class="two-fifths description last">Your radius sensitivity. When the Google Places API provides the radius for the place, it is very exact. Here you can expand this radius (in <?php echo ddp('geo_distance_type'); ?> - Change this under the bPanel "Map Options > Geolocation Options), as an extension. For example. If the user select a specific suburb, and you select a sensitivity of 1km, the listing results will increase the radius given by google by 1km to all sides.</div>
			
			<div class="clear"></div>
		
		</li>
    
    </ul>
    <!-- /.tabbed/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->

</div>