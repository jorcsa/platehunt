

	<div class="clear"></div>
	
	<script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('.post-review-ratings ul li').each(function() { jQuery(this)._sf_listings_review_stars(); });
			
			jQuery('#post-review-form')._sf_review_submit();
			
			jQuery('#reviews-load-more')._sf_load_more_reviews(<?php echo $post->ID ?>);
			
		});
	
	</script>
	
	<div id="post-review">
	
		<?php 
		
			$title = sprintf2(__('Leave a review for %post_title', 'btoa'), array('post_title' => get_the_title($post->ID)));
			$show_form = true;
			///// IF USER NEEDS TO BE REGISTERED
			if(ddp('rating_registered') == 'on')  {
				
				$show_form = true;
				if(!is_user_logged_in()) {
					
					$title = __('You must be logged in to submit reviews.', 'btoa'); $show_form = false;
					
					///// LETS TRY ANG GET A LOGIN PAGE
					$pages = get_pages(array(
						'meta_key' => '_wp_page_template',
						'meta_value' => 'login.php'
					));
					
					if(is_array($pages)) {
						
						foreach($pages as $single_page) {
							
							$after_title = '&nbsp;&nbsp;&nbsp;<a href="'.get_permalink($single_page->ID).'">'.__('Login Here &rarr;','btoa').'</a>';
							
						}
						
					}
										
				}
				
			}
		
		?>

		<h3><?php echo $title; ?><?php if(isset($after_title)) :  ?><?php echo $after_title; ?><?php endif; ?></h3>
		
		<?php if($show_form) : ?>
		
		<form id="post-review-form" action="<?php echo home_url(); ?>" method="post">
		
			<div class="post-review-ratings one-fourth right last">
					
				<ul>
			
				<?php
				
					//// LETS GET ALL THE FIELDS
					$fields = get_terms('rating_field', array('hide_empty' => false));
					
					if($fields) :
					
						foreach($fields as $rating_field) :
				
				?>
				
					<li>
					
						<h4><?php echo $rating_field->name ?></h4>
						<span class="field-rating"><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></span>
						<p><?php echo $rating_field->description ?></p>
						<input type="hidden" name="sf_rating_field_<?php echo $rating_field->term_id ?>" value="" />
						<small class="error tooltip left" style="top: 21px;"><?php _e('Please rate this field.', 'btoa'); ?></small>
					
					</li>
				
				<?php endforeach; else : ?>
				
					<li>
					
						<h4><?php _e('Overall Rating', 'btoa'); ?></h4>
						<span class="field-rating"><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></span>
						<p><?php _e('Please select your overall rating', 'btoa'); ?></p>
						<input type="hidden" name="sf_rating" value="" />
						<small class="error tooltip left" style="top: 21px;"><?php _e('Please rate this field.', 'btoa'); ?></small>
					
					</li>
				
				<?php endif; ?>
				
				</ul>
			
			</div>
			<!-- .post-review-ratings -->
		
			<div class="post-review-fields three-fourths last">
			
				<div class="one-half">
				
					<?php
					
						$user = '';
						if(is_user_logged_in()) { $the_user = wp_get_current_user(); $user = $the_user->display_name; }
					
					?>
				
					<p><label for="post-review-name"><?php _e('Name:', 'btoa'); ?></label>
					<input type="text" name="user" id="post-review-name" value="<?php echo $user ?>" />
					<small class="error tooltip right" style="top: 21px;"><?php _e('Type in your name.', 'btoa'); ?></small></p>
				
				</div>
				<!-- .one-haklf -->
			
				<div class="one-half last">
				
					<?php
					
						$email = '';
						if(is_user_logged_in()) { $email = $the_user->user_email; }
					
					?>
				
					<p><label for="post-review-email"><?php _e('Email:', 'btoa'); ?></label>
					<input type="email" name="email" id="post-review-email" value="<?php echo $email ?>" />
					<small class="error tooltip left" style="top: 21px;"><?php _e('Type in a valid email.', 'btoa'); ?></small></p>
				
				</div>
				<!-- .one-haklf -->
				
				<div class="clear"></div>
				<!-- .clear -->
				
				<p><label for="post-review-title"><?php _e('Title:', 'btoa'); ?></label>
					<input type="text" name="title" id="post-review-title" value="" maxlength="120" />
					<small class="error tooltip right" style="top: 21px;"><?php _e('Type in a title.', 'btoa'); ?></small></p>
					
				<p><label for="post-review-comment"><?php _e('Comments:', 'btoa'); ?></label>
				<textarea name="comment" id="post-review-comment" cols="" rows="5" style="min-height: 80px;"></textarea>
					<small class="error tooltip right" style="top: 21px;"><?php _e('Type in a comment.', 'btoa'); ?></small></p>
				
				<p><input type="submit" class="button-primary" value="<?php _e('Submit Review', 'btoa'); ?>"></p>
				
				<input type="hidden" name="post_parent" value="<?php echo $post->ID ?>" />
			
			</div>
			<!-- .post-review-fields -->
			
			<div class="clear"></div>
			<!-- .clear -->
		
		</form>
		
		<?php endif; ?>

	</div>
	<!-- #reviews -->