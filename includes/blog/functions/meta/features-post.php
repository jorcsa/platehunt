<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// ULTRASHARP THEME — INCLUDES/BLOG/FUNCTIONS/META/FEATURES-POST.PHP
//
//// POST FEATURES
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

	//// OUR VARIABLE
	$feature_related_posts = get_post_meta($post->ID, 'feature_related_posts', true);
	$feature_latest_posts = get_post_meta($post->ID, 'feature_latest_posts', true);
	$feature_popular_posts = get_post_meta($post->ID, 'feature_popular_posts', true);
	$feature_about_author = get_post_meta($post->ID, 'feature_about_author', true);
	$feature_social_media = get_post_meta($post->ID, 'feature_social_media', true);
	$feature_post_info = get_post_meta($post->ID, 'feature_post_info', true);

?>

<script type="text/javascript" charset="utf-8">

	jQuery(document).ready(function() {
		
		jQuery('#feature_related_posts').iphoneStyle();
		jQuery('#feature_latest_posts').iphoneStyle();
		jQuery('#feature_popular_posts').iphoneStyle();
		jQuery('#feature_about_author').iphoneStyle();
		jQuery('#feature_social_media').iphoneStyle();
		jQuery('#feature_post_info').iphoneStyle();
		
	});

</script>

<div style="padding: 5px;">

    <div style="float: left; width: 48%;">
    
        <p class="iphone-metabox">

            <label for="feature_about_author">Disable About the Author</label>
            <input type="checkbox" name="feature_about_author" id="feature_about_author"<?php if($feature_about_author == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="feature_post_info">Disable Post Info</label>
            <input type="checkbox" name="feature_post_info" id="feature_post_info"<?php if($feature_post_info == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="feature_social_media">Disable Share/Like Page (Social Media)</label>
            <input type="checkbox" name="feature_social_media" id="feature_social_media"<?php if($feature_social_media == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>
    
    </div>
    
    <div style="float: right; width: 48%; border-left: 1px solid #dfdfdf; padding-left: 2%;"">
    
        <p class="iphone-metabox">

            <label for="feature_related_posts">Disable Related Posts</label>
            <input type="checkbox" name="feature_related_posts" id="feature_related_posts"<?php if($feature_related_posts == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="feature_latest_posts">Disable Latest Posts</label>
            <input type="checkbox" name="feature_latest_posts" id="feature_latest_posts"<?php if($feature_latest_posts == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>

		<div class="metaboxDivider" style="margin-left: -5px;"></div>
    
        <p class="iphone-metabox">

            <label for="feature_popular_posts">Disable Popular Posts</label>
            <input type="checkbox" name="feature_popular_posts" id="feature_popular_posts"<?php if($feature_popular_posts == 'on') { echo ' checked="checked"'; } ?> />
        
        </p>
    
    </div>
    
</div>

<div style="clear: both;"></div>