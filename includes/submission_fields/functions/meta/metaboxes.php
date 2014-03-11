<?php

	$field_type = get_post_meta($post->ID, 'field_type', true);
	$required = get_post_meta($post->ID, 'required', true);
	$field_category = get_post_meta($post->ID, 'field_category', true);
	if($field_category == '') { $field_category = array(); }
	$position = get_post_meta($post->ID, 'position', true);
	$dropdown_values = htmlspecialchars_decode(get_post_meta($post->ID, 'dropdown_values', true));
	$listing_position = get_post_meta($post->ID, 'listing_position', dropdown_values);
	$markup = get_post_meta($post->ID, 'markup', true);
	$allow_html = get_post_meta($post->ID, 'allow_html', true);
	$allow_video = get_post_meta($post->ID, 'allow_video', true);

?>

<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/icons.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/gmap3.min.js"></script>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?sensor=false'></script>

<div class="bpanel-tabbed-meta">

	<ul class="tabs">
    
    	<li class="bpanel-tab current" style="padding-left: 5px;"><i class="icon-cog-alt"></i> <?php _e('Field Type', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-menu"></i> <?php _e('Field Attributes', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-desktop"></i> <?php _e('Front-End Options', 'btoa'); ?></li>
    
    </ul>
    <!-- /.tabs/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->
    
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
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
			
			jQuery('#required').iphoneStyle();
			jQuery('#allow_video').iphoneStyle();
			
			jQuery('#allow_html').iphoneStyle();
			
			///// on change
//			jQuery('#field_type').change(function() {
//				
//				var selectedField = jQuery('#field_type option:selected').val();
//				jQuery('.tabbed li > .type').hide();
//				jQuery('.tabbed li > .type-'+selectedField).show();
//				
//				if(selectedField == 'rating') { jQuery('.not-type.type-rating, .bpanel-tabbed-meta ul li.submission').hide(); }
//				else { jQuery('.not-type.type-rating, .bpanel-tabbed-meta ul li.submission').show(); }
//				
//			});
			
		});
	
	</script>
    
    <ul class="tabbed">
    
    	<li class="current">
        
        	<div class="one-fifth"><label for="field_type"><?php _e('Field Type', 'btoa'); ?></label></div>
            <div class="two-fifths"><select name="field_type" id="field_type" class="widefat">
            
            	<option value="text"<?php if($field_type == 'text') { echo ' selected="selected"'; } ?>><?php _e('Text Field', 'btoa'); ?></option>
            	<option value="dropdown"<?php if($field_type == 'dropdown') { echo ' selected="selected"'; } ?>><?php _e('Select Field', 'btoa'); ?></option>
            	<option value="file"<?php if($field_type == 'file') { echo ' selected="selected"'; } ?>><?php _e('File Upload Field', 'btoa'); ?></option>
            
            </select></div>
            <div class="two-fifths description last"><?php _e('Select your submission field type', 'btoa'); ?></div>
            
            <div class="clear"></div>
        
        </li>
		
		<li>
        
			<div class="one-fifth"><label for="required"><?php _e('Required', 'btoa'); ?></label></div>
			<div class="two-fifths"><input type="checkbox" name="required" id="required"<?php if($required == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
			<div class="two-fifths description last"><?php _e('Whether or not the user is required to fill in this field when making his submission.', 'btoa'); ?></div>

			<div class="clear"></div>
			<div class="bDivider"></div>
        
			<div class="one-fifth"><label for="field_category"><?php _e('Categories', 'btoa'); ?></label></div>
			<div class="two-fifths"><select name="field_category[]" id="field_category" class="widefat" multiple>
			
				<option value="all"<?php if($field_category == '' || in_array('all', $field_category) || sizeof($field_category) == 0) { echo ' selected="selected"'; } ?>><?php _e('All Categories', 'btoa'); ?></option>
				
				<?php
				
					/// GET CATEGORIES
					$_cats = get_terms('spot_cats', array('hide_empty' => false));
					
					foreach($_cats as $cat) {
						
						echo '<option';
						
						if(in_array($cat->term_id, $field_category)) { echo ' selected="selected"'; }
						
						echo ' value="'.$cat->term_id.'">'.$cat->name.'</option>';
						
					}
				
				?>
			
			  </select></div>
			<div class="two-fifths description last"><?php _e('Allow this field to be set only with the specified categories. This means that this search field will only be available for selection in case the user has checked the selected category.', 'btoa'); ?></div>
			
			<div class="clear"></div>
			<div class="bDivider"></div>
        
			<div class="one-fifth"><label for="position"><?php _e('Submission Page Position', 'btoa'); ?></label></div>
			<div class="two-fifths">
			
				<script type="text/javascript">
				
					jQuery(document).ready(function() {
						
						jQuery('#submission-field-position span').click(function() {
							
							if(jQuery(this).attr('class').indexOf('current') == -1) {
							
								//// WHEN WE CLICK AN AREA
								//// REMOVES CURRENT
								jQuery(this).parent().parent().find('.current').removeClass('current');
								
								//// UPDATES HIDDEN FIELD AND CHANGES CURRENT
								jQuery('#position').val(jQuery(this).attr('class'));
								jQuery(this).addClass('current');
							
							}
							
						});
						
					});
				
				</script>
			
				<?php if($position == '') { $position = 'before_custom_fields'; } ?>
			
				<input type="hidden" name="position" id="position" value="<?php echo $position ?>" />
				
				<div id="submission-field-position">
				
					<div class="two-thirds">
					
						<span class="after_title<?php if($position == 'after_title') : ?> current<?php endif; ?>" style="line-height: 25px;">After Title</span>
					
						<span class="after_slogan<?php if($position == 'after_slogan') : ?> current<?php endif; ?>" style="line-height: 18px;">After Slogan</span>
					
						<span class="after_content<?php if($position == 'after_content') : ?> current<?php endif; ?>" style="line-height: 80px;">After Content</span>
					
						<span class="after_gallery<?php if($position == 'after_gallery') : ?> current<?php endif; ?>" style="line-height: 40px;">After Gallery</span>
					
						<span class="after_featured<?php if($position == 'after_featured') : ?> current<?php endif; ?>" style="line-height: 40px;">After Featured Selection</span>
					
					</div>
					
					<div class="one-third last">
					
						<span class="after_categories<?php if($position == 'after_categories') : ?> current<?php endif; ?>" style="line-height: 70px;">After Categories</span>
					
						<span class="after_tags<?php if($position == 'after_tags') : ?> current<?php endif; ?>" style="line-height: 70px;">After Tags</span>
					
						<span class="after_map<?php if($position == 'after_map') : ?> current<?php endif; ?>" style="line-height: 70px;">After Map Location</span>
					
					</div>
					<!-- .one-third -->
					
					<div class="position-divider"></div>
					<!-- .position-divider -->
				
					<div class="two-thirds">
					
						<span class="before_custom_fields<?php if($position == 'before_custom_fields') : ?> current<?php endif; ?>" style="line-height: 25px;">Before Custom Fields</span>
					
						<span class="after_custom_fields<?php if($position == 'after_custom_fields') : ?> current<?php endif; ?>" style="line-height: 60px;">After Custom Fields</span>
					
					</div>
					
					<div class="one-third last">
					
						<span class="before_search_fields<?php if($position == 'before_search_fields') : ?> current<?php endif; ?>" style="line-height: 25px;">Before Search Fields</span>
					
						<span class="after_search_fields<?php if($position == 'after_search_fields') : ?> current<?php endif; ?>" style="line-height: 60px;">After Search Fields</span>
					
					</div>
					<!-- .one-third -->
					
					<div class="clear"></div>
					<!-- .clear -->
				
				</div>
				<!-- #submission-field-position -->
				
			</div>
			<div class="two-fifths description last"><?php _e('Please select where your field will display in the submission page. Note that these positions are predefined and the position you click, the field will display AFTER that default field, unless otherwise stated.', 'btoa'); ?></div><br>
			
			<div class="clear"></div>
			
			<div class="type type-text" style="display: none;">
	
				<div class="clear"></div>
				<div class="bDivider"></div>
        
				<div class="one-fifth"><label for="allow_html"><?php _e('Allow HTML', 'btoa'); ?></label></div>
				<div class="two-fifths"><input type="checkbox" name="allow_html" id="allow_html"<?php if($allow_html == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
				<div class="two-fifths description last"><?php _e('Whether or not to allow HTML', 'btoa'); ?></div>
	
				<div class="clear"></div>
				<div class="bDivider"></div>
        
				<div class="one-fifth"><label for="allow_video"><?php _e('Allow Videos', 'btoa'); ?></label></div>
				<div class="two-fifths"><input type="checkbox" name="allow_video" id="allow_video"<?php if($allow_video == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
				<div class="two-fifths description last"><?php _e('Whether or not to allow videos. If allowed users can just paste a youtube URL in order to embed a video', 'btoa'); ?></div>
	
				<div class="clear"></div>
			
			</div>
			
			<div class="type type-dropdown" style="display: none;">
			
				<div class="clear"></div>
				<div class="bDivider"></div>
				<!-- bDivider -->
			
				 <h2 style=" margin-bottom: 0;">Select Values</h2>
        
                <div class="one-fifth">
    
                    <div class="clear"></div>
                    <div class="bDivider"></div>
                                
                    <div>
                    
                    	<p><label style="margin-bottom: 4px;"><?php _e('Value', 'btoa'); ?></label>
                        <input type="text" class="widefat value_name" value="" id="add_new_dropdown_name" /></p>
                        
                        <input type="button" class="button" value="<?php _e('Insert Value', 'btoa'); ?>" id="add_new_dropdown_button" onclick="jQuery(this).addNewSelectValue('dropdown-values-wrapper', 'dropdown_values');" />
                    
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
									jQuery('#dropdown-values-wrapper ul').refreshSelectInput();
									
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
                                <input type="text" class="widefat value_name" value="<?php echo $value->label; ?>" onblur="jQuery(this).valueChangeLabel(); jQuery('#dropdown-values-wrapper ul').refreshSelectInput();" />
                                <em style="margin: 10px 0 0; display: block;"><?php _e('Label of your dropdown', 'btoa'); ?></em>
		
									<div class="clear"></div>
									<div class="bDivider"></div>
                                
                                <input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeSelectValue();" />
    
                                <div class="clear"></div>
                            
                            </div>
                            <!-- /.inside/ -->
                        
                        </li>
                        
                        <?php endforeach; endif; ?>
                    
                    </ul>
                
                </div>
                <!-- /dropdown-value/ --><br>
				
			</div>
			<!-- .type-select -->
			
			<div class="type type-file" style="display: none;">
	
				<div class="clear"></div>
				<div class="bDivider"></div>
        
				<div class="one-fifth"><label for="file_count"><?php _e('Number of Files', 'btoa'); ?></label></div>
				<div class="two-fifths"><input type="number" name="file_count" id="file_count" value="<?php echo $file_count; ?>" />&nbsp;</div>
				<div class="two-fifths description last"><?php _e('How many files the user is able to upload. Leave 0, blank or 1 to allow only a single file', 'btoa'); ?></div>
			
			</div>
			<!-- .type-file -->
				
				
				<div class="clear"></div>
				<!-- .clear -->
			
			
			
		
		</li>
		
		<li class="">
			
        
			<div class="one-fifth"><label for="listing_position"><?php _e('Single Listing Page Position', 'btoa'); ?></label></div>
			<div class="two-fifths">
			
				<script type="text/javascript">
				
					jQuery(document).ready(function() {
						
						jQuery('#listing-field-position span').click(function() {
							
							if(jQuery(this).attr('class').indexOf('current') == -1) {
							
								//// WHEN WE CLICK AN AREA
								//// REMOVES CURRENT
								jQuery('#listing-field-position').find('.current').removeClass('current');
								
								//// UPDATES HIDDEN FIELD AND CHANGES CURRENT
								jQuery('#listing_position').val(jQuery(this).attr('class'));
								jQuery(this).addClass('current');
							
							}
							
						});
						
					});
				
				</script>
			
				<?php if($listing_position == '') { $listing_position = 'after_gallery'; } ?>
			
				<input type="hidden" name="listing_position" id="listing_position" value="<?php echo $listing_position ?>" />
				
				<div id="listing-field-position">
				
					<div class="two-thirds">
				
						<span class="before_gallery<?php if($listing_position == 'before_gallery') : ?> current<?php endif; ?>" style="line-height: 25px;">Before Gallery</span>
				
						<span class="after_gallery<?php if($listing_position == 'after_gallery') : ?> current<?php endif; ?>" style="line-height: 80px;">After Gallery</span>
						
						<div class="two-thirds">
						
							<span class="before_content<?php if($listing_position == 'before_content') : ?> current<?php endif; ?>" style="line-height: 25px;">Before Content</span>
						
							<span class="after_content<?php if($listing_position == 'after_content') : ?> current<?php endif; ?>" style="line-height: 106px;">After Content</span>
						
						</div>
						<!-- .two-thirds -->
						
						<div class="one-third last">
						
							<span class="before_address<?php if($listing_position == 'before_address') : ?> current<?php endif; ?>" style="height: 25px; line-height: 14px; padding: 4px 0;">Before Address</span>
						
							<span class="after_address<?php if($listing_position == 'after_address') : ?> current<?php endif; ?>" style="height: 14px; line-height: 14px; padding: 4px 0;">After Address</span>
						
							<span class="after_search<?php if($listing_position == 'after_search') : ?> current<?php endif; ?>" style="height: 25px; line-height: 14px; padding: 4px 0;">After Search Fields</span>
						
							<span class="after_custom<?php if($listing_position == 'after_custom') : ?> current<?php endif; ?>" style="height: 25px; line-height: 14px; padding: 4px 0;">After Custom Fields</span>
						
						</div>
						<!-- .one-third -->
						
						<div class="clear"></div>
						<!-- .clear -->
						
						<span class="after_content_area<?php if($listing_position == 'after_content_area') : ?> current<?php endif; ?>" style="line-height: 45px;">After Content Area</span>
					
					</div>
					<!-- .two-thirds -->
					
					<div class="one-third last">
					
						<span class="before_contact<?php if($listing_position == 'before_contact') : ?> current<?php endif; ?>" style="line-height: 50px;">Before Contact Form</span>
					
						<span class="after_contact<?php if($listing_position == 'after_contact') : ?> current<?php endif; ?>" style="line-height: 50px;">After Contact Form</span>
					
					</div>
					
					<div class="clear"></div>
					<!-- .clear -->
				
				</div>
				<!-- #listing-field-position -->
				
			</div>
			<div class="two-fifths description last"><?php _e('Please select where your field will display in the single listings page. Note that these positions are predefined and the position you click, the field will display AFTER that default field, unless otherwise stated.', 'btoa'); ?></div>
			
			<div class="type type-text type-dropdown" style="display: none;">
                
				<div class="clear"></div>
				<div class="bDivider"></div>
		
				<div class="one-fifth"><label for="markup"><?php _e('Front End Markup', 'btoa'); ?></label></div>
				<div class="two-fifths"><textarea name="markup" id="markup" class="widefat" cols="" rows="4"><?php echo $markup; ?></textarea></div>
				<div class="two-fifths description last"><?php _e('This is the markup that is displayed in your front end. You can use the variable %% to display the chosen value.<br>For example to display a website you can type "Website: %%" where %% will be replaced with the chosen value if provided.<br>
				You can also use %_*VAL_% to multiply an element based on the value. For example if your field is a number, use "%_*VAL_% ELEMENT" to multiple the string ELEMENT by the amount of times the user has chosen.', 'btoa'); ?></div>
			
			</div>
			<!-- .type -->
			
			<div class="clear"></div>
		
		</li>
    
    </ul>
    <!-- /.tabbed/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->

</div>