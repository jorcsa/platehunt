<?php

	//// OUR VARIABLE
	$_sf_custom_fields = htmlspecialchars_decode(get_post_meta($post->ID, '_sf_custom_fields', true));
	$_sf_gallery_images = get_post_meta($post->ID, '_sf_gallery_images', true);
	$address = get_post_meta($post->ID, 'address', true);
	$latitude = get_post_meta($post->ID, 'latitude', true);
	$longitude = get_post_meta($post->ID, 'longitude', true);
	$pin = get_post_meta($post->ID, 'pin', true);
	$contact_form = get_post_meta($post->ID, 'contact_form', true);
	$featured = get_post_meta($post->ID, 'featured', true);
	$slogan = get_post_meta($post->ID, 'slogan', true);
	
	if(ddp('price_featured_recurring') == 'on') {
		
		$featured_payment_expire = get_post_meta($post->ID, 'featured_payment_expire', true);
		
	}
	
	$original_post = $post;

	//// OUR VARIABLE
	$header_bg = get_post_meta($post->ID, 'header_bg', true);
	$header_title = get_post_meta($post->ID, 'header_title', true);
	$header_color = get_post_meta($post->ID, 'header_color', true);
	$fancy_slogan = get_post_meta($post->ID, 'fancy_slogan', true);
	
	if($header_color == '') { $header_color = '#ffffff'; }
	
?>
<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/icons.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/gmap3.min.js"></script>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?sensor=false'></script>

<div class="bpanel-tabbed-meta">

	<ul class="tabs">
    
    	<li class="bpanel-tab current" style="padding-left: 5px;"><i class="icon-desktop"></i><?php _e('Front-End', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;" onclick="loadInitMap();"><i class="icon-location"></i><?php _e('Location', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-arrow-combo"></i><?php _e('Dropdowns', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-up"></i><?php _e('Min Values', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-down"></i><?php _e('Max Values', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-resize-horizontal"></i><?php _e('Range Fields', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-check"></i><?php _e('Checkboxes', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-doc-text"></i><?php _e('Custom Fields', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-doc-text"></i><?php _e('Custom Submission Fields', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-desktop"></i> <?php _e('Fancy Header', 'btoa'); ?></li>
    
    </ul>
    <!-- /.tabs/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->
    
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('#contact_form').iphoneStyle();
			jQuery('#featured').iphoneStyle();
			
			jQuery(document).keydown(function(e) {
				
				if(e.keyCode == 13) {
				
					//// IS USER IS FOCUSED ON ANY OF THESE
					if(jQuery('input:focus').attr('id') == 'add_custom_field_form_label' || jQuery('input:focus').attr('id') == 'add_custom_field_form_value') {
						
						jQuery('#post').submit(function(x) {
							
							if(jQuery('input:focus').attr('id') == 'add_custom_field_form_label' || jQuery('input:focus').attr('id') == 'add_custom_field_form_value') {
							
								x.preventDefault();
								jQuery('#publishing-action .spinner').hide();
								jQuery('#publish').removeAttr("disabled");
							
							}
							
						});
						
						//// SUBMITS THE FIELD
						jQuery('#add_custom_field_form input.button').insertSpotCustomField();
						
						return false;
						
					}
				
				}
				
			});
			
		
		//AJAX upload
		jQuery('#pin_upload').each(function(){
			
			var the_button = jQuery(this);
			var image_input = jQuery('#pin');
			var image_id = jQuery(this).attr('id');
			//alert('a');
			
			new AjaxUpload(image_id, {
				
				  action: ajaxurl,
				  name: image_id,
				  
				  // Additional data
				  data: {
					action: 'ddpanel_ajax_upload',
					data: image_id,
					post_id: <?php echo $post->ID ?>
				  },
				  
				  autoSubmit: true,
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension) {
					  
					  //// ALLOWS IMAGES ONLY
					  if(extension == 'png' || extension == 'gif' || extension == 'jpg' || extension == 'jpeg') {
					  
						the_button.attr('disabled', 'disabled').val('Uploading').addClass('ddpanel-upload-button-disabled');	
						  
					  } else {
						  
						  return false;
						  alert('You can only upload PNG, JPG or GIF images.');
						  
					  }
									  
				  },
				  
				  onComplete: function(file, response) {
					  
					  var theImage = jQuery.parseJSON(response);
						
					  the_button.removeAttr('disabled').removeClass('ddpanel-upload-button-disabled');
					  
					  if(response.search("Error") > -1){
						  
						  alert("There was an error uploading:\n"+response);
						  
					  }
					  
					  else{		
										  
						  image_input.val(theImage.url);
						  the_button.val('Upload Image')
						  
							  
					  }
					  
				  }
			});
		});
		
		
		
		jQuery('#_sf_gallery_upload').each(function(){
			
			var the_button = jQuery(this);
			var image_id = jQuery(this).attr('id');
			//alert('a');
			
			new AjaxUpload(image_id, {
				
				  action: ajaxurl,
				  name: image_id,
				  
				  // Additional data
				  data: {
					action: 'ddpanel_ajax_upload',
					data: image_id,
					post_id: <?php echo $post->ID ?>
				  },
				  
				  autoSubmit: true,
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension) {
					  
					  //// ALLOWS IMAGES ONLY
					  if(extension == 'png' || extension == 'gif' || extension == 'jpg' || extension == 'jpeg') {
					  
						the_button.attr('disabled', 'disabled').val('Uploading').addClass('ddpanel-upload-button-disabled');	
						  
					  } else {
						  
						  alert('<?php _e('You can only upload PNG, JPG or GIF images.', 'btoa'); ?>');
						  return false;
						  
					  }
									  
				  },
				  
				  onComplete: function(file, response) {
					  
					  var theImage = jQuery.parseJSON(response);
						
					  the_button.removeAttr('disabled').removeClass('ddpanel-upload-button-disabled');
					  
					  if(response.search("Error") > -1){
						  
						  alert("There was an error uploading:\n"+response);
						  
					  }
					  
					  else{		
										  
						 
						 //// ADDS THE IMAGE TO OUR ARRAY
						 jQuery('#_sf_gallery > ul').append('<li><input type="hidden" name="image_id" value="'+theImage.id+'"><img src="'+theImage.thumb+'" alt="" /><span class="remove" onclick="jQuery(this).removeFromGallery();"><i class="icon-trash"></i></span></li>');
						 
						 jQuery('#_sf_gallery ul._sf_images').refreshSpotGallery();
						 
						 
						  the_button.val('<?php _e('Upload New Image', 'btoa'); ?>');
							  
					  }
					  
				  }
			});
		});
		
		
		
		
			
			jQuery('.bpanel-tabbed-meta .tabs li').click(function() {
				
				if(jQuery(this).attr('class').indexOf('current') == -1) {
					
					var clickedIndex = jQuery(this).index();
					jQuery(this).addClass('current').siblings('.current').removeClass('current');
					
					jQuery(this).parent().siblings('.tabbed').children('li.current').removeClass('current');
					jQuery(this).parent().siblings('.tabbed').children('li:eq('+clickedIndex+')').addClass('current');
					
				}
				
			});
							
							
							
							//// GETS LATITUDE AND LONGITUDE
							jQuery('#sf_get_lat_lng_address').click(function() {
								
								var the_address = jQuery('#address').val();
							
								var geocoder = new google.maps.Geocoder();
								var latLng = geocoder.geocode({
									
									address: the_address
									
								}, function(results, status) {
									
									/// IF WE HAVE A RESULT
									if(status == google.maps.GeocoderStatus.OK) {
										
										lat = results[0].geometry.location.lat();
										lng = results[0].geometry.location.lng();
										
										jQuery('#latitude').val(lat);
										jQuery('#longitude').val(lng);
										
										jQuery(gMap).gmap3({
											
											get: {
												
												name: 'marker',
												all: true,
												callback: function(objs) {
													
													jQuery.each(objs, function(i, obj) {
														
														obj.setMap(null);
														
													})
													
												}
												
											},
											
											map: {
												
												options: {
												
													zoom: 14,
													center: new google.maps.LatLng(lat, lng)
												
												}
												
											},
											marker: {
												
												values: [{ latLng:[lat, lng] }],
												options: {
													
													draggable: true
													
												},
												events: {
													
													mouseup: function(marker, event, context) {
														
														//// GETS MARKER LATITUDE AND LONGITUDE
														var thePos = marker.getPosition();
														var theLat = thePos.lat();
														var theLng = thePos.lng();
														
														jQuery('#latitude').val(theLat);
														jQuery('#longitude').val(theLng);
														
													}
													
												}
												
											}
											
										});
										
									} else {
										
										alert('Could not find the latitude and longitude for the address '+the_address);
										
									}
									
								});
								
							});
			
		});
	
	function loadInitMap() {
							
			
		if(typeof gMap == 'undefined') {
							
							
			//// CREATES A MAP
			gMap = jQuery('#property-loc');
			
			gMap.gmap3({
				
				map: {
					
					options: {
						
						zoom: 2,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						mapTypeControl: true,
						mapTypeControlOptions: {
						  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
						},
						navigationControl: true,
						scrollwheel: true,
						streetViewControl: false
						
					}
					
				}
				
			});
			
			//// IF LATITUDE AND LONGITUDE ARE SET
			var lat = jQuery('#latitude').val();
			var lng = jQuery('#longitude').val();
			
			if(lat != '' && lng != '') { if(!isNaN(lat) && !isNaN(lng)) {
				
				//// SET MAP
				jQuery(gMap).gmap3({
					
					map: {
						
						options: {
							
							zoom: 14,
							center: new google.maps.LatLng(lat, lng)
							
						}
						
					},
					
					marker: {
						
						values: [{ latLng:[lat, lng] }],
						options: {
							
							draggable: true
							
						},
						events: {
							
							mouseup: function(marker, event, context) {
								
								//// GETS MARKER LATITUDE AND LONGITUDE
								var thePos = marker.getPosition();
								var theLat = thePos.lat();
								var theLng = thePos.lng();
								
								jQuery('#latitude').val(theLat);
								jQuery('#longitude').val(theLng);
								
							}
							
						}
						
					}
					
				});
				
			} }
		
		}
		
	}
	
	</script>
    
    <ul class="tabbed tabbed-fields">
        
        
        
        <li class="current">
        
        	<?php if(ddp('submission_days') != '0' && ddp('submission_days') != '' && $post->post_status == 'publish') :
			
				
					if(get_post_meta(get_the_ID(), 'expiry_date', true) != '') {
						$date = date('d-m-Y', get_post_meta(get_the_ID(), 'expiry_date', true));
					} else {
						$date = __('Never', 'btoa');
					}
					
			
			?>
			
			  <script type="text/javascript">
			  
			  	jQuery(document).ready(function() {
					
					var post_created = new Date(<?php echo get_the_time('U', $post) * 1000; ?>)
					
					//// ADDS A DATE PICKER TO OUR FIELD
					jQuery('#expiry_date_value').datepicker({
						
						minDate: post_created,
						dateFormat: 'dd-mm-yy',
						onSelect: function(date, ui) {
							
							var newDate = new Date(ui.selectedYear, ui.selectedMonth, ui.selectedDay, 0, 0, 0);
							var unix = newDate.getTime() / 1000;
							
							//// SETS UP OUR HIDDEN INPUT
							jQuery('#expiry_date').val(unix);
							
						}
						
					});
					
				});
			  
			  </script>
            
            <div class="one-fifth"><label for="expiry_date"><?php _e('Expires:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="expiry_date_value" id="expiry_date_value" value="<?php echo $date ?>" class="widefat" style="margin-bottom: 5px;" />
			<input type="hidden" id="expiry_date" name="expiry_date" value="<?php echo get_post_meta(get_the_ID(), 'expiry_date', true) ?>" /></div>
            <div class="two-fifths description last"><?php _e('When this is to expire', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <?php endif; ?>
            
            <div class="one-fifth"><label for="slogan"><?php _e('Slogan:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="slogan" id="slogan" value="<?php echo $slogan ?>" class="widefat" style="margin-bottom: 5px;" maxlength="256" /></div>
            <div class="two-fifths description last"><?php _e('Spot Slogan.', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="pin"><?php _e('Custom Pin:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="pin" id="pin" value="<?php echo $pin ?>" class="widefat" style="margin-bottom: 5px;" /><input type="button" class="button" id="pin_upload" value="Upload Image" /></div>
            <div class="two-fifths description last"><?php _e('Upload your custom pin.', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth">
            
            	<label for="gallery"><?php _e('Gallery:', 'btoa'); ?></label>
				
				<div class="bDivider"></div>
				
				<h5><?php _e('Add from media gallery', 'btoa'); ?></h5>
				
				<?php
				
					//// LETS GET ATTACHEMTN FROM THE MEDIA GALLERY
					$args = array(
					
						'post_type' => 'attachment',
						'post_mime_type' =>'image',
						'post_status' => 'inherit',
						'posts_per_page' => -1,
						'post_parent' => $post->ID,
						'orderby' => 'menu_order',
						'order' => 'ASC',
					
					);
					
					$galQ = new WP_Query($args);
					
					if($galQ->have_posts()) :
				
				?>
				
					<ul class="_sf_gallerY_image_click">
					
						<?php
						
							while($galQ->have_posts()) : $galQ->the_post();
							
							$image = wp_get_attachment_url(get_the_ID());
							
						?>
						
							<li onclick="jQuery(this)._sf_add_attachemnt_to_gallery();"><img src="<?php echo ddTimthumb($image, 150, 150) ?>" alt="<?php the_ID(); ?>" title="<?php the_ID(); ?>" /s></li>
						
						<?php endwhile; wp_reset_postdata(); ?>
					
					</ul>
				
				<?php else: ?>
				
					<em><?php _e('No images found in your media gallery.', 'btoa'); ?></em>
				
				<?php endif; ?>
                
           </div>
           
           <div class="four-fifths last values" id="_sf_gallery">
            
            	<input type="hidden" value="<?php echo $_sf_gallery_images; ?>" id="_sf_gallery_images" name="_sf_gallery_images" />
                
                <input type="button" class="button" value="<?php _e('Upload New Image', 'btoa'); ?>" id="_sf_gallery_upload" /><br /><br />
                
                    <ul class="_sf_images">
                
                	<?php
					
						//// IF WE HAVE IMAGES
						if(is_object(json_decode(htmlspecialchars_decode($_sf_gallery_images)))) :
						
					?>
                    
                        <script type="text/javascript">
                        
                            jQuery(document).ready(function() {
                                
                                jQuery('#_sf_gallery ul._sf_images').sortable({
                                    
                                    items: '> li',
                                    stop: function(event, ui) {
                                        
                                        jQuery('#_sf_gallery ul._sf_images').refreshSpotGallery();
                                        
                                    }
                                    
                                });
                                
                            });
					
					</script>
                    
                    
                   	<?php
					
						//// LETS LOOP IMAGE BY IMAGE
						foreach(json_decode(htmlspecialchars_decode($_sf_gallery_images)) as $single_image) :
						
						//// GETS THE IMAGE
						if($this_image = wp_get_attachment_image_src($single_image, 'full')) :
						
						$image_url = ddTimthumb($this_image[0], 150, 150);
					
					?>
                    
                    	<li>
                        
                        	<input type="hidden" name="image_id" value="<?php echo $single_image; ?>">
                            
                            <img src="<?php echo $image_url ?>" alt="" />
                            
                            <span class="remove" onclick="jQuery(this).removeFromGallery();"><i class="icon-trash"></i></span>
                            <!-- /.remove/ -->
                        
                        </li>
                    
                    <?php endif; endforeach; ?>
                    
                    <?php endif; ?>
           
           </ul>
            
            </div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="contact_form"><?php _e('Contact Form:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="checkbox" name="contact_form" id="contact_form"<?php if($contact_form == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
            <div class="two-fifths description last"><?php _e('Upload your custom pin.', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="featured"><?php _e('Featured:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="checkbox" name="featured" id="featured"<?php if($featured == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
            <div class="two-fifths description last"><?php _e('Feature this spot. Featured spots show at the top of listings.', 'btoa'); ?></div>
            
            <div class="clear"></div>
        
        	<?php if(ddp('price_featured_recurring') == 'on' && ddp('price_featured_days') != '0' && ddp('price_featured_days') != '' && $post->post_status == 'publish') :
			
				
					if(get_post_meta(get_the_ID(), 'featured_payment_expire', true) != '') {
						$featured_payment_expire = date('d-m-Y', get_post_meta(get_the_ID(), 'featured_payment_expire', true));
					} else {
						$featured_payment_expire = __('Never', 'btoa');
					}
					
			
			?>
			
			  <script type="text/javascript">
			  
			  	jQuery(document).ready(function() {
					
					var post_created = new Date()
					
					//// ADDS A DATE PICKER TO OUR FIELD
					jQuery('#featured_payment_expire_value').datepicker({
						
						minDate: post_created,
						dateFormat: 'dd-mm-yy',
						onSelect: function(date, ui) {
							
							var newDate = new Date(ui.selectedYear, ui.selectedMonth, ui.selectedDay, 0, 0, 0);
							var unix = newDate.getTime() / 1000;
							
							//// SETS UP OUR HIDDEN INPUT
							jQuery('#featured_payment_expire').val(unix);
							
						}
						
					});
					
				});
			  
			  </script>
			
			<div class="bDivider"></div>
            
            <div class="one-fifth"><label for="featured_payment_expire_value"><?php _e('Featured Selection Expires:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="featured_payment_expire_value" id="featured_payment_expire_value" value="<?php echo $featured_payment_expire ?>" class="widefat" style="margin-bottom: 5px;" />
			<input type="hidden" id="featured_payment_expire" name="featured_payment_expire" value="<?php echo get_post_meta($post->ID, 'featured_payment_expire', true); ?>" /></div>
            <div class="two-fifths description last"><?php _e('When will the featured selection expire', 'btoa'); ?></div>
            
            <div class="clear"></div>
            
            <?php endif; ?>
        
        </li>
        
        
        
        
        
        <li class="">
            
            <div class="one-fifth"><label for="address"><?php _e('Address', 'btoa'); ?>:</label></div>
            <div class="two-fifths"><input type="text" name="address" id="address" value="<?php echo $address ?>" class="widefat" /><br><input type="button" class="button" id="sf_get_lat_lng_address" value="Get Pinpoint" style="margin: 5px 0 0;" /></div>
            <div class="two-fifths description last"><?php _e('Spot Address. Enter your address and get latitude and longitude automatically. You can drag a drop the pin to adjust actual latitude and longitude.', 'btoa'); ?></div>
    
    		<div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="latitude"><?php _e('Latitude:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="latitude" id="latitude" value="<?php echo $latitude ?>" class="widefat" /></div>
            <div class="two-fifths description last"><?php _e('Pin Latitude.', 'btoa'); ?></div>
    
    		<div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="longitude"><?php _e('Longitude:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="longitude" id="longitude" value="<?php echo $longitude ?>" class="widefat" /></div>
            <div class="two-fifths description last"><?php _e('Pin Longitude.', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <p style="margin: 40px 0 5px;"><strong><?php _e('Type in your address to set pin. Pin is draggable.', 'btoa'); ?></strong></p>
            <div id="property-loc" style="width: 100%; height: 400px; float: left; position: relative;"></div>
    
    		<div class="clear"></div>
        
        </li>
    
    	<li class="">
        
        	<?php
			
			
				//// GETS ALL AVAILABLE DROPDOWNS FIRST AND THEN DEPENDENTS
				$args = array(
				
					'post_type' => 'search_field',
					'meta_query' => array(
					
						array(
						
							'key' => 'field_type',
							'value' => 'dropdown',	
						
						)
					
					),
					'posts_per_page' => -1,
				
				);
				
				$dQ = new WP_Query($args);
				
				$args = array(
				
					'post_type' => 'search_field',
					'meta_query' => array(
					
						array(
						
							'key' => 'field_type',
							'value' => 'dependent',	
						
						)
					
					),
					'posts_per_page' => -1,
				
				);
				
				$dQ2 = new WP_Query($args);
				
				$i = 1;
				$total_posts = $dQ->found_posts + $dQ2->found_posts;
				
				//// IF BOTH HAVE VALUES
				if(!$dQ->have_posts() && !$dQ2->have_posts()) :
			
			?>
            
            	<h2><?php _e('You don\'t have any dropdown fields.', 'btoa'); ?></h2>
            
            <?php else : ?>
            
            	<?php
				
					//// LETS LOOP OUR DROPDOWNS
					while($dQ->have_posts()) : $dQ->the_post();
				
				?>
                
                	<div class="search-field">	
                
                		<h3 onclick="if(jQuery(this).siblings('.insider').is(':visible')) { jQuery(this).siblings('.insider').hide(); } else { jQuery(this).siblings('.insider').show(); }"><?php the_title(); ?><span class="arrow"></span></h3>
                        
                        <div class="insider">
                            
							<?php
                            
                                //// LETS GO THROUGH ALL FIELDS AND DISPLAY THEM IN A CHECKBOX LIST
                                $values = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'dropdown_values', true)));
								$sf_fields = get_post_meta($original_post->ID, '_sf_field_'.get_the_ID(), true);
                                
                                if(count((array)$values) > 0) :
                            
                            ?>
                        
                        	<ul class="check-list">
                            
                            	<?php
								
									//// LOOPS ALL OUR VALUES
									foreach($values as $field) :
								
								?>
                                
                                	<li><input value="<?php echo $field->id ?>" type="checkbox" name="_sf_field_<?php echo $post->ID; ?>[]" id="in-<?php echo $post->post_name; ?>-<?php echo $field->id ?>" style="margin-right: 5px;"<?php if(is_array($sf_fields)) { if(in_array($field->id, $sf_fields)) { echo ' checked="checked"'; } } ?> /><?php echo $field->label; ?></li>
                                
                                <?php endforeach; ?>
                            
                            </ul>
                            
                            <?php else : ?>
                            
                            	<h2 style="margin: 10px 15px;"><?php _e('You don\'t have any values in this field.', 'btoa'); ?> <a href="<?php echo get_edit_post_link( get_the_ID() ) ?>"><?php _e('Add more here &rarr;', 'btoa'); ?></a></h2>
                            
                            <?php endif; ?>
                        
                        </div>
                        <!-- /.insider/ -->
                        
                    </div>
                    <!-- /.search-field/ -->
                    
                    <?php if($i != $total_posts) : ?><div class="bDivider"></div><?php endif; ?>
                
                <?php $i++; endwhile; wp_reset_postdata(); ?>
                
                
                
                
                
            
            	<?php
				
					//// LETS LOOP OUR DEPENDENTS
					while($dQ2->have_posts()) : $dQ2->the_post();
					
					
					$_parent = get_post(get_post_meta(get_the_ID(), 'dependent_parent', true));
					
					if(!$_parent_values = json_decode(htmlspecialchars_decode(get_post_meta($_parent->ID, 'dropdown_values', true)))) {
						
						$__parent_values = json_decode(htmlspecialchars_decode(get_post_meta($_parent->ID, 'dependent_values', true)));
						$_parent_values = array();
						foreach($__parent_values as $_dependent_parent_values) { foreach($_dependent_parent_values as $foo) { $_parent_values[] = $foo; } }
						
					}
					
					
				
				?>
                
                	<div class="search-field">	
                
                		<h3 onclick="if(jQuery(this).siblings('.insider').is(':visible')) { jQuery(this).siblings('.insider').hide(); } else { jQuery(this).siblings('.insider').show(); }"><?php the_title(); ?> - (Parent: <?php echo $_parent->post_title ?>)<span class="arrow"></span></h3>
                        
                        <div class="insider">
                            
							<?php
                            
                                //// LETS GO THROUGH ALL FIELDS AND DISPLAY THEM IN A CHECKBOX LIST
                                $values = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'dependent_values', true)));
								$sf_fields = get_post_meta($original_post->ID, '_sf_field_'.get_the_ID(), true);
								
                                
                                if(count((array)$values) > 0) :
                            
                            ?>
                        
                        	<ul class="check-list">
                            
                            	<?php
								
									//// LOOPS ALL OUR PARENT SECTIONS
									foreach($values as $key => $parent) :
								
								?>
                                
                                	<script type="text/javascript">
									
										jQuery(document).ready(function() {
											
											//// ONLY LETS USER SELECT THIS IN CASE PARENT IS CHECKED
											if(jQuery('#in-<?php echo $_parent->post_name ?>-<?php echo $key ?>').is(':checked')) {
												
												jQuery('#<?php echo $post->post_name ?>-parent-<?php echo $key; ?> input').removeAttr('disabled');
												
											}
											
											//// WHEN WE CHECK THE PARENT
											jQuery('#in-<?php echo $_parent->post_name ?>-<?php echo $key ?>').change(function() {
												
												if(jQuery('#in-<?php echo $_parent->post_name ?>-<?php echo $key ?>').is(':checked')) {
												
													jQuery('#<?php echo $post->post_name ?>-parent-<?php echo $key; ?> input').removeAttr('disabled');
													
												} else {
													
													jQuery('#<?php echo $post->post_name ?>-parent-<?php echo $key; ?> input').attr('disabled', 'disabled').removeAttr('checked');
													
												}	
												
											});
											
										});
									
									</script>
                                    
                                    <li class="parent_dropdown parent-<?php echo $key; ?>" id="<?php echo $post->post_name ?>-parent-<?php echo $key; ?>">
                                    
                                    	<?php
										
											//// GET PARENT DROPDOWN IN ORDER TO GET SECTION NAME
											foreach($_parent_values as $_single_parent) :
											
											//// DISPLAY SECTION NAME
											if($key == $_single_parent->id) :
										
										?>
                                        
                                        	<h3><?php echo $_single_parent->label; ?></h3>
                                            
                                            <ul>
                                            
                                            <?php
											
												//// NOW LET'S LOOP OUR FIELDS BASED ON THE PARENT
												if(count((array)$parent) > 0) :
												foreach($parent as $field) :
												
											
											?>
                                
												<script type="text/javascript">
                                                
                                                    jQuery(document).ready(function() {
                                                        
                                                        //// WHEN WE CHECK THE PARENT
                                                        jQuery('#in-<?php echo $_parent->post_name ?>-<?php echo $key ?>').change(function() {
                                                            
                                                            if(jQuery('#in-<?php echo $_parent->post_name ?>-<?php echo $key ?>').is(':checked')) {
                                                                
                                                            } else {
                                                                
																jQuery('.parent-<?php echo $field->id ?> input').attr('disabled', 'disabled').removeAttr('checked');
                                                                
                                                            }	
                                                            
                                                        });
                                                        
                                                    });
                                                
                                                </script>
                                            
                                            	<li><input value="<?php echo $field->id ?>" type="checkbox" disabled="disabled" name="_sf_field_<?php echo $post->ID; ?>[]" id="in-<?php echo $post->post_name ?>-<?php echo $field->id ?>" style="margin-right: 5px;"<?php if(is_array($sf_fields)) { if(in_array($field->id, $sf_fields)) { echo ' checked="checked"'; } } ?> /><?php echo $field->label; ?></li>
                                            
                                            <?php endforeach; else : ?>
                                            
                                            	<li>No values under this section. <a href="<?php echo get_edit_post_link( get_the_ID() ) ?>">Add more here &rarr;</a></li>
                                            
                                            <?php endif; ?>
                                            
                                            </ul>
                                        
                                        <?php endif; endforeach; // PARENT FOREACH ?>
                                    
                                    </li>
                                
                                
                                <?php endforeach; ?>
                            
                            </ul>
                            
                            <?php else : ?>
                            
                            	<h2 style="margin: 10px 15px;"><?php _e('You don\'t have any values in this field.', 'btoa'); ?> <a href="<?php echo get_edit_post_link( get_the_ID() ) ?>"><?php _e('Add more here &rarr;', 'btoa'); ?></a></h2>
                            
                            <?php endif; ?>
                        
                        </div>
                        <!-- /.insider/ -->
                        
                    </div>
                    <!-- /.search-field/ -->
                    
                    <?php if($i != $total_posts) : ?><div class="bDivider"></div><?php endif; ?>
                
                <?php $i++; endwhile; wp_reset_postdata(); ?>
            
            <?php endif; ?>
            
            <div class="clear"></div>
        
        </li>
        
        
        
        
        
        
        
        
        
    
    	<li>
        
        	<?php
			
				//// GETS ALL AVAILABLE MIN VALS FIRST AND THEN DEPENDENTS
				$args = array(
				
					'post_type' => 'search_field',
					'meta_query' => array(
					
						array(
						
							'key' => 'field_type',
							'value' => 'min_val',	
						
						)
					
					),
					'posts_per_page' => -1,
				
				);
				
				$dQ = new WP_Query($args);
				
				$i = 1;
				$total_posts = $dQ->found_posts;
				
				//// IF BOTH HAVE VALUES
				if(!$dQ->have_posts()) :
			
			?>
            
            	<h2><?php _e('You don\'t have any minimum value fields.', 'btoa'); ?></h2>
            
            <?php else : ?>
            
            	<?php
				
					//// LETS LOOP OUR DROPDOWNS
					while($dQ->have_posts()) : $dQ->the_post();
					
					$sf_field = get_post_meta($original_post->ID, '_sf_field_'.$post->ID, true);
				
				?>
                
                	<div class="search-field">	
                
                		<h3 onclick="if(jQuery(this).siblings('.insider').is(':visible')) { jQuery(this).siblings('.insider').hide(); } else { jQuery(this).siblings('.insider').show(); }"><?php the_title(); ?><span class="arrow"></span></h3>
                        
                        <div class="insider">
                            
							<input type="number" value="<?php echo $sf_field; ?>" id="_sf_field_<?php echo $post->ID; ?>" name="_sf_field_<?php echo $post->ID; ?>" class="" style="width: 100px;" />
                        
                        </div>
                        <!-- /.insider/ -->
                        
                    </div>
                    <!-- /.search-field/ -->
                    
                    <?php if($i != $total_posts) : ?><div class="bDivider"></div><?php endif; ?>
                
                <?php $i++; endwhile; wp_reset_postdata(); ?>
            
            <?php endif; ?>
            
            
        </li>
        
        
        
        
        
        
        
        
        
    
    	<li>
        
        	<?php
			
				//// GETS ALL AVAILABLE MAX VALS FIRST AND THEN DEPENDENTS
				$args = array(
				
					'post_type' => 'search_field',
					'meta_query' => array(
					
						array(
						
							'key' => 'field_type',
							'value' => 'max_val',	
						
						)
					
					),
					'posts_per_page' => -1,
				
				);
				
				$dQ = new WP_Query($args);
				
				$i = 1;
				$total_posts = $dQ->found_posts;
				
				//// IF BOTH HAVE VALUES
				if(!$dQ->have_posts()) :
			
			?>
            
            	<h2><?php _e('You don\'t have any maximum value fields.', 'btoa'); ?></h2>
            
            <?php else : ?>
            
            	<?php
				
					//// LETS LOOP OUR DROPDOWNS
					while($dQ->have_posts()) : $dQ->the_post();
					
					$sf_field = get_post_meta($original_post->ID, '_sf_field_'.$post->ID, true);
				
				?>
                
                	<div class="search-field">	
                
                		<h3 onclick="if(jQuery(this).siblings('.insider').is(':visible')) { jQuery(this).siblings('.insider').hide(); } else { jQuery(this).siblings('.insider').show(); }"><?php the_title(); ?><span class="arrow"></span></h3>
                        
                        <div class="insider">
                            
							<input type="number" value="<?php echo $sf_field; ?>" id="_sf_field_<?php echo $post->ID; ?>" name="_sf_field_<?php echo $post->ID; ?>" class="" style="width: 100px;" />
                        
                        </div>
                        <!-- /.insider/ -->
                        
                    </div>
                    <!-- /.search-field/ -->
                    
                    <?php if($i != $total_posts) : ?><div class="bDivider"></div><?php endif; ?>
                
                <?php $i++; endwhile; wp_reset_postdata(); ?>
            
            <?php endif; ?>
            
            
        </li>
        
        
        
        
        
        
        
        
        
    
    	<li>
        
        	<?php
			
				//// GETS ALL AVAILABLE RANGE FIRST
				$args = array(
				
					'post_type' => 'search_field',
					'meta_query' => array(
					
						array(
						
							'key' => 'field_type',
							'value' => 'range',	
						
						)
					
					),
					'posts_per_page' => -1,
				
				);
				
				$dQ = new WP_Query($args);
				
				$i = 1;
				$total_posts = $dQ->found_posts;
				
				//// IF BOTH HAVE VALUES
				if(!$dQ->have_posts()) :
			
			?>
            
            	<h2><?php _e('You don\'t have any range fields.', 'btoa'); ?></h2>
            
            <?php else : ?>
            
            	<?php
				
					//// LETS LOOP OUR DROPDOWNS
					while($dQ->have_posts()) : $dQ->the_post();
					
					$sf_field = get_post_meta($original_post->ID, '_sf_field_'.$post->ID, true);
				
				?>
                
                	<div class="search-field">	
                
                		<h3 onclick="if(jQuery(this).siblings('.insider').is(':visible')) { jQuery(this).siblings('.insider').hide(); } else { jQuery(this).siblings('.insider').show(); }"><?php the_title(); ?><span class="arrow"></span></h3>
                        
                        <div class="insider">
                        
                        	<?php
							
								$min = get_post_meta(get_the_ID(), 'range_minimum', true);
								$max = get_post_meta(get_the_ID(), 'range_maximum', true);
							
							?>
                        
                        	<script type="text/javascript">
							
								jQuery(document).ready(function() {
									
									//// MAKES SURE VALUE IS WITHIN RANGE
									jQuery('#_sf_field_<?php echo $post->ID; ?>').change(function() {
										
										//// IF ITS OUTSIDE RANGE
										if(jQuery(this).val() < <?php echo $min; ?> || jQuery(this).val() > <?php echo $max; ?>) {
											
											jQuery(this).val('');
											alert('Value is outside range. Range from <?php echo $min; ?> to <?php echo $max; ?>');
											
										}
										
									});
									
								});
							
							</script>
                            
							<input type="number" value="<?php echo $sf_field; ?>" id="_sf_field_<?php echo $post->ID; ?>" name="_sf_field_<?php echo $post->ID; ?>" class="" style="width: 100px;" />
                        
                        </div>
                        <!-- /.insider/ -->
                        
                    </div>
                    <!-- /.search-field/ -->
                    
                    <?php if($i != $total_posts) : ?><div class="bDivider"></div><?php endif; ?>
                
                <?php $i++; endwhile; wp_reset_postdata(); ?>
            
            <?php endif; ?>
            
            
        </li>
        
        
        
        
        
        
        
        
        
    
    	<li>
        
        	<?php
			
				//// GETS ALL AVAILABLE CHECK FIRST
				$args = array(
				
					'post_type' => 'search_field',
					'meta_query' => array(
					
						array(
						
							'key' => 'field_type',
							'value' => 'check',	
						
						)
					
					),
					'posts_per_page' => -1,
				
				);
				
				$dQ = new WP_Query($args);
				
				$i = 1;
				$total_posts = $dQ->found_posts;
				
				//// IF BOTH HAVE VALUES
				if(!$dQ->have_posts()) :
			
			?>
            
            	<h2><?php _e('You don\'t have any check fields.', 'btoa'); ?></h2>
            
            <?php else : ?>
            
            	<?php
				
					//// LETS LOOP OUR DROPDOWNS
					while($dQ->have_posts()) : $dQ->the_post();
					
					$sf_field = get_post_meta($original_post->ID, '_sf_field_'.$post->ID, true);
				
				?>
                
                	<div class="search-field">	
                
                		<h3 onclick="if(jQuery(this).siblings('.insider').is(':visible')) { jQuery(this).siblings('.insider').hide(); } else { jQuery(this).siblings('.insider').show(); }"><?php the_title(); ?><span class="arrow"></span></h3>
                        
                        <div class="insider" style="position: relative; height: 30px;">
                        
                        	<script type="text/javascript">
							
								jQuery(document).ready(function() {
									
									//// MAKES SURE VALUE IS WITHIN RANGE
									jQuery('#_sf_field_<?php echo $post->ID; ?>').iphoneStyle();
									
								});
							
							</script>
                            
							<input type="checkbox" id="_sf_field_<?php echo $post->ID; ?>" name="_sf_field_<?php echo $post->ID; ?>" <?php if($sf_field == 'on') { echo 'checked="checked"'; } ?> />
                        
                        </div>
                        <!-- /.insider/ -->
                        
                    </div>
                    <!-- /.search-field/ -->
                    
                    <?php if($i != $total_posts) : ?><div class="bDivider"></div><?php endif; ?>
                
                <?php $i++; endwhile; wp_reset_postdata(); ?>
            
            <?php endif; ?>
            
            
        </li>
        
        
        
        
        
        
        
        
        
        <li class="">
        
            <div class="one-fifth">
            
                <label><?php _e('Add Custom Fields', 'btoa'); ?></label>
    
                <div class="clear"></div>
                <div class="bDivider"></div>
                
                <div id="add_custom_field_form">
                            
                <div>
                
                    <p><label style="margin-bottom: 4px;"><?php _e('Label', 'btoa'); ?></label>
                    <input type="text" class="widefat value_label" value="" id="add_custom_field_form_label" /></p>
                
                    <p><label style="margin-bottom: 4px;"><?php _e('Value', 'btoa'); ?></label>
                    <input type="text" class="widefat value_value" value="" id="add_custom_field_form_value" /></p>
                    
                    <input type="button" class="button" value="<?php _e('Add Custom Field', 'btoa'); ?>" onclick="jQuery(this).insertSpotCustomField();" />
                
                </div>
                </div>
                
            </div>
            
            <div class="four-fifths last values" id="_sf_custom_fields_wrapper">
            
            	<input type="hidden" value="<?php echo htmlspecialchars($_sf_custom_fields); ?>" id="_sf_custom_fields" name="_sf_custom_fields" />
            
            	<script type="text/javascript">
				
					jQuery(document).ready(function() {
						
						jQuery('#_sf_custom_fields_wrapper ul').sortable({
							
							handle: jQuery('#_sf_custom_fields_wrapper li .head'),
							items: '> li',
							stop: function(event, ui) {
								
								/// RETURN FALSE FOR SHOWING THE CONTENT
								jQuery('#_sf_custom_fields_wrapper ul').spotCustomFieldRefresh();
								
							}
							
						});
						
					});
				
				</script>
            
            
            	<ul>
                
                	<?php
					
						//// LETS LOOP OUR CUSTOM FIELDS AND DISPLAY IT
						$the_custom_fields = json_decode($_sf_custom_fields);
						
						if(is_object($the_custom_fields)) :
						
						foreach($the_custom_fields as $custom_field) :
					
					?>
                    
                    	<li>
                        
                        	<div class="head" onclick="jQuery(this).openInsider();">
                            
                            	<span class="title"><?php echo esc_html($custom_field->label); ?></span>
                                
                                <span class="arrow"></span>
                                <!-- /.arrow/ -->
                            
                            </div>
                            
                            <div class="insider" style="display: none;">
                            
                            	<div class="one-half">
                                
                                	<label><?php _e('Label', 'btoa'); ?></label>
                                    <input type="text" class="widefat value_label" value="<?php echo esc_html($custom_field->label); ?>" onblur="jQuery(this).valueChangeLabel2(); jQuery('#_sf_custom_fields_wrapper ul').spotCustomFieldRefresh();" />
                      				<em style="margin: 10px 0 0; display: block;"><?php _e('Label of your Custom Field', 'btoa'); ?></em></div>
                      
                      				<div class="one-half last"><label><?php _e('Value', 'btoa'); ?></label>
                      				<input type="text" class="widefat value_value" value="<?php echo esc_html($custom_field->value); ?>" />
                      				<em style="margin: 10px 0 0; display: block;"><?php _e('Your value. This is displayed in the fron end. HTML accepted', 'btoa'); ?></em></div>
    				  				<div class="clear"></div><div class="bDivider"></div><input type="button" class="button" value="Remove Value" onclick="jQuery(this).removeCustomField();" /><div class="clear"></div>
                            
                            </div>
                            <!-- /.insider/ -->
                        
                        </li>
                    
                    <?php endforeach;endif; ?>
                
                </ul>
            
                
            </div>
            <!-- /dropdown-value/ -->
            
            
            
            <div class="clear"></div>
            <!-- /.clear/ -->
        
        </li>
		
		
		<li>
		
			<?php
			
				///// LETS LOOP ALL OUR CUSTOM SUBMISSION FIELDS
				$args = array(
				
					'post_type' => 'submission_field',
					'posts_per_page' => -1,
					'post_status' => 'publish',
				
				);
				
				$sfQ = new WP_Query($args);
				
				if($sfQ->have_posts()) :
				
					while($sfQ->have_posts()) :
					
					$sfQ->the_post();
			
			?>
			
					
					<?php if(get_post_meta(get_the_ID(), 'field_type', true) == 'text') : /// IF ITS A TEXT FIELD ?>
            
						<div class="one-fifth"><label for="_sf_submission_field_<?php the_ID(); ?>"><?php the_title(); ?></label></div>
						<div class="two-fifths"><input type="text" name="_sf_submission_field_<?php the_ID(); ?>" id="_sf_submission_field_<?php the_ID(); ?>" value="<?php echo get_post_meta($original_post->ID, '_sf_submission_field_'.get_the_ID(), true); ?>" class="widefat" style="margin-bottom: 5px;" maxlength="256" /></div>
						<div class="two-fifths description last"><?php echo $post->post_content; ?></div>
						
						<div class="clear"></div>
						<div class="bDivider"></div>
					
					<?php endif; ?>
			
					
					<?php if(get_post_meta(get_the_ID(), 'field_type', true) == 'dropdown') : /// IF ITS A TEXT FIELD ?>
            
						<div class="one-fifth"><label for="_sf_submission_field_<?php the_ID(); ?>"><?php the_title(); ?></label></div>
						<div class="two-fifths"><select name="_sf_submission_field_<?php the_ID(); ?>" id="_sf_submission_field_<?php the_ID(); ?>" class="widefat">
			
							<?php
							
								$sel_val = get_post_meta($original_post->ID, '_sf_submission_field_'.get_the_ID(), true);
							
								//// GETS ALL DROPDOWN VALUES
								$dropdown_values = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'dropdown_values', true)));
								
								if(is_object($dropdown_values)) :
								
									$i = 0;
									foreach($dropdown_values as $key => $value) :
							
							?>
							
								<option value="<?php echo $i; ?>"<?php if($i == $sel_val) { echo ' selected="selected"'; } ?>><?php echo $value->label ?></option>
							
							<?php $i++; endforeach; endif; ?>
						
						</select></div>
						<div class="two-fifths description last"><?php echo $post->post_content; ?></div>
						
						<div class="clear"></div>
						<div class="bDivider"></div>
					
					<?php endif; ?>
			
					
					<?php if(get_post_meta(get_the_ID(), 'field_type', true) == 'file') : /// IF ITS A TEXT FIELD ?>
					
						<script type="text/javascript">
						
							jQuery(document).ready(function() {
								
								//AJAX upload
								jQuery('#_sf_submission_field_upload_<?php the_ID(); ?>').each(function(){
									
									var the_button = jQuery(this);
									var image_input = the_button.parent().siblings('.filename').children('input');
									var image_id = jQuery(this).attr('id');
									//alert('a');
									
									new AjaxUpload(image_id, {
										
										  action: ajaxurl,
										  name: image_id,
										  
										  // Additional data
										  data: {
											action: 'ddpanel_ajax_upload',
											data: image_id,
											post_id: <?php echo $original_post->ID ?>
										  },
										  
										  autoSubmit: true,
										  responseType: false,
										  onChange: function(file, extension){},
										  onSubmit: function(file, extension) {
											  
											  the_button.attr('disabled', 'disabled').val('Uploading').addClass('ddpanel-upload-button-disabled');
															  
										  },
										  
										  onComplete: function(file, response) {
											  
											  var theImage = jQuery.parseJSON(response);
												
											  the_button.removeAttr('disabled').removeClass('ddpanel-upload-button-disabled');
											  
											  if(response.search("Error") > -1){
												  
												  alert("There was an error uploading:\n"+response);
												  
											  }
											  
											  else{		
																  	
													
													var filename = theImage.url.split('/');
													var the_filename = filename[(filename.length-1)];
																	
														  
										  image_input.val(theImage.id);
										  image_input.parent().find('span').text(the_filename);
												  the_button.val('<?php _e('Upload File', 'btoa'); ?>')
												  
													  
											  }
											  
										  }
									});
								});
								
							});
						
						</script>
            
						<div class="one-fifth">
						
							<label for="_sf_submission_field_<?php the_ID(); ?>"><?php the_title(); ?></label>
							
							<div class="bDivider"></div>
							<!-- .bDivider -->
							
							<div class="add_submission_field_file">
                            
								<p><label style="margin-bottom: 4px;">Title</label>
								<input type="text" class="widefat value_label" value=""></p>
							
								<p><label style="margin-bottom: 4px;">Description</label>
								<input type="text" class="widefat value_desc" value=""></p>
								
								<p class="filename"><span></span><input type="hidden" class="value_id" value="" /></p>
								
								<p><input type="button" class="button" value="<?php _e('Upload File', 'btoa'); ?>" id="_sf_submission_field_upload_<?php the_ID(); ?>"></p>
								
								<input type="button" class="button" value="<?php _e('Add to File List', 'btoa'); ?>" onclick="jQuery(this).insertSpotSubmissionFile('_sf_custom_submission_field_list_<?php the_ID(); ?>', '_sf_submission_field_<?php the_ID(); ?>');">
							
								<div class="clear"></div>
								
							</div>
							<!-- .add_submission_field_file -->
						
						</div>
						
						<div class="four-fifths last _sf_submission_fields_file_list values" id="_sf_custom_submission_field_list_<?php the_ID(); ?>">
						
							<input type="hidden" name="_sf_submission_field_<?php the_ID(); ?>" id="_sf_submission_field_<?php the_ID(); ?>" value="<?php echo htmlspecialchars(get_post_meta($original_post->ID, '_sf_submission_field_'.get_the_ID(), true)); ?>" class="widefat" style="margin-bottom: 5px;" />
            
								<script type="text/javascript">
								
									jQuery(document).ready(function() {
										
										jQuery('#_sf_custom_submission_field_list_<?php the_ID(); ?> ul').sortable({
											
											handle: jQuery('#_sf_custom_submission_field_list_<?php the_ID(); ?> li .head'),
											items: '> li',
											stop: function(event, ui) {
												
												/// RETURN FALSE FOR SHOWING THE CONTENT
												jQuery('#_sf_custom_submission_field_list_<?php the_ID(); ?> ul').spotSubmissionFieldFileRefresh('_sf_submission_field_<?php the_ID(); ?>');
												
											}
											
										});
										
									});
								
								</script>
							
							
								<ul>
								
									<?php
									
										//// LETS LOOP OUR CUSTOM FIELDS AND DISPLAY IT
										$files = json_decode(htmlspecialchars_decode(get_post_meta($original_post->ID, '_sf_submission_field_'.get_the_ID(), true)));
										
										if(is_object($files)) :
										
										foreach($files as $file) :
									
									?>
									
										<li>
										
											<div class="head" onclick="jQuery(this).openInsider();">
											
												<span class="title"><?php echo esc_html($file->title); ?></span>
												
												<span class="arrow"></span>
												<!-- /.arrow/ -->
											
											</div>
											
											<div class="insider" style="display: none;">
											
												<p><label><?php _e('File', 'btoa'); ?></label>
												<a href="<?php echo get_edit_post_link($file->ID) ?>" target="_blank"><?php echo get_the_title($file->ID) ?></a></p>
												
												<div class="clear"></div><div class="bDivider"></div>
											
												<div class="one-half">
												
													<label><?php _e('Title', 'btoa'); ?></label>
													<input type="text" class="widefat value_label" value="<?php echo esc_html($file->title); ?>" onblur="jQuery(this).valueChangeLabel2(); jQuery('#_sf_custom_submission_field_list_<?php the_ID(); ?> ul').spotSubmissionFieldFileRefresh('_sf_submission_field_<?php the_ID(); ?>');" />
													<input type="hidden" class="value_ID" value="<?php echo $file->ID ?>" />
													<input type="hidden" class="value_size" value="<?php echo $file->size ?>" />
													<em style="margin: 10px 0 0; display: block;"><?php _e('Title of the file', 'btoa'); ?></em></div>
									  
													<div class="one-half last"><label><?php _e('Description', 'btoa'); ?></label>
													<input type="text" class="widefat value_desc" value="<?php echo esc_html($file->desc); ?>" onblur="jQuery('#_sf_custom_submission_field_list_<?php the_ID(); ?> ul').spotSubmissionFieldFileRefresh('_sf_submission_field_<?php the_ID(); ?>');" />
													<em style="margin: 10px 0 0; display: block;"><?php _e('File Description', 'btoa'); ?></em></div>
													<div class="clear"></div><div class="bDivider"></div><input type="button" class="button" value="Remove File" onclick="jQuery(this).removeSubmissionFieldFile('_sf_custom_submission_field_list_<?php the_ID(); ?> ul', '_sf_submission_field_<?php the_ID(); ?>');" /><div class="clear"></div>
											
											</div>
											<!-- /.insider/ -->
										
										</li>
									
									<?php endforeach; endif; ?>
									
										<li class="clone hidden" style="display: none !important">
										
											<div class="head" onclick="jQuery(this).openInsider();">
											
												<span class="title"></span>
												
												<span class="arrow"></span>
												<!-- /.arrow/ -->
											
											</div>
											
											<div class="insider" style="display: none;">
											
												<p><label><?php _e('File', 'btoa'); ?></label>
												<a href="" target="_blank"></a></p>
												
												<div class="clear"></div><div class="bDivider"></div>
											
												<div class="one-half">
												
													<label><?php _e('Title', 'btoa'); ?></label>
													<input type="text" class="widefat value_label" value="" onblur="jQuery(this).valueChangeLabel2(); jQuery('#_sf_custom_submission_field_list_<?php the_ID(); ?> ul').spotSubmissionFieldFileRefresh('_sf_submission_field_<?php the_ID(); ?>');" />
													<input type="hidden" class="value_ID" value=">" />
													<input type="hidden" class="value_size" value="" />
													<em style="margin: 10px 0 0; display: block;"><?php _e('Title of the file', 'btoa'); ?></em></div>
									  
													<div class="one-half last"><label><?php _e('Description', 'btoa'); ?></label>
													<input type="text" class="widefat value_desc" value="" onblur="jQuery('#_sf_custom_submission_field_list_<?php the_ID(); ?> ul').spotSubmissionFieldFileRefresh('_sf_submission_field_<?php the_ID(); ?>');" />
													<em style="margin: 10px 0 0; display: block;"><?php _e('File Description', 'btoa'); ?></em></div>
													<div class="clear"></div><div class="bDivider"></div><input type="button" class="button" value="Remove File" onclick="jQuery(this).removeSubmissionFieldFile('_sf_custom_submission_field_list_<?php the_ID(); ?> ul', '_sf_submission_field_<?php the_ID(); ?>');" /><div class="clear"></div>
											
											</div>
											<!-- /.insider/ -->
										
										</li>
								
								</ul>
							
						</div>
						
						<div class="clear"></div>
						<div class="bDivider"></div>
					
					<?php endif; ?>
			
			
				<?php endwhile; wp_reset_postdata(); ?>	
			
			
			<?php else : ?>
			
				<h2 style="margin: 15px;">You do not have any custom submission fields.</h2>
			
			<?php endif; ?>
		
		</li>
		
		
        
        <li>
		
			<script type="text/javascript">
			
				jQuery(document).ready(function() {
				
				jQuery('#header_color').focus(function() {
					
					jQuery(this).iris({
						
						hide: false
						
					});
					
				});
				
				jQuery('#page_title').iphoneStyle();
		
							jQuery('#header_bg_upload').each(function(){
								
								var the_button = jQuery(this);
								var image_input = jQuery('#header_bg');
								var image_id = jQuery(this).attr('id');
								//alert('a');
								
								new AjaxUpload(image_id, {
				
								  action: ajaxurl,
								  name: image_id,
								  
								  // Additional data
								  data: {
									action: 'ddpanel_ajax_upload',
									data: image_id,
									post_id: <?php echo $post->ID ?>
								  },
								  
								  autoSubmit: true,
								  responseType: false,
								  onChange: function(file, extension){},
								  onSubmit: function(file, extension) {
									  
									  //// ALLOWS IMAGES ONLY
									  if(extension == 'png' || extension == 'gif' || extension == 'jpg' || extension == 'jpeg') {
									  
										the_button.attr('disabled', 'disabled').val('Uploading').addClass('ddpanel-upload-button-disabled');	
										  
									  } else {
										  
										  return false;
										  alert('You can only upload PNG, JPG or GIF images.');
										  
									  }
													  
								  },
								  
								  onComplete: function(file, response) {
									  
									  var theImage = jQuery.parseJSON(response);
										
									  the_button.removeAttr('disabled').removeClass('ddpanel-upload-button-disabled');
									  
									  if(response.search("Error") > -1){
										  
										  alert("There was an error uploading:\n"+response);
										  
									  }
									  
									  else{		
														  
										  image_input.val(theImage.url);
										  the_button.val('Upload Image')
										  
											  
									  }
									  
								  }
								});
							});
					
				});
			
			</script>
            
            <div class="one-fifth"><label for="header_bg">Header Background:</label></div>
            <div class="two-fifths"><input type="text" name="header_bg" id="header_bg" value="<?php echo $header_bg ?>" class="widefat" style="margin-bottom: 5px;" /><input type="button" class="button" id="header_bg_upload" value="Upload Image" /></div>
            <div class="two-fifths description last">Header Background. Leave blank to show default.</div>
    
    		<div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="fancy_slogan">Fancy Header Slogan:</label></div>
            <div class="two-fifths"><input type="text" name="fancy_slogan" id="fancy_slogan" value="<?php echo $fancy_slogan ?>" class="widefat" style="margin-bottom: 5px;" /></div>
            <div class="two-fifths description last">Page slogan, displayed with your title.</div>
    
    		<div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="header_title">Header Title:</label></div>
            <div class="two-fifths"><input type="text" name="header_title" id="header_title" value="<?php echo $header_title ?>" class="widefat" style="margin-bottom: 5px;" /></div>
            <div class="two-fifths description last">Page title displayed in your custom header.</div>
    
    		<div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="header_color">Color:</label></div>
            <div class="two-fifths"><input type="text" name="header_color" id="header_color" value="<?php echo $header_color ?>" class="widefat" style="margin-bottom: 5px; width: 100px;" maxlength="7" /></div>
            <div class="two-fifths description last">Color of your custom header.</div>
            
            <div class="clear"></div>
            
        </li>
    
    </ul>
    <!-- /.tabbed/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->

</div>