<?php

	//// OUR VARIABLE
	$rating = get_post_meta($post->ID, 'rating', true);
	$user = get_post_meta($post->ID, 'user', true);
	$user_email = get_post_meta($post->ID, 'user_email', true);
	$parent = get_post_meta($post->ID, 'parent', true);
	$moderate = get_post_meta($post->ID, 'moderate', true);
	
?>
<!-- /CSS FILE/ -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/field.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/backend/css/iPhoneCheckbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/icons.css" media="screen" />

<!-- /JAVASCRIPT FILE/ -->

<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/jquery.iphone.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo get_template_directory_uri(); ?>/includes/backend/js/select.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/js/ajaxupload.js"></script>

<div class="bpanel-tabbed-meta">

	<ul class="tabs">
    
    	<li class="bpanel-tab current" style="padding-left: 5px;"><i class="icon-star"></i> <?php _e('Ratings', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-user"></i> <?php _e('User Info', 'btoa'); ?></li>
    
    	<li class="bpanel-tab" style="padding-left: 5px;"><i class="icon-cog"></i> <?php _e('Moderation', 'btoa'); ?></li>
    
    </ul>
    <!-- /.tabs/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->
    
    <script type="text/javascript">
	
		jQuery(document).ready(function() {
			
			jQuery('#moderate').iphoneStyle();
			
			jQuery('.bpanel-tabbed-meta .tabs li').click(function() {
				
				if(jQuery(this).attr('class').indexOf('current') == -1) {
					
					var clickedIndex = jQuery(this).index();
					jQuery(this).addClass('current').siblings('.current').removeClass('current');
					
					jQuery(this).parent().siblings('.tabbed').children('li.current').removeClass('current');
					jQuery(this).parent().siblings('.tabbed').children('li:eq('+clickedIndex+')').addClass('current');
					
				}
				
			});
		
		});
	
	</script>
    
    <ul class="tabbed tabbed-fields">
        
        <li class="current">
            
            <div class="one-fifth"><label for="parent"><?php _e('Review of:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="parent" id="parent" value="<?php echo get_the_title($parent); ?>" class="widefat" style="margin-bottom: 5px; background: #f0f0f0;" maxlength="256" disabled /></div>
            <div class="two-fifths description last"><?php _e('Parent listings of this review', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="rating"><?php _e('Overall Rating:', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="rating" id="rating" value="<?php echo $rating ?>" class="widefat" style="margin-bottom: 5px;" maxlength="256" disabled />
			<?php echo sf_get_rating_html(get_post_meta($post->ID, 'rating', true)); ?></div>
            <div class="two-fifths description last"><?php _e('Overall Rating of this review', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
		
			<?php
			
				///// LETS GET ALL THE TAXONOMIES AND DISPLAY THEM HERE
				
				$rating_fields = get_terms('rating_field', array('hide_empty' => false));
				
				$i = 1; foreach($rating_fields as $field) { ?>
            
					<div class="one-fifth"><label for="sf_rating_field_<?php echo $field->term_id; ?>"><?php echo $field->name; ?>:</label></div>
					<div class="two-fifths"><input type="number" name="sf_rating_field_<?php echo $field->term_id; ?>" id="sf_rating_field_<?php echo $field->term_id; ?>" value="<?php echo get_post_meta($post->ID, 'sf_rating_field_'.$field->term_id, true); ?>" class="widefat" style="margin-bottom: 5px;" maxlength="1" /><br>
<?php echo sf_get_rating_html(get_post_meta($post->ID, 'sf_rating_field_'.$field->term_id, true)); ?></div>
					<div class="two-fifths description last"><?php echo $field->description; ?></div>
					
					<div class="clear"></div>
					
					<?php if($i < sizeof($rating_fields)) { echo '<div class="bDivider"></div>'; } ?>
					
				<?php $i++; }
			
			?>
        
        </li>
		
		
		
		
		<li>
            
            <div class="one-fifth"><label for="user"><?php _e('Username', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="user" id="user" value="<?php echo $user ?>" class="widefat" style="margin-bottom: 5px;" maxlength="256" /></div>
            <div class="two-fifths description last"><?php _e('Name of the person that submitted the review', 'btoa'); ?></div>
            
            <div class="clear"></div>
            <div class="bDivider"></div>
            
            <div class="one-fifth"><label for="user_email"><?php _e('Username Email', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="text" name="user_email" id="user_email" value="<?php echo $user_email ?>" class="widefat" style="margin-bottom: 5px;" maxlength="256" /></div>
            <div class="two-fifths description last"><?php _e('Email of the person that submitted the review', 'btoa'); ?></div>
            
            <div class="clear"></div>
		
		</li>
		
		
		
		
		<li>
            
            <div class="one-fifth"><label for="moderate"><?php _e('Under Moderation', 'btoa'); ?></label></div>
            <div class="two-fifths"><input type="checkbox" name="moderate" id="moderate"<?php if($moderate == 'on') { echo ' checked="checked"'; } ?> />&nbsp;</div>
            <div class="two-fifths description last"><?php _e('If checked someone has reported this review.', 'btoa'); ?></div>
            
            <div class="clear"></div>
		
		</li>
		
		
		
		
    
    </ul>
    <!-- /.tabbed/ -->
    
    <div style="clear: both;"></div>
    <!-- /.clear/ -->

</div>