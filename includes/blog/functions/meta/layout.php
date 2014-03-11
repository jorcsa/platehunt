<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// ULTRASHARP THEME — INCLUDES/BLOG/FUNCTIONS/META/LAYOUT.PHP
//
//// METABOX MARKUP OUR PAGE LAYOUT
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

	//// OUR VARIABLE
	$blog_date = get_post_meta($post->ID, 'blog_date', true);
	$blog_author = get_post_meta($post->ID, 'blog_author', true);
	$blog_categories = get_post_meta($post->ID, 'blog_categories', true);
	$blog_comments = get_post_meta($post->ID, 'blog_comments', true);
	$blog_thumb = get_post_meta($post->ID, 'blog_thumb', true);
	$blog_thumb_side = get_post_meta($post->ID, 'blog_thumb_side', true);
	$blog_thumb_height = get_post_meta($post->ID, 'blog_thumb_height', true);
	$blog_tags = get_post_meta($post->ID, 'blog_tags', true);
	$blog_button = get_post_meta($post->ID, 'blog_button', true);
	$blog_button_text = get_post_meta($post->ID, 'blog_button_text', true);
	$blog_font = get_post_meta($post->ID, 'blog_font', true);
	
	//// DEFAULT BACKGROUND COLOR
	if($blog_button_text == '') { $blog_button_text = 'Read more'; }
	if($blog_thumb_height == '') { $blog_thumb_height = '300'; }

?>

<script type="text/javascript" charset="utf-8">

	jQuery(document).ready(function() {
		
		jQuery('#blog_date').iphoneStyle();
		jQuery('#blog_author').iphoneStyle();
		jQuery('#blog_categories').iphoneStyle();
		jQuery('#blog_button').iphoneStyle();
		jQuery('#blog_thumb').iphoneStyle();
		jQuery('#blog_comments').iphoneStyle();
		jQuery('#blog_tags').iphoneStyle();
		jQuery('#blog_font').iphoneStyle();
		
	});

</script>

<div style="padding: 5px;">

    <div style="float: left; width: 48%;">
    
        <p class="iphone-metabox">

            <label for="blog_date">Post Date</label>
            <input type="checkbox" name="blog_date" id="blog_date"<?php if($blog_date == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_author">Post Author</label>
            <input type="checkbox" name="blog_author" id="blog_author"<?php if($blog_author == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_categories">Post Categories</label>
            <input type="checkbox" name="blog_categories" id="blog_categories"<?php if($blog_categories == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_button">Read More Button</label>
            <input type="checkbox" name="blog_button" id="blog_button"<?php if($blog_button == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_button">Read More Button Text</label>
            <input type="text" name="blog_button_text" value="<?php echo $blog_button_text; ?>" style="position: absolute; right: 10px; top: 5px; width: 150px; text-align: right;" />
        
        </p>
    
    </div>
    
    <div style="float: right; width: 48%; border-left: 1px solid #dfdfdf; padding-left: 2%;"">
    
        <p class="iphone-metabox">

            <label for="blog_tags">Tags</label>
            <input type="checkbox" name="blog_tags" id="blog_tags"<?php if($blog_tags == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_comments">Comments</label>
            <input type="checkbox" name="blog_comments" id="blog_comments"<?php if($blog_comments == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_font">Increase Font size for Readability</label>
            <input type="checkbox" name="blog_font" id="blog_font"<?php if($blog_font == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_thumb">Featured Image</label>
            <input type="checkbox" name="blog_thumb" id="blog_thumb"<?php if($blog_thumb == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox" id="featured-image-side">

            <label for="blog_thumb_side">Featured Image Side</label>
            <select name="blog_thumb_side" id="blog_thumb_side" style="position: absolute; right: 10px; top: 3px; width: 100px; text-align: right;" />
            
            	<option value="left"<?php if($blog_thumb_side == 'left') { echo ' selected="selected"'; } ?>>Left</option>
            	<option value="right"<?php if($blog_thumb_side == 'right') { echo ' selected="selected"'; } ?>>Right</option>
            
            </select>
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="blog_thumb_height">Featured Image Height</label>
            <input type="text" name="blog_thumb_height" value="<?php echo $blog_thumb_height; ?>" style="position: absolute; right: 10px; top: 5px; width: 100px; text-align: right;" />
        
        </p>
    
    </div>
    
</div>

<div style="clear: both;"></div>