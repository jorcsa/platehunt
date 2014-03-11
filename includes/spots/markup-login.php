
        
        <?php
        
            //////////////////////////////////////////////////////
            //// PAGE LAYOUT
            //////////////////////////////////////////////////////
			$page_layout = get_page_layout($post->ID);
			$content_class = '';
			switch($page_layout) {
				
				case 'right' :
					$content_class = 'large-8 columns';
					break;
				
				case 'left' :
					$content_class = 'large-8 columns';
					break;
				
				default :
					$content_class = 'large-12';
					break;
				
			}
		
		?>
        
        <?php
        
            //////////////////////////////////////////////////////
            //// CUSTOM HEADER
            //////////////////////////////////////////////////////
			if(get_post_meta(get_the_ID(), 'header_bg', true) != '' && (get_post_meta(get_the_ID(), 'header_title', true) != '') || get_post_meta(get_the_ID(), 'fancy_slogan', true) != '') {
				
				/// INCLUDES CUSTOM HEADER
				get_template_part('includes/page/custom-header');
				
			}
		
		?>
        
        <div id="content">
        
        	<div class="wrapper row">
        
        	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            
            	<div id="main-content" class="sidebar-<?php echo $page_layout; ?> <?php echo $content_class; ?>">
                
                	<div class="page-header large-12">
					
						<div class="left"><h2><?php _e('Hey There! Please login or register', 'btoa'); ?></h2></div>
                        <!-- /.left/ -->
                        
                        <div class="clear"></div>
                        <!-- /.clear/ -->
                        
                    </div>
                    <!-- /.page-header/ -->
                    
                    <?php the_content(); ?>
                    
                    <?php if(ddp('public_submissions') != 'on') : ?>
                    
                    	<h2><?php _e('Public submissions are now closed.', 'btoa'); ?></h2>
                    
                    <?php else : ?>
					
						<div class="clear"></div>
						<!-- .clear -->
							
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
											jQuery('#facebook-signup')._sf_fb_sign_up();
											
										}
									
									</script>
								
									<span id="facebook-signup" class="facebook-button">
									
										<i class="icon-facebook"></i>
										
										<?php _e('Login or Register with facebook', 'btoa'); ?>
									
									</span>
									<!-- #facebook-signup -->
									
									<div class="facebook-divider">
									
										<span class="text"><?php _e('Or', 'btoa'); ?></span>
										<span class="line"></span>
										
									</div>
									
									<?php endif; ?>
                    
                    <div class="row" id="_sf_login_row">
                    
                    <script type="text/javascript">
					
						jQuery(document).ready(function() {
							
							jQuery('#_sf_login')._sf_login();
							
							jQuery('#_sf_lost_password')._sf_lost_password();
							
							jQuery('#password-lost-button').click(function(e) {
								
								jQuery(this).fadeOut(300);
								jQuery('.large-6.register').slideUp(300);
								jQuery('.large-6.lost-password').slideDown(300);
								
								e.preventDefault();
								return false;
								
							});
							
						});
					
					</script>
                        
                        <?php
						
							//// IF WE HAVE A KEY CHECKS IT
							if(isset($_GET['key'])) {
								
								$key = $_GET['key'];
								
								//// TRIES TO GET USER BY KEY
								global $wpdb;
								$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_activation_key = '$key'");
								
							} else { $user = false; }
							
							
						?>
                        
                        <?php
							
							///// IF WE HAVE A USER
							if($user) : 
						
						?>
                    
                    <script type="text/javascript">
					
						jQuery(document).ready(function() {
							
							jQuery('#_sf_reset_password')._sf_reset_password();
							
						});
					
					</script>
                    
                    	<div class="large-6 columns lost-password">
                        
                        	<h3><?php _e('Reset Your Password', 'btoa'); ?></h3>
                            
                            <p><em><?php _e('Enter your new password.', 'btoa'); ?></em></p>
                            
                            <form id="_sf_reset_password" action="<?php echo home_url(); ?>" method="post">
                            
                            	<p>
                                
                                	<label for="_sf_new_password"><?php _e('New Password:', 'btoa'); ?></label>
           							<input type="password" name="password" id="_sf_new_password" />
                                
                                </p>
                            
                            	<p>
                                
                                	<label for="_sf_new_password_confirm"><?php _e('Confirm New Password:', 'btoa'); ?></label>
           							<input type="password" name="password_confirm" id="_sf_new_password_confirm" />
                                
                                </p>
                                
                                <div class="padding" style="height: 5px;"></div>
                                
                                <input type="hidden" name="username" value="<?php echo $user->user_login ?>" />
        
        						<p><input type="submit" value="<?php _e('Reset Password', 'btoa'); ?>" class="button-primary" /></p>
                            
                            </form>
                        
                        </div>
                        <!-- /.large6/ -->
                        
                        <?php endif; ?>
                        
                        
                        
                        
                    
                    	<div class="large-6 columns<?php if($user) : ?> hidden<?php endif; ?>">
                        
                        	<h3 class=""><?php _e('Login', 'btoa'); ?></h3>
                            
                            <p><em><?php _e('Login using your already existent credentials.', 'btoa'); ?></em></p>
                            
                            <form id="_sf_login" action="<?php echo home_url(); ?>" method="post">
                            
                            	<p>
                                
                                	<label for="_sf_login_username"><?php _e('Username:', 'btoa'); ?></label>
           							<input type="text" name="username" id="_sf_login_username" />
                                
                                </p>
                            
                            	<p>
                                
                                	<label for="_sf_login_password"><?php _e('Password:', 'btoa'); ?></label>
           							<input type="password" name="password" id="_sf_login_password" />
                                
                                </p>
                                
                                <div class="padding" style="height: 5px;"></div>
        
        						<p><input type="submit" value="<?php _e('Log in now', 'btoa'); ?>" class="button-primary" /></p>
                                
                                <p><a href="#" id="password-lost-button"><?php _e('Lost your password?', 'btoa'); ?> &rarr;</a></p>
                            
                            </form>
                        
                        </div>
                        <!-- /.large6/ -->
                    
                    	<div class="large-6 columns register<?php if($user) : ?> hidden<?php endif; ?>">
						
							<?php
								
								/**
								 * sf_login_user_registration hook
								 *
								 * @hooked sf_template_registration_form - 10
								 */
							
								do_action('sf_login_user_registration');
								
								
							?>
                        
                        &nbsp;</div>
                        <!-- /.large6/ -->
                        
                        <?php if(!$user) : ?>
                    
                    	<div class="large-6 columns lost-password hidden">
                        
                        	<h3><?php _e('Recover Your Password', 'btoa'); ?></h3>
                            
                            <p><em><?php _e('Enter your username or email address.', 'btoa'); ?></em></p>
                            
                            <form id="_sf_lost_password" action="<?php echo home_url(); ?>" method="post">
                            
                            	<p>
                                
                                	<label for="_sf_email_user"><?php _e('Email Address or Username:', 'btoa'); ?></label>
           							<input type="text" name="email_user" id="_sf_email_user" />
                                
                                </p>
                                
                                <div class="padding" style="height: 5px;"></div>
        
        						<p><input type="submit" value="<?php _e('Recover Password', 'btoa'); ?>" class="button-primary" /></p>
                            
                            </form>
                        
                        </div>
                        <!-- /.large6/ -->
                        
                        <?php endif; ?>
                    
                    </div>
                    <!-- /.row/ -->
                    
                    <?php endif; ?>
                	
                
                </div>
                <!-- /#main-content/ -->
                
                <?php 
				
					//// LEFT SIDEBAR IF IS SET
					if($page_layout == 'left') {
						
						echo '<div id="sidebar-left" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'page');
						echo '</div>';
						
					}
				
					//// RIGHT SIDEBAR IF IS SET
					if($page_layout == 'right') {
						
						echo '<div id="sidebar-right" class="large-4 columns">';
						get_page_custom_sidebar($post->ID, 'page');
						echo '</div>';
						
					}
					
						
				?>
            
            <?php endwhile; endif; ?>
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->