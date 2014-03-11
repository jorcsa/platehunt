<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// ULTRASHARP THEME — INCLUDES/GENERAL/SHORTCODES/IMAGE-GALLERY.PHP
//
//// TWITTER FEEDBAR SHORTCODE
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////


	
	//// OUR HOOK
	add_shortcode('image_gallery', 'usshort_image_gallery');
	
	
	//// OUR FUNCTION
	function usshort_image_gallery($atts, $content = null) {
		
		global $post;
		
		extract(shortcode_atts(array(
		
			'type' => 'wp_gallery',
			'count' => '9',
			'full_size' => '260x260',
			'thumbs' => '62x62',
			'thumb_columns' => '3',
			'cat' => 'all',
		
		), $atts));
		
		$full_size_dimensions = explode('x', $full_size);
		$thumbs_dimensions = explode('x', $thumbs);
		
		/// STARTS OUR OUTPUT 
		$output = '<div class="ddGallery">
		
		<div class="ddGallery-full loading" style="width: '.$full_size_dimensions[0].'px; height: '.$full_size_dimensions[1].'px;"><a href="#" rel="lightbox"><h4><span></span>'.__('view full &rarr;', 'ultrasharp').'</h4></a></div>';
			
		/// OUR THUMBS CONTAINER
		$output .= '<ul class="ddGallery-list">';
		
		//// IF ITS WP_GALLERY TYPE
		if($type == 'wp_gallery') {
			
			/// LET'S GET OUR GALLERY IMAGES
			$attachments = get_children( array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' =>'image') );
			
			/// LET'S LOOP IT AND DISPLAY OUR LI'S
			$iGal = 1;
			foreach($attachments as $attachment_id => $attachment) {
				
				//// IF IT'S MORE THAN WE NEED TO DISPLAY
				if($iGal > $count) { break; }
				
				//// GET IMAGE URL
				$thisSingleImage = wp_get_attachment_image_src( $attachment_id, 'full' );
				
				$last_cat = '';
				if($iGal % $thumb_columns == 0) { $last_cat = ' last'; }
				
				$output .= '<li class="loading'.$last_cat.'" style="width: '.$thumbs_dimensions[0].'px; height: '.$thumbs_dimensions[1].'px;">
				
								<span class="thumb">'.ddTimthumb($thisSingleImage[0], $thumbs_dimensions[0], $thumbs_dimensions[1]).'</span>
								<span class="full">'.ddTimthumb($thisSingleImage[0], $full_size_dimensions[0], $full_size_dimensions[1]).'</span>
								<span class="link">'.$thisSingleImage[0].'</span>
								<span class="title">'.$attachment->post_title.'</span>
				
							</li>';
							
				$iGal++;
				
			}
			
		} else {
			
			//// OUR LOOP ARGS
			$args = array(
			
				'post_type' => 'portfolio_posts',
				'posts_per_page' => $count,
			
			); if($cat != 'all') { $args['tax_query'] = array(
			
				array(
				
					'taxonomy' => 'portfolio_cats',
					'field' => 'id',
					'terms' => $cat,
				
				)
			
			); }
			
			$imageGalQuery = new WP_Query($args);
			
			//// OUR LOOP
			$iGal = 1;
			if($imageGalQuery->have_posts()) { while($imageGalQuery->have_posts()) { $imageGalQuery->the_post();
				
				//// GET FEATURED IMAGE
				$thisSingleImage = ddGetFeaturedImage(get_the_ID());
				
				$last_cat = '';
				if($iGal % $thumb_columns == 0) { $last_cat = ' last'; }
				
				$output .= '<li class="loading'.$last_cat.'" style="width: '.$thumbs_dimensions[0].'px; height: '.$thumbs_dimensions[1].'px;">
				
								<span class="thumb">'.ddTimthumb($thisSingleImage[0], $thumbs_dimensions[0], $thumbs_dimensions[1]).'</span>
								<span class="full">'.ddTimthumb($thisSingleImage[0], $full_size_dimensions[0], $full_size_dimensions[1]).'</span>
								<span class="link">'.$thisSingleImage[0].'</span>
								<span class="title">'.get_the_title().'</span>
				
							</li>';
							
				$iGal++;
			
			} }
			
		}
			
	  //// CLOSES OUR THUUMBS CONTAINER
	  $output .= '</ul>';
		
		//// CLOSES OUTPUT
		$output .= '</div>';
		
		
		//// returns the output
		return $output;
		
	}


?>