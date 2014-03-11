<?php

	//// OUR VARIABLE
	$sidebar_position = get_post_meta($post->ID, 'sidebar_position', true);
	
	//// DEFAULT BACKGROUND COLOR
	if($sidebar_position == '') { $sidebar_position = 'default'; }

?>

<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">

	jQuery(document).ready(function() {
		
		jQuery('#sidebar_position').ddSelectReplace();
		
	});

</script>

<p class="select-metabox">

	<!-- <label for="post_shadow">Post Shadow</label> -->
	<label for="sidebar_position" class="select-label">Sidebar Position</label>
    <select name="sidebar_position" id="sidebar_position">
    
    	<option value="default"<?php if($sidebar_position == 'default') { echo ' selected="selected"'; } ?>><?php _e('Default ('.ddp('sidebar_default').')', 'ultrasharp'); ?></option>
    	<option value="Right Side"<?php if($sidebar_position == 'Right Side') { echo ' selected="selected"'; } ?>><?php _e('Right Side', 'ultrasharp'); ?></option>
    	<option value="Left Side"<?php if($sidebar_position == 'Left Side') { echo ' selected="selected"'; } ?>><?php _e('Left Side', 'ultrasharp'); ?></option>
    	<option value="No Sidebar (Full Width)"<?php if($sidebar_position == 'No Sidebar (Full Width)') { echo ' selected="selected"'; } ?>><?php _e('No Sidebar (Full Width)', 'ultrasharp'); ?></option>
    
    </select>

</p>