<?php

	global $current_user;

?>

<div class="large-8 columns">

	<h3><?php _e('Edit your profile', 'btoa'); ?></h3>
    
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			//// WHEN SUER SUBMITS THIS FORM
			jQuery('#_sf_edit_profile').submit(function(e) {
				
				var formCont = jQuery(this);
				var button = formCont.find('input[type="submit"]');
				var firstName = formCont.find('input[name="user_first_name"]');
				var lastName = formCont.find('input[name="user_last_name"]');
				var email = formCont.find('input[name="user_email"]');
				
				//// ADDS SPINNING SIGN
				formCont.children('*').stop().animate({ opacity: .3 });
				button.attr('disabled', 'disabled');
				formCont.spin({ lines: 9, length: 7, width: 4, radius: 8, corners: 1, speed: 1.9 });
				formCont.find('small.error, p.error small').remove();
				formCont.find('p.error').removeClass('error');
				
				//// DOES OUR AJAX QUERY
				jQuery.ajax({
					
					url: 			sf_us.ajaxurl,
					type: 			'post',
					dataType: 		'json',
					data: {
						
						action: 	'_sf_edit_profile',
						nonce: 		sf_us._sf_edit_profile_nonce,
						data: 		formCont.serialize(),
						user_id: 	<?php echo $current_user->ID ?>
						
					},
					success: function(data) {
								
						formCont.children('*').stop().animate({ opacity: 1 });
						button.removeAttr('disabled');
						formCont.spin(false);
						
						/// IF ERRORS
						if(data.error) {
							
							//// GOES THROUGH THE ARRAY OF ERRORS
							jQuery.each(data.error_field, function(i, field) {
								
								//// IF CRITICAL ERROR
								if(field.container == 'form') {
									
									//// ADDS ERROR TO THE CONTAINER AND DISPLAYS THE TOOLTIP
									formCont.prepend('<small class="error">'+field.message+'</small>');
									formCont.children('small').fadeIn(300);
									
								} else {
									
									//// ADDS ERROR TO THE CONTAINER AND DISPLAYS THE TOOLTIP
									formCont.find('input[name="user_'+field.container+'"]').parent().addClass('error').append('<small>'+field.message+'</small>');
									formCont.find('input[name="user_'+field.container+'"]').siblings('small').fadeIn(300);
									
								}
								
							});
							
						} else {
							
							//// SHOWS SUCCESS MESSAGE
							formCont.prepend('<small class="success"><?php _e('Profile edited successfully.', 'btoa'); ?></small>');
							formCont.children('small').fadeIn(300, function() { jQuery(this).delay(3000).fadeOut(300, function() { jQuery(this).remove(); }); });
							formCont.find('input[type="password"]').val('');
							
							
							
						}
						
					}
					
				});
				
				//// PREVENTS NON AJAX SUBMISSIONS
				e.preventDefault();
				return false;
				
			});
			
		});
	
	</script>

	<form action="<?php echo home_url(); ?>" method="post" id="_sf_edit_profile">
	
		<?php if(ddp('pbl_profile') == 'on') : ?>
		<div class="one-half">
		<?php endif; ?>
    
    	<p>
        
        	<label for="user_first_name"><?php _e('First Name', 'btoa'); ?></label>
            <input type="text" name="user_first_name" id="user_first_name" value="<?php echo $current_user->first_name ?>" />
        
        </p>
    
    	<p>
        
        	<label for="user_last_name"><?php _e('Last Name', 'btoa'); ?></label>
            <input type="text" name="user_last_name" id="user_last_name" value="<?php echo $current_user->last_name ?>" />
        
        </p>
    
    	<p>
        
        	<label for="user_email"><?php _e('Email Address', 'btoa'); ?></label>
            <input type="email" name="user_email" id="user_email" value="<?php echo $current_user->user_email ?>" />
        
        </p>
        
        
		
		<?php if(ddp('pbl_profile') == 'on') : ?>
    
    	<p>
        
        	<label for="phone"><?php _e('Phone Number', 'btoa'); ?></label>
            <input type="text" name="phone" id="phone" value="<?php echo get_the_author_meta( 'phone', $current_user->ID ) ?>" />
        
        </p>
    
    	<p>
        
        	<label for="position"><?php _e('Title / Position', 'btoa'); ?></label>
            <input type="text" name="position" id="position" value="<?php echo get_the_author_meta( 'position', $current_user->ID ) ?>" />
        
        </p>
		
			<p><input type="submit" value="<?php _e('Update Profile', 'btoa'); ?>" class="button-primary" /></p>
		
			</div>
			<!-- .one-half -->
			
			<div class="one-half last">
			
				<div id="_sf_user_profile">
				
					<script type="text/javascript">
					
						jQuery(document).ready(function() {
												
							//// UPLOAD IMAGE
							jQuery('#_sf_user_profile')._sf_upload_profile_pic(<?php echo $spot_id; ?>);
							
						});
					
					</script>
				
					<?php
					
						//// USER PROFILE IMAGE
						$user_picture = _sf_get_user_profile_pic($current_user->ID);
					
					?>
				
					<div id="_sf_user_profile_image"><img src="<?php echo ddTimthumb($user_picture, 92, 108) ?>" alt="" title="" /></div>
					<!-- #_sf_user_profile_image -->
					
					<input type="hidden" name="profile_pic" id="_sf_user_profile_pic" value="<?php echo get_the_author_meta( 'profile_pic', $user->ID ) ?>" />
					
					<h4>Profile Picture</h4>
					
					<span class="upload-bar-file" style="display: none;"></span><div class="upload-bar" style="display: none; margin-bottom: 15px;"><span></span></div>
                                        
					<span class="button-secondary button-small" id="_sf_user_profile_pic_upload_button" style="cursor: pointer; position: relative;">
						
						<?php _e('Upload Picture', 'btoa'); ?>
					   <input type="file" value="<?php _e('Upload Picture', 'btoa'); ?>" class="button-secondary" name="_sf_user_profile_pic_upload" id="_sf_user_profile_pic_upload" style="display: block; opacity: 0; position: absolute; left: 0; top: 0; width: 100%; height: 100%; cursor: pointer !important;" />   
					   
				   </span><br>
				   
					<span class="button-secondary button-small" id="_sf_user_profile_pic_remove"><?php _e('Remove', 'btoa'); ?></span>
					
					<div class="clear"></div>
					<!-- .clear -->
				
				</div>
				<!-- #_sf_user_profile -->
    
				<p>
				
					<label for="user_description"><?php _e('Short Bio (250 chars)', 'btoa'); ?></label>
					<textarea name="description" id="user_description" rows="" cols="" maxlength="250"><?php echo esc_attr(get_the_author_meta( 'description', $current_user->ID )) ?></textarea>
				
				</p>
				
				<div id="_sf_user_profile_public">
				
					<input type="checkbox" name="public_profile" id="public_profile" <?php if(get_the_author_meta( 'public_profile', $current_user->ID ) == 'on') { echo 'checked="checked"'; } ?> />
					<?php _e('Check this box to make your profile publicly available on your listings page.', 'btoa'); ?>
				
				</div>
				<!-- .show-profile -->
			
			</div>
			<!-- .one-half -->
			
			<div class="clear"></div>
			<!-- .clear -->
			
		<?php else : ?>
		
			<p><input type="submit" value="<?php _e('Update Profile', 'btoa'); ?>" class="button-primary" /></p>
			
		<?php endif; ?>
    
    </form>

</div>