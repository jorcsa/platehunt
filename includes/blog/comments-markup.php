<?php

	
	///////////////////////////////////
	// OUR COMMENTS TEMPLATE
	///////////////////////////////////
	
	function btoaCommentTemplate($comment, $args, $depth) {
		
		//LOADS OUR GLOBAL
		$GLOBALS['comment'] = $comment;
		
		?>
        
                            
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            
            	<div class="comment-info">
                                
                    <?php echo get_avatar( get_comment_author_email(), 60 ); ?>
                    
                </div>
                <!-- /.comment-info/ -->
                                
                <div class="comment-content">
                    
                    <span class="author"><?php comment_author_link()?></span>
                    
                    <span class="date"><?php comment_time(__('M d, Y', 'btoa')); ?> at <?php comment_time(__('H:i', 'btoa')); ?></span>
                    
                    <br />
                
                     <?php comment_text(); ?>
                     
                     <?php if($comment->comment_approved == '0') { echo '<p><em>'.__('Your comment is awaiting approval.', 'btoa').'</em></p>'; } ?>
                     
                    <span class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span></p>
                
                </div>
                <!-- /.comment-content/ -->
                
                <div class="clear"></div>
            
        
		<?php
            
        }
	
?>