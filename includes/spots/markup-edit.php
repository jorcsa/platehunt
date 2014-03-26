<?php

	////// INSERTS A POST AS AN AUTO-DRAFT SO WE CAN GET A POST ID
	$current_user = wp_get_current_user();
	$spot_id = $_GET['id'];
	$spot = get_post($spot_id);
	
	///// IF WE HAVE A TOKEN WE NEED TO PROCESS OUR CHECKOUT
	if(isset($_GET['token']) && isset($_GET['PayerID'])) { if($_GET['token'] != '' && $_GET['PayerID'] != '') {
		
		$_error = _sf_checkout_function_process($spot_id, $_GET['token'], $_GET['PayerID']);
		
	} }
	
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
        
            <div id="message" class="success" <?php if(!is_array($_error)) : ?>style="display: none;"<?php endif; ?>>
                
                <div class="wrapper row"><div class="large-12 columns"><i class="icon-ok-circle"></i><span><?php echo $_error['message']; ?></span></div></div>
            
            </div>
		
		<?php endif; ?>
        
        
        
        <div id="content">
        
        	<div class="wrapper row">
            
            	<div id="main-content" class="sidebar-right large-12 columns">
	
                     <div class="page-header">
                    
                        <div class="left"><h2><?php _e('Edit', 'btoa'); ?> <?php echo ddp('spot_name'); ?> - <?php echo $spot->post_title ?></h2></div>
                        <!-- /.left/ -->
                        
                        <div class="right" id="page-header-right">
                        
                            <?php if($spot->post_status != 'publish' && $spot->post_status != 'pending') : ?><a href="<?php echo home_url(); ?>" class="logout button-secondary" onclick="jQuery(this)._sf_save_spot(<?php echo $spot_id ?>); return false;"><?php _e('Save Draft', 'btoa'); ?></a><?php endif; ?>
                            <?php if($spot->post_status == 'publish') { $publish = __('Finish Edit', 'btoa'); } elseif(ddp('pbl_publish') == 'on') { $publish = __('Publish', 'btoa'); } else { $publish = __('Submit for review', 'btoa'); } ?>
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
                                
                                	<input type="text" placeholder="<?php _e('Enter your title', 'btoa'); ?>" class="spot_title" name="_sf_title" id="_sf_spot_title" value="<?php echo $spot->post_title; ?>" />
                                    <small class="error tooltip left" style="top: 8px;"><?php _e('Type in your title.', 'btoa'); ?></small>
                                    
                                </p>
								
									<?php
									
										do_action('_sf_submission_after_title', $spot_id);
										sf_create_public_submission_action('after_title', $submission_fields_actions, $spot_id);
										
									?>
                            
                                <p class="rel">
                                
                                	<input type="text" placeholder="<?php _e('Slogan', 'btoa'); ?>" name="_sf_slogan" id="_sf_slogan" value="<?php echo get_post_meta($spot->ID, 'slogan', true); ?>" />
                                    <small class="error tooltip left" style="top: 8px;"><?php _e('Type in your title.', 'btoa'); ?></small>
                                    
                                </p>
								
									<?php
									
										do_action('_sf_submission_after_slogan', $spot_id);
										sf_create_public_submission_action('after_slogan', $submission_fields_actions, $spot_id);
										
									?>
                                
                                <p>
                                
                                	<?php wp_editor($spot->post_content, '_sf_spot_content', array(
									
										'media_buttons' => false,
										'textarea_rows' => '30',
										'editor_css' => '',
									
									)); ?>
                                
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
                                    
                                    	<div class="left"><em><?php echo sprintf2(__('Upload up to %num image(s).', 'btoa'), array('num' => _sf_get_maximum_images($spot_id))); ?></em></div>
                                        <!-- /.left/ -->
                                        
                                        <div class="right">
                                        
                                        <span class="button-secondary" id="_sf_gallery_upload_button" style="cursor: pointer; position: relative;"><?php _e('Upload Images', 'btoa'); ?><input type="file" value="Upload Image" class="button-secondary" name="_sf_gallery_upload[]" id="_sf_gallery_upload" multiple style="display: block; opacity: 0; position: absolute; left: 0; top: 0; width: 100%; height: 100%; cursor: pointer !important;" /></span>
                                        
                                        </div>
                                        <!-- /.right/ -->
                                        
                                        <div class="clear"></div><span class="upload-bar-file" style="display: none;"></span><div class="upload-bar" style="display: none;"><span></span></div>
                                        
                                        <div class="clear"></div>
                                        <!-- /.clear/ -->
                                        
                                        <input type="hidden" name="_sf_gallery" id="_sf_gallery_attachments" value="<?php echo get_post_meta($spot_id, '_sf_gallery_images', true); ?>" />
                                        
                                        <?php if(get_post_meta($spot_id, 'price_images', true) == 'on') : ?><input type="hidden" name="_sf_gallery_extra" id="_sf_gallery_extra" value="true" /><?php endif; //// IF USER IS ALLOWED TO UPLOAD THE EXTRA IMAGES ?>
                                        
                                        <script type="text/javascript">
										
											jQuery(document).ready(function() {
												
												//// SORTABLE GALLERY
												jQuery('#_sf_gallery_images')._sf_sortable_gallery();
												
												//// UPLOAD IMAGE
												jQuery('#_sf_gallery_upload')._sf_upload_gallery(<?php echo $spot_id; ?>);
												
											});
										
										</script>
                                        
                                        
                                        <ul id="_sf_gallery_images">
                
											<?php
											
												$_sf_gallery_images = get_post_meta($spot->ID, '_sf_gallery_images', true);
                                            
                                                //// IF WE HAVE IMAGES
                                                if(is_object(json_decode(htmlspecialchars_decode($_sf_gallery_images)))) :
												
												//// LOOPS IMAGE BY IMAGE
												foreach(json_decode(htmlspecialchars_decode($_sf_gallery_images)) as $single_image) :
												
												//// GETS IMAGE
												if($this_image = wp_get_attachment_image_src($single_image, 'full')) :
												
												$image_url = ddTimthumb($this_image[0], 150, 150);
                                                
                                            ?>
                                            
                                            	<li style="opacity: 1;"><img src="<?php echo $image_url; ?>" alt="" title=""><span class="hidden id"><?php echo $single_image ?></span><span class="remove" onclick="jQuery(this)._sf_sortable_gallery_remove();"><i class="icon-trash"></i></span></li>
                                            
                                            <?php endif; endforeach; endif; ?>
                                        
                                        
                                        </ul>
                                        <!-- /#_sf_gallery_images/ -->
                                        
                                        <div class="clear"></div>
                                        <!-- /.clear/ -->
                                    
                                    </div>
                                    <!-- /.inside/ -->
                                
                                </div>
                                <!-- /._sf_box/ -->
								
									<?php
									
										do_action('_sf_submission_after_gallery', $spot_id);
										sf_create_public_submission_action('after_gallery', $submission_fields_actions, $spot_id);
										
									?>
								
								<?php endif; ?>
								
								
									<?php
									
										//////////////////////////////
										////// ONLY IF IT'S ENABLED
										//////////////////////////////
										if(ddp('pbl_featured') == 'on') :
									
									?>
								
									<div class="_sf_box">
									
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
													if(ddp('price_featured') != '' && ddp('price_featured') != '0' && get_post_meta($spot_id, 'price_featured', true) != 'on' && get_post_meta($spot_id, 'featured', true) != 'on') :
													
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
                                            
												<?php 
                                                    
                                                    $the_value = get_post_meta($spot_id, 'featured', true);
                                                    if($the_value != 'on') { $the_value = 'off'; }
                                                    
                                                ?>
                                            
                                            <div class="_sf_switch" id="pbl_featured" style="float: right;">
                                            
                                            	<input type="checkbox" name="_sf_featured" id="pbl_featured_check" class="_sf_switch_input" value="<?php echo  $the_value; ?>" checked="checked" />
                                            
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
									
									
									if($cats) :?>
                                
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
												
												//// GETS THE CURRENT CATEGORIES
												$the_cats = array();
												$the_cats_obj = get_the_terms($spot_id, 'spot_cats');
												
												//// GOES THROUGH THE CATS AND ADDS THEM TO AN ARRAY
												if(is_array($the_cats_obj)) { foreach($the_cats_obj as $_cat) { $the_cats[] = $_cat->term_id; } }
												
												foreach($cats as $_cat) :
												
													$class = '';
												
													//// CHECKS IF IT HAS CHILDREN
													if(ddp('pbl_cats') == 'on') {
														
														if($terms = get_terms('spot_cats', array('hide_empty' => false, 'parent' => $_cat->term_id))) {
															
															$class = ' class="load-subcategories"';
															
														}
														
													}
											
											?>
                                        
                                        		<li><input type="<?php echo $input_type; ?>"<?php echo $class; ?> name="_sf_category[]" id="_sf_category_<?php echo $_cat->term_id ?>" value="<?php echo $_cat->term_id ?>"<?php if(in_array($_cat->term_id, $the_cats)) { echo ' checked="checked"'; } ?> /><span class="checkbox-label"><?php echo $_cat->name; ?></span>
												
												<?php
												
													//// IF THIS IS SELECTED ALSO SHOW SUB CATEGORIES
													if(in_array($_cat->term_id, $the_cats)) :
													
														if($subcats = get_terms('spot_cats', array(
														
															'hide_empty' => false,
															'parent' => $_cat->term_id,
														
														))) :
												
												?>
												
													<ul>
													
														<?php foreach($subcats as $subcat) :
												
															$class = '';
														
															//// CHECKS IF IT HAS CHILDREN
																
																if($terms = get_terms('spot_cats', array('hide_empty' => false, 'parent' => $subcat->term_id))) {
																	
																	$class = ' class="load-subcategories"';
																	
																} ?>
														
															<li><input type="<?php echo $input_type; ?>"<?php echo $class; ?> name="_sf_category[]" id="_sf_category_<?php echo $subcat->term_id ?>" value="<?php echo $subcat->term_id ?>"<?php if(in_array($subcat->term_id, $the_cats)) { echo ' checked="checked"'; } ?> /><span class="checkbox-label"><?php echo $subcat->name; ?></span>
												
																<?php
																
																	//// IF THIS IS SELECTED ALSO SHOW SUB CATEGORIES
																	if(in_array($subcat->term_id, $the_cats)) :
																	
																		if($subcats2 = get_terms('spot_cats', array(
																		
																			'hide_empty' => false,
																			'parent' => $subcat->term_id,
																		
																		))) :
																
																?>
																
																	<ul>
																	
																		<?php foreach($subcats2 as $subcat2) :
																
																			$class = '';
																		
																			//// CHECKS IF IT HAS CHILDREN
																				
																				if($terms = get_terms('spot_cats', array('hide_empty' => false, 'parent' => $subcat2->term_id))) {
																					
																					$class = ' class="load-subcategories"';
																					
																				} ?>
																		
																			<li><input type="<?php echo $input_type; ?>"<?php echo $class; ?> name="_sf_category[]" id="_sf_category_<?php echo $subcat2->term_id ?>" value="<?php echo $subcat2->term_id ?>"<?php if(in_array($subcat2->term_id, $the_cats)) { echo ' checked="checked"'; } ?> /><span class="checkbox-label"><?php echo $subcat2->name; ?></span>
												
																				<?php
																				
																					//// IF THIS IS SELECTED ALSO SHOW SUB CATEGORIES
																					if(in_array($subcat2->term_id, $the_cats)) :
																					
																						if($subcats3 = get_terms('spot_cats', array(
																						
																							'hide_empty' => false,
																							'parent' => $subcat2->term_id,
																						
																						))) :
																				
																				?>
																				
																					<ul>
																					
																						<?php foreach($subcats3 as $subcat3) :
																				
																							$class = '';
																						
																							//// CHECKS IF IT HAS CHILDREN
																								
																								if($terms = get_terms('spot_cats', array('hide_empty' => false, 'parent' => $subcat3->term_id))) {
																									
																									$class = ' class="load-subcategories"';
																									
																								} ?>
																						
																							<li><input type="<?php echo $input_type; ?>"<?php echo $class; ?> name="_sf_category[]" id="_sf_category_<?php echo $subcat3->term_id ?>" value="<?php echo $subcat3->term_id ?>"<?php if(in_array($subcat3->term_id, $the_cats)) { echo ' checked="checked"'; } ?> /><span class="checkbox-label"><?php echo $subcat3->name; ?></span>
																							
																							
																							
																							</li>
																						
																						<?php endforeach; ?>
																					
																					</ul>
																				
																				<?php endif; endif; ?>
																			
																			</li>
																		
																		<?php endforeach; ?>
																	
																	</ul>
																
																<?php endif; endif; ?>
															
															</li>
														
														<?php endforeach; ?>
													
													</ul>
												
												<?php endif; endif; ?>
												
												</li>
                                            
                                            <?php endforeach; ?>
                                        
                                        </ul>
                                        <!-- /#_sf_categories_box/ -->
                                        
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
                                    
                                    	<em><?php echo sprintf2(__('Add up to %num tags.', 'btoa'), array('num' => _sf_get_maximum_tags($spot_id))); ?></em>
                                        
                                        <input type="hidden" value="" name="_sf_tags" id="_sf_tags_input" />
                                        
                                        <?php if(get_post_meta($spot_id, 'price_tags', true) == 'on') : ?><input type="hidden" name="_sf_tags_extra" id="_sf_tags_extra" value="true" /><?php endif; //// IF USER IS ALLOWED TO ADD EXTRA TAGS ?>
                                        
                                        <ul id="_sf_tags_list">
                                        
                                        	<?php
											
												///// GETS OUR TAGS AND DISPLAYS THEM
												$tags = get_the_terms($spot_id, 'spot_tags');
												
												if(is_array($tags)) : foreach($tags as $_tag) :
											
											?>
                                        
                                        		<li><span><i class="icon-minus" onclick="jQuery(this)._sf_remove_tag();"></i></span><?php echo $_tag->name; ?></li>
                                            
                                            <?php endforeach; endif; ?>
                                        
                                        </ul>
                                        <!-- /#_sf_tags_list/ -->
                                        
                                        <p style="margin-bottom: 0;">
                                        
                                        	<input type="text" name="_sf_tags_add" id="_sf_tags_add" placeholder="<?php _e('Tag Name', 'btoa'); ?>" class="small-input" />
                                            <input type="button" name="_sf_tags_add_submit" onclick="jQuery('#_sf_tags_list')._sf_add_tag(jQuery('#_sf_tags_add').val());" id="_sf_tags_add_submit" value="<?php _e('Add Tag', 'btoa'); ?>" class="button-secondary button-small" style="margin-top: -3px; display: block;" />
                                        
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
                                    
                                    	<p class="rel"><input type="text" name="_sf_address" id="_sf_address" placeholder="<?php _e('Enter address', 'btoa'); ?>" class="small-input" value="<?php echo get_post_meta($spot_id, 'address', true); ?>" />
                                        <input type="button" name="_sf_address_get" id="_sf_address_get" value="<?php _e('Get pinpoint', 'btoa'); ?>" class="button-secondary button-small" style="margin-top: -3px; display: block;" onclick="jQuery(this)._sf_location_get_pinpoint();" />
                                    	<small class="error tooltip right"><?php _e('Please type in the address.', 'btoa'); ?></small></p>
                                        
                                        <div class="one-half">
                                    
                                            <p class="rel"><label for="_sf_latitude"><?php _e('Latitude', 'btoa'); ?></label>
                                            <input type="text" name="_sf_latitude" id="_sf_latitude" class="small-input" value="<?php echo get_post_meta($spot_id, 'latitude', true); ?>" />
                                            <small class="error tooltip right" style="top: 18px;"><?php _e('Please type in a valid latitude.', 'btoa'); ?></small></p>
                                        
                                        </div>
                                        <!-- /.one-half/ -->
                                        
                                        <div class="one-half last">
                                    
                                            <p class="rel"><label for="_sf_longitude"><?php _e('Longitude', 'btoa'); ?></label>
                                            <input type="text" name="_sf_longitude" id="_sf_longitude" class="small-input" value="<?php echo get_post_meta($spot_id, 'longitude', true); ?>" />
                                            <small class="error tooltip left" style="top: 18px;"><?php _e('Please type in a valid longitude.', 'btoa'); ?></small></p>
                                        
                                        </div>
                                        <!-- /.one-half/ -->
                                        
                                        <div class="clear"></div>
                                        <!-- /.clear/ -->
                                        
                                        <script type="text/javascript">
										
											// DAHERO #1667462 EVENT BOUND
											jQuery(document).bind('_ph_google_sync', function() {
												
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
														
													},
													
													<?php if(get_post_meta($spot_id, 'latitude', true) != '' && get_post_meta($spot_id, 'longitude', true) != '') : ?>
													
													marker: {
								
														values: [{ latLng:[<?php echo get_post_meta($spot_id, 'latitude', true) ?>, <?php echo get_post_meta($spot_id, 'longitude', true) ?>] }],
														options: {
															
															draggable: true
															
														},
														events: {
															
															mouseup: function(marker, event, context) {
																
																var theLat = jQuery('#_sf_latitude');
																var theLng = jQuery('#_sf_longitude');
																
																//// GETS MARKER LATITUDE AND LONGITUDE
																var thePos = marker.getPosition();
																var lat = thePos.jb;
																var lng = thePos.kb;
																
																theLat.val(lat);
																theLng.val(lng);
																
															}
															
														}
														
													}
													
													<?php endif; ?>
													
												});
												
												<?php if(get_post_meta($spot_id, 'latitude', true) != '' && get_post_meta($spot_id, 'longitude', true) != '') : ?>
												
													var theMap = jQuery('#_sf_location_map').gmap3('get');
													theMap.setZoom(14);
													theMap.setCenter(new google.maps.LatLng(<?php echo get_post_meta($spot_id, 'latitude', true) ?>, <?php echo get_post_meta($spot_id, 'longitude', true) ?>));
												
												<?php endif; ?>
												
											});
										
										</script>
                                        
                                        <div id="_sf_location_map"></div>
                                        <!-- /#location-map/ -->
                                    
                                    	<?php if(ddp('pbl_custom_pin') == 'on') : ?>
                                        
                                        <p style="margin-bottom: 0;" class="custom-pin-field">
                                        
                                            <label for="_sf_custom_pin"><?php _e('Custom Pin', 'btoa'); ?></label>
                                            <input type="text" name="_sf_custom_pin" id="_sf_custom_pin" placeholder="<?php _e('Pin Image URL', 'btoa'); ?>" class="small-input" value="<?php echo get_post_meta($spot_id, 'pin', true); ?>" />
                                            
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
                                            
                                            <div class="three-fourths last">
                                            
                                            <?php $_sf_custom_fields = htmlspecialchars_decode(get_post_meta($spot_id, '_sf_custom_fields', true)); ?>
                                            
                                            	<input type="hidden" name="_sf_custom_fields" id="_sf_custom_fields_input" value="<?php echo htmlspecialchars(get_post_meta($spot_id, '_sf_custom_fields', true)); ?>" />
                                            
                                            	<ul id="_sf_custom_fields_list">
                                                
                                                	<?php
													
														//// GETS CUSTOM FIELDS
														$the_custom_fields = json_decode($_sf_custom_fields);
													
														//// IF USER HAS CUSTOM FIELDS
														if(is_object($the_custom_fields)) : foreach($the_custom_fields as $_field) :
														
													?>
                                                    
                                                    	<li class="_sf_box" style="">
                                                        
                                                        	<div class="head" onclick="jQuery(this)._sf_custom_field_open(event);">
                                                            
                                                            	<div class="left"><?php echo $_field->label; ?></div>
                                                                
                                                                <div class="right close" onclick="jQuery(this)._sf_custom_field_remove(event);"><i class="icon-cancel"></i></div>
                                                                
                                                                <div class="clear"></div>
                                                                
                                                            </div>
                                                            
                                                            <div class="inside">
                                                            
                                                            	<div class="one-half">
                                                                
                                                                	<p style="position: relative;">
                                                                    
                                                                    	<label>Title:</label>
                                                                        <input type="text" class="_sf_custom_field_label small-input" onblur="jQuery(this)._sf_custom_field_update();" value="<?php echo $_field->label; ?>" />
                                                                        <small class="error tooltip right" style="top: 19px;">!</small>
                                                                    </p>
                                                                
                                                                </div>
                                                                
                                                                <div class="one-half last">
                                                                
                                                                	<p style="position: relative;">
                                                                    	
                                                                        <label>Value:</label>
                                                                        <input type="text" class="_sf_custom_field_value small-input" onblur="jQuery(this)._sf_custom_field_update();" value="<?php echo $_field->value; ?>" />
                                                                        <small class="error tooltip left" style="top: 19px;">!</small>
                                                                    
                                                                    </p>
                                                                </div>
                                                                
                                                                <div class="clear"></div>
                                                                
                                                            </div>
                                                            
                                                        </li>
                                                    
                                                    <?php endforeach; endif; ?>
                                                
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
													
														//// GETS THE FIELDS ALREADY ASSIGNED TO THIS SPOT
														$assigned_dropdowns = get_post_meta($spot_id, '_sf_field_'.get_the_ID(), true);
														if(!is_array($assigned_dropdowns)) { $assigned_dropdowns = array(); }
                                                    
                                                        //// LOOPS EACH DROPDOWN IN THIS FIELD
                                                        $dropdowns = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'dropdown_values', true)));
                                                        
                                                        if(is_object($dropdowns)) :
                                                            
                                                        foreach($dropdowns as $_dropdown) :
                                                    
                                                    ?>
                                                    
                                                        <option value="<?php echo $_dropdown->id ?>"<?php if(in_array($_dropdown->id, $assigned_dropdowns)) { echo ' selected="selected"'; } ?>><?php echo $_dropdown->label ?></option>
                                                    
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
														jQuery('#_sf_field_<?php the_ID() ?>_fields')._sf_load_initial_dependents(jQuery('#_sf_field_<?php echo $parent_field->ID; ?>_select'), <?php echo $parent_field->ID; ?>, <?php the_ID() ?>, function() {
															
															jQuery('#_sf_field_<?php the_ID() ?>_fields')._sf_load_initial_dependents(jQuery('#_sf_field_<?php echo $parent_field->ID; ?>_select'), <?php echo $parent_field->ID; ?>, <?php the_ID() ?>);
															
														});
														
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
                                                    
                                                    <input type="hidden" name="selected_dependents" value="<?php echo urlencode(json_encode(get_post_meta($spot_id, '_sf_field_'.get_the_ID(), true))); ?>" />
                                                
                                                </p>
                                            
                                            
                                            
                                            
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A RANGE FIELD
												elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'range') :
											
											?>
                                            
                                            <?php if(get_post_meta($spot_id, '_sf_field_'.get_the_ID(), true) == '') { $the_value = get_post_meta(get_the_ID(), 'range_minimum', true); } else { $the_value = get_post_meta($spot_id, '_sf_field_'.get_the_ID(), true); } ?>
                                            
                                            <input type="hidden" name="_sf_field_<?php the_id(); ?>" id="_sf_field_<?php the_id(); ?>_field" value="<?php echo $the_value; ?>" />
                                            
                                            <script type="text/javascript">
                                            
                                                jQuery(document).ready(function() {
                                                
                                                    jQuery('#_sf_field_range_<?php echo the_ID(); ?>').slider({
														
														min: <?php echo get_post_meta(get_the_ID(), 'range_minimum', true); ?>,
														max: <?php echo get_post_meta(get_the_ID(), 'range_maximum', true); ?>,
														value: <?php echo $the_value ?>,
														<?php if(get_post_meta(get_the_ID(), 'range_increments', true) != '' && is_numeric(get_post_meta(get_the_ID(), 'range_increments', true))) : ?>step: <?php echo get_post_meta(get_the_ID(), 'range_increments', true) ?>,<?php endif; ?>
														slide: function(event, ui) {
															
															var theValue = ui.value;
															
															<?php if(get_post_meta(get_the_ID(), 'range_price', true) == 'on') ://// IF ITS A PRICE FIELD ?>
																//var theValue = ui.value.formatMoney();
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
                                                
                                                <input type="number" value="<?php echo get_post_meta($spot_id, '_sf_field_'.get_the_ID(), true); ?>" name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_field" class="small-input<?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') { echo ' required-num'; } ?>" />
                                                
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
                                                
                                                <input type="number" value="<?php echo get_post_meta($spot_id, '_sf_field_'.get_the_ID(), true); ?>" name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_field" class="small-input<?php if(get_post_meta(get_the_ID(), 'public_field_required', true) == 'on') { echo ' required-num'; } ?>" />
                                                
                                            </p>
                                            
                                            
                                            
                                            
                                            
                                            <?php
											
												//////////////////////////////////////////////
												//// IF ITS A CHECK FIELD
												elseif(get_post_meta(get_the_ID(), 'field_type', true) == 'check') :
												
												$the_value = get_post_meta($spot_id, '_sf_field_'.get_the_ID(), true);
												if($the_value != 'on') { $the_value = 'off'; }
											
											?>
                                            
                                            <script type="text/javascript">
											
												jQuery(document).ready(function() {
													
													jQuery('#_sf_switch_<?php the_ID() ?>_switch')._sf_switch();
													
												});
											
											</script>
                                            
                                            <div class="_sf_switch" id="_sf_switch_<?php the_ID() ?>_switch">
                                            
                                            	<input type="checkbox" name="_sf_field_<?php the_ID(); ?>" id="_sf_field_<?php the_ID(); ?>_field" class="_sf_switch_input" value="<?php echo $the_value; ?>" checked="checked" />
                                            
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
                                            
												<?php 
                                                    
                                                    $the_value = get_post_meta($spot_id, 'contact_form', true);
                                                    if($the_value != 'on') { $the_value = 'off'; }
                                                    
                                                ?>
                                            
                                            	<input type="checkbox" name="_sf_contact_form" id="_sf_contact_form_field" class="_sf_switch_input" value="<?php echo $the_value ?>" checked="checked" />
                                            
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
                            
                            		<div class="left">
                                    
                                    	<?php if($spot->post_status == 'publish') { $publish = __('Finish Edit', 'btoa'); } elseif(ddp('pbl_publish') == 'on') { $publish = __('Publish', 'btoa'); } else { $publish = __('Submit for review', 'btoa'); } ?>
                                        <a href="<?php echo home_url(); ?>" class="logout button-primary" onclick="jQuery('#_sf_spot').submit(); return false;"><?php echo $publish; ?></a>

                                    
                                    </div>
                                
                                </div>
                                
                            <?php endif; ?>
                        
                        </div>
                        <!-- /.row/ -->
                        
                        <?php if(ddp('pbl_custom_fields') == 'on') : ?>
                        
	                        <div class="divider-top" style="margin-bottom: 30px; margin-top: 35px;"></div>
                            
                            <div class="right">
                        
										<?php if($spot->post_status == 'publish') { $publish = __('Finish Edit', 'btoa'); } elseif(ddp('pbl_publish') == 'on') { $publish = __('Publish', 'btoa'); } else { $publish = __('Submit for review', 'btoa'); } ?>
                                        <a href="<?php echo home_url(); ?>" class="logout button-primary" onclick="jQuery('#_sf_spot').submit(); return false;"><?php echo $publish; ?></a>
                                    
                                    </div></div>
                            
                            <div class="clear"></div>
                            <!-- /.clear/ -->
                        
                        <?php endif; ?>
                        
                        <input type="hidden" value="<?php echo $spot_id; ?>" name="_sf_post" id="_sf_spot_id" />
                        
                    </form>
                    <!-- /#_sf_spot/ -->
                    
                </div>
                <!-- /#main-content/ -->
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->