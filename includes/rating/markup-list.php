<?php

	$post_id = $post->ID;

	///// LET"S LOOP ALL OF OUR REVIEWS ATTACHED TO THIS SPOT
	$args = array(
	
		'post_type' => 'rating',
		'posts_per_page' => ddp('rating_per_page'),
		'meta_query' => array(
		
			array(
			
				'key' => 'parent',
				'value' => $post_id,
			
			)
		
		),
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => get_query_var('page'),
	
	);
	
	
	///// NOW WE NEED TO MAKE SURE THIS IS NOT A TRANSLATION BECAUSE OTHERWISE IT WILL RETURN NOTHING
	global $sitepress;
	if(isset($sitepress)) {
		
		$post_id = icl_object_id($post_id, 'spot', false, $sitepress->get_default_language());
		$args['meta_query'][0]['value'] = $post_id;
		$args['suppress_filters'] = TRUE;
		
	}
	

	$rQ = new WP_Query($args);
	
	
	$title = sprintf2(__('Reviews for %post_title (%count)', 'btoa'), array('post_title' => get_the_title($post->ID), 'count' => get_post_meta($post_id, 'rating_count', true)));
	if($rQ->found_posts == 0) { $title = sprintf2(__('No reviews for %post_title yet. Be the first to leave one!', 'btoa'), array('post_title' => get_the_title($post->ID))); }
	///// DEFINES OUR FIRST TITLE
	
	
?>

	<div class="clear"></div>
	
	<div id="reviews">

		<h3><?php echo $title; ?></h3>
		
		<?php
		
			//// ACTUALLY LOOPS THE REVIEWS
			include(locate_template('includes/rating/loop.php'));
			$the_page = get_query_var('page'); if(get_query_var('page') == 0) { $the_page = 1; }
		
		?>
		
		<?php if($rQ->post_count == ddp('rating_per_page') && $rQ->found_posts > (ddp('rating_per_page') * $the_page)) :  ?><p style="text-align: center;" id="reviews-load-more"><a href="<?php echo add_query_arg('page', ($the_page+1), the_permalink($post->ID)) ?>" class="button-secondary center"><?php _e('Load More', 'btoa'); ?></a></p><?php endif; ?>

	</div>
	<!-- #reviews -->