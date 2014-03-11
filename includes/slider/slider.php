<div id="slider">
    
		<div id="search-ipad" class="ipad-only"><i class="icon-search"></i> <?php _e('Filter Listings', 'btoa'); ?></div>

		<?php
                
            //////////////////////////////////////////////////////
            //// THIS IS OUR SEARCH AREA
            //////////////////////////////////////////////////////
            
                get_template_part('includes/header/search');
            
            //////////////////////////////////////////////////////
        
        ?>

    
        <?php
			
			////////////////////////////////////////
			//// WHAT SLIDER ARE WE USING
			////////////////////////////////////////
			
			if(ddp('home_slider') == 'Map') {
				
				get_template_part('includes/slider/markup', 'map');
				
			} else {
				
				if(function_exists('putRevSlider')) { putRevSlider(ddp('home_slider_alias')); }  ?>
				
                <script type="text/javascript">
				
					jQuery(document).ready(function() { _sf_send_user_to_listings = true; });
				
				</script>
                
			<?php  }
		
		?>

</div>
<!-- /#slider/ -->

<?php if(ddp('home_slider') == 'Map' && ddp('map_bar') == 'on') : ?>

<div id="slider-bar">

	<div class="wrapper">
    
    	<div class="left"><span id="listing-results-count"></span></div>
		<!-- /.left/ -->        
        
        <div class="right"><a href="#" id="listing-results-page"><?php _e('View as list', 'btoa'); ?></a></div>
        <!-- /.right/ -->
    
    </div>
    <!-- /#slider-bar .wrapper/ -->

</div>

<?php endif; ?>