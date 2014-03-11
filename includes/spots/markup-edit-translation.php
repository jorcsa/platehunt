<?php

	////// INSERTS A POST AS AN AUTO-DRAFT SO WE CAN GET A POST ID
	$current_user = wp_get_current_user();
	$spot_id = $_GET['id'];
	$spot = get_post($spot_id);
	global $sitepress;
	
	///// IF WE HAVE A TOKEN WE NEED TO PROCESS OUR CHECKOUT
	if(isset($_GET['token']) && isset($_GET['PayerID'])) { if($_GET['token'] != '' && $_GET['PayerID'] != '') {
		
		$_error = _sf_checkout_function_process($spot_id, $_GET['token'], $_GET['PayerID']);
		
	} }
	
	$submission_fields_actions = _sf_get_submission_field_actions();
	
	//// GETS THE MASTER LANGUAGE
	$master_id = icl_object_id($spot_id, 'spot', false, $sitepress->get_default_language());
	$master_post = get_post($master_id);
	$flag = _sf_get_flag($sitepress->get_flag($sitepress->get_default_language()));
	
	//// GETS THE LANGUAGE WE ARE EDITING
	global $wpdb;
	
	$spot_language = wpml_get_language_information($spot_id);
	$query = $wpdb->get_row('SELECT code FROM ' . $wpdb->prefix . 'icl_languages WHERE default_locale="'.$spot_language['locale'].'"');
	$spot_language = $query->code;
	
	$current_flag = _sf_get_flag($sitepress->get_flag($spot_language));

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
                    
                        <div class="left"><h2><?php _e('Edit Translation', 'btoa'); ?> - <?php echo $spot->post_title ?></h2></div>
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
                    
                    
                    <script type="text/javascript">
					
						jQuery(document).ready(function() {
							
							jQuery('#_sf_spot')._sf_spot_submit_translation();
							
						});
					
					</script>
                    
                    <form id="_sf_spot" action="<?php echo home_url() ?>" method="post">

                        <div class="row">
                        
                            <div class="large-8 columns">
                            
                                <p class="rel fieldset">
								
										<span class="original"><img src="<?php echo $flag ?>" alt="" title="" /> &nbsp;<?php echo get_the_title($master_id); ?></span>
                                
                                		<input type="text" placeholder="<?php _e('Enter your title', 'btoa'); ?>" class="spot_title" name="_sf_title" id="_sf_spot_title" value="<?php echo $spot->post_title; ?>" style="background-image: url(<?php echo $current_flag ?>); background-repeat: no-repeat; background-position: 10px center;" />
                                    <small class="error tooltip left" style="top: 8px;"><?php _e('Type in your title.', 'btoa'); ?></small>
                                    
                                </p>
								
									<?php
									
										do_action('_sf_submission_after_title', $spot_id);
										sf_create_public_submission_action('after_title', $submission_fields_actions, $spot_id);
										
									?>
                            
                                <p class="rel fieldset">
								
										<span class="original"><img src="<?php echo $flag ?>" alt="" title="" /> &nbsp;<?php echo get_post_meta($master_id, 'slogan', true); ?></span>
                                
                                		<input type="text" placeholder="<?php _e('Slogan', 'btoa'); ?>" name="_sf_slogan" id="_sf_slogan" value="<?php echo get_post_meta($spot->ID, 'slogan', true); ?>" style="background-image: url(<?php echo $current_flag ?>); background-repeat: no-repeat; background-position: 10px center;" />
                                    <small class="error tooltip left" style="top: 8px;"><?php _e('Type in your title.', 'btoa'); ?></small>
                                    
                                </p>
								
									<?php
									
										do_action('_sf_submission_after_slogan', $spot_id);
										sf_create_public_submission_action('after_slogan', $submission_fields_actions, $spot_id);
										
									?>
									
									<div class="fieldset fieldset-content">
										
										<?php wp_editor($spot->post_content, '_sf_spot_content', array(
										
											'media_buttons' => false,
											'textarea_rows' => '30',
											'editor_css' => '',
										
										)); ?>
									
										<div class="original"><?php echo apply_filters('the_content', $master_post->post_content); ?></div>
										<!-- .original -->
									
									</div>
								
									<?php
									
										do_action('_sf_submission_after_content', $spot_id);
										sf_create_public_submission_action('after_content', $submission_fields_actions, $spot_id);
										
									?>
                                
                                <div class="padding" style="height: 5px;"></div>
                                <!-- /.padding/ -->
								
									<?php
									
										do_action('_sf_submission_after_gallery', $spot_id);
										sf_create_public_submission_action('after_gallery', $submission_fields_actions, $spot_id);
										
									?>
								
									<?php
									
										do_action('_sf_submission_after_featured', $spot_id);
										sf_create_public_submission_action('after_featured', $submission_fields_actions, $spot_id);
										
									?>
								
									<?php
									
										do_action('_sf_submission_before_custom_fields', $spot_id);
										sf_create_public_submission_action('before_custom_fields', $submission_fields_actions, $spot_id);
										
									?>
								
										<?php
										
											do_action('_sf_submission_after_custom_fields', $spot_id);
											sf_create_public_submission_action('after_custom_fields', $submission_fields_actions, $spot_id);
											
										?>
                            
                            </div>
                            <!-- /.large-8/ -->
                            
                            <div class="large-4 columns">
                            
                            	<?php
								
									//// GETS CATEGORIES
									$cats = get_terms('spot_cats', array(
										
										'hide_empty' => 0
										
									));
									
									?>
                                
                                
								
									<?php
									
										do_action('_sf_submission_after_categories', $spot_id);
										sf_create_public_submission_action('after_categories', $submission_fields_actions, $spot_id);
										
									?>
                                
                                
								
									<?php
									
										do_action('_sf_submission_after_tags', $spot_id);
										sf_create_public_submission_action('after_tags', $submission_fields_actions, $spot_id);
										
									?>
                                
                                
                                
                                
                                
                                <div class="_sf_box" id="_sf_location">
                                
                                		<div class="head">
                                    
                                    	<div class="left"><?php _e('Address', 'btoa'); ?></div>
                                        <!-- /.left/ -->
                                        
                                        <div class="clear"></div>
                                        <!-- /.cclear/ -->
                                    
                                    </div>
                                    
                                    <div class="inside">
                                    
                                    	<p class="rel fieldset fieldset-small">
										
												<span class="original"><img src="<?php echo $flag ?>" alt="" title="" /> &nbsp;<?php echo get_post_meta($master_id, 'address', true); ?></span>
										
												<input type="text" name="_sf_address" id="_sf_address" placeholder="<?php _e('Enter address', 'btoa'); ?>" class="small-input" value="<?php echo get_post_meta($spot_id, 'address', true); ?>" style="background-image: url(<?php echo $current_flag ?>); background-repeat: no-repeat; background-position: 10px center;" />
                                    		<small class="error tooltip right"><?php _e('Please type in the address.', 'btoa'); ?></small>
											
											</p>
                                    
                                    </div>
                                    
                                </div>
                                <!-- /#_sf_location/ -->
								
									<?php
									
										do_action('_sf_submission_after_map', $spot_id);
										sf_create_public_submission_action('after_map', $submission_fields_actions, $spot_id);
										
									?>
									
									
									<?php if(ddp('pbl_custom_fields') == 'on') : //// IF USERS CAN AD CUSTOM FIELDS ?>
									
										<?php
										
											//// TRIES AND GET CUSTOM FIELDS FROM PARENTS
											$_sf_parent_custom_fields = htmlspecialchars_decode(get_post_meta($master_id, '_sf_custom_fields', true));
											
											if(is_object(json_decode($_sf_parent_custom_fields))) :
										
										?>
									
										<div class="_sf_box" id="_sf_custom_fields">
										
											<div class="head">
                                        
                                        	<div class="left"><?php _e('Custom Fields', 'btoa'); ?></div>
                                            
                                            <div class="clear"></div>
                                            <!-- /.clear/ -->
                                        
                                        </div>
                                        <!-- /.head/ -->
										
											<div class="inside">
											
												<?php
												
													///// NOW LETS GET THE CHILDREN AND PARENT CUSTOM FIELDS
													$parent_custom_fields = json_decode(htmlspecialchars_decode(get_post_meta($master_id, '_sf_custom_fields', true)));
													$_children_custom_fields = htmlspecialchars_decode(get_post_meta($spot_id, '_sf_custom_fields', true));
													if(is_object(json_decode($_children_custom_fields))) { $children_custom_fields = json_decode(htmlspecialchars_decode(get_post_meta($spot_id, '_sf_custom_fields', true))); }
												
												?>
												
												<script type="text/javascript">
												
													jQuery(document).ready(function() {
														
														///// LETS ADD FUNCTIONALITY SO WHEN THE USER CHANGES A FIELD WE UPDATE THE CUSTOM FIELDS
														jQuery('#wpml_custom_fields')._sf_wpml_update_custom_field_translations();
														
													});
												
												</script>
												
												<input type="hidden" name="_sf_custom_fields" id="_sf_custom_fields_input" value="<?php echo htmlspecialchars(get_post_meta($spot_id, '_sf_custom_fields', true)); ?>" />
													
												<ul id="wpml_custom_fields">
												
													<?php $i = 0; foreach($parent_custom_fields as $parent_custom_field) : ?>
												
														<li class="border-color-input">
														
															<span class="original"><img src="<?php echo $flag ?>" alt="" title="" /> &nbsp;<strong><?php echo $parent_custom_field->label; ?>:</strong> <?php echo $parent_custom_field->value ?></span>
															
															<span class="translations">
																
																<?php
																
																	$translated_value = $parent_custom_field->label;
																
																	//// CHECKS FOR THE TRANSLATED VALUE, OTHERWISE DISPLAYS THE UNSTRASLATED
																	if(isset($children_custom_fields)) {
																		
																		$i2 = 0; foreach($children_custom_fields as $children_custom_field) {
																			
																			if($i == $i2) {
																				
																				if($children_custom_field->label != '') { $translated_value = $children_custom_field->label; break; }
																				
																			}
																			
																			$i2++;
																			
																		} /// ENDS FOREACH
																		
																	}
																
																?>
																<p class="rel">
																
																	<input type="text" name="" id="" class="small-input label" value="<?php echo $translated_value; ?>" style="background-image: url(<?php echo $current_flag ?>); background-repeat: no-repeat; background-position: 10px center;" />
																	<small class="error tooltip right">!</small>
																	
																</p>
																
																<?php
																
																	$translated_value = $parent_custom_field->value;
																
																	//// CHECKS FOR THE TRANSLATED VALUE, OTHERWISE DISPLAYS THE UNSTRASLATED
																	if(isset($children_custom_fields)) {
																		
																		$i2 = 0; foreach($children_custom_fields as $children_custom_field) {
																			
																			if($i == $i2) {
																				
																				if($children_custom_field->value != '') { $translated_value = $children_custom_field->value; break; }
																				
																			}
																			
																			$i2++;
																			
																		}
																		
																	}
																
																?>
																<p class="rel">
																
																	<input type="text" name="" id="" class="small-input value" value="<?php echo $translated_value; ?>" style="background-image: url(<?php echo $current_flag ?>); background-repeat: no-repeat; background-position: 10px center;" />
																	<small class="error tooltip right">!</small>
																	
																</p>
															
															</span>
															<!-- .translations -->
														
														</li>
												
													<?php $i++; endforeach; ?>
												
												</ul>
												<!-- #wpml_custom_fields -->
											
											</div>
										
										</div>
										<!-- _sf_custom_fields -->
										
										<?php endif; //// ENDS IF PARENT HAS CUSTOM FIELDS ?>
									
									<?php endif; ?>
								
									<?php
									
										do_action('_sf_submission_before_search_fields', $spot_id);
										sf_create_public_submission_action('before_search_fields', $submission_fields_actions, $spot_id);
										
									?>
									
									<?php
									
										do_action('_sf_submission_after_search_fields', $spot_id);
										sf_create_public_submission_action('after_search_fields', $submission_fields_actions, $spot_id);
										
									?>
						
                            </div>
                            <!-- /.large-8/ -->
                        
                        </div>
                        <!-- /.row/ -->
                        
						<div class="divider-top" style="margin-bottom: 30px; margin-top: 35px;"></div>
						
						<div class="right">
					
									<?php if($spot->post_status == 'publish') { $publish = __('Finish Edit', 'btoa'); } elseif(ddp('pbl_publish') == 'on') { $publish = __('Publish', 'btoa'); } else { $publish = __('Submit for review', 'btoa'); } ?>
									<a href="<?php echo home_url(); ?>" class="logout button-primary" onclick="jQuery('#_sf_spot').submit(); return false;"><?php echo $publish; ?></a>
								
								</div></div>
						
						<div class="clear"></div>
						<!-- /.clear/ -->
                        
                        <input type="hidden" value="<?php echo $spot_id; ?>" name="_sf_post" id="_sf_spot_id" />
                        
                    </form>
                    <!-- /#_sf_spot/ -->
                    
                </div>
                <!-- /#main-content/ -->
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->