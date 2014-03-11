<?php

	//// OUR VARIABLE
	$column_layout = get_post_meta($post->ID, 'column_layout', true);
	$form_fields = htmlspecialchars_decode(get_post_meta($post->ID, 'form_fields', true));
	
	
	if(!$column_layout || $column_layout == '') { $column_layout = 3; }
	
	global $sitepress;

?>

<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/icons.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>


<h2 style=" margin-bottom: 10px;"><?php _e('1) Select your initial column layout:', 'btoa'); ?></h2>

<select class="column_layout widefat" name="column_layout">

	<option value="1"<?php if($column_layout == '1') { echo ' selected="selected"'; } ?>><?php _e('1 Columns', 'btoa'); ?></option>
	<option value="2"<?php if($column_layout == '2') { echo ' selected="selected"'; } ?>><?php _e('2 Columns', 'btoa'); ?></option>
	<option value="3"<?php if($column_layout == '3') { echo ' selected="selected"'; } ?>><?php _e('3 Columns', 'btoa'); ?></option>
	<option value="4"<?php if($column_layout == '4') { echo ' selected="selected"'; } ?>><?php _e('4 Columns', 'btoa'); ?></option>
	<option value="5"<?php if($column_layout == '5') { echo ' selected="selected"'; } ?>><?php _e('5 Columns', 'btoa'); ?></option>

</select>

<div class="bDivider"></div>
<!-- /.bDivider/ -->

<h2 style="margin-bottom: 10px;">2) Drag and Drop you created search fields inside the columns</h2>

<input type="hidden" name="form_fields" value="<?php echo htmlspecialchars($form_fields) ?>" id="form_fields_input" />

<ul id="the-form">

	<?php
	
		//// LOOPS OUR COLUMNS
		$i = 0;
		$all_fields = json_decode($form_fields);
		if(is_object($all_fields)) :
		foreach(json_decode($form_fields) as $column) :
	
	?>
    
    	<li class="col-index-<?php echo $i; ?>">
        
        	<ul>
            
            	<?php
				
					//// LET'S LOOPS EACH FIELD
					foreach($column as $field) :
		
					$field_type = $field->type;
					
					$title = $field->title;
					$id = $field->id;
					$this_post = true;
					$slug = $field->type;
					if($field->type != 'divider' && $field->type != 'open_column' && $field->type != 'close_column') {
						
						$label = $field->label;
						
						//// LETS DO A QUERY ON THIS OBJECT
						if($the_post = get_post($field->id)) {
							
							$title = $the_post->post_title;
							$field_type = get_post_meta($field->id, 'field_type', true);
							
							$slug = $the_post->post_name;
							
						} else { $this_post = false; }
						
					}
					
					//// IF FIELD ACTUALLY EXISTS
					if($this_post) :
					
					if($field_type == 'text') { $icon = 'doc-text'; }
					if($field_type == 'dropdown') { $icon = 'arrow-combo'; }
					if($field_type == 'min_val') { $icon = 'up'; }
					if($field_type == 'max_val') { $icon = 'down'; }
					if($field_type == 'range') { $icon = 'resize-horizontal'; }
					if($field_type == 'rating') { $icon = 'star'; }
					if($field_type == 'dependent') { $icon = 'flow-tree'; }
					if($field_type == 'check') { $icon = 'check'; }
					if($field_type == 'divider') { $icon = 'minus'; }
					if($field_type == 'open_column') { $icon = 'columns'; }
					if($field_type == 'close_column') { $icon = 'columns'; }
				
				?>
                
                	<li class="field-id-<?php echo $id; ?>">
                    
                    	<div class="head" onclick="jQuery(this).openInsider(); jQuery('#the_form').refreshFormFields();">
                        
                        	<span class="title"><i class="icon-<?php echo $icon; ?>"></i><?php echo $title; ?></span>
                            
                            <span class="arrow"></span>
                            
                        </div>
                        
                        <div class="insider" style="display: none;">
                        
                        	<?php if($field->type != 'divider' && $field->type != 'open_column' && $field->type != 'close_column') : ?>
                        
                                <label><?php _e('Label', 'btoa'); ?></label>
                                <input type="text" class="widefat field_label" value="<?php echo $label; ?>" onblur="jQuery(this).refreshFormFields();">
                                
                                <div class="bDivider" style="margin: 10px 0;"></div>
											
												
									 <?php
									 
										//// IF THE USER HAS WPML
										if(isset($sitepress)) :
										
											//// IF WE HAVE MORE THAN 1 LANGUAGE
											if(count($sitepress->get_active_languages()) > 1) :
									 
									 ?>
										
											<?php
											
												$lang_val = '';
											
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
														
														if(isset($field->wpml)) {
															
															$lang_val = (array)$field->wpml;
															if(isset($lang_val[$lang['code']])) { $lang_val = $lang_val[$lang['code']]; }
															
														}
											
											?>
											
												<label><img src="<?php echo $flag_url ?>" /> &nbsp;<?php _e('Label', 'btoa'); ?> (<?php echo $lang['code']; ?>): </label>
												<input type="text" class="widefat value_name_wpml value_name_wpml_<?php echo $lang['code']; ?>" data-lang="<?php echo $lang['code']; ?>" value="<?php echo $lang_val; ?>" onblur="jQuery(this).refreshFormFields();" />
		
										<div class="clear"></div>
										<div class="bDivider" style="margin: 10px 0;"></div>
											
											<?php } endforeach; ?>
									 
									 <?php
									 	
											endif; /// ENDS IF HAS MORE THAN ONE LANGUAGE
									 
									 	endif; /// ENDS IF SITEPRESS
										
									?>
									
									
								
									<label>Only show this field if:</label>
									<ul class="field-if"<?php if(isset($field->field_if)) :  ?> style="display: none;"<?php endif; ?>>
									
										<li class="no-item">Drop field here</li>
									
									</ul>
									
									<?php
									
										if($field_if = get_post($field->field_if->id)) {
											
											if(get_post_type($field_if) == 'search_field') {
												
												$the_field_type = get_post_meta($field->field_if->id, 'field_type', true);
												
												if($the_field_type == 'dropdown' || $the_field_type == 'min_val' || $the_field_type == 'max_val' || $the_field_type == 'check') { ?>
													
													<div class="the-if-field">
					
														<div class="head"><strong><?php echo $field_if->post_title; ?></strong></div>
														<!-- .head -->
														
														<div class="insider">
														
															<input type="hidden" name="field_if_id" value="<?php echo $field->field_if->id ?>" />
						
						
															<?php if($the_field_type == 'dropdown') : //// IF IT"S A DROPDOWN ?>
															
																<p style="margin: 5px 0;"><?php _e('Is one of the following:', 'btoa'); ?></p>
																
																<select multiple class="widefat" name="field_if_values">
																
																	<?php
																	
																		//// IF WE ARE USING CUSTOM VALUES
																		if(get_post_meta($field->field_if->id, 'dropdown_type', true) == 'custom') {
																	
																			///// GETS ALL DROPDOWNS AVAILABLE AND DISPLAYS THEM
																			$dropdown_fields = json_decode(htmlspecialchars_decode(get_post_meta($field->field_if->id, 'dropdown_values', true)));
																			
																			if(is_object($dropdown_fields)) {
																				
																				foreach($dropdown_fields as $key => $value) {
																					
																					echo '<option value="'.$value->id.'"';
																					
																					//// IF ITS ONE OF OUR VALUES
																					if(in_array($value->id, $field->field_if->values)) { echo ' selected="selected"'; }
																					
																					echo '>'.$value->label.'</option>';
																					
																				}
																				
																			}
																		
																		} else {
																	
																			///// GETS ALL DROPDOWNS AVAILABLE AND DISPLAYS THEM
																			$dropdown_fields = get_terms('spot_cats', array('hide_empty' => false));
																			
																			if(is_array($dropdown_fields)) {
																				
																				foreach($dropdown_fields as $_term) {
																					
																					echo '<option value="'.$_term->slug.'"';
																					
																					//// IF ITS ONE OF OUR VALUES
																					if(in_array($_term->slug, $field->field_if->values)) { echo ' selected="selected"'; }
																					
																					echo '>'.$_term->name.'</option>';
																					
																				}
																				
																			}
																			
																		}
																	
																	?>
																
																</select>
																
																<p><input type="checkbox" name="field_if_values_any"<?php if(in_array('all', $field->field_if->values)) { echo ' checked="checked"'; } ?> /> <?php _e('Show this field if nothing is selected.', 'btoa'); ?></p>
															
															<?php endif; ?>
						
						
						
						
															<?php if($the_field_type == 'min_val' || $the_field_type == 'max_val') : //// IF IT"S A MINIMUM OR MAXIMUM VALUE ?>
															
																<p style="margin: 5px 0;"><?php _e('Is one of the following:', 'btoa'); ?></p>
																
																<select multiple class="widefat" name="field_if_values">
																
																	<?php
																	
																		//// IF MINIMU MVALUES
																		if($the_field_type == 'min_val') {
																			
																			$values = json_decode(htmlspecialchars_decode(get_post_meta($field->field_if->id, 'min_val_values', true)));
																			
																		} else {
																			
																			$values = json_decode(htmlspecialchars_decode(get_post_meta($field->field_if->id, 'max_val_values', true)));
																			
																		}
																		
																		if(is_object($values)) {
																		
																			foreach($values as $key => $value) {
																					
																				echo '<option value="'.$value->value.'"';
																				
																				//// IF ITS ONE OF OUR VALUES
																				if(in_array($value->value, $field->field_if->values)) { echo ' selected="selected"'; }
																				
																				echo '>'.$value->label.'</option>';
																				
																			}
																			
																		}
																	
																	?>
																
																</select>
															
															<?php endif; ?>
															
															
															
															<input type="button" class="button" value="Remove This" onclick="jQuery(this).remove_this_if_field();" style="margin-top: 10px;" />
															
														</div>
														<!-- .insider -->
													
													</div>
													<!-- .the-if-field -->
													
												<?php }
												
											}
											
										}
									
									?>
                                
                                <div class="bDivider" style="margin: 10px 0;"></div>
                            
                            <?php endif; ?>
                            
                            <input type="button" class="button" value="Remove Field" onclick="jQuery(this).removeThisFormField();" />
                            <input type="hidden" name="field_type" value="<?php echo $field_type; ?>" />
                            <input type="hidden" name="the_id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="the_slug" value="<?php echo $slug; ?>" />
                            
                        </div>
                    
                    </li>
                
                <?php endif; endforeach; ?>
            
            </ul>
        
        </li>
    
    <?php $i++; endforeach; endif; ?>

</ul>
<div class="clear"></div>

<script>

	jQuery(document).ready(function() {
		
		//// SETS THE COLUMNS IN OUR FORM AREA
		
		//// IF COLUMNS ARE EMPTY
		<?php if(get_post_meta($post->ID, 'column_layout', true) == '') : ?>
		for(i=0; i<jQuery('.column_layout > option:selected').val(); i++) { 
		
			//// GETS THE WIDTH OF EACH COLUMN
			var colLength = jQuery('.column_layout > option:selected').val();
			var theWidth = ((100 - ((colLength-1)*4)) / colLength) - 1;
			
			jQuery('#the-form').append('<li style="width: '+theWidth+'%;" class="col-index-'+i+'"><ul></ul></li>');
		
		}
		<?php else: ?>
		
		//// SETS COLUMN SIZES
		for(i=0; i<jQuery('.column_layout > option:selected').val(); i++) { 
		
			var colLength = jQuery('.column_layout > option:selected').val();
			var theWidth = ((100 - ((colLength-1)*4)) / colLength) - 1;
			
			jQuery('#the-form > li').css({ width: theWidth+'%' });
		
		}
		
		
		<?php endif; ?>
		
		//// ON CHANGE COLUMNS
		jQuery('.column_layout').change(function() {
			
			var c = confirm('If you change your column layout, all fields assigned will be lost and you will have to reassign them to the columns. Are you sure you want to do this?');
			
			if(c) {
				
				jQuery('#the-form').html('');
		
				//// SETS THE COLUMNS IN OUR FORM AREA
				for(i=0; i<jQuery('.column_layout > option:selected').val(); i++) { 
				
					//// GETS THE WIDTH OF EACH COLUMN
					var colLength = jQuery('.column_layout > option:selected').val();
					var theWidth = ((100 - ((colLength-1)*4)) / colLength) - 1;
					
					jQuery('#the-form').append('<li style="width: '+theWidth+'%;" class="col-index-'+i+'"><ul></ul></li>');
				
				}
				
				sortTheForm();
				
			}
			
		});
		
		sortTheForm();
		
	});

</script>

<ul id="the-fields">

	<?php
	
		//// LOOPS THOUGH OUR SEARCH FIELDS AND DISPLAYES THEM
		$args = array(
		
			'post_type' => 'search_field',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		
		);
		
		$sQ = new WP_Query($args);
		
		while($sQ->have_posts()) :$sQ->the_post();
		
		
		$field_type = get_post_meta(get_the_ID(), 'field_type', true);
		
		if($field_type == 'text') { $icon = 'doc-text'; }
		if($field_type == 'dropdown') { $icon = 'arrow-combo'; }
		if($field_type == 'min_val') { $icon = 'up'; }
		if($field_type == 'max_val') { $icon = 'down'; }
		if($field_type == 'range') { $icon = 'resize-horizontal'; }
		if($field_type == 'rating') { $icon = 'star'; }
		if($field_type == 'dependent') { $icon = 'flow-tree'; }
		if($field_type == 'check') { $icon = 'check'; }
									 
			//// IF THE USER HAS WPML
			if(isset($sitepress)) :
			
				//// IF WE HAVE MORE THAN 1 LANGUAGE
				if(count($sitepress->get_active_languages()) > 1) :
											
					$lang_val = '';
					$the_lang_code = '';
				
					/// LETS LOOP EACH LANGUAGE AND ADD THEM AS A FIELD
					foreach($sitepress->get_active_languages() as $lang) :
					
						$include_lang = false;
					
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
							
							$the_lang_code .= '<span class="hidden the_lang_code">'.$lang['code'].'</span>';
							$the_lang_code .= '<span class="hidden the_lang_label the_lang_label_'.$lang['code'].'"><img src="'.$flag_url.'" /> &nbsp;'.__('Label', 'btoa').' ('.$lang['code'].'):</span>';
							
						}
						
					endforeach;
					
				endif;
				
				endif;
				
				?>
    
    	<li class="id-<?php echo get_the_ID(); ?> type-<?php echo $field_type; ?>">
        
        	<span class="icon"><i class="icon-<?php echo $icon; ?>"></i></span>
            
            <h4><?php the_title(); ?></h4>
            
            <h5><?php echo $field_type ?></h5>
            
            <span class="hidden the_id"><?php echo get_the_ID(); ?></span>
            <span class="hidden the_type"><?php echo $field_type; ?></span>
            <span class="hidden the_slug"><?php echo $post->post_name; ?></span>
			<?php if(isset($sitepress)): if($the_lang_code != '') : ?><?php echo $the_lang_code; ?><?php endif; endif; ?>
        
        </li>
    
    <?php endwhile; wp_reset_postdata(); ?>
    
    	<li class="id-0 type-divider">
        
        	<span class="icon"><i class="icon-minus"></i></span>
            
            <h4><?php _e('Divider', 'btoa'); ?></h4>
            
            <h5>divider</h5>
            
            <span class="hidden the_id">0</span>
            <span class="hidden the_type">divider</span>
            <span class="hidden the_slug">divider</span>
        
        </li>
    
    	<li class="id-0 type-open-column">
        
        	<span class="icon"><i class="icon-columns"></i></span>
            
            <h4><?php _e('Open Column', 'btoa'); ?></h4>
            
            <h5>advanced</h5>
            
            <span class="hidden the_id">0</span>
            <span class="hidden the_type">open_column</span>
            <span class="hidden the_slug">open_column</span>
        
        </li>
    
    	<li class="id-0 type-close-column">
        
        	<span class="icon"><i class="icon-columns"></i></span>
            
            <h4><?php _e('Close Column', 'btoa'); ?></h4>
            
            <h5>advanced</h5>
            
            <span class="hidden the_id">0</span>
            <span class="hidden the_type">close_column</span>
            <span class="hidden the_slug">close_column</span>
        
        </li>

</ul>

<div class="clear"></div>

<div class="clear"></div>
<!-- /.clear/ -->