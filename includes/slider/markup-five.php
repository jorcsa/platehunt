<?php
	
		
	//// QUERY ARGUMENTS
	$args = array(
	
		'post_type' => 'slides',
		'posts_per_page' => ddp('slider_no')
	
	);
	
	//// SLIDE SIZE
	$slide_height = ddp('slider_height');
	
	//// QUERY OBJECT
	$sliderQuery = new WP_Query($args);
	
	//// IF WE HAVE SLIDES
	if($sliderQuery->have_posts()) :

?>
        
<!-- SLIDER HEIGHT -->
<style type="text/css" media="screen">

    #slider ul#slider-content, #slider .wrapper { height: <?php echo $slide_height ?>px; }

</style>
<!-- SLIDER HEIGHT -->
        
<!-- JQUERY ACTIVATORS -->
<script type="text/javascript">
    
    jQuery(window).load(function() {
        
        //opens up our menu
        jQuery('#slider').rbSlider(<?php echo ddp('slider_wait'); ?>);
        
    });

</script>


<!-- /SLIDER MARKUP STARTS/ -->
<ul id="slider-content" class="loading">
                
    <?php while($sliderQuery->have_posts()) : $sliderQuery->the_post(); //// SLIDES LOOP
            
                //// SLIDER FEATURED IMAGE
                $slider_bg = getFeaturedImage(get_the_ID());
				$slider_bg_color = get_post_meta(get_the_ID(), 'slider_bg_color', true);
				
				 ?>
    
    	<li style="height: <?php echo $slide_height ?>px; background: #<?php echo $slider_bg_color; ?> url(<?php echo $slider_bg[0] ?>) no-repeat top center;">
            
			<?php
                
                //////////////////////////////////////////////////
                //// LET'S CHECK THE TYPE OF OUR SLIDER
                //////////////////////////////////////////////////
                
                if(get_post_meta(get_the_ID(), 'slide_layout', true) == 'image') {
                    
                    //// IF IS IMAGE ONLY
                    ?><a href="<?php echo get_post_meta(get_the_ID(), 'slide_link', true); ?>" class="slider-image" title="<?php the_title(); ?>"></a><?php
                    
                } else {
                    
                    //// MEANS WE HAVE SOME SORT OF CONTENT HERE
                    //// IF IT'S NOT PURE HTML
                    if(get_post_meta(get_the_ID(), 'slide_layout', true) != 'html') {
                        
                        //// IF WE HAVE A CONTENT BOX - CALCULATE THE HEIGHT OF OUR BOX
                        $box_height = $slide_height - 120;
						
						//// GENERATE OUR RANDOM ID SO WE CAN STYLE THE COLOR OF THE TEXT
						$slide_id = randomString('abcdefghijklmnopqrstuvwxyz', 7);
                        
                        ?>
                        
                        	<style type="text/css">
							
								#<?php echo $slide_id; ?> { color: #<?php echo get_post_meta(get_the_id(), 'text_color', true); ?>; }
								
								
								#<?php echo $slide_id; ?> h1,
								#<?php echo $slide_id; ?> h2,
								#<?php echo $slide_id; ?> h3,
								#<?php echo $slide_id; ?> h4,
								#<?php echo $slide_id; ?> h5,
								#<?php echo $slide_id; ?> h6 { color: #<?php echo get_post_meta(get_the_id(), 'header_color', true); ?> !important; }
							
							</style>
                        
                            <div id="<?php echo $slide_id ?>" style="height: <?php echo $slide_height ?>px; position: relative;" class="wrapper">
                            
                                <div class="slide_text <?php echo get_post_meta(get_the_ID(), 'slide_layout', true); ?>" style="height: <?php echo $box_height; ?>px;"><?php the_content(); ?></div>
                            
                            </div>
                        
                        <?php
                        
                    } else {
						
						echo '<div class="wrapper">'; the_content(); echo '</div>';
						
					}
                    
                }
            
            ?>
        
        </li>
    
    <?php endwhile; //// END SLIDES LOOP ?>

</ul>
<!-- /#SLIDER MARKUP ENDS/ -->

<?php endif; //// IF WE HAVE POSTS ?>


<?php

	//// IF WE'RE SHOWING OUR SELECTORS
	if(ddp('slider_selector_status') == 'on') :

?>

	<ul id="slider-selector"></ul>

<?php endif; ?>




	<?php
	
		if(ddp('slider_featured') == 'on') {
	
			//// GETS OUR FEATURED MARKERS MARKUP
			get_template_part('includes/slider/markup-map', 'featured');
		
		}
	
	?>