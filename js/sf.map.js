(function($){ 

    $.fn.extend({
		
		btoaSubmitSearch: function() {
			
			var formCont = this;
			
			//// PREVENTS NON AJAX SUBMISSIONS
			formCont.submit(function(e) {
				
				//// CANCELS WHATEVER OTHER REQUESTS WE ARE DOING
				if(typeof spotsSearchAjaxObj != 'undefined') { spotsSearchAjaxObj.abort(); }
				
				//// ADDS LOADING SIGN
				jQuery('#slider').spin({ lines: 11, length: 11, width: 5, radius: 11, corners: 1, speed: 2, shadow: false });
				
				//// REMOVES ALL MARKERS & OVERLAYS
				jQuery('.overlay-title-wrapper').remove();
				jQuery('.overlay-featured-wrapper').remove();
				if(typeof theDirections != 'undefined') { theDirections.setMap(null); }
				jQuery('#slider-map').removeOverlays();
				jQuery('#slider-map').gmap3({
					
					get: {
						
						name: 	'marker',
						all: 	true,
						tag: 	'spot',
						callback: function(objs) {
							
							jQuery.each(objs, function(i, obj){
								
								//// IF WE ARE USING CLUSTER WE NEED TO REPAINT IT
								if(typeof clusterManager != 'undefined') { clusterManager.removeMarker(obj); }

								
							})
							
						}
						
					}
					
				});
				jQuery('#slider-map').gmap3({ clear: { name: 	'marker', tag: 	'spot' } });
				
				//// IF OUR LISTINGS ARE PRESENT WE PREPARE THEM TO LOAD - ONLY LOADS IF WE ARE INDEED REFRESHING THE LISTINGS
				if(jQuery('#main-content').length > 0) {
					
					if(typeof hasFormLoadedOnce != 'undefined') {
					
						jQuery('#main-content')._sf_before_loading_spots();
					
					}
					
				}
				
				///// FIRST IF ITS NOT A TAXONOMY PAGE WE SET IT TO NULL
				if(typeof _sf_load_only_spot_cats == 'undefined') { _sf_load_only_spot_cats = null; }
				if(typeof _sf_load_only_spot_tags == 'undefined') { _sf_load_only_spot_tags = null; }
				
				//// CHECKS FOR RADIUS
				if(jQuery.urlParam('radius') != null && typeof hasFormLoadedOnce == 'undefined') { var init_radius = jQuery.urlParam('radius'); }
				else { var init_radius = null; }
				
				///// SUBMITS OUR FORM WITH IT'S CONTENTS
				spotsSearchAjaxObj = jQuery.ajax({
					
					url: 			sf.ajaxurl,
					type: 			'post',
					dataType: 		'json',
					data: {
						
						action: 	'ajaxSearchSpots',
						nonce: 		sf.search_spots_nonce,
						data: 		formCont.serialize(),
						load_tax: 	_sf_load_only_spot_cats,
						load_tag: 	_sf_load_only_spot_tags,
						force_radius: 	init_radius
						
					},
					success: function(data) {
						
						console.log(data);
						
						
						jQuery('#slider').spin(false);
						
						/// CHECKS FOR ERRORS FIRST
						if(data.error) {
							
							alert(data.error_message);
							
						} else {
							
							//// IF WE HAVE FOUND POSTS
							if(data.found > 0) {
								
								//// SHOW VIEW AS LIST
								jQuery('#listing-results-page').show();
								
								/// LOOPS THROUGH EACH ONE AND ADDS IT TO THE MAP
								jQuery.each(data.posts, function(i, post) {
									
									//// ADDS TO THE MAP ONLY IF LATITUDE NAD LONGITUDE ARE SET
									if(post.latitude && post.longitude && jQuery('#slider-map').length > 0) {
										
										if(post.thumb == '') { post.featured=false; }
									
										jQuery('#slider-map').addNewPin(post.id, post.latitude, post.longitude, post.pin, post.title, post.permalink, post.featured, post.thumb);
									
									}
									
								});
									
								//// SETS THIS GLOBAL SO WE CAN KNOW WHEN THE MAP HAS FINALLY ADDED EVERYTHING
								_sf_all_pins_loaded = true;

							} else {
								
								/// NO POSTS LET THE USER KNOW
								
								//// HIDE VIEW AS LIST
								jQuery('#listing-results-page').hide();
								
							}
							
							//// IF WE ARE CHANGING THE LOCATION
							if(data.change_location && jQuery('#slider-map').length > 0) {
								
								jQuery('#slider-map').gmap3('get').panTo(new google.maps.LatLng(data.change_location_lat, data.change_location_lng));
								
								//// IF THERE IS NO RADIUS AT ALL LET'S JUST DESTROY IY
								if(!data.change_radius) { jQuery('#slider-map')._sf_draw_radius(null, null, null, null, null, 'destroy'); }
								
							}
							
							//// IF WE'RE DOING RADIUS WE NEED TO DRAW IT
							if((data.change_radius && jQuery('#slider-map').length > 0)) {
								
								jQuery('#slider-map')._sf_draw_radius(data.change_radius, data.radius_lat, data.radius_lng, data.distance_type, data.radius_field_id, data.radius_field_val);
								
							}
							
							//// IF WE'RE DOING RADIUS WE NEED TO DRAW IT
							if((data.destroy_radius && jQuery('#slider-map').length > 0)) {
								
								jQuery('#slider-map')._sf_draw_radius(null, null, null, null, null, null, 'destroy');
								
							}
							
							//// IF WE ARE CHANGING THE ZOOM
							if(data.change_zoom && jQuery('#slider-map').length > 0) {
								
								jQuery('#slider-map').gmap3('get').setZoom(parseInt(data.change_zoom));
								
							}
							
							//// IF WE HAVE A MESSAGE FOR THE USER
							if(data.message) {
								
								jQuery('#slider-map-message span').html(data.message).parent().fadeIn(300, function() { jQuery(this).delay(5000).fadeOut(300); });
								
								jQuery('#slider-map-message .notify-me')._sf_open_user_notification();
								
							}
							
							//// UPDATES SLIDER BAR
							if(data.slider_bar_count) { jQuery('#listing-results-count').html(data.slider_bar_count); }
							
							//// UPDATES LISTING URL
							if(data.list_url) { jQuery('#listing-results-page').attr('href', data.list_url); }
							
							//// IF WENEEED TO SEND THE USER TO OUR LISTINGS PAGE
							if(typeof _sf_send_user_to_listings != 'undefined') { window.location.href = data.list_url; }
							
							//// NOW THAT WE HAVE OUR URL WE NEED TO LOAD THE MAIN CONTENT AREA
							if(jQuery('#main-content').length > 0) {
								
								//// STORES OUR POST IDS IN A HIDDEN FIELD
								jQuery('#_sf_post_ids').val(data.post_ids);
								
								if(data.custom_query) {
									
									//// IF WE ARE IN A CATEGORY PAGE
									if(formCont.find('#_sf_search_is_taxonomy').length > 0) {
										
										//// MAKES SURE OUR URL IS THE TAXONOMY ONE
										var theURLParse = data.list_url.split('?');
										var taxonomyUrl = window.location.href.split('?');
										
										data.list_url = taxonomyUrl[0]+'?'+theURLParse[1];
										
									}
									
									jQuery('#main-content')._sf_after_loading_spots(data.list_url, data.post_ids, 'force_ajax');
								
								} else if(typeof hasFormLoadedOnce != 'undefined') {
									
									//// IF WE ARE IN A CATEGORY PAGE
									if(formCont.find('#_sf_search_is_taxonomy').length > 0) {
										
										//// MAKES SURE OUR URL IS THE TAXONOMY ONE
										var theURLParse = data.list_url.split('?');
										var taxonomyUrl = window.location.href.split('?');
										
										data.list_url = taxonomyUrl[0]+'?'+theURLParse[1];
										
									}
								
									jQuery('#main-content')._sf_after_loading_spots(data.list_url, data.post_ids);
								
								} else { hasFormLoadedOnce = true; }
								
							}
							
						}
						
					}
					
				})
				
				e.preventDefault();
				return false;
				
			});
			
		},
		
		addNewPin: function(post_id, lat, lng, pin, title, permalink, featured, thumb, callback) {
			
			var theMap = this;
			
			var overlay_content = '<div class="overlay-title-wrapper" id="overlay-title-'+post_id+'"><a href="'+permalink+'"><span class="title"><span>'+title+'</span></span></a><span class="arrow-down"></span></div>';
			
			//// IF WE HAVE FEATURED
			if(featured == 'true') {
				
				//// ADDS THIS TO OUR OVERLAY CONTENT
				overlay_content += '<div class="overlay-featured-wrapper overlay-featured-wrapper-'+post_id+'"><a href="'+permalink+'"><img src="'+thumb+'" alt="'+title+'" title="'+title+'" /></a><span class="arrow-down"></span></div>';
				
			}
			
			//// ADDS THIS PIN
			jQuery(theMap).gmap3({
				
				marker: {
					
					id: post_id,
					tag: 'spot',
					options: {
						
						position: new google.maps.LatLng(lat, lng),
						icon: 	{
							
							url: 		pin	
							
						},
						
					},
					events: {
						
						mouseover: function(marker, event, context) {
							
							//// IF OUR OVERLAY IS NOT PRESENT
							if(jQuery('#map-overlay-'+context.id).length === 0) {
								
								//// IF IT'S A FEATURED
								if(featured == 'true') {
									
									jQuery('.overlay-featured-wrapper-'+context.id).sf_open_pin_title_featured(marker, event, context, lat, lng);
							
									//// OPENS OUR MARKER
									//jQuery('#overlay-title-'+context.id).css({ top: the_top+'px' }).stop().animate({ opacity: 1, top: the_top_final+'px' }, { duration: 150, easing: 'easeInOutQuint' });
									
								} else {
									
									//// CHECKS FOR HEIGHT FIRST
									jQuery('#overlay-title-'+context.id).sf_open_pin_title(marker, event, context);
								
								}
							
							}
							
						},
						
						mouseout: function(marker, event, context) {
								
							//// IF IT'S A FEATURED
							if(featured == 'true') {
									
								//// ANIMATES OUR FEATURED BUBBLE FIRST
								jQuery('.overlay-featured-wrapper-'+context.id).stop().animate({ width: '40px', height: '40px', left: '81px', top: '-20px', opacity: .6 }, { duration: 250, easing: 'easeInOutBack' });
								//jQuery('#overlay-title-'+context.id).stop().animate({ opacity: 0, top: '10px' }, { duration: 200, easing: 'easeInOutQuint', complete: function() { jQuery(this).hide(); } });
								
							} else {
							
								//// OPENS OUR MARKER
								jQuery('#overlay-title-'+context.id).stop().animate({ opacity: 0, top: '10px' }, { duration: 100, easing: 'easeInOutQuint', complete: function() { jQuery(this).hide(); } });
								
							}
							
						},
						
						click: function(marker, event, context) {
							
							//// IF OVERLAYS ARE ON
							if(sf.overlays) {
								
								//// CENTER MAP THERE
								var theCenter = marker.getPosition();
								
								//// IF OUR OVERLAY IS ALREADY PRESENT OR IF WE ARE ON RESPONSIVE
								if(jQuery('#map-overlay-'+context.id).length > 0 || jQuery(window).width() <= 700) {
									
									///// IF ITS ALREADY SHOWN
									if(parseInt(jQuery('#overlay-title-'+context.id).css('opacity')) > .95) {
								
										//// REDIRECT THE USER
										window.location = permalink;
										return false;
										
									}
									
									//// IF TITLE IS HIDDEN
									if(featured == 'true') {
								
										//// REDIRECT THE USER
										window.location = permalink;
										return false;
										
									} else {
										
										//// ITS NOT FEATURED OPEN TITLE
										jQuery('#overlay-title-'+context.id).sf_open_pin_title(marker, event, context);
										
									}
								
								}
								
								//// IF WE ARE ON IPAD OFFSET IT TO THE LEFT
								if(jQuery(window).width() >= 700 && jQuery(window).width() < 1000) {
									
									var offsetX = parseInt('-'+(sf.overlays_width / 2));
									
									jQuery('#slider-map').map_position_offset(offsetX, 0, theCenter);
									
								} else {
									
									/// IF OUR SEARCH BAR IS FIXED.
									if(typeof sf_map != 'undefined') {
										
										if(typeof sf_map.search_visibile != 'undefined') {
											
											//// GETS THE HEIGHT OF OUR SEARCH BAR
											var searchHeight = parseInt(jQuery('#search').outerHeight()) / 2;
											if(sf_map.search_position == 'Top') { searchHeight = -Math.abs(searchHeight); }
											
											jQuery('#slider-map').map_position_offset(0, searchHeight, theCenter);
											
										} else {
											
											jQuery('#slider-map').gmap3('get').panTo(theCenter);
											
										}
										
									} else {
								
										jQuery('#slider-map').gmap3('get').panTo(theCenter);
										
									}
									
								}
							
							} else { //// REDIRECTS THE USER
							
								//// REDIRECT THE USER
								window.location = permalink;
								return false;
							
							}
							
							///// IF WE ARE NOT IN MOBILE
							if(jQuery(window).width() > 700) {
								
								//// CALLS THE FUNCTION THAT CREATES OUR OVERLAY
								jQuery('#slider-map').openSpotOverlay(post_id, lat, lng);
								
							}
							
							
						}
						
					},
					callback: function(marker) {
						
						///// SPOTFINDER 1.35.2
						///// CHECKS FOR RETINA
						if(sf_map.pin_2x == 'on') {
							
							//// LETS SET THE ICON WITH THE PROPER WIDTH AND HEIGHT
							marker.setIcon({
								
								url: 			pin,
								scaledSize:	new google.maps.Size(parseInt(sf_map.pin_2x_w), parseInt(sf_map.pin_2x_h)),
								
							});
							
						}
						
						//// IF OUR CLUSTER EXISTS ADD IT TO IT
						if(typeof clusterManager != 'undefined') { clusterManager.addMarker(marker); }
						
						///// LET'S CERATE A GLOBAL CALLED THIS POST ID WITH THE GOOGLE MAP MARKER SO WE CAN ADD IT TO OUR CLUSTER
						thisMarkerId = marker.__gm_id;
						
						if (typeof callback == 'function') {
							
							callback.call(this);
							
						}
						
					}
					
				},
				
				overlay: {
					
					latLng: [lat, lng],
					options: {
						
						content: overlay_content,
						offset: { y: -65, x: -100 }
						
					},
					
					callback: function(results) {
						
						if(featured == 'true') {
							
							//// LETS GET OUR FEATURED MARKER CONTAINER AND ADD THE ID
							var featured_overlay = jQuery(results.getDOMElement()).find('.overlay-featured-wrapper');
							featured_overlay.attr('id', 'featured-'+thisMarkerId+'-'+post_id);
							featured_overlay.addClass('overlay-helper-'+thisMarkerId);
							
							featured_overlay.css({ opacity: .6 });
							
							featured_overlay.click(function() {
								
								window.location = permalink;
								return false;
								
							});
						
							//// WHEN THE USER CLICKS OUR FEATURED OVERLAY
							
							featured_overlay.hover(function() {
								
								//// ANIMATES IT
								featured_overlay.stop().animate({ width: '75px', height: '75px', left: '62px', top: '-54px', opacity: 1 }, { duration: 250, easing: 'easeInOutBack' });
								
								//// IF OUR OVERLAY IS NOT OPEN
								if(jQuery('#map-overlay-'+post_id).length == 0) {
								
									//// OPENS ONVERLAY
									var lat_lng = results.getPosition();
									jQuery('#slider-map').openSpotOverlay(post_id, lat_lng.lat(), lat_lng.lng());
								
								}
								
							}, function() {
								
								//// CHECKS IF OUR OVERLAY IS STILL OPEN
								if(jQuery('#map-overlay-'+post_id).length == 0) {
									
									jQuery('.overlay-featured-wrapper-'+post_id).stop().animate({ width: '40px', height: '40px', left: '81px', top: '-20px', opacity: .6 }, { duration: 250, easing: 'easeInOutBack' });
									
								}
								
							});
							
						} else {
							
							var normal_overlay = jQuery(results.getDOMElement()).find('.overlay-title-wrapper');
							normal_overlay.addClass('overlay-helper-'+thisMarkerId);
							
						}
						
					}
					
				},
				
			});
			
		},
		
		openSpotOverlay: function(post_id, lat, lng) {
			
			var mapCont = this;
			
			jQuery('#slider-map').removeOverlays();
			
			//// ADDS THE OVERLAY WITH A SPINNING SIGN
			mapCont.gmap3({
				
				overlay: {
					
					latLng: [lat, lng],
					options: {
						
						content: '<div id="map-overlay-'+post_id+'" class="map-overlay map-overlay-loading"><div class="overlay-inside"></div><span class="arrow"></span></div>',
						offset: { y: -30, x: 25 }
						
					},
					
					callback: function(data) {
						
						//// sets an interval until we find the container
						overlayInt = setInterval(function() {
							
							//// IF WE HAVE FOUND OUR CONTAINER
							if(jQuery('#map-overlay-'+post_id).length > 0) {
								
								clearInterval(overlayInt);
								
								var hasMapOverlayFaded = false;
								
								//// ADDS LOADING SIGN
								jQuery('#map-overlay-'+post_id).fadeIn(200, function() {
									
									hasMapOverlayFaded = true;
									
								}).spin({ lines: 7, length: 0, width: 5, radius: 5, corners: 1, rotate: 0, direction: 1, speed: 2.5, trail: 64, });
								
								//// DOES AN AJAX QUERY TO RETRIEVE OUR DATA FOR THE OVERLAY
								overlayRequest = jQuery.ajax({
									
									url: 			sf.ajaxurl,
									type: 			'post',
									dataType: 		'json',
									data: {
										
										action: 	'get_overlay_markup',
										nonce: 		sf.get_overlay_markup,
										post_id: 	post_id
										
									},
									success: function(data) {
										
										//// SET AN INTERVAL UNTIL OUR OVERLAY HAS FADED IN
										overlayFadeInt = setInterval(function() {
											
											if(hasMapOverlayFaded) {
												
												clearInterval(overlayFadeInt);
										
												//// IF THERE IS AN ERROR
												if(data.error) {
													
													jQuery('#map-overlay-'+post_id).fadeOut(200, function() { jQuery(this).remove(); });
													
													/// FIF THERES AN IMAGE
													if(data.message) { jQuery('#slider-map-message span').text(data.message).parent().fadeIn(300, function() { jQuery(this).delay(1500).fadeOut(300); }); }
													
												} else {
													
													/// IF MARKUP
													if(data.markup) {
														
														//// ANIMATES OUR HEIGHT
														var theTop = (data.height - 30) / 2;
														jQuery('#map-overlay-'+post_id).spin(false).stop().animate({ height: data.height, top: '-'+theTop+'px' }, { duration: 200, ease: 'easingInOutQuint', complete: function() {
															
															jQuery('#map-overlay-'+post_id).spin(false).children('.overlay-inside').html(data.markup).fadeIn(200);
															
														}});
														
													}
													
												}
												
											}
											
										}, 100);
										
									}
									
								});
								
							}
							
						}, 100);
						
					}
					
				}
				
			});
			
			//// ADDS THE SPIN TO OUR OVERLAY
			
			
			/// DOES AN AJAX REQUEST TO RETRIEVE DATA FOR OUR OVERLAY
			
		},
		
		fixMapHeight: function() {
			
			var mainCont = this;
			
			if(jQuery(window).width() < 720) { mainCont.fixMapHeightResponsive(); return false; }
			
			//// IF WE ARE USING THE HANDLE STOP IT
			if(typeof _sf_resize_handle_pos != 'undefined') { return false; }
			
			//// CHECKS FOR OUR RESIZE COOKIE
			if(jQuery.cookie('_sf_map_height') != undefined) {
				
				var theMapHeight = jQuery.cookie('_sf_map_height');
				
				jQuery('#slider, #slider-map').css({ height: theMapHeight+'px' });
				return false;
				
			}
			
			//// FIXES CONTAINER HEIGHT
			var wHeight = (parseInt(jQuery(window).height()) / 100) * 80;
			mainCont.css({ height: wHeight+'px' });
			
		},
		
		fixMapHeightResponsive: function() {
			
			var mainCont = this;
			
			//// FIXES CONTAINER HEIGHT
			var wHeight = (parseInt(jQuery(window).height()) / 100) * 70;
			mainCont.css({ height: wHeight+'px' });
			
		},
		
		searchShowOnHover: function() {
			
			var mainCont = this;
			var searchCont = mainCont.children('#search');
			var isHovered = false;
			
			//// WHEN WE HOVER IT
			mainCont.hover(function() {
				
				isHovered = true;
				
				/// CALCULATES THE HEIGHT OF THE SEARCH
				var searchHeight = searchCont.outerHeight();
				var actualHeight = searchHeight + 70;
				
				//// ANIMATES THE HEIGHT
				mainCont.stop().animate({ height: actualHeight+'px' }, { easing: 'easeInOutCubic', duration: 300 });
				
				mainCont.find('.up-arrow, .down-arrow').stop().animate({ opacity: 0 }, 250);
				
			}, function() {
					
				var unHover = true;
				isHovered = false;
					
				//// IF WE HAVE A SELECT OPEN
				if(mainCont.find('select:focus').length > 0 && navigator.userAgent.toLowerCase().indexOf('msie') != -1) {
					
					unHover = false;
					
					jQuery('#search-spots').one('submit', function() {
				
						//// ANIMATES THE HEIGHT
						mainCont.stop().animate({ height: '70px' }, { easing: 'easeInOutCubic', duration: 300 });
						
						mainCont.find('.up-arrow, .down-arrow').stop().animate({ opacity: 1 }, 250);
						
					});
					
				}
					
				if(jQuery('.pac-container').length > 0) {
					
					if(jQuery('.pac-container').is(':visible')) { unHover = false; }	
				
				}
				
				//// IF ITS NOT HOVERED
				if(unHover) {
			
					//// ANIMATES THE HEIGHT
					mainCont.stop().animate({ height: '70px' }, { easing: 'easeInOutCubic', duration: 300 });
					
					mainCont.find('.up-arrow, .down-arrow').stop().animate({ opacity: 1 }, 250);
					
				}
				
			});
			
		},
		
		removeOverlays: function() {
			
			var theMap = this;
			
			//// ABORTS ANY REQUESTS
			if(typeof overlayRequest != 'undefined') { overlayRequest.abort(); }
			
			//// HIDES ALL OVERLAYS
			jQuery('.map-overlay, .overlay-cluster-wrapper').fadeOut(200, function() { jQuery(this).remove(); });
			
			//// CHECKS FOR FEATURED OVERLAYS
			jQuery('.map-overlay').each(function() {
				var thisId = jQuery(this).attr('id').split('-');
				//// CHECKS FOR FEATURED OVERLAYS
				if(jQuery('.overlay-featured-wrapper-'+thisId[2]).length > 0) {
					jQuery('.overlay-featured-wrapper-'+thisId[2]).stop().animate({ width: '40px', height: '40px', left: '81px', top: '-20px', opacity: .6 }, { duration: 250, easing: 'easeInOutBack' });
				}
			});
		},
		
		mapZoomIn: function() {
			
			var zoomCont = this;
			
			zoomCont.click(function() {
				
				/// GETS CURRENT ZOOM
				var theMap = jQuery('#slider-map').gmap3('get')
				var zoomLevel = theMap.getZoom(); zoomLevel++;
				if(zoomLevel >= 20) { zoomLevel = 20; }
				theMap.setZoom(zoomLevel);
				
			});
			
		},
		
		mapZoomOut: function() {
			
			var zoomCont = this;
			
			zoomCont.click(function() {
				
				/// GETS CURRENT ZOOM
				var theMap = jQuery('#slider-map').gmap3('get')
				var zoomLevel = theMap.getZoom(); zoomLevel--;
				if(zoomLevel <= 2) { zoomLevel = 2; }
				theMap.setZoom(zoomLevel);
				
			});
			
		},
		
		fitMapToBounds: function(e) {
			
			var mapCont = this;
			
			//// FITS MAP TO BOUNDS
			//// LET"S GO THROUGH EACH MARKER AND IDD IT TO OUR LATLNG ARRAY
			jQuery(this).gmap3({
				
				get: {
				
					name: 'marker',
					all: true,
					tag: 'spot',
					callback: function(objs) {
						
						//// creates a new bound object and a latLngArray
						var bounds = new google.maps.LatLngBounds();
						var LatLngList = new Array();
						
						//// GOES THROUGH EACH ONE AND ADDS TO THE LAT LNG LIST
						jQuery.each(objs, function(i, obj){
							
							var positions = obj.getPosition();
							
							/// AFDS TO THE ARRAY
							LatLngList[i] = new google.maps.LatLng(positions.lat(), positions.lng());
							bounds.extend(LatLngList[i]);
							
						});
						
						//// FITS BOUNDS ONLY IF WE HAVE FOUND PINS
						if(objs.length > 0) {
							
							mapCont.gmap3('get').fitBounds(bounds);
							
							//// DECREASE ONE ZOOM TO FIT IN ALL PINS
							var curZoom = mapCont.gmap3('get').getZoom();
							if(curZoom >= 20) { curZoom = 20; }
							curZoom--;
							if(curZoom < 2) { curZoom = 2; }
							
							mapCont.gmap3('get').setZoom(curZoom);
							
						}
						
					}
				
				}
				
			});
			
			//// PREVENTS DEFAULT BEHAVIOUR
			if(typeof e != 'undefined') { e.preventDefault(); }
			return false;
			
		},
		
		getDirections: function(e, post_id, travel_mode) {
				
			//// CLEARS PREVIOUS DIRECTIONS
			if(typeof theDirections != 'undefined') { theDirections.setMap(null); }
			
			var mapCont = this;
			var myLoc = '';
			
			//// GETS PERON'S LOCATION
			mapCont.gmap3({
				
				get: {
					
					name: 'marker',
					id: 'cur_loc',
					callback: function(objs) {
						
						//// SETS OUR CURRENT LCOATION MARKER AS A VARIABLE
						myLoc = objs;
						
					}
					
				}
				
			});
			
			//// IF WE HAVE A CURRENT LOCATION
			if(myLoc) {
			
				//// GETS THE MARKER
				mapCont.gmap3({
					
					get: {
						
						name: 'marker',
						id: post_id,
						callback: function(objs) {
							
							var myDest = objs;
							
							/// TRAVELMODE
							if(travel_mode == 'DRIVING') { travel_mode = google.maps.DirectionsTravelMode.DRIVING; }
							
							//// GETS ROUTE
							mapCont.gmap3({
								
								getroute: {
									
									options: {
										
										origin: myLoc.getPosition(),
										destination: myDest.getPosition(),
										travelMode: travel_mode
										
									},
									callback: function(results) {
										
										//// IF False
										if(!results) {
											
											jQuery('#slider-map-message span').text('Directions from your location to here are not available.').parent().fadeIn(300, function() { jQuery(this).delay(1500).fadeOut(300); });
											
										} else {
											
											
											////// CREATES A BOUND so user can see both pins at the same time.
											var bounds = new google.maps.LatLngBounds();
											var LatLngList = new Array();
											LatLngList[0] = new google.maps.LatLng(myDest.getPosition().lat(), myDest.getPosition().lng());
											LatLngList[1] = new google.maps.LatLng(myLoc.getPosition().lat(), myLoc.getPosition().lng());
											bounds.extend(LatLngList[0]); bounds.extend(LatLngList[1]);
											
											//// FITS BOUNDS
											mapCont.gmap3('get').fitBounds(bounds);
											
											//// DRAWS THE DIRECTIONS
											mapCont.gmap3({
												
												directionsrenderer: {
													
													options: {
														
														directions:results,
														draggable: true,
														suppressMarkers: true
														
													},
												
													callback: function(obj) {
														
														//// SETS OUR DIRECTIONS GLOBAL
														theDirections = obj;
														
													}
													
												}
												
											});
											
										}
										
									}
									
								}
								
							});
							
							////// CREATES A BOUND so user can see both pins at the same time.
//							var bounds = new google.maps.LatLngBounds();
//							var LatLngList = new Array();
//							LatLngList[0] = new google.maps.LatLng(myDest.position.jb, myDest.position.kb);
//							LatLngList[1] = new google.maps.LatLng(myLoc.position.jb, myLoc.position.kb);
//							bounds.extend(LatLngList[0]); bounds.extend(LatLngList[1]);
//							
//							//// FITS BOUNDS
//							mapCont.gmap3('get').fitBounds(bounds);
							
						}
						
					}
					
				});
			
			}
			
			//// PREVENTS DEFAULT BEHAVIOUS
			e.preventDefault();
			return false;
			
		},
		
		_sf_fit_all_pins_to_bound: function() {
			
			//// vars
			var map = this;
			
			///// LETS CREATE AN INTERVAL SO WE LAUNCH THIS UNTIL THIS IS A MAP
			var fitPinsToBound = setInterval(function() {
				
				//// IF WE HAVE FINISHED LOADING OUR PINS
				if(typeof _sf_all_pins_loaded != 'undefined') {
					
					/// CLEARS THE INTERVAL
					clearInterval(fitPinsToBound);
					
					//// FITS ALL PINS TO BOUND
					map.fitMapToBounds();
					
				}
				
				
			}, 50);
			
		},
		
		_sf_before_loading_spots: function(callback) {
			
			//// FIRST WE NEED TO FADE OUT ALL OUR CONTENT
			var mainCont = this;
			
			///// FADES EVERYTHING OUT AND ADDS LOADING SIGN
			mainCont.find('*').hide();
			mainCont.addClass('loading-content').spin({ lines: 11, length: 11, width: 5, radius: 11, corners: 1, speed: 2, shadow: false, top: '50' });
			setTimeout(function() {
				
				if(typeof callback == 'function') { 
					
					callback.call(mainCont);
					
				}
				
			}, 200);
			
		},
		
		_sf_after_loading_spots: function(the_url, post_ids, force_ajax) {
			
			////// VARS
			var mainCont = this;
			
			if(jQuery('#main-content .spinner').length == 0) { jQuery('#main-content')._sf_before_loading_spots(); }
			
			//// WE NEED TO PARSE ANY ARGUMENTS WE ALREADY HAVE SUCH AS LIST VIEW, GRID AND PER PAGE
			var theUrl = window.location.href;
			var params = jQuery.url(theUrl).param();
			
			//// GOES THROUGH OUR PARAMS AND ADDS THEM TO OUR URL
			jQuery.each(params, function(key, _param) {
				
				///// IF ITS OUR VIEW, PER PAGE OR SORT PARAMETERS
				if(key == 'view' || key == 'sort' || key == 'per_page' && key != '') {
					
					//// ADDS IT TO OUR URL
					the_url += '&'+key+'='+_param;
					
				}
				
			});
			
			//// FITS ALL OUR PINS TO BOUND
			if(jQuery('#slider-map').length > 0) { jQuery('#slider-map')._sf_fit_all_pins_to_bound(); }
			
			if(post_ids) { 
			
				mainCont._sf_load_results(the_url, post_ids);
			
			} else {
			
				//// LOADS OUR RESULTS VIA AJAX
				mainCont._sf_load_results(the_url);
			
			}
			
		},
		
		_sf_load_results: function(url, post_ids) {
			
			//// VARS
			var mainCont = this;
			
			//// MAKES SURE WE DONT INCLUDE OUR PAGED
			if(typeof post_ids == undefined) { post_ids = new Array(); }
			
			var sendPosts = JSON.stringify(post_ids);
			
			//// LETS SEE IF THE BROWSER SUPPORTS THE PUSH
				
			//// CANCELS ANYTHING ALREADY GOING
			if(typeof loadingSpotsAjax != 'undefined') { loadingSpotsAjax.abort(); }
			
			//// LOADS VIA AJAX OUR URL
			loadingSpotsAjax = jQuery.ajax({
				
				url: 				url,
				type: 				'post',
				dataType:			'HTML',
				data: {
					
					p_ids: post_ids,
					nonce: 'nope'
					
				},
				success: function(data) {
					
					////SCROLLS TO WHERE IT"S SUPPOSED TO
					//var cOffset = jQuery('#subheader').offset();
					//jQuery('body, html').stop().animate({ scrollTop: (cOffset.top - 80)+'px' }, 250);
					
					///// GETS SOME VARIABLES
					var pageTitle = data.split('<title>');
					pageTitle = pageTitle[1].split('</title>');
					pageTitle = pageTitle[0];
					
					//// OUR CONTENTS
					var theContent = jQuery(data).find('#main-content').html();
					
					//// APPENDS OUR CONTENT
					jQuery('#main-content').html(theContent).removeClass('loading-content');
					
					//// IN CASE WE ARE SHOWING NOTIFICATIONS
					if(jQuery(data).find('#main-content .notify-me').length > 0) { jQuery('#main-content .notify-me')._sf_open_user_notification(); }
					
					///// PUSHES OUR HISTORY STATE
					if(Modernizr.history) { window.history.pushState({"the_url": url, "pageTitle": pageTitle}, pageTitle, url); }
					
					//// CHANGES PAGE TITLE
					jQuery('title').html(pageTitle);
					
					//// ACTIVATES PAGINATION AS WELL
					jQuery('#pagination a')._sf_pagination_click();
					
				}
				
			});
			
		},
		
		_sf_load_results_pop_state: function(listing_url) {
			
			var mainCont = this;
			
			///// WHENEVER THE USER PRESSES BACK AND FORWARD
			if(Modernizr.history) {
				
				window.onpopstate = function(e) {
				
					//// IF WE HAVE A STATE OT IF IT'S OUR LISTING URL
					if(e.state != null) {
						
						//// LETS RELOAD THE PAGE TO MAKE SURE WE GET THE FILTERING RIGHT
						window.location.href = e.state.the_url
						
					} else {
						
						if(typeof url_global_store != 'undefined') {
							
							window.location.reload();
							
						}
						
						///// STORES THIS URL AS A GLOBAL JUST SO WE CAN REFRESH THE PAGE IF BACK TO OUR LISTINGS SQAURE 1
						url_global_store = window.location.href;
						
					}
					
				}
				
			}
			
		},
		
		_sf_list_view_click: function() {
			
			var aCont = this;
			
			//// WHEN  THE USER CLICKS IT
			aCont.click(function(e) {
				
				//// IF ITS NOT CURRENT
				if(jQuery(this).attr('class').indexOf('current') == -1) {
					
					//// MAKES IT CURRENT
					jQuery(this).parent().parent().find('.current').removeClass('current');
					jQuery(this).addClass('current');
				
					//// LETS JUST SET THE COOKIE
					if(jQuery(this).attr('href').indexOf('grid') != -1) {
						
						//// SETS OUR COOKIE
						jQuery.cookie('listing_view', 'Grid', { path: '/' });
						var theClass = 'spot-grid';
						
					} else {
					
						//// SETS OUR COOKIE
						jQuery.cookie('listing_view', 'List', { path: '/' });
						var theClass = 'spot-list';
					
					}
					
					//// FADES OUT CONTENT
					jQuery('#main-content ul#spots').stop().animate({ opacity: 0 }, 200, function() {
						
						//// CHANGES THE CLASS
						jQuery(this).attr('class', theClass);
						
						//// FADES IT BACK IN
						jQuery(this).stop().animate({ opacity: 1 }, 200);
						
					});
				
				}
				
				e.preventDefault();
				return false;
				
			});
			
		},
		
		_sf_change_per_page_view: function() {
			
			var option = this;
			
			//// LETS GET THE CURRENT URL WITH OUR LISTINGS
			var theUrl = window.location.href;
			var optionUrl = option.val();
			
			//// LETS GET THE AMOUNT OF LISTINGS PER PAGE FIRST
			var perPage = jQuery.url(optionUrl).param('per_page');
			
			//// NOW LETS GO THROUGH OUR PARAMETERS IN THE NORMAL URL AND MAKE SURE OUR PER PAGE ISNT THERE
			var allParams = jQuery.url(theUrl).param();
			var params = '';
			jQuery.each(allParams, function(key, _param) {
				
				//// IF ITS NOT THE PER PAGE PARAM WE ADD IT TO OUR URL
				if(key != 'per_page' && key != 'paged' && key != '') {
					
					params += '&'+key+'='+_param;
					
				}
				
			});
			
			var segments = theUrl.split('?');
			if(segments.length > 1) { var siteUrl = segments[0]; }
			else { var siteUrl = theUrl; }
			
			///// MAKES SURE WE REMOVE THE PAGINATION FROM OUR URL
			var allSegments = jQuery.url(siteUrl).segment(); var segments = ''; var pageIndex = '';
			jQuery.each(allSegments, function(i, _segment) {
				
				//// IF ITS PAGE WE REMOVE AND STORE THE INDEX
				if(_segment == 'page') {
					
					pageIndex = i+1;
					
				} else {
					
					//// IF OUR PAGE INDEX EXISTS
					if(typeof pageIndex != '' && i == pageIndex && pageIndex != 0) { } else {
						
						segments += '/'+_segment;
						
					}
					
				}
				
			});
			
			if(pageIndex != '') {
				
				//// LETS REBUILD OUR SITEURL
				var urlObj = jQuery.url(siteUrl);
				
				siteUrl = urlObj.attr('protocol')+'://'+urlObj.attr('host')+segments+'/';
				
			}
			
			//// IF OUR PARAMS STARTS WITH AN AMPERSAND
			var allParams = params+'&per_page='+perPage;
			if(allParams[0] == '&') { allParams = allParams.substr(1, allParams.length); }
			
			//// ADDS OUR PARAMS TO THE SITE URL ALONG WITH OUR PER PAGE OPTION
			var loadUrl = siteUrl+'?'+allParams;
			
			//// FADES OUT OUR CONTAINER AND LOADS THE URL
			jQuery('#main-content')._sf_before_loading_spots(function() {
				
				jQuery(this)._sf_load_results(loadUrl, jQuery('#_sf_post_ids').val());
				
			});
			
		},
		
		_sf_change_sort_view: function() {
			
			var option = this;
			
			//// LETS GET THE CURRENT URL WITH OUR LISTINGS
			var theUrl = window.location.href;
			var optionUrl = option.val();
			
			//// LETS GET THE SORT WE ARE HAVING NOW
			var sortList = jQuery.url(optionUrl).param('sort');
			
			//// NOW LETS GO THROUGH OUR PARAMETERS IN THE NORMAL URL AND MAKE SURE OUR SORT ISNT THERE ISNT THERE
			var allParams = jQuery.url(theUrl).param();
			var params = '';
			jQuery.each(allParams, function(key, _param) {
				
				//// IF ITS NOT THE PER PAGE PARAM WE ADD IT TO OUR URL
				if(key != 'sort' &&  key != 'paged' &&  key != '') {
					
					params += '&'+key+'='+_param;
					
				}
				
			});
			
			var segments = theUrl.split('?');
			if(segments.length > 1) { var siteUrl = segments[0]; }
			else { var siteUrl = theUrl; }
			
			///// MAKES SURE WE REMOVE THE PAGINATION FROM OUR URL
			var allSegments = jQuery.url(siteUrl).segment(); var segments = ''; var pageIndex = '';
			jQuery.each(allSegments, function(i, _segment) {
				
				//// IF ITS PAGE WE REMOVE AND STORE THE INDEX
				if(_segment == 'page') {
					
					pageIndex = i+1;
					
				} else {
					
					//// IF OUR PAGE INDEX EXISTS
					if(typeof pageIndex != '' && i == pageIndex && pageIndex != 0) { } else {
						
						segments += '/'+_segment;
						
					}
					
				}
				
			});
			
			if(pageIndex != '') {
				
				//// LETS REBUILD OUR SITEURL
				var urlObj = jQuery.url(siteUrl);
				
				siteUrl = urlObj.attr('protocol')+'://'+urlObj.attr('host')+segments+'/';
				
			}
			
			//// IF OUR PARAMS STARTS WITH AN AMPERSAND
			var allParams = params+'&sort='+sortList;
			if(allParams[0] == '&') { allParams = allParams.substr(1, allParams.length); }
			
			//// ADDS OUR PARAMS TO THE SITE URL ALONG WITH OUR PER PAGE OPTION
			var loadUrl = siteUrl+'?'+allParams;
			
			//// FADES OUT OUR CONTAINER AND LOADS THE URL
			jQuery('#main-content')._sf_before_loading_spots(function() {
				
				//// GETS OUR LIST OF POST IDS SO WE CAN SEND IT VIA POST
				
				jQuery(this)._sf_load_results(loadUrl, jQuery('#_sf_post_ids').val());
				
			});
			
		},
		
		_sf_pagination_click: function() {
			
			var aCont = this;
			
			aCont.click(function(e) {
				
				//// LETS GET OUR URL
				var theUrl = jQuery(this).attr('href');
				var currentUrl = window.location.href;
				
				//// LETS GET ALL OUR PARAMS
				var allParams = jQuery.url(currentUrl).param();
				var params = '';
				
				//// IF OUR PAGED IS SET WITHIN OUR CLICKED URL
				if(jQuery.url(theUrl).param('paged') != undefined) { allParams.paged = jQuery.url(theUrl).param('paged'); }
				
				//// LETS LOOP THOUGH OUR PARAMS AND ADD THEM ONE BY ONE TO OUR URL
				jQuery.each(allParams, function(key, _param) {
					
					if(key != '') {
					
						params += '&'+key+'='+_param;
						
					}
					
				});
			
				var segments = theUrl.split('?');
				if(segments.length > 1) { var siteUrl = segments[0]; }
				else { var siteUrl = theUrl; }
				
				//// IF OUR PARAMS STARTS WITH AN AMPERSAND
				var allParams = params;
				if(allParams[0] == '&') { allParams = allParams.substr(1, allParams.length); }
				
				//// ADDS OUR PARAMS TO THE SITE URL ALONG WITH OUR PER PAGE OPTION
				if(allParams != '') { var loadUrl = siteUrl+'?'+allParams; }
				else { var loadUrl = siteUrl }
				
				//console.log(loadUrl);
			
				//// FADES OUT OUR CONTAINER AND LOADS THE URL
				jQuery('#main-content')._sf_before_loading_spots(function() {
					
					jQuery(this)._sf_load_results(loadUrl, jQuery('#_sf_post_ids').val());
					
				});
				
				e.preventDefault()
				return false;
				
			});
			
		},
		
		_sf_show_pin_on_map: function(e, post_id) {
			
			//// LETS GET OUR MARKER FIRST
			jQuery('#slider-map').gmap3({
				
				get: {
					
					name: 'marker',
					id: post_id,
					tag: 'spot',
					callback: function(marker) {
						
						var position = marker.getPosition();
						
						//// LETS SCROOL TO TOP AND CENTER THE MAP ON THE PIN
						jQuery('html, body').stop().animate({ 'scrollTop': 0 }, 300);
						
						///// CENTERS MAPS AND ZOOMS IN
						var theMap = jQuery('#slider-map').gmap3('get');
						
						theMap.setCenter(position);
						theMap.setZoom(18);
						
					}
					
				}
				
			});
			
			e.preventDefault();
			return false;
			
		},
		
		map_recenter: function(latlng) {
		
			var mapCont = this.gmap3('get');
			
			///// IF FULL WIDTH WE NEED TO PAN 470PX
			if(jQuery(window).width() >= 1000) { var offsetx = -470; var offsety = -15 }
			if(jQuery(window).width() >= 700 && jQuery(window).width() < 1000) { var offsetx = -270; var offsety = -15 }
			if(jQuery(window).width() < 700) { var offsetx = -130; var offsety = -15 }
			
			var point1 = mapCont.getProjection();
			var the_point1 = point1.fromLatLngToPoint(latlng);
			
			var point2 = new google.maps.Point(
				( (typeof(offsetx) == 'number' ? offsetx : 0) / Math.pow(2, mapCont.getZoom()) ) || 0,
				( (typeof(offsety) == 'number' ? offsety : 0) / Math.pow(2, mapCont.getZoom()) ) || 0
			);  
			
			mapCont.setCenter(mapCont.getProjection().fromPointToLatLng(new google.maps.Point(
				the_point1.x - point2.x,
				the_point1.y + point2.y
			)));
			
		},
		
		map_position_offset: function(offsetx, offsety, latLng) {
			
			//// GETS MAP OBJECT
			var mapCont = this.gmap3('get');
			
			var point1 = mapCont.getProjection();
			var the_point1 = point1.fromLatLngToPoint(latLng);
			
			var point2 = new google.maps.Point(
				( (typeof(offsetx) == 'number' ? offsetx : 0) / Math.pow(2, mapCont.getZoom()) ) || 0,
				( (typeof(offsety) == 'number' ? offsety : 0) / Math.pow(2, mapCont.getZoom()) ) || 0
			); 
			
			mapCont.panTo(mapCont.getProjection().fromPointToLatLng(new google.maps.Point(
				the_point1.x - point2.x,
				the_point1.y + point2.y
			)));
			
		},
		
		_sf_refresh_featured_markers: function() {
			var theMap = this;
			var hide_array = new Array();

			if (typeof clusterManager != 'undefined') {
				//// LETS GO THORUGH ALL OUR CLUSTERS
				var clusters = clusterManager.getClusters();
				jQuery.each(clusters, function(i, _cluster) {
					//// LETS GET ALL MARKERS FROM THIS CLUSTER AND ADD TO OUR ARRAY OF OVERLAYS WE NEED TO HIDE
					var markers = _cluster.getMarkers();
					
					if(markers.length > 1) { 
						jQuery.each(markers, function(i, _marker) {
							//// ADDS THIS MARKER ID TO OUR ARRAY
							hide_array.push(_marker.__gm_id)
						});
					}
				});
			}

			if (typeof showFeatured == 'undefined' || showFeatured == true) {
debugger;
				//// LETS GO THHROUGH ALL OUR FEATURED MARKERS
				jQuery('.overlay-featured-wrapper').each(function() {
					//// SEE IF THE ID IS NOT IN THERE
					var overlay_id = jQuery(this).attr('id').split('-');
					//// IF NOT IN THE CLUSTERS SHOW IT
					if(hide_array.indexOf(parseInt(overlay_id[1])) == -1) { jQuery(this).show(); }
					else { jQuery(this).hide(); }
				});
			}
		},
		
		_sf_map_resize: function() {
			
			var mainCont = this;
			var theMap = jQuery('#slider');
			
			mainCont.css({ display: 'block', opacity: 0 });
			
			mainCont._sf_map_resize_fix_top();
			
			//// WHEN THE USER HOVERS THE MAP WE SHOW IT
			theMap.hover(function() {
				
				mainCont.stop().animate({ opacity: 1 }, 200);
				
			}, function() {
				
				//// ONLY DO IT IF THE BUTOTN ISNT HOVERED
				if(!mainCont.is(':hover')) {
				
					mainCont.stop().animate({ opacity: 0 }, 200);
				
				}
				
			});
			
			var min_height = 300;
			
			//// ENABLES IT TO BE DRAGGED
			mainCont.draggable({
				
				axis: 'y',
				start: function(event, ui) {
					
					//// LETS SET A VARIABLE SO WE CAN CALCULLATE HOW MUCH T HE USER HAS DRAGGED
					_sf_resize_handle_pos = ui.position.top;
					_sf_resize_map_height = parseInt(jQuery('#slider-map').height());
					
				},
				drag: function(event, ui) {
					
					//// CALCULATES THE DISTANCE THE USER HAS DRAGGED
					var theDistance = (ui.position.top - _sf_resize_handle_pos);
					
					console.log(ui);
					
					//// APPLIES THAT TO THE MAP HEIGHT
					var theHeight = _sf_resize_map_height + theDistance;
					if(theHeight < min_height) {
						
						theHeight = min_height;
						mainCont.draggable('disable');
						
					}
					jQuery('#slider-map, #slider').height(theHeight);
					
				},
				stop: function(event, ui) {
					
					//// STORES THAT HEIGHT AS A COOKIE FOR FUTURE REFERENCES
					jQuery.cookie('_sf_map_height', parseInt(jQuery('#slider-map').height()), { path: '/' });
					
					var thisMap = theMap.gmap3('get');
					
					//google.maps.event.trigger(thisMap, "resize");
					
				}
				
			});
			
		},
		
		_sf_map_resize_fix_top: function() {
			
			var mainCont = this;
			var theMap = jQuery('#slider');
			
			//// FIXES ITS INITIAL TOP BASED ON POSITION OF HOVER
			var theTop = theMap.height() - 40;
			
			//// IF THE SEARCH FIELDS ARE ON BOTTOM
			if(sf_map.search_position == 'Bottom') {
				
				//// GETS THE TOTAL HEIGHT OF IT AN TAKES OF OUR TOP
				theTop = theTop - (jQuery('#search').outerHeight());
				
			}
			mainCont.css({ top: theTop });
			
		},
		
		_sf_if_dropdown: function(parent_if, values, input) {
			
			var parentCont = this;
			var mainCont = jQuery('#search-spots .'+parent_if);
				
			//// GETS THE VALUE OF THE NEW SELECTED ITEM
			var selVal = parentCont.children('option:selected').val();
			
			///// IF IT'S IN OUR LIST OF VALUES DISPLAY THAT FIELD
			if(values.indexOf(selVal) != -1) { mainCont.fadeIn(200); }
			else { mainCont.hide(); }
			
			//// IF THE VALUE IS NIL CHECK FOR ALL VALUE
			if(parentCont.children('option:selected').val() == '') {
				
				if(values.indexOf('all') != -1) { mainCont.fadeIn(200); }
				
			}
			
			//// ADDS THE ONCHANGE EVENT TO OUR PARENT
			parentCont.change(function() {
				
				//// GETS THE VALUE OF THE NEW SELECTED ITEM
				var selVal = jQuery(this).children('option:selected').val();
				
				///// IF IT'S IN OUR LIST OF VALUES DISPLAY THAT FIELD
				if(values.indexOf(selVal) != -1) { mainCont.fadeIn(200); }
				else { mainCont.hide(); }
			
				//// IF THE VALUE IS NIL CHECK FOR ALL VALUE
				if(jQuery(this).children('option:selected').val() == '') {
					
					if(values.indexOf('all') != -1) { mainCont.fadeIn(200); }
					
				}
				
			});
			
		},
		
		_sf_if_check: function(parent_if, input) {
			
			var parentCont = this;
			var mainCont = jQuery('#search-spots .'+parent_if);
				
			if(parentCont.is(':checked')) { mainCont.fadeIn(200); }
			else { mainCont.hide(); }
			
			parentCont.parent().click(function() {
				
				if(parentCont.is(':checked')) { mainCont.fadeIn(200); }
				else { mainCont.hide(); }
				
			});
			
		},
		
		_sf_draw_radius: function(radius, lat, lng, distance_type, field_id, field_val, action) {
				
			jQuery('#search-spots')._sf_destroy_radius();
			
			//// DRAW A RADIUS ON OUT MAP
			var gMap = this;
			var theMap = this.gmap3('get');
			
			/// MAKES SURE WE REMOVE OTHER CIRCLES FROM THE MAP
			gMap.gmap3({
				
				clear: {
					
					tag: ['radiusCircle', 'radiusCenter', 'radiusResizer']
					
				}
				
			});
			
			if(action == 'destroy' || radius == null) {
				
				jQuery('#_sf_radius_field').val('');
				jQuery('#_sf_enable_radius_search').val('');
				jQuery('#_sf_radius_lat_from').val('');
				jQuery('#_sf_radius_lat_to').val('');
				jQuery('#_sf_radius_lng_from').val('');
				jQuery('#_sf_radius_lng_to').val('');
				jQuery('#_sf_radius_distance').val('');
				jQuery('#_sf_radius_center_lat').val('');
				jQuery('#_sf_radius_center_lng').val('');
				jQuery('._sf_ignore_sel_radius').val('');
				jQuery('._sf_ignore_sel').val('');
				jQuery('._sf_ignore_sel_parent').val('');
				
				return true;
				
			}
			
			console.log('draw');
			
			//// TRANSFERS OUR RADIUS VALUE INTO METREST
			if(distance_type == 'Kilometres') { radius_metres = (radius * 1000); }
			else { radius_metres = (radius * 1609.344); }
			
			//// LET'S DRAW THE INITIAL CIRCLE - RADIUS
			gMap.gmap3({
				
				circle: {
					
					options: {
						
						center: [lat, lng],
						radius: radius_metres,
						fillColor : sf.primary_color,
						strokeColor : sf.primary_color,
						fillOpacity : 0.05,
						strokeWeight: 3,
						strokeOpacity: .15,
						clickable: false
						
					},
					tag: 'radiusCircle',
					
				},
				
				overlay: {
					
					latLng: [lat, lng],
					options: {
						
						content: '<div class="_sf_radius_center" style="background: '+sf.primary_color+';"></div>',
						offset: { x: -6, y: -6 }
						
					},
					tag: 'radiusCenter'
					
				}
				
			});
			
			//// GETS THE CIRCLE AS A CIRCLE OBJECT
			gMap.gmap3({
				
				get: {
					
					name: 'circle',
					tag: 'radiusCircle',
					callback: function(obj) {
						
						sfTheCircleRadius = obj;
						
					}
					
				}
				
			});
			
			//// SETS OUR GLOBAL CIRCLE INPUTS FOR RADIUS
			jQuery('._sf_ignore_sel_'+field_id).val(field_val);
									
			///// NOW WE NEED TO POPULATE OUR LATITUDE AND LONGITUDE FIELDS SO WE CAN FILTER LISTINGS BASED ON LOCATION
			var newCircleBounds = sfTheCircleRadius.getBounds();
			jQuery('#_sf_enable_radius_search').val('true');
			jQuery('#_sf_radius_lat_from').val(newCircleBounds.getSouthWest().lat());
			jQuery('#_sf_radius_lat_to').val(newCircleBounds.getNorthEast().lat());
			jQuery('#_sf_radius_lng_from').val(newCircleBounds.getSouthWest().lng());
			jQuery('#_sf_radius_lng_to').val(newCircleBounds.getNorthEast().lng());
			
			//// UPDATES DISTANCE AND THE CENTER POINT
			jQuery('#_sf_radius_distance').val(radius);
			jQuery('#_sf_radius_center_lat').val(sfTheCircleRadius.getCenter().lat());
			jQuery('#_sf_radius_center_lng').val(sfTheCircleRadius.getCenter().lng());
			jQuery('#_sf_radius_field').val(field_id);
			
			///// IF WE HVE RESIZING ENABLED
			if(sf.enable_radius_resizing == 'on') {
				
				//// GETS THE CIRCLE BOUNDS
				var circleBounds = sfTheCircleRadius.getBounds();
				
				// Bounds might not always be set so check that it exists first.
				if(circleBounds) {
					
					//// LETS SET OUR NEW MARKER RIGHT IN THE SOUTH WEST
					var southWestLatLng = circleBounds.getSouthWest();
					var resizerLng = southWestLatLng.lng();
					var resizerLat = sfTheCircleRadius.getCenter().lat();
					
					//// NOW WE CAN SET UP OUR NEW MARKER
					gMap.gmap3({
						
						marker: {
							
							tag: 'radiusResizer',
							options: {
								
								position: new google.maps.LatLng(resizerLat, resizerLng),
								icon: {
									
									url: sf.radius_resizing_icon,
									scaledSize: new google.maps.Size(20,20),
									anchor: {
										
										x: 10,
										y: 10
										
									}
									
								},
								draggable: true
								
							},
							events: {
								
								//// WHEN WE DRAG THE PIN
								drag: function(marker) {
									
									//// NOW WE NEED TO CALCULATE THE DISTANCE BETWWEN THE CENTER OF THE CIRCLE AND OUR RESIZING MARKER SO WE CAN SET THE NEW CIRCLE
									var p1 = marker.getPosition();
									var p2 = sfTheCircleRadius.getCenter();
									
									//// CALCULATES THE DISTANCE
									var R = 6371; // Radius of the Earth in km
									var dLat = (p2.lat() - p1.lat()) * Math.PI / 180;
									var dLon = (p2.lng() - p1.lng()) * Math.PI / 180;
									var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
											Math.cos(p1.lat() * Math.PI / 180) * Math.cos(p2.lat() * Math.PI / 180) *
											Math.sin(dLon / 2) * Math.sin(dLon / 2);
									var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
									var d = R * c;
									
									//// TRANSLARES OUR D INTO METERS
									var dMeters = d * 1000;
									
									//// SETS THE NEW RADIUS FOR OUR CIRCLE
									sfTheCircleRadius.setRadius(dMeters);
									
									sfTheCircleRadius.setOptions({
										
										fillOpacity: .2,
										strokeOpacity: .5
										
									});
									
								},
								
								dragend: function(marker) {
									
									//// NOW WE NEED TP UPDATE OUR FIELD SO THE SEARCH FUNCTIONALITY CAN KNOW WE'RE LOOKING FOR RADIUS RATHER THAN LOCATION NOW
									jQuery('#_sf_ignore_sel_'+field_id).val(field_val);
									
									///// NOW WE NEED TO POPULATE OUR LATITUDE AND LONGITUDE FIELDS SO WE CAN FILTER LISTINGS BASED ON LOCATION
									var newCircleBounds = sfTheCircleRadius.getBounds();
									jQuery('#_sf_enable_radius_search').val('true');
									jQuery('#_sf_radius_lat_from').val(newCircleBounds.getSouthWest().lat());
									jQuery('#_sf_radius_lat_to').val(newCircleBounds.getNorthEast().lat());
									jQuery('#_sf_radius_lng_from').val(newCircleBounds.getSouthWest().lng());
									jQuery('#_sf_radius_lng_to').val(newCircleBounds.getNorthEast().lng());
									
									//// WE NEED TO GET THE DISTANCE FROM THE CENTER AGAIN
									var p1 = marker.getPosition();
									var p2 = sfTheCircleRadius.getCenter();
									
									//// CALCULATES THE DISTANCE
									var R = 6371; // Radius of the Earth in km
									var dLat = (p2.lat() - p1.lat()) * Math.PI / 180;
									var dLon = (p2.lng() - p1.lng()) * Math.PI / 180;
									var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
											Math.cos(p1.lat() * Math.PI / 180) * Math.cos(p2.lat() * Math.PI / 180) *
											Math.sin(dLon / 2) * Math.sin(dLon / 2);
									var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
									var d = R * c;
									
									//// UPDATES DISTANCE AND THE CENTER POINT
									jQuery('#_sf_radius_distance').val(d);
									jQuery('#_sf_radius_center_lat').val(p2.lat());
									jQuery('#_sf_radius_center_lng').val(p2.lng());
									jQuery('#_sf_radius_field').val(field_id);
									
									jQuery('#search-spots').submit();
									
								},
								mouseover: function(marker) {
									
									sfTheCircleRadius.setOptions({
										
										fillOpacity: .2,
										strokeOpacity: .5
										
									});
									
								},
								mouseout: function(marker) {
									
									sfTheCircleRadius.setOptions({
										
										fillOpacity: .05,
										strokeOpacity: .2
										
									});
									
								}
								
							},
							callback: function(marker) {
								
								//// CHECKS FOR CLUSTER MANAGER, WE DONT WANT INCLUDE OUR MARKER IN THE CLUSTER
								if(typeof clusterManager !== 'undefined') { clusterManager.removeMarker(marker); }
								
							}
							
						}
						
					});
					
				}
			
			}
			
		},
		
		_sf_destroy_radius: function() {
			
			//// DESTROY MARKER AND OVERLAY
			//// DRAW A RADIUS ON OUT MAP
			var gMap = this;
			
			/// MAKES SURE WE REMOVE OTHER CIRCLES FROM THE MAP
			gMap.gmap3({
				
				clear: {
					
					tag: ['radiusCircle', 'radiusCenter', 'radiusResizer']
					
				}
				
			});
			
		},
		
		_sf_check_for_radius: function(field_id) {
			
			var sel = this;
			
			if((sel.find('option:selected').val() == '' || sel.find('option:selected').val() == 0 || sel.find('option:selected').val() == 'undefined') && jQuery('#_sf_radius_field').val() == field_id) {
				
				jQuery('#slider-map')._sf_draw_radius(null, null, null, null, null, null, 'destroy');
				
			}
			
		},
		
		_sf_show_cluster_markers: function(latLng, markers) {
			
			var theMap = this;
				
			var liMarkup = '';
			
			jQuery('#slider-map').removeOverlays();
			
			//// NOW WE NEED TO GO MARKER BY MARKER AND CREATE OUR LIST
			jQuery.each(markers, function(i, obj) {
				
				var theMarkerId = obj.__gm_id;
				
				//// LETS GET THE TITLE
				if(jQuery('.overlay-helper-'+theMarkerId).attr('class').indexOf('featured') != -1) {
					
					/// ITS A FEATURED OVERLAY
					var theTitle = jQuery('.overlay-helper-'+theMarkerId+' img').attr('title');
					var thePermalink = jQuery('.overlay-helper-'+theMarkerId+' a').attr('href');
					
				} else {
					
					// ITS A SIMPLE OVERLAY
					var theTitle = jQuery('.overlay-helper-'+theMarkerId+' .title').text();
					var thePermalink = jQuery('.overlay-helper-'+theMarkerId+' a').attr('href');
					
				}
					
				liMarkup += '<li><a href="'+thePermalink+'" title="'+theTitle+'">'+theTitle+'</a></li>';
				
			});
			
			//// WE CAN NOW ADD OUR OVERLAY
			theMap.gmap3({
				
				overlay: {
					
					latLng: [latLng.lat(), latLng.lng()],
					options: {
						
						content: '<div class="overlay-cluster-wrapper"><div class="overlay-cluster"><ul>'+liMarkup+'</ul><span class="arrow"></span></div></div>',
						offset: {
							
							x: 30,
							y: -125
							
						}
						
					},
					callback: function(results) {
						
						//// LETS ANIMATE IT
						var overlay = jQuery(results.getDOMElement()).find('.overlay-cluster-wrapper .overlay-cluster');
						
						//// CENTERS IT VERTICALLY
						overlay.css({ display: 'block', opacity: 0 }).stop().animate({ opacity: 0 }, 5, function() {
							
							var theHeight = overlay.outerHeight();
							overlay.css({ 'margin-top': '-'+(theHeight/2-7)+'px', left: '-20px' }).stop().animate({ left: 0, opacity: 1 }, 200);
							
						});
						
						//overlay.find('.overlay-cluster').css({ 'margin-top': '-'+theHeight+'px', opacity: 1 });
						
					}
					
				}
				
			});
			
			
			//jQuery('.overlay-featured-wrapper-'+context.id)
			
		},
		
		sf_open_pin_title_featured: function(marker, event, context, lat, lng) {
									
			//// ANIMATES OUR FEATURED BUBBLE FIRST
			jQuery('.overlay-featured-wrapper-'+context.id).stop().animate({ width: '75px', height: '75px', left: '62px', top: '-54px', opacity: 1 }, { duration: 250, easing: 'easeInOutBack' });
			
			//// CHECKS FOR HEIGHT FIRST
			jQuery('#overlay-title-'+context.id).css({ display: 'block', opacity: 0 });
			var titleHeight = jQuery('#overlay-title-'+context.id).height();
			if(titleHeight > 30) { var the_top = 34; var the_top_final = -20; }
			else { var the_top = 14; var the_top_final = 0; }
			
			jQuery('#slider-map').openSpotOverlay(context.id, lat, lng);
			
		},
		
		sf_open_pin_title: function(marker, event, context) {
			
			jQuery('#overlay-title-'+context.id).css({ display: 'block', opacity: 0 });
			var titleHeight = jQuery('#overlay-title-'+context.id).height();
			var the_top_final = 20;
			
			if(titleHeight > 30) { var the_top = 34; }
			else { var the_top = 14; }
	
			//// OPENS OUR MARKER
			jQuery('#overlay-title-'+context.id).css({ top: the_top+'px' }).stop().animate({ opacity: 1, top: the_top_final+'px' }, { duration: 150, easing: 'easeInOutQuint' });
			
		}
		
	});
	
})(jQuery);

jQuery.urlParam = function(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
	console.log(results);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}







/**
 * Copyright (c) 2007-2013 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.6
 */
;(function($){var h=$.scrollTo=function(a,b,c){$(window).scrollTo(a,b,c)};h.defaults={axis:'xy',duration:parseFloat($.fn.jquery)>=1.3?0:1,limit:true};h.window=function(a){return $(window)._scrollable()};$.fn._scrollable=function(){return this.map(function(){var a=this,isWin=!a.nodeName||$.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!isWin)return a;var b=(a.contentWindow||a).document||a.ownerDocument||a;return/webkit/i.test(navigator.userAgent)||b.compatMode=='BackCompat'?b.body:b.documentElement})};$.fn.scrollTo=function(e,f,g){if(typeof f=='object'){g=f;f=0}if(typeof g=='function')g={onAfter:g};if(e=='max')e=9e9;g=$.extend({},h.defaults,g);f=f||g.duration;g.queue=g.queue&&g.axis.length>1;if(g.queue)f/=2;g.offset=both(g.offset);g.over=both(g.over);return this._scrollable().each(function(){if(e==null)return;var d=this,$elem=$(d),targ=e,toff,attr={},win=$elem.is('html,body');switch(typeof targ){case'number':case'string':if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(targ)){targ=both(targ);break}targ=$(targ,this);if(!targ.length)return;case'object':if(targ.is||targ.style)toff=(targ=$(targ)).offset()}$.each(g.axis.split(''),function(i,a){var b=a=='x'?'Left':'Top',pos=b.toLowerCase(),key='scroll'+b,old=d[key],max=h.max(d,a);if(toff){attr[key]=toff[pos]+(win?0:old-$elem.offset()[pos]);if(g.margin){attr[key]-=parseInt(targ.css('margin'+b))||0;attr[key]-=parseInt(targ.css('border'+b+'Width'))||0}attr[key]+=g.offset[pos]||0;if(g.over[pos])attr[key]+=targ[a=='x'?'width':'height']()*g.over[pos]}else{var c=targ[pos];attr[key]=c.slice&&c.slice(-1)=='%'?parseFloat(c)/100*max:c}if(g.limit&&/^\d+$/.test(attr[key]))attr[key]=attr[key]<=0?0:Math.min(attr[key],max);if(!i&&g.queue){if(old!=attr[key])animate(g.onAfterFirst);delete attr[key]}});animate(g.onAfter);function animate(a){$elem.animate(attr,f,g.easing,a&&function(){a.call(this,targ,g)})}}).end()};h.max=function(a,b){var c=b=='x'?'Width':'Height',scroll='scroll'+c;if(!$(a).is('html,body'))return a[scroll]-$(a)[c.toLowerCase()]();var d='client'+c,html=a.ownerDocument.documentElement,body=a.ownerDocument.body;return Math.max(html[scroll],body[scroll])-Math.min(html[d],body[d])};function both(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);