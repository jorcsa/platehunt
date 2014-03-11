<?php

	global $current_user;

?>

<div class="large-4 columns">

	<h3><?php _e('Change Password', 'btoa'); ?></h3>
    
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			//// WHEN SUER SUBMITS THIS FORM
			jQuery('#_sf_change_password').submit(function(e) {
				
				var formCont = jQuery(this);
				var button = formCont.find('input[type="submit"]');
				var newPass = formCont.find('input[name="new_password"]');
				var confirmNewPass = formCont.find('input[name="new_password_confirm"]');
				var oldPass = formCont.find('input[name="old_password"]');
				
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
						
						action: 			'_sf_change_password',
						nonce: 				sf_us._sf_change_password_nonce,
						new_pass: 			newPass.val(),
						new_pass_confirm: 	confirmNewPass.val(),
						old_pass: 			oldPass.val(),
						user_id: 			<?php echo $current_user->ID ?>
						
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
									formCont.find('input[name="'+field.container+'"]').parent().addClass('error').append('<small>'+field.message+'</small>');
									formCont.find('input[name="'+field.container+'"]').siblings('small').fadeIn(300);
									
								}
								
							});
							
						} else {
							
							//// SHOWS SUCCESS MESSAGE
							formCont.prepend('<small class="success"><?php _e('Password changed successfully. Redirecting you...', 'btoa'); ?></small>');
							formCont.children('small').fadeIn(300, function() { jQuery(this).delay(3000).fadeOut(300, function() {window.location.href=window.location.href; jQuery(this).remove(); }); });
							
							
							
						}
						
					}
					
				});
				
				//// PREVENTS NON AJAX SUBMISSIONS
				e.preventDefault();
				return false;
				
			});
			
			
		});
	
	</script>

	<form action="<?php echo home_url(); ?>" method="post" id="_sf_change_password">
    
    	<p>
        
        	<label for="new_password"><?php _e('New Password', 'btoa'); ?></label>
            <input type="password" name="new_password" id="new_password" value="" class="" />
        
        </p>
    
    	<p>
        
        	<label for="new_password_confirm"><?php _e('Confirm New Password', 'btoa'); ?></label>
            <input type="password" name="new_password_confirm" id="new_password_confirm" value="" />
        
        </p>
    
    	<p>
        
        	<label for="old_password"><?php _e('Current Password', 'btoa'); ?></label>
            <input type="password" name="old_password" id="old_password" value="" />
        
        </p>
        
        <p><input type="submit" value="<?php _e('Change Password', 'btoa'); ?>" class="button-primary" /></p>
    
    </form>

</div>