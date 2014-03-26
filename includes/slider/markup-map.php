<?php

	///// DEALS WITH THE MAP HEIGHT
	get_template_part('includes/slider/map/map', 'height');

?>

<?php

	//// GETS THE NECESSARY VARIABLES TO INITIATE OUR MAP
	
	//// INITIAL COORDS
	$init_lat = ddp('map_initial_pos_lat');
	if(!is_numeric($init_lat)) { $init_lat = '-37.814107'; }
	$init_lng = ddp('map_initial_pos_lng');
	if(!is_numeric($init_lng)) { $init_lng = '144.96327999999994'; }
	
	//// ZOOM
	$zoom = ddp('map_zoom');
	
	//// MAP TYP
	$map_type = ddp('map_type');
	

?>

<script type="text/javascript">

	// DAHERO #1667462 EVENT BOUND
	jQuery(document).bind('_ph_google_sync', function() {
		
		google.maps.visualRefresh = true;
		
		//// INITIATES OUR MAP
		jQuery('#slider-map').gmap3({
			
			map: {
				
				options: {
					
					zoom: <?php echo $zoom; ?>,
					mapTypeId: google.maps.MapTypeId.<?php echo $map_type ?>,
					mapTypeControl: false,
					zoomControl: false,
					panControl: false,
					scaleControl: false,
					navigationControl: false,
					<?php if(ddp('map_scroll') != 'on') : ?>scrollwheel: false,<?php endif; ?>
					streetViewControl: false,
					center: new google.maps.LatLng('<?php echo $init_lat ?>', '<?php echo $init_lng ?>'),
					styles: [
					
						<?php if(ddp('map_pois') == 'on') : ?>
						{
							
							featureType: 'poi',
							elementType: 'labels',
							stylers: [
								
								{ visibility: 'off' }
								
							]
							
						},
						<?php endif; ?>
						
						<?php if(ddp('map_b_w') == 'on') : ?>
						
						{
							
							'stylers': [
							
								{ saturation: -100 },
								{ weight: 0.7 },
								{ gamma: 0.9 }
							
							]
							
						},
						
						<?php endif; ?>
					
					],
					
				}
				
			}
			
		});
		
		/// MAP OBJ
		theMap = jQuery('#slider-map').gmap3('get');
		
		//// INITIATES THE MAP FIRST TIME
		hasFormBeenSubmitted = 0;
		google.maps.event.addListener(theMap, 'idle', function() {
			
			/// GETS OUR INITIAL PINS BASED ON THE INITIAL SET OF FIELDS
			if(hasFormBeenSubmitted === 0) { jQuery('#search-spots').submit(); hasFormBeenSubmitted = 1; }
			
		});
		
		//// ADDS A LISTENER TO REMOVE OVERLAYS WHEN WE MOVE THE MAP
		google.maps.event.addListener(theMap, 'bounds_changed', function() { jQuery('#slider-map').removeOverlays(); });
	
	
	
		<?php
		
			///// IF USER HAS ENABLED GEOLOCATION
			if(ddp('map_geolocation') == 'on') :
		
		?>
		
			if(navigator.geolocation) {
				
				navigator.geolocation.getCurrentPosition(function(position) {
					
					initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
					
					//// SAVES IT IN COOKIES
					jQuery.cookie('user_latitude', initialLocation.lat(), { path: '/' });
					jQuery.cookie('user_longitude', initialLocation.lng(), { path: '/' });
					  
					//// INITIAL LOCATION
					<?php if(ddp('map_geolocation_redirect_user') == 'on') : ?> jQuery('#slider-map').gmap3('get').panTo(initialLocation); <?php endif; ?>
					  
					//// ADDS THE MARKER
					jQuery('#slider-map').gmap3({
						
						marker : {
							
							id: 'cur_loc',
							options: {
								
								position: initialLocation,
								clickable: false,
								icon: {
									
									url: '<?php echo get_template_directory_uri().'/images/pins/location.png'; ?>',
									scaledSize: new google.maps.Size(42,42),
									anchor: {
										
										x: 21,
										y: 21
										
									}
									
								}
								
							}
							
						}
						
					});
					  
				});
				
			}
			
			<?php if(ddp('map_directions') == 'on') : ?>theDirections = new google.maps.DirectionsRenderer;<?php endif; ?>
		
		<?php endif; ?>
		
		
		<?php
		
			///// IF USER IS USING CLUSTERS
			if(ddp('map_clustering') == 'on') :
		
		?>
			
			var styles = [{
			  url: '<?php echo get_template_directory_uri() ?>/images/clusters/<?php echo ddp('map_clustering_color'); ?>_1.png',
			  height: 56,
			  width: 56,
			  anchor: [0, 0],
			  textColor: '#ffffff',
			  textSize: 12
			}, {
			  url: '<?php echo get_template_directory_uri() ?>/images/clusters/<?php echo ddp('map_clustering_color'); ?>_2.png',
			  height: 76,
			  width: 76,
			  anchor: [0, 0],
			  textColor: '#ffffff',
			  textSize: 15
			}, {
			  url: '<?php echo get_template_directory_uri() ?>/images/clusters/<?php echo ddp('map_clustering_color'); ?>_3.png',
			  height: 100,
			  width: 100,
			  anchor: [0, 0],
			  textColor: '#ffffff',
			  textSize: 18
			}];
							
			//// ADDS CLUSTERER GLOBAL
			clusterManager = new MarkerClusterer(theMap, [], {
				
				styles: styles,
				zoomOnClick: false
			
			});
			
			<?php
			
				//// IF FEATURED PINS ARA AVAILABLE
				if(ddp('map_featured_overlay')) :
			
			?>
				//// WHEN WE FINISH CLUSTERING
				google.maps.event.addListener(clusterManager, 'clusteringend', function() {
					
					setTimeout(function() {
						
						jQuery('#slider-map')._sf_refresh_featured_markers();
						
					}, 20);
					
					
				});
			
			<?php endif; ?>
			
			clusterManager.setAverageCenter(true);
			
			//// WHE NWE CLICK THE CLUSTER
			google.maps.event.addListener(clusterManager, 'clusterclick', function(cluster) {
				
				//// LETS GET THE ZOOM IN CASE THE PROPERTIES ARE STACKED
				var currentZoom = theMap.getZoom();
				
				///// IF WE ARE BELOW 17 WE NEED TOSHOW AN OVERLAY WITH THE AVAILABLE SPOTS
				if(currentZoom >= 16) {
					
					//// LETS CREATE A CUSTOM OVERLAY JSUT FOR THIS
					jQuery('#slider-map')._sf_show_cluster_markers(cluster.getCenter(), cluster.getMarkers());
					
				} else {
							
					//// GETS ALL MARKERS WITHIN THAT CLUSTER AND FITS THEM TO BOUNDS
					
					var markers = cluster.getMarkers();
							
					//// creates a new bound object and a latLngArray
					var bounds = new google.maps.LatLngBounds();
					var LatLngList = new Array();
					
					//// GOES THROUGH EACH ONE AND ADDS TO THE LAT LNG LIST
					jQuery.each(markers, function(i, obj){
						
						console.log(obj);
						
						/// AFDS TO THE ARRAY
						LatLngList[i] = new google.maps.LatLng(obj.getPosition().lat(), obj.getPosition().lng());
						bounds.extend(LatLngList[i]);
						
					});
					
					theMap.fitBounds(bounds);
					
					//// DECREASE ZOOM BY 1
					//if(currentZoom > 20) { currentZoom = 20; }
					//currentZoom--;
					//theMap.setZoom(currentZoom);
				
				}
				
			});
		
		<?php endif; ?>

// DAHERO #1667454 STRT
<?php if (ddp('map_featured_overlay') == 'on' && ddp('map_clustering') != 'on') : ?>
				showFeatured = true;

				google.maps.event.addListener(theMap, 'idle', function() {
					jQuery('#slider-map')._sf_refresh_featured_markers();
				});
<?php endif; ?>
// DAHERO #1667454 STOP

		<?php if(ddp('map_zoom_controls') == 'on') :  ?>jQuery('#map-zoom-in').mapZoomIn(); jQuery('#map-zoom-out').mapZoomOut();<?php endif; ?>
		
	});

</script>

<div id="slider-map"></div>
<!-- /#slider map/ -->

<div id="slider-map-message"><span></span></div>
<!-- /#slider-map-message/ -->

<?php if(ddp('map_zoom_controls') == 'on') : ?><div id="map-zoom-in"><i class="icon-plus"></i></div>
<!-- /#map-zoom-in/ -->

<div id="map-zoom-out"><i class="icon-minus"></i></div>
<!-- /#map-zoom-in/ --><?php endif; ?>

<?php if(ddp('map_resize') == 'on') : //// IF USER IS ENABLED TO RESIZE THE MAP ?>

	<script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('#map-resize')._sf_map_resize();
			
		});
		
		jQuery(window).resize(function() { jQuery('#map-resize')._sf_map_resize_fix_top(); });
	
	</script>

	<div id="map-resize"><?php _e('Resize Me', 'btoa'); ?> <i class="icon-move"></i></div>

<?php endif; ?>