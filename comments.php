<?php

	
	////////////////////////////////////////
	// KILLS THE SCRIPT IF OPEN DIRECTLY
	////////////////////////////////////////
	if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
		
		die(__('Please do not load this page directly. Thanks!', 'btoa'));
		
	}
	
	include('includes/blog/comments-markup.php');
	
?>

    <div id="comments">
    
    	
        <?php if(post_password_required()) : //// IF REQUIRES PASSWORD ?>
        
        	<h3><?php _e('This post is password protected. Enter the password to view comments.', 'btoa'); ?></h3>
        
        <?php endif; ?>
        
        
        
        <?php
			
			//LOADS OUR GLOBALS
			global $id;
			$id = $post->ID;
			
			if(have_comments()) :
		
		?>
        
        	<h3><?php comments_number(__('No response to', 'btoa'), __('One response to', 'btoa'), __('% responses to', 'btoa') ); ?> &quot;<?php the_title(); ?>&quot;</h3>
    
            <ol>
            
                <?php wp_list_comments('avatar_size=60&style=ul&callback=btoaCommentTemplate'); ?>
            
            </ol>
            
            <div class="left comment-pagination"><?php previous_comments_link(); ?></div>
            <div class="right comment-pagination"><?php next_comments_link(); ?></div>
        
        
        <?php else : ?>
        
        	<h3><?php _e('There are no responses so far.', 'btoa'); ?></h3>
        
        <?php endif; ?>
        
    
    </div>
    <!-- /#comments/ -->
    
    <?php comment_form(); ?>