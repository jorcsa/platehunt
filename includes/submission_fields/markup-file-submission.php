<?php

	$field = get_post($field_id);
									
	//// GETS THE CATEGORIES TO BE SHOWN
	$show_cats = get_post_meta($field_id, 'field_category', true);
	$show_cats_class = '';
	
	//// GOES THROUGH THEM AND ADDS IT AS A CLASS
	if(!is_array($show_cats)) { $show_cats = array('all'); }
	foreach($show_cats as $_show_cat) { $show_cats_class .= $_show_cat.'_'; }
	$show_cats_class = trim($show_cats_class, '_');
	
	$accordion_class = '_sf_submission_field';
	if($position == 'before_search_fields' || $position == 'after_search_fields') { $accordion_class = '_sf_box_accordion'; }
	
	///// CURRENT VALUE
	$sel_val = htmlspecialchars_decode(get_post_meta($spot_id, '_sf_submission_field_'.$field->ID, true));

?>

<div class="_sf_box <?php echo $accordion_class; ?> _sf_box_field_<?php echo $field_id ?> <?php echo $show_cats_class; ?>" id="_sf_submission_field_box_<?php echo $field->ID; ?>">

	<div class="head">
	
		<div class="left"><?php echo $field->post_title ?></div>
		<!-- .left -->
		
		<div class="clear"></div>
		<!-- .clear -->
		
	</div>
	<!-- .head -->
	
	<div class="inside">
		
		<div class="left" style="width: 70%; padding: 10px 0 0;">
		
			<?php if($field->post_content != '') : ?><p style="margin-bottom: 0;"><em><?php echo $field->post_content; ?></em></p><?php endif; ?>
		
		</div>
		<!-- .left -->
		
		<div class="right">
									
			<span class="button-secondary" id="_sf_upload_file_submission_<?php echo $field->ID ?>" style="cursor: pointer; position: relative;">
				
				<?php _e('Upload File', 'btoa'); ?>
			   <input type="file" value="Upload File" class="button-secondary" name="_sf_upload_file_submission_<?php echo $field->ID ?>[]" id="_sf_upload_file_submission_<?php echo $field->ID ?>" multiple style="display: block; opacity: 0; position: absolute; left: 0; top: 0; width: 100%; height: 100%; cursor: pointer !important;" />  
			   
		   </span>
		
		</div>
		
		<div class="clear"></div>
		<!-- .clear -->
		
		<div class="clear"></div><span class="upload-bar-file" style="display: none;"></span><div class="upload-bar" style="display: none;"><span></span></div>
		
		<input type="hidden" name="_sf_submission_field_<?php echo $field->ID; ?>" id="_sf_submission_field_<?php echo $field->ID; ?>_attachments" value="<?php echo htmlspecialchars(get_post_meta($spot_id, '_sf_submission_field_'.$field->ID, true)); ?>" />
		
		<ul class="_sf_submission_field_file_list<?php if(get_post_meta($field->ID, 'required', true) == 'on') { echo ' required-file'; } ?>" id="_sf_submission_field_<?php echo $field->ID; ?>_list">
		
		
		
		
		
			<?php
			
				//// LETS TRY AND LOOP OUR FIELD
				$files = json_decode($sel_val);
				
				//// IF ITS AN OBJECT WITH VALUES IN IT
				if(is_object($files)) :
					
					//// LOOPS THEM
					foreach($files as $_file) :
					
					//// IF ITS AN ATTACHMENT
					if(wp_get_attachment_url($_file->ID)) :
			
			?>
			
				<li class="_sf_box">
															
					<div class="head">
					
						<div class="left"><?php echo $_file->title; ?></div>
						
						<div class="right close" onclick="jQuery(this)._sf_submission_file_remove(event);"><i class="icon-cancel"></i></div>
						
						<div class="clear"></div>
						
					</div>
					
					<div class="inside" style="display: block;">
					
						<div class="one-fifth _sf_submission_file_description">
						
							<i class="icon-doc"></i>
							<span class="filetype"><?php echo get_post_mime_type($_file->ID) ?></span>
							<span class="filesize"><?php echo $_file->size; ?></span>
						
						</div>
						<!-- .one-fifth -->
						
						<div class="four-fifths last">
						
							<p style="position: relative;">
							
								<label><?php _e('File Title', 'btoa'); ?>:</label>
								<input type="text" class="_sf_submission_file small-input" onblur="jQuery(this)._sf_submission_file_update();" value="<?php echo $_file->title; ?>" />
								<small class="error tooltip right" style="top: 19px;">!</small>
								
							</p>
						
							<p style="position: relative; margin-bottom: 0;">
								
								<label><?php _e('Description', 'btoa'); ?>:</label>
								<input type="text" class="_sf_submission_description small-input" onblur="jQuery(this)._sf_submission_file_update();" value="<?php echo $_file->desc; ?>" />
								<small class="error tooltip left" style="top: 19px;">!</small>
							
							</p>
						
						</div>
						<!-- .two-fifths -->
						
						<div class="clear"></div>
						
					</div>
					
					<input type="hidden" name="_sf_submission_attachment_id" value="<?php echo $_file->ID; ?>" />
					
				</li>
			
			<?php endif; endforeach; endif; ?>
			
			
			
			
			
			
			
			
			
			<li class="_sf_box _sf_box_clone">
                                                        
				<div class="head">
				
					<div class="left"></div>
					
					<div class="right close" onclick="jQuery(this)._sf_submission_file_remove(event);"><i class="icon-cancel"></i></div>
					
					<div class="clear"></div>
					
				</div>
				
				<div class="inside" style="display: block;">
				
					<div class="one-fifth _sf_submission_file_description">
					
						<i class="icon-doc"></i>
						<span class="filetype"></span>
						<span class="filesize"></span>
					
					</div>
					<!-- .one-fifth -->
					
					<div class="four-fifths last">
					
						<p style="position: relative;">
						
							<label><?php _e('File Title', 'btoa'); ?>:</label>
							<input type="text" class="_sf_submission_file small-input" onblur="jQuery(this)._sf_submission_file_update();" value="" />
							<small class="error tooltip right" style="top: 19px;">!</small>
							
						</p>
					
						<p style="position: relative; margin-bottom: 0;">
							
							<label><?php _e('Description', 'btoa'); ?>:</label>
							<input type="text" class="_sf_submission_description small-input" onblur="jQuery(this)._sf_submission_file_update();" value="" />
							<small class="error tooltip left" style="top: 19px;">!</small>
						
						</p>
					
					</div>
					<!-- .two-fifths -->
					
					<div class="clear"></div>
					
				</div>
				
				<input type="hidden" name="_sf_submission_attachment_id" value="" />
				
			</li>
			
			
		
		</ul>
		
		<small class="error tooltip bottom" style="display: none; margin: 0;">Please upload a file.</small>
	
	</div>
	<!-- .inside -->
	
	<script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			<?php $file_count = get_post_meta($field->ID, 'file_count', true);
			if(!$file_count || !is_numeric($file_count) || $file_count == '' || $file_count == 0) { $file_count = 1; } ?>
			
			jQuery('#_sf_upload_file_submission_<?php echo $field->ID ?>')._sf_upload_file_submission(<?php echo $spot_id; ?>, <?php echo $field->ID ?>, <?php echo $file_count; ?>);
			
		});
	
	</script>

</div>
<!-- .sf_box -->