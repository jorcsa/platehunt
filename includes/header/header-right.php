<?php

	//// CUSTOM HTML
	if(ddp('social_icons_alt') != '') { echo ddp('social_icons_alt'); }

	///// IF WE HAVE SOCIAL ICONS ENABLED
	if(ddp('social_icons') == 'on') :

?>

	<ul id="social">
    
    	<?php if(ddp('social_facebook') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_facebook') ?>" class="social-facebook" title="<?php echo get_bloginfo('name'); ?> Facebook"><i class="icon-facebook"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_twitter') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_twitter') ?>" class="social-twitter" title="<?php echo get_bloginfo('name'); ?> Twitter"><i class="icon-twitter"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_vimeo') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_vimeo') ?>" class="social-vimeo" title="<?php echo get_bloginfo('name'); ?> Vimeo"><i class="icon-vimeo"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_google') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_google') ?>" class="social-google" title="<?php echo get_bloginfo('name'); ?> Google Plus"><i class="icon-gplus"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_pinterest') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_pinterest') ?>" class="social-pinterest" title="<?php echo get_bloginfo('name'); ?> Pinterest"><i class="icon-pinterest"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_tumblr') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_tumblr') ?>" class="social-tumblr" title="<?php echo get_bloginfo('name'); ?> Tumblr"><i class="icon-tumblr"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_linkedin') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_linkedin') ?>" class="social-linkedin" title="<?php echo get_bloginfo('name'); ?> LinkedIn"><i class="icon-linkedin"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_dribbble') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_dribbble') ?>" class="social-dribbble" title="<?php echo get_bloginfo('name'); ?> Dribbble"><i class="icon-dribbble"></i></a></li><?php endif; ?>
    
    	<?php if(ddp('social_instagram') != '') : //// FACEBOOK ?><li><a href="<?php echo ddp('social_instagram') ?>" class="social-instagram" title="<?php echo get_bloginfo('name'); ?> Instagram"><i class="icon-instagramm"></i></a></li><?php endif; ?>
    
    </ul>
    <!-- /.social/ -->

<?php endif; ?>