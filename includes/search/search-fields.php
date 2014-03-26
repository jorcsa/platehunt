<form id="search-spots" action="<?php echo home_url(); ?>" method="post">

<!-- DAHERO #1667517 STRT -->
			<span id="clear-filter" class="responsive-only"><i class="icon-eraser"></i> <?php _e('Clear Search', 'btoa'); ?></span>
<!-- DAHERO #1667517 STOP -->
			<span id="finish-filter" class="responsive-only"><i class="icon-ok"></i> <?php _e('Finish Filtering', 'btoa'); ?></span>

			<?php //// THIS ARE FIELDS FORDISTANCE VALUES ?>
			<input type="hidden" id="_sf_enable_radius_search" value="false" name="_sf_enable_radius_search" />
			<input type="hidden" id="_sf_radius_lat_from" value="" name="_sf_radius_lat_from" />
			<input type="hidden" id="_sf_radius_lat_to" value="" name="_sf_radius_lat_to" />
			<input type="hidden" id="_sf_radius_lng_from" value="" name="_sf_radius_lng_from" />
			<input type="hidden" id="_sf_radius_lng_to" value="" name="_sf_radius_lng_to" />
			<input type="hidden" id="_sf_radius_center_lat" value="" name="_sf_radius_center_lat" />
			<input type="hidden" id="_sf_radius_center_lng" value="" name="_sf_radius_center_lng" />
			<input type="hidden" id="_sf_radius_field" value="false" name="_sf_radius_field" />
			<input type="hidden" id="_sf_radius_field_id" value="false" name="_sf_radius_field_id" />
			<input type="hidden" id="_sf_post_ids" value="" name="_sf_post_ids" />
			
			<?php $radius = ''; if(isset($_GET['radius'])) { if(is_numeric($_GET['radius'])) { $radius = $_GET['radius']; } } ?>
			
			<input type="hidden" id="_sf_radius_distance" value="<?php echo $radius; ?>" name="_sf_radius_distance" />

			<?php if(is_tax('spot_cats')) : ?><input type="hidden" name="is_taxonomy" value="true" id="_sf_search_is_taxonomy" /><?php endif; ?>
			
			
			
			<?php
			
				global $sitepress;
			
				//// IF ITS A LISTINGS PAGE WE NEED TO MAKE SURE WE INCLUDE THE URL FOR IT INCASE OF MULTIPLE LISTINGS PAGE
				if(is_page()) : if(get_post_meta($post->ID, '_wp_page_template', true) == 'listings.php') :
			
			?>
			
				<input type="hidden" value="<?php echo get_permalink($post->ID); ?>" name="_sf_listings_page_url" />
			
			<?php endif; endif; ?>
			
			
			
        
        	<?php
			
				//// LETS GET OUR SEARCH FIELD AND ITS FIELDS
				$home_search = _sf_get_page_search_form();
				if(!is_numeric($home_search)) {
					
					$args = array(
					
						'post_type' => 'search_form',
						'posts_per_page' => 1,
					
					);
					
					$homeSearchQuery = new WP_Query($args);
					
					if(sizeof($homeSearchQuery->posts) > 0) { foreach($homeSearchQuery->posts as $_post) { $home_search = $_post->ID; break; } }
					
				}
				
				//// IF WE HAVE A SEARCH FORM
				if(is_numeric($home_search)) :
				
				//// GETS OUUR HOME FORM POST
				$the_search = new WP_Query(array(
				
					'post_type' => 'search_form',
					'p' => $home_search,
				
				));
				
				if($the_search->have_posts()) : while($the_search->have_posts()) : $the_search->the_post();
				
				//// GETS THE FIELDS
				$columns = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'form_fields', true)));
				$columns_no = count((array)$columns);
				$one_halves = 1;
				
				//// PROPER CLASS DEPENDING ON THE NUMBER OF COLUMNS
				switch($columns_no) {
					
					case 1:
						$the_class = 'large-12';
						break;
					
					case 2:
						$the_class = 'large-6';
						break;
					
					case 3:
						$the_class = 'large-4';
						break;
					
					case 4:
						$the_class = 'large-3';
						break;
					
					case 5:
						$the_class = 'large-2';
						break;
					
					default:
						$the_class = 'one';
						break;
					
				}
				
				$hidden_array = array();
				
				//// LOOPS OUR COLUMNS
				$i = 1; foreach($columns as $column) :
				
			
			?>
            
            	<div class="<?php echo $the_class; ?><?php if($i%$columns_no == 0) { echo ' last'; } ?> columns" id="search-form-column-<?php echo $i; ?>">
                
                	<?php
					
						///// LET'S LOOP THE FILEDS IN THIS COLUMNS
						foreach($column as $field) :
						
						//// IF NOT DIVIDER OR COLUMN GETS OUR FILED TYPE
						if($field->type != 'divider' && $field->type != 'close_column' && $field->type != 'open_column' && $field->type != 'button') { $the_type = get_post_meta($field->id, 'field_type', true); }
						else { $the_type = $field->type; }
						
						if(!empty($the_type)) :
					
					?>
					
					
					
					
					
					
						<?php
						
							$is_if_field = false;
						
							//// DEALS WITH IF FIELDS
							if(isset($field->field_if->id)) {
								
								//// IF ITS A SEARCH FIELD
								if($if_field = get_post($field->field_if->id)) {
									
									if(get_post_type($if_field) == 'search_field') {
										
										//// IF IT IS ONE OF THE ALLOWED TYPES
										$if_field_type = get_post_meta($if_field->ID, 'field_type', true);
										if($if_field_type == 'dropdown' || $if_field_type == 'min_val' || $if_field_type == 'max_val' || $if_field_type == 'check') {
											
											//// SETS IT TO TRUE
											$is_if_field = true;
											
											///// NOW WE ADD A JAVACSRIPT EVENT FOR IT 
											
											$hidden_array[] = $field->id;
											
											?>
											
											<input type="hidden" name="sf_if_<?php echo $field->id ?>_parent" id="sf_if_<?php echo $field->id ?>_parent" value="<?php echo $field->field_if->id ?>" />
											<?php if($if_field_type != 'check') : ?><input type="hidden" name="sf_if_<?php echo $field->id ?>_values" id="sf_if_<?php echo $field->id ?>_values" value="<?php echo implode('||', $field->field_if->values); ?>" /><?php endif; ?>
											
											<script type="text/javascript">
											
												jQuery(document).ready(function() {
													
													<?php if($if_field_type == 'dropdown') :  ?>
													
														jQuery('select.parent-<?php echo $field->field_if->id ?>')._sf_if_dropdown('sf_if_<?php echo $field->id ?>', [<?php foreach($field->field_if->values as $if_value) { echo "'".$if_value."', "; } ?>], 'sf_if_<?php echo $field->id ?>_nonce');
														
													<?php endif; ?>
													
													<?php if($if_field_type == 'max_val' || $if_field_type == 'min_val') :  ?>
													
														jQuery('select.sf_if_<?php echo $field->field_if->id ?>')._sf_if_dropdown('sf_if_<?php echo $field->id ?>', [<?php foreach($field->field_if->values as $if_value) { echo "'".$if_value."', "; } ?>], 'sf_if_<?php echo $field->id ?>_nonce');
														
													<?php endif; ?>
													
													<?php if($if_field_type == 'check') :  ?>
													
														jQuery('input.sf_if_<?php echo $field->field_if->id ?>')._sf_if_check('sf_if_<?php echo $field->id ?>', 'sf_if_<?php echo $field->id ?>_nonce');
														
													<?php endif; ?>
													
													
												});
											
											</script>
											
										<?php }
										
									}
									
								}
								
							}
						
						?>
					
					
					
					
					
					
                    
                    	<?php if($the_type == 'text') : //// IF IT'S A TEXT FIELD ?>
                        
                        	<?php if($field->label != '') : ?><label class="sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo $field->label; ?></label><?php endif; //// IF WE HAVE A LABEL ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
								
								
								///// CHECKS FOR INITIAL FIELD
								$sel_val = get_post_meta($this_field->ID, 'text_default', true);
								if(isset($_GET[$this_field->post_name])) {
									
									//// IF WE ARE USING TAGS
									if($sel_term = get_term_by('slug', $_GET[$this_field->post_name], 'spot_tags')) {
										
										$sel_val = $sel_term->name;
										
									}
									
								}
									
								///// IF ITS GOOGLE PLACES WE NEED TO GET IT BY gplace
								if(get_post_meta($this_field->ID, 'text_type', true) != 'tags') { ?>
									
									<input type="hidden" name="_sf_field_<?php echo $this_field->ID ?>_lat" value="<?php if(isset($_GET['glat'])) { echo $_GET['glat']; } ?>" class="_sf_field_places_lat" id="_sf_field_<?php echo $this_field->ID ?>_lat" />
									<input type="hidden" name="_sf_field_<?php echo $this_field->ID ?>_lng" value="<?php if(isset($_GET['glng'])) { echo $_GET['glng']; } ?>" class="_sf_field_places_lng" id="_sf_field_<?php echo $this_field->ID ?>_lng" />
					
								<?php
								
									if(isset($_GET['gplace'])) {
										
										$sel_val = urldecode($_GET['gplace']);
										
									}
									
								}
								
								//// RESOLVES THE CLASS OF THE TET FIELD - IN CASE TAG OR GOOGLE PLACES
								$field_class = 'type-text look-'.get_post_meta($field->id, 'text_type', true).' sf_if_'.$field->id;
								if(get_post_meta($field->id, 'text_autoload', true) == 'on') { $field_class .= ' autoload'; }
								
								
								///// GETS THE PLACEHOLDER TEXT
								$sel_val = get_post_meta($this_field->ID, 'text_default', true);
								
								///// IF WPML LETS GET THE TRANSLATED VALUE
								if(isset($sitepress)) {
									
									$temp_placeholder = get_post_meta($this_field->ID, 'text_default_'.ICL_LANGUAGE_CODE, true);
									
									if($temp_placeholder != '') {
										
										$sel_val = $temp_placeholder;
										
									}
									
								}
								
							
							?>
                            
							
							
                            <span class="type-text-wrapper">
<?php
// DAHERO #1667459 STRT

switch ($this_field->post_name) {
	case 'location':
		if (isset($_GET['glng'])) $sel_val = $_GET['gplace'];
		break;
	case 'keywords':
		if (isset($_GET['keywords'])) $sel_val = $_GET['keywords'];
		break;
}

// DAHERO #1667459 STOP
?>
							   	<input type="text"
									value="<?=$sel_val;?>"
									id="_sf_field_<?php echo $field->id; ?>"
									class="<?php echo $field_class; ?>"
									name="<?php echo $this_field->post_name ?>"
									onfocus="if(jQuery(this).val() == '<?php echo $sel_val; ?>') { jQuery(this).val('') }"
									onblur="if(jQuery(this).val() == '') { jQuery(this).val('<?php echo $sel_val; ?>') }"
									<?php if(in_array($field->id, $hidden_array)) : ?>style="display: none;"<?php endif; ?> />
                            
                                <ul>
                                
                                </ul>
                            
                            </span>
							
                            
                            <?php
							
									//// IF AUTOLOAD
									if(get_post_meta($field->id, 'text_autoload', true) == 'on') :
								
								?>
                            
								<script type="text/javascript">
								
// DAHERO #1667462 STRT
										<?php if(get_post_meta($this_field->ID, 'text_type', true) == 'tags') : ?>
									jQuery(document).ready(function() {
											jQuery('#_sf_field_<?php echo $field->id; ?>').btoaLoadTagSuggestions('<?php echo get_post_meta($this_field->ID, 'text_default', true); ?>');
									});
										<?php else : ?>
									jQuery(document).bind('_ph_google_sync', function() {
											jQuery('#_sf_field_<?php echo $field->id; ?>').btoaLoadGooglePlacesSuggestions('<?php echo get_post_meta($this_field->ID, 'text_default', true); ?>', '<?php echo get_post_meta($this_field->ID, 'google_places_country', true); ?>');
									});
										<?php endif; ?>
// DAHERO #1667462 STOP
								
								</script>
                            
                           <?php endif; ?>
                        
                        
                        
                        
                        
                        
                        
                        <?php elseif($field->type == 'dropdown') : //// IF IT'S A DROPDOWN ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
								
								
								//// CHECKS FOR LABEL WPML
								$label = get_form_wpml_label($field);
							
							?>
                        
                        	<?php if($field->label != '') : ?><label class="sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo $label; ?></label><?php endif; //// IF WE HAVE A LABEL ?>
							
							<?php 
										
								//// CHECKS FOR SELECTED VALUE
								if(isset($_GET[$this_field->post_name])) { $sel_val = $_GET[$this_field->post_name]; }
								else { $sel_val = ''; }
								
							?>
                            
                            <input type="hidden" name="has_changed_<?php echo $this_field->post_name; ?>" id="has_changed_<?php echo $this_field->post_name; ?>" value="<?php if($sel_val == '') { echo 'false'; } else { echo 'true'; } ?>" />
							
							<?php if(get_post_meta($field->id, 'dropdown_change_location', true)) : //// IF WE ARE CHANGING LOCATION - WE NEED TO PUT THIF FIELD TO DEAL WITH RADIUS ?>
								<input type="hidden" name="_sf_ignore_sel_<?php echo $this_field->ID; ?>" value="false" class="_sf_ignore_sel _sf_ignore_sel_<?php echo $this_field->ID; ?>" />
								<?php endif; ?>
							   
                            <select name="<?php echo $this_field->post_name; ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?> class="parent-<?php echo $field->id; ?> sf_if_<?php echo $field->id ?> type-dropdown<?php if(get_post_meta($field->id, 'dropdown_change_location', true) == 'on') { echo ' change-location'; } //// IF IT CHANGES THE MAP ?>" onchange="jQuery('#has_changed_<?php echo $this_field->post_name; ?>').val('true'); <?php if(get_post_meta($field->id, 'dropdown_change_location', true)) : ?>jQuery(this)._sf_check_for_radius(<?php echo $field->id; ?>);<?php endif ?> jQuery('#search-spots').submit(); jQuery('#has_changed_<?php echo $this_field->post_name; ?>').val('false');">
                            
                            	<option value=""><?php _e('All', 'btoa'); ?></option>
                            
                            	<?php 
									
									//// IF ITS CATEGORIES
									if(get_post_meta($this_field->ID, 'dropdown_type', true) == 'categories') {
										
										//// CHECKS FOR SELECTED VALUE
										if(isset($_GET[$this_field->post_name])) { $sel_val = $_GET[$this_field->post_name]; }
										else { $sel_val = ''; }
										
										//// IF ITS A TAXONOMY PAGE LETS CHANGE OUR SELECTED VALUE
										if(is_tax('spot_cats')) {
											
											$queried_object = get_queried_object();
											$sel_val = $queried_object->slug;
											
										}
										
										$values = get_post_meta($this_field->ID, 'dropdown_categories', true);
										if(!is_array($values)) { $values = array('all'); }
											
										if(in_array('all', $values)) { $tax_values = get_terms('spot_cats', array('hide_empty' => 0)); $values = array(); foreach($tax_values as $_tax) { $values[] = $_tax->term_id; } }
										
										foreach($values as $tax_id) { $this_tax = get_term_by('id', $tax_id, 'spot_cats'); ?>
											
											<option value="<?php echo $this_tax->slug ?>"<?php if($this_tax->slug == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $this_tax->name ?></option>
											
										<?php }
										
									} else {
									
										$values = json_decode(htmlspecialchars_decode(get_post_meta($field->id, 'dropdown_values', true)));
									
										//// LOOPS OUR VALUES
										if(is_object($values)) : foreach($values as $opt) :
										
										//// CHECKS FOR SELECTED VALUE
										if(isset($_GET[$this_field->post_name])) { $sel_val = $_GET[$this_field->post_name]; }
										else { $sel_val = ''; }
										
									?>
									
										<?php
										
											$label = $opt->label;
										
											///// CHECKS FOR WPML
											if(isset($sitepress)) {
												
												//// CHECKS TO SEE IF THIS OPTION HAS A LABEL TRANSLATED
												//// IF OUR WPML ISSET
												if(isset($opt->wpml)) {
													
													$wpml = (array)$opt->wpml;
													
													$cur_lang = ICL_LANGUAGE_CODE;
													
													//// CHECKS FOR LANGUAGE
													if(isset($wpml[$cur_lang])) {
														
														//// IF IT HAS SOMETHING
														if($wpml[$cur_lang] != '') {
															
															$label = $wpml[$cur_lang];
															
														}
														
													}
													
												}
												
											}
										
										?>
									
										<option value="<?php echo $opt->id ?>"<?php if($opt->id == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $label ?></option>
									
									<?php endforeach; endif;
									
									} /// ENDS IF ITS CUSTOM VALUES
									
									?>
                            
                            </select>
                            
                            
                            
                            
                            
                        
                        <?php elseif($field->type == 'dependent') : $the_parent = get_post_meta($field->id, 'dependent_parent', true); //// IF IT'S A DEPENDENT ?>
                        
                        	<?php if($field->label != '') : ?><label class="sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo get_form_wpml_label($field); ?></label><?php endif; //// IF WE HAVE A LABEL ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
									
								//// CHECKS FOR SELECTED VALUE
								if(isset($_GET[$this_field->post_name])) { $sel_val = $_GET[$this_field->post_name]; }
								else { $sel_val = ''; }
							
							?>
                            
                            <script type="text/javascript">
							
								jQuery(document).ready(function() {
									
									//// WHEN THE PARENT CHANGES, WE NNED TO CHANGE THIS DEPENDENT
									jQuery('select.parent-<?php echo $the_parent; ?>').change(function() {
										
										console.log('change');
										
										//// SELECTED VAL
										var sel = jQuery(this).children('option:selected').val();
										var this_field = <?php echo $field->id; ?>
										
										//// CHANGES THE DEPENDENT AND ALSO TRIGGER CHANGES SO OTHER DEPENDENTS CAN GO AHEAD
										jQuery('select[name="<?php echo $this_field->post_name; ?>"]').btoaReloadDependentField(sel, this_field, function() {
											
											//// LETS RELOAD OUR AJAX
											jQuery('#search-spots').submit();
											
										});
									
										//// MAKES SURE WE FIND ANY CHILDREN AND RESET THEM
										//jQuery('select.parent-dropdown-<?php echo $field->id; ?>').html('<option value="0">-</option>');
										//jQuery('select.parent-dropdown-<?php echo $field->id; ?>').siblings('span').text('-');
										
									});
									
									//// MAKES SURE OUR PARENT IS OFF
									<?php if($sel_val != '') : $the_parent_post = get_post($the_parent); ?>jQuery('#has_changed_<?php echo $the_parent_post->post_name; ?>').val('false');<?php endif; ?>
									
								});
							
							</script>
                            
                            <input type="hidden" name="has_changed_<?php echo $this_field->post_name; ?>" id="has_changed_<?php echo $this_field->post_name; ?>" value="false" />
							
							<?php if(get_post_meta($field->id, 'dependent_change_location', true)) : //// IF WE ARE CHANGING LOCATION - WE NEED TO PUT THIF FIELD TO DEAL WITH RADIUS ?>
								<input type="hidden" name="_sf_ignore_sel_<?php echo $this_field->ID; ?>" id="_sf_ignore_sel_<?php echo $this_field->ID; ?>" value="false" class="_sf_ignore_sel _sf_ignore_sel_<?php echo $this_field->ID; ?>" />
								<?php endif; ?>
                            
                            <select name="<?php echo $this_field->post_name; ?>" class="parent-<?php echo $field->id; ?> sf_if_<?php echo $field->id ?> parent-dropdown-<?php echo $the_parent; ?> type-dropdown<?php if(get_post_meta($field->id, 'dependent_change_location', true) == 'on') { echo ' change-location'; } //// IF IT CHANGES THE MAP ?>" onchange="jQuery('#has_changed_<?php echo $this_field->post_name; ?>').val('true'); <?php if(get_post_meta($field->id, 'dependent_change_location', true)) : ?>jQuery(this)._sf_check_for_radius(<?php echo $field->id; ?>);<?php endif; ?> jQuery('#search-spots').submit(); jQuery('#has_changed_<?php echo $this_field->post_name; ?>').val('false');"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>>
							
							<option value=""><?php _e('-', 'btoa'); ?></option>
							
								<?php
								
									$this_parent_field = get_post($the_parent);
								
									//// IF THIS DEPENDENTS DROPDOWN IS CATEGORIES
									if(get_post_meta($this_parent_field->ID, 'dropdown_type', true) == 'categories') {
									
										//// IF OUR PARENT IS SELECTED WE GET THE APPROPRIATE SUBCATEGORIES
										if(isset($_GET[$this_parent_field->post_name])) {
											
											$parent_value = $_GET[$this_parent_field->post_name];
											$parent_cat = get_term_by('slug', $parent_value, 'spot_cats');
											
											//// IF ITS A VALID CATEGORY
											if($parent_cat) {
				
												//// CATEGORIES TO INCLUDE
												$include = get_post_meta($_POST['post_id'], 'dropdown_categories', true);
												if(!is_array($include)) { $include = array(); }
												elseif(in_array('all', $include)) { $include = array(); }
				
												//// ITS A CATEGORY SO WE NEED TO GET SUBCATEGORIES FOR THIS ITEM
												$the_terms = get_terms('spot_cats', array(
												
													'hide_empty' => false,
													'child_of' => $parent_cat->term_id,
													'include' => $include,
												
												));
												
												//// IF WE HAVE FOUND SUB CATEGORIES
												if($the_terms) {
													
													echo '<option value="">'.__('Any', 'btoa').'</option>';
													
													foreach($the_terms as $_term) { ?>
														
														 <option value="<?php echo $_term->slug ?>"<?php if($_term->slug == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $_term->name ?></option>
														
													<?php }
													
												}
											
											}
											
											
										}
										
									} else  {
								
								?>
                            
                            	<?php 
									
									$values = json_decode(htmlspecialchars_decode(get_post_meta($field->id, 'dropdown_values', true)));
									$section = '';
									
									//// IF OUR PARENT IS SELECTED WE GET THE APPROPRIATE SECTION
									if(isset($_GET[$this_parent_field->post_name])) {
										
										//// GETS VALUES BASED ON PARENT
										$parent_value = $_GET[$this_parent_field->post_name]; 
										$values = json_decode(htmlspecialchars_decode(get_post_meta($field->id, 'dependent_values', true)));
										
										//// GOES THROUGH OUR DEPENCDENT SECTIONS AND LOOK FOR THE PARENT SECTION
										foreach($values as $key => $_section) {
											
											//// IF THSI IS OUR SETION SELECT IT
											if($key == $parent_value) { $section = $_section; }
											
										}
										
									}
								
									//// LOOPS OUR VALUES
									if(is_object($section)) : foreach($section as $opt) :
									
										
									$label = $opt->label;
								
									///// CHECKS FOR WPML
									if(isset($sitepress)) {
										
										//// CHECKS TO SEE IF THIS OPTION HAS A LABEL TRANSLATED
										//// IF OUR WPML ISSET
										if(isset($opt->wpml)) {
											
											$wpml = (array)$opt->wpml;
											
											$cur_lang = ICL_LANGUAGE_CODE;
											
											//// CHECKS FOR LANGUAGE
											if(isset($wpml[$cur_lang])) {
												
												//// IF IT HAS SOMETHING
												if($wpml[$cur_lang] != '') {
													
													$label = $wpml[$cur_lang];
													
												}
												
											}
											
										}
										
									}
								
								?>
                                
                                <option value="<?php echo $opt->id ?>"<?php if($opt->id == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $label ?></option>
                                
                                <?php endforeach;
								
										endif;
										
										
									} //// ENDS IF ITS FOR CATEGORIES - THE PARENT ?>
                            
                            </select>
                        
                        
                        
                        
                        
                        <?php elseif($field->type == 'min_val') : //// IF IT'S A MIN VAL ?>
                        
                        	<?php if($field->label != '') : ?><label class="sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo get_form_wpml_label($field); ?></label><?php endif; //// IF WE HAVE A LABEL ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
							
							?>
                            
                            <select name="<?php echo $this_field->post_name; ?>" class="type-min_val sf_if_<?php echo $field->id ?>" onchange="jQuery('#search-spots').submit();"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>>
                            
                            	<?php 
									
									$values = json_decode(htmlspecialchars_decode(get_post_meta($field->id, 'min_val_values', true)));
								
									//// LOOPS OUR VALUES
									if(is_object($values)) : foreach($values as $opt) :
									
									//// CHECKS FOR SELECTED VALUE
									if(isset($_GET[$this_field->post_name])) { $sel_val = $_GET[$this_field->post_name]; }
									else { $sel_val = ''; }
									
									$label = $opt->label;
								
									///// CHECKS FOR WPML
									if(isset($sitepress)) {
										
										//// CHECKS TO SEE IF THIS OPTION HAS A LABEL TRANSLATED
										//// IF OUR WPML ISSET
										if(isset($opt->wpml)) {
											
											$wpml = (array)$opt->wpml;
											
											$cur_lang = ICL_LANGUAGE_CODE;
											
											//// CHECKS FOR LANGUAGE
											if(isset($wpml[$cur_lang])) {
												
												//// IF IT HAS SOMETHING
												if($wpml[$cur_lang] != '') {
													
													$label = $wpml[$cur_lang];
													
												}
												
											}
											
										}
										
									}
								
								?>
                                
                                	<option value="<?php echo $opt->value ?>"<?php if($opt->value == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $label ?></option>
                                
                                <?php endforeach; endif; ?>
                            
                            </select>
                            
                            
                            
                            
                            
                        
                        <?php elseif($field->type == 'max_val') : //// IF IT'S A MAX VAL ?>
                        
                        	<?php if($field->label != '') : ?><label class="sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo get_form_wpml_label($field); ?></label><?php endif; //// IF WE HAVE A LABEL ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
							
							?>
                            
                            <select name="<?php echo $this_field->post_name; ?>" class="type-max_val sf_if_<?php echo $field->id ?>" onchange="jQuery('#search-spots').submit();"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>>
                            
                            	<?php 
									
									$values = json_decode(htmlspecialchars_decode(get_post_meta($field->id, 'max_val_values', true)));
								
									//// LOOPS OUR VALUES
									if(is_object($values)) : foreach($values as $opt) :
									
									//// CHECKS FOR SELECTED VALUE
									if(isset($_GET[$this_field->post_name])) { $sel_val = $_GET[$this_field->post_name]; }
									else { $sel_val = ''; }
									
									$label = $opt->label;
								
									///// CHECKS FOR WPML
									if(isset($sitepress)) {
										
										//// CHECKS TO SEE IF THIS OPTION HAS A LABEL TRANSLATED
										//// IF OUR WPML ISSET
										if(isset($opt->wpml)) {
											
											$wpml = (array)$opt->wpml;
											
											$cur_lang = ICL_LANGUAGE_CODE;
											
											//// CHECKS FOR LANGUAGE
											if(isset($wpml[$cur_lang])) {
												
												//// IF IT HAS SOMETHING
												if($wpml[$cur_lang] != '') {
													
													$label = $wpml[$cur_lang];
													
												}
												
											}
											
										}
										
									}
								
								?>
                                
                                	<option value="<?php echo $opt->value ?>"<?php if($opt->value == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $label; ?></option>
                                
                                <?php endforeach; endif; ?>
                            
                            </select>
                        
                        
                        
                        
                        
                        
                        <?php elseif($field->type == 'range') : //// IF IT'S A RANGE ?>
                        
                        	<?php if($field->label != '') : ?><label class="sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo get_form_wpml_label($field); ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
									
								//// CHECKS FOR SELECTED VALUE
								if(isset($_GET[$this_field->post_name])) {
									
									//// GETS MINIMUM
									if(isset($_GET[$this_field->post_name.'_min'])) { $abs_min = $_GET[$this_field->post_name.'_min']; }
									else { $abs_min = get_post_meta($field->id, 'range_minimum', true); }
									
									//// GETS MAXIMUM
									if(isset($_GET[$this_field->post_name.'_max'])) { $abs_max = $_GET[$this_field->post_name.'_max']; }
									else { $abs_max = get_post_meta($field->id, 'range_maximum', true); }
									
								} else {
									
									//// SETS MINIMUM AND MAXIMUM
									$abs_min = get_post_meta($field->id, 'range_minimum', true);
									$abs_max = get_post_meta($field->id, 'range_maximum', true);
									
								}
								
								
								///// IF PRICE FORMAR
								if(get_post_meta($field->id, 'range_price', true) == 'on') {
									
									$min = str_replace('%', '<span>'.number_format($abs_min).'</span>', get_post_meta($field->id, 'range_label', true));
									$max = str_replace('%', '<span>'.number_format($abs_max).'</span>', get_post_meta($field->id, 'range_label', true));
									
								} else {
									
									$min = str_replace('%', '<span>'.$abs_min.'</span>', get_post_meta($field->id, 'range_label', true));
									$max = str_replace('%', '<span>'.$abs_max.'</span>', get_post_meta($field->id, 'range_label', true));
									
								}
								
							
							?>
                            
                            	<span class="range-label">
                                
                                	<span class="min"><?php echo $min; ?></span> - 
                                    
                                    <span class="max"><?php echo $max; ?></span>
                                    
                                </span>
                                
                            </label><?php endif; //// IF WE HAVE A LABEL ?>
                            
                            <input type="hidden" name="<?php echo $this_field->post_name ?>_min" value="<?php echo $abs_min; ?>" id="<?php echo $this_field->post_name ?>_min" />
                            <input type="hidden" name="<?php echo $this_field->post_name ?>_max" value="<?php echo $abs_max; ?>" id="<?php echo $this_field->post_name ?>_max" />
                            <input type="hidden" name="<?php echo $this_field->post_name ?>" value="true" />
                            
                            <script type="text/javascript">
							
								jQuery(document).ready(function() {
								
									jQuery('#field-range-<?php echo $field->id; ?>').slider({
										
										range: true,
										min: <?php echo get_post_meta($field->id, 'range_minimum', true); ?>,
										max: <?php echo get_post_meta($field->id, 'range_maximum', true); ?>,
										values: [<?php echo $abs_min; ?>, <?php echo $abs_max; ?>],
										<?php if(get_post_meta($field->id, 'range_increments', true) != '' && is_numeric(get_post_meta($field->id, 'range_increments', true))) : ?>step: <?php echo get_post_meta($field->id, 'range_increments', true) ?>,<?php endif; ?>
										slide: function(event, ui) {
											var value1 = ui.values[0];
											var value2 = ui.values[1];
											console.log(<?php echo $field->id ?>);
											<?php if(get_post_meta($field->id, 'range_price', true) == 'on') : /// ITS A PRICE FIELD ?>
											 var value1 = ui.values[0].formatMoney();
											 var value2 = ui.values[1].formatMoney();
											<?php endif; ?>
											
											//// CHANGES LABEL
											var theLabel = jQuery(this).parent().siblings('label.sf_if_<?php echo $field->id ?>');
											theLabel.find('.min span').text(value1);
											theLabel.find('.max span').text(value2);
											
											//// CHANGES INPUT
											jQuery('#<?php echo $this_field->post_name ?>_min').val(ui.values[0]);
											jQuery('#<?php echo $this_field->post_name ?>_max').val(ui.values[1]);
											
											
										},
										stop: function(event, ui) {
											
											jQuery('#search-spots').submit();
											
										}
										
									});
									
								});
							
							</script>
                            
                            <div class="the-field-range sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><div class="field-range" id="field-range-<?php echo $field->id; ?>"></div></div>
                        
                        
                        
                        
                        
                        
                        <?php elseif($field->type == 'rating' && ddp('rating') == 'on') : //// IF IT'S A RATING ?>
                        
                        	<?php if($field->label != '') : ?><label class="sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo get_form_wpml_label($field); ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
									
								//// CHECKS FOR SELECTED VALUE
								if(isset($_GET[$this_field->post_name])) {
									
									//// GETS MINIMUM
									if(isset($_GET[$this_field->post_name.'_min'])) { $min = $_GET[$this_field->post_name.'_min']; }
									else { $min = get_post_meta($field->id, '1', true); }
									if($min < 1 || $min > 5) { $min = 1; }
									
									//// GETS MAXIMUM
									if(isset($_GET[$this_field->post_name.'_max'])) { $max = $_GET[$this_field->post_name.'_max']; }
									else { $max = get_post_meta($field->id, 'range_maximum', true); }
									if($max < 1 || $max > 5) { $max = 5; }
									
								} else {
									
									//// SETS MINIMUM AND MAXIMUM
									$min = 1;
									$max = 5;
									
								}
								
							
							?>
                            
                            	<span class="range-label">
                                
                                	<span class="min"><?php echo sf_get_rating_html($min, false); ?></span> <span class="to"><?php _e('to', 'btoa'); ?></span> 
                                    
                                    <span class="max"><?php echo sf_get_rating_html($max, false); ?></span>
                                    
                                </span>
                                
                            </label><?php endif; //// IF WE HAVE A LABEL ?>
                            
                            <input type="hidden" name="<?php echo $this_field->post_name ?>_min" value="<?php echo $min; ?>" id="<?php echo $this_field->post_name ?>_min" />
                            <input type="hidden" name="<?php echo $this_field->post_name ?>_max" value="<?php echo $max; ?>" id="<?php echo $this_field->post_name ?>_max" />
                            <input type="hidden" name="<?php echo $this_field->post_name ?>" value="true" />
                            
                            <script type="text/javascript">
							
								jQuery(document).ready(function() {
								
									jQuery('#field-rating-<?php echo $field->id; ?>').slider({
										
										range: true,
										min: 1,
										max: 5,
										values: [<?php echo $min; ?>, <?php echo $max; ?>],
										step: 1,
										slide: function(event, ui) {
											
											var value1 = ui.values[0];
											var value2 = ui.values[1];
											
											//// CHANGES LABEL
											var theLabel = jQuery(this).parent().siblings('label.sf_if_<?php echo $field->id ?>');
											
											theLabel.find('.min').html('');
											for(var i = 0; i < value1; i++) { theLabel.find('.min').append('<i class="icon-star"></i>') }
											
											theLabel.find('.max').html('');
											for(var i = 0; i < value2; i++) { theLabel.find('.max').append('<i class="icon-star"></i>') }
											
											//// IF THE SAME
											if(value1 == value2) { theLabel.find('.min, .to').hide(); }
											else { theLabel.find('.min, .to').show(); }
											
											//// CHANGES INPUT
											jQuery('#<?php echo $this_field->post_name ?>_min').val(ui.values[0]);
											jQuery('#<?php echo $this_field->post_name ?>_max').val(ui.values[1]);
											
											
										},
										stop: function(event, ui) {
											
											jQuery('#search-spots').submit();
											
										}
										
									});
									
								});
							
							</script>
                            
                            <div class="the-field-range sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><div class="field-range" id="field-rating-<?php echo $field->id; ?>"></div></div>
                        
                        
                        
                        
                        
                        
                        <?php elseif($field->type == 'check') : //// IF IT'S A CHECKBOX ?>
                            
                            <?php
							
								//// GETS OUR POST AND DISPLAY VALUES
								$this_field = get_post($field->id);
									
								//// CHECKS FOR SELECTED VALUE
								if(isset($_GET[$this_field->post_name])) { if($_GET[$this_field->post_name] == 'true') { $sel_val = $_GET[$this_field->post_name]; } else { $sel_val = ''; } }
								else { $sel_val = ''; }
							
							?>
                        <script type="text/javascript">jQuery(document).ready(function() { jQuery('#<?php echo $this_field->post_name ?>_check').parent().click(function() { jQuery('#search-spots').submit(); }); });</script>
						
                        <input type="checkbox" name="<?php echo $this_field->post_name ?>" class="type-check id-<?php echo $field->id ?> sf_if_<?php echo $field->id ?>" id="<?php echo $this_field->post_name ?>_check"<?php if($sel_val != '') { echo ' checked="checked"'; } ?><?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?> />
						
                        <?php if($field->label != '') : ?><label class="check-label sf_if_<?php echo $field->id ?>"<?php if(in_array($field->id, $hidden_array)) : ?> style="display: none;"<?php endif; ?>><?php echo get_form_wpml_label($field); ?></label><?php endif; //// IF WE HAVE A LABEL ?>
                        
                        
                        
                        
                        
                        
                        <?php elseif($field->type == 'divider') : //// IF IT'S A DIVIDER ?>
                        
                            <div class="clear"></div>
                            <div class="form-divider"></div>
                            <!-- /.form-divider/ -->
                            
                            
                            
                            
                            
                        
                        <?php elseif($field->type == 'open_column') : //// IF IT'S A COLUMN OPENER  ?>
                        
                        	<div class="one-half<?php if($one_halves%2==0) { echo ' last'; } ?>">
                            
                            <?php $one_halves++; ?>
                            
                            
                            
                            
                            
                        
                        <?php elseif($field->type == 'close_column') : //// IF IT'S A COLUMN CLOSER ?>
                        
                        	</div>
                            
                            
                            
                            
                            
                        
                        <?php endif; /// ENDS OUR SEARCH ?>
                    
                    <?php endif; endforeach; /// FINISHINS LOOPING THE FIELDS ?>
                
                </div>
            
            <?php $i++; endforeach; //// ENDS LOOPING COLUMNS ?>
			
            
            <?php endwhile; else : //// IF WE HAVEN'T FOUND A FORM ?>
            
            	<h2>Could not find your homepage search form</h2>
            
            <?php endif; ?>
			
			<?php endif; ?>
            
            <div class="clear"></div>
            <!-- .clear -->
        
        	</form>
            <!-- /#search-spots/ -->
            
            <script type="text/javascript">

	// DAHERO #1667462 EVENT BOUND
	jQuery(document).bind('_ph_google_sync', function() {
				/// WHENEVER THIS FUNCTION IS SUBMITTED,
				/// THE MAP IS RELOADED
				jQuery('#search-spots').btoaSubmitSearch();
	});			
			</script>
			