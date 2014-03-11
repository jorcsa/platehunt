<?php

	if($rQ ->have_posts()) :

?>

	<ul>

	<?php while($rQ->have_posts()) : $rQ->the_post(); ?>
		
		<li class="review<?php if(current_user_can('install_plugins') && get_post_meta(get_the_ID(), 'moderate', true) == 'on') : ?> review-moderate<?php endif; ?>" id="review-<?php the_ID() ?>" itemprop="review" itemscope itemtype="http://schema.org/Review">
		
			<div class="rating-user-info">
			
				<?php
				
					//// GETS USER AVATAR
					echo get_avatar(get_post_meta(get_the_ID(), 'user_email', true), 160, ddp('rating_avatar'), get_post_meta(get_the_ID(), 'user', true));
				
				?>
				
				<h5 itemprop="author"><?php echo get_post_meta(get_the_ID(), 'user', true); ?></h5>
				<h6><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ); _e(' ago', 'btoa'); ?></h6>
				
				<meta itemprop="datePublished" content="<?php the_time('Y-m-d'); ?>">
			
			</div>
			<!-- .rating-user-info -->
			
			<div class="rating-values one-fourth last">
			
				<span class="overall-rating" title="<?php echo get_post_meta(get_the_ID(), 'rating', true) ?>" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
				
					<?php echo sf_get_rating_html(get_post_meta(get_the_ID(), 'rating', true)); ?>
					
					<meta itemprop="worstRating" content="1"/>
					<meta itemprop="ratingValue" content="<?php echo get_post_meta(get_the_ID(), 'rating', true) ?>"/>
					<meta itemprop="bestRating" content="5"/>
					
				</span>
			
				<?php
				
					//// LETS GET OUR TERMS FIRST AND THEN LOOP THEM!
					$terms = get_terms('rating_field', array('hide_empty' => false));
				
					if(is_array($terms)) :
					
				?>
				
					<ul>
				
					<?php global $sitepress; foreach($terms as $rating_field) : ?>
					
						<?php
						
							$rating_field_id  = $rating_field->term_id;
						
							///// IF WE ARE LOOKING AT A TRANSLATION, LETS MAKE SURE WE GET THE APPROPRIATE TRANSLATION FIELDS
							if(isset($sitepress)) {
								
								//// GETS THE DEFAULT FIELD ID SO WE CAN GET THE VALUE
								$rating_field_id = icl_object_id($rating_field->term_id, 'rating_field', false, $sitepress->get_default_language());
								
							}
						
						?>
					
						<li>
						
							<h5><?php echo $rating_field->name; ?>:</h5>
							<?php echo sf_get_rating_html(get_post_meta(get_the_ID(), 'sf_rating_field_'.$rating_field_id, true)); ?>
						
						</li>
					
					<?php endforeach; ?>
					
					</ul>
				
				<?php endif; ?>
			
			</div>
			<!-- .rating-values -->
			
			<div class="rating-comment">
			
				<?php if(get_post_meta(get_the_ID(), 'moderate', true) != 'on') : ?>
			
					<h4 itemprop="name"><?php the_title(); ?></h4>
					
					<span itemprop="description"><?php the_content(); ?></span>
					
					<p>
					
						<a href="#" class="report-rating" onClick="jQuery(this).sf_report_rating(event, <?php the_ID(); ?>);"><i class="icon-flag"></i> <?php _e('Report Review', 'btoa'); ?></a>
						
						<?php if(current_user_can('install_plugins')) : ?>
						
							<a href="#" class="trash-rating" onClick="jQuery(this).sf_trash_rating(event, <?php the_ID(); ?>);"><i class="icon-trash"></i> <?php _e('Trash Review', 'btoa'); ?></a>
						
						<?php endif; ?>
						
					</p>
				
				<?php else : ?>
				
					<p><?php _e('This review has been flagged and will be reviewed by our team shortly.', 'btoa'); ?></p>
						
					<?php if(current_user_can('install_plugins')) : ?>
					
						<p><a href="#" class="trash-rating" onClick="jQuery(this).sf_trash_rating(event, <?php the_ID(); ?>);"><i class="icon-trash"></i> <?php _e('Trash Review', 'btoa'); ?></a><a href="#" class="restore-rating" onClick="jQuery(this).sf_restore_rating(event, <?php the_ID(); ?>);"><i class="icon-ok"></i> <?php _e('Restore Review', 'btoa'); ?></a></p>
					
					<?php endif; ?>
				
				<?php endif; ?>
			
			</div>
			<!-- .rating-comment -->
			
			<div class="clear"></div>
			<!-- .clear -->
		
		</li>
		
	<?php endwhile; wp_reset_postdata(); ?>
		
	</ul>

<?php endif; // ENDS IF WE HAVE REVIEWS ?>