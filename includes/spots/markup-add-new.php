<?php

	////// INSERTS A POST AS AN AUTO-DRAFT SO WE CAN GET A POST ID
	$current_user = wp_get_current_user();
	$spot_id = wp_insert_post(array( 'post_title' => 'Auto Draft', 'post_type' => 'spot', 'post_status' => 'auto-draft', 'post_author' => $current_user->ID ));
	
	$steps = new SF_Tooltip();
	
	$steps->add_step('content', __('Welcome!', 'btoa'), __('This is your submissions admin page. Here you can manage your submissions and details and view your submissions page views.', 'btoa'));
	
	$submission_fields_actions = _sf_get_submission_field_actions();

?>
        
        <?php
		
			global $current_user;
        
            ////////////////////////////////////////////////////
            //// CUSTOM HEADER
            ////////////////////////////////////////////////////
			if(get_post_meta(get_the_ID(), 'header_bg', true) != '' && (get_post_meta(get_the_ID(), 'header_title', true) != '') || get_post_meta(get_the_ID(), 'fancy_slogan', true) != '') {
				
				/// INCLUDES CUSTOM HEADER
				get_template_part('includes/page/custom-header');
				
			}
		
		?>
            
        <?php if(is_wp_error($_error)) : ?>
        
			<div id="message" class="error">
            
            	<div class="wrapper row"><div class="large-12 columns"><i class="icon-cancel-circle"></i><span><?php echo $_error->get_error_message(); ?></span></div></div>
            
            </div>
            <!-- /#message/ -->
            
            <?php else : ?>
        
            <div id="message" class="success" style="display: none;">
                
                <div class="wrapper row"><div class="large-12 columns"><i class="icon-ok-circle"></i><span></span></div></div>
            
            </div>
		
		<?php endif; ?>
        
        
        
        <div id="content">
        
        	<div class="wrapper row">
            
            	<div id="main-content" class="sidebar-right large-12 columns">
	
                     <div class="page-header responsive-negative-margin">
                    
                        <div class="left"><h2><?php _e('Submit New', 'btoa'); ?> <?php echo ddp('spot_name'); ?></h2></div>
                        <!-- /.left/ -->
                        
                        <div class="right" id="page-header-right">
                        
                            <a href="<?php echo home_url(); ?>" class="logout button-secondary" onclick="jQuery(this)._sf_save_spot(<?php echo $spot_id ?>); return false;" id="_sf_save_draft_top"><?php _e('Save Draft', 'btoa'); ?></a>
                            <?php if(ddp('pbl_publish') == 'on') { $publish = __('Publish', 'btoa'); } else { $publish = __('Submit for review', 'btoa'); } ?>
                            <a href="<?php echo home_url(); ?>" class="logout button-primary" onclick="jQuery('#_sf_spot').submit(); return false;"><?php echo $publish; ?></a>
                            
                        
                        </div>
                        <!-- /.right/ -->
                        
                        <div class="clear"></div>
                        <!-- /.clear/ -->
                        
                    </div>
                    <!-- /.page-header/ -->
                    
                    
                    <?php
					
						///// CART
						include(locate_template('includes/spots/markup-cart.php'));
					
					?>
                    
                    
                    <script type="text/javascript">
					
						jQuery(document).ready(function() {
							
							jQuery('#_sf_spot')._sf_spot_submit();
							
						});
					
					</script>
                    
                    <form id="_sf_spot" action="<?php echo home_url() ?>" method="post">

                        <div class="row">
                        
                            <div class="large-8 columns">
                            
                                <p class="rel">
                                
                                	<input type="text" placeholder="<?php _e('Enter your title', 'btoa'); ?>" class="spot_title" name="_sf_title" id="_sf_spot_title" />
                                    <small class="error tooltip left" style="top: 8px;"><?php _e('Type in your title.', 'btoa'); ?></small>
                                    
                                    <?php $steps->add_step('_sf_spot_title', __('Title', 'btoa'), __('Start by entering yout submission title. This is the main title of your submission used throughout the website. Enter your business name or location address.', 'btoa')); //// ADDS THE TITLE TO ORU STEP ?>
                                    
                                </p>
								
									<?php
									
										do_action('_sf_submission_after_title', $spot_id);
										sf_create_public_submission_action('after_title', $submission_fields_actions, $spot_id);
										
									?>
                            
                                <p class="rel">
                                
                                	<input type="text" placeholder="<?php _e('Slogan', 'btoa'); ?>" name="_sf_slogan" id="_sf_slogan" />
                                    <small class="error tooltip left" style="top: 8px;"><?php _e('Type in your title.', 'btoa'); ?></small>
                                    
                                    <?php $steps->add_step('_sf_slogan', __('Slogan', 'btoa'), __('Your slogan is a short title used to promote and describe your submission thoughout the website. It works like a secondary title. Choose something witty and catchy!', 'btoa')); //// ADDS THE TITLE TO ORU STEP ?>
                                    
                                </p>
								
									<?php
									
										do_action('_sf_submission_after_slogan', $spot_id);
										sf_create_public_submission_action('after_slogan', $submission_fields_actions, $spot_id);
										
									?>
                                
                                <p>
                                
                                	<?php wp_editor('', '_sf_spot_content', array(
									
										'media_buttons' => false,
										'textarea_rows' => '30',
										'editor_css' => '',
									
									)); ?>
                                    
                                    <?php $steps->add_step('_sf_spot_content', __('Content', 'btoa'), __('Here you can write more about your submission. Include HTML tags or use the WYSIWYG editor to style your content. It is a good idea to be as descriptive as possible. The more detailed your information is, the less questions and doubts about your submission your users will have.', 'btoa'), 'wp-_sf_spot_content-wrap'); //// ADDS THE TITLE TO ORU STEP ?>
                                
                                </p>
								
									<?php
									
										do_action('_sf_submission_after_content', $spot_id);
										sf_create_public_submission_action('after_content', $submission_fields_actions, $spot_id);
										
									?>
                                
                                <div class="padding" style="height: 5px;"></div>
                                <!-- /.padding/ -->
                                
								
								
									<?php
									
										//////////////////////////////
										////// ONLY IF IT'S ENABLED
										//////////////////////////////
										if(ddp('pbl_images_check') == 'on') :  ?>
                                
                                <div class="_sf_box" id="_sf_gallery">
                                	<div class="head">
                                    	<div class="left"><?php _e('Images', 'btoa'); ?></div>
                                        <!-- /.left/ -->
											<?php
													/// IF IT'S ENABLED IN THE CART
													if(ddp('price_images') != '' && ddp('price_images') != '0' && get_post_meta($spot_id, 'price_images', true) != 'on') :
												 ?>
												 <div class="right _sf_us_addtocart" id="price_images">
													<?php $is_in_cart = get_post_meta($spot_id, 'price_images_cart', true); ?>
													<span<?php if($is_in_cart == 'on') : ?> style="display: none;"<?php endif; ?> onclick="jQuery(this)._sf_us_add_to_cart('price_images', <?php echo $spot_id ?>);">
													<?php echo sprintf2(__('Upload up to %num images for just %price', 'btoa'), array('num' => ddp('price_images_num'),'price' => format_price(ddp('price_images')))); ?>
													</span>
													<em style="display: <?php if($is_in_cart == 'on') : ?>inline<?php else : ?>none<?php endif; ?>;"><?php _e('Please checkout before updating this.', 'btoa'); ?></em>
												&nbsp;</div>
											<?php endif; /// ENDS IF IT'S ENABLED IN THE CART ?>
                                        <!-- /.right/ -->
                                        <div class="clear"></div>
                                        <!-- /.cclear/ -->
                                    
                                    </div>
                                    <!-- /.head/ -->
                                    
                                    <div class="inside">
                                    	<div class="left"><em><?php echo sprintf2(__('Upload up to %num image(s).', 'btoa'), array('num' => ddp('pbl_images'))); ?></em></div>
                                        <!-- /.left/ -->
                                        <div class="right">
											<span class="button-secondary" id="_sf_gallery_upload_button" style="cursor: pointer; position: relative;">
												<?php _e('Upload Images', 'btoa'); ?>
											   <input type="file" value="Upload Image" class="button-secondary" name="_sf_gallery_upload[]" id="_sf_gallery_upload" multiple style="display: block; opacity: 0; position: absolute; left: 0; top: 0; width: 100%; height: 100%; cursor: pointer !important;" />
												<?php $steps->add_step('_sf_gallery_upload', __('Upload new images', 'btoa'), __('Click the upload images button to start uploading your images. You can upload multiple images at the same time. By uploading more than one image you automatically create an image gallery within your submission page. Maximum size per image is 5mb.', 'btoa'), '_sf_gallery'); //// ADDS THE TITLE TO ORU STEP ?>    
											</span>
                                    	</div>
                                        <!-- /.right/ -->
                                        <div class="clear"></div><span class="upload-bar-file" style="display: none;"></span><div class="upload-bar" style="display: none;"><span></span></div>
                                        
                                        <div class="clear"></div>
                                        <!-- /.clear/ -->
                                        
                                        <input type="hidden" name="_sf_gallery" id="_sf_gallery_attachments" value="" />
                                        
                                        <script type="text/javascript">
										
											jQuery(document).ready(function() {
												
												//// SORTABLE GALLERY
												jQuery('#_sf_gallery_images')._sf_sortable_gallery();
												
												//// UPLOAD IMAGE
												jQuery('#_sf_gallery_upload')._sf_upload_gallery(<?php echo $spot_id; ?>);
												
											});
										
										</script>
                                        
<!-- DAHERO #1667540 STRT -->
	                                    <small class="error tooltip left" style="top: 54px;"><?php _e('Upload an image.', 'btoa'); ?></small>
                                        <ul id="_sf_gallery_images" class="required-file"></ul>
<!-- DAHERO #1667540 STOP -->

                                        <!-- /#_sf_gallery_images/ -->
                                    		<?php $steps->add_step('_sf_gallery_images', __('Image Gallery', 'btoa'), __('After uploading your images you can click and drag your uploaded images to re-arrange them. Your first image will be used as a placeholder throughout the website and the following images are automatically added to your gallery image.', 'btoa')); //// ADDS THE TITLE TO ORU STEP ?> 
                                        
                                        <div class="clear"></div>
                                        <!-- /.clear/ -->
                                    
                                    </div>
                                    <!-- /.inside/ -->
                                
                                </div>
                                <!-- /._sf_box/ -->
								
								<?php endif; ?>
								
									<?php
									
										do_action('_sf_submission_after_gallery', $spot_id);
										sf_create_public_submission_action('after_gallery', $submission_fields_actions, $spot_id);
										
									?>
								
								
									<?php
									
										//////////////////////////////
										////// ONLY IF IT'S ENABLED
										//////////////////////////////
										if(ddp('pbl_featured') == 'on') :
									
									?>
								
									<div class="_sf_box" id="_sf_featured_selection">
									
										<div class="head">
										
											<div class="left"><?php _e('Featured Submission', 'btoa'); ?></div>
											<!-- .left -->
											
											<div class="clear"></div>
											<!-- .clear -->
										
										</div>
										<!-- .head -->
										
										<div class="inside">
										
										
                                            
                                            <?php
													
													/// IF IT'S ENABLED IN THE CART
													if(ddp('price_featured') != '' && ddp('price_featured') != '0' && get_post_meta($spot_id, 'price_featured', true) != 'on') :
													
												 ?>
												 
                                            <span class="_sf_us_addtocart_over" onclick="jQuery(this)._sf_us_add_to_cart_2('price_featured', <?php echo $spot_id ?>);" id="price_featured">
											
													<?php $is_in_cart = get_post_meta($spot_id, 'price_featured_cart', true); ?>
											
													<span<?php if($is_in_cart == 'on') : ?> style="display: none;"<?php endif; ?>>
													
														<?php echo sprintf2(__('Set your submission as featured for just %price, and appear on top of searches!', 'btoa'), array('price' => format_price(ddp('price_featured')))); ?>
                                            
													</span>
													
													<em style="display: <?php if($is_in_cart == 'on') : ?>block<?php else : ?>none<?php endif; ?>;"><?php _e('Please checkout before updating this.', 'btoa'); ?></em>
											
												&nbsp;</span>
											
                                            <?php endif; /// ENDS IF IT'S ENABLED IN THE CART ?>
											
											
										
											<div class="left" style="width: 50%;">
											
												<p style="margin-bottom: 0;"><em><?php _e('Featured submissions have a lot more visibility than others. Enable a permanent image pin on your submission plus appear on top of listings!', 'btoa'); ?></em></p>
												
											</div>
											<!-- .left -->
											
											<div class="right" style="width: 50%;">
                                            
                                            <script type="text/javascript">
											
													jQuery(document).ready(function() {
														
														jQuery('#pbl_featured')._sf_switch();
														
													});
											
												 </script>
                                            
                                            <div class="_sf_switch" id="pbl_featured" style="float: right;">
                                            
                                            	<input type="checkbox" name="_sf_featured" id="pbl_featured_check" class="_sf_switch_input" value="off" checked="checked" />
                                            
                                            	<span class="_sf_switch_handle"></span>
                                                <!-- /._sf_switch_handle/ -->
                                            
                                            	<span class="_sf_switch_on"></span>
                                                <!-- /._sf_switch_handle/ -->
                                                
                                            </div>
                                            <!-- /._sf_switch/ -->
											
												<div class="clear"></div>
												<!-- .clear -->
											
											</div>
											
											<div class="clear"></div>
											<!-- .clear -->
										
										</div>
										<!-- .inside -->
									
									</div>
									<!-- ._sf_box -->
									
									<?php $steps->add_step('_sf_featured_selection', __('Featured Submission', 'btoa'), __('By setting your submission as featured you automatically get a permanent pin on our map with your main image and you also appear on top of our listings results, generating more visitors and getting more visibility to your submission.', 'btoa')); //// ADDS THE TITLE TO ORU STEP ?> 
									
									<?php endif; //// ENDS IF FEATURED IS ENABLED ?>
								
									<?php
									
										do_action('_sf_submission_after_featured', $spot_id);
										sf_create_public_submission_action('after_featured', $submission_fields_actions, $spot_id);
										
									?>
									
                            
                            </div>
                            <!-- /.large-8/ -->
                            
                            <div class="large-4 columns">
                            
                            	<?php
								
									//// GETS CATEGORIES
									$cats = get_terms('spot_cats', array(
										
										'hide_empty' => 0
										
									));
									
									///// IF ITS A CHECKBOX LETS DO THE HIERARCHIC
									if(ddp('pbl_cats') == 'on') {
										
										$cats = get_terms('spot_cats', array(
											
											'hide_empty' => 0,
											'parent' => 0,
											
										));
									
									}
									
									
									if($cats) : ?>
                                
                                <div class="_sf_box" id="_sf_category">
                                
                                	<div class="head">
                                    
                                    	<div class="left"><?php if(ddp('pbl_cats') != 'on') : ?><?php _e('Category', 'btoa'); ?><?php else : ?><?php _e('Categories', 'btoa'); ?><?php endif; ?></div>
                                        <!-- /.left/ -->
                                        
                                        <div class="clear"></div>
                                        <!-- /.cclear/ -->
                                    
                                    </div>
                                    <!-- /.head/ -->
                                    
                                    <div class="inside rel">
                                    
                                    	<small class="error tooltip right" style="top: 14px;"><?php _e('Select a category.', 'btoa'); ?></small>
                                    
                                    	<script type="text/javascript">
										
											jQuery(document).ready(function() {
												
												<?php if(ddp('pbl_cats') != 'on') { ?>
												
												jQuery('#_sf_categories_box .checkbox-label').each(function() { jQuery(this).click(function() { var theName = jQuery(this).siblings('div').children('input').attr('name'); jQuery('input[name="'+theName+'"]').removeAttr('checked').parent().removeClass('radio-replace-checked'); if(jQuery(this).siblings('div').children('input').is(':checked')) { jQuery(this).siblings('div').removeClass('radio-replace-checked').children('input').removeAttr('checked'); } else { jQuery(this).siblings('div').addClass('radio-replace-checked').children('input').attr('checked', 'checked'); } }); });
												
												<?php } else { ?>
												
												jQuery('#_sf_categories_box .checkbox-label').each(function() { jQuery(this).click(function() { if(jQuery(this).siblings('div').children('input').is(':checked')) { jQuery(this).siblings('div').removeClass('checkbox-replace-checked').children('input').removeAttr('checked'); } else { jQuery(this).siblings('div').addClass('checkbox-replace-checked').children('input').attr('checked', 'checked'); } }); });
												
												<?php } ?>
												
												//// TAKES CARE OF SEARCH FIELD SELECTIONS
												jQuery('#_sf_categories_box')._sf_field_categories();
												
											});
											
											jQuery(window).load(function() {
												
												<?php if(ddp('pbl_cats') == 'on') : ?>jQuery('#_sf_categories_box input.load-subcategories')._sf_field_categories_load_subcats();<?php endif; ?>
												
											});
										
										</script>
                                    
                                    	<ul id="_sf_categories_box">
                                        
                                        	<?php
											
												//// IF WE CAN SELECT MULTIPLE
												$input_type = 'checkbox';
												if(ddp('pbl_cats') != 'on') { $input_type = 'radio'; }
												
												foreach($cats as $_cat) :
												
													$class = '';
												
													//// CHECKS IF IT HAS CHILDREN
													if(ddp('pbl_cats') == 'on') {
														
														if($terms = get_terms('spot_cats', array('hide_empty' => false, 'parent' => $_cat->term_id))) {
															
															$class = ' class="load-subcategories"';
															
														}
														
													}
											
											?>
                                        
                                        		<li><input type="<?php echo $input_type; ?>" name="_sf_category[]" id="_sf_category_<?php echo $_cat->term_id ?>" value="<?php echo $_cat->term_id ?>"<?php echo $class; ?> /><span class="checkbox-label"><?php echo $_cat->name; ?></span></li>
                                            
                                            <?php endforeach; ?>
                                        
                                        </ul>
                                        <!-- /#_sf_categories_box/ -->
                                    		<?php $steps->add_step('_sf_categories_box', __('Categories', 'btoa'), __('Select the appropriate category in which your submission best fits in. Categories are used to organise submissions, so make sure you choose the right one to maximise your page views.', 'btoa'), '_sf_category'); //// ADDS A STEP ?> 
                                        
                                        <div class="clear"></div>
                                        <!-- /.clear/ -->
                                    
                                    </div>
                                    <!-- /.inside/ -->
                                
                                </div>
                                <!-- /._sf_box/ -->
                                
                                <?php endif; //// ENDS IF WE HAVE CATEGORIES ?>
								
									<?php
									
										do_action('_sf_submission_after_categories', $spot_id);
										sf_create_public_submission_action('after_categories', $submission_fields_actions, $spot_id);
										
									?>
                                
                                
                                <?php if(ddp('pbl_enable_tags') == 'on') : ?>
                                
                                <div class="_sf_box" id="_sf_tags">
                                
                                	<div class="head">
                                    
                                    	<div class="left"><?php _e('Tags', 'btoa'); ?></div>
                                        <!-- /.left/ -->
                                            
											<?php
													
													/// IF IT'S ENABLED IN THE CART
													if(ddp('price_tags') != '' && ddp('price_tags') != '0' && get_post_meta($spot_id, 'price_tags', true) != 'on') :
													
												 ?>
												 
												 <div class="right _sf_us_addtocart" id="price_tags">
											
													<?php $is_in_cart = get_post_meta($spot_id, 'price_tags_cart', true); ?>
											
													<span<?php if($is_in_cart == 'on') : ?> style="display: none;"<?php endif; ?> onclick="jQuery(this)._sf_us_add_to_cart('price_tags', <?php echo $spot_id ?>);">
													
													<?php echo sprintf2(__('Add up to %num for just %price', 'btoa'), array('num' => ddp('price_tags_num'),'price' => format_price(ddp('price_tags')))); ?>
											
													</span>
													
													<em style="display: <?php if($is_in_cart == 'on') : ?>inline-block<?php else : ?>none<?php endif; ?>;"><?php _e('Please checkout before updating this.', 'btoa'); ?></em>
											
												&nbsp;</div>
											
											<?php endif; /// ENDS IF IT'S ENABLED IN THE CART ?>
                                        <!-- /.right/ -->
                                        
                                        <div class="clear"></div>
                                        <!-- /.cclear/ -->
                                    
                                    </div>
                                    <!-- /.head/ -->
                                    
                                    <script type="text/javascript">
									
										jQuery(document).ready(function() {
											
											//// WHEN ADDING TAGS
											jQuery('#_sf_tags_add')._sf_adding_tags_input();
											
										});
									
									</script>

                                    <div class="inside">
                                    	<em><?php echo sprintf2(__('Add up to %num tags.', 'btoa'), array('num' => ddp('pbl_tags_no'))); ?></em>
                                        <input type="hidden" value="" name="_sf_tags" id="_sf_tags_input" />
<!-- DAHERO #1667540 STRT -->
	                                    <small class="error tooltip right" style="top: 74px;"><?php _e('Enter plate number.', 'btoa'); ?></small>
                                        <ul id="_sf_tags_list" class="required-file"></ul>
<!-- DAHERO #1667540 STOP -->
                                        <!-- /#_sf_tags_list/ -->
                                        
                                        <p style="margin-bottom: 0;">
                                        
                                        	<input type="text" name="_sf_tags_add" id="_sf_tags_add" placeholder="<?php _e('Tag Name', 'btoa'); ?>" class="small-input" />
                                            <input type="button" onclick="jQuery('#_sf_tags_list')._sf_add_tag(jQuery('#_sf_tags_add').val());" name="_sf_tags_add_submit" id="_sf_tags_add_submit" value="<?php _e('Add Tag', 'btoa'); ?>" class="button-secondary button-small" style="margin-top: -3px; display: block;" />
                                            
                                    		<?php $steps->add_step('_sf_tags_add', __('Tags', 'btoa'), __('Assign relevant tags to your submission. Doing so helps you get more visibility throughout the website such as more views on search listings and appear on related submissions.', 'btoa'), '_sf_tags'); //// ADDS A STEP ?> 
                                        
                                        </p>
                                    
                                    </div>
                                    <!-- /.inside/ -->
                                    
                                </div>
                                <!-- /#_sf_tags/ -->
                                
                                <?php endif; ?>
								
									<?php
									
										do_action('_sf_submission_after_tags', $spot_id);
										sf_create_public_submission_action('after_tags', $submission_fields_actions, $spot_id);
										
									?>
                                
                                
                                <div class="_sf_box" id="_sf_location">
                                
                                	<div class="head">
                                    
                                    	<div class="left"><?php _e('Location', 'btoa'); ?></div>
                                        <!-- /.left/ -->
                                        
                                        <div class="clear"></div>
                                        <!-- /.cclear/ -->
                                    
                                    </div>
                                    
                                    <div class="inside">
                                    
                                    	<p class="rel"><input type="text" name="_sf_address" id="_sf_address" placeholder="<?php _e('Enter address', 'btoa'); ?>" class="small-input" />
                                        <input type="button" name="_sf_address_get" id="_sf_address_get" value="<?php _e('Get pinpoint', 'btoa'); ?>" class="button-secondary button-small" style="margin-top: -3px; display: block;" onclick="jQuery(this)._sf_location_get_pinpoint();" />
                                    	<small class="error tooltip right"><?php _e('Please type in the address.', 'btoa'); ?></small></p>
                                            
                                    		<?php $steps->add_step('_sf_address', __('Location', 'btoa'), __('Enter your submission address and click "Get Pinpoint" to automatically get your address geolocation. If you are unable to pinpoint your address, type in your city and click and drag the pin o t he map to pinpoint where you are located.', 'btoa'), '_sf_location'); //// ADDS A STEP ?> 
                                        
                                        <div class="one-half">
                                    
                                            <p class="rel"><label for="_sf_latitude"><?php _e('Latitude', 'btoa'); ?></label>
                                            <input type="text" name="_sf_latitude" id="_sf_latitude" class="small-input" />
                                            <small class="error tooltip right" style="top: 18px;"><?php _e('Please type in a valid latitude.', 'btoa'); ?></small></p>
                                        
                                        </div>
                                        <!-- /.one-half/ -->
                                        
                                        <div class="one-half last">
                                    
                                            <p class="rel"><label for="_sf_longitude"><?php _e('Longitude', 'btoa'); ?></label>
                                            <input type="text" name="_sf_longitude" id="_sf_longitude" class="small-input" />
                                            <small class="error tooltip left" style="top: 18px;"><?php _e('Please type in a valid longitude.', 'btoa'); ?></small></p>
                                        
                                        </div>
                                        <!-- /.one-half/ -->
                                        
                                        <div class="clear"></div>
                                        <!-- /.clear/ -->
                                        
                                        <script type="text/javascript">
										
											jQuery(document).ready(function() {

												//// WHEN GETTING PINPOINT
												
												//// INITIATES MAP
												jQuery('#_sf_location_map').gmap3({
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

<!-- DAHERO #1667542 STRT -->
<?php if (ddp('map_geolocation') == 'on') : /* IF USER HAS ENABLED GEOLOCATION */ ?>

												if (navigator.geolocation) {
													navigator.geolocation.getCurrentPosition(function(position) {
														initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

														var theLat = jQuery('#_sf_latitude');
														var theLng = jQuery('#_sf_longitude');

														theLat.val(initialLocation.lat());
														theLng.val(initialLocation.lng());
									
														//// SAVES IT IN COOKIES
														jQuery.cookie('user_latitude', initialLocation.lat(), { path: '/' });
														jQuery.cookie('user_longitude', initialLocation.lng(), { path: '/' });
									
														//// ADDS THE MARKER AND LOCATES MAP
														jQuery('#_sf_location_map').gmap3({
															map: {
																options: {
																	zoom: 14,
																	center: initialLocation
																}
															},
															marker: {
																values: [{ latLng:[initialLocation.lat(), initialLocation.lng()] }],
																options: {
																	draggable: true
																},
																events: {
																	mouseup: function(marker, event, context) {
																		//// GETS MARKER LATITUDE AND LONGITUDE
																		var thePos = marker.getPosition();
																		var lat = thePos.lat();
																		var lng = thePos.lng();
																		theLat.val(lat);
																		theLng.val(lng);
																	}
																}
															}
														});
													});
												}
		
<?php endif; ?>
<!-- DAHERO #1667542 STOP -->
											});
										
										</script>
                                        
                                        <div id="_sf_location_map"></div>
                                        <!-- /#location-map/ -->
                                    
                                    	<?php if(ddp('pbl_custom_pin') == 'on') : ?>
                                        
                                        <p style="margin-bottom: 0;" class="custom-pin-field">
                                        
                                            <label for="_sf_custom_pin"><?php _e('Custom Pin', 'btoa'); ?></label>
                                            <input type="text" name="_sf_custom_pin" id="_sf_custom_pin" placeholder="<?php _e('Pin Image URL', 'btoa'); ?>" class="small-input" />
                                            
                                            <?php
													
													/// IF IT'S ENABLED IN THE CART
													if(ddp('price_custom_pin') != '' && ddp('price_custom_pin') != '0' && get_post_meta($spot_id, 'price_custom_pin', true) != 'on') :
													
												 ?>
												 
                                            <span class="_sf_us_addtocart_over" onclick="jQuery(this)._sf_us_add_to_cart_2('price_custom_pin', <?php echo $spot_id ?>);" id="price_custom_pin">
											
													<?php $is_in_cart = get_post_meta($spot_id, 'price_custom_pin_cart', true); ?>
											
													<span<?php if($is_in_cart == 'on') : ?> style="display: none;"<?php endif; ?>>
													
													<?php echo sprintf2(__('Set your own custom pin for just %price', 'btoa'), array('price' => format_price(ddp('price_custom_pin')))); ?>
                                            
													</span>
													
													<em style="display: <?php if($is_in_cart == 'on') : ?>block<?php else : ?>none<?php endif; ?>;"><?php _e('Please checkout before updating this.', 'btoa'); ?></em>
											
												&nbsp;</span>
											
                                            <?php endif; /// ENDS IF IT'S ENABLED IN THE CART ?>
                                        
                                        </p>
										
										<?php endif; ?>
                                    
                                    </div>
                                    
                                </div>
                                <!-- /#_sf_location/ -->
								
									<?php
									
										do_action('_sf_submission_after_map', $spot_id);
										sf_create_public_submission_action('after_map', $submission_fields_actions, $spot_id);
										
									?>
								
                            
                            </div>
                            <!-- /.large-8/ -->
                        
                        </div>
                        <!-- /.row/ -->
                        
                        <div class="divider-top" style="margin-bottom: 40px;"></div>
                        
                        
                        
                        <div class="row">
                            
                           	<?php if(ddp('pbl_custom_fields') == 'on') : //// IF USERS CAN AD CUSTOM FIELDS ?>
                        
                        		<div class="large-8 columns">
								
									<?php
									
										do_action('_sf_submission_before_custom_fields', $spot_id);
										sf_create_public_submission_action('before_custom_fields', $submission_fields_actions, $spot_id);
										
									?>
                                
                                	<div id="_sf_custom_fields" class="_sf_box">
                                    
                                    	<div class="head">
                                        
                                        	<div class="left"><?php _e('Custom Fields', 'btoa'); ?></div>
                                            
                                            <div class="clear"></div>
                                            <!-- /.clear/ -->
                                        
                                        </div>
                                        <!-- /.head/ -->
                                        
                                        <div class="inside">
                                            
                                            <?php
													
													/// IF IT'S ENABLED IN THE CART
													if(ddp('price_custom_fields') != '' && ddp('price_custom_fields') != '0' && get_post_meta($spot_id, 'price_custom_fields', true) != 'on') :
													
												 ?>
												 
                                            <span class="_sf_us_addtocart_over" onclick="jQuery(this)._sf_us_add_to_cart_2('price_custom_fields', <?php echo $spot_id ?>);" id="price_custom_fields">
											
													<?php $is_in_cart = get_post_meta($spot_id, 'price_custom_fields_cart', true); ?>
											
													<span<?php if($is_in_cart == 'on') : ?> style="display: none;"<?php endif; ?>>
													
														<?php echo sprintf2(__('Assign unlimited custom fields for just %price', 'btoa'), array('price' => format_price(ddp('price_custom_fields')))); ?>
                                            
													</span>
													
													<em style="display: <?php if($is_in_cart == 'on') : ?>block<?php else : ?>none<?php endif; ?>;"><?php _e('Please checkout before updating this.', 'btoa'); ?></em>
											
												&nbsp;</span>
											
                                            <?php endif; /// ENDS IF IT'S ENABLED IN THE CART ?>
                                        
                                        	<?php if(ddp('pbl_custom_fields_desc') != '') : ?><p><em><?php echo ddp('pbl_custom_fields_desc'); ?></em></p><?php endif; ?>
                                        
                                        	<div class="one-fourth">
                                            
                                            	<script type="text/javascript">
												
													jQuery(document).ready(function() {
														
														jQuery('#_sf_custom_field_add')._sf_custom_field_add_all();
														
														jQuery('#_sf_custom_fields_list')._sf_custom_field_refresh_sortable();														
													});
												
												</script>
                                            
                                            	<p><strong><?php _e('Add New:', 'btoa'); ?></strong></p>
                                                
                                                <p style="position: relative;"><label><?php _e('Title:', 'btoa'); ?></label>
                                                <input type="text" id="_sf_custom_field_label" class="small-input" />
                                                <small class="error tooltip left" style="top: 19px;"><?php _e('Title must not be empty', 'btoa'); ?></small></p>
                                                
                                                <p style="position: relative;"><label><?php _e('Value:', 'btoa'); ?></label>
                                                <input type="text" id="_sf_custom_field_value" class="small-input" />
                                                <small class="error tooltip left" style="top: 19px;"><?php _e('Value must not be empty', 'btoa'); ?></small></p>
                                                
                                                <p style=" margin-bottom: 0;"><input type="button" id="_sf_custom_field_add" value="<?php _e('Add Custom Field', 'btoa'); ?>" class="button-secondary button-small" style="margin-top: -3px; display: block;" onclick="jQuery(this)._sf_add_custom_field();" /></p>
                                            
                                            </div>
                                            <!-- /.one-fourth/ -->
                                            
                                            <?php $steps->add_step('_sf_custom_field_label', __('Custom Fields', 'btoa'), __('Custom fields are a way of displaying key information about your submission. Add options such as opening hours or key features. This helps users to find important information easier and faster.', 'btoa'), '_sf_custom_fields'); //// ADDS A STEP ?> 
                                            
                                            <div class="three-fourths last">
                                            
                                            	<input type="hidden" name="_sf_custom_fields" id="_sf_custom_fields_input" value="" />
                                            
                                            	<ul id="_sf_custom_fields_list">
                                                
                                                	
                                                
                                                </ul>
                                                <!-- /#_sf_custom_fields_list/ -->
                                            
                                            </div>
                                            <!-- /.three-fourths/ -->
                                        
                                        	<div class="clear"></div>
                                            <!-- /.clear/ -->
                                        
                                        </div>
                                        <!-- /.inside/ -->
                                    
                                    </div>
                                    <!-- /#_sf_custom_fields/ -->
								
										<?php
										
											do_action('_sf_submission_after_custom_fields', $spot_id);
											sf_create_public_submission_action('after_custom_fields', $submission_fields_actions, $spot_id);
											
										?>
                            
                            	</div>
                            
                            	<div class="large-4 columns" id="_sf_custom_search_fields_wrapper">
                            
                            <?php else : ?>
                            
                            	<div class="large-8 columns" id="_sf_custom_search_fields_wrapper">
                                
                            <?php endif; ?>
                            
                            <?php $steps->add_step('_sf_custom_search_fields_wrapper', __('Search Fields', 'btoa'), __('Assign your search fields in order to get your submission to show up on listings. The more accurate the information provided, the more page views and conversions you get.', 'btoa')); //// ADDS A STEP ?> 
                            
                            	<script type="text/javascript">
								
									jQuery(document).ready(function() {
										
										jQuery('._sf_box_accordion:first .inside').show();
										
										jQuery('._sf_box_accordion .head').click(function() {
											
											if(!jQuery(this).parent().find('.inside').is(':visible')) {
												
												jQuery('._sf_box_accordion .inside').slideUp(200);
												jQuery(this).parent().find('.inside').slideDown(200, function() {
													
													jQuery(this).css({ overflow: 'visible' });
													
												});
												
											}
											
										});
										
									});
								
								</script>
								
											<?php
											
												do_action('_sf_submission_before_search_fields', $spot_id);
												sf_create_public_submission_action('before_search_fields', $submission_fields_actions, $spot_id);
												
											?>
                            	
                                <?php
								
									//// GETS SEARCH FIELDS
									$args = array(
									
										'post_type' => 'search_field',
										'posts_per_page' => -1,
										'meta_query' => array(
										
											array(
											
												'key' => 'public_field',
												'value' => 'on',
											
											)
										
										),
									
									);
									
									$searchFields = new WP_Query($args);
								
									//// LETS GO THROUGH OUR SEARCH FIELDS
									while($searchFields->have_posts()) : $searchFields->the_post();
									
									//// GETS THE CATEGORIES TO BE SHOWN
									$show_cats = get_post_meta(get_the_ID(), 'public_field_category', true);
									$show_cats_class = '';
									
									//// GOES THROUGH THEM AND ADDS IT AS A CLASS
									if(!is_array($show_cats)) { $show_cats = array('all'); }
									foreach($show_cats as $_show_cat) { $show_cats_class .= $_show_cat.'_'; }
									$show_cats_class = trim($show_cats_class, '_');
								
								?>
                                
                                	<div class="_sf_box _sf_box_accordion _sf_box_field_<?php the_ID() ?> <?php echo $show_cats_class; ?>" id="_sf_field_<?php the_ID() ?>" style="display: none;">
                                    
                                    	<div class="head">
                                    
                                            <div class="left"><?php the_title(); ?></div>
                                            <!-- /.left/ -->
                                            
                                            <div class="clear"></div>
                                            <!-- /.cclear/ -->
                                        
                                        </div>
                                        <!-- /.head/ -->
                                        
                                        <div class="inside" style="display: none;">
                                            
                                            <?php
													
													/// IF IT'S ENABLED IN THE CART
													if(get_post_meta(get_the_ID(), 'public_field_price', true) != '' && get_post_meta(get_the_ID(), 'public_field_price', true) != '0' && get_post_meta(get_the_ID(), 'public_field_price', true) != 'on') :
													
												 ?>
												 
                                            <span class="_sf_us_addtocart_over" onclick="jQuery(this)._sf_us_add_to_cart_2('<?php echo '_sf_'.get_the_ID() ?>', <?php echo $spot_id ?>);" id="<?php echo '_sf_'.get_the_ID() ?>">
											
													<?php $is_in_cart = get_post_meta($spot_id, '_sf_'.get_the_ID().'_cart', true); ?>
											
													<span<?php if($is_in_cart == 'on') : ?> style="display: none;"<?php endif; ?>>
													
														<?php echo get_post_meta(get_the_ID(), 'public_field_price_description', true); ?>
                                            
													</span>
													
													<em style="display: <?php if($is_in_cart == 'on') : ?>block<?php else : ?>none<?php endif; ?>;"><?php _e('Please checkout before updating this.', 'btoa'); ?></em>
											
												&nbsp;</span>
											
                                            <?php endif; /// ENDS IF IT'S ENABLED IN THE CART ?>
                                        
                                        	<?php if(get_post_meta(get_the_ID(), 'public_field_description', true) != '') : ?><p><em><?php echo htmlspecialchars_decode(get_post_meta(get_the_ID(), 'public_field_description', true)); ?></em></p><?php endif; ?>
                                            
                                            
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A DROPDOWN
												if(get_post_meta(get_the_ID(), 'field_type', true) == 'dropdown') :
											
											?>
                                                
                                                <p style=" margin-bottom: 0;" class="rel">
                                                
                                                <?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') : ?>
                                                <small class="error tooltip right"><?php echo sprintf2(__('Please select a %field.', 'btoa'), array('field' => get_the_title())); ?></small>
                                                <?php endif; ?>
                                                
                                                <?php if(get_post_meta(get_the_ID(), 'public_field_selection', true) == 'multiple') : ?><select name="_sf_field_<?php the_ID(); ?>[]" id="_sf_field_<?php the_ID(); ?>_select" multiple="multiple" class="<?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') { echo 'required-dropdown'; } ?>"><?php else : ?>
                                                <select name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_select"><?php endif; ?>
                                                
                                                    <?php
                                                    
                                                        //// LOOPS EACH DROPDOWN IN THIS FIELD
                                                        $dropdowns = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'dropdown_values', true)));
                                                        
                                                        if(is_object($dropdowns)) :
                                                            
                                                        foreach($dropdowns as $_dropdown) :
                                                    
                                                    ?>
                                                    
                                                        <option value="<?php echo $_dropdown->id ?>"><?php echo $_dropdown->label ?></option>
                                                    
                                                    <?php endforeach; endif; ?>
                                                
                                                </select></p>
                                            
                                            
                                            
                                            
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A DEPENDENT
												elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'dependent') :
												
												//// GETS THE PARENT FIELD
												$parent_field = get_post(get_post_meta(get_the_ID(), 'dependent_parent', true));
											
											?>
                                            
                                            	<script type="text/javascript">
												
													jQuery(document).ready(function() {
														
														/// LOADS FIELDS BASED ON PARENT
														jQuery('#_sf_field_<?php the_ID() ?>_fields')._sf_load_initial_dependents(jQuery('#_sf_field_<?php echo $parent_field->ID; ?>_select'), <?php echo $parent_field->ID; ?>, <?php the_ID() ?>);
														
														//// WHEN THE PARENT CHANGES WE CHANGE THIS
														jQuery('#_sf_field_<?php echo $parent_field->ID; ?>_select').change(function() {
															
															jQuery('#_sf_field_<?php the_ID() ?>_fields')._sf_load_initial_dependents(jQuery('#_sf_field_<?php echo $parent_field->ID; ?>_select'), <?php echo $parent_field->ID; ?>, <?php the_ID() ?>);
															
														});
														
													});
												
												</script>
                                            
                                            	<p class="message"><?php echo sprintf2(__('Please select your %parent_field first.', 'btoa'), array('parent_field' => $parent_field->post_title)); ?></p>
                                                
                                                <p class="fields rel<?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') { echo ' required-dependent'; } ?>" style="display: none;" id="_sf_field_<?php the_ID() ?>_fields">
                                                    
                                                    <?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') : ?>
                                                    <small class="error tooltip right"><?php echo sprintf2(__('Please select a %field.', 'btoa'), array('field' => get_the_title())); ?></small>
                                                    <?php endif; ?>
                                                    
                                                    <?php if(get_post_meta(get_the_ID(), 'public_field_selection', true) == 'multiple') : ?><select name="_sf_field_<?php the_ID(); ?>[]" id="_sf_field_<?php the_ID(); ?>_select" multiple="multiple"><?php else : ?>
                                                    <select name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_select"><?php endif; ?>
                                                    
                                                    
                                                    
                                                    </select>
                                                
                                                </p>
                                            
                                            
                                            
                                            
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A RANGE FIELD
												elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'range') :
											
											?>
                                            
                                            <input type="hidden" name="_sf_field_<?php the_id(); ?>" id="_sf_field_<?php the_id(); ?>_field" value="<?php echo get_post_meta(get_the_ID(), 'range_minimum', true) ?>" />
                                            
                                            <script type="text/javascript">
                                            
                                                jQuery(document).ready(function() {
                                                
                                                    jQuery('#_sf_field_range_<?php echo the_ID(); ?>').slider({
														
														min: <?php echo get_post_meta(get_the_ID(), 'range_minimum', true); ?>,
														max: <?php echo get_post_meta(get_the_ID(), 'range_maximum', true); ?>,
														<?php if(get_post_meta(get_the_ID(), 'range_increments', true) != '' && is_numeric(get_post_meta(get_the_ID(), 'range_increments', true))) : ?>step: <?php echo get_post_meta(get_the_ID(), 'range_increments', true) ?>,<?php endif; ?>
														slide: function(event, ui) {
															
															var theValue = ui.value;
															
															<?php if(get_post_meta(get_the_ID(), 'range_price', true) == 'on') ://// IF ITS A PRICE FIELD ?>
																var theValue = ui.value.formatMoney();
															<?php endif; ?>
															
															//// CHANGES LABEL
															var theLabel = jQuery('#_sf_field_range_<?php the_ID(); ?>_label');
															theLabel.find('span').text(theValue);
															
															jQuery('#_sf_field_<?php the_id(); ?>_field').val(ui.value);
															
															<?php if(get_post_meta(get_the_ID(), 'range_input', true) == 'on') : ?>
															
																jQuery('#_sf_field_<?php the_id(); ?>_input').val(theValue);
															
															<?php endif; ?>
															
														},
                                                        
                                                    });
															
															<?php if(get_post_meta(get_the_ID(), 'range_input', true) == 'on') : ?>
															
																jQuery('#_sf_field_<?php the_id(); ?>_input').blur(function() {
																	
																	var input = jQuery(this);
																	var value = jQuery(this).val().replace(',', '').replace(',', '').replace(',', '');
																	
																	console.log(value);
																	
																	//// CHECKS IF IT'S WITHIN OUR RANGE
																	if(value < <?php echo get_post_meta(get_the_ID(), 'range_minimum', true); ?> || value > <?php echo get_post_meta(get_the_ID(), 'range_maximum', true); ?>) {
																		
																		console.log('NOT POSSIBLE');
																		
																		 jQuery('#_sf_field_range_<?php echo the_ID(); ?>').slider({ value: <?php echo get_post_meta(get_the_ID(), 'range_minimum', true); ?> });
																		 input.val(<?php echo get_post_meta(get_the_ID(), 'range_minimum', true); ?>);
																		
																		alert('Please provide a whole number between <?php echo get_post_meta(get_the_ID(), 'range_minimum', true); ?> and <?php echo get_post_meta(get_the_ID(), 'range_maximum', true); ?>.');
																		
																	} else {
																		
																		console.log(value);
																		
																		//// UPDATE SLIDER
																		 jQuery('#_sf_field_range_<?php echo the_ID(); ?>').slider({ value: value });
																		 
																		 jQuery('#_sf_field_<?php the_id(); ?>_field').val(value);
																		
																	}
																	
																});
															
															<?php endif; ?>
                                                    
                                                });
                                            
                                            </script>
                                            
                                            <div class="the-field-range" id="_sf_field_range_<?php the_ID(); ?>_wrapper"><div class="field-range" id="_sf_field_range_<?php the_ID(); ?>"></div><small class="error tooltip right"></small></div>
											
												<?php if(get_post_meta(get_the_ID(), 'range_input', true) != 'on') : ?>
													
														<?php
														
														$the_value = get_post_meta(get_the_ID(), 'range_minimum', true);
														
															//// IF FORMAT TO PRICE
															if(get_post_meta(get_the_ID(), 'range_price', true) == 'on') {
																
																$label_val = str_replace('%', '<span>'.number_format($the_value).'</span>', get_post_meta(get_the_ID(), 'range_label', true));
																
															} else {
																
																$label_val = str_replace('%', '<span>'.$the_value.'</span>', get_post_meta(get_the_ID(), 'range_label', true));
																
															}
														
														?>
													
													<span id="_sf_field_range_<?php the_ID(); ?>_label" class="_sf_label_range"><?php echo $label_val; ?></span>
												
												<?php else : ?>
													
														<?php
														
															//// IF FORMAT TO PRICE
															if(get_post_meta(get_the_ID(), 'range_price', true) == 'on') {
																
																$the_value = get_post_meta(get_the_ID(), 'range_minimum', true);
																$label_val = number_format($the_value); ?>
																
																<script type="text/javascript">
																
																	jQuery(document).ready(function() {
																		
																		jQuery('#_sf_field_<?php the_id(); ?>_input').keyup(function() {
																		
																			//// FIRST OFF LET'S GET THE ABSOLUTE VALUE HE IS GETTING
																			var theValue = numeral().unformat(jQuery(this).val());
																			if(theValue == 0) { theValue = ''; }
																			
																			//// LETS FORMAT HIS PRICE
																			if(!isNaN(theValue)) { theValue = theValue.formatMoney(); }
																			else { theValue = ''; }
																			
																			jQuery(this).val(theValue);
																			
																		});
																		
																	});
																
																</script>
																
																<?php
																
															} else {
																
																$label_val = $the_value;
																
															}
														
														?>
												
														<input type="text" name="_sf_field_<?php the_id(); ?>_input" id="_sf_field_<?php the_id(); ?>_input" value="<?php echo $label_val ?>" class="_sf_range_input" />
												
												<?php endif; ?>
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A MAX FIELD
												elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'max_val') :
											
											?>
                                            
                                            <p style="margin-bottom: 0;" class="rel">
                                                
                                                <?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') : ?>
                                                <small class="error tooltip right"><?php echo sprintf2(__('Please type in a valid %field value.', 'btoa'), array('field' => get_the_title())); ?></small>
                                                <?php endif; ?>
                                                
                                                <input type="number" value="" name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_field" class="small-input<?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') { echo ' required-num'; } ?>" />
                                                
                                            </p>
                                            
                                            
                                            
                                            
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A MIN FIELD
												elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'min_val') :
											
											?>
                                            
                                            
                                            
                                            <p style="margin-bottom: 0;" class="rel">
                                                
                                                <?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') : ?>
                                                <small class="error tooltip right"><?php echo sprintf2(__('Please type in a valid %field value.', 'btoa'), array('field' => get_the_title())); ?></small>
                                                <?php endif; ?>
                                                
                                                <input type="number" value="" name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_field" class="small-input<?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') { echo ' required-num'; } ?>" />
                                                
                                            </p>
                                            
                                            
                                            
                                            
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A CHECK FIELD
												elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'check') :
											
											?>
                                            
                                            <script type="text/javascript">
											
												jQuery(document).ready(function() {
													
													jQuery('#_sf_switch_<?php the_ID() ?>_switch')._sf_switch();
													
												});
											
											</script>
                                            
                                            <div class="_sf_switch" id="_sf_switch_<?php the_ID() ?>_switch">
                                            
                                            	<input type="checkbox" name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_field" class="_sf_switch_input" value="off" checked="checked" />
                                            
                                            	<span class="_sf_switch_handle"></span>
                                                <!-- /._sf_switch_handle/ -->
                                            
                                            	<span class="_sf_switch_on"></span>
                                                <!-- /._sf_switch_handle/ -->
                                                
                                            </div>
                                            <!-- /._sf_switch/ -->
                                                
                                                
                                            <?php endif; ?>
                                            
                                            <div class="clear"></div>
                                        
                                        </div>
                                        <!-- /.inside/ -->
                                    
                                    </div>
                                    <!-- /.sf_box/ -->
                                
                                <?php endwhile; wp_reset_postdata(); ?>
                                
                                <?php if(ddp('pbl_contact_form') == 'on' && ddp('pbl_force_contact') != 'on') : ?>
                                
                                	<div class="_sf_box _sf_box_accordion _sf_box_accordion_none all" id="_sf_field_contact_form">
                                    
                                    	<div class="head">
                                    
                                            <div class="left"><?php _e('Contact Form', 'btoa'); ?></div>
                                            <!-- /.left/ -->
                                            
                                            <div class="clear"></div>
                                            <!-- /.cclear/ -->
                                        
                                        </div>
                                        <!-- /.head/ -->
                                        
                                        <div class="inside" style="display: none;">
                                            
                                            <?php
													
													/// IF IT'S ENABLED IN THE CART
													if(ddp('price_contact_form') != '' && ddp('price_contact_form') != '0' && get_post_meta($spot_id, 'price_contact_form', true) != 'on') :
													
												 ?>
												 
                                            <span class="_sf_us_addtocart_over" onclick="jQuery(this)._sf_us_add_to_cart_2('price_contact_form', <?php echo $spot_id ?>);" id="price_contact_form">
											
													<?php $is_in_cart = get_post_meta($spot_id, 'price_contact_form_cart', true); ?>
											
													<span<?php if($is_in_cart == 'on') : ?> style="display: none;"<?php endif; ?>>
													
														<?php echo sprintf2(__('Enable a contact form on your submission for just %price', 'btoa'), array('price' => format_price(ddp('price_contact_form')))); ?>
                                            
													</span>
													
													<em style="display: <?php if($is_in_cart == 'on') : ?>block<?php else : ?>none<?php endif; ?>;"><?php _e('Please checkout before updating this.', 'btoa'); ?></em>
											
												&nbsp;</span>
											
                                            <?php endif; /// ENDS IF IT'S ENABLED IN THE CART ?>
                                        
                                        	<p><em><?php _e('Display a contact form in your submission. emails are sent directly to your email address.', 'btoa'); ?></em></p>
                                            
                                            <script type="text/javascript">
											
												jQuery(document).ready(function() {
													
													jQuery('#_sf_contact_form_switch')._sf_switch();
													
												});
											
											</script>
                                            
                                            <div class="_sf_switch" id="_sf_contact_form_switch">
                                            
                                            	<input type="checkbox" name="_sf_contact_form" id="_sf_contact_form_field" class="_sf_switch_input" value="off" checked="checked" />
                                                
                                                <?php $steps->add_step('_sf_contact_form_switch', __('Contact Form', 'btoa'), __('By enabling a contact form on your page, users will find a contact form when viewing your submission. The contact form sends out the email directly to your inbox.', 'btoa'), '_sf_field_contact_form'); //// ADDS A STEP ?> 
                                            
                                            	<span class="_sf_switch_handle"></span>
                                                <!-- /._sf_switch_handle/ -->
                                            
                                            	<span class="_sf_switch_on"></span>
                                                <!-- /._sf_switch_handle/ -->
                                                
                                            </div>
                                            <!-- /._sf_switch/ -->
											
												<div class="clear"></div>
												<!-- .clear -->
                                        
                                        </div>
                                        <!-- /.inside/ -->
                                        
                                    </div>
                                    <!-- /._sf_box/ -->
                                    
                                <?php endif; ?>
								
									<?php
									
										do_action('_sf_submission_after_search_fields', $spot_id);
										sf_create_public_submission_action('after_search_fields', $submission_fields_actions, $spot_id);
										
									?>
                                
                            
                            </div>
                            
                            <?php if(ddp('pbl_custom_fields') != 'on') : ?>
                            
                            	<div class="large-4 columns">
                            
                            		<div class="left"><a href="<?php echo home_url(); ?>" class="logout button-secondary" onclick="jQuery(this)._sf_save_spot(<?php echo $spot_id ?>); return false;"><?php _e('Save Draft', 'btoa'); ?></a>
                            		<a href="<?php echo home_url(); ?>" class="logout button-primary" onclick="jQuery('#_sf_spot').submit(); return false;"><?php echo $publish; ?></a></div>
                                
                                </div>
                                
                            <?php endif; ?>
                        
                        </div>
                        <!-- /.row/ -->
                        
                        <?php if(ddp('pbl_custom_fields') == 'on') : ?>
                        
	                        <div class="divider-top" style="margin-bottom: 30px; margin-top: 35px;"></div>
                            
                            <div class="right"><a href="<?php echo home_url(); ?>" class="logout button-secondary" onclick="jQuery(this)._sf_save_spot(<?php echo $spot_id ?>); return false;"><?php _e('Save Draft', 'btoa'); ?></a>
                            		<a href="<?php echo home_url(); ?>" class="logout button-primary" onclick="jQuery('#_sf_spot').submit(); return false;"><?php echo $publish; ?></a></div></div>
                            
                            <div class="clear"></div>
                            <!-- /.clear/ -->
                        
                        <?php endif; ?>
                        
                        <input type="hidden" value="<?php echo $spot_id; ?>" name="_sf_post" id="_sf_spot_id" />
                        
                    </form>
                    <!-- /#_sf_spot/ -->
                    
                            <?php $steps->add_step('_sf_save_draft_top', __('Save or Submit!', 'btoa'), __('Finally, choose whether you want to save your submission to finish it off later, or go ahead and submit it straight away.', 'btoa'), 'page-header-right'); //// ADDS A STEP ?> 
                    
                    <?php
					
						//// LETS SHOW UP OUR STEPS AS TOOLTIPS
						$steps->generate_steps();
					
						?>
                    
                </div>
                <!-- /#main-content/ -->
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->