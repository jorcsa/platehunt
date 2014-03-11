 <div id="header-mobile" class="responsive-only">
    
    <span id="mobile-menu-button"><?php _e('Menu', 'btoa'); ?><i class="icon-menu"></i></span>
    
    <span id="mobile-filter-button"><i class="icon-search"></i><?php _e('Filter', 'btoa'); ?></span>
    
    <div id="mobile-menu">
	
		<div id="mobile-menu-wrapper">
    
			<span id="mobile-menu-close"><i class="icon-block"></i> <?php _e('Close Menu', 'btoa'); ?></span>
		
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
					'menu_id'           => 'menu-ul-mobile',
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
		<!-- #mobile-menu-wrapper -->
    
    </div>
    <!-- #mobile-menu -->	
 
 </div>
 
 <script type="text/javascript">
 
 	jQuery(document).ready(function() {
		
		//// MOBILE MENU
		jQuery('#mobile-menu')._sf_mobile_menu();
		
		//// FILTER MENU FOR MOBILE
		jQuery('#mobile-filter-button')._sf_mobile_filter();
		
	});
 
 </script>