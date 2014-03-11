<?php if(ddp('pbl_contact_form') == 'on') : //// IF CONTACT FORM IS ENABLED ?>

	<?php if(get_post_meta(get_the_ID(), 'contact_form', true) == 'on' || ddp('pbl_force_contact') == 'on') : //// IF CONTACT FORM IS FREE AND IF THE USER HAS IT ON ?>
    
		<div class="sidebar-item spot-enquiry">

            <h4><?php echo sprintf2(__('Contact %spot_name:', 'btoa'), array('spot_name' => ddp('spot_name'))); ?></h4>
            
            <script type="text/javascript">
            
                jQuery(document).ready(function() {
                    
                    jQuery('#enquiry-form')._sf_spot_enquiry(<?php echo $post->ID ?>);
                    
                });
            
            </script>
            
            <form action="<?php echo home_url() ?>" method="post" id="enquiry-form">
            
            	<p><small class="error" style="margin-top: 15px; display: none;"></small></p>
            
                <p><input type="text" value="<?php _e('Your name', 'btoa'); ?>" name="name" id="enquiry-name" onfocus="if(jQuery(this).val() == '<?php _e('Your name', 'btoa'); ?>') { jQuery(this).val(''); }" onblur="if(jQuery(this).val() == '') { jQuery(this).val('<?php _e('Your name', 'btoa'); ?>'); }" /></p>
            
                <p><input type="text" value="<?php _e('Email address', 'btoa'); ?>" name="email" id="enquiry-email" onfocus="if(jQuery(this).val() == '<?php _e('Email address', 'btoa'); ?>') { jQuery(this).val(''); }" onblur="if(jQuery(this).val() == '') { jQuery(this).val('<?php _e('Email address', 'btoa'); ?>'); }" /></p>
            
                <p><textarea name="message" id="enquiry-message" cols="" rows="4" onfocus="if(jQuery(this).val() == '<?php _e('Message', 'btoa'); ?>') { jQuery(this).val(''); }" onblur="if(jQuery(this).val() == '') { jQuery(this).val('<?php _e('Message', 'btoa'); ?>'); }"><?php _e('Message', 'btoa'); ?></textarea></p>
                
                <p><input type="submit" class="button-primary" value="<?php _e('Send', 'btoa'); ?>" /></p>
                
                <div class="clear"></div>
                <!-- /.clear/ -->
                
                <div class="error-message"></div>
                
                <div class="thank-you hidden">
                
                    <p><?php _e('Thank you! Your message has been successfully sent.', 'btoa'); ?></p>
                
                </div>
                
            </form>
        
        </div>
    
    <?php endif; ?>

<?php endif; ?>