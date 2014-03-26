<?php

	///// LETS GET A FEW VARIABLES
	
	//// LATITUDE NAD LONGITUDE
	$lat = get_post_meta($post->ID, 'latitude', true);
	$lng = get_post_meta($post->ID, 'longitude', true);
	
	//// MAP TYPE
	$map_type = ddp('map_type');
	
	//// GETS PIN
	$pin = get_spot_pin($post->ID);
	
	$image = ddTimthumb(btoa_get_featured_image($post->ID), 150, 150);

?>
<script type="text/javascript">

	// DAHERO #1667462 EVENT BOUND
	jQuery(document).bind('_ph_google_sync', function() {
	
		//// INITIATES OUR MAP
		var theMap = jQuery('#the-map');
		
		theMap.gmap3({
			
			map: {
					
				options: {
					
					zoom: 17,
					mapTypeId: google.maps.MapTypeId.<?php echo $map_type ?>,
					mapTypeControl: false,
					navigationControl: false,
					scrollwheel: false,
					zoomControl: false,
					panControl: false,
					scaleControl: false,
					streetViewControl: false,
					center: new google.maps.LatLng('<?php echo $lat ?>', '<?php echo $lng ?>'),
					<?php if(ddp('map_b_w') == 'on') : ?>styles:[{ 'stylers':
						[{'weight': .7},
						{'saturation':-100}]
					}],<?php endif; ?>
					
				}
			
			},
				
			marker: {
				
				id: <?php echo $post->ID ?>,
				tag: 'spot',
				options: {
					
					position: new google.maps.LatLng('<?php echo $lat ?>', '<?php echo $lng ?>'),
					icon: 	'<?php echo $pin; ?>',
					
				},
				callback: function(marker) {
					
					<?php if(ddp('map_pin_twox') == 'on') : ?>
							
					//// LETS SET THE ICON WITH THE PROPER WIDTH AND HEIGHT
					marker.setIcon({
						
						url: 			'<?php echo $pin; ?>',
						scaledSize:	new google.maps.Size(parseInt(<?php echo ddp('map_pin_2x_width'); ?>), parseInt(<?php echo ddp('map_pin_2x_height'); ?>)),
						
					});
					
					<?php endif; ?>
					
					var thePosition = new google.maps.LatLng('<?php echo $lat ?>', '<?php echo $lng ?>');
					
					//// LETS CENTER IT ON OUR LEFT
					google.maps.event.addListenerOnce(theMap.gmap3('get'), 'projection_changed', function(){
     
    					theMap.map_recenter(thePosition);
						
						//// WHEN THE USER RESIZES THE WINDOW
						jQuery(window).resize(function() {
							
							theMap.map_recenter(thePosition);
							
						});
						
					});
					
				}
				
			},
			
			overlay: {
				
				latLng: [<?php echo $lat ?>, <?php echo $lng ?>],
				options: {
					
					content: '<div class="overlay-single-wrapper" id="overlay-single-<?php echo $post->ID ?>"><div class="inside"><img src="<?php echo $image; ?>" alt="<?php the_title($post->ID); ?>" title="<?php the_title($post->ID); ?>" /><span class="title"><?php echo get_the_title($post->ID) ?></span><span class="address"><?php echo get_post_meta($post->ID, 'address', true); ?></span></div><span class="arrow-down"></span></div>',
					offset: { y: 0, x: 30 }
					
				}
				
			}
			
		});
		
	});

</script>

<div id="header-map"<?php if(ddp('lst_logo') == 'on') : ?> class="header-map-alt-list"<?php endif; ?>>

	<div id="the-map"></div>
    <!-- #the-map -->
    
    <div id="the-map-overlay"></div>
    <!-- #the-map-overlay -->

</div>
<!-- #header-map -->