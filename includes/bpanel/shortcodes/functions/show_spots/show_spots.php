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
					
					///// IF WE ARE SHOWING THE EXCERPT
					if($excerpt == 'true') {
						
						$markup .= get_excerpt_by_id(get_the_ID(), $excerpt_length);
						
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