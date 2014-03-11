<div id="search-hover">

	<?php
		
		if(ddp('search_visibility') == 'Show on hover') :
	?>
    
    	<script type="text/javascript">
		
			jQuery(document).ready(function() {
				
				jQuery('#search-hover').searchShowOnHover();
				
			});
		
		</script>
    
    <?php endif; ?>

	<div id="search">
    
    	<div class="wrapper row">
        
        	<?php if(ddp('search_visibility') == 'Show on hover' && ddp('search_position') == 'Top') : ?><span class="down-arrow"><i class="icon-search"></i></span><?php endif; ?>
        	<?php if(ddp('search_visibility') == 'Show on hover' && ddp('search_position') == 'Bottom') : ?><span class="up-arrow"><i class="icon-search"></i></span><?php endif; ?>
        
        	<?php
				
				get_template_part('includes/search/search', 'fields');
			
			?>
        	
        </div>
        <!-- /#search.wrapper/ -->
    
    </div>
    <!-- /#search/ -->

</div>
<!-- /#search-area/ -->