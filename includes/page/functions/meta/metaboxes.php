<?php

	//// OUR VARIABLE
	$header_bg = get_post_meta($post->ID, 'header_bg', true);
	$slogan = get_post_meta($post->ID, 'slogan', true);
	$header_title = get_post_meta($post->ID, 'header_title', true);
	$header_color = get_post_meta($post->ID, 'header_color', true);
	$page_title = get_post_meta($post->ID, 'page_title', true);
	$fancy_slogan = get_post_meta($post->ID, 'fancy_slogan', true);
	$list_form = get_post_meta($post->ID, 'list_form', true);
	$list_map = get_post_meta($post->ID, 'list_map', true);
	$submit_loggedin = get_post_meta($post->ID, 'submit_loggedin', true);
	
	if($header_color == '') { $header_color = '#ffffff'; }

?>

<!-- /CSS FILE/ -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/ajaxupload.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />

<script type="text/javascript" charset="utf-8">

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

<div class="bpanel-tabbed-meta">

	<ul class="tabs">
    
    	<li class="bpanel-tab current" style="padding-left: 5px;"><i class="icon-cog-alt"></i> <?php _e('Main Options', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-desktop"></i> <?php _e('Fancy Header', 'btoa'); ?></li>
    
    	<li class="bpanel-tab listing-only" style="padding-left: 5px; display: none;"><i class="icon-cog-alt"></i> <?php _e('Listing Page Options', 'btoa'); ?></li>
    
    	<li class="bpanel-tab submit-only" style="padding-left: 5px; display: none;"><i class="icon-cog-alt"></i> <?php _e('Submit Page Options', 'btoa'); ?></li>
    
    </ul>
    <!-- /.tabs/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->
    
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('.bpanel-tabbed-meta .tabs li').click(function() {
				
				if(jQuery(this).attr('class').indexOf('current') == -1) {
					
					var clickedIndex = jQuery(this).index();
					jQuery(this).addClass('current').siblings('.current').removeClass('current');
					
					console.log(clickedIndex);
					
					jQuery(this).parent().siblings('.tabbed').children('li.current').removeClass('current');
					jQuery(this).parent().siblings('.tabbed').children('li:eq('+clickedIndex+')').addClass('current');
					
				}
				
			});
			
			//// LISTING TAB
			if(jQuery('#page_template option:selected').val() == 'listings.php') { jQuery('.listing-only').show(); }
			jQuery('#page_template').change(function() {
				
				if(jQuery('#page_template option:selected').val() == 'listings.php') { jQuery('.listing-only').show(); }
				else { jQuery('.listing-only').hide(); }
				
			});
			
			//// LISTING TAB
			if(jQuery('#page_template option:selected').val() == 'login.php') { jQuery('.submit-only').show(); }
			jQuery('#page_template').change(function() {
				
				if(jQuery('#page_template option:selected').val() == 'login.php') { jQuery('.submit-only').show(); }
				else { jQuery('.submit-only').hide(); }
				
			});
				
				jQuery('#list_map').iphoneStyle();
			
		});
	
	</script>
    
    <ul class="tabbed">
        
        <li class="current">
            
            <div class="one-fifth"><label for="page_title">Display Title:</label></div>
            <div class="two-fifths"><input type="checkbox" name="page_title" id="page_title"<?php if($page_title == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
            <div class="two-fifths description last">Display page title at top of main content?</div>
    
    		<div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="slogan">Header Slogan:</label></div>
            <div class="two-fifths"><input type="text" name="slogan" id="slogan" value="<?php echo $slogan ?>" class="widefat" style="margin-bottom: 5px;" /></div>
            <div class="two-fifths description last">Page slogan, displayed with your title.</div>
            
            <div class="clear"></div>
        
        </li>
        
        <li>
            
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
        
        <li>
            
            <div class="one-fifth"><label for="list_map">Enable Map:</label></div>
            <div class="two-fifths"><input type="checkbox" name="list_map" id="list_map"<?php if($list_map == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
            <div class="two-fifths description last">Enable map view on listings page?</div>
    
    		<div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="list_form">Search Form:</label></div>
            <div class="two-fifths"><select name="list_form" id="list_form">
            
            	<?php
				
					$args = array(
					
						'post_type' => 'search_form',
						'posts_per_page' => -1,
					
					);
					
					$tQ = new WP_Query($args);
					
					if($tQ->have_posts()) : while($tQ->have_posts()) : $tQ->the_post();
				
				?>
                
                	<option value="<?php the_ID(); ?>"<?php if(get_the_ID() == $list_form) { echo ' selected="selected"'; } ?>><?php the_title(); ?></option>
                
                <?php endwhile; wp_reset_postdata(); endif; ?>
            
            </select></div>
            <div class="two-fifths description last">Page slogan, displayed with your title.</div>
            
            <div class="clear"></div>
        
        </li>
        
        <li>
            
            <div class="one-fifth"><label for="submit_loggedin">Logged in Title:</label></div>
            <div class="two-fifths"><input type="text" name="submit_loggedin" id="submit_loggedin" value="<?php echo $submit_loggedin ?>" class="widefat" style="margin-bottom: 5px;" /></div>
            <div class="two-fifths description last">Page title when user is logged in</div>
    
    		<div class="clear"></div>
        
        </li>
    
    </ul>
    <!-- /.tabbed/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->

</div>