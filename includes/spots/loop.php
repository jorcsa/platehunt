<?php

	///// SETS OUR WIDTH VARIABLES DEPENDING ON PAGE LAYOUT AND SEARCH FIELDS
	//// IF OUR PAGE LAYOUT IS FUUL WIDTH
	if($page_layout == 'none') {
		
		$image_width = 'one-third';
		$all_content_width = 'two-thirds';
		$clear = 3;
		
		//// IF WE ARE DISPLAYING OUR SEARCH FIELDS
		if(ddp('lst_search') == 'on' && ddp('lst_excerpt') == 'on') { $content_width = 'one-half'; $search_width = 'one-sixth last'; } else { $content_width = ''; }
		
	} else {
		
		$image_width = 'one-half';
		$all_content_width = 'one-half';
		$clear = 2;
		
		//// IF WE ARE DISPLAYING OUR SEARCH FIELDS
		if(ddp('lst_search') == 'on' && ddp('lst_excerpt') == 'on') { $content_width = 'one-fourth'; $search_width = 'one-sixth last'; } else { $content_width = ''; }
		
	}
	
	
	//// IF WE ARE USING THE LOGO OUR STRUCTURE IS DIFFERENT
	$classes = '';
	if(ddp('lst_logo') == 'on') { $classes .= ' spot-list-alt'; }
	if(get_post_meta(get_the_ID(), 'featured', true) == 'on') { $classes .= ' listing-featured'; }

?>
                            
<li class="spot-item border-color-input<?php if($i % $clear == 0) { echo ' last'; } if($i % 2 == 0) { echo ' even'; } echo $classes; ?>" id="spot-<?php the_ID(); ?>">
	
	<?php
	
		//// DOES NOT HSOW IF WE ARE USIGN THE LOGO OPTIONS
		if(ddp('lst_logo') != 'on') :
	
	?>

    <div class="spot-image <?php echo $image_width; ?>">
	
		<?php echo _sf_get_spot_listing_image(get_the_ID(), get_the_title()); ?>
    
    </div>
    <!-- .spot-image -->
	
	<?php else : ?>
	
		<?php if(get_post_meta(get_the_ID(), 'featured', true) == 'on') :  ?><span class="listing-featured-badge"><span><?php _e('Featured', 'btoa'); ?></span></span><?php endif; ?>
	
	<?php endif; ?>
	
	
    
    <div class="spot-content-top <?php echo $all_content_width ?> last">
    
    	<?php if(ddp('lst_cats') == 'on') : //// IF WE ARE DISPLAYING OUR CATEGORIES ?>
        <span class="spot-cats secondary-color"><?php the_terms(get_the_ID(), 'spot_cats', '', ', '); ?></span>
        <?php endif; ?>
		
        <?php if(ddp('rating') == 'on' && ddp('rating_frontend') == 'on') : ?><div class="spot-listing-rating secondary-color"><?php echo sf_get_rating_html(get_post_meta(get_the_ID(), 'rating', true)); ?></div><?php endif; ?>
		
			<div class="clear"></div>
			<!-- .clear -->

<!-- DAHERO #1667453 STRT (#1667453 MOVED BEFORE H2) -->
<?php $tag = @reset(get_the_terms($post->ID, 'spot_tags')); ?>
<?php if (is_object($tag)) : ?><p class="number-plate"><?=strtoupper($tag->name);?></p><?php endif; ?>
<!-- DAHERO #1667453 STOP -->
		
        <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="read-more grid-only"><?php _e('View more', 'btoa'); ?></a>
        
        <?php if(get_listings_header_type() == 'on') : ?><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="view-map grid-only" onclick="jQuery(this)._sf_show_pin_on_map(event, <?php the_ID(); ?>);"><?php _e('Show on map', 'btoa'); ?></a><?php endif; ?>
        
    </div>
    <!-- .spot-content-top -->
        
        
    <?php if(ddp('lst_search') == 'on' && ddp('lst_excerpt') == 'on') : //// LETS SHOW OUR SEARCH VALUES HERE ?>
    
        <div class="spot-search-fields-wrapper <?php echo $search_width ?>">
        
            <?php include(locate_template('includes/spots/loop-search.php')); ?>
        
        </div>
    
    <?php endif; ?>
    
        
    <div class="spot-content <?php echo $content_width ?>">
    
        <?php
        
            //// IF WE ARE SHOWING OUR EXCERPT
            if(ddp('lst_excerpt') == 'on') {
                
                echo '<p>'.get_excerpt_by_id(get_the_ID(), ddp('lst_excerpt_length')).'</p>';
                
            } else {
                
                include(locate_template('includes/spots/loop-search.php'));
                
                echo '<div class="padding" style="height: 15px"></div>';
                
            }
        
        ?>
        
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="read-more"><?php _e('View more', 'btoa'); ?></a>
        
        <?php if(get_listings_header_type() == 'on') : ?><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="view-map" onclick="jQuery(this)._sf_show_pin_on_map(event, <?php the_ID(); ?>);"><?php _e('Show on map', 'btoa'); ?></a><?php endif; ?>
    
    </div>
    <!-- .spot-content -->
    
    <div class="clear"></div>
    <!-- .clear -->

</li>
<!-- .spot-item -->

<?php if($i % $clear == 0 && $i != _sf_get_posts_per_page() && $i != $pagination_query->found_posts) : ?>
	<li class="clear border-color-input"></li>
<?php endif; ?>