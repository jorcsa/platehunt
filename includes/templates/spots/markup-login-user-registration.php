<?php
/**
 * Template for the registration form in login page 
 *
 * @author BTOA
 * @version 1.35.3
 */
 ?>
                        
<?php if(ddp('public_submissions_register') == 'on') : ?>

		<script type="text/javascript">
		
			jQuery(document).ready(function() {
				
				jQuery('#_sf_register')._sf_register();
				
			});
		
		</script>

		<h3><?php _e('Register', 'btoa'); ?></h3>
	
		<p><em><?php _e('Your password will be emailed to you.', 'btoa'); ?></em></p>
		
	
	<form id="_sf_register" action="<?php echo home_url(); ?>" method="post">
	
		<p>
		
			<label for="_sf_register_username"><?php _e('Username:', 'btoa'); ?></label>
			<input type="text" name="username" id="_sf_register_username" />
		
		</p>
	
		<p>
		
			<label for="_sf_register_email"><?php _e('Email:', 'btoa'); ?></label>
			<input type="email" name="email" id="_sf_register_email" />
		
		</p>
		
		<div class="padding" style="height: 5px;"></div>

		<p><input type="submit" value="<?php _e('Sign Up', 'btoa'); ?>" class="button-primary" /></p>
	
	</form>
	
<?php else: ?>
	
	<h3><?php _e('Registrations are currently closed.', 'btoa'); ?></h3>
	
<?php endif; //// ENDS IF USERS ARE ABLE TO REGISTER ?>