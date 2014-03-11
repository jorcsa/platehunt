<?php include('bpanel-store.php');global $current_user;
      get_currentuserinfo(); ?>

<!-- CSS FILE -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/bpanel/style.css" media="screen" />

<!-- CSS FILE -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/bpanel/css/bPanel-jquery-ui-1.8.7.custom.css" media="screen" />


<!-- JS FILE -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/ajaxupload.js"></script>

<!-- checkbox -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/jquery.checkbox.min.js"></script>

<!-- main script file -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/scripts.js"></script>	

<!-- UI -->

<script type="text/javascript">

	jQuery(document).ready(function() {
				
		sectionClickHandler();
		
		descriptionDelimiters();
		
		bpanelSelectReplacers();
		
		bpanelImageFieldHover();
		
		jQuery('.bpanel-check').each(function() { jQuery(this).bpanelCheckReplace(); });
		
		bpanelColorPicker();
		
		bpanelInit();
		
		jQuery('#contextual-help-link-wrap').remove();
		
		<?php if(isset($ddpStore)) : //// IF WE HAVE SAVED OUR SETTINGS ?>
		
			bpanelInfo('Setting successfully saved.');
		
		<?php endif; ?>
		
		<?php
		
			//Lets go through our fields to check if there's any upload buttons
			foreach($myOpts as $opt) {
				
				//foreach tab
				if($opt['tabs'] != NULL) { foreach($opt['tabs'] as $tab) {
					
					//foreach field
					if($tab['fields'] != NULL) { foreach($tab['fields'] as $field) {
						
						//if its an image
						if($field['type'] == 'image' || $field['type'] == 'file') {
							
						?>
		
							//AJAX upload
							jQuery('#ddp_<?php echo $field['name']; ?>_button').each(function(){
								
								var the_button = jQuery(this);
								var image_input = jQuery(this).siblings('input');
								var image_id = jQuery(this).attr('id');
								//alert('a');
								
								new AjaxUpload(image_id, {
									
									  action: ajaxurl,
									  name: image_id,
									  
									  // Additional data
									  data: {
										action: 'ddpanel_ajax_upload',
										data: image_id
									  },
									  
									  autoSubmit: true,
									  responseType: false,
									  onChange: function(file, extension){},
									  onSubmit: function(file, extension) {
										  
											the_button.attr('disabled', 'disabled').addClass('ddpanel-upload-button-disabled');	
														  
									  },
									  
									  onComplete: function(file, response) {
											
											the_button.removeAttr('disabled').removeClass('ddpanel-upload-button-disabled');
											
											if(response.search("Error") > -1){
												
												alert("There was an error uploading:\n"+response);
												
											}
											
											else{		
																
												image_input.val(response);
												
												<?php if($field['type'] == 'image') : ?>
												//// LET'S LOAD THE IMAGE AND FIND OUT THE WIDTH AND HEIGHT OF IT
												var uploadedImage = new Image();
												jQuery(uploadedImage).attr('src', response);
												
												jQuery(uploadedImage).load(function() {
													
													/// APPEND IT TO THE BODY
													image_input.parent().siblings('.field-desc').append(this);
													image_input.parent().siblings('.field-desc').children('img').css({ opacity: 0, display: 'block' });
													
													/// UPDATES HEIGHT AND WIDTH
													var imageHeight = image_input.parent().siblings('.field-desc').children('img').height();
													var imageWidth = image_input.parent().siblings('.field-desc').children('img').width();
													image_input.siblings('.image_height').val(imageHeight);
													image_input.siblings('.image_width').val(imageWidth);
													
													/// GETS RID OF THE IMAGE
													image_input.parent().siblings('.field-desc').children('img').remove();
													
												});
												<?php endif; ?>
													
											}
											
										}
								});
							});
						
						<?php	
							
						} //// IF IT'S AN IMAGE
						
						if($field['type'] == 'range') {
							
							//// MIN AND MAX VALUES
							$range = explode(',', $field['range']); 
							?>
						
							jQuery('#ddp_<?php echo $field['name']; ?>_slide').slider({
								
								range: 'min',
								value: <?php if(ddp($field['name']) != '') { echo ddp($field['name']); } else { echo 1; } ?>,
								min: <?php echo $range[0]; ?>,
								max: <?php echo $range[1] ?>,
								slide: function(event, ui) {
									
									jQuery(this).parent().children('input').val(ui.value);
									jQuery(this).parent().children('.old-val').html(ui.value);
									
								}
								
							});
						
						<?php
						
						} //// IF IT'S RANGE
						
					} }
					
				} }
				
			}
		
		?>
		
		
		
	});
	
	function bpanelGenerateBackup() {
		
		//// LET'S START OUR JQUERY AJAX QUERY TO RETURN AN ENCRYPTED ARRAY OF OPTIONS
		jQuery.ajax({
			
			type: 'POST',
			url: '<?php echo get_template_directory_uri().'/includes/bpanel/generate-backup.php'; ?>',
			dataType: 'json',
			data: {
				
				fields: jQuery('#ddpanel-form').serialize()
				
			},
			success: function(data) {
				
				alert('Save the text that pops up in the textarea. That\'s your backup.');
				
				jQuery('#ddp_import').val(data.backup);
				
				
				//alert(data.backup);
				
			}
			
		});
		
		return false;
		
	}
	
	function bpanelImportBackup(myButton) {
		
		////OUR IMPORT STRING
		var importStr = myButton.siblings('textarea').val();
		
		jQuery.ajax({
			
			type: 'POST',
			url: '<?php echo get_template_directory_uri().'/includes/bpanel/import-backup.php'; ?>',
			dataType: 'json',
			data: {
				
				fields: importStr
				
			},
			success: function(data) {
				
				if(data.error) {
					
					alert(data.message);
					
				} else {
					
					alert('Done!');
					location.reload();
					
				}
				
			}
			
		});
		
	}
	
	function ddAddCustomSidebar(buttonCont) {
		
		//// MAIN CONTAINERS
		inputCont = buttonCont.siblings('input');
		
		////gets the input value
		var newSidebarName = inputCont.val();
		
		if(newSidebarName == '') {
			
			bpanelError('Please insert a name for your sidebar.', jQuery('#add_sidebar'));
			
		} else { //disbales it
			
				//adds loading gif
				buttonCont.before('<span class="loading-gif-button"></span>');
				buttonCont.siblings('.loading-gif-button').fadeIn(300);
				buttonCont.fadeOut(200);
				
				// LET'S PROCESS THE REQUEST
				jQuery.ajax({
					
					type: 		'POST',
					url: 		'<?php echo get_template_directory_uri().'/includes/bpanel/sidebars/add-sidebar.php'; ?>',
					dataType: 	'json',
					data: {
					
						sidebar_name: newSidebarName
						
					},
					success: function(data) {
						
						// IF THERE'S NO ERRORS
						if(data.error == false) {
							
							//removes loading and puts button back to normal
							buttonCont.siblings('.loading-gif-button').remove();
							buttonCont.fadeIn(200);
							
							// LET'S UPDATE THE SIDEBAR NAMES
							if(data.newSidebars.length > 0) {
							
							var newOpts = '';
							for(var i in data.newSidebars) {
								
								newOpts += '<option>'+data.newSidebars[i]+'</option>';
								
							}
							//updates it
							jQuery('#dd_custom_sidebars_select').html(newOpts);
							
							bpanelInfo('Sidebar successfully added.');
							inputCont.val('Custom Sidebar Unique Name');
							
						}
							
							
						} else {
							
							//removes loading and puts button back to normal
							buttonCont.siblings('.loading-gif-button').remove();
							buttonCont.fadeIn(200);
							
							//shows the error message
							bpanelError(data.error_msg, jQuery('#add_sidebar'));
							
						}
						
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						
						
					}
					
				});
				
		}
		
	}
	
	function ddDeleteCustomSidebar(buttonCont) {
	 
		//// LET"S GET THE SELECTED SIDEBARS AND DEFINE MAIN VARS
		var selCont = buttonCont.siblings('select');
		var selItems = selCont.children('option:selected');
		
		if(selItems.text() != 'You have no custom sidebars.') {
			
	
			/// SELECTED ARRAY
			var itemsArr = [];
			selItems.each(function(i, selected) {
				
				itemsArr[i] = jQuery(selected).text();
				
			});
			
			// IF SELECT IS NOT EMPTY
			if(itemsArr.length > 0) {
				
				/// Confirm the delete
				var confirmDelete = confirm("Are you sure you want to delete the sidebar "+itemsArr+"?\nThis cannot be undone and the data in this sidebar will be erased.");
				
				//if confirms
				if(confirmDelete) {
			
					//adds loading gif
					buttonCont.before('<span class="loading-gif-button-sidebar"></span>');
					buttonCont.siblings('.loading-gif-button').fadeIn(300);
					buttonCont.attr('disabled', 'disabled').css({ opacity: .5 });
					
					//delete ITTTT
					jQuery.ajax({
						
						type: 'POST',
						url: '<?php echo get_template_directory_uri().'/includes/bpanel/sidebars/delete-sidebar.php'; ?>',
						dataType: 'json',
						data: {
							
							sidebars: itemsArr	
							
						},
						success: function(data) {
							
							//updates our select
							if(data.newSidebars.length > 0) {
								
								var newOpts = '';
								for(var i in data.newSidebars) {
									
									newOpts += '<option>'+data.newSidebars[i]+'</option>';
									
								}
								selCont.html(newOpts);
								
							} else { selCont.html('<option>You have no custom sidebars.</option>'); }
							
							//removes loading
							buttonCont.siblings('span.loading-gif-button-sidebar').remove();
							buttonCont.removeAttr('disabled').css({ opacity: 1 });
							bpanelInfo('Sidebar successfully removed.');
							
						}
						
					});
					
				}
				
			} else {
				
				bpanelError('Please select at least one sidebarto delete.', jQuery('#dd_custom_sidebars_select'));
				
			}
		
		}
		
		
		 
	 }

</script>
    
    	<div id="bpanel-wrapper">
        
        	<div id="bpanel-header">
            
            	<div id="bpanel-logo"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/images/bpanel-logo.png" alt="BTOA" /></a></div>
                <!-- /#logo/ -->
                
                <div id="bpanel-header-tools">
                
	                <span id="bpanel-welcome">Welcome back <strong><?php echo $current_user->display_name; ?></strong>. You last edited your settings <strong><?php echo time_elapsed_string(ddp('bpanel_edited_time')); ?></strong> ago.</span>
                    
                    <div id="bpanel-top-buttons">
                    
                    </div>
                    <!-- /#bpanel-top-buttons/ -->
                
                </div>
            
            </div>
            <!-- /bpanel-header/ --><div id="bpanel-body">
            
            	<div id="bpanel-sidebar">
                
                	<ul>
                    
                    	<?php
						
							//// LET'S LOOP THROUGH OUR SECTIONS AND TABS TO MAKE UP THE MARKUP FOR THE MENU
							$iSec = 1;
							foreach($myOpts as $opt) {
								
								echo '<li class="close" id="bpanel-section-'.$iSec.'"><span class="click-area"></span><span class="section-icon" style="background-image:url('.get_template_directory_uri().'/includes/bpanel/icons/'.$opt['icon'].');"></span><span class="section-name">'.$opt['title'].'</span><span class="section-state"></span>';	
									
									// OPENS UL FOR TABS
									echo '<ul>';
									
									$altBgI = 1;
									//// LOOPS OUR TABS
									foreach($opt['tabs'] as $tab) {
										
										echo '<li class="bpanel-tab';
										
										if($altBgI % 2 == 0) { echo ' alt-bg'; }
										
										$altBgI++;
										
										echo '"><span class="tab-bullet"></span>'.$tab['title'].'<span class="current-bg"></span><span class="hidden tab-info">'.$tab['info'].'</span></li>';
										
									}
									
									// CLOSES UL
									echo '</ul>';
								
								//// CLOSE LI
								echo '</li>';
								
								$iSec++;
								
							}
						
						?>
                    
                    </ul>
                    <!-- /sidebar ul/ -->
                    
                    <div id="bpanel-sidebar-bottom"></div>
                    <!-- /bpnel-sidebar-bottom/ -->
                
                </div>
                <!-- /bpanel-sidebar/ -->
                
                <div id="bpanel-content">
                
                	<form id="ddpanel-form" action="" method="post">
                    
                    <div id="bpanel-error"><span></span></div>
                    
                    <div id="bpanel-info"><span></span></div>
                
                	<div id="bpanel-content-info">
                    
                    	<div id="tab-info">These settings will affect the layout of all your pages.<div class="clear"></div></div>
                        <!-- /.tab-info/ -->
                        
                        <div id="tab-buttons">
                        	
                            <input type="submit" class="bpanel-button" value="Save Changes" name="ddp_submit_2" />
                        
                        </div>
                        <!-- /#tab-buttons/ -->
                    
                    </div>
                    <!-- /bpanel-content-info/ -->
                    
                    <ul id="bpanel-tabs">
                    
                    	<?php
						
							//// LET'S NOW LOOP OUR FIELDS
							foreach($myOpts as $section) {
								
								//// LOOPS TABS
								foreach($section['tabs'] as $tab) {
								
									//// START LI
									echo '<li class="bpanel-tab">';
									
									//// LETS NOW LOOP OUR FIELDS
									foreach($tab['fields'] as $field) {
										
										//// IF IT'S A SELECT FIELD
										if($field['type'] == 'select') {
											
											//// START FIELD
											echo '<div class="bpanel-field select-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												if(isset($field['desc'])) { echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>'; }
												
												//// FIELD
												echo '<div class="field-input"><select name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-select" onchange="jQuery(this).bpanelSelectChange();">';
												
													//// OPTIONS
													foreach($field['options'] as $field_option) {
														if(ddp($field['name']) == $field_option) { echo '<option selected="selected" value="'.stripslashes($field_option).'">'.stripslashes($field_option).'</option>'; }
														else { echo '<option value="'.stripslashes($field_option).'">'.stripslashes($field_option).'</option>'; }
													}
													
												/// CLOSES FIELD
												echo '</select><div class="select-selected"></div></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A SELECT FIELD
										elseif($field['type'] == 'pages') {
											
											//// START FIELD
											echo '<div class="bpanel-field select-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><select name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-select" onchange="jQuery(this).bpanelSelectChange();">';
												
													//// PAGES
													$pages = get_pages();
												
													//// OPTIONS
													foreach($pages as $page) {
				
														//// OPENS OUR OPTION
														echo '<option value="'.$page->ID.'"';
														
														//// IF IT's THE SELECTED SIDEBAR
														if(ddp($field['name']) == $page->ID) { echo ' selected="selected"'; }
														
														//// CLOSES OUR OPTION
														echo '>'.$page->post_title.'</option>';
													}
													
												/// CLOSES FIELD
												echo '</select><div class="select-selected"></div></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A SELECT FIELD
										elseif($field['type'] == 'post_type') {
											
											//// START FIELD
											echo '<div class="bpanel-field select-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><select name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-select" onchange="jQuery(this).bpanelSelectChange();">';
												
													//// PAGES
													$pages = get_posts(array('post_type' => $field['post_type']));
												
													//// OPTIONS
													if(!empty($pages)) { foreach($pages as $page) {
				
														//// OPENS OUR OPTION
														echo '<option value="'.$page->ID.'"';
														
														//// IF IT's THE SELECTED SIDEBAR
														if(ddp($field['name']) == $page->ID) { echo ' selected="selected"'; }
														
														//// CLOSES OUR OPTION
														echo '>'.$page->post_title.'</option>';
													} }
													
												/// CLOSES FIELD
												echo '</select><div class="select-selected"></div></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A SELECT FIELD
										elseif($field['type'] == 'custom_sidebar') {
											
											//// START FIELD
											echo '<div class="bpanel-field select-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><select name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-select" onchange="jQuery(this).bpanelSelectChange();">';
												
													//// GETS CUSTOM SIDEBARS
													$custom_sidebars = get_option('dd_custom_sidebars');
													
														echo '<option value="Default">Default</option>';
												
													//// OPTIONS
													foreach($custom_sidebars as $sidebar) {
				
														//// OPENS OUR OPTION
														echo '<option value="'.$sidebar.'"';
														
														//// IF IT's THE SELECTED SIDEBAR
														if(ddp($field['name']) == $sidebar) { echo ' selected="selected"'; }
														
														//// CLOSES OUR OPTION
														echo '>'.$sidebar.'</option>';
													}
													
												/// CLOSES FIELD
												echo '</select><div class="select-selected"></div></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A CHECK FIELD
										if($field['type'] == 'check') {
											
											//// START FIELD
											echo '<div class="bpanel-field text-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												if(ddp($field['name']) == 'on') {
													echo '<div class="field-input"><input name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-check" type="checkbox" checked="checked" value="on" /></div>';
												} else {
													echo '<div class="field-input"><input name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-check" type="checkbox" checked="checked" value="off" /></div>';
												}
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A TEXT FIELD
										if($field['type'] == 'text') {
											
											//// START FIELD
											echo '<div class="bpanel-field text-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><input name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-input" value="'.htmlspecialchars(stripslashes(ddp($field['name']))).'" /></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A TEXT FIELD
										if($field['type'] == 'textarea') {
											
											//// START FIELD
											echo '<div class="bpanel-field textarea-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><textarea name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-textarea" cols="" rows="5">'.stripslashes(ddp($field['name'])).'</textarea></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S AN IMAGE FIELD
										if($field['type'] == 'image') {
											
											//// START FIELD
											echo '<div class="bpanel-field image-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><input name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-input" value="'.htmlspecialchars(stripslashes(ddp($field['name']))).'" /><span class="upload-image" id="ddp_'.$field['name'].'_button"></span>
                                  					  <div class="image-tooltip"><img src="" width="180" /><span></span></div>
													  <input type="hidden" class="hidden image_height" name="ddp_'.$field['name'].'_image_height" id="ddp_'.$field['name'].'_image_height" value="'.ddp($field['name'].'_image_height').'" />
													  <input type="hidden" class="hidden image_width" name="ddp_'.$field['name'].'_image_width" id="ddp_'.$field['name'].'_image_width" value="'.ddp($field['name'].'_image_width').'" />
													  </div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A FILE FIELD
										if($field['type'] == 'file') {
											
											//// START FIELD
											echo '<div class="bpanel-field image-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><input name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-input" value="'.htmlspecialchars(stripslashes(ddp($field['name']))).'" /><span class="upload-image" id="ddp_'.$field['name'].'_button"></span>
													  </div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A COLOR FIELD
										if($field['type'] == 'color') {
											
											//// START FIELD
											echo '<div class="bpanel-field color-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input">
                                
														<div class="picker-wrapper">
													
															<input name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-input main" value="'.ddp($field['name']).'" maxlength="7" />
															<input name="ddp_'.$field['name'].'_opacity" id="ddp_'.$field['name'].'_opacity" class="bpanel-input opacity hidden" value="'.ddp($field['name'].'_opacity').'" />
															
															<div class="color-input-preview-divider"></div>
															<div class="color-input-preview-divider" style="left: 150px;"></div>
															<h5 class="color-opacity">Opacity: <span>'.ddp($field['name'].'_opacity').'</span></h5>
															<div class="color-input-preview" style="background-color:'.ddp($field['name']).';"><span class="color-overlay"></span></div>
															<span class="color-input-picker-button"></span>
															<div class="color-input-picker"></div>
															<div id="ddp_'.$field['name'].'_opacity_slider" class="range-slider"></div>
															
														</div>
														<!-- /picker-wrapper/ -->
														
													</div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A RANGE FIELD
										if($field['type'] == 'range') {
											
											//// MIN AND MAX VALUES
											$range = explode(',', $field['range']);
											
											//// START FIELD
											echo '<div class="bpanel-field range-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><input name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-input min-'.$range[0].' max-'.$range[1].'" value="'.ddp($field['name']).'" onchange="jQuery(this).bpanelUpdateSlide();" />
                                <span class="old-val hidden">'.ddp($field['name']).'</span>
                                <div id="ddp_'.$field['name'].'_slide" class="range-slider"></div></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A TAXONOMY FIELD
										if($field['type'] == 'taxonomy') {
											
											//// START FIELD
											echo '<div class="bpanel-field select-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><select name="ddp_'.$field['name'].'" id="ddp_'.$field['name'].'" class="bpanel-select" onchange="jQuery(this).bpanelSelectChange();">';
												
													//// OUR TAXONOMIES
													$taxonomies = get_terms($field['taxonomy'], array('hide_empty' => false));
												
													//// OPTIONS
													foreach($taxonomies as $tax) {
														if(ddp($field['name']) == $tax->term_id) { echo '<option selected="selected" value="'.$tax->term_id.'">'.$tax->name.'</option>'; }
														else { echo '<option value="'.$tax->term_id.'">'.$tax->name.'</option>'; }
													}
													
												/// CLOSES FIELD
												echo '</select><div class="select-selected"></div></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A TAXONOMY FIELD
										if($field['type'] == 'sidebars') {
											
											//// START FIELD
											echo '<div class="bpanel-field text-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="add_sidebar">Add Sidebar</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">Insert an unique name for your sidebar.</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><input name="add_sidebar" id="add_sidebar" class="bpanel-input" value="Custom Sidebar Unique Name" onclick="jQuery(this).val(\'\');"  /><span class="add_sidebar" id="add_sidebar_button" onclick="ddAddCustomSidebar(jQuery(this));"></span></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
											//// START FIELD
											echo '<div class="bpanel-field select-multiple-field">';
											
												//// LABEL
												echo '<div class="field-label"><label for="dd_custom_sidebars">Delete Sidebar</label></div>';
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">Select and delete a sidebar.<br><br>To select multiple items or unselect item, press CTRL (Command on mac) and click.</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><select multiple="multiple" id="dd_custom_sidebars_select" class="bpanel-select-multiple">';
													
													$sidebars = get_option('dd_custom_sidebars');
													if(count($sidebars) > 0) {
														
														foreach($sidebars as $sidebar) { echo '<option>'.$sidebar.'</option>'; }
														
													} else {
														
														echo '<option>You have no custom sidebars.</option>';
														
													}
													
												/// CLOSES FIELD
												echo '</select><input type="button" class="bpanel-button" value="delete sidebars" onclick="ddDeleteCustomSidebar(jQuery(this));" style="float: right; margin-top: 9px;" /></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
										//// IF IT'S A TEXT FIELD
										if($field['type'] == 'import') {
											
											//// START FIELD
											echo '<div class="bpanel-field textarea-field">';
											
												//// LABEL
												if(isset($field['name'])) { echo '<div class="field-label"><label for="ddp_'.$field['name'].'">'.$field['title'].'</label></div>'; }
												else { echo '<div class="field-label"><label>'.$field['title'].'</label></div>'; }
												
												//// DESCRIPTION
												echo '<div class="field-desc"><span class="full-desc">'.$field['desc'].'</span><span class="short-desc"></span></div>';
												
												//// FIELD
												echo '<div class="field-input"><textarea id="ddp_import" class="bpanel-textarea" cols="" rows="10"></textarea><input type="button" class="bpanel-button" value="import options" onclick="bpanelImportBackup(jQuery(this));" style="float: right; margin-top: 9px;" /><a href="#" class="bpanel-button" onclick="bpanelGenerateBackup();" style="float: left; margin-top: 9px;">Backup Options</a></div>';
											
											//// CLOSES FIELD
											echo '<div class="clear"></div></div>';
											
										}
										
									}
									
									//// CLOSES OUR LI
									echo '</li>';
									
								}
								
							}
						
						?>
                    
                    </ul>
                    <!-- /bpanel-tabs/ -->
                    
                    <div id="bpanel-bottom-info">
                    
                    	<input type="submit" value="Save Changes" id="bpanel-bottom-submit" class="bpanel-button" name="ddp_submit_2" />
                    
                    </div>
                    <!-- /#bpanel-bottom-info/ -->
                    
                    </form>
                
                </div>
                <!-- /boanel-content/ -->
            
            </div>
            <!-- /#bpanel-body/ -->
        
        </div>
        <!-- /bpanel-wrapper/ -->