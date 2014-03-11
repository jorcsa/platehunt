<?php /*

	Template Name: Home

*/ ?><?php get_header(); ?>


		<?php
            
            /////////////////////////////////////////////
            ///// GETS OUR INITIAL SLIDER
            /////////////////////////////////////////////
            
            get_template_part('includes/slider/slider');
            
            /////////////////////////////////////////////
        
        ?>
        
        
        <div id="content" style="float: left; width: 100%;">
        
        
        <?php
		
			//////////////////////////////////////////////////////
			//// LOOPS OUR HOMEPOSTS
			//////////////////////////////////////////////////////
			
			$args = array(
			
				'post_type' => 'home_posts',
				'posts_per_page' => -1
			
			);
			
			$hQuery = new WP_Query($args);
			
			if($hQuery->have_posts()) : while($hQuery->have_posts()) : $hQuery->the_post();
			
			$bg_color = get_post_meta(get_the_ID(), 'background_color', true);
			$featured_image = getFeaturedImage(get_the_ID());
		
		?>
        
        	<div class="home-post" id="home-post-<?php the_ID(); ?>"<?php if($bg_color != '' || $featured_image[0] != '') : ?> style="background: #<?php echo $bg_color ; if($featured_image[0] != '') :?> url(<?php echo $featured_image[0] ?>) no-repeat bottom center<?php endif; ?>;<?php if(is_numeric(get_post_meta(get_the_ID(), 'top_border_size', true))) : ?>border-top: <?php echo get_post_meta(get_the_ID(), 'top_border_size', true); ?>px solid #<?php echo get_post_meta(get_the_ID(), 'top_border_color', true); ?><?php endif; ?><?php if(is_numeric(get_post_meta(get_the_ID(), 'bottom_border_size', true))) : ?>border-bottom: <?php echo get_post_meta(get_the_ID(), 'bottom_border_size', true); ?>px solid #<?php echo get_post_meta(get_the_ID(), 'bottom_border_color', true); ?><?php endif; ?>"<?php endif; ?>>
            
            	<div class="wrapper">
                
                <?php the_content(); ?>
                        
            	</div>
                <!-- /.wrapper/ -->
            
            </div>
            <!-- /.home-post/ -->
        
        <?php endwhile; endif; ?>
        
        
        
        </div>
        <!-- /#content/ -->


<div class="clear"></div>
<?php get_footer(); ?>