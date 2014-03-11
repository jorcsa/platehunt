	
    <div id="slider">
    
    	<script type="text/javascript">
		
			jQuery(document).ready(function() {
				
				jQuery('#slider-map')._sf_fit_all_pins_to_bound();
				
				<?php if(is_tax('spot_cats')) : $term = get_term_by('name', single_cat_title('', false), 'spot_cats'); ?>
				_sf_load_only_spot_cats = <?php echo $term->term_id; ?>;
				<?php endif; ?>
				
				<?php if(is_tax('spot_tags')) : $term = get_term_by('name', single_cat_title('', false), 'spot_tags'); ?>
				_sf_load_only_spot_tags = <?php echo $term->term_id; ?>;
				<?php endif; ?>
				
			});
		
		</script>
	
		<div id="search-ipad" class="ipad-only"><div class="wrapper"><i class="icon-search"></i> <?php _e('Filter Listings', 'btoa'); ?></div></div>

		<?php
                
            //////////////////////////////////////////////////////
            //// THIS IS OUR SEARCH AREA
            //////////////////////////////////////////////////////
            
                get_template_part('includes/header/search');
            
            //////////////////////////////////////////////////////
        
        ?>

		<?php
                
            //////////////////////////////////////////////////////
            //// THIS IS OUR MAP
            //////////////////////////////////////////////////////
            
                get_template_part('includes/slider/markup', 'map')
            
            //////////////////////////////////////////////////////
        
        ?>
		
    </div>