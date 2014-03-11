<?php if(ddp('header_sticky') == 'on') : //// IF HEADER IS STICKY ?>

	<script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('#header').sf_sticky_header();
			
		});
	
	</script>
	
<?php endif; ?>

 <div id="header">
 
 	<div class="left">
    
    	<a href="<?php echo home_url(); ?>" title="<?php echo bloginfo('name'); ?>" id="logo" style="width: <?php echo ddp('logo_image_width'); ?>px;"><img src="<?php echo ddp('logo'); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" class="no-retina" />
		<img src="<?php echo ddp('logo2x'); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" class="retina-only" style="width: <?php echo ddp('logo_image_width'); ?>px; " /></a>
    
    </div>
    <!-- /.left/ -->
    
    <div class="right small-12">
    
    	<?php
		
			///// GETS SOCIAL ICONS
			get_template_part('includes/header/header', 'right');
		
		?>
    
    </div>
    <!-- /.right/ -->
    
    <div class="center">
    
    	<div id="menu">
        
            <?php
    
                ////////////////////////////////////////
                //// MENU
                ////////////////////////////////////////
                
            
                //// SHOWS OUR MENU
                wp_nav_menu(array(
                
                    'menu'              => 'main_bar_menu',
                    'container'         => false,
                    'container_class'   => '',
                    'container_id'      => '',
                    'menu_class'        => '',
                    'menu_id'           => 'menu-ul',
                    'echo'              => true,
                    'before'            => '',
                    'after'             => '',
                    'link_before'       => '',
                    'link_after'        => '',
                    'depth'             => 0,
                    'walker'            => '',
                    'theme_location'    => 'main_bar_menu'
                
                ));
            
            ?>
        
        </div>
        <!-- /#menu/ -->
    
    </div>
    <!-- /.center/ -->
    
    <div class="clear"></div>
    <!-- /.clear/ -->
 
 </div>