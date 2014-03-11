<?php


	//// REGISTERS OUR WIDGETS
	add_action( 'widgets_init', create_function( '', 'register_widget( "rb_signup" );' ) );
	
	
	//// OUR WIDGET CLASS
	class rb_signup extends WP_Widget {
		
		////////////////////////////////////////////////////////////
		//// REGISTER WIDGET WITH WORDPRESS
		public function __construct() {
			
			parent::__construct(
			
				'rb_signup_view', // BASE ID
				__('Sign-up/Login Form', ''), // NAME
				array('description' => __('Shows a sign-up/login form', '')) // DESCRIPTION
			
			);
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// FRONT-END FUNCTION
		public function widget($args, $instance) {
			
			global $wpdb, $post;
			
			//// EXTRACT OUR INPUTS
			extract($args);
			extract($instance);
			
			//// IF USER LOGGED IN DO NOT SHOW THIS
			if(is_user_logged_in()) { return false; }
				
			echo $before_widget;
			
			if($title != '') { echo $before_title.$title.$after_title; } ?>
			
				<script type="text/javascript">
				
					jQuery(document).ready(function() {
						
						jQuery('._sf_login_sign_up_widget')._sf_login_widget_tabs();
						
						<?php if(ddp('public_submissions_register') == 'on') : ?>jQuery('#_sf_widget_signup')._sf_login_widget_signup();<?php endif; ?>
						
						jQuery('#_sf_widget_login')._sf_login_widget_login();
						
					});
				
				</script>
				
				<?php if(ddp('fb_login_app_id') != '') : ?>
								
					<div id="fb-root"></div>
				
					<script type="text/javascript">
					
						//// FIRST THE FB SDK
						(function(d){
						var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
						if (d.getElementById(id)) {return;}
						js = d.createElement('script'); js.id = id; js.async = true;
						js.src = "//connect.facebook.net/en_US/all.js";
						ref.parentNode.insertBefore(js, ref);
						}(document));
						
						///// CHECKS IF THE USER HAS ALREADY SIGNED IN WITH FACEBOOK
						window.fbAsyncInit = function() {
							
							//// INITIALIZES THE APP
							FB.init({
								appId      : '<?php echo ddp('fb_login_app_id'); ?>', // App ID
								//channelUrl : '//', // Channel File
								status     : true, // check login status
								cookie     : true, // enable cookies to allow the server to access the session
								xfbml      : true  // parse XFBML
							});
							
							//FB.Event.subscribe('auth.authResponseChange', function(response) {
								
								//// IF THE USER HAS ALREADY AUTHORISED THE APP LETS LOG HIM IN
								//if(response.status === 'connected') {
									
									//jQuery('#facebook-signup')._sf_fb_log_in(response);
									
								//}
								
							//});
							
							//// ENABLE USER TO SIGN UP/IN WITH FACEBOOK BUTTON
							jQuery('.button-facebook')._sf_fb_sign_up_widget();
							
						}
					
					</script>
				
				<?php endif; ?>
			
				<div class="_sf_login_sign_up_widget">
				
					<ul class="tabs">
					
						<?php if(ddp('public_submissions_register') == 'on') : ?><li class="current"><?php _e('Sign Up', 'btoa'); ?></li><?php endif; ?>
					
						<li class="<?php if(ddp('public_submissions_register') == 'on') : ?>other<?php else : ?>current<?php endif ?>"><?php _e('Log In', 'btoa'); ?></li>
					
					</ul>
					<!-- .tabs -->
					
					<div class="clear"></div>
					
					<ul class="tabbed">
					
						<?php if(ddp('public_submissions_register') == 'on') : ?>
					
						<li class="current">
						
							<form id="_sf_widget_signup" action="<?php echo home_url() ?>" method="POST">
							
								<p style="margin: 10px 0 0; display: none;"><small class="error"></small></p>
							
								<p><label for="_sf_widget_signup_username"><?php _e('Username', 'btoa'); ?></label>
								<input type="text" name="username" id="_sf_widget_signup_username" value="" /></p>
								
								<div class="form-divider"></div>
							
								<p><label for="_sf_widget_signup_email"><?php _e('Email Address', 'btoa'); ?></label>
								<input type="email" name="email" id="_sf_widget_signup_email" value="" /></p>
								
								<p><input type="submit" class="button-primary" value="Sign Up" />
								
								<?php if(ddp('fb_login_app_id') != '') : ?><span class="button-primary button-facebook right"><i class="icon-facebook"></i> Sign up with facebook</span><?php endif; ?></p>
								
								<div class="clear"></div>
							
							</form>
							<!-- #_sf_widget_signup -->
						
						</li>
						<!-- .current -->
						
						<?php endif; ?>
					
						<li<?php if(ddp('public_submissions_register') != 'on') : ?> class="current"<?php endif ?>>
						
							<form id="_sf_widget_login" action="<?php echo home_url() ?>" method="POST">
							
								<p style="margin: 10px 0 0; display: none;"><small class="error"></small></p>
							
								<p><label for="_sf_widget_login_username"><?php _e('Username', 'btoa'); ?></label>
								<input type="text" name="username" id="_sf_widget_login_username" value="" /></p>
								
								<div class="form-divider"></div>
							
								<p><label for="_sf_widget_login_password"><?php _e('Password', 'btoa'); ?></label>
								<input type="password" name="password" id="_sf_widget_login_password" value="" /></p>
								
								<p><input type="submit" class="button-primary" value="Log In" /> <?php if(ddp('fb_login_app_id') != '') : ?><span class="button-primary button-facebook right"><i class="icon-facebook"></i> Log In with facebook</span><?php endif; ?></p>
								
								<div class="clear"></div>
							
							</form>
							<!-- #_sf_widget_signup -->
						
						</li>
						<!-- .current -->
					
					</ul>
					<!-- .tabbed -->
				
				</div>
				<!-- ._sf_login_sign_up_widget -->
			
			
			<?php echo $after_widget;
			
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// BACK-END FUNCTION
		public function form($instance) {
			
			$defaults = array(
			
				'title' => '',
			
			);
			
			
			$instance = wp_parse_args((array) $instance, $defaults);
			
			//// OUR FORM ?>
                
            	<p>
                
                	<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
                	<input type="text" value="<?php echo $instance['title']; ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat">
                
                </p>
            
            <?php
			
		}
		
		
		////////////////////////////////////////////////////////////
		//// SAVE FUNCTION
		public function update($new, $old) {
			
			//// NEW INSTANCE ARRAY
			$instance = array();
			
			//// OUR FIELDS
			$instance['title'] = strip_tags($new['title']);
			
			//// SAVES OUR FIELDS
			return $instance;
			
		}
		
		
	}


?>