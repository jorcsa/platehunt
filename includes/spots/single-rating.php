<?php

	//// IF WPML MAKE SURE WE GET THE MASTER ID POST
	$post_id = $post->ID;
	global $sitepress;
	if(isset($sitepress)) {
		
		$post_id = icl_object_id($post->ID, 'spot', false, $sitepress->get_default_language());
		
	}

	if(get_post_meta($post_id, 'rating', true) != '' && get_post_meta($post_id, 'rating', true) != '0') :
	
		
		$title = __('Overall rating of ', 'btoa');
		$title .= '<span itemprop="ratingValue">'.get_post_meta($post_id, 'rating', true).'</span>';
		if(get_post_meta($post_id, 'rating_count', true) == 1) {
			$title .= ' based on <span itemprop="reviewCount">1</span> review.';
		} else {
			$title .= ' based on <span itemprop="reviewCount">'.get_post_meta($post_id, 'rating_count', true).'</span> reviews.';
		}

?>

<div class="spot-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">

	<?php echo sf_get_rating_html(get_post_meta($post_id, 'rating', true)); ?>
	
	<p><?php echo $title ?></p>

</div>
<!-- .spot-rating -->

<?php endif; ?>