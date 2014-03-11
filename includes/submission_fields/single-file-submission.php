<div class="submission-field-file">

	<h4><strong><?php the_title() ?></strong></h4>
	
	<?php
	
		///// LETS GET A LIST OF ALL FILES
		$files = json_decode(htmlspecialchars_decode(get_post_meta($post_id, '_sf_submission_field_'.get_the_ID(), true)));
		
		if(is_object($files)) {
			
			echo '<ul>';
			
			foreach($files as $file) { ?>
				
				<li>
				
					<div class="one-fifth">
						
						<i class="icon-doc"></i>
						<span class="filetype"><?php echo get_post_mime_type($file->ID) ?></span>
						<span class="filesize"><?php echo $file->size; ?></span>
					
					</div>
					<!-- .one-fifth -->
					
					<div class="four-fifths last">
					
						<h4><strong><?php echo $file->title; ?></strong></h4>
						<p><?php echo $file->desc; ?></p>
						<p><a href="<?php echo wp_get_attachment_url($file->ID) ?>" class="button-primary button-small" target="_blank"><?php _e('Download File', 'btoa'); ?></a></p>
					
					</div>
					<!-- .four-fifths -->
					
					<div class="clear"></div>
					<!-- .clear -->
				
				</li>
				
			<?php }
			
			echo '</ul>';
			
		} else {
			
			echo __('No files to display.', 'btoa');
			
		}
	
	?>

</div>
<!-- .submission-field-text -->