<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR PORTFOLIO
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('latest_blog', 'ddshort_blog');
	
	//Our Funciton
	function ddshort_blog($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'category' => 'all',
			'count' => '4',
			'columns' => '4',
			'thumb' => true,
			'read_more' => 'Read More...',
			'desc_len' => '20',
			'thumb_height' => '120',
		
		), $atts));
		
		if(isset($atts['thumb_width'])) { $thumb_width = $atts['thumb_width']; }
		$thumb = $atts['thumb'];
		
		//query args
		$args = array(
		
			'posts_per_page' => $count,
			'post_type' => 'post'
		
		);
		//column width
		if(!isset($thumb_width) || $thumb_width == '') { 
		
			switch($columns) { case 2: $colWidth = 'half'; $thumb_width = '461'; break; case 3: $colWidth = 'third'; $thumb_width = '294'; break; case 4: $colWidth = 'fourth'; $thumb_width = '211'; break; case 5: $colWidth = 'fifth'; $thumb_width = '161'; break; case 6: $colWidth = 'sixth'; $thumb_width = '128'; break; }
			
		} else {
		
			switch($columns) { case 2: $colWidth = 'half'; break; case 3: $colWidth = 'third'; break; case 4: $colWidth = 'fourth'; break; case 5: $colWidth = 'fifth'; break; case 6: $colWidth = 'sixth'; break; }
			
		}
		
		//category id
		if($category != 'all') { $category = get_cat_ID($category); if(!$category) { $category = 'all'; } }
		if($category != 'all') { $args['cat'] = $category; }
		
		//creates query object
		$lat = new WP_Query($args);
		
		//starts loop
		$i = 1; $col = 1; $output = ''; global $post; $temp_post = $post;
		if($lat->have_posts()) { while($lat->have_posts()) { $lat->the_post(); global $more; $more = 0;
			
			//checks if it's last column or not
			if((($i/$col)/$columns) == 1) { $output .= '<div class="one-'.$colWidth.' last">'; } else { $output .= '<div class="one-'.$colWidth.'">'; }
				
				$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
				
				//starts the actual post
				if(($thumb == 'true') && ($src[0] != '')) {
					$output .= '<a href="'.get_permalink().'"><img src="'.ddTimThumb($src[0], $thumb_width, $thumb_height).'" alt="'.get_the_title().'" /></a>';
					$output .= '<span class="padding-20"></span>';
				}
				
				//title
				$output .= '<h5><a href="'.get_permalink().'">'.get_the_title().'</a></h5><span class="heading-divider-20"></span>';
				
				if(!empty($post->post_excerpt)) {
					
					$thisCont = explode(' ', strip_tags(get_the_excerpt()));
					$finalCont = '';
					for($a=0; $a<$desc_len; $a++) { if($a>=count($thisCont)) { break; } $finalCont .= $thisCont[$a].' '; }
					$output .= '<p>'.$finalCont.' [...]</p>';
					
				} else {
					
					$thisCont = explode(' ', strip_tags(get_the_content()));
					$finalCont = '';
					for($a=0; $a<$desc_len; $a++) { if($a>=count($thisCont)) { break; } $finalCont .= $thisCont[$a].' '; }
					$output .= '<p>'.$finalCont.' [...]</p>';
					
				}
				
				//read more
				if($read_more != '') { $output .= '<p><a href="'.get_permalink().'" class="read-more">'.$read_more.'</a></p>'; }
			
			//closes div
			if((($i/$col)/$columns) == 1) { $output .= '</div><div class="clear"></div>'; $col++; } else { $output .= '</div>'; }
			
			$i++;
			
		} }
		
		$post = $temp_post;
		
		return $output;
		
	}
	
	include('tinyMCE.php');

?>