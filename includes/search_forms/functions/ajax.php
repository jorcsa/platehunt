<?php

	
	////////////////////////////////////////////////////////////
	///// LOADS OUR IF ONLY
	////////////////////////////////////////////////////////////
	
	add_action('wp_ajax__sf_form_load_if_field', '_sf_form_load_if_field_function');
	
	function _sf_form_load_if_field_function() {
		
		//// FIRST LETS MAKE SURE THE ID PROVIDED IS A VALID FIELD
		if(isset($_POST['field_id'])) { $post_id = $_POST['field_id']; } else { $post_id = 0; };
		
		//// LETS TRY AND GET OUR SEARCH FIELD
		if($field = get_post($post_id)) {
			
			//// IF IT IS A SEARCH FIELD
			if(get_post_type($field) == 'search_field') {
			
				//// LETS MAKE SURE IT IS A DROPDOWN, MIn_VAL, MAX_VAL, OR DEPENDENT DROPDOWN FIELD
				$field_type = get_post_meta($post_id, 'field_type', true);
				if($field_type == 'dropdown' || $field_type == 'min_val' || $field_type == 'max_val' || $field_type == 'check') {
					
					//// STARTS OUR BASIC MARKUP ?>
					
						<div class="head"><strong><?php echo $field->post_title; ?></strong></div>
						<!-- .head -->
						
						<div class="insider">
						
							<input type="hidden" name="field_if_id" value="<?php echo $post_id ?>" />
						
						
							<?php if($field_type == 'dropdown') : //// IF IT"S A DROPDOWN ?>
							
								<p style="margin: 5px 0;"><?php _e('Is one of the following:', 'btoa'); ?></p>
								
								<select multiple class="widefat" name="field_if_values">
								
									<?php
									
										//// IF WE ARE USING CUSTOM VALUES
										if(get_post_meta($post_id, 'dropdown_type', true) == 'custom') {
									
											///// GETS ALL DROPDOWNS AVAILABLE AND DISPLAYS THEM
											$dropdown_fields = json_decode(htmlspecialchars_decode(get_post_meta($post_id, 'dropdown_values', true)));
											
											if(is_object($dropdown_fields)) {
												
												foreach($dropdown_fields as $key => $value) {
													
													echo '<option value="'.$value->id.'">'.$value->label.'</option>';
													
												}
												
											}
										
										} else {
									
											///// GETS ALL DROPDOWNS AVAILABLE AND DISPLAYS THEM
											$dropdown_fields = get_terms('spot_cats', array('hide_empty' => false));
											
											if(is_array($dropdown_fields)) {
												
												foreach($dropdown_fields as $_term) {
													
													echo '<option value="'.$_term->slug.'">'.$_term->name.'</option>';
													
												}
												
											}
											
										}
									
									?>
								
								</select>
								
								<p><input type="checkbox" name="field_if_values_any" /> <?php _e('Show this field if nothing is selected.', 'btoa'); ?></p>
							
							<?php endif; ?>
						
						
						
						
							<?php if($field_type == 'min_val' || $field_type == 'max_val') : //// IF IT"S A MINIMUM OR MAXIMUM VALUE ?>
							
								<p style="margin: 5px 0;"><?php _e('Is one of the following:', 'btoa'); ?></p>
								
								<select multiple class="widefat" name="field_if_values">
								
									<?php
									
										//// IF MINIMU MVALUES
										if($field_type == 'min_val') {
											
											$values = json_decode(htmlspecialchars_decode(get_post_meta($post_id, 'min_val_values', true)));
											
										} else {
											
											$values = json_decode(htmlspecialchars_decode(get_post_meta($post_id, 'max_val_values', true)));
											
										}
										
										if(is_object($values)) {
										
											foreach($values as $key => $value) {
												
												echo '<option value="'.$value->value.'">'.$value->label.'</option>';
												
											}
											
										}
									
									?>
								
								</select>
								
								<p><input type="checkbox" name="field_if_values_any" /> <?php _e('Show this field if nothing is selected.', 'btoa'); ?></p>
							
							<?php endif; ?>
						
							
							<input type="button" class="button" value="Remove This" onclick="jQuery(this).remove_this_if_field();" style="margin-top: 10px;">
						
						</div>
						<!-- .inside -->	
					
				<?php
				
					///// MAKE SSURE WE EXIT IT
					exit;
				
				}
				
			}
			
		}
		
		die(0);
		
	}

?>