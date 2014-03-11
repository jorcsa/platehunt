<?php

	//// OUR VARIABLE
	$background_color = get_post_meta($post->ID, 'background_color', true);
	$top_border_color = get_post_meta($post->ID, 'top_border_color', true);
	$top_border_size = get_post_meta($post->ID, 'top_border_size', true);
	$bottom_border_color = get_post_meta($post->ID, 'bottom_border_color', true);
	$bottom_border_size = get_post_meta($post->ID, 'bottom_border_size', true);
	
	//// DEFAULT BACKGROUND COLOR
	if($background_color == '') { $background_color = 'ffffff'; }
	if($top_border_color == '') { $top_border_color = 'ffffff'; }
	if($bottom_border_color == '') { $bottom_border_color = 'ffffff'; }

?>

<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/colorPicker.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/bpanel/css/colorpicker.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->
<script src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/colorpicker.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/ddcolorpicker.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">

	jQuery(document).ready(function() {
		
		jQuery('#background_color').ddColorPicker();
		jQuery('#bottom_border_color').ddColorPicker();
		jQuery('#top_border_color').ddColorPicker();
		
		jQuery('#post_shadow').ddSelectReplace();
		
	});

</script>

<style type="text/css">

	#btoa_background_home_posts_meta { z-index: 2000; }

</style>





<p class="colorpicker-metabox">

	<label for="background_color" style="float: right;"><?php _e('Background Color', 'btoa'); ?></label>
    <input type="text" name="background_color" id="background_color" value="<?php echo $background_color; ?>" maxlength="6" />
    <span class="colorpicker-metabox-wrapper" style="float: left; z-index: 2000;"><span style="background-color: #<?php echo $background_color; ?>;"></span></span>

</p>

<div class="clear"></div>
<!-- /.clear/ -->
<div class="bDivider" style="margin: 15px 0 00;"></div>


<p class="colorpicker-metabox">

	<label for="border-top" style="float: right;"><?php _e('Top Border', 'btoa'); ?></label>
    <input type="text" name="top_border_color" id="top_border_color" value="<?php echo $top_border_color; ?>" maxlength="6" />
    <span class="colorpicker-metabox-wrapper" style="float: left; z-index: 2000;"><span style="background-color: #<?php echo $top_border_color; ?>;"></span></span>
    <div class="clear"><br /></div>
    <input type="text" style="width: 40px; display: block; float: left;" class="widefat" name="top_border_size" value="<?php echo $top_border_size ?>" /> <span style="display: inline-block; margin-top: 4px; margin-left: 5px;">px</span>

</p>

<div class="clear"></div>
<!-- /.clear/ -->
<div class="bDivider" style="margin: 15px 0 00;"></div>


<p class="colorpicker-metabox">

	<label for="border-top" style="float: right;"><?php _e('Bottom Border', 'btoa'); ?></label>
    <input type="text" name="bottom_border_color" id="bottom_border_color" value="<?php echo $bottom_border_color; ?>" maxlength="6" />
    <span class="colorpicker-metabox-wrapper" style="float: left; z-index: 2000;"><span style="background-color: #<?php echo $bottom_border_color; ?>;"></span></span>
    <div class="clear"><br /></div>
    <input type="text" style="width: 40px; display: block; float: left;" class="widefat" name="bottom_border_size" value="<?php echo $bottom_border_size ?>" /> <span style="display: inline-block; margin-top: 4px; margin-left: 5px;">px</span>

</p>

<div class="clear"></div>