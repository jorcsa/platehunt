<?php

	global $current_user;

	//// LETS FIRST GET ALL THE SPOTS BY THIS USER
	$args = array(
	
		'post_type' => 'spot',
		'posts_per_page' => -1,
		'author' => $current_user->ID,
		'post_status' => array('publish', 'pending', 'draft'),
	
	);
	
	$tQ = new WP_Query($args); ?>
	
	
                
    <div class="page-header" id="submissions_page_header">
    
        <div class="left"><h2><?php _e('Welcome back', 'btoa'); ?> <?php echo $current_user->display_name; ?></h2></div>
        <!-- /.left/ -->
        
        <div class="right" id="_sf_add_new_submission_button" style="padding-left: 15px;">
        
            <a href="#" class="logout button-secondary" onclick="jQuery(this)._sf_logout(event);"><?php _e('Logout', 'btoa'); ?></a>
            <?php if(ddp('public_submissions') == 'on' && $tQ->found_posts < ddp('pbl_count')) : ?><a href="<?php echo add_query_arg('action', 'add-new'); ?>" class="addnew button-primary"><?php _e('Submit New', 'btoa'); ?></a><?php endif; ?>
        
        </div>
        <!-- /.right/ -->
        
        <div class="clear"></div>
        <!-- /.clear/ -->
        
    </div>
    <!-- /.page-header/ -->
	
<?php
	
	if($tQ->have_posts()) :

?>

		<?php include(locate_template('includes/spots/markup-spot-views.php')); ?>
	
        <ul id="user-spots-header" class="large-12 columns">
        
            <li class="large-4 columns"><?php _e('Your Submissions', 'btoa'); ?></li>
        
            <li class="large-2 columns"><?php _e('Submitted on', 'btoa'); ?></li>
        
            <li class="large-2 columns"><?php _e('Status', 'btoa'); ?></li>
        
            <li class="large-2 columns"><?php _e('Page Views:', 'btoa'); ?></li>
        
            <li class="large-2 columns"><?php _e('Actions', 'btoa'); ?></li>
        
        </ul>
	
        <ul id="user-spots" class="large-12 columns">
    
        <?php while($tQ->have_posts()) : $tQ->the_post(); ?>
        
        	<li>
            
            	<div class="large-4 columns spot-title">
					
					<?php if(get_post_meta(get_the_ID(), 'featured', true) == 'on') : ?><h5 class="sticky-featured"><span><?php _e('Featured', 'btoa'); ?></h5></span><?php endif; ?>
								
					<a href="<?php echo add_query_arg(array('action' => 'edit','id' => get_the_ID())); ?>" class="edit-post" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					<?php if($post->post_status == 'publish') : ?>&nbsp;&nbsp;&nbsp;<a href="<?php echo get_permalink($post->ID) ?>" target="_blank"><small><?php _e('View Listing', 'btoa'); ?></small></a><?php endif; ?>
					
					<div class="clear"></div>
					
				</div>
                
                <div class="large-2 columns spot-date"><?php the_time(get_option('date_format')); ?>
                <?php if(get_post_meta(get_the_ID(), 'expiry_date', true) != '') : ?><br /><strong><?php _e('Expires:', 'btoa'); ?></strong> <?php echo date(get_option('date_format'), get_post_meta(get_the_ID(), 'expiry_date', true)); ?><?php endif; ?>
                <?php if(get_post_meta(get_the_ID(), 'featured', true) == 'on' && get_post_meta(get_the_ID(), 'featured_payment_expire', true) != '') : ?><br /><strong><?php _e('Featured Until:', 'btoa'); ?></strong> <?php echo date(get_option('date_format'), get_post_meta(get_the_ID(), 'featured_payment_expire', true)); ?><?php endif; ?></div>
                
                <div class="large-2 columns spot-status"><?php echo get_spot_status(get_the_ID()); ?></div>
                
                <div class="large-2 columns spot-views" style="text-align: left;"><?php if($post->post_status != 'publish') { echo '-'; } else { $views = get_post_meta(get_the_ID(), '_sf_view_count', true); if($views == '') { echo '0'; } else { echo $views; } } ?></div>
                
                <div class="large-2 columns spot-actions">
                
                	<?php if(ddp('pbl_enable_editing') == 'on') : ?><a href="<?php echo add_query_arg(array('action' => 'edit','id' => get_the_ID())); ?>" class="button-secondary button-small"><?php _e('Edit', 'btoa'); ?></a><?php endif; ?>
                	<a href="#" class="button-secondary button-small" onclick="var cD = confirm('<?php _e('Are you sure you want to trash your submission?', 'btoa'); ?>'); if(cD) { jQuery(this)._sf_delete_submission(<?php the_ID(); ?>); }"><?php _e('Delete', 'btoa'); ?></a>
					
					<?php
					
						global $sitepress;
						if(isset($sitepress)) {
						
							//// WE ALSO NEED TO DO OUR TRANSLATION ENTRIES
							foreach($sitepress->get_active_languages() as $lang => $details) {
								
								//// IF NOT CURRENT LANGUAGE
								if($lang != $sitepress->get_default_language()) {
				
									//// GETS THE TRANSLATED POST FOR THIS LANGUAGE
									$translation_id = icl_object_id(get_the_ID(), 'spot', false, $lang);
									
									//// GETS FLAG
									$flag = _sf_get_flag($sitepress->get_flag($lang));
									
									//// DISPLAYSI THE BUTTON
									?>
									
									<br><a href="<?php echo add_query_arg(array('action' => 'edit','id' => $translation_id)); ?>" class="button-secondary button-small"><img src="<?php echo $flag ?>" alt="" title="" style="margin: 4px 0 0 0; float: left;" /> &nbsp;<?php _e('Edit Translation', 'btoa'); ?></a>
									
								<?php }
								
								
							}  // ENDS FOREACH
						
						}	
						
					?>
                
                </div>
                
                <div class="clear"></div>
                <!-- /.clear/ -->
            
            </li>
        
        <?php endwhile; ?>
        
        </ul>
        <!-- /#user-spots/ -->
		
		
<?php else:  ?>

 <ul id="user-spots-header" class="large-12 columns" style="margin-bottom: 20px;">

        
        	<li>
            
            	<div class="large-12 columns" style="text-align: center;"><?php _e('Oops! You have not submitted anything yet.', 'btoa'); ?><?php if(ddp('public_submissions') == 'on' && $tQ->found_posts < ddp('pbl_count')) : ?> <a href="<?php echo add_query_arg('action', 'add-new'); ?>"><?php _e('Begin your first submission &rarr;', 'btoa'); ?></a><?php endif; ?></div>
            
            </li>
        </ul>
        <!-- /#user-spots/ -->
<?php endif; ?>