<?php get_header(); ?>

	
    <?php
	
		///////////////////////////////////////////////////////
		///// LOADS OUR HEADER MAP
		///////////////////////////////////////////////////////
		
		///// CHECKS FOR FANCY HEADER
		if(get_post_meta(get_the_ID(), 'fancy_header', true) != '' || get_post_meta(get_the_ID(), 'header_title', true) != '') {
			
			$show_title = false;
			get_template_part('includes/page/custom-header');
			
		} else {
		
			$show_title = true;
			get_template_part('includes/spots/single', 'header');
			
		}
	
	?>
        
        
        
        <?php
        
            //////////////////////////////////////////////////////
            //// PAGE LAYOUT
            //////////////////////////////////////////////////////
			$page_layout = get_page_layout($post->ID);
			$content_class = '';
			if($page_layout == 'none') { $page_layout = 'right'; }
			switch($page_layout) {
				
				case 'right' :
					$content_class = 'large-8 columns';
					break;
				
				case 'left' :
					$content_class = 'large-8 columns';
					break;
				
				default :
					$content_class = 'large-12';
					break;
				
			}
			
			//// UPDATES OUR VIEW COUNT
			_sf_update_view_count($post->ID);
		
		?>
        
        <div id="content">
        
        	<div class="wrapper row" itemscope itemtype="http://schema.org/Product">
			
				<meta itemprop="name" content="<?php the_title(); ?>">
        
        	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                
                <?php if($show_title) : ?><h1 class="page-title spot-title"><?php the_title(); ?><?php if(get_post_meta(get_the_ID(), 'slogan', true) != '') : ?> <small><?php echo get_post_meta(get_the_ID(), 'slogan', true); ?></small><?php endif; ?></h1><?php endif; ?>
            
            	<div id="main-content" class="sidebar-<?php echo $page_layout; ?> <?php echo $content_class; ?>">
                
                	<?php
					
						
						//// BEFORE GALLERY ACTION
						do_action('single_spot_before_gallery', get_the_ID(), 'before_gallery');
						
					
						//////////////////////////////////////////////////////////////////
						///// GETS OUR SPOT GALLERY
						//////////////////////////////////////////////////////////////////
						
						get_template_part('includes/spots/single', 'gallery');
					
						
						//// AFTER GALLERY ACTION
						do_action('single_spot_after_gallery', get_the_ID(), 'after_gallery');
					
					?>
                
                	<?php
					
						//////////////////////////////////////////////////////////////////
						///// GETS OUR SPOT CONTENT AREA
						//////////////////////////////////////////////////////////////////
						
						get_template_part('includes/spots/single', 'content');
					
					?>
					
					<?php do_action('single_spot_after_content_area', get_the_ID(), 'after_content_area'); ?>
					
					<?php
					
						//////////////////////////////////////////////////////////////////
						///// GETS OUR REVIEW SYSTEM
						//////////////////////////////////////////////////////////////////
						
						if(ddp('rating') == 'on') { get_template_part('includes/rating/markup'); }
					
					?>
                
                </div>
                <!-- /#main-content/ -->
                
                <?php 
				
					//// LEFT SIDEBAR IF IS SET
					if($page_layout == 'left') {
						
						echo '<div id="sidebar-left" class="large-4 columns">';
					
						//////////////////////////////////////////////////////////////////
						///// GETS OUR SPOT SIDEBAR
						//////////////////////////////////////////////////////////////////
						
						get_template_part('includes/spots/single', 'sidebar');
						
						get_page_custom_sidebar($post->ID, 'spot-sidebar');
						echo '</div>';
						
					}
				
					//// RIGHT SIDEBAR IF IS SET
					if($page_layout == 'right') {
						
						echo '<div id="sidebar-right" class="large-4 columns">';
					
						//////////////////////////////////////////////////////////////////
						///// GETS OUR SPOT SIDEBAR
						//////////////////////////////////////////////////////////////////
						
						get_template_part('includes/spots/single', 'sidebar');
						
						get_page_custom_sidebar($post->ID, 'spot-sidebar');
						echo '</div>';
						
					}
					
						
				?>
            
            <?php endwhile; endif; ?>
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->

	
<!-- /FOOTER STARTS/ -->
<?php get_footer(); ?>