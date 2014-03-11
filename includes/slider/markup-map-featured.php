<?php

	//// IF WE HAVE ENABLED OUR FEATURED SLIDER
	if(ddp('slider_featured') == 'on') :

?>

	<script type="text/javascript">
    
        jQuery(document).ready(function() {
            
            jQuery('#slider-map-featured').sliderMapFeaturedInit();
            
        });
    
    </script>
            
    <div id="slider-map-featured">
    
        <div id="slider-map-featured-left"></div>
        <!-- /#slider-map-featured-left/ -->
    
        <div id="slider-map-featured-right"></div>
        <!-- /#slider-map-featured-right/ -->
    
        <ul>
        
<?php endif; //// IF WE HAVE ENABLED OUR FEATURED SLIDER ?>
    
    	<?php

			//// LETS GET OUR FEATURED PROPERTIES
			$args = array(
			
				'post_type' => 'property',
				'posts_per_page' => ddp('slider_no'),
				'meta_query' => array(
				
					array(
					
						'key' => 'featured',
						'value' => 'on'
					
					)
				
				),
			
			);
			
			$fQuery = new WP_Query($args);
		
			//// LOOPS OUR FEATURED MARKERS
			$i = 0;
			while($fQuery->have_posts()) : $fQuery->the_post(); 
			
			//// GETS ADDRESS AND DISPLAYS IF ADDRESS IS NOT FALSE
			$address = get_property_location(get_the_ID());
			if($address != false) :
				
				//// PROPERTY PIN
				$pin = get_property_pin(get_the_ID());
				
				$featured_image = getFeaturedImage(get_the_ID());
				
				$bathrooms = get_post_meta(get_the_ID(), 'bathrooms', true);
				$bedrooms = get_post_meta(get_the_ID(), 'bedrooms', true);
				$car_spaces = get_post_meta(get_the_ID(), 'car_spaces', true);
				
				//// IF HAS EXCERPT
				if(has_excerpt()) {
					
					$excerpt = get_the_excerpt();
					
				} else { $excerpt = substr(strip_tags(get_the_excerpt()), 0, 105).' [...]'; }
		
		?>
        

			<?php
            
                //// IF WE HAVE ENABLED OUR FEATURED SLIDER
                if(ddp('slider_featured') == 'on') :
            
            ?>
            
    
            <li id="marker_featured_<?php echo get_the_ID(); ?>" class="marker-featured-slide <?php if($i== 0) { echo ' current '; } ?>">
            
                <?php if($featured_image[0] != '') :  ?><img src="<?php echo ddTimthumb($featured_image[0], 175, 145) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /><?php endif; ?>
                
                <?php if(get_post_meta(get_the_ID(), 'slogan', true) != '') : ?><span class="slider-title"><?php echo get_post_meta(get_the_ID(), 'slogan', true); ?></span><?php endif; ?>
                <h3><?php the_title(); ?></h3>
                <p><?php echo $excerpt; ?></p>
                
                <div class="property-info">
                
                    <span class="beds"><?php echo $bedrooms ?></span>
                    <span class="baths"><?php echo $bedrooms ?></span>
                    <span class="cars"><?php echo $car_spaces ?></span>
                    
                    <span class="price"><?php echo format_property_price(get_post_meta(get_the_ID(), 'price', true), get_the_ID()); ?></span>
                    
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="view"><?php _e('View Property', 'btoa'); ?></a>
                
                </div>
                <!-- /.property-info/ -->
                
            <?php endif; //// IF WE HAVE ENABLED OUR FEATURED SLIDER - STILL SHOWS ON THE MAP THOUGH ?>
            
            <?php if(ddp('slider_featured') == 'on') : ?></li><?php endif; //// IF WE HAVE ENABLED OUR FEATURED SLIDER ?>
        
        <?php $i++; endif; endwhile; wp_reset_postdata(); ?>
                
    <?php if(ddp('slider_featured') == 'on') : ?></ul>
    <!-- /#slider-map-featured ul/ -->
	
    <?php
	
		//// LOOPS IT AGAIN TO SHOW OUR FEATURED MARKER – THIS PREVENTS DOUBLE POSTS WHEN THE SLIDER CLONES ELEMENTS
		while($fQuery->have_posts()) : $fQuery->the_post(); 
			
		//// GETS ADDRESS AND DISPLAYS IF ADDRESS IS NOT FALSE
		$address = get_property_location(get_the_ID());
		if($address != false) :
			
			//// PROPERTY PIN
			$pin = get_property_pin(get_the_ID());
			
			$featured_image = getFeaturedImage(get_the_ID());
			
			$bathrooms = get_post_meta(get_the_ID(), 'bathrooms', true);
			$bedrooms = get_post_meta(get_the_ID(), 'bedrooms', true);
			$car_spaces = get_post_meta(get_the_ID(), 'car_spaces', true);
			
			//// IF HAS EXCERPT
			if(has_excerpt()) {
				
				$excerpt = get_the_excerpt();
				
			} else { $excerpt = substr(strip_tags(get_the_excerpt()), 0, 105).' [...]'; }
	
	?>
	
    
            
            <?php if(ddp('slider_type') == 'Map') : ?><script type="text/javascript">jQuery(document).ready(function() { myGmap.addFeaturedMarker(<?php echo get_the_ID(); ?>, '<?php echo addslashes($address[0]); ?>', '<?php echo $address[1] ?>', '<?php echo $address[2] ?>', '<?php echo $pin; ?>', '<?php the_permalink(); ?>', '<?php echo ddTimthumb($featured_image[0], 72, 72) ?>', '<?php the_title(); ?>'<?php if($i== 0) { echo ', true'; } ?>); });</script><?php endif; ?>
            
    
    <?php endif; endwhile; ?>
    
    </div>
    <!-- /#slider-map-featured/ -->
    
    <?php endif; ?>