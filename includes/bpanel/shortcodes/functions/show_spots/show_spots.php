<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR BIG BUTTONS
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('show_spots', '_sf_shortcode_show_spots');
	
	//// COLUMN SHORTCODE
	function _sf_shortcode_show_spots($atts, $content = null) {
		
		//// DEFAULTS AND ATTRIBUTES
		extract(shortcode_atts(array(
				
			'featured' => 'false',
			'category' => 'all',
			'count' => '3',
			'columns' => 'one-third',
			'slider' => 'false',
			'show_cats' => 'true',
			'thumbnails' => 'true',
			'thumb_w' => '620',
			'thumb_h' => '420',
			'excerpt' => 'true',
			'excerpt_length' => '150',
			'link' => 'true',
			'link_title' => 'View more',
			'search_fields' => '',
			'orderby' => 'date',
				
		),$atts));
		
		//// LETS MAKE UP OUR QUERY
		$args = array(
		
			'post_type' => 'spot',
			'posts_per_page' => $count,
			'orderby' => $orderby,
			'meta_query' => array(),
			'tax_query' => array(),
		
		);
		
		///// IF FEATURED ONLY
		if($featured == 'true') { $args['meta_query'][] = array(
		
			'key' => 'featured',
			'value' => 'on',
		
		); }
		
		///// IF WE HAVE SET A CATEGORY
		if($category != 'all' && $_cat = get_term_by('id', $category, 'spot_cats')) {
			
			$args['tax_query'][] = array(
			
				'taxonomy' => 'spot_cats',
				'terms' => $_cat->term_id,
				'field' => 'id',
			
			);
			
		}
		
		$sQ = new WP_Query($args);
		
		if($sQ->have_posts()) {
			
			$id = randomString('qwertyuiopasdfghjklzxcvbnm', 10);
			
			//// STARTS OUR MARKUP
			$markup = '<div class="spots-short" id="'.$id.'">';
			
			//// IF WE ARE USING THE HORIZONTAL SLIDER
			if($slider == 'true') { $markup .= '<script type="text/javascript">
			
				jQuery(window).load(function() {
					
					jQuery(\'#'.$id.'\').spot_slider_scroll();
					
				});
			
			</script>'; }
			
			$markup .= '<ul>';
			
			//// RESOLVES OUR COLUMNS
			$last = 3; $i = 1;
			if($columns == 'one') { $last = 200; }
			if($columns == 'one-half') { $last = 2; }
			if($columns == 'one-fourth') { $last = 4; }
			if($columns == 'one-fifth') { $last = 5; }
			if($columns == 'one-sixth') { $last = 6; }
			if($slider == 'true') { $last = 9999; }
			
			///// LOOPS OUR SPOTS
			while($sQ->have_posts()) { $sQ->the_post();
				
				//// CLASSES
				$classes = $columns;
				if($i % $last == 0) { $classes .= ' last'; }
				if(($i-1) % $last == 0) { $classes .= ' clear'; }
				
				//// STARTS MARKUP
				$markup .= '<li class="spot-short '.$classes.'">';
					
					///// IF USER IS SHOWING THUMBNAILS
					if($thumbnails == true) {
						
						$image = btoa_get_featured_image(get_the_ID());
						if($image) { $markup .= '<a href="'.get_permalink().'" title="'.get_the_title().'"><img src="'.ddTimthumb($image, absint($thumb_w), absint($thumb_h)).'" alt="'.get_the_title().'" title="'.get_the_title().'" /></a>'; }
						
					}
				
					///// IF USER IS SHOWING CATEGORIES
					if($show_cats == 'true') {
					
						if(($cats = get_the_terms(get_the_ID(), 'spot_cats'))) { $ic = 1;
							$markup .= '<span class="spot-cats secondary-color">';
							foreach($cats as $_cat) { $markup .= '<a href="'.get_term_link($_cat, 'spot_cats').'" title="'.$_cat->name.'" class="secondary-color">'.$_cat->name.'</a>'; if($ic < count($cats)) { $markup .= ', '; } $ic++; }
							$markup .= '</span>';
						}
					
					}
					
					////// TITLE
					$markup .= '<h2><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h2>';

// DAHERO #1667457 STRT
					$tag = @reset(get_the_terms(get_the_ID(), 'spot_tags'));

					if (is_object($tag)) {
						$markup .= '<p class="number-plate">'.strtoupper($tag->name).'</p>';
					}

					//// GETS ALL CATEGORIES FROM THIS POST BEFORE WE GO ANY FURTHER
					$categories = get_the_terms(get_the_ID(), 'spot_cats');
					$spot_cats = array();
					if (is_array($categories)) { foreach($categories as $_cat) { $spot_cats[] = $_cat->term_id; } }

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
					$mQ = get_posts($args);
					if (is_array($mQ)) {
						$markup .= '<ul class="spot-search-fields clear">';
// DAHERO #1667515 STRT
						$markup .= '<li><strong>Country:</strong> '.get_post_meta($mP->ID, 'address_country', true).'</li>';
						$markup .= '<li><strong>City:</strong> '.get_post_meta($mP->ID, 'address_city', true).'</li>';
// DAHERO #1667515 STOP

						foreach ($mQ as $mP) {
							$field_cats = get_post_meta($mP->ID, 'public_field_category', true);
							//// CHECKS IF THIS SEARCH FIELD IS WITHIN ONE OF THE CHOSEN CATEGORIES
							$is_field_in_cat = false;
							if (!is_array($field_cats) || in_array('all', $field_cats) || $field_cats == '') {
								$is_field_in_cat = true;
							} else {
								///// GOES THROUGH CATEGORY BY CATEGORY
								foreach($field_cats as $field_cat) {
									if(in_array($field_cat, $spot_cats)) {
										$is_field_in_cat = true;
									}
								}
							}

							$sfTransform = array(
								'range' => array('apply_field_overlay_markup', '', true),
								'check' => array('apply_field_overlay_markup', 'on', false),
								'min_val' => array('apply_field_overlay_markup', '', true),
								'max_val' => array('apply_field_overlay_markup', '', false),
								'dropdown' => array('apply_field_overlay_markup_dropdown', '', false),
								'dependent' => array('apply_field_overlay_markup_dependent', '', false),
							);
							if ($is_field_in_cat) {
								$field = get_post_meta(get_the_ID(), '_sf_field_'.$mP->ID, true);
								if (is_array($op = $sfTransform[get_post_meta($mP->ID, 'field_type', true)])) {
									if ($op[1] == '' && $field != '' || $field == $op[1]) {
										if ($op[2] == true) $field = get_translated_wpml_value(get_the_ID(), $field);
										$fn = $op[0];
										$field = $fn($mP->ID, $field);
										$markup .= '<li id="sf_search_field_'.get_the_ID().'">'.$field.'</li>';
									}
								}
							}
						}
						$markup .= '</ul>';
					}

// DAHERO #1667457 STOP

					///// IF WE ARE SHOWING THE EXCERPT
					if($excerpt == 'true') {
						$markup .= '<div class="clear">'.get_excerpt_by_id(get_the_ID(), $excerpt_length).'</div>';
					}
					
					//// IF WE ARE SHOWING EXTRAS
					
					//// IF SHOWING TITLE
					if($link == true) {
						$markup .= '<p><a href="'.get_permalink().'" title="'.get_the_title().'" class="button-primary">'.$link_title.'</a></p>';
					}
				
				//// closes markup
				$markup .= '</li>';
				
				$i++;
				
			} wp_reset_postdata();
			
			$markup .= '</ul>';
			
			//// CLOSES OUR MARKUP
			$markup .= '</div>';
			
		}
		
		return $markup;
		
	}

?>