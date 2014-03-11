<?php

	///// FIRST LETS CHECK IF WE HAVE A GALLERY
	
	$gallery_images = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), '_sf_gallery_images', true)));
	
	if(is_object($gallery_images) && count((array)$gallery_images) >= 1) :
	
	//// GETS A RANDOM IMAGE AS THE FIRST ONE
	if(count((array)$gallery_images) > 1) {
		
		$i = range(1, count((array)$gallery_images));
		shuffle($i);
		$i = $i[0];
		
	} else { $i = 1; }
	
	///// ABOVE IS JUST TEST FOR FUTURE
	$i = 1;

?>

	<div id="spot-gallery">
    
    	<?php
		
			//// GETS OUR FIRST IMAGE URL
			$this_i = 1;
			foreach($gallery_images as $_img) { if($this_i == $i) { $main = wp_get_attachment_image_src($_img, 'full'); } $this_i++; }
		
		?>
        
        <span id="spot-gallery-main"><a href="<?php echo $main[0] ?>" title="<?php the_title() ?>"><img src="<?php echo ddTimthumb($main[0], 654, 435) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a></span>
        
        <?php if(count((array)$gallery_images) > 1) : //// IF WE HAVE THUMBNAILS TO SHOW ?>
        
        <script type="text/javascript">
		
			jQuery(document).ready(function() {
				
				///// DEALS WITH OUR THUMBNAILS AND GALLERY
				jQuery('#spot-gallery')._sf_spot_single_gallery();
				
			});
		
		</script>
        
        <?php if(count((array)$gallery_images) < 7) { $class = 'align-center'; } else { $class = "thumb-slider"; } ?>
        
        <div id="spot-gallery-thumbs" class="<?php echo $class; ?>">
        
        	<ul>
            
            	<?php
				
					///// LOOPS OUR GALLERY IMAGES
					$this_i = 1;
					foreach($gallery_images as $_img) :
					
					///// GETS IMAGE URL
					$image = wp_get_attachment_image_src($_img, 'full');
					$class = 'spot-thumb';
					
					//// IF CURRENT
					if($this_i == $i) { $class .= ' current'; }
				
				?>
                
                	<li class="<?php echo $class ?>" id="spot-thumb-<?php echo $_img ?>">
                    
                    	<span class="thumb-over"></span>
                        <!-- .thumb-over -->
                    
                    	<img src="<?php echo ddTimthumb($image[0], 164, 164); ?>" alt="<?php the_title() ?>" title="<?php the_title(); ?>" />
                        
                        <span class="main hidden"><?php echo ddTimthumb($image[0], 654, 435) ?></span>
                        <!-- .full -->
                        
                        <a href="<?php echo $image[0] ?>" title="<?php the_title() ?>" rel="lightbox[gal]" class="hidden full"></a>
                    
                    </li>
                    <!-- .spot-thumb -->
                
                <?php $this_i++; endforeach; ?>
            
            </ul>
        
        </div>
        <!-- #spot-gallery-thumbs -->
        
        <?php endif; ?>
    
    </div>
    <!-- #spot-gallery -->

<?php endif; ?>