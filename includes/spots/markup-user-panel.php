
        
        <?php
		
			global $current_user;
        
            //////////////////////////////////////////////////////
            //// CUSTOM HEADER
            //////////////////////////////////////////////////////
			if(get_post_meta(get_the_ID(), 'header_bg', true) != '' && (get_post_meta(get_the_ID(), 'header_title', true) != '') || get_post_meta(get_the_ID(), 'fancy_slogan', true) != '') {
				
				/// INCLUDES CUSTOM HEADER
				get_template_part('includes/page/custom-header');
				
			}
			
			$steps = new SF_Tooltip();
			
			$steps->add_step('content', __('Welcome!', 'btoa'), __('This is your submissions admin page. Here you can manage your submissions and details and view your submissions page views.', 'btoa'));
			$steps->add_step('_sf_add_new_submission_button', __('Logout or Submit', 'btoa'), __('Click here to log out or start a new submission. After you start a new submission you can save it as draft for later or finish it up and submit straight away!', 'btoa'), NULL, 'right');
			$steps->add_step('_sf_edit_profile', __('Edit Profile', 'btoa'), __('Here you can edit your basic profile information. It is good to keep your profile up to date as this information is used whenever we get in contact with you', 'btoa'));
			$steps->add_step('_sf_change_password', __('Change Password', 'btoa'), __('Here you can also edit your password. If you have signed up via facebook your password was sent to your email.', 'btoa'));
			//// ADDS STEPS #
		
		?>
        
        
            
        <?php if(is_wp_error($_error)) : ?>
        
			<div id="message" class="error">
            
            	<div class="wrapper row"><div class="large-12 columns"><i class="icon-cancel-circle"></i><span><?php echo $_error->get_error_message(); ?></span></div></div>
            
            </div>
            <!-- /#message/ -->
            
        <?php elseif(isset($_GET['message'])) :
		
			if(ddp('pbl_publish') == 'on') { $message = __('Submission published!', 'btoa'); }
			else { $message = __('Submission successful!', 'btoa'); }
			
			if($_GET['message'] == 'success') :
		
		?>
        
			<div id="message" class="success">
            
            	<div class="wrapper row"><div class="large-12 columns"><i class="icon-cancel-circle"></i><span><?php echo $message; ?></span></div></div>
            
            </div>
            <!-- /#message/ -->
            
        <?php endif; else : ?>
        
			<div id="message" class="error" style="display: none;">
            
            	<div class="wrapper row"><div class="large-12 columns"><i class="icon-cancel-circle"></i><span></span></div></div>
            
            </div>
            <!-- /#message/ -->
		
		<?php endif; ?>
        
        
        
        <div id="content">
        
        	<div class="wrapper row">
        
        	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            
            	<div id="main-content" class="sidebar-right large-12">
                
                	<?php 
        
						//////////////////////////////////////////////////////
						//// USERS SUBMISSIONS
						//////////////////////////////////////////////////////
						
						get_template_part('includes/spots/markup', 'user-submissions');
						
					?>
                    
                    <div class="clear"></div>
                    <div class="divider-top" style="margin: 10px 0 40px;"></div>
                    
                    <div class="row" id="_sf_user_profile_fields">
                
						<?php 
            
                            //////////////////////////////////////////////////////
                            //// USER PROFILE
                            //////////////////////////////////////////////////////
                            
                            get_template_part('includes/spots/markup', 'user-profile');
                            
                        ?>
                
						<?php 
            
                            //////////////////////////////////////////////////////
                            //// PASSWORD CHANGE
                            //////////////////////////////////////////////////////
                            
                            get_template_part('includes/spots/markup', 'user-password');
                            
                        ?>
                    
                    </div>
                    <!-- /.row/ -->
                
                </div>
                <!-- /#main-content/ -->
                
                
            
            <?php endwhile; endif; ?>
			
			<?php $steps->generate_steps('_sf_tooltips_panel'); ?>
            
            </div>
            <!-- /.wrapper .row/ -->
        
        </div>
        <!-- /#content/ -->