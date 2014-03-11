<h2><?php _e('Notify Me', 'btoa'); ?> <i class="icon-cancel-circle"></i></h2>

<script type="text/javascript">

	jQuery(document).ready(function() {
		
		//// WHEN USER SUBMITS OUR NOTIFICATION FORM
		jQuery('#_sf_notification_signup_form')._sf_send_user_notification();
		
	});

</script>

<form id="_sf_notification_signup_form" action="<?php echo home_url() ?>" method="post">

	<p><em><?php _e('Subscribe and get notified once a matching submission is published.', 'btoa'); ?></em></p>
    
    <ul id="notify-filters">
    
    <?php
		
		
		////// GOES THROUGH OUR FIELDS AND SEES WHICH FIELDS TO ADD TO OUR NOTIFICATION
		$fields = array();
		parse_str($_POST['data'], $fields);
		foreach($fields as $_key => $_field) {
				
			//// GETS THE TYPE OF FIELD BY IT'S SLUG - IF FALSE SKIP THIS FIELD
			if($field = get_page_by_path($_key, OBJECT, 'search_field')) {
					
				//// GETS THE TYPE OF THE POST
				$field_type = get_post_meta($field->ID, 'field_type', true);
					
					
				/////////////////////////////////////////////////////////////////
				///// CHECKS FOR IF FIELD
				/////////////////////////////////////////////////////////////////
				$if_enable = true;
				if(isset($fields['sf_if_'.$field->ID.'_parent'])) {
					
					$if_enable = false;
					
					$if_parent_id = $fields['sf_if_'.$field->ID.'_parent'];
					
					//// LET'S MAKE SURE OUR PARENT FIELD IS A SEARCH FIELD
					if($if_parent_field = get_post($if_parent_id)) {
						
						//// CHECKS TO SEE IF IT'S SET
						if(isset($fields[$if_parent_field->post_name])) {
							
							//// IF THIS PARENT FIELD IS A DROPDOWN, WE NEED TO GET OUR VALUES
							if(get_post_meta($if_parent_field->ID, 'field_type', true) == 'check') {
								
								//// IF PARENT FIELD IS ON
								$if_enable = true;
								
							} else {
								
								//// GETS APPROPRIATE VALUES - IF SET
								if(isset($fields['sf_if_'.$field->ID.'_values'])) {
									
									$if_values = explode('||', $fields['sf_if_'.$field->ID.'_values']);
									
									///// IF OUR SELECTED VALUE FOR OUR PARENT FIELD IS WITHIN OUR VALUES
									if(in_array($fields[$if_parent_field->post_name], $if_values)) {
										
										$if_enable = true;
										
									}
									
									///// IF ITS STILL FALSE CHECK FOR ALL
									if(!$if_enable && $fields[$if_parent_field->post_name] == '') {
										
										///// IF IT IS SET TO ALL AS A VALUE
										if(in_array('all', $if_values)) { $if_enable = true; }
										
									}
									
								}
								
							}
							
						}
						
					}
					
				}
				
				if($if_enable) {
					
					
					/////////////////////////////////////////////////////////////////
					///// IF IT'S A TEXT FIELD
					/////////////////////////////////////////////////////////////////
					
					if($field_type == 'text') {
						
						//// MAKES SURE ITS NOT OUR DEFAULT TEXT _ IF NOT SEARCH FOR TAGS
						//// MAKES SURE ITS NOT EMPTY
						if($_field != get_post_meta($field->ID, 'text_default', true) && $_field != '') {
							
							//// GETS THE TAGS TYPED - IF IT EXISTS RETURN IT
							$tags = get_terms('spot_tags', array(
		
								'search' => $_field,
								'hide_empty' => '1'
							
							));
							
							//// PUTS ALL IDS WITHIN AN ARRAY
							$tag_array = array();
							foreach($tags as $single_tag) { $tag_array[] = $single_tag; }
							
							//// IF WE HAVE FOUND AT LEAST ONE TAG
							if(count($tag_array) > 0) {
							
								//// ADDS IT TO OUR MARKUP
								$tag = array_pop($tag_array); ?>
								
								<li>
								
									<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?>:</strong> <?php echo $_field; ?>
									
									<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="<?php echo $tag->term_id; ?>" />
									
								</li>
								
							<?php }
							
						} //// END SIF NOT DEFAULT TEXT
						
					} //// ENDS IF TEXT FIELD
						
						
						
					/////////////////////////////////////////////////////////////////
					///// IF IT'S A DROPDOWN FIELD
					/////////////////////////////////////////////////////////////////
					
					if($field_type == 'dropdown') {
						
						//// WHETHER WE ARE ACTUALLY LOOKING FOR A FIELD OR IF IT'S ANY
						if($_field != '') {
							
							//// IF ITS A CUSTOM DROPDOWN
							if(get_post_meta($field->ID, 'dropdown_type', true) == 'custom') {
							
								//// LET"S GET OUR DROPDOWN FIELD VALUE
								$dropdown_fields = json_decode(htmlspecialchars_decode(get_post_meta($field->ID, 'dropdown_values', true)));
								foreach($dropdown_fields as $dropdown_field) {
									
									//// IF IT'S THE FIELD WE AR ELOOKING FOR
									if($dropdown_field->id == $_field) {
										
										//// ADDS IT TO OUR FORM ?>
									
										<li>
										
											<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?>:</strong> <?php echo $dropdown_field->label; ?>
											
											<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="<?php echo $_field; ?>" />
											
										</li>
									
									<?php }
									
								}
							
							} else {
								
								///// IF IT'S CATEGORIES
								//// GET CATEGORY BY SLUG
								$the_term = get_term_by('slug', $_field, 'spot_cats');
								
								if($the_term) { ?>
									
									<li>
									
										<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?>:</strong> <?php echo $the_term->name; ?>
										
										<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="<?php echo $the_term->term_id; ?>" />
										
									</li>
									
								<?php }
															
							}
							
						}/// ENDS IF WE ARE ACTUALLY LOOKING FOR A DROPDOWN
						
					} //// ENDS IF DROPDOWN FIELD
						
						
						
						
						
					/////////////////////////////////////////////////////////////////
					///// IF IT'S A DEPENDENT FIELD
					/////////////////////////////////////////////////////////////////
					
					if($field_type == 'dependent') {
						
						//// WHETHER WE ARE ACTUALLY LOOKING FOR A FIELD OR IF IT'S ANY
						if($_field != '' && $_field != '-' && $_field != '0') {
							
							//// LET"S GET OUR DROPDOWN FIELD VALUE
							$dependent_fields = json_decode(htmlspecialchars_decode(get_post_meta($field->ID, 'dependent_values', true)));
						
							foreach($dependent_fields as $parent_section) {
								
								foreach($parent_section as $dependent_field) {
								
									//// IF IT'S THE FIELD WE AR ELOOKING FOR
									if($dependent_field->id == $_field) {
										
										//// ADDS IT TO OUR FORM ?>
									
										<li>
										
											<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?>:</strong> <?php echo $dependent_field->label; ?>
											
											<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="<?php echo $_field; ?>" />
											
										</li>
									
									<?php }
									
								}
								
							}
								
						} /// ENDS IF WE ARE ACTUALLY LOOKING FOR A DEPENDENT
						
					} //// ENDS IF DEPENDENT FIELD
						
						
						
						
					
					/////////////////////////////////////////////////////////////////
					///// IF IT'S A MIN_VAL FIELD
					/////////////////////////////////////////////////////////////////
					
					if($field_type == 'min_val') {
						
						//// IF IS NOT EQUALS 0
						if($_field != '' && $_field != 0) {
							
							//// GOES THROUGH OUR FIELDS 
							$values = json_decode(htmlspecialchars_decode(get_post_meta($field->ID, 'min_val_values', true)));
									
							//// LOOPS OUR VALUES
							if(is_object($values)) : foreach($values as $opt) :
							
								//// IF ITS OUR VALUE
								if($opt->value == $_field) {
										
									//// ADDS IT TO OUR FORM ?>
								
									<li>
									
										<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?>:</strong> <?php echo $opt->label; ?>
										
										<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="<?php echo $_field; ?>" />
										
									</li>
								
								<?php }
							
							endforeach; endif;
						
						}
						
					} //// ENDS IF MIN VAL FIELD
						
						
						
						
					
					/////////////////////////////////////////////////////////////////
					///// IF IT'S A MAX_VAL FIELD
					/////////////////////////////////////////////////////////////////
					
					if($field_type == 'max_val') {
						
						//// IF IS NOT EQUALS 0
						if($_field != '' && $_field != 0) {
							
							//// GOES THROUGH OUR FIELDS 
							$values = json_decode(htmlspecialchars_decode(get_post_meta($field->ID, 'max_val_values', true)));
									
							//// LOOPS OUR VALUES
							if(is_object($values)) : foreach($values as $opt) :
							
								//// IF ITS OUR VALUE
								if($opt->value == $_field) {
										
									//// ADDS IT TO OUR FORM ?>
								
									<li>
									
										<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?>:</strong> <?php echo $opt->label; ?>
										
										<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="<?php echo $_field; ?>" />
										
									</li>
								
								<?php }
							
							endforeach; endif;
						
						}
						
					} //// ENDS IF MIN VAL FIELD
						
						
						
						
						
					/////////////////////////////////////////////////////////////////
					///// IF IT'S A RANGE FIELD
					/////////////////////////////////////////////////////////////////
					
					if($field_type == 'range') {
						
						//// GETS MINIMUM AND MAXIMUM
						$min = $fields[$_key.'_min'];
						$max = $fields[$_key.'_max'];
						
						//// IF WE HAVE FORMAT PRICE
						if(get_post_meta($field->ID, 'range_price', true) == 'on') {
							
							$label_min = str_replace('%', '<span>'.number_format($min).'</span>', get_post_meta($field->ID, 'range_label', true));
							$label_max = str_replace('%', '<span>'.number_format($max).'</span>', get_post_meta($field->ID, 'range_label', true));
							
						} else {
							
							$label_min = str_replace('%', '<span>'.$min.'</span>', get_post_meta($field->ID, 'range_label', true));
							$label_max = str_replace('%', '<span>'.$max.'</span>', get_post_meta($field->ID, 'range_label', true));
							
						}
										
						//// ADDS IT TO OUR FORM ?>
					
						<li>
						
							<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?>:</strong> <?php echo $label_min; ?> - <?php echo $label_max; ?>
							
							<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="true" />
							<input type="hidden" name="range_<?php echo $field->ID; ?>_min" value="<?php echo $min; ?>" />
							<input type="hidden" name="range_<?php echo $field->ID; ?>_max" value="<?php echo $max; ?>" />
							
						</li>
					
					<?php
						
					} //// ENDS IF RANGE FIELD
						
						
						
						
						
					/////////////////////////////////////////////////////////////////
					///// IF IT'S A CHECK FIELD
					/////////////////////////////////////////////////////////////////
					
					if($field_type == 'check') {
						
						//// IF FIELD IS ON
						if($_field == 'on') {
										
								//// ADDS IT TO OUR FORM ?>
							
								<li>
								
									<i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong><?php echo get_the_title($field->ID) ?></strong>
									
									<input type="hidden" name="_sf_field_<?php echo $field->ID; ?>" value="true" />
									
								</li>
							
							<?php
							
						}
						
					} //// ENDS IF MIN VAL FIELD
					
				} /// ENDS IF ENABLE
				
				
				
			} //// ENDS IF WE CAN GET A FIELD
			
		}
	
	?>
    
    <!-- <li><i class="icon-cancel-circle" onclick="jQuery(this).parent().fadeOut(200, function() { jQuery(this).remove(); });"></i><strong>Keywords:</strong> budget</li> -->
    
    </ul>
    
    <div class="clear"></div>
    <!-- .clear -->
    
    <p><input type="text" name="name" value="<?php _e('Your Name', 'btoa'); ?>" onfocus="if(jQuery(this).val() == '<?php _e('Your Name', 'btoa'); ?>') { jQuery(this).val(''); }" onblur="if(jQuery(this).val() == '') { jQuery(this).val('<?php _e('Your Name', 'btoa'); ?>'); }" /></p>
    
    <p><input type="email" name="email" value="<?php _e('Email Address', 'btoa'); ?>" onfocus="if(jQuery(this).val() == '<?php _e('Email Address', 'btoa'); ?>') { jQuery(this).val(''); }" onblur="if(jQuery(this).val() == '') { jQuery(this).val('<?php _e('Email Address', 'btoa'); ?>'); }" /></p>
    
    <p><input type="submit" value="<?php _e('Notify Me!', 'btoa'); ?>" class="button-primary" /></p>

</form>

<div class="thankyou" style="display: none;">

	<p><?php _e('Thank you. You will now be notified of new published submissions matching your criteria.', 'btoa'); ?></p>

</div>

<div class="clear"></div>
<!-- .clear -->