<?php

	////// CHECKS FOR AUTO HEIGHT, IF NOT DISPLAY FIXED HEIGHT
	if(ddp('map_auto_height') != 'on') :
	
?>

	<style type="text/css">
	
		#slider, #slider-map { height: <?php echo ddp('map_height'); ?>px; }
	
	</style>
    
<?php else : /// WE ARE USING AUTO HEIGHT ?>

	<script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('#slider, #slider-map').fixMapHeight();
			
			jQuery(window).resize(function() {
			
				jQuery('#slider, #slider-map').fixMapHeight();
			
			});
			
		});
	
	</script>

<?php endif; ?>