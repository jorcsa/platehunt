<?php

	$field = get_post($field_id);
									
	//// GETS THE CATEGORIES TO BE SHOWN
	$show_cats = get_post_meta($field_id, 'field_category', true);
	$show_cats_class = '';
	
	//// GOES THROUGH THEM AND ADDS IT AS A CLASS
	if(!is_array($show_cats)) { $show_cats = array('all'); }
	foreach($show_cats as $_show_cat) { $show_cats_class .= $_show_cat.'_'; }
	$show_cats_class = trim($show_cats_class, '_');
	
	$accordion_class = '_sf_submission_field';
	if($position == 'before_search_fields' || $position == 'after_search_fields') { $accordion_class = '_sf_box_accordion'; }
	
	///// CURRENT VALUE
	$sel_val = get_post_meta($spot_id, '_sf_submission_field_'.$field->ID, true);

?>

<div class="_sf_box <?php echo $accordion_class; ?> _sf_box_field_<?php echo $field_id ?> <?php echo $show_cats_class; ?>" id="_sf_submission_field_box_<?php echo $field->ID; ?>">

	<div class="head">
	
		<div class="left"><?php echo $field->post_title ?></div>
		<!-- .left -->
		
		<div class="clear"></div>
		<!-- .clear -->
		
	</div>
	<!-- .head -->
	
	<div class="inside">
	
		<?php if($field->post_content != '') : ?><p><em><?php echo $field->post_content; ?></em></p><?php endif; ?>
		
		<p class="rel" style="margin-bottom: 0;">
		
			<select name="_sf_submission_field_<?php echo $field->ID; ?>" id="_sf_field_<?php echo $field->ID; ?>_select">
			
				<?php
				
					//// GETS ALL DROPDOWN VALUES
					$dropdown_values = json_decode(htmlspecialchars_decode(get_post_meta($field->ID, 'dropdown_values', true)));
					
					if(is_object($dropdown_values)) :
					
						$i = 0;
						foreach($dropdown_values as $key => $value) :
				
				?>
				
					<option value="<?php echo $i; ?>"<?php if($i == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $value->label ?></option>
				
				<?php $i++; endforeach; endif; ?>
			
			</select>   
			<small class="error tooltip bottom" style="display: none;">Please select an option.</small>
			
		</p>
	
	</div>
	<!-- .inside -->

</div>
<!-- .sf_box -->