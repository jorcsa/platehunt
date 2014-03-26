<?php

	//// GETS ALL CATEGORIES FROM THIS POST BEFORE WE GO ANY FURTHER
	$categories = get_the_terms($post->ID, 'spot_cats');
	$spot_cats = array();
	if(is_array($categories)) { foreach($categories as $_cat) { $spot_cats[] = $_cat->term_id; } }

	///// LETS GET OUR SEARCH FIELDS THAT WE CAN INCLUDE
	$args = array(
				
		'post_type' => 'search_field',
		'posts_per_page' => -1,
		'meta_query' => array(
		
			array(
			
				'key' => 'include_overlay',
				'value' => 'on',
			
			),
			
			array(
			
				'key' => 'overlay_markup',
				'value' => '',
				'compare' => '!=',
			
			),
		
		)
					
	);
	
	$sQ = new WP_Query($args);
	
	if($sQ->have_posts()) :

?>
	<ul class="spot-search-fields">
<!-- DAHERO #1667515 STRT -->
       	<li><strong>Country:</strong> <?=get_post_meta($post->ID, 'address_country', true);?></li>
       	<li><strong>City:</strong> <?=get_post_meta($post->ID, 'address_city', true);?></li>
<!-- DAHERO #1667515 STOP -->
    	<?php
			//// STARTS OUR LOOP
			$post_id = $post->ID;
			$the_post = $post;
			while($sQ->have_posts()) : $sQ->the_post();
				//// GETS THE CATEGORIES THIS SEARCH FIELD IS ASSIGNED TO
				$field_cats = get_post_meta(get_the_ID(), 'public_field_category', true);
				
				//// CHECKS IF THIS SEARCH FIELD IS WITHIN ONE OF THE CHOSEN CATEGORIES
				$is_field_in_cat = false;
				if(!is_array($field_cats)) { $is_field_in_cat = true; }
				elseif(in_array('all', $field_cats) || $field_cats == '') { $is_field_in_cat = true; } else {
				
					///// GOES THROUGH CATEGORY BY CATEGORY
					foreach($field_cats as $field_cat) {
						if(in_array($field_cat, $spot_cats)) { $is_field_in_cat = true; }
					}
				}
				
				//// ONLY SHOWS THIS FIELD IS ITS WITHIN THE CATEGORY
				if($is_field_in_cat) {
					
					//// CHECKS FOR RANGE FIELD
					if(get_post_meta(get_the_ID(), 'field_type', true) == 'range') {
						
						//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
						$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
						
						if($field != '') { echo '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), get_translated_wpml_value(get_the_ID(), $field)).'</li>'; }
						
					}
						
					//// CHECKS FOR CHECK FIELD
					elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'check') {
						
						//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
						$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
						
						if($field == 'on') { echo '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), '').'</li>'; }
						
					}
			
					//// CHECKS FOR MIN VAL FIELD
					elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'min_val') {
						
						//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
						$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
						
						if($field != '') { echo '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), get_translated_wpml_value(get_the_ID(), $field)).'</li>'; }
						
					}
			
					//// CHECKS FOR MAX VAL FIELD
					elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'max_val') {
						
						//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
						$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
						
						if($field != '') { echo '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup(get_the_ID(), $field).'</li>'; }
						
					}
			
					//// CHECKS FOR DROPDOWN FIELD
					elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'dropdown') {
						
						//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
						$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
						
						if($field != '') { echo '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup_dropdown(get_the_ID(), $field).'</li>'; }
						
					}
			
					//// CHECKS FOR DEPENDENT FIELD
					elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'dependent') {
						
						//// GET THE FIELD FROM THE SPOT AND CHECK IF ISN"T EMPTY
						$field = get_post_meta($post_id, '_sf_field_'.get_the_ID(), true);
						
						if($field != '') { echo '<li id="sf_search_field_'.get_the_ID().'">'.apply_field_overlay_markup_dependent(get_the_ID(), $field).'</li>'; }
						
					}
				
				}
				
			
			endwhile; wp_reset_postdata();
			$post = $the_post;
		
		?>
    
    </ul>
    <!-- .spot-search-fields -->

<?php endif; ?>